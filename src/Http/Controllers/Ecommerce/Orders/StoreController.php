<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Orders;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'user_id' => 'nullable|exists:users,id',

            // Shipping address
            'shipping_street' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'nullable|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:20',
            'shipping_country' => 'required|string|max:100',

            // Billing address
            'billing_same_as_shipping' => 'nullable|boolean',
            'billing_street' => 'required_if:billing_same_as_shipping,false|nullable|string|max:255',
            'billing_city' => 'required_if:billing_same_as_shipping,false|nullable|string|max:100',
            'billing_state' => 'nullable|string|max:100',
            'billing_postal_code' => 'nullable|string|max:20',
            'billing_country' => 'required_if:billing_same_as_shipping,false|nullable|string|max:100',

            // Order items
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.sku' => 'nullable|string|max:100',

            // Pricing
            'subtotal' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',

            // Payment
            'payment_method' => 'nullable|string|max:100',
            'payment_status' => 'required|in:pending,paid,failed,refunded,cancelled',
            'payment_id' => 'nullable|string|max:255',

            // Order info
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // Prepare shipping address
        $shippingAddress = [
            'street' => $data['shipping_street'],
            'city' => $data['shipping_city'],
            'state' => $data['shipping_state'] ?? '',
            'postal_code' => $data['shipping_postal_code'] ?? '',
            'country' => $data['shipping_country']
        ];

        // Prepare billing address
        $billingAddress = null;
        if ($data['billing_same_as_shipping'] ?? false) {
            $billingAddress = $shippingAddress;
        } else {
            $billingAddress = [
                'street' => $data['billing_street'] ?? '',
                'city' => $data['billing_city'] ?? '',
                'state' => $data['billing_state'] ?? '',
                'postal_code' => $data['billing_postal_code'] ?? '',
                'country' => $data['billing_country'] ?? ''
            ];
        }

        // Create order
        $order = Order::create([
            'user_id' => $data['user_id'],
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'shipping_address' => $shippingAddress,
            'billing_address' => $billingAddress,
            'status' => $data['status'],
            'subtotal' => $data['subtotal'],
            'tax_amount' => $data['tax_amount'] ?? 0,
            'shipping_cost' => $data['shipping_cost'] ?? 0,
            'discount_amount' => $data['discount_amount'] ?? 0,
            'total_amount' => $data['total_amount'],
            'currency' => 'KRW',
            'payment_method' => $data['payment_method'],
            'payment_status' => $data['payment_status'],
            'payment_id' => $data['payment_id'],
            'notes' => $data['notes'],
            'order_items' => $data['items'],
        ]);

        return redirect()->route('admin.cms.ecommerce.orders.show', $order->id)
            ->with('success', '주문이 성공적으로 생성되었습니다.');
    }
}