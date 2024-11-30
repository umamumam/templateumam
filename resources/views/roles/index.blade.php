@extends('layouts.app')

@section('title', 'Manage Roles')

@section('content')
<div class="mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">Add Role</button>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRoleModal{{ $role->id }}">Edit</button>
                    <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @include('roles.partials.edit-modal', ['role' => $role])
        @endforeach
    </tbody>
</table>

@include('roles.partials.add-modal')
@endsection
