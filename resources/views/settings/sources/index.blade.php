@extends('layouts.app')

@section('heading')
    <h1>Sources</h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
    <li class="breadcrumb-item active" aria-current="page">Sources</li>
@endsection

@section('content')
    <div class="setting-links">
        <a href="#">Sources</a>
        <a href="#" class="ml-3">Project Types</a>
    </div>
@endsection
