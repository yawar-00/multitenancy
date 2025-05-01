<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.9.0/axios.min.js" integrity="sha512-FPlUpimug7gt7Hn7swE8N2pHw/+oQMq/+R/hH/2hZ43VOQ+Kjh25rQzuLyPz7aUWKlRpI7wXbY6+U3oFPGjPOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@extends('app.layout-backend.master')
@section('content')
<style>
    .addproductBtn{
        background-color:#00b894;
        color:#ffffff
    }
    .addproductBtn:hover{
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
                <button type="button" class="btn addproductBtn mb-4" data-bs-toggle="modal" data-bs-target="#addProductModal">
                 Add Product
                </button>

        <div id="message"></div>

        <table class="table  table-bordered" id="productsTable">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productTable">
                @forelse($products as $index => $product)
                <tr id="product_{{ $product->id }}">
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        @if($product->image)
                        <img src="{{asset($product->image) }}" style="width: 120px; height: 60px; cursor:pointer;"
                            class="product-img" alt="Image">
                        @else
                        No Image
                        @endif
                    </td>
                    <td>{{ $product->category->category_name}}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->description }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm editProductBtn" data-id="{{ $product->id }}"
                            data-bs-toggle="modal" data-bs-target="#editProductModal">
                            Edit
                        </button>

                        <button class="btn btn-danger btn-sm deleteProductBtn" data-id="{{ $product->id }}">
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
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="productForm" enctype="multipart/form-data" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Name:</label>
                        <input type="text" name="name" class="form-control" required />
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Description:</label>
                        <textarea name="description" class="form-control" required></textarea>
                        <span class="text-danger error-text description_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Category:</label>
                        <select name="category" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            <option value="1">Electronics</option>
                            <option value="2">Cosmetics</option>
                            <option value="3">Home Decor</option>
                            <option value="4">Kitchen Item</option>
                            <option value="5">Grocery</option>
                        </select>
                        <span class="text-danger error-text category_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Price:</label>
                        <input name="price" class="form-control" required />
                        <span class="text-danger error-text price_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Image:</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required />
                        <span class="text-danger error-text image_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="editProductForm" enctype="multipart/form-data" class="modal-content">
                <input type="hidden" name="product_id" id="editProductId">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Name:</label>
                        <input type="text" name="name" id="editProductName" class="form-control" required />
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Description:</label>
                        <textarea name="description" id="editProductDescription" class="form-control"
                            required></textarea>
                        <span class="text-danger error-text description_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Category:</label>
                        <select name="category" class="form-control" id="editProductCategory" required>
                            <option value="">-- Select Category --</option>
                            <option value="1">Electronics</option>
                            <option value="2">Cosmetics</option>
                            <option value="3">Home Decor</option>
                            <option value="4">Kitchen Item</option>
                            <option value="5">Grocery</option>
                        </select>
                        <span class="text-danger error-text category_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label>Price:</label>
                        <input name="price" class="form-control" required id="editProductPrice"/>
                        <span class="text-danger error-text price_error"></span>
                    </div>

                    <div class="form-group mb-3">
                        <label>Image:</label>

                        <!-- Image preview -->
                        <div id="image-preview" class="mb-2">
                            <img id="edit-preview-image" src="" alt="Current Image"
                                style="max-width: 200px; height: auto; display: none;" />
                        </div>

                        <!-- File input -->
                        <input type="file" name="image" class="form-control" accept="image/*" />
                        <span class="text-danger error-text image_error"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update Product</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        new DataTable('#productsTable', {
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
        $('#productForm').submit(function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    $('.error-text').text('');

    $.ajax({
        url: "{{ url('/dashboard/products/save-item') }}",
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
            $('#addProductModal').modal('hide');

    // Wait for modal to fully hide, then clean up body styles
        $('#addProductModal').on('hidden.bs.modal', function () {
            $('body').removeClass('modal-open');
            $('body').css('overflow', 'auto');
            $('body').css('padding-right', '');
            $('.modal-backdrop').remove();
        });
            let newRow = `<tr id="product_${response.product.id}">
                <td>${response.product.id}</td>
                <td>${response.product.name}</td>
                <td><img height="60px" width="120px" src="${response.product.image}" class="product-img" alt="Image"></td>
                <td>${response.product.category}</td>
                <td>${response.product.price}</td>
                <td>${response.product.description}</td>
                <td>
                    <button class="btn btn-warning btn-sm editProductBtn" data-id="${response.product.id}">Edit</button>
                    <button class="btn btn-danger btn-sm deleteProductBtn" data-id="${response.product.id}">Delete</button>
                </td>
            </tr>`;
            $('#productTable').prepend(newRow);
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
    
        // Edit Product AJAX - Load Product Data into Modal
        $(document).on('click', '.editProductBtn', function() {
            let productId = $(this).data('id');
            // console.log(url);
            
            $.ajax({
                url: `products/${productId}/edit`,
                type: 'GET',
                
                success: function(response) {
                    $('#editProductId').val(response.product.id);
                    $('#editProductName').val(response.product.name);
                    $('#editProductDescription').val(response.product.description);
                    $('#editProductCategory').val(response.product.category_id);
                    $('#editProductPrice').val(response.product.price);
                    // Set the image preview
                    if (response.product.image) {
                        $('#edit-preview-image').attr('src', response.product.image).show();
                    } else {
                        $('#edit-preview-image').hide();
                    }
                    $('#editProductModal').modal('show');
                }
            });
        });
    
        // Update Product AJAX
        $('#editProductForm').on('submit', function(e) {
        e.preventDefault();

        let productId = $('#editProductId').val();
        let formData = new FormData(this);

        $.ajax({
            url: `products/${productId}/update`,
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

                $('#editProductForm')[0].reset();
                $('#editProductModal').modal('hide');

                // Optional safety: re-enable modal usability
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                // Update table data dynamically
                let row = $(`#product_${response.product.id}`);
                row.find('td:nth-child(2)').text(response.product.name);
                row.find('td:nth-child(3) img').attr('src', response.product.image);
                row.find('td:nth-child(4)').text(response.product.category);
                row.find('td:nth-child(5)').text(response.product.price);
                row.find('td:nth-child(6)').text(response.product.description);
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

    
        // Delete Product AJAX with Event Delegation
        $(document).on('click', '.deleteProductBtn', function(e) {
            e.preventDefault();
            const productId = $(this).data('id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete the product permanently!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then(result => {
                if (result.isConfirmed) {
                    axios.delete(`/products/delete/${productId}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        Swal.fire('Deleted!', response.data.success, 'success');
                        $(`#product_${productId}`).remove();
                    })
                    .catch(error => {
                        console.error(error);
                        Swal.fire('Error!', 'There was a problem deleting the product.', 'error');
                    });
                }
            });
        });
    </script>
@endsection