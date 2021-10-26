@extends('layouts.app')

@section('heading')
    <h1>
        Edit Project Type
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            Delete <i class="fas fa-trash-alt fa-fw"></i>
        </button>
    </h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
    <li class="breadcrumb-item"><a href="{{ route('settings.project-types.index') }}">Project Types</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Project Type</li>
@endsection

@section('content')
    <form method="POST" action="">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="id" class="form-label">ID</label>
            <input type="text" readonly class="form-control-plaintext" id="id" value="{{ $projectType->id }}">
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name*</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                   value="{{ old('name') ? old('name') : $projectType->name }}" required>
        </div>

        <div class="mb-3">
            <label for="created_at" class="form-label">Created At</label>
            <input type="text" readonly class="form-control-plaintext" id="created_at" value="{{ $projectType->getCreatedAt() }}">
        </div>

        <div class="mb-3">
            <label for="updated_at" class="form-label">Updated At</label>
            <input type="text" readonly class="form-control-plaintext" id="updated_at" value="{{ $projectType->getUpdatedAt() }}">
        </div>

        @include('components.errors')

        <p>* required fields</p>
        <div>
            <button type="submit" class="btn btn-primary">Submit <i class="fas fa-check fa-fw"></i></button>
            <a href="{{ route('settings.project-types.index') }}" class="btn btn-outline-secondary">Cancel <i class="fas fa-ban fa-fw"></i></a>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Project Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <p>This action cannot be undone!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel <i class="fas fa-ban fa-fw"></i></button>
                    <button type="button" class="btn btn-danger">Delete <i class="fas fa-trash-alt fa-fw"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
