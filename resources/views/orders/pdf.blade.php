<!DOCTYPE html>
<html>
<head>
    <title>Orders Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-pending { background-color: #ffc107; color: #000; }
        .badge-completed { background-color: #28a745; color: #fff; }
        .badge-cancelled { background-color: #dc3545; color: #fff; }
    </style>
</head>
<body>
    <h1>Orders Report</h1>
    <p><strong>Generated:</strong> {{ date('F d, Y H:i:s') }}</p>
    <p><strong>Total Orders:</strong> {{ $orders->count() }}</p>
    <p><strong>Total Revenue:</strong> ${{ number_format($orders->where('status', 'completed')->sum('amount'), 2) }}</p>

    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->customer->name }}</td>
                <td>${{ number_format($order->amount, 2) }}</td>
                <td>
                    <span class="badge badge-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>{{ $order->order_date->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th>${{ number_format($orders->sum('amount'), 2) }}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>ImpactGuru CRM - Customer Management System</p>
    </div>
</body>
</html>