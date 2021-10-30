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
    @if(count($images) > 0)
    <div id="projects">
        @foreach($images as $image)
        <div class="card">
            <img src="{{ $image->getFile() }}" class="card-img-top" alt="{{ $image->name }}">
            <div class="card-body">
              <h5 class="card-title">{{ $image->name }}</h5>
              <p><span class="badge bg-secondary">/{{ $image->getFolderName() }}</span></p>
              <a href="{{ route('settings.images.edit', ['image' => $image]) }}" class="btn btn-primary">Edit Image <i class="fas fa-pen fa-fw"></i></a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-center"><em>No image data.</em></p>
    @endif

    {{ $images->links() }}
@endsection
