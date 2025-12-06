<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('orders.create', compact('customers'));
    }

    public function store(OrderRequest $request)
    {
        $data = $request->validated();
        $data['order_number'] = Order::generateOrderNumber();

        $order = Order::create($data);

        // Send notification
        try {
            $adminUsers = \App\Models\User::where('role', 'admin')->get();
            Notification::send($adminUsers, new NewOrderNotification($order));
        } catch (\Exception $e) {
            \Log::error('Failed to send order notification: ' . $e->getMessage());
        }

        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load('customer');
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $customers = Customer::all();
        return view('orders.edit', compact('order', 'customers'));
    }

    public function update(OrderRequest $request, Order $order)
    {
        $data = $request->validated();
        $order->update($data);

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        // Only admin can delete
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    public function exportCsv()
    {
        $orders = Order::with('customer')->get();
        
        $fileName = 'orders_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Order Number', 'Customer', 'Amount', 'Status', 'Order Date', 'Created At'];

        $callback = function() use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->customer->name,
                    $order->amount,
                    ucfirst($order->status),
                    $order->order_date->format('Y-m-d'),
                    $order->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $orders = Order::with('customer')->get();
        
        $pdf = Pdf::loadView('orders.pdf', compact('orders'));
        
        return $pdf->download('orders_' . date('Y-m-d_His') . '.pdf');
    }
}