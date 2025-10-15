<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Orders;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class StepController extends Controller
{
    public function __invoke(Request $request, $step = 1)
    {
        $step = (int) $step;

        // 유효한 스텝 범위 확인
        if ($step < 1 || $step > 4) {
            return redirect()->route('admin.cms.ecommerce.orders.step', 1);
        }

        // POST 요청 처리 (폼 제출)
        if ($request->isMethod('POST')) {
            return $this->handleStepSubmission($request, $step);
        }

        // GET 요청 처리 (스텝 표시)
        return $this->showStep($request, $step);
    }

    private function showStep(Request $request, int $step)
    {
        $stepData = Session::get('order_step_data', []);

        switch ($step) {
            case 1:
                $users = User::select('id', 'name', 'email')->orderBy('name')->get();
                return view('jiny-site::ecommerce.orders.steps.customer', compact('step', 'stepData', 'users'));

            case 2:
                // 1단계 완료 확인
                if (!isset($stepData['customer'])) {
                    return redirect()->route('admin.cms.ecommerce.orders.step', 1)
                        ->with('error', '고객 정보를 먼저 입력해주세요.');
                }
                return view('jiny-site::ecommerce.orders.steps.products', compact('step', 'stepData'));

            case 3:
                // 1,2단계 완료 확인
                if (!isset($stepData['customer']) || !isset($stepData['products'])) {
                    $missingStep = !isset($stepData['customer']) ? 1 : 2;
                    return redirect()->route('admin.cms.ecommerce.orders.step', $missingStep)
                        ->with('error', '이전 단계를 먼저 완료해주세요.');
                }
                return view('jiny-site::ecommerce.orders.steps.shipping', compact('step', 'stepData'));

            case 4:
                // 1,2,3단계 완료 확인
                if (!isset($stepData['customer']) || !isset($stepData['products']) || !isset($stepData['shipping'])) {
                    $missingStep = !isset($stepData['customer']) ? 1 : (!isset($stepData['products']) ? 2 : 3);
                    return redirect()->route('admin.cms.ecommerce.orders.step', $missingStep)
                        ->with('error', '이전 단계를 먼저 완료해주세요.');
                }
                return view('jiny-site::ecommerce.orders.steps.payment', compact('step', 'stepData'));

            default:
                return redirect()->route('admin.cms.ecommerce.orders.step', 1);
        }
    }

    private function handleStepSubmission(Request $request, int $step)
    {
        switch ($step) {
            case 1:
                return $this->handleCustomerStep($request);
            case 2:
                return $this->handleProductsStep($request);
            case 3:
                return $this->handleShippingStep($request);
            case 4:
                return $this->handlePaymentStep($request);
            default:
                return redirect()->route('admin.cms.ecommerce.orders.step', 1);
        }
    }

    private function handleCustomerStep(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $stepData = Session::get('order_step_data', []);
        $stepData['customer'] = $validator->validated();
        Session::put('order_step_data', $stepData);

        return redirect()->route('admin.cms.ecommerce.orders.step', 2)
            ->with('success', '고객 정보가 저장되었습니다.');
    }

    private function handleProductsStep(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.sku' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $stepData = Session::get('order_step_data', []);
        $stepData['products'] = $validator->validated();

        // 소계 계산
        $subtotal = 0;
        foreach ($stepData['products']['items'] as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $stepData['products']['subtotal'] = $subtotal;

        Session::put('order_step_data', $stepData);

        return redirect()->route('admin.cms.ecommerce.orders.step', 3)
            ->with('success', '상품 정보가 저장되었습니다.');
    }

    private function handleShippingStep(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_street' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'nullable|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:20',
            'shipping_country' => 'required|string|max:100',

            'billing_same_as_shipping' => 'nullable|boolean',
            'billing_street' => 'required_if:billing_same_as_shipping,false|nullable|string|max:255',
            'billing_city' => 'required_if:billing_same_as_shipping,false|nullable|string|max:100',
            'billing_state' => 'nullable|string|max:100',
            'billing_postal_code' => 'nullable|string|max:20',
            'billing_country' => 'required_if:billing_same_as_shipping,false|nullable|string|max:100',

            'tax_amount' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $stepData = Session::get('order_step_data', []);
        $validated = $validator->validated();

        // 배송 주소 처리
        $shippingAddress = [
            'street' => $validated['shipping_street'],
            'city' => $validated['shipping_city'],
            'state' => $validated['shipping_state'] ?? '',
            'postal_code' => $validated['shipping_postal_code'] ?? '',
            'country' => $validated['shipping_country']
        ];

        // 청구 주소 처리
        $billingAddress = null;
        if ($validated['billing_same_as_shipping'] ?? false) {
            $billingAddress = $shippingAddress;
        } else {
            $billingAddress = [
                'street' => $validated['billing_street'] ?? '',
                'city' => $validated['billing_city'] ?? '',
                'state' => $validated['billing_state'] ?? '',
                'postal_code' => $validated['billing_postal_code'] ?? '',
                'country' => $validated['billing_country'] ?? ''
            ];
        }

        $stepData['shipping'] = [
            'shipping_address' => $shippingAddress,
            'billing_address' => $billingAddress,
            'tax_amount' => $validated['tax_amount'] ?? 0,
            'shipping_cost' => $validated['shipping_cost'] ?? 0,
            'discount_amount' => $validated['discount_amount'] ?? 0,
        ];

        // 총액 계산
        $subtotal = $stepData['products']['subtotal'];
        $totalAmount = $subtotal + $stepData['shipping']['tax_amount'] + $stepData['shipping']['shipping_cost'] - $stepData['shipping']['discount_amount'];
        $stepData['shipping']['total_amount'] = max(0, $totalAmount);

        Session::put('order_step_data', $stepData);

        return redirect()->route('admin.cms.ecommerce.orders.step', 4)
            ->with('success', '배송 정보가 저장되었습니다.');
    }

    private function handlePaymentStep(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
            'payment_method' => 'nullable|string|max:100',
            'payment_status' => 'required|in:pending,paid,failed,refunded,cancelled',
            'payment_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 모든 단계 데이터 가져오기
        $stepData = Session::get('order_step_data', []);
        $paymentData = $validator->validated();

        try {
            // 주문 생성
            $order = Order::create([
                'user_id' => $stepData['customer']['user_id'],
                'customer_name' => $stepData['customer']['customer_name'],
                'customer_email' => $stepData['customer']['customer_email'],
                'customer_phone' => $stepData['customer']['customer_phone'],
                'shipping_address' => $stepData['shipping']['shipping_address'],
                'billing_address' => $stepData['shipping']['billing_address'],
                'status' => $paymentData['status'],
                'subtotal' => $stepData['products']['subtotal'],
                'tax_amount' => $stepData['shipping']['tax_amount'],
                'shipping_cost' => $stepData['shipping']['shipping_cost'],
                'discount_amount' => $stepData['shipping']['discount_amount'],
                'total_amount' => $stepData['shipping']['total_amount'],
                'currency' => 'KRW',
                'payment_method' => $paymentData['payment_method'],
                'payment_status' => $paymentData['payment_status'],
                'payment_id' => $paymentData['payment_id'],
                'notes' => $paymentData['notes'],
                'order_items' => $stepData['products']['items'],
            ]);

            // 세션 정리
            Session::forget('order_step_data');

            return redirect()->route('admin.cms.ecommerce.orders.show', $order->id)
                ->with('success', '주문이 성공적으로 생성되었습니다.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '주문 생성 중 오류가 발생했습니다: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function reset()
    {
        Session::forget('order_step_data');
        return redirect()->route('admin.cms.ecommerce.orders.step', 1)
            ->with('success', '주문 생성이 초기화되었습니다.');
    }
}