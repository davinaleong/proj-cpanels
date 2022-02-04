@extends('layouts.app')

@section('heading')
    <h1>
        Additional Data
        <a href="{{ route('additionalDataGroup.create') }}" class="btn btn-outline-primary">Create <i class="fas fa-plus fa-fw"></i></a>
    </h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Additional Data</li>
@endsection

@section('content')
    @foreach($additionalDataGroups as $additionalDataGroup)
        <div class="mb-3">
            <h2 class="h4">
                {{ $additionalDataGroup->name }}
                <a href="{{ route('additionalDataGroup.edit', ['additionalDataGroup' => $additionalDataGroup]) }}" class="btn btn-outline-primary"><i class="fas fa-pen fa-fw"></i></a>
            </h2>
            <div class="additional-data">
                @foreach($additionalDataGroup->additionalData as $additionalData)
                <div class="text-break"><strong>{{ $additionalData->key }}:</strong> {{ $additionalData->value }}</div>
                @endforeach
            </div>
            <hr>
        </div>
    @endforeach

    {{ $additionalDataGroups->links() }}
@endsection
