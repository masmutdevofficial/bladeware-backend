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
<div class="card p-4">
        <div class="d-flex flex-row justify-content-between align-items-center mb-2">
            <h5 class="font-bold">Transaction Records</h5>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Profit</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Action</th>
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
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $transaction->user_name }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $transaction->product_image) }}" alt="Product Image" width="80">
                                </td>
                                <td>{{ $transaction->product_name }}</td>
                                <td>{{ number_format($transaction->price, 2, ',', '.') }}</td>
                                <td>{{ number_format($transaction->profit, 2, ',', '.') }}</td>
                                <td>{{ $transaction->created_at }}</td>
                                <td>{{ $transaction->updated_at }}</td>
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
</div>
@endsection
