<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">
                <i class="bi bi-person"></i> Customer Details
            </h2>
            <div>
                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <!-- Customer Information -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <img src="{{ $customer->profile_image_url }}" 
                         class="rounded-circle mb-3" 
                         width="120" height="120"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&size=120&background=random'">
                    <h4 class="mb-1">{{ $customer->name }}</h4>
                    <p class="text-muted mb-3">Customer ID: #{{ $customer->id }}</p>
                    
                    <div class="text-start">
                        <h6 class="text-muted mb-3">Contact Information</h6>
                        <p class="mb-2">
                            <i class="bi bi-envelope text-primary"></i>
                            <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-telephone text-primary"></i>
                            <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-geo-alt text-primary"></i>
                            {{ $customer->address ?? 'No address provided' }}
                        </p>
                        <hr>
                        <p class="mb-1">
                            <i class="bi bi-calendar text-primary"></i>
                            <small>Registered: {{ $customer->created_at->format('M d, Y') }}</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Orders -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-cart"></i> Orders ({{ $customer->orders->count() }})
                    </h5>
                    <a href="{{ route('orders.create') }}?customer_id={{ $customer->id }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> New Order
                    </a>
                </div>
                <div class="card-body">
                    @if($customer->orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Order #</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->orders as $order)
                                <tr>
                                    <td>
                                        <strong>{{ $order->order_number }}</strong>
                                    </td>
                                    <td>${{ number_format($order->amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_badge }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->order_date->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Total Revenue:</strong></td>
                                    <td><strong>${{ number_format($customer->orders->sum('amount'), 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1"></i>
                        <p class="mb-0">No orders yet</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>