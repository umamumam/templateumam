@extends('layouts.app')

@section('title', 'Module List')

@section('content')
<div class="container mt-4">
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

    <!-- Card -->
    <div class="card overflow-hidden">
        <div class="card-header">
            <h5 class="card-title mb-3">Module List</h5>
            <div class="d-flex justify-content-between align-items-center">
                <!-- Create Module Button with Icon -->
                <a href="{{ route('modules.create') }}" class="btn btn-success">
                    <i class="bx bx-plus me-1"></i> Create New Module
                </a>
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('modules.index') }}" class="d-flex align-items-center">
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" class="form-control" name="search" placeholder="Search modules" value="{{ request('search') }}">
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
                            <th style="width: 70%; color: white;">Module Name</th>
                            <th style="color: white;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modules as $module)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $module->name }}</td>
                            <td>
                                <!-- Edit Button with Icon -->
                                <a href="{{ route('modules.edit', $module->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bx bx-edit-alt"></i> Edit
                                </a>
                                
                                <!-- Delete Button with Icon -->
                                <form action="{{ route('modules.destroy', $module->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bx bx-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination and Data Information -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="d-flex">
                    <p class="mb-0">Showing {{ $modules->firstItem() }} to {{ $modules->lastItem() }} of
                        {{ $modules->total() }} entries</p>
                </div>
                <div>
                    {{ $modules->links('pagination::bootstrap-5') }}
                </div>
                <div>
                    <!-- Form untuk dropdown entries -->
                    <form method="GET" action="{{ route('modules.index') }}" id="entries-form">
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
</div>
@endsection
