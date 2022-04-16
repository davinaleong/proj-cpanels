@extends('layouts.app')

@section('heading')
    <h1>Search</h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Search</li>
@endsection

@section('content')
    <p class="fst-italic">Search results for "{{ $term }}"</p>

    <h2 id="search-projects">Projects</h2>

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
                @foreach ($projects as $project)
                    <tr @if ($project->is_full_project) class="table-primary" @endif>
                        <td>{{ $project->id }}</td>
                        <td>
                            <img src="{{ $project->getImage() }}" alt="{{ $project->name }}"
                                class="img-thumbnail img-table">
                        </td>
                        <td>{{ $project->name }}</td>
                        <td>
                            @if ($project->projectType)
                                <span class="label"
                                    style="color: {{ $project->projectType->text_color }}; background-color: {{ $project->projectType->bg_color }}">{{ $project->projectType->name }}</span>
                            @endif
                        </td>
                        <td>
                            @if (filled($project->demoCpanel->site_url))
                                <span class="text-info">Active</span>
                            @endif
                        </td>
                        <td>
                            @if (filled($project->liveCpanel->site_url))
                                <span class="text-warning">Active</span>
                            @endif
                        </td>
                        <td>{{ $project->getCreatedAt() }}</td>
                        <td>{{ $project->getUpdatedAt() }}</td>
                        <td>
                            <a href="{{ route('projects.show', ['project' => $project]) }}"
                                class="btn btn-outline-primary">
                                <i class="fa fa-eye fa-fw"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2 id="search-cpanels">CPanels</h2>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Thumbnail</th>
                    <th>Name</th>
                    <th>Project Type</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cpanels as $cpanel)
                    <tr>
                        <td>{{ $cpanel->id }}</td>
                        <td>
                            <img src="{{ $cpanel->getImage() }}" alt="{{ $cpanel->name }}"
                                class="img-thumbnail img-table">
                        </td>
                        <td>{{ $cpanel->name }}</td>
                        <td>
                            @if ($cpanel->projectType)
                                <span class="label"
                                    style="color: {{ $cpanel->projectType->text_color }}; background-color: {{ $cpanel->projectType->bg_color }}">{{ $cpanel->projectType->name }}</span>
                            @endif
                        </td>
                        <td>{{ $cpanel->getCreatedAt() }}</td>
                        <td>{{ $cpanel->getUpdatedAt() }}</td>
                        <td>
                            <a href="{{ route('cpanels.show', ['cpanel' => $cpanel]) }}" class="btn btn-outline-primary">
                                <i class="fa fa-eye fa-fw"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2 id="search-additional-data">Additional Data</h2>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($additionalDataGroups as $additionalDataGroup)
                    <tr>
                        <td>{{ $additionalDataGroup->id }}</td>
                        <td>{{ $additionalDataGroup->name }}</td>
                        <td>{{ $additionalDataGroup->getCreatedAt() }}</td>
                        <td>{{ $additionalDataGroup->getUpdatedAt() }}</td>
                        <td>
                            <a href="{{ route('additionalDataGroup.edit', ['additionalDataGroup' => $additionalDataGroup]) }}"
                                class="btn btn-outline-primary">
                                <i class="fa fa-eye fa-fw"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <ul id="search-nav" class="nav flex-column bg-light p-2 position-fixed">
        <li class="nav-item">
            <a class="nav-link" href="#search-projects">Projects</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#search-cpanels">CPanels</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#search-additional-data">Additional Data</a>
        </li>
    </ul>
@endsection
