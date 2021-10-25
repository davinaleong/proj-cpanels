@extends('layouts.app')

@section('heading')
    <h1>
        Other Settings
        <a href="{{ route('settings.other-settings.edit') }}" class="btn btn-outline-primary">Add / Edit <i class="fas fa-pen fa-fw"></i></a>
    </h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
    <li class="breadcrumb-item active" aria-current="page">Other Settings</li>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
            </tr>
            </thead>
            <tbody>
            @forelse($otherSettings as $otherSetting)
                <tr>
                    <td>{{ $otherSetting->key }}</td>
                    <td>{{ $otherSetting->value }}</td>
                </tr>
            @empty
            <tr>
                <td colspan="2" class="text-center text-italic">There are no settings.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
