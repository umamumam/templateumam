@extends('layouts.app')

@section('title', 'Create Module')

@section('content')
<div class="container">
    <h1>Create Module</h1>

    <form action="{{ route('modules.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Module Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Module</button>
    </form>
</div>
@endsection
