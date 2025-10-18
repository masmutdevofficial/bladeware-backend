@extends('layouts.main')
@section('customScript')
<script>
    // Fungsi untuk menangani Edit Modal
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Tombol yang diklik
        var product = button.data('product'); // Ambil data produk dari tombol
    
        // Isi form edit dengan data produk
        $('#edit_product_id').val(product.id);
        $('#edit_product_name').val(product.product_name);
        $('#edit_status').val(product.status);
    
        // Atur action form edit dengan ID produk
        var formAction = "{{ route('admin.edit-products', ':id') }}";
        formAction = formAction.replace(':id', product.id);
        $('#editForm').attr('action', formAction);
    
        // Tampilkan gambar preview
        if (product.image) {
            $('#preview_edit_image')
                .attr('src', '/uploads/products/' + product.image)
                .removeClass('d-none');
        } else {
            $('#preview_edit_image').addClass('d-none');
        }
    });

    // Fungsi untuk menangani Delete Modal
    $('#confirmDeleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var productId = button.data('id'); // Ambil ID dari tombol delete

        // Simpan ID produk dalam input hidden
        $('#deleteItemId').val(productId);

        // Atur URL action delete
        $('#confirmDelete').data('id', productId);
    });

    // Aksi konfirmasi hapus
    $('#confirmDelete').on('click', function() {
        var productId = $(this).data('id');
        $.ajax({
            url: '/admin/delete-products/' + productId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload(); // Refresh halaman setelah sukses
            },
            error: function(response) {
                alert('Error deleting product.');
            }
        });
    });
    
    $('#edit_product_image').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview_edit_image')
                    .attr('src', e.target.result)
                    .removeClass('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection

@section('content')
<div class="card p-4">
        <div class="d-flex flex-row justify-content-between align-items-center mb-2">
            <h5 class="font-bold">Products Records</h5>
            @if(Auth::user()->level == 0)
            <!-- Button untuk Membuka Modal -->
            <button class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
                <i class="fa fa-plus mr-2"></i>
                Add Products
            </button>
            @endif
        </div>
        <!--<div class="d-flex flex-row justify-between w-100">-->
        <!--    <form method="GET" class="mb-2" style="width:100px;">-->
        <!--        <div class="d-flex align-items-center">-->
        <!--            <select name="per_page" id="per_page" class="form-control w-auto" onchange="this.form.submit()">-->
        <!--                @foreach([5, 10, 25, 50, 100] as $option)-->
        <!--                    <option value="{{ $option }}" {{ request('per_page', 5) == $option ? 'selected' : '' }}>-->
        <!--                        {{ $option }}-->
        <!--                    </option>-->
        <!--                @endforeach-->
        <!--            </select>-->
        <!--        </div>-->
        <!--    </form>-->
        <!--    <form method="GET" action="{{ route('admin.products') }}" class="mb-2 w-100">-->
        <!--        <div class="input-group">-->
        <!--            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Search Product ID..." value="{{ request('search') }}">-->
        <!--            <div class="input-group-append">-->
        <!--                <button class="btn btn-primary mr-2" type="submit">-->
        <!--                    <i class="fas fa-search fa-sm"></i>-->
        <!--                </button>-->
        <!--                <a href="{{ route('admin.products') }}" class="btn btn-secondary">-->
        <!--                    <i class="fas fa-sync-alt fa-sm"></i>-->
        <!--                </a>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </form>-->
        <!--</div>-->
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align:center;">ID</th>
                        <th style="text-align:center;">Product Image</th>
                        <th style="text-align:center;">Product Name</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($products->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center">No Data Available</td>
                        </tr>
                    @else
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <!-- Kolom Gambar -->
                            <td>
                                @if($product->product_image)
                                    <img src="{{ asset('uploads/products/' . $product->product_image) }}" alt="Product Image" width="80" class="img-thumbnail">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td><span class="text-black">{{ $product->product_name }}</span></td>
                            <td>
                                @if($product->status == 1)
                                    <span class="badge badge-success w-100">Active</span>
                                @else
                                    <span class="badge badge-danger w-100">NonActive</span>
                                @endif
                            </td>
                            <td>
                                @if(Auth::user()->level == 0)
                                <div class="d-flex flex-row justify-content-center align-items-center">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-warning mr-2" data-toggle="modal" data-target="#editModal"
                                        data-product='@json($product)'>
                                        <i class="fa fa-edit"></i>
                                    </button>
                    
                                    <!-- Tombol Delete -->
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal"
                                        data-id="{{ $product->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @else
                                <div class="d-flex flex-row justify-content-center align-items-center">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-warning mr-2">
                                        <i class="fa fa-edit"></i>
                                    </button>
                    
                                    <!-- Tombol Delete -->
                                    <button class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        @if(Auth::user()->level == 0)
        <!-- Add Modal -->
        <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('admin.add-products') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Product Image -->
                            <div class="form-group">
                                <label for="product_image">Product Image</label>
                                <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*">
                            </div>
                            
                            <!-- Product Name -->
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" required>
                            </div>

                            <!-- Product Status -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">NonActive</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Product -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="POST" id="editForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_product_id" name="product_id"> <!-- Hidden input untuk ID produk -->

                        <div class="modal-body">
                            
                            <!-- Product Image -->
                            <div class="form-group">
                                <!-- Preview Image -->
                                <div class="mb-2">
                                    <img id="preview_edit_image" src="" alt="Preview Image" width="100" class="img-thumbnail d-none">
                                </div>
                                
                                <label for="edit_product_image">Product Image</label>
                                <input type="file" class="form-control" id="edit_product_image" name="product_image" accept="image/*">
                            </div>
                            
                            <!-- Product Name -->
                            <div class="form-group">
                                <label for="edit_product_name">Product Name</label>
                                <input type="text" class="form-control" id="edit_product_name" name="product_name" required>
                            </div>
                            <!-- Product Status -->
                            <div class="form-group">
                                <label for="edit_status">Status</label>
                                <select class="form-control" id="edit_status" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">NonActive</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Confirm Delete -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this data?</p>
                        <input type="hidden" id="deleteItemId" value=""> <!-- Menyimpan ID data yang akan dihapus -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
</div>
@endsection
