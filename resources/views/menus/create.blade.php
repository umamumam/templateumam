@extends('layouts.app')

@section('title', 'Create Menu')

@section('content')
<div class="container">
    <h1>Create New Menu</h1>

    <form action="{{ route('menus.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="module_id" class="form-label">Module</label>
            <select name="module_id" id="module_id" class="form-control" required>
                <option value="">Select Module</option>
                @foreach ($modules as $module)
                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent Menu</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">None (Top Level Menu)</option>
                @foreach ($menus as $menu)
                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Menu Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="icon" class="form-label">Menu Icon</label>
            <input type="text" name="icon" id="icon" class="form-control" placeholder="fa-solid fa-home">
            <small class="form-text text-muted">Gunakan class icon FontAwesome atau library lain (contoh: fa-solid fa-home).</small>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Menu Link</label>
            <input type="text" name="link" id="link" class="form-control" placeholder="/nama-menu" required>
            <small class="form-text text-muted">Tuliskan hanya path seperti "/nama-menu". Sistem akan otomatis menyesuaikan dengan domain saat ini.</small>
        </div>

        <div class="mb-3">
            <label for="order" class="form-label">Order</label>
            <input type="number" name="order" id="order" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="roles" class="form-label">Assign Roles</label>
            <select name="roles[]" id="roles" class="form-control" multiple required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Hold down the Ctrl (Windows) or Command (Mac) button to select multiple roles.</small>
        </div>

        <button type="submit" class="btn btn-primary">Create Menu</button>
    </form>
</div>
@endsection
