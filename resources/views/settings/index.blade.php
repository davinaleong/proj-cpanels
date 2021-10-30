@extends('layouts.app')

@section('heading')
    <h1>Settings</h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
@endsection

@section('content')
    <div class="setting-links">
        <a href="{{ route('settings.project-types.index') }}" class="ml-3">Project Types</a>
        <a href="{{ route('settings.folders.index') }}" class="ml-3">Folders</a>
        <a href="{{ route('settings.images.index') }}" class="ml-3">Images</a>
        <a href="{{ route('settings.other-settings.index') }}">Other Settings</a>
    </div>
@endsection
