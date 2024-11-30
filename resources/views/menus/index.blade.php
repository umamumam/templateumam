@extends('layouts.app')

@section('title', 'Menu List')

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
            <h5 class="card-title mb-3">Menu List</h5>
            <div class="d-flex justify-content-between align-items-center">
                <!-- Create New Menu Button with Icon -->
                <a href="{{ route('menus.create') }}" class="btn btn-success">
                    <i class="bx bx-plus me-1"></i> Create New Menu
                </a>
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('menus.index') }}" class="d-flex align-items-center">
                    <div class="input-group" style="max-width: 300px;">
                        <input type="text" class="form-control" name="search" placeholder="Search menus" value="{{ request('search') }}">
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
                            <th style="color: white;">Module</th>
                            <th style="color: white;">Menu Name</th>
                            <th style="color: white;">Link</th>
                            <th style="color: white;">Order</th>
                            <th style="color: white;">Roles</th>
                            <th style="color: white;">Parent Menu</th>
                            <th style="color: white;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                        <tr class="parent-menu">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $menu->module->name }}</td>
                            <td>
                                <button class="toggle-button btn btn-link">
                                    ▶
                                </button>
                                {{ $menu->name }}
                            </td>
                            <td><a href="{{ $menu->link }}" target="_blank">{{ $menu->link }}</a></td>
                            <td>{{ $menu->order }}</td>
                            <td>
                                @foreach ($menu->roles as $role)
                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if ($menu->parent_id)
                                    {{ $menu->parent->name }}
                                @else
                                    Main Menu
                                @endif
                            </td>
                            <td>
                                <!-- Edit Button with Icon -->
                                <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bx bx-edit-alt"></i> Edit
                                </a>
                                <!-- Delete Button with Icon -->
                                <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bx bx-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <!-- Menampilkan sub-menu, disembunyikan awalnya -->
                        @foreach ($menu->children as $submenu)
                        <tr class="submenu" style="display: none;">
                            <td></td> <!-- Indentation for submenu -->
                            <td>{{ $submenu->module->name }}</td>
                            <td>{{ $submenu->name }}</td>
                            <td><a href="{{ $submenu->link }}" target="_blank">{{ $submenu->link }}</a></td>
                            <td>{{ $submenu->order }}</td>
                            <td>
                                @foreach ($submenu->roles as $role)
                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ $submenu->parent ? $submenu->parent->name : 'Main Menu' }}</td>
                            <td>
                                <!-- Edit Button with Icon -->
                                <a href="{{ route('menus.edit', $submenu->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bx bx-edit-alt"></i> Edit
                                </a>
                                <!-- Delete Button with Icon -->
                                <form action="{{ route('menus.destroy', $submenu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bx bx-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination and Data Information -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="d-flex">
                    <p class="mb-0">Showing {{ $menus->firstItem() }} to {{ $menus->lastItem() }} of
                        {{ $menus->total() }} entries</p>
                </div>
                <div>
                    {{ $menus->links('pagination::bootstrap-5') }}
                </div>
                <div>
                    <!-- Form untuk dropdown entries -->
                    <form method="GET" action="{{ route('menus.index') }}" id="entries-form">
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

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleButtons = document.querySelectorAll('.toggle-button');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr'); // Find the parent row
                const subMenuRows = row.nextElementSibling; // Get the next sibling (submenu rows)
                
                // Toggle the display of submenu rows
                if (subMenuRows.style.display === 'none' || subMenuRows.style.display === '') {
                    subMenuRows.style.display = 'table-row'; // Show submenu
                    this.innerHTML = '▼'; // Change to down arrow
                } else {
                    subMenuRows.style.display = 'none'; // Hide submenu
                    this.innerHTML = '▶'; // Change to right arrow
                }
            });
        });
    });
</script>
@endsection
