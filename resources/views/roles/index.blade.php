@extends('layouts.app')

@section('title', 'Manage Roles')

@section('content')
    <div class="container mt-4">
        <!-- Card -->
        @if(session('success'))
        <script>
            Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
        </script>
        @endif
        <div class="card overflow-hidden">
            <div class="card-header">
                <h5 class="card-title mb-3">Manage Roles</h5>
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Add Role Button -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <i class="bx bx-plus me-1"></i> Add Role
                    </button>
            
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('roles.index') }}" class="d-flex align-items-center">
                        <div class="input-group" style="max-width: 300px;">
                            <input type="text" class="form-control" name="search" placeholder="Search roles" value="{{ request('search') }}">
                            <button class="btn btn-primary text-white" type="submit">
                                <i class="bx bx-search"></i> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>            
            
            <div class="card-body">

                <!-- Table -->
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead style="background-color: #56a1f7; color: white;">
                            <tr>
                                <th style="color: white;">#</th>
                                <th style="width: 70%; color: white;">Role</th>
                                <th style="color: white;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $index => $role)
                                <tr>
                                    <td>{{ $index + $roles->firstItem() }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Edit Button -->
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editRoleModal{{ $role->id }}">
                                                <i class="bx bx-edit-alt"></i> Edit
                                            </button>
                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('roles.destroy', $role->id) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this role?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bx bx-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Include the Edit Role Modal -->
                                @include('roles.partials.edit-modal', ['role' => $role])
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination and Data Information -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="d-flex">
                        <p class="mb-0">Showing {{ $roles->firstItem() }} to {{ $roles->lastItem() }} of
                            {{ $roles->total() }} entries</p>
                    </div>
                    <div>
                        {{ $roles->links('pagination::bootstrap-5') }}
                    </div>
                    <div>
                        <!-- Form untuk dropdown entries -->
                        <form method="GET" action="{{ route('roles.index') }}" id="entries-form">
                            <!-- Dropdown untuk memilih jumlah entries -->
                            <select name="entries" class="form-select form-select-sm w-auto" onchange="document.getElementById('entries-form').submit();">
                                <option value="5" {{ request('entries') == 5 ? 'selected' : '' }}>5 entries</option>
                                <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10 entries</option>
                                <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25 entries</option>
                                <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50 entries</option>
                                <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100 entries</option>
                            </select>
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Include the Add Role Modal -->
        @include('roles.partials.add-modal')
    </div>
@endsection
