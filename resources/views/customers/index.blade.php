<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">
                <i class="bi bi-people"></i> Customers
            </h2>
            <div>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('customers.export.csv') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
                </a>
                <a href="{{ route('customers.export.pdf') }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
                @endif
                <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Add Customer
                </a>
            </div>
        </div>
    </x-slot>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <!-- Search Form -->
            <form action="{{ route('customers.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Search by name or email..." 
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Search
                    </button>
                    @if(request('search'))
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x"></i> Clear
                    </a>
                    @endif
                </div>
            </form>

            <!-- Customers Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Orders</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>
                                <img src="{{ $customer->profile_image_url }}" 
                                     class="rounded-circle" 
                                     width="40" height="40"
                                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=random'">
                            </td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>
                                <span class="badge bg-info">{{ $customer->orders->count() }} orders</span>
                            </td>
                            <td>{{ $customer->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('customers.show', $customer) }}" 
                                       class="btn btn-info" 
                                       title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('customers.edit', $customer) }}" 
                                       class="btn btn-warning" 
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin())
                                    <button type="button" 
                                            class="btn btn-danger" 
                                            title="Delete"
                                            onclick="confirmDelete({{ $customer->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $customer->id }}" 
                                          action="{{ route('customers.destroy', $customer) }}" 
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
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1"></i>
                                <p class="mb-0">No customers found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $customers->links() }}
            </div>
        </div>
    </div>

    @if(auth()->user()->isAdmin())
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this customer? All related orders will also be deleted.')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
    @endif
</x-app-layout>