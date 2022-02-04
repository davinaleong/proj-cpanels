@extends('layouts.app')

@section('heading')
    <h1>Edit CPanel</h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('cpanels.index') }}">CPanels</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cpanels.show', ['cpanel' => $cpanel]) }}">{{ $cpanel->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
    <form method="POST" action="{{ route('cpanels.update', ['cpanel' => $cpanel]) }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="project_type_id" class="form-label">Project Type*</label>
            <select name="project_type_id" class="form-control" required>
                <option value="">-- Project Types --</option>
                @foreach ($projectTypes as $projectType)
                    <option value="{{ $projectType->id }}" {{ $cpanel->project_type_id == $projectType->id ? 'selected="selected"' : '' }}>{{ $projectType->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image_id" class="form-label">Image*</label>
            <select name="image_id" class="form-control" required>
                <option value="">-- Images --</option>
                @foreach ($images as $image)
                    <option value="{{ $image->id }}" {{ $cpanel->image_id == $image->id ? 'selected="selected"' : '' }}>{{ $image->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name*</label>
            <input type="text" class="form-control" name="name" id="name"
                value="{{ old('name') ? old('name') : $cpanel->name }}" placeholder="Name" required>
        </div>

        <fieldset>
            <legend>URLs</legend>

            <div class="mb-3">
                <label for="site_url" class="form-label">Site URL</label>
                <input type="text" class="form-control" name="site_url" id="site_url"
                    value="{{ old('site_url') ? old('site_url') : $cpanel->site_url }}" placeholder="http://www.example.com">
            </div>

            <div class="mb-3">
                <label for="admin_url" class="form-label">Admin URL</label>
                <input type="text" class="form-control" name="admin_url" id="admin_url"
                    value="{{ old('admin_url') ? old('admin_url') : $cpanel->admin_url }}" placeholder="http://www.example.com/admin">
            </div>

            <div class="mb-3">
                <label for="cpanel_url" class="form-label">CPanel URL</label>
                <input type="text" class="form-control" name="cpanel_url" id="cpanel_url"
                    value="{{ old('cpanel_url') ? old('cpanel_url') : $cpanel->cpanel_url }}" placeholder="http://www.example.com:2083">
            </div>
        </fieldset>

        <fieldset>
            <legend>CPanel Credentials</legend>

            <div class="mb-3">
                <label for="cpanel_username" class="form-label">CPanel Username</label>
                <input type="text" class="form-control" name="cpanel_username" id="cpanel_username"
                    value="{{ old('cpanel_username') ? old('cpanel_username') : $cpanel->cpanel_username }}" placeholder="CPanel Username">
            </div>

            <div class="mb-3">
                <label for="cpanel_password" class="form-label">CPanel Password</label>
                <input type="text" class="form-control" name="cpanel_password" id="cpanel_password"
                    value="{{ old('cpanel_password') ? old('cpanel_password') : $cpanel->cpanel_password }}" placeholder="CPanel Password">
            </div>
        </fieldset>

        <fieldset>
            <legend>Backend Credentials</legend>
            <div class="mb-3">
                <button id="btn-oc" type="button" class="btn btn-outline-secondary mr-2">
                    Use Default OC Credentials
                </button>
                <button id="btn-wp" type="button" class="btn btn-outline-secondary">
                    Use Default WP / WC Credentials
                </button>
            </div>

            <div class="mb-3">
                <label for="backend_username" class="form-label">Backend Username</label>
                <input type="text" class="form-control" name="backend_username" id="backend_username"
                    value="{{ old('backend_username') ? old('backend_username') : $cpanel->backend_username }}"
                    placeholder="Backend Username">
            </div>

            <div class="mb-3">
                <label for="backend_password" class="form-label">Backend Password</label>
                <input type="text" class="form-control" name="backend_password" id="backend_password"
                    value="{{ old('backend_password') ? old('backend_password') : $cpanel->backend_password }}"
                    placeholder="Backend Password">
            </div>
        </fieldset>

        @include('components.errors')

        <p>* required fields</p>

        <div>
            <button type="submit" class="btn btn-primary">Submit <i class="fas fa-check fa-fw"></i></button>
            <a href="{{ route('cpanels.show', ['cpanel' => $cpanel]) }}" class="btn btn-outline-secondary">Cancel <i class="fas fa-ban fa-fw"></i></a>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#btn-oc').click(function() {
            $('#backend_username').val('{{ $oc_default_credentials['username'] }}');
            $('#backend_password').val('{{ $oc_default_credentials['password'] }}');
        });

        $('#btn-wp').click(function() {
            $('#backend_username').val('{{ $wp_default_credentials['username'] }}');
            $('#backend_password').val('{{ $wp_default_credentials['password'] }}');
        });
    });
</script>
@endsection
