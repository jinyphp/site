<?php

namespace Jiny\Site\Http\Controllers\Ecommerce\Orders;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        // Handle AJAX requests for filtering and searching
        if ($request->ajax()) {
            return $this->handleAjax($request);
        }

        // Get filter parameters
        $status = $request->get('status');
        $paymentStatus = $request->get('payment_status');
        $search = $request->get('search');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Build query
        $query = Order::with('user')->orderBy('created_at', 'desc');

        // Apply filters
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($paymentStatus && $paymentStatus !== 'all') {
            $query->where('payment_status', $paymentStatus);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Paginate results
        $orders = $query->paginate(15)->withQueryString();

        // Get statistics for dashboard
        $stats = $this->getOrderStats();

        return view('jiny-site::ecommerce.orders.index', compact('orders', 'stats'));
    }

    private function handleAjax(Request $request)
    {
        if ($request->get('action') === 'update_status') {
            return $this->updateOrderStatus($request);
        }

        if ($request->get('action') === 'bulk_action') {
            return $this->bulkAction($request);
        }

        return response()->json(['error' => 'Invalid action'], 400);
    }

    private function updateOrderStatus(Request $request)
    {
        $order = Order::findOrFail($request->get('order_id'));
        $newStatus = $request->get('new_status');

        $order->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'order' => $order
        ]);
    }

    private function bulkAction(Request $request)
    {
        $action = $request->get('bulk_action');
        $orderIds = $request->get('order_ids', []);

        if (empty($orderIds)) {
            return response()->json(['error' => 'No orders selected'], 400);
        }

        switch ($action) {
            case 'mark_processing':
                Order::whereIn('id', $orderIds)->update(['status' => 'processing']);
                break;
            case 'mark_shipped':
                Order::whereIn('id', $orderIds)->update(['status' => 'shipped', 'shipped_at' => now()]);
                break;
            case 'mark_delivered':
                Order::whereIn('id', $orderIds)->update(['status' => 'delivered', 'delivered_at' => now()]);
                break;
            case 'delete':
                Order::whereIn('id', $orderIds)->delete();
                break;
            default:
                return response()->json(['error' => 'Invalid bulk action'], 400);
        }

        return response()->json([
            'success' => true,
            'message' => "Bulk action '{$action}' completed successfully"
        ]);
    }

    private function getOrderStats()
    {
        return [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'pending_revenue' => Order::where('payment_status', 'pending')->sum('total_amount'),
        ];
    }
}
