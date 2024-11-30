@extends('layouts.app')

@section('title', 'Edit Module')

@section('content')
<div class="container">
    <h1>Edit Module</h1>

    <form action="{{ route('modules.update', $module->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Module Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $module->name) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Module</button>
    </form>
</div>
@endsection
