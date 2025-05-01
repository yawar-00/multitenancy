@extends('app.layout-backend.master')

@section('content')
<style>
    .form-container {
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
    }
    .table{
        margin-top:25px!important;
    }
    .dataTables_wrapper .dataTables_length select {
        width :60px
    }
    .btnSaveAbout{
        background-color:#00b894;
        color:#ffffff
    }
    .btnSaveAbout:hover{
        background-color:#016954;
    }
</style>

<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Manage About Us</h1>

    {{-- Add / Edit Form --}}
    <div class="form-container">
        <form id="aboutForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="about_id">

            <textarea name="content" id="editor"></textarea><br>

            <input type="file" name="image" class="form-control mt-2" id="imageInput">
            <img id="previewImage" src="" width="100" class="mt-2 d-none"><br>

            <button type="submit" class="btn btnSaveAbout mt-2">Save</button>
        </form>
    </div>
    
    <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background-color:#bfc7a4">
        <div class="p-6 text-gray-900 dark:text-gray-100">
        <table class="table table-bordered " id="aboutTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($abouts as $about)
                <tr>
                    <td>{{ $about->id }}</td>
                    <td><img src="{{ asset('storage/' . $about->image) }}" width="80"></td>
                    <td>{!! Str::limit(strip_tags($about->content), 60) !!}</td>
                    <td>
                        <input type="checkbox" class="toggle-status" data-id="{{ $about->id }}" {{ $about->status ? 'checked' : '' }}>
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm edit-btn" data-id="{{ $about->id }}">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $about->id }}">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>



{{-- Styles & Scripts --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@3.24.5/build/jodit.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jodit@3.24.5/build/jodit.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function () {
        $('#aboutTable').DataTable();

        const editor = new Jodit('#editor', {
    defaultMode: Jodit.MODE_WYSIWYG,
    style: {
        color: 'black',
        backgroundColor: 'white',   
    },
    iframe: false,
    theme: 'default'
});

        // AJAX Save / Update
        $('#aboutForm').on('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: '{{ url("/admin/about-us/store") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    location.reload();
                },
                error: function (xhr) {
                    alert('Something went wrong');
                    console.error(xhr.responseText);
                }
            });
        });

        // AJAX Delete
        $('.delete-btn').on('click', function () {
            const id = $(this).data('id');
            if (confirm('Delete this entry?')) {
                $.ajax({
                    url: `/admin/about-us/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        alert('Deleted successfully!');
                        location.reload();
                    },
                    error: function () {
                        alert('Error deleting entry');
                    }
                });
            }
        });

        // AJAX Edit
        $('.edit-btn').on('click', function () {
            const id = $(this).data('id');
            $.get(`/admin/about-us/${id}`, function (res) {
                editor.value = res.content;
                $('#about_id').val(res.id);
                if (res.image) {
                    $('#previewImage').attr('src', '/storage/' + res.image).removeClass('d-none');
                } else {
                    $('#previewImage').addClass('d-none');
                }
            });
        });

        // AJAX Status Toggle
        $('.toggle-status').on('change', function () {
            const id = $(this).data('id');
            $.post(`/admin/about-us/toggle-status/${id}`, {
                _token: '{{ csrf_token() }}'
            }, function (res) {
                console.log(res.message);
            });
        });
    });
</script>
@endsection
