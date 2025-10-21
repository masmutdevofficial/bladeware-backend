@extends('layouts.main')
@section('customScript')
<script>
    // Fungsi untuk menangani Delete Modal
    $('#confirmDeleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var transactionId = button.data('id'); // Ambil ID dari tombol delete

        // Simpan ID produk dalam input hidden
        $('#deleteItemId').val(transactionId);

        // Atur URL action delete
        $('#confirmDelete').data('id', transactionId);
    });

    // Aksi konfirmasi hapus
    $('#confirmDelete').on('click', function() {
        var transactionId = $(this).data('id');
        $.ajax({
            url: '/admin/delete-transactions/' + transactionId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload(); // Refresh halaman setelah sukses
            },
            error: function(response) {
                alert('Error deleting transaction.');
            }
        });
    });
</script>

@endsection

@section('content')
<style>
/* Ensure all modal form text is black in transactions page */
.modal-content, .modal-content label, .modal-content .form-control, .modal-content .modal-title {
    color: #000 !important;
}
.modal-content ::placeholder { color: #000 !important; opacity: 1; }
</style>
<div class="card p-4">
        <div class="d-flex flex-row justify-content-between align-items-center mb-2">
            <h5 class="font-bold text-black">Transaction Records</h5>
        </div>
        <div class="d-flex flex-row justify-between w-100">
            <form method="GET" class="mb-2" style="width:100px;">
                <div class="d-flex align-items-center">
                    <select name="per_page" id="per_page" class="form-control w-auto" onchange="this.form.submit()">
                        @foreach([5, 10, 25, 50, 100] as $option)
                            <option value="{{ $option }}" {{ request('per_page', 10) == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
            <form method="GET" action="{{ route('admin.transactions') }}" class="mb-2 w-100">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-0 small text-black" placeholder="Search user or product..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-success mr-2" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                        <a href="{{ route('admin.transactions') }}" class="btn btn-success">
                            <i class="fas fa-sync-alt fa-sm"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="d-flex flex-row justify-between w-100 mt-2">
            <form method="GET" action="{{ route('admin.transactions') }}" class="form-inline mb-3">
                <label for="start_date" class="mr-2">From:</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control mr-2 text-black">
                
                <label for="end_date" class="mr-2">To:</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control mr-2 text-black">
            
                <button type="submit" class="btn btn-success">Filter</button>
            </form>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover">
                <thead class="bg-success text-white">
                    <tr>
                        <th style="text-align:center;">No</th>
                        <th style="text-align:center;">Name</th>
                        <th style="text-align:center;">Image</th>
                        <th style="text-align:center;">Product</th>
                        <th style="text-align:center;">Price</th>
                        <th style="text-align:center;">Profit</th>
                        <th style="text-align:center;">Created</th>
                        <th style="text-align:center;">Updated</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($transactions->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">No Transactions Available</td>
                        </tr>
                    @else
                        @foreach ($transactions as $key => $transaction)
                            <tr>
                                <td><span class="text-black">{{ $key + 1 }}</span></td>
                                <td><span class="text-black">{{ $transaction->user_name }}</span></td>
                                <td>
                                    <img src="{{ asset('storage/' . $transaction->product_image) }}" alt="Product Image" width="80">
                                </td>
                                <td><span class="text-black">{{ $transaction->product_name }}</span></td>
                                <td><span class="text-black">{{ number_format($transaction->price, 2, ',', '.') }}</span></td>
                                <td><span class="text-black">{{ number_format($transaction->profit, 2, ',', '.') }}</span></td>
                                <td><span class="text-black">{{ $transaction->created_at }}</span></td>
                                <td><span class="text-black">{{ $transaction->updated_at }}</span></td>
                                <td>
                                    <div class="d-flex flex-row justify-content-center align-items-center">
                                        <!-- Tombol Delete -->
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal"
                                            data-id="{{ $transaction->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            @if(method_exists($transactions, 'links'))
            <div class="mt-3 d-flex justify-content-center align-items-center">
                {{ $transactions->links('pagination::bootstrap-4') }}
            </div>
            @endif
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
