@extends('layouts.app')

@section('heading')
    <h1>Create Project</h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Projects</li>
@endsection

@section('content')
    <form method="POST" action="{{ route('projects.store') }}">
        @csrf

        <div class="mb-3">
            <label for="project_type_id" class="form-label">Project Type*</label>
            <select name="project_type_id" class="form-control" required>
                <option value="">-- Project Types --</option>
                @foreach ($projectTypes as $projectType)
                    <option value="{{ $projectType->id }}" {{ old('project_type_id') == $projectType->id ? 'selected="selected"' : '' }}>{{ $projectType->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image_id" class="form-label">Image*</label>
            <select name="image_id" class="form-control" required>
                <option value="">-- Images --</option>
                @foreach ($images as $image)
                    <option value="{{ $image->id }}" {{ old('image_id') == $image->id ? 'selected="selected"' : '' }}>{{ $image->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name*</label>
            <input type="text" class="form-control" name="name" id="name"
                value="{{ old('name') }}" placeholder="Name" required>
        </div>

        <div class="mb-3">
            <label for="project_executive" class="form-label">Project Executive</label>
            <input type="text" class="form-control" name="project_executive" id="project_executive"
                value="{{ old('project_executive') }}" placeholder="Project Executive">
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" class="form-control" id="notes" rows="4">{{ old('notes') }}</textarea>
        </div>

        <div class="form-check">
            <input name="is_full_project" class="form-check-input" type="checkbox" value="yes" id="is_full_project">
            <label class="form-check-label" for="is_full_project">
              Full Project
            </label>
        </div>

        <!-- Tab Content -->
        <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="demo-tab" data-bs-toggle="tab" data-bs-target="#demo" type="button" role="tab" aria-controls="demo" aria-selected="true">Demo</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="live-tab" data-bs-toggle="tab" data-bs-target="#live" type="button" role="tab" aria-controls="live" aria-selected="false">Live</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- Demo Tab -->
            <div class="tab-pane text-info p-3 fade show active" id="demo" role="tabpanel" aria-labelledby="demo-tab">
                <fieldset>
                    <legend>URLs</legend>

                    <div class="mb-3">
                        <label for="demo_site_url" class="form-label">Site URL</label>
                        <input type="text" class="form-control" name="demo[site_url]" id="demo_site_url"
                            value="{{ old('demo.site_url') }}" placeholder="http://www.example.com">
                    </div>

                    <div class="mb-3">
                        <label for="demo_admin_url" class="form-label">Admin URL</label>
                        <input type="text" class="form-control" name="demo[admin_url]" id="demo_admin_url"
                            value="{{ old('demo.admin_url') }}" placeholder="http://www.example.com/admin">
                    </div>

                    <div class="mb-3">
                        <label for="demo_cpanel_url" class="form-label">CPanel URL</label>
                        <input type="text" class="form-control" name="demo[cpanel_url]" id="demo_cpanel_url"
                            value="{{ old('demo.cpanel_url') }}" placeholder="http://www.example.com:2083">
                    </div>

                    <div class="mb-3">
                        <label for="demo_design_url" class="form-label">Design URL</label>
                        <input type="text" class="form-control" name="demo[design_url]" id="demo_design_url"
                            value="{{ old('demo.design_url') }}" placeholder="http://www.example.com/design">
                    </div>

                    <div class="mb-3">
                        <label for="demo_programming_brief_url" class="form-label">Programming Brief URL</label>
                        <input type="text" class="form-control" name="demo[programming_brief_url]" id="demo_programming_brief_url"
                            value="{{ old('demo.programming_brief_url') }}" placeholder="http://www.example.com/brief">
                    </div>
                </fieldset>

                <fieldset>
                    <legend>CPanel Credentials</legend>

                    <div class="mb-3">
                        <label for="demo_cpanel_username" class="form-label">CPanel Username</label>
                        <input type="text" class="form-control" name="demo[cpanel_username]" id="demo_cpanel_username"
                            value="{{ old('demo.cpanel_username') }}" placeholder="CPanel Username">
                    </div>

                    <div class="mb-3">
                        <label for="demo_cpanel_password" class="form-label">CPanel Password</label>
                        <input type="text" class="form-control" name="demo[cpanel_password]" id="demo_cpanel_password"
                            value="{{ old('demo.cpanel_password') }}" placeholder="CPanel Password">
                    </div>
                </fieldset>

                <fieldset>
                    <legend>DB Credentials</legend>

                    <div class="mb-3">
                        <label for="demo_db_name" class="form-label">DB Name</label>
                        <input type="text" class="form-control" name="demo[db_name]" id="demo_db_name"
                            value="{{ old('demo.db_name') }}" placeholder="DB Name">
                    </div>

                    <div class="mb-3">
                        <label for="demo_db_username" class="form-label">DB Username</label>
                        <input type="text" class="form-control" name="demo[db_username]" id="demo_db_username"
                            value="{{ old('demo.db_username') }}" placeholder="DB Username">
                    </div>

                    <div class="mb-3">
                        <label for="demo_db_password" class="form-label">DB Password</label>
                        <input type="text" class="form-control" name="demo[db_password]" id="demo_db_password"
                            value="{{ old('demo.db_password') }}" placeholder="DB Password">
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Backend Credentials</legend>
                    <div class="mb-3">
                        <button id="btn-demo-oc" type="button" class="btn btn-outline-secondary mr-2">
                            Use Default OC Credentials
                        </button>
                        <button id="btn-demo-wp" type="button" class="btn btn-outline-secondary">
                            Use Default WP / WC Credentials
                        </button>
                    </div>

                    <div class="mb-3">
                        <label for="demo_backend_username" class="form-label">Backend Username</label>
                        <input type="text" class="form-control" name="demo[backend_username]" id="demo_backend_username"
                            value="{{ old('demo.backend_username') }}" placeholder="Backend Username">
                    </div>

                    <div class="mb-3">
                        <label for="demo_backend_password" class="form-label">Backend Password</label>
                        <input type="text" class="form-control" name="demo[backend_password]" id="demo_backend_password"
                            value="{{ old('demo.backend_password') }}" placeholder="Backend Password">
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Timestamps</legend>

                    <div class="mb-3">
                        <label for="demo_started_at" class="form-label">Started At</label>
                        <input type="text" class="form-control" name="demo[started_at]" id="demo_started_at"
                            value="{{ old('demo.started_at') }}" placeholder="DD MMM YYYY">
                    </div>

                    <div class="mb-3">
                        <label for="demo_ended_at" class="form-label">Ended At</label>
                        <input type="text" class="form-control" name="demo[ended_at]" id="demo_ended_at"
                            value="{{ old('demo.ended_at') }}" placeholder="DD MMM YYYY">
                    </div>
                </fieldset>
            </div>
            <!-- Demo Tab -->
            <!-- Live Tab -->
            <div class="tab-pane text-warning p-3 fade" id="live" role="tabpanel" aria-labelledby="live-tab">
                <fieldset>
                    <legend>URLs</legend>

                    <div class="mb-3">
                        <label for="live_site_url" class="form-label">Site URL</label>
                        <input type="text" class="form-control" name="live[site_url]" id="live_site_url"
                            value="{{ old('live.site_url') }}" placeholder="http://www.example.com">
                    </div>

                    <div class="mb-3">
                        <label for="live_admin_url" class="form-label">Admin URL</label>
                        <input type="text" class="form-control" name="live[admin_url]" id="live_admin_url"
                            value="{{ old('live.admin_url') }}" placeholder="http://www.example.com/admin">
                    </div>

                    <div class="mb-3">
                        <label for="live_cpanel_url" class="form-label">CPanel URL</label>
                        <input type="text" class="form-control" name="live[cpanel_url]" id="live_cpanel_url"
                            value="{{ old('live.cpanel_url') }}" placeholder="http://www.example.com:2083">
                    </div>
                </fieldset>

                <fieldset>
                    <legend>CPanel Credentials</legend>

                    <div class="mb-3">
                        <label for="live_cpanel_username" class="form-label">CPanel Username</label>
                        <input type="text" class="form-control" name="live[cpanel_username]" id="live_cpanel_username"
                            value="{{ old('live.cpanel_username') }}" placeholder="CPanel Username">
                    </div>

                    <div class="mb-3">
                        <label for="live_cpanel_password" class="form-label">CPanel Password</label>
                        <input type="text" class="form-control" name="live[cpanel_password]" id="live_cpanel_password"
                            value="{{ old('live.cpanel_password') }}" placeholder="CPanel Password">
                    </div>
                </fieldset>

                <fieldset>
                    <legend>DB Credentials</legend>

                    <div class="mb-3">
                        <label for="live_db_name" class="form-label">DB Name</label>
                        <input type="text" class="form-control" name="live[db_name]" id="live_db_name"
                            value="{{ old('live.db_name') }}" placeholder="DB Name">
                    </div>

                    <div class="mb-3">
                        <label for="live_db_username" class="form-label">DB Username</label>
                        <input type="text" class="form-control" name="live[db_username]" id="live_db_username"
                            value="{{ old('live.db_username') }}" placeholder="DB Username">
                    </div>

                    <div class="mb-3">
                        <label for="live_db_password" class="form-label">DB Password</label>
                        <input type="text" class="form-control" name="live[db_password]" id="live_db_password"
                            value="{{ old('live.db_password') }}" placeholder="DB Password">
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Backend Credentials</legend>
                    <div class="mb-3">
                        <button id="btn-live-oc" type="button" class="btn btn-outline-secondary mr-2">
                            Use Default OC Credentials
                        </button>
                        <button id="btn-live-wp" type="button" class="btn btn-outline-secondary">
                            Use Default WP / WC Credentials
                        </button>
                    </div>

                    <div class="mb-3">
                        <label for="live_admin_panel" class="form-label">Backend Panel</label>
                        <input type="text" class="form-control" name="live[admin_panel]" id="live_admin_panel"
                            value="{{ old('live.admin_panel') }}" placeholder="Backend Panel">
                    </div>

                    <div class="mb-3">
                        <label for="live_backend_username" class="form-label">Backend Username</label>
                        <input type="text" class="form-control" name="live[backend_username]" id="live_backend_username"
                            value="{{ old('live.backend_username') }}" placeholder="Backend Username">
                    </div>

                    <div class="mb-3">
                        <label for="live_backend_password" class="form-label">Backend Password</label>
                        <input type="text" class="form-control" name="live[backend_password]" id="live_backend_password"
                            value="{{ old('live.backend_password') }}" placeholder="Backend Password">
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Noreply Credentials</legend>

                    <div class="mb-3">
                        <label for="live_noreply_email" class="form-label">Noreply Email</label>
                        <input type="text" class="form-control" name="live[noreply_email]" id="live_noreply_email"
                            value="{{ old('live.noreply_email') }}" placeholder="Noreply Email">
                    </div>

                    <div class="mb-3">
                        <label for="live_noreply_password" class="form-label">Noreply Password</label>
                        <input type="text" class="form-control" name="live[noreply_password]" id="live_noreply_password"
                            value="{{ old('live.noreply_password') }}" placeholder="Noreply Password">
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Timestamps</legend>

                    <div class="mb-3">
                        <label for="live_lived_at" class="form-label">Lived At</label>
                        <input type="text" class="form-control" name="live[lived_at]" id="live_lived_at"
                            value="{{ old('live.lived_at') }}" placeholder="DD MMM YYYY">
                    </div>
                </fieldset>
            </div>
            <!-- Live Tab -->
        </div>
        <!-- Tab Content -->

        @include('components.errors')

        <p>* required fields</p>

        <div>
            <button type="submit" class="btn btn-primary">Submit <i class="fas fa-check fa-fw"></i></button>
            <a href="{{ route('cpanels.index') }}" class="btn btn-outline-secondary">Cancel <i class="fas fa-ban fa-fw"></i></a>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#btn-demo-oc').click(function() {
            $('#demo_backend_username').val('{{ $oc_default_credentials['username'] }}');
            $('#demo_backend_password').val('{{ $oc_default_credentials['password'] }}');
        });

        $('#btn-demo-wp').click(function() {
            $('#demo_backend_username').val('{{ $wp_default_credentials['username'] }}');
            $('#demo_backend_password').val('{{ $wp_default_credentials['password'] }}');
        });

        $('#btn-live-oc').click(function() {
            $('#live_backend_username').val('{{ $oc_default_credentials['username'] }}');
            $('#live_backend_password').val('{{ $oc_default_credentials['password'] }}');
        });

        $('#btn-live-wp').click(function() {
            $('#live_backend_username').val('{{ $wp_default_credentials['username'] }}');
            $('#live_backend_password').val('{{ $wp_default_credentials['password'] }}');
        });
    });
</script>
@endsection
