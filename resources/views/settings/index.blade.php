@extends('layouts.app')

@section('heading')
    <h1>Settings</h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
@endsection

@section('content')
    <div class="setting-links">
        <a href="{{ route('settings.sources.index') }}">Sources</a>
        <a href="#" class="ml-3">Project Types</a>
    </div>
@endsection
