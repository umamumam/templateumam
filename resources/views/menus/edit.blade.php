@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="container">
    <h1>Edit Menu</h1>

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
            <select name="module_id" id="module_id" class="form-control" required>
                @foreach ($modules as $module)
                    <option value="{{ $module->id }}" {{ $menu->module_id == $module->id ? 'selected' : '' }}>
                        {{ $module->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent Menu</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">None (Top Level Menu)</option>
                @foreach ($menus as $parentMenu)
                    <option value="{{ $parentMenu->id }}" {{ $menu->parent_id == $parentMenu->id ? 'selected' : '' }}>
                        {{ $parentMenu->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Menu Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $menu->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="icon" class="form-label">Menu Icon</label>
            <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon', $menu->icon) }}" placeholder="fa-solid fa-home">
            <small class="form-text text-muted">Gunakan class icon FontAwesome atau library lain (contoh: fa-solid fa-home).</small>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Menu Link</label>
            <input type="text" name="link" id="link" class="form-control" value="{{ old('link', $menu->link) }}" placeholder="/nama-menu" required>
            <small class="form-text text-muted">Tuliskan hanya path seperti "/nama-menu". Sistem akan secara otomatis menyesuaikan dengan domain saat ini.</small>
        </div>

        <div class="mb-3">
            <label for="order" class="form-label">Order</label>
            <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $menu->order) }}" required>
        </div>

        <div class="mb-3">
            <label for="roles" class="form-label">Assign Roles</label>
            <select name="roles[]" id="roles" class="form-control" multiple required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $menu->roles->contains($role->id) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Menu</button>
        <a href="{{ route('menus.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
