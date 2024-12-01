@extends('layouts.app')

@section('title', 'Create Menu')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Create New Menu</h5>
            <small class="text-muted">Form to create a new menu</small>
        </div>
        <div class="card-body">
            <form action="{{ route('menus.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="module_id" class="form-label">Module</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-package"></i></span>
                        <select name="module_id" id="module_id" class="form-select" required>
                            <option value="" disabled selected>Select Module</option>
                            @foreach ($modules as $module)
                                <option value="{{ $module->id }}">{{ $module->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>                

                <div class="mb-3">
                    <label for="parent_id" class="form-label">Parent Menu</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-menu"></i></span>
                        <select name="parent_id" id="parent_id" class="form-select">
                            <option value="">None (Top Level Menu)</option>
                            @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>                

                <div class="mb-3">
                    <label for="name" class="form-label">Menu Name</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-font"></i></span>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="icon" class="form-label">Menu Icon</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-image"></i></span>
                        <input type="text" name="icon" id="icon" class="form-control" placeholder="fa-solid fa-home">
                    </div>
                    <small class="form-text text-muted">Gunakan class icon FontAwesome atau library lain (contoh: fa-solid fa-home).</small>
                </div>

                <div class="mb-3">
                    <label for="link" class="form-label">Menu Link</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-link-alt"></i></span>
                        <input type="text" name="link" id="link" class="form-control" placeholder="/nama-menu" required>
                    </div>
                    <small class="form-text text-muted">Tuliskan hanya path seperti "/nama-menu". Sistem akan otomatis menyesuaikan dengan domain saat ini.</small>
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label">Order</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-sort"></i></span>
                        <input type="number" name="order" id="order" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="roles" class="form-label">Assign Roles</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                        <select name="roles[]" id="roles" class="form-select" multiple required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-text">
                        Hold down the <strong>Ctrl</strong> (Windows) or <strong>Command</strong> (Mac) key to select multiple roles.
                    </div>
                </div>                

                <button type="submit" class="btn btn-primary">Create Menu</button>
            </form>
        </div>
    </div>
</div>
@endsection
