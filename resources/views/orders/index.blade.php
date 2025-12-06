<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">
                <i class="bi bi-cart"></i> Orders
            </h2>
            <div>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('orders.export.csv') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
                </a>
                <a href="{{ route('orders.export.pdf') }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
                @endif
                <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Create Order
                </a>
            </div>
        </div>
    </x-slot>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <!-- Filter Form -->
            <form action="{{ route('orders.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-10">
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                </div>
            </form>

            <!-- Orders Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->order_number }}</strong>
                            </td>
                            <td>
                                @if($order->customer)
                                    <a href="{{ route('customers.show', $order->customer) }}" class="text-decoration-none">
                                        {{ $order->customer->name }}
                                    </a>
                                @else
                                    <span class="text-muted">(Customer removed)</span>
                                @endif
                            </td>
                            <td>${{ number_format($order->amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status_badge }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->order_date->format('M d, Y') }}</td>
                            <td>{{ $order->created_at->diffForHumans() }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('orders.show', $order) }}" 
                                       class="btn btn-info" 
                                       title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('orders.edit', $order) }}" 
                                       class="btn btn-warning" 
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                    <button type="button" 
                                            class="btn btn-danger" 
                                            title="Delete"
                                            onclick="confirmDelete({{ $order->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $order->id }}" 
                                          action="{{ route('orders.destroy', $order) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1"></i>
                                <p class="mb-0">No orders found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    @if(auth()->user()->isAdmin())
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this order?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
    @endif
</x-app-layout>