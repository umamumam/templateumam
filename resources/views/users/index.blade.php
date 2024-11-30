@extends('layouts.app')

@section('title', 'Manage Users')

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
            <h5 class="card-title mb-3">Manage Users</h5>
            <div class="d-flex justify-content-between align-items-center">
                <!-- Add User Button -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bx bx-plus me-1"></i> Add User
                </button>
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('users.index') }}" class="d-flex align-items-center">
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" class="form-control" name="search" placeholder="Search users" value="{{ request('search') }}">
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
                            <th style="width: 25%; color: white;">Name</th>
                            <th style="width: 25%; color: white;">Email</th>
                            <th style="width: 20%; color: white;">Role</th>
                            <th style="color: white;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ $index + $users->firstItem() }}</td>
                                <td>
                                    @php
                                        // Array berisi nama file avatar
                                        $avatars = ['avatar1.avif', 'avatar2.avif', 'avatar3.avif', 'avatar4.avif', 'avatar5.avif', 'avatar6.avif', 'avatar7.avif', 'avatar8.avif', 'avatar9.avif'];
                                        // Pilih avatar secara acak
                                        $randomAvatar = $avatars[array_rand($avatars)];
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-4">
                                            <!-- Menampilkan gambar avatar acak -->
                                            <img src="{{ asset('sneat/' . $randomAvatar) }}" alt="Avatar" class="rounded-circle" />
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-truncate">{{ $user->name }}</h6>
                                            <small class="text-truncate">{{ $user->username ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-label-{{ $roleColors[$user->role->name] }} rounded-pill">
                                            {{ $user->role->name }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Edit Button -->
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editUserModal{{ $user->id }}">
                                            <i class="bx bx-edit-alt"></i> Edit
                                        </button>
                                        <!-- Delete Button -->
                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bx bx-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Include the Edit User Modal -->
                            @include('users.partials.edit-modal', ['user' => $user])
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination and Data Information -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="d-flex">
                    <p class="mb-0">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of
                        {{ $users->total() }} entries</p>
                </div>
                <div>
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
                <div>
                    <!-- Form untuk dropdown entries -->
                    <form method="GET" action="{{ route('users.index') }}" id="entries-form">
                        <div class="d-flex">
                            <select name="entries" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                <option value="5" {{ request('entries')==5 ? 'selected' : '' }}>5 entries</option>
                                <option value="10" {{ request('entries')==10 ? 'selected' : '' }}>10 entries</option>
                                <option value="25" {{ request('entries')==25 ? 'selected' : '' }}>25 entries</option>
                                <option value="50" {{ request('entries')==50 ? 'selected' : '' }}>50 entries</option>
                                <option value="100" {{ request('entries')==100 ? 'selected' : '' }}>100 entries</option>
                            </select>
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Include the Add User Modal -->
    @include('users.partials.add-modal')
</div>
@endsection
