@extends('layouts.app')

@section('heading')
    <h1>
        Images
        <a href="{{ route('settings.images.create') }}" class="btn btn-outline-primary">Create <i class="fas fa-plus fa-fw"></i></a>
    </h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
    <li class="breadcrumb-item active" aria-current="page">Other Settings</li>
@endsection

@section('content')
    //
@endsection
