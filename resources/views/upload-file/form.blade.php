<form name="form_default" id="form_default" autocomplete="off" method="POST" enctype="multipart/form-data" action="{{$url}}">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($data->id) ? $data->id : '' }}">
    <div class="mb-3">
        <label for="file_name" class="form-label">Upload File</label>
        <input type="file" class="form-control" id="file_name" name="file_name" value="{{ isset($data->file_name) ? $data->file_name : '' }}">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Keterangan</label>
        <textarea class="form-control" id="description" name="description" rows="3" >{{ isset($data->description) ? $data->description : '' }}</textarea>
    </div>
    <div class="text-end">
        <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal" aria-label="Close">
            Tutup
        </button>
    </div>
</form>
<script src="{{ asset('js/upload-file/form.js?v=' . rand(1,100)) }}"></script>