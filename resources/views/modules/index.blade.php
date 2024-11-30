@extends('layouts.app')

@section('title', 'Module List')

@section('content')
<div class="container">
    <h1>Module List</h1>

    <a href="{{ route('modules.create') }}" class="btn btn-success mb-3">Create New Module</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Module Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($modules as $module)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $module->name }}</td>
                    <td>
                        <a href="{{ route('modules.edit', $module->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('modules.destroy', $module->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
