@extends('layouts.app')

@section('heading')
    <h1>Create Additional Data</h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('additionalDataGroup.index') }}">Additional Data</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Additional Data</li>
@endsection

@section('content')
    <form method="POST" action="{{ route('additionalDataGroup.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name*</label>
            <input type="text" class="form-control" name="name" id="name"
                value="{{ old('name') }}" placeholder="Name" required>
        </div>

        <h2>Additional Data</h2>
        <table id="addtionalDataTable" class="table">
            <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <td class="text-end" colspan="3">
                    <button type="button" class="btn btn-outline-primary btn-add">
                        <i class="fas fa-plus"></i>
                    </button>
                </td>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-end" colspan="3">
                        <button type="button" class="btn btn-outline-primary btn-add">
                            <i class="fas fa-plus"></i>
                        </button>
                    </td>
                </tr>
            </tfoot>
        </table>

        @include('components.errors')

        <p>* required fields</p>
        <div>
            <button type="submit" class="btn btn-primary">Submit <i class="fas fa-check fa-fw"></i></button>
            <a href="{{ route('additionalDataGroup.index') }}" class="btn btn-outline-secondary">Cancel <i class="fas fa-ban fa-fw"></i></a>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    let rows = 0;

    $(document).ready(() => {
        $('.btn-add').click(() => {
            $('#addtionalDataTable tbody').append(`
                <tr class="row-${rows}">
                    <td><input name="keys[]" type="text" class="form-control" required></td>
                    <td><input name="values[]" type="text" class="form-control" required></td>
                    <td class="text-end">
                        <button type="button" class="btn btn-outline-danger" onclick="$('.row-${rows}').remove()">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            `);
            rows++;
        });
    });
</script>
@endsection
