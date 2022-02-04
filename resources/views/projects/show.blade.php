@extends('layouts.app')

@section('heading')
    <h1>
        View Project
        <a href="{{ route('projects.edit', ['project' => $project]) }}" class="btn btn-outline-primary">
            Edit <i class="fas fa-pen"></i>
        </a>
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
          Delete <i class="fas fa-trash-alt fa-fw"></i>
        </button>
    </h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $project->name }}</li>
@endsection

@section('content')
    <div class="details">
        <div class="key">Project Type</div>
        <div class="value">
            @if($project->projectType)
            <a href="{{ route('settings.project-types.edit', ['projectType' => $project->projectType]) }}">
                {{ $project->projectType->name }}
            </a>
            @endif
        </div>
    </div>

    <div class="details">
        <div class="key">Image</div>
        <div class="value">
            @if($project->image)
            <a href="{{ route('settings.images.edit', ['image' => $project->image]) }}">
                <img src="{{ $project->image->getFile() }}" alt="{{ $project->name }}" class="img-fluid img-thumbnail h200">
            </a>
            @endif
        </div>
    </div>

    <div class="details">
        <div class="key">Name</div>
        <div class="value">{{ $project->name }}</div>
    </div>

    <div class="details">
        <div class="key">Project Executive</div>
        <div class="value">{{ $project->project_executive }}</div>
    </div>

    <div class="details">
        <div class="key">Full Project</div>
        <div class="value">{{ $project->is_full_project ? 'Yes' : '' }}</div>
    </div>

    <div class="details">
        <div class="key">Notes</div>
        <div class="value">{!! nl2br($project->notes) !!}</div>
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
            @if ($project->demoCpanel)
            <div class="mb-3">
                <h3 class="mb-1">URLs</h3>

                <div class="details">
                    <div class="key">Site URL</div>
                    <div class="value">
                        <a href="{{ $project->demoCpanel->site_url }}">
                            {{ $project->demoCpanel->site_url }} <i class="fa fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>

                <div class="details">
                    <div class="key">Admin URL</div>
                    <div class="value">
                        <a href="{{ $project->demoCpanel->admin_url }}">
                            {{ $project->demoCpanel->admin_url }} <i class="fa fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>

                <div class="details">
                    <div class="key">CPanel URL</div>
                    <div class="value">
                        <a href="{{ $project->demoCpanel->cpanel_url }}">
                            {{ $project->demoCpanel->cpanel_url }} <i class="fa fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>

                <div class="details">
                    <div class="key">Design URL</div>
                    <div class="value">
                        <a href="{{ $project->demoCpanel->design_url }}">
                            {{ $project->demoCpanel->design_url }} <i class="fa fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>

                <div class="details">
                    <div class="key">Programming Brief URL</div>
                    <div class="value">
                        <a href="{{ $project->demoCpanel->programming_brief_url }}">
                            {{ $project->demoCpanel->programming_brief_url }} <i class="fa fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <h3 class="mb-1">CPanel Credentials</h3>

                <div class="details">
                    <div class="key">CPanel Username</div>
                    <div class="value">{{ $project->demoCpanel->cpanel_username }}</div>
                </div>

                <div class="details">
                    <div class="key">CPanel Password</div>
                    <div class="value">{{ $project->demoCpanel->cpanel_password }}</div>
                </div>
            </div>

            <div class="mb-3">
                <h3 class="mb-1">DB Credentials</h3>

                <div class="details">
                    <div class="key">DB Name</div>
                    <div class="value">{{ $project->demoCpanel->db_name }}</div>
                </div>

                <div class="details">
                    <div class="key">DB Username</div>
                    <div class="value">{{ $project->demoCpanel->db_username }}</div>
                </div>

                <div class="details">
                    <div class="key">DB Password</div>
                    <div class="value">{{ $project->demoCpanel->db_password }}</div>
                </div>
            </div>

            <div class="mb-3">
                <h3 class="mb-1">Backend Credentials</h3>

                <div class="details">
                    <div class="key">Backend Username</div>
                    <div class="value">{{ $project->demoCpanel->backend_username }}</div>
                </div>

                <div class="details">
                    <div class="key">Backend Password</div>
                    <div class="value">{{ $project->demoCpanel->backend_password }}</div>
                </div>
            </div>

            <div>
                <h3 class="mb-1">Timestamps</h3>

                <div class="details">
                    <div class="key">Started At</div>
                    <div class="value">{{ $project->demoCpanel->started_at }}</div>
                </div>

                <div class="details">
                    <div class="key">Ended At</div>
                    <div class="value">{{ $project->demoCpanel->ended_at }}</div>
                </div>
            </div>
            @endif
        </div>
        <!-- Demo Tab -->
        <!-- Live Tab -->
        <div class="tab-pane text-warning p-3 fade" id="live" role="tabpanel" aria-labelledby="live-tab">
            <div class="mb-3">
                <h3 class="mb-1">URLs</h3>

                <div class="details">
                    <div class="key">Site URL</div>
                    <div class="value">
                        <a href="{{ $project->liveCpanel->site_url }}">
                            {{ $project->liveCpanel->site_url }} <i class="fa fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>

                <div class="details">
                    <div class="key">Admin URL</div>
                    <div class="value">
                        <a href="{{ $project->liveCpanel->admin_url }}">
                            {{ $project->liveCpanel->admin_url }} <i class="fa fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>

                <div class="details">
                    <div class="key">CPanel URL</div>
                    <div class="value">
                        <a href="{{ $project->liveCpanel->cpanel_url }}">
                            {{ $project->liveCpanel->cpanel_url }} <i class="fa fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <h3 class="mb-1">CPanel Credentials</h3>

                <div class="details">
                    <div class="key">CPanel Username</div>
                    <div class="value">{{ $project->liveCpanel->cpanel_username }}</div>
                </div>

                <div class="details">
                    <div class="key">CPanel Password</div>
                    <div class="value">{{ $project->liveCpanel->cpanel_password }}</div>
                </div>
            </div>

            <div class="mb-3">
                <h3 class="mb-1">DB Credentials</h3>

                <div class="details">
                    <div class="key">DB Name</div>
                    <div class="value">{{ $project->liveCpanel->db_name }}</div>
                </div>

                <div class="details">
                    <div class="key">DB Username</div>
                    <div class="value">{{ $project->liveCpanel->db_username }}</div>
                </div>

                <div class="details">
                    <div class="key">DB Password</div>
                    <div class="value">{{ $project->liveCpanel->db_password }}</div>
                </div>
            </div>

            <div class="mb-3">
                <h3 class="mb-1">Backend Credentials</h3>

                <div class="details">
                    <div class="key">Backend Panel</div>
                    <div class="value">{{ $project->liveCpanel->admin_panel }}</div>
                </div>

                <div class="details">
                    <div class="key">Backend Username</div>
                    <div class="value">{{ $project->liveCpanel->backend_username }}</div>
                </div>

                <div class="details">
                    <div class="key">Backend Password</div>
                    <div class="value">{{ $project->liveCpanel->backend_password }}</div>
                </div>
            </div>

            <div class="mb-3">
                <h3 class="mb-1">Noreply Credentials</h3>

                <div class="details">
                    <div class="key">Noreply Email</div>
                    <div class="value">{{ $project->liveCpanel->noreply_email }}</div>
                </div>

                <div class="details">
                    <div class="key">Noreply Password</div>
                    <div class="value">{{ $project->liveCpanel->noreply_password }}</div>
                </div>
            </div>

            <div>
                <h3 class="mb-1">Timestamps</h3>

                <div class="details">
                    <div class="key">Lived At</div>
                    <div class="value">{{ $project->liveCpanel->lived_at }}</div>
                </div>
            </div>
        </div>
        <!-- Live Tab -->
    </div>
    <!-- Tab Content -->

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('projects.destroy', ['project' => $project]) }}" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <p>This action cannot be undone!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel <i class="fas fa-ban fa-fw"></i></button>
                    <button type="submit" class="btn btn-danger">Delete <i class="fas fa-trash-alt fa-fw"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
