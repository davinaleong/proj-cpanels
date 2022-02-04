@extends('layouts.app')

@section('heading')
    <h1>
        Edit Additional Data
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            Delete <i class="fas fa-trash-alt fa-fw"></i>
        </button>
    </h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('additionalDataGroup.index') }}">Additional Data</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Additional Data</li>
@endsection

@section('content')
    <form method="POST" action="{{ route('additionalDataGroup.update', ['additionalDataGroup' => $additionalDataGroup]) }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="name" class="form-label">Name*</label>
            <input type="text" class="form-control" name="name" id="name"
                value="{{ old('name') ? old('name') : $additionalDataGroup->name }}" placeholder="Name" required>
        </div>

        <h2>Additional Data</h2>
        <table id="addtionalDataTable" class="table">
            <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
                <th class="text-end">
                    <button type="button" class="btn btn-outline-primary btn-add">
                        <i class="fas fa-plus"></i>
                    </button>
                </th>
            </tr>
            </thead>
            <tbody>
                @foreach ($additionalDataGroup->additionalData as $key=>$additionalData)
                <tr class="row-{{ $key }}">
                    <td>
                        <input name="keys[]" type="text" class="form-control" value="{{ $additionalData->key }}" required>
                    </td>
                    <td>
                        <input name="values[]" type="text" class="form-control" value="{{ $additionalData->value }}" required>
                    </td>
                    <td class="text-end">
                        <button type="button" class="btn btn-outline-danger" onclick="$('.row-{{ $key }}').remove()">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
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

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('additionalDataGroup.destroy', ['additionalDataGroup' => $additionalDataGroup]) }}" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Additional Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <p>This action cannot be undone!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel <i class="fas fa-ban fa-fw"></i></button>
                    <button type="submit" class="btn btn-danger">Delete <i class="fas fa-trash-alt fa-fw"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let rows = {{ $additionalDataRow }};

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
