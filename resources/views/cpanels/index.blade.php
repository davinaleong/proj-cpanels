@extends('layouts.app')

@section('heading')
    <h1>
        CPanels
        <a href="{{ route('cpanels.create') }}" class="btn btn-outline-primary">Create <i class="fas fa-plus fa-fw"></i></a>
    </h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">CPanels</li>
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
                <th>Created At</th>
                <th>Updated At</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cpanels as $cpanel)
                <tr>
                    <td>{{ $cpanel->id }}</td>
                    <td>
                        <img src="{{ $cpanel->getImage() }}" alt="{{ $cpanel->name }}" class="img-thumbnail img-table">
                    </td>
                    <td>{{ $cpanel->name }}</td>
                    <td>{{ $cpanel->getProjectType() }}</td>
                    <td>{{ $cpanel->getCreatedAt() }}</td>
                    <td>{{ $cpanel->getUpdatedAt() }}</td>
                    <td>
                        <a href="#" class="btn btn-outline-primary">
                            Edit <i class="fa fa-pen fa-fw"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $cpanels->links() }}
@endsection
