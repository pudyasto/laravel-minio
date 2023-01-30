@extends('layouts.main')

@push('style-default')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.css"/>

@endpush

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="align-items-center">
                    <h4 class="mb-0">Upload File </h4>
                    <p>Upload file ke minio</p>
                </div>
                <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-title="Tambah Data" data-post-id="" data-action-url="upload-file/create" data-bs-target="#form-modal">Tambah</button>
                <button type="button" class="btn btn-dark btn-refresh">
                    Refresh
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0" id="tableMain">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Preview</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Deskripsi</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mime</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Size</th>
                                <th class="text-secondary opacity-7" style="width: 40px;"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-default')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.js"></script>
<script src="{{ asset('/js/upload-file/index.js?v=' . rand(1,100)) }}"></script>
@endpush