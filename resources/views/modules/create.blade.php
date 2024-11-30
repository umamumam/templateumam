@extends('layouts.app')

@section('title', 'Create Module')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Create Module</h5>
            <small class="text-muted">Form to create a new module</small>
        </div>
        <div class="card-body">
            <form action="{{ route('modules.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Module Name</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-package"></i></span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter module name" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Create Module</button>
            </form>
        </div>
    </div>
</div>
@endsection
