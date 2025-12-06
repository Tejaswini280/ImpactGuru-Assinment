<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">
                <i class="bi bi-receipt"></i> Order Details
            </h2>
            <div>
                <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Order Number</p>
                            <h5>{{ $order->order_number }}</h5>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Status</p>
                            <h5>
                                <span class="badge bg-{{ $order->status_badge }} fs-6">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </h5>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Amount</p>
                            <h4 class="text-primary">${{ number_format($order->amount, 2) }}</h4>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Order Date</p>
                            <h5>{{ $order->order_date->format('F d, Y') }}</h5>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Created At</p>
                            <p>{{ $order->created_at->format('F d, Y H:i:s') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Last Updated</p>
                            <p>{{ $order->updated_at->format('F d, Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="{{ $order->customer->profile_image_url }}" 
                             class="rounded-circle" 
                             width="80" height="80"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($order->customer->name) }}&size=80&background=random'">
                    </div>
                    <h5 class="text-center mb-3">{{ $order->customer->name }}</h5>
                    
                    <p class="mb-2">
                        <i class="bi bi-envelope text-primary"></i>
                        <a href="mailto:{{ $order->customer->email }}">{{ $order->customer->email }}</a>
                    </p>
                    <p class="mb-2">
                        <i class="bi bi-telephone text-primary"></i>
                        <a href="tel:{{ $order->customer->phone }}">{{ $order->customer->phone }}</a>
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-geo-alt text-primary"></i>
                        {{ $order->customer->address ?? 'No address' }}
                    </p>

                    <hr>

                    <a href="{{ route('customers.show', $order->customer) }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-person"></i> View Customer Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>