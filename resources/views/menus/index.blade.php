@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Left Panel: Table of Modules with Card -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex w-100">
                        <input type="text" id="search-input" class="form-control w-75" placeholder="Search modules"
                            onkeyup="searchModules()">
                        <button id="refresh-btn" class="btn btn-secondary btn-sm ms-2" onclick="refreshPage()">
                            <i class="bx bx-refresh"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead style="background-color: #56a1f7; color: white;">
                            <tr>
                                <th style="color: white">#</th>
                                <th style="color: white">Module</th>
                                <th style="color: white">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="module-table-body">
                            @foreach ($uniqueModules as $moduleId => $moduleName)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $moduleName }}</td>
                                <td>
                                    <!-- Send module_id when clicking View -->
                                    <a href="{{ route('menus.index', ['module_id' => $moduleId]) }}"
                                        class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Panel: Sidebar with Menu List in Card -->
        <div class="col-md-6">
            <div id="menu-sidebar" class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold" style="color: red">Daftar Menu</span>
                    <a href="{{ route('menus.create') }}" class="btn btn-success btn-sm">
                        <i class="bx bx-plus me-1"></i> Create New Menu
                    </a>
                </div>
                <div class="card-body">
                    @foreach ($menus as $menu)
                    <div class="menu-item mb-3">
                        <div class="d-flex justify-content-between align-items-center menu-title" @if($menu->
                            children->isNotEmpty())
                            onclick="toggleSubmenu('menu-{{ $menu->id }}')"
                            @endif>
                            <span class="fw-bold">{{ $menu->name }}</span>
                            @if($menu->children->isNotEmpty())
                            <i class="bx bx-chevron-down"></i>
                            @endif
                            <div class="dropdown">
                                <button type="button"
                                    class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="menuOptions{{ $menu->id }}">
                                    <li>
                                        <button class="dropdown-item" onclick="showMenuDetails({{ $menu }})">
                                            <i class="bx bx-show"></i> Show
                                        </button>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('menus.edit', $menu->id) }}">
                                            <i class="bx bx-edit"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('menus.destroy', $menu->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this menu?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item">
                                                <i class="bx bx-trash"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        @if($menu->children->isNotEmpty())
                        <div id="menu-{{ $menu->id }}" class="submenu" style="display: none;">
                            @foreach ($menu->children as $submenu)
                            <div class="submenu-item d-flex justify-content-between align-items-center ps-3 py-1">
                                <span>{{ $submenu->name }}</span>
                                <div class="dropdown">
                                    <i class="bx bx-dots-vertical-rounded" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="cursor: pointer;"
                                        id="submenuOptions{{ $submenu->id }}"></i>
                                    <ul class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="submenuOptions{{ $submenu->id }}">
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                onclick="showMenuDetails({{ json_encode($submenu) }})">
                                                <i class="bx bx-show"></i> Show
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('menus.edit', $submenu->id) }}">
                                                <i class="bx bx-edit"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('menus.destroy', $submenu->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this submenu?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bx bx-trash"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Add Modal for Menu Details -->
        <div class="modal fade" id="menuDetailsModal" tabindex="-1" aria-labelledby="menuDetailsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="menuDetailsModalLabel">Menu Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Module</th>
                                <td id="menuModule"></td>
                            </tr>
                            <tr>
                                <th>Menu Name</th>
                                <td id="menuName"></td>
                            </tr>
                            <tr>
                                <th>Link</th>
                                <td id="menuLink"></td>
                            </tr>
                            <tr>
                                <th>Order</th>
                                <td id="menuOrder"></td>
                            </tr>
                            <tr>
                                <th>Roles</th>
                                <td id="menuRoles"></td>
                            </tr>
                            <tr>
                                <th>Parent Menu</th>
                                <td id="menuParent"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="submenuDetailsModal" tabindex="-1" aria-labelledby="submenuDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="submenuDetailsModalLabel">Submenu Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Module</th>
                                <td id="submenuModule"></td>
                            </tr>
                            <tr>
                                <th>Submenu Name</th>
                                <td id="submenuName"></td>
                            </tr>
                            <tr>
                                <th>Link</th>
                                <td id="submenuLink"></td>
                            </tr>
                            <tr>
                                <th>Order</th>
                                <td id="submenuOrder"></td>
                            </tr>
                            <tr>
                                <th>Roles</th>
                                <td id="submenuRoles"></td>
                            </tr>
                            <tr>
                                <th>Parent Menu</th>
                                <td id="submenuParent"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
    function toggleSubmenu(menuId) {
        const submenu = document.getElementById(menuId);
        if (submenu.style.display === 'none' || submenu.style.display === '') {
            submenu.style.display = 'block';
        } else {
            submenu.style.display = 'none';
        }
    }

    function showMenuDetails(menu) {
        document.getElementById('menuModule').innerText = menu.module?.name || 'N/A';
        document.getElementById('menuName').innerText = menu.name || 'N/A';
        document.getElementById('menuLink').innerHTML = `<a href="${menu.link}" target="_blank">${menu.link}</a>` || 'N/A';
        document.getElementById('menuOrder').innerText = menu.order || 'N/A';
        document.getElementById('menuRoles').innerHTML = menu.roles?.map(role => `<span class="badge bg-primary">${role.name}</span>`).join(' ') || 'N/A';
        document.getElementById('menuParent').innerText = menu.parent?.name || 'Main Menu';

        const modal = new bootstrap.Modal(document.getElementById('menuDetailsModal'));
        modal.show();
    }

    function showSubmenuDetails(submenu) {
        document.getElementById('submenuModule').innerText = submenu.module?.name || 'N/A';
        document.getElementById('submenuName').innerText = submenu.name || 'N/A';
        document.getElementById('submenuLink').innerHTML = 
            submenu.link
                ? `<a href="${submenu.link}" target="_blank">${submenu.link}</a>` 
                : 'N/A';
        document.getElementById('submenuOrder').innerText = submenu.order || 'N/A';
        document.getElementById('submenuRoles').innerHTML = 
            submenu.roles?.map(role => `<span class="badge bg-primary">${role.name}</span>`).join(' ') || 'N/A';
        document.getElementById('submenuParent').innerText = submenu.parent?.name || 'Main Menu';
        const modal = new bootstrap.Modal(document.getElementById('submenuDetailsModal'));
        modal.show();
    }


    function searchModules() {
        const searchQuery = document.getElementById('search-input').value.toLowerCase();
        const rows = document.querySelectorAll('#module-table-body tr');
        rows.forEach(row => {
            const moduleName = row.cells[1].innerText.toLowerCase();
            if (moduleName.includes(searchQuery)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    function refreshPage() {
        const searchQuery = document.getElementById('search-input').value;
        let url = '/menus'; 
        if (searchQuery) {
            url += `?search=${encodeURIComponent(searchQuery)}`;
        }    
        window.location.href = url;
    }


</script>

@endsection