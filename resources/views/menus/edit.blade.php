@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Menu</h5>
            <small class="text-muted">Form to edit an existing menu</small>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('menus.update', $menu->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="module_id" class="form-label">Module</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-package"></i></span>
                        <select name="module_id" id="module_id" class="form-control" required>
                            @foreach ($modules as $module)
                                <option value="{{ $module->id }}" {{ $menu->module_id == $module->id ? 'selected' : '' }}>
                                    {{ $module->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="parent_id" class="form-label">Parent Menu</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-menu"></i></span>
                        <select name="parent_id" id="parent_id" class="form-control">
                            <option value="">None (Top Level Menu)</option>
                            @foreach ($menus as $parentMenu)
                                <option value="{{ $parentMenu->id }}" {{ $menu->parent_id == $parentMenu->id ? 'selected' : '' }}>
                                    {{ $parentMenu->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Menu Name</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-font"></i></span>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $menu->name) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="icon" class="form-label">Menu Icon</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-image"></i></span>
                        <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon', $menu->icon) }}" placeholder="fa-solid fa-home">
                    </div>
                    <small class="form-text text-muted">Gunakan class icon FontAwesome atau library lain (contoh: fa-solid fa-home).</small>
                </div>

                <div class="mb-3">
                    <label for="link" class="form-label">Menu Link</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-link-alt"></i></span>
                        <input type="text" name="link" id="link" class="form-control" value="{{ old('link', $menu->link) }}" placeholder="/nama-menu" required>
                    </div>
                    <small class="form-text text-muted">Tuliskan hanya path seperti "/nama-menu". Sistem akan secara otomatis menyesuaikan dengan domain saat ini.</small>
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label">Order</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-sort"></i></span>
                        <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $menu->order) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="roles" class="form-label">Assign Roles</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                        <select name="roles[]" id="roles" class="form-control" multiple required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $menu->roles->contains($role->id) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Menu</button>
                <a href="{{ route('menus.index') }}" class="btn btn-secondary">Back to List</a>
            </form>
        </div>
    </div>
</div>
@endsection
