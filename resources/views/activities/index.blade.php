@extends('layouts.app')

@section('heading')
    <h1>Activity</h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Activity</li>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Log</th>
                <th>Timestamp</th>
            </tr>
            </thead>
            <tbody>
            @foreach($activities as $activity)
                <tr>
                    <td>
                        {{ $activity->log }}
                        @if ($activity->label && $activity->link)
                            <a href="{{ $activity->link }}">{{ $activity->label }}</a>
                        @endif
                    </td>
                    <td>{{ $activity->getCreatedAt() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $activities->links() }}
@endsection
