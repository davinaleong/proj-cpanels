@extends('layouts.app')

@section('heading')
    <h1>
        View CPanel
        <a href="{{ route('cpanels.edit', ['cpanel' => $cpanel]) }}" class="btn btn-outline-primary">
            Edit <i class="fas fa-pen"></i>
        </a>
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            Delete <i class="fas fa-trash-alt fa-fw"></i>
        </button>
    </h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('cpanels.index') }}">CPanels</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $cpanel->name }}</li>
@endsection

@section('content')
    <div class="details">
        <div class="key">Project Type</div>
        <div class="value">
            @if ($cpanel->projectType)
                <a href="{{ route('settings.project-types.edit', ['projectType' => $cpanel->projectType]) }}"
                    class="label"
                    style="color: {{ $cpanel->projectType->text_color }}; background-color: {{ $cpanel->projectType->bg_color }}">
                    {{ $cpanel->projectType->name }}
                </a>
            @endif
        </div>
    </div>

    <div class="details">
        <div class="key">Image</div>
        <div class="value">
            @if ($cpanel->image)
                <a href="{{ route('settings.images.edit', ['image' => $cpanel->image]) }}">
                    <img src="{{ $cpanel->image->getFile() }}" alt="{{ $cpanel->name }}"
                        class="img-fluid img-thumbnail h200">
                </a>
            @endif
        </div>
    </div>

    <div class="details">
        <div class="key">Name</div>
        <div class="value">{{ $cpanel->name }}</div>
    </div>

    <h3 class="h5">URLs</h3>
    <div class="details">
        <div class="key">Site URL</div>
        <div class="value">
            <a href="{{ $cpanel->site_url }}" target="blank">
                {{ $cpanel->site_url }} <i class="fa fa-external-link-alt fa-fw"></i>
            </a>
        </div>
    </div>

    <div class="details">
        <div class="key">Admin URL</div>
        <div class="value">
            <a href="{{ $cpanel->admin_url }}" target="blank">
                {{ $cpanel->admin_url }} <i class="fa fa-external-link-alt fa-fw"></i>
            </a>
        </div>
    </div>

    <div class="details">
        <div class="key">CPanel URL</div>
        <div class="value">
            <a href="{{ $cpanel->cpanel_url }}" target="blank">
                {{ $cpanel->cpanel_url }} <i class="fa fa-external-link-alt fa-fw"></i>
            </a>
        </div>
    </div>

    <h3 class="h5">CPanel Credentials</h3>
    <div class="details">
        <div class="key">Username</div>
        <div class="value">{{ $cpanel->cpanel_username }}</div>
    </div>

    <div class="details">
        <div class="key">Password</div>
        <div class="value">{{ $cpanel->cpanel_password }}</div>
    </div>

    <h3 class="h5">Backend Credentials</h3>
    <div class="details">
        <div class="key">Username</div>
        <div class="value">{{ $cpanel->backend_username }}</div>
    </div>

    <div class="details">
        <div class="key">Password</div>
        <div class="value">{{ $cpanel->backend_password }}</div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('cpanels.destroy', ['cpanel' => $cpanel]) }}" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete CPanel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <p>This action cannot be undone!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel <i
                            class="fas fa-ban fa-fw"></i></button>
                    <button type="submit" class="btn btn-danger">Delete <i class="fas fa-trash-alt fa-fw"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
