@extends('layouts.main')
@section('customScript')
<script>
    // Fungsi untuk menangani Edit Modal
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Tombol yang diklik
        var deposit = button.data('deposit'); // Ambil data produk dari tombol

        // Isi form edit dengan data produk
        $('#edit_deposit_id').val(deposit.id);
        $('#edit_currency').val(deposit.currency);
        $('#edit_network_address').val(deposit.network_address);
        $('#edit_wallet_address').val(deposit.wallet_address);
        $('#edit_amount').val(deposit.amount);
        $('#edit_status').val(deposit.status);
        $('#edit_jenis').val(deposit.category_deposit);
        if (deposit.deposit_image) {
            $('#edit_preview_image').attr('src', '/storage/' + deposit.deposit_image);
        } else {
            $('#edit_preview_image').attr('src', '/assets/img/empty.png');
        }

        // Atur action form edit dengan ID produk
        var formAction = "{{ route('admin.edit-deposits', ':id') }}";
        formAction = formAction.replace(':id', deposit.id);
        $('#editForm').attr('action', formAction);
    });

    // Fungsi untuk menangani Delete Modal
    $('#confirmDeleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var depositId = button.data('id'); // Ambil ID dari tombol delete

        // Simpan ID produk dalam input hidden
        $('#deleteItemId').val(depositId);

        // Atur URL action delete
        $('#confirmDelete').data('id', depositId);
    });

    // Aksi konfirmasi hapus
    $('#confirmDelete').on('click', function() {
        var depositId = $(this).data('id');
        $.ajax({
            url: '/admin/delete-deposits/' + depositId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload(); // Refresh halaman setelah sukses
            },
            error: function(response) {
                alert('Error deleting deposit.');
            }
        });
    });
</script>

@endsection

@section('content')
<style>
/* Ensure all modal form text is black in deposit page */
.modal-content, .modal-content label, .modal-content .form-control, .modal-content .modal-title {
    color: #000 !important;
}
.modal-content ::placeholder { color: #000 !important; opacity: 1; }
</style>
<div class="card p-4">
        <div class="d-flex flex-row justify-content-between align-items-center mb-2">
            <h5 class="font-bold text-black">Deposit Records</h5>
        </div>
        <div class="d-flex flex-row justify-between w-100">
            <form method="GET" class="mb-2" style="width:100px;">
                <div class="d-flex align-items-center">
                    <select name="per_page" id="per_page" class="form-control w-auto" onchange="this.form.submit()">
                        @foreach([5, 10, 25, 50, 100] as $option)
                            <option value="{{ $option }}" {{ request('per_page', 5) == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
            <form method="GET" action="{{ route('admin.deposits') }}" class="mb-2 w-100">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-0 small text-black" placeholder="Search Name..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-success text-white mr-2" type="submit">
                            <i class="fas fa-search fa-sm text-white"></i>
                        </button>
                        <a href="{{ route('admin.deposits') }}" class="btn btn-success text-white">
                            <i class="fas fa-sync-alt fa-sm text-white"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="d-flex flex-row justify-between w-100 mt-4">
            <form method="GET" class="form-inline mb-3">
                <label for="start_date" class="mr-2">From:</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control mr-2 text-black">
                
                <label for="end_date" class="mr-2">To:</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control mr-2 text-black">
            
                <button type="submit" class="btn btn-success text-white">Filter</button>
            </form>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover">
                <thead class="bg-success text-white">
                    <tr>
                        <th style="text-align:center;">No</th>
                        <th style="text-align:center;">Users</th>
                        <th style="text-align:center;">Amount</th>
                        <th style="text-align:center;">Type</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:center;">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($deposits->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No Data Available</td>
                        </tr>
                    @else
                        @foreach ($deposits as $key => $deposit)
                        <tr>
                            <td><span class="text-black">{{ $key + 1 }}</span></td>

                            <td><span class="text-black">{{ $deposit->name }}</span></td>
                            <td><span class="text-black">{{ number_format($deposit->amount, 2, '.', ',') }}</span></td>
                            <td><span class="text-black">{{ $deposit->category_deposit == 'Bonus' ? 'Rewards' : $deposit->category_deposit }}</span></td>
                            <td>
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                @if($deposit->status == 1)
                                    <span class="badge badge-success" style="width:120px;color:white!important;">Succeed</span>
                                @else
                                    <span class="badge badge-danger" style="width:120px;color:white!important;">Rejected</span>
                                @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <span class="text-black">{{ $deposit->created_at }}</span>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="mt-3 d-flex justify-content-center align-items-center">
                {{ $deposits->links('pagination::bootstrap-4') }}
            </div>
        </div>

        @if(Auth::user()->level == 0)
        <!-- Add Modal -->
        <div class="modal fade" id="addDepositModal" tabindex="-1" role="dialog" aria-labelledby="addDepositModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDepositModalLabel">Add New Deposit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('admin.add-deposits') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Select Users -->
                            <div class="form-group">
                                <label for="id_users">Select Users</label>
                                <select class="form-control" id="id_users" name="id_users">
                                    <option value="" selected>Choose Users</option>
                                    @foreach ($dataUser as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Currency -->
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <select class="form-control" id="currency" name="currency" required>
                                    <option value="" selected>Choose Currency</option>
                                    <option value="Paypal USD">Paypal USD</option>
                                    <option value="USDC">USDC</option>
                                    <option value="ETH">ETH</option>
                                    <option value="BTC">BTC</option>
                                </select>
                            </div>

                            <!-- Network Address -->
                            <div class="form-group">
                                <label for="network_address">Network Address</label>
                                <select class="form-control" id="network_address" name="network_address" required>
                                    <option value="" selected>Choose Network Address</option>
                                    <option value="ERC-20">ERC-20</option>
                                    <option value="SOL">SOL</option>
                                    <option value="Polygon">Polygon</option>
                                    <option value="BTC">BTC</option>
                                </select>
                            </div>


                            <!-- Wallet Address -->
                            <div class="form-group">
                                <label for="wallet_address">Wallet Address</label>
                                <input type="text" class="form-control" id="wallet_address" name="wallet_address" required>
                            </div>

                            <!-- Deposit Amount -->
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                            
                            <!-- Deposit Type -->
                            <div class="form-group">
                                <label for="currency">Deposit Type</label>
                                <select class="form-control" id="currency" name="category_deposit" required>
                                    <option value="" selected>Choose Deposit Type</option>
                                    <option value="Deposit">Deposit</option>
                                    <option value="Bonus">Rewards</option>
                                </select>
                            </div>
                            
                            <!-- Deposit Status -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1">Succeed</option>
                                    <option value="0">Rejected</option>
                                </select>
                            </div>

                            <!-- Deposit Image -->
                            <div class="form-group">
                                <label for="deposit_image">Deposit Image</label>
                                <input type="file" class="form-control-file" id="deposit_image" name="deposit_image">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Deposit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Deposit -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Deposit</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="POST" id="editForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_deposit_id" name="deposit_id"> <!-- Hidden input untuk ID produk -->

                        <div class="modal-body">

                            <!-- Currency -->
                            <div class="form-group">
                                <label for="edit_currency">Currency</label>
                                <input type="text" class="form-control" id="edit_currency" name="currency" required>
                            </div>

                            <!-- Network Address -->
                            <div class="form-group">
                                <label for="edit_network_address">Network Address</label>
                                <input type="text" class="form-control" id="edit_network_address" name="network_address" required>
                            </div>

                            <!-- Wallet Address -->
                            <div class="form-group">
                                <label for="edit_wallet_address">Wallet Address</label>
                                <input type="text" class="form-control" id="edit_wallet_address" name="wallet_address" required>
                            </div>

                            <!-- Deposit Amount -->
                            <div class="form-group">
                                <label for="edit_amount">Amount</label>
                                <input type="number" class="form-control" id="edit_amount" name="amount" required>
                            </div>
                            
                            <!-- Deposit Type -->
                            <div class="form-group">
                                <label for="edit_jenis">Deposit Type</label>
                                <select class="form-control" id="edit_jenis" name="category_deposit" required>
                                    <option value="">Choose Deposit Type</option>
                                    <option value="Deposit">Deposit</option>
                                    <option value="Bonus">Rewards</option>
                                </select>
                            </div>
                            
                            <!-- Deposit Status -->
                            <div class="form-group">
                                <label for="edit_status">Status</label>
                                <select class="form-control" id="edit_status" name="status">
                                    <option value="1">Succeed</option>
                                    <option value="0">Rejected</option>
                                </select>
                            </div>

                            <!-- Deposit Image -->
                            <div class="form-group">
                                <label for="edit_deposit_image">Deposit Image</label>
                                <input type="file" class="form-control" id="edit_deposit_image" name="deposit_image">
                                <br>
                                <img id="edit_preview_image" src="" alt="Deposit Image" width="100"> <!-- Preview Image -->
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Deposit</button>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        @endif   
</div>
@endsection
