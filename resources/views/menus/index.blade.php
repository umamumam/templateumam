@extends('layouts.app')

@section('title', 'Menu List')

@section('content')
<div class="container">
    <h1>Menu List</h1>

    <a href="{{ route('menus.create') }}" class="btn btn-success mb-3">Create New Menu</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Module</th>
                <th>Menu Name</th>
                <th>Link</th>
                <th>Order</th>
                <th>Roles</th>
                <th>Parent Menu</th>
                <th>Actions</th>
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
                        <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
                            <a href="{{ route('menus.edit', $submenu->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('menus.destroy', $submenu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
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
