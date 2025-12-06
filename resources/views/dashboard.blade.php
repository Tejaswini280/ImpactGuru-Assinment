<x-app-layout>
    <!-- Dashboard header removed as requested -->

    

    <div class="row g-4">
        <!-- Total Customers Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Customers</p>
                            <h3 class="mb-0">{{ $totalCustomers }}</h3>
                        </div>
                        <div class="fs-3 text-primary">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Orders</p>
                            <h3 class="mb-0">{{ $totalOrders }}</h3>
                        </div>
                        <div class="fs-3 text-success">
                            <i class="bi bi-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Revenue</p>
                            <h3 class="mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                        </div>
                        <div class="fs-3 text-warning">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Pending Orders</p>
                            <h3 class="mb-0">{{ $pendingOrders }}</h3>
                        </div>
                        <div class="fs-3 text-info">
                            <i class="bi bi-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end dashboard page wrapper will be closed after recent customers -->

    <!-- Order Status Cards -->
    @if(auth()->user()->isAdmin())
    <div class="row g-4 mt-2">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-hourglass-split fs-1 text-warning"></i>
                    <h4 class="mt-3">{{ $pendingOrders }}</h4>
                    <p class="text-muted mb-0">Pending Orders</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle fs-1 text-success"></i>
                    <h4 class="mt-3">{{ $completedOrders }}</h4>
                    <p class="text-muted mb-0">Completed Orders</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-x-circle fs-1 text-danger"></i>
                    <h4 class="mt-3">{{ $cancelledOrders }}</h4>
                    <p class="text-muted mb-0">Cancelled Orders</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Customers -->
    <div class="row mt-4">
        <div class="col-12">
                <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history"></i> Recent Customers
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Registered</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCustomers as $customer)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $customer->profile_image_url }}" 
                                                 class="rounded-circle me-2" 
                                                 width="32" height="32"
                                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=random'">
                                            {{ $customer->name }}
                                        </div>
                                    </td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('customers.show', $customer) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No customers yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>