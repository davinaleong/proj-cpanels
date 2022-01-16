@extends('layouts.app')

@section('heading')
    <h1>
        Projects
        <a href="{{ route('projects.create') }}" class="btn btn-outline-primary">Create <i class="fas fa-plus fa-fw"></i></a>
    </h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Projects</li>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Thumbnail</th>
                <th>Name</th>
                <th>Project Type</th>
                <th>Demo</th>
                <th>Live</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr @if($projects->is_full_project)class="table-primary"@endif>
                    <td>{{ $project->id }}</td>
                    <td>
                        <img src="{{ $project->getImage() }}" alt="{{ $project->name }}" class="img-thumbnail img-table">
                    </td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->getProjectTypeName() }}</td>
                    <td>
                        @if(filled($project->demoCpanel))
                        <span class="text-info">Active</span>
                        @endif
                    </td>
                    <td>
                        @if(filled($project->liveCpanel))
                        <span class="text-info">Active</span>
                        @endif
                    </td>
                    <td>{{ $project->getCreatedAt() }}</td>
                    <td>{{ $project->getUpdatedAt() }}</td>
                    <td>
                        <a href="{{ route('projects.show', ['project' => $project]) }}" class="btn btn-outline-primary">
                            <i class="fa fa-eye fa-fw"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $projects->links() }}
@endsection
