@extends('layouts.main')
@section('customScript')
<script>
    // Edit Modal
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);          // tombol yang diklik
        var withdrawal = button.data('withdrawal');   // object withdrawal dari data-*

        // Set hidden id
        $('#edit_withdrawal_id').val(withdrawal.id);

        // Sinkronkan STATUS dengan aman (normalisasi ke string, clear dulu, lalu pilih)
        var statusVal = String(withdrawal.status);
        var $status = $('#edit_status');
        $status.find('option').prop('selected', false);
        $status.find('option[value="' + statusVal + '"]').prop('selected', true);
        $status.trigger('change'); // kalau pakai plugin/select2 tetap kepilih

        // Atur action form edit
        var formAction = "{{ route('admin.edit-withdrawals', ':id') }}".replace(':id', withdrawal.id);
        $('#editForm').attr('action', formAction);
    });

    // Delete Modal (biarkan seperti sebelumnya)
    $('#confirmDeleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var withdrawalId = button.data('id');
        $('#deleteItemId').val(withdrawalId);
        $('#confirmDelete').data('id', withdrawalId);
    });

    $('#confirmDelete').on('click', function() {
        var withdrawalId = $(this).data('id');
        $.ajax({
            url: '/admin/delete-withdrawals/' + withdrawalId,
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function() { location.reload(); },
            error: function() { alert('Error deleting withdrawal.'); }
        });
    });
</script>
@endsection


@section('content')
<style>
/* Ensure all modal form text is black in withdrawals page */
.modal-content, .modal-content label, .modal-content .form-control, .modal-content .modal-title {
    color: #000 !important;
}
.modal-content ::placeholder { color: #000 !important; opacity: 1; }
</style>
<div class="card p-4">
        <div class="d-flex flex-row justify-content-between align-items-center mb-2">
            <h5 class="font-bold text-black">Withdrawals Records</h5>
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
            <form method="GET" action="{{ route('admin.withdrawals') }}" class="mb-2 w-100">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-0 small text-black" placeholder="Search Name..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-success mr-2" type="submit">
                            <i class="fas fa-search text-white fa-sm"></i>
                        </button>
                        <a href="{{ route('admin.withdrawals') }}" class="btn btn-success">
                            <i class="fas fa-sync-alt text-white fa-sm"></i>
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
                        <th style="text-align:center;">Currency</th>
                        <th style="text-align:center;">Network Address</th>
                        <th style="text-align:center;">Wallet Address</th>
                        <th style="text-align:center;">Amount</th>
                        <th style="text-align:center;">Status</th>
                        <th style="text-align:center;">Created</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($withdrawals->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center">No Data Available</td>
                        </tr>
                    @else
                        @foreach ($withdrawals as $key => $withdrawal)
                        <tr>
                            <td><span class="text-black">{{ $key + 1 }}</span></td>
                            <td><span class="text-black">{{ $withdrawal->name }}</span></td>
                            <td><span class="text-black">{{ $withdrawal->currency }}</span></td>
                            <td><span class="text-black">{{ $withdrawal->network_address }}</span></td>
                            <td><span class="text-black">{{ $withdrawal->wallet_address }}</span></td>
                            <td><span class="text-black">{{ number_format($withdrawal->amount, 2, '.', ',') }}</span></td>
                            <td>
                                @switch((int)$withdrawal->status)
                                    @case(0)
                                        <span class="badge badge-warning w-100" style="color:white!important;">In Process</span>
                                        @break
                                    @case(1)
                                        <span class="badge badge-success w-100" style="color:white!important;">Approved</span>
                                        @break
                                    @case(2)
                                        <span class="badge badge-danger w-100" style="color:white!important;">Rejected</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary w-100" style="color:white!important;">-</span>
                                @endswitch
                            </td>


                            <td><span class="text-black">{{ $withdrawal->created_at }}</span></td>
                            <td>
                                @if(Auth::user()->level == 0)
                                <div class="d-flex flex-row justify-content-center align-items-center">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-warning mr-2" data-toggle="modal" data-target="#editModal"
                                        data-withdrawal='@json($withdrawal)'>
                                        <i class="fa fa-edit"></i>
                                    </button>

                                </div>
                                @else
                                    <div class="d-flex flex-row justify-content-center align-items-center">
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-warning mr-2">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="mt-3 d-flex justify-content-center align-items-center">
                {{ $withdrawals->links('pagination::bootstrap-4') }}
            </div>
        </div>

        @if(Auth::user()->level == 0)
        <!-- Add Modal -->
        <div class="modal fade" id="addWithdrawalsModal" tabindex="-1" role="dialog" aria-labelledby="addWithdrawalsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addWithdrawalsModalLabel">Add New Withdrawals</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('admin.add-withdrawals') }}" enctype="multipart/form-data">
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

                            <!-- Withdrawals Amount -->
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>

                            <!-- Withdrawals Status -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="0">In Process</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Withdrawals</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Withdrawals -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Withdrawals</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="POST" id="editForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_withdrawal_id" name="withdrawal_id"> <!-- Hidden input untuk ID produk -->

                        <div class="modal-body">

                            <!-- Withdrawals Status -->
                            <div class="form-group">
                                <label for="edit_status">Status</label>
                                <select class="form-control" id="edit_status" name="status">
                                    <option value="0">In Process</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Withdrawals</button>
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
