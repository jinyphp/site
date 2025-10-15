<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Orders;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class ShowController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $order = Order::with('user')->findOrFail($id);

        // Handle AJAX requests for status updates
        if ($request->ajax()) {
            if ($request->has('action') && $request->get('action') === 'update_status') {
                return $this->updateStatus($request, $order);
            }
        }

        return view('jiny-site::ecommerce.orders.show', compact('order'));
    }

    private function updateStatus(Request $request, Order $order)
    {
        $newStatus = $request->get('status');
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];

        if (!in_array($newStatus, $validStatuses)) {
            return response()->json(['error' => 'Invalid status'], 400);
        }

        $oldStatus = $order->status;
        $order->status = $newStatus;

        // Update timestamps based on status change
        if ($newStatus === 'shipped' && $oldStatus !== 'shipped') {
            $order->shipped_at = now();
        }

        if ($newStatus === 'delivered' && $oldStatus !== 'delivered') {
            $order->delivered_at = now();
        }

        $order->save();

        return response()->json([
            'success' => true,
            'message' => "주문 상태가 '{$newStatus}'로 변경되었습니다.",
            'order' => $order->fresh(),
            'status_badge' => $order->status_badge
        ]);
    }
}