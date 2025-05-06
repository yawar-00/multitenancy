
@extends('app.layout-backend.master')
@section('content')
<style>
    .addBanner{
        background-color:#00b894;
        color:#ffffff
        
    }
    .addBanner:hover{
        background-color:#016954;
    }
</style>
<!-- DataTables core CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">

<!-- DataTables Buttons Extension CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.2/css/buttons.dataTables.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<!-- DataTables core -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>

<!-- DataTables Buttons Extension -->
<script src="https://cdn.datatables.net/buttons/3.2.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.print.min.js"></script>

<!-- JSZip for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- pdfmake for PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.8.4/axios.min.js" integrity="sha512-2A1+/TAny5loNGk3RBbk11FwoKXYOMfAK6R7r4CpQH7Luz4pezqEGcfphoNzB7SM4dixUoJsKkBsB6kg+dNE2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="py-12">
    
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background-color:#bfc7a4">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <button type="button" class="btn addBanner mb-4" data-bs-toggle="modal" data-bs-target="#addHeroModal">
                 Add Banner
                </button>

        <div id="message"></div>

        <table id="bannerTable" class="table  table-bordered display nowrap">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="bannerTable">
                @forelse($banners as $index => $banner)
                <tr id="banner_{{ $banner->id }}">
                    <td>{{ $banner->id }}</td>
                    <td>
                        @if($banner->url)
                        <img src="/Upload/Banner/{{ basename($banner->url) }}" style="width: 120px; height: 60px; cursor:pointer;"
                            class="banner-img" alt="Image">
                        @else
                        No Image
                        @endif
                    </td>
                    
                    <td>{{ $banner->description }}</td>
                    <td>
                    <div class="form-check form-switch">
    <input
      class="form-check-input toggleStatus"
      type="checkbox"
      role="switch"
      data-id="{{ $banner->id }}"
      {{ $banner->status ? 'checked' : '' }}>
    </div>
                </td>
                    
           
                    <td>
                        <button class="btn btn-warning btn-sm editBannerBtn" data-id="{{ $banner->id }}"
                            data-bs-toggle="modal" data-bs-target="#editBannerModal">
                            Edit
                        </button>

                        <button class="btn btn-danger btn-sm deleteBannerBtn" data-id="{{ $banner->id }}">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No products found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addHeroModal" tabindex="-1" aria-labelledby="addHeroModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="HeroForm" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addHeroModalLabel">Add New Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group mb-3">
                        <div class="form-group mb-3">
                            <label>Image:</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required />
                            <span class="text-danger error-text image_error"></span>
                        </div>
                        <label>Description:</label>
                        <textarea name="description" class="form-control" required></textarea>
                        <span class="text-danger error-text description_error"></span>
                    </div>
                    
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <!-- Edit Banner Modal -->
<div class="modal fade" id="editBannerModal" tabindex="-1" aria-labelledby="editBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editBannerForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBannerModalLabel">Edit Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="editBannerId" name="id">
                    <div class="mb-3">
                        <label for="editBannerName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editBannerName" name="name">
                    </div>

                    <div class="mb-3">
                        <label for="editBannerDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editBannerDescription" name="description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="editBannerCategory" class="form-label">Category</label>
                        <select id="editBannerCategory" name="category_id" class="form-select">
                            <!-- Load categories dynamically -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editBannerImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="editBannerImage" name="image">
                        <img id="edit-preview-image" src="" class="img-fluid mt-2" style="max-height: 150px; display: none;" />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Bootstrap Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white" id="imagePreviewLabel">Image Preview</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="previewImage" src="" alt="Preview" class="img-fluid rounded">
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- Bootstrap JS (v5) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    new DataTable('#bannerTable', {
    layout: {
        topStart: {
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
    }
});
        // Show image in modal
$(document).on('click', '.product-img', function() {
    const imageUrl = $(this).attr('src');
    $('#previewImage').attr('src', imageUrl);
    $('#imagePreviewModal').modal('show');
});
        
        // Add Product AJAX
$('#HeroForm').submit(function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    $('.error-text').text('');

    $.ajax({
        url: "{{ url('/banners/save-item') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: response.success,
                timer: 2000,
                showConfirmButton: false
            });
            $('#addHeroModal').modal('hide');

    // Wait for modal to fully hide, then clean up body styles
        $('#addHeroModal').on('hidden.bs.modal', function () {
            $('body').removeClass('modal-open');
            $('body').css('overflow', 'auto');
            $('body').css('padding-right', '');
            $('.modal-backdrop').remove();
            
        });
        let newRow = `<tr id="banner_${response.banner.id}">                 
                <td>${response.banner.id}</td>                 
                <td><img height="60px" width="120px" src="${response.banner.image}" class="banner-img" alt="Image"></td>                 
                <td>${response.banner.description}</td>                 
                <td> 
                     <div class="form-check form-switch">
    <input
      class="form-check-input toggleStatus"
      type="checkbox"
      role="switch"
      data-id="${response.banner.id }"
      ${response.bannerstatus ? 'checked' : ''}>
    </div>
                </td>                 
                <td>                     
                    <button class="btn btn-warning btn-sm editBannerBtn" data-id="${response.banner.id}">Edit</button>                     
                    <button class="btn btn-danger btn-sm deleteBannerBtn" data-id="${response.banner.id}">Delete</button>                 
                </td>             
            </tr>`;

            $('#bannerTable').prepend(newRow);
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(field, messages) {
                    $(`.error-text.${field}_error`).text(messages[0]);
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Something went wrong.',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        }
    });
});
    
        // Edit Banner AJAX - Load Banner Data into Modal
        $(document).on('click', '.editBannerBtn', function() {
    let bannerId = $(this).data('id');
    
    $.ajax({
        url: `banners/${bannerId}/edit`,
        type: 'GET',
        success: function(response) {
           
            
            $('#editBannerId').val(response.banner.id);
            $('#editBannerDescription').val(response.banner.description);

            if (response.banner.image) {
                $('#edit-preview-image').attr('src', response.banner.image).show();
            } else {
                $('#edit-preview-image').hide();
            }
            $('#editBannerModal').show();
        }
    });
});

    // Update Banner AJAX
    $('#editBannerForm').on('submit', function(e) {
        e.preventDefault();

        let bannerId = $('#editBannerId').val();
        let formData = new FormData(this);

        $.ajax({
          
            url: `banner/${bannerId}/update`,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.success
                });

                $('#editBannerForm')[0].reset();
                $('#editBannerModal').modal('hide');

                // Optional safety: re-enable modal usability
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                // Update table data dynamically
                let row = $(`#banner_${response.banner.id}`);
                row.find('td:nth-child(2)').text(response.banner.name);
                row.find('td:nth-child(3)').text(response.banner.description);
                row.find('td:nth-child(4)').text(response.banner.category);
                let imageUrl = response.product.image;
                     imageUrl= imageUrl.split('/').pop();
                    imageUrl = '/Upload/Banner/'+imageUrl ;
                row.find('td:nth-child(5) img').attr('src', imageUrl);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        $(`.error-text.${field}_error`).text(messages[0]);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong while updating the product.'
                    });
                }
            }
        });
    });

       // toggle 
$(document).on('change', '.toggleStatus', function () {
    const bannerId = $(this).data('id');
    const newStatus = $(this).is(':checked') ? 1 : 0;

    axios.post(`/banners/makeActive/${bannerId}`, {
        status: newStatus
    }, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        Swal.fire('Success', response.data.message, 'success');

        // Reset all toggle buttons except the clicked one
        $('.toggleStatus').not(this).prop('checked', false);
    })
    .catch(error => {
        console.error(error);
        Swal.fire('Error', 'Could not update status.', 'error');
    });
});
       
        // Delete Product AJAX with Event Delegation
        $(document).on('click', '.deleteBannerBtn', function(e) {
            e.preventDefault();
            const bannerId = $(this).data('id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete the Banner permanently!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then(result => {
                if (result.isConfirmed) {
                    axios.delete(`banners/delete/${bannerId}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        Swal.fire('Deleted!', response.data.success, 'success');
                        $(`#banner_${bannerId}`).remove();
                    })
                    .catch(error => {
                        console.error(error);
                        Swal.fire('Error!', 'There was a problem deleting the Banner.', 'error');
                    });
                }
            });
        });
    </script>
@endsection