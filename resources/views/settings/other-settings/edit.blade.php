@extends('layouts.app')

@section('heading')
    <h1>Edit Other Settings</h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
    <li class="breadcrumb-item"><a href="{{ route('settings.other-settings.index') }}">Other Settings</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
    <form method="POST" action="{{ route('settings.other-settings.update') }}">
        @csrf

        <div class="table-responsive">
            <table id="other-settings-table" class="table">
                <thead>
                <tr>
                    <th>Key</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                @foreach($otherSettings as $key=>$otherSetting)
                    <tr>
                        <td>
                            <input type="text" name="otherSettings[{{ $key }}][key]"
                                   class="form-control" value="{{ $otherSetting->key }}"
                                   placeholder="Key*" required>
                        </td>
                        <td>
                            <input type="text" name="otherSettings[{{ $key }}][value]"
                                   class="form-control" value="{{ $otherSetting->value }}"
                                   placeholder="Value*" required>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-end">
                            <button type="button" class="btn btn-outline-primary" onclick="addRow()">
                                <i class="fa fa-plus fa-fw"></i>
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        @include('components.errors')

        <div>
            <button type="submit" class="btn btn-primary">Submit <i class="fa fa-pen fa-fw"></i></button>
            <a href="{{ route('settings.other-settings.index') }}" class="btn btn-outline-secondary">Cancel <i class="fa fa-ban fa-fw"></i></a>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        let key = {{ $otherSettingsCount }};

        function addRow() {
            const newRow = `
                <tr>
                    <td>
                        <input type="text" name="otherSettings[${key}][key]"
                               class="form-control" value=""
                               placeholder="Key*" required>
                    </td>
                    <td>
                        <input type="text" name="otherSettings[${key}][value]"
                               class="form-control" value=""
                               placeholder="Value*" required>
                    </td>
                </tr>
            `;
            $("#other-settings-table tbody").append(newRow);

            key++;
        }
    </script>
@endsection
