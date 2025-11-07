@extends('layouts.main')
@section('customScript')
<script>
    function generateReferral() {
        let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let referralCode = '';
        let length = 6; // Panjang kode referral

        for (let i = 0; i < length; i++) {
            let randomIndex = Math.floor(Math.random() * characters.length);
            referralCode += characters[randomIndex];
        }

        document.getElementById("referral").value = referralCode;
    }

    // Generate referral saat halaman selesai dimuat
    document.addEventListener("DOMContentLoaded", function() {
        generateReferral();
    });
    
</script>
<!-- Script custom -->
<script>
    $(document).ready(function () {
        $('.modal').on('shown.bs.modal', function () {
            const $modal = $(this);
            const $select = $modal.find('.product-multiselect');
            const $selectGroup = $modal.find('#product-select-group');
            const $boostSequenceGroup = $modal.find('#boost-sequence-group');
            const $boostSetGroup = $modal.find('#boost-set-group');

            // Init Select2 jika belum
            setTimeout(() => {
                if (!$select.hasClass("select2-hidden-accessible")) {
                    if (typeof $select.select2 === 'function') {
                        $select.select2({
                            placeholder: "Select products...",
                            maximumSelectionLength: 3,
                            width: '100%'
                        });
                    } else {
                        console.error('Select2 Error!');
                    }
                }

                // 🔥 Initial Check (langsung setelah select2 aktif)
                const status = $modal.find('.status-radio:checked').val();
                const selected = $select.val();

                if (status === 'active') {
                    $selectGroup.removeClass('d-none');
                    if (selected && selected.length > 0) {
                        $boostSequenceGroup.removeClass('d-none');
                        $boostSetGroup.removeClass('d-none');
                    }
                }
            }, 100); // delay sedikit biar select2 ready

            $modal.find('.status-radio').on('change', function () {
                const isActive = $(this).val() === 'active';
            
                $selectGroup.toggleClass('d-none', !isActive);
                $boostSequenceGroup.toggleClass('d-none', !isActive);
                $boostSetGroup.toggleClass('d-none', !isActive);
            
                if (isActive) {
                    $select.prop('required', true);
                    $modal.find('input[name="sequence"]').prop('required', true);
                    $modal.find('select[name="set_boost"]').prop('required', true);
                } else {
                    $select.val(null).trigger('change');
                    $select.prop('required', false);
                    $modal.find('input[name="sequence"]').prop('required', false);
                    $modal.find('select[name="set_boost"]').prop('required', false);
                }
            });


            // Saat user memilih produk
            $select.on('change', function () {
                const selected = $(this).val();
                const isActive = $modal.find('.status-radio:checked').val() === 'active';

                if (isActive && selected.length > 0) {
                    $boostSequenceGroup.removeClass('d-none');
                    $boostSetGroup.removeClass('d-none');
                } else {
                    $boostSequenceGroup.addClass('d-none');
                    $boostSetGroup.addClass('d-none');
                }
            });
        });
    });
</script>
@endsection
@section('content')
<div class="card p-4"> 
            <div class="d-flex flex-row justify-content-between align-items-center mb-4">
            <h5 class="font-bold">Users Records</h5>
            @if(Auth::user()->level == 0)
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <button class="btn btn-success text-white mr-2" data-toggle="modal" data-target="#addUserModal">
                        <i class="fa fa-plus text-white mr-2"></i>
                        Add Users
                    </button>
                    <div class="dropdown mr-2">
                        <button class="btn btn-success text-white dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-file-excel mr-2 text-white"></i> Export
                        </button>
                        <div class="dropdown-menu" aria-labelledby="exportDropdown">
                            <a class="dropdown-item" href="{{ route('admin.export-excel') }}">
                                <i class="fa fa-file-excel mr-2 text-success"></i> Excel
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.export-pdf') }}">
                                <i class="fa fa-file-pdf mr-2 text-danger"></i> PDF
                            </a>
                        </div>
                    </div>
                </div>
            @endif
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
            <form method="GET" action="{{ route('admin.users') }}" class="mb-2 w-100">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-0 small text-black" placeholder="Search name, email, referral, wallet address..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-success text-white mr-2" type="submit">
                            <i class="fas fa-search text-white fa-sm"></i>
                        </button>
                        <a href="{{ route('admin.users') }}" class="btn btn-success text-white">
                            <i class="fas fa-sync-alt text-white fa-sm"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="d-flex flex-row justify-between w-100 mt-2">
            <form method="GET" action="{{ route('admin.users') }}" class="form-inline mb-3">
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
                        <th class="text-center">No</th>
                        <th class="text-center">Users Detail</th>
                        <th class="text-center">Finance</th>
                        <th class="text-center">Recharge/Withdraw</th>
                        <th class="text-center">Boost Information</th>
                        <th class="text-center">Register Information</th>
                        <th class="text-center">Workdays Information</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @if($users->isEmpty())
                        <tr>
                            <td colspan="100%" class="text-center">No Data Available.</td>
                        </tr>
                    @else
                    @foreach($users as $user)
                        <tr>
                            <td class="
                                @if($user->level == 0) bg-danger text-white 
                                @elseif($user->level == 1) bg-primary text-white 
                                @elseif($user->level == 2) bg-success text-white
                                @elseif($user->level == 3) bg-warning text-white
                                @endif
                            ">
                                {{ $no++ }}
                            </td>
                            <td>
                                <div class="d-flex flex-column flex-wrap gap-2 text-sm" style="width:300px;">
                                    @if(Auth::user()->level == 0)
                                    <div class="d-flex justify-content-end mb-1">
                                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModalData-{{ $user->id }}">
                                            <i class="fa fa-edit text-black"></i>
                                        </a>
                                    </div>
                                    @endif
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black"><strong class="me-1">User Name:</strong> {{ $user->name ?? 'N/A' }}</div>
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black"><strong class="me-1">Phone Number:</strong> {{ $user->phone_email ?? 'N/A' }}</div>
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black"><strong class="me-1">Email:</strong> {{ $user->email_only ?? 'N/A' }}</div>
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black"><strong class="me-1">VIP Level:</strong> {{ $user->membership ?? 'N/A' }}</div>
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black"><strong class="me-1">Invitation Code:</strong> {{ $user->referral ?? 'N/A' }}</div>
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black"><strong class="me-1">Superior Username:</strong> {{ $user->upline_name ?? 'N/A' }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column flex-wrap gap-2 text-sm" style="width:300px;padding-top: 34.5px;">
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black"><strong class="me-1">Available Balance:</strong> {{ $user->finance->saldo ?? 'N/A' }}</div>
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black"><strong class="me-1">Frozen Balance:</strong> {{ $user->finance->saldo_beku ?? 'N/A' }}</div>
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black"><strong class="me-1">Mission Commission:</strong> {{ $user->finance->saldo_misi ?? 'N/A' }}</div>
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black"><strong class="me-1">Superior Commission:</strong> {{ number_format($user->finance->komisi ?? 0, 2, '.', '') }}</div>
                                </div>
                            </td>
                            <td>
                                    @if(Auth::user()->level == 0)
                                    <div class="d-flex justify-content-end mb-1">
                                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModalFinance-{{ $user->id }}">
                                            <i class="fa fa-edit text-warning"></i>
                                        </a>
                                    </div>
                                    @endif
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-sm text-black" style="width:300px;">
                                        <strong class="me-1">Recharge Times:</strong>
                                        {{ $user->deposit_count > 0 ? $user->deposit_count . ' times' : 'N/A' }}
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-sm text-black" style="width:300px;">
                                        <strong class="me-1">Recharge Amount:</strong>
                                        {{ $user->deposit_total > 0 ? number_format($user->deposit_total) : 'N/A' }}
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-sm text-black" style="width:300px;">
                                        <strong class="me-1">Withdrawal Times:</strong>
                                        {{ $user->withdrawal_count > 0 ? $user->withdrawal_count . ' times' : 'N/A' }}
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-sm text-black" style="width:300px;">
                                        <strong class="me-1">Withdrawal Amount:</strong>
                                        {{ $user->withdrawal_total > 0 ? number_format($user->withdrawal_total) : 'N/A' }}
                                    </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column flex-wrap gap-2 text-sm" style="width:250px;padding-top: 34.5px;">
                                    @if($user->has_combination)
                                        <div class="d-flex justify-content-between align-items-center flex-row mb-0 text-danger">
                                            <strong class="me-1 text-danger">Order Boost:</strong>{{ $user->task_done }}/{{ $user->task_limit }}
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center flex-row mb-0 text-danger" >
                                            <strong class="me-1" >Current Set:</strong> {{ $user->display_set ?? '-' }}
                                        </div>
                                        @php
                                            $ids = $user->display_combination_products ?? [];
                                            $idsStr = empty($ids) ? '-' : implode(', ', $ids);
                                        @endphp
                                        <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-danger">
                                            <strong class="me-1 text-danger">Combination:</strong> <p>{{ $idsStr }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-danger">
                                            <strong class="me-1 text-danger">Order:</strong> {{ $user->display_sequence - 1 ?? '-' }}
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-danger">
                                            <strong class="me-1 text-danger">Set:</strong> {{ $user->display_set ?? '-' }}
                                        </div>
                                        @if($user->is_combination_active)
                                            <div class="d-flex flex-column justify-content-center align-items-center flex-row mb-1" style="color: red;">
                                                <strong class="text-center"> Currently processing combination order</strong>
                                            </div>
                                        @endif
                                    @else
                                        <div class="d-flex justify-content-between align-items-center flex-row mb-0 text-black">
                                            <strong class="me-1">Order Boost:</strong>{{ $user->task_done }}/{{ $user->task_limit }}
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center flex-row mb-0 text-danger" >
                                            <strong class="me-1">Current Set:</strong> {{ $user->position_set ?? '-' }}
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black">
                                            <strong class="me-1">Product ID:</strong>{{ $user->latest_product_id ?? '-' }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column flex-wrap gap-2 text-sm" style="width:340px;padding-top: 34.5px;">
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black"><strong class="me-1">Registration Time:</strong> {{ $user->created_at ?? 'N/A' }}</div>
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black"><strong class="me-1">Up Time:</strong> {{ $user->finance->updated_at ?? 'N/A' }}</div>
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black"><strong class="me-1">IP Address:</strong> {{ $user->ip_address ?? '-' }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column flex-wrap gap-2 text-sm" style="width:240px;padding-top: 34.5px;">
                                @php
                                    $absenData = $user->absen_user->take(5); // ambil max 5 data
                                @endphp
                                
                                @for ($i = 0; $i < 5; $i++)
                                    <div class="d-flex justify-content-between align-items-center flex-row mb-1 text-black">
                                        <strong class="me-1">Day {{ $i + 1 }}</strong>
                                        {{ $absenData[$i]->created_at ?? '-' }}
                                    </div>
                                @endfor
                                </div>
                            </td>
                            <td>
                                @if(Auth::user()->level == 0)
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.users.combinations', ['id' => $user->id]) }}" class="btn btn-primary mr-2">
                                        <i class="fa fa-cogs"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal-{{ $user->id }}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                                
                                <div class="d-flex justify-content-center w-full mt-4">
                                    @if ($user->task_done == $user->task_limit)
                                        <form action="{{ url('/admin/reset-job') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <button type="submit" class="btn btn-success text-white mr-2">
                                                Reset ({{ $user->task_done }}/{{ $user->task_limit }})
                                            </button>
                                        </form>
                                    @else
                                        <div href="#"
                                           class="btn btn-danger mr-2" >
                                            Reset ({{ $user->task_done }}/{{ $user->task_limit }})
                                        </div>
                                    @endif
                                </div>

                                @else
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-primary mr-2">
                                            <i class="fa fa-cogs"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>

                        @if(Auth::user()->level == 0)
                        <!-- Modal Confirm Delete -->
                        <div class="modal fade" id="confirmDeleteModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the user <strong>{{ $user->name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <a href="{{ route('admin.delete-user', ['id' => $user->id]) }}" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal Edit Users Info -->
                        <div class="modal fade" id="editModalData-{{ $user->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Users Info</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.edit-info-user', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                        
                                            <!-- Preview Profile Picture -->
                                            <div class="form-group text-center">
                                                <label>Profile Picture</label>
                                                <div>
                                                    <img id="profilePreview"
                                                        src="{{ $user->profile ? asset('storage/' . $user->profile) : asset('assets/img/tx1.png') }}"
                                                        alt="Profile Picture"
                                                        width="100" height="100"
                                                        style="border-radius: 50%; object-fit: cover;">
                                                </div>
                                                <input type="file" class="form-control-file mt-2" id="profile_picture" name="profile_picture" onchange="previewImage(event)">
                                            </div>
                        
                                            <!-- UID (Tidak Bisa Diedit) -->
                                            <div class="form-group">
                                                <label>UID</label>
                                                <input type="text" class="form-control" value="{{ $user->uid }}" readonly>
                                            </div>
                        
                                            <!-- Name -->
                                            <div class="form-group">
                                                <label>User Name</label>
                                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                            </div>
                                            
                                            <!-- Phone/Email (Tidak Bisa Diedit) -->
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text" class="form-control" value="{{ $user->phone_email }}" readonly>
                                            </div>
                        
                                            <!-- Phone/Email (Tidak Bisa Diedit) -->
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" value="{{ $user->email_only }}" readonly>
                                            </div>
                                            
                                            <!-- Password -->
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="*******">
                                                <small class="text-warning">* Optional (Ignore if no changes)</small>
                                            </div>
                        
                                            <!-- Referral (Tidak Bisa Diedit) -->
                                            <div class="form-group">
                                                <label>Referral</label>
                                                <input type="text" class="form-control" value="{{ $user->referral }}" readonly>
                                            </div>
                        
                                            <!-- Referral Upline -->
                                            <div class="form-group">
                                                <label for="referral_upline">Superior Username</label>
                                                <input type="text" class="form-control" id="referral_upline" name="referral_upline" value="{{ $user->referral_upline }}" readonly>
                                            </div>
                        
                                            <!-- Status -->
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" name="status">
                                                    <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Active</option>
                                                    <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Suspend</option>
                                                </select>
                                            </div>
                        
                                            <!-- Level -->
                                            <div class="form-group">
                                                <label>Type Account</label>
                                                <select class="form-control" name="level">
                                                    <option value="3" {{ $user->level == 0 ? 'selected' : '' }}>Operator</option>
                                                    <option value="1" {{ $user->level == 1 ? 'selected' : '' }}>Member</option>
                                                    <option value="2" {{ $user->level == 2 ? 'selected' : '' }}>Training Account</option>
                                                </select>
                                            </div>
                        
                                            <!-- Membership -->
                                            <div class="form-group">
                                                <label>VIP Level</label>
                                                <select class="form-control" name="membership">
                                                    <option value="Normal" {{ $user->membership == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                    <option value="Gold" {{ $user->membership == 'Gold' ? 'selected' : '' }}>Gold</option>
                                                    <option value="Platinum" {{ $user->membership == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                                                    <option value="Crown" {{ $user->membership == 'Crown' ? 'selected' : '' }}>Crown</option>
                                                </select>
                                            </div>
                        
                                            <!-- Credibility -->
                                            <div class="form-group">
                                                <label>Credibility</label>
                                                <input type="number" class="form-control" name="credibility" value="{{ $user->credibility }}" required>
                                            </div>
                        
                                            <h5 class="my-2 text-center mb-4">Finance Information</h5>
                                            
                                            <!-- Network Address -->
                                            <div class="form-group">
                                                <label>Network Address</label>
                                                <select class="form-control" name="network_address">
                                                    <option value="ERC-20" {{ $user->network_address == 'ERC-20' ? 'selected' : '' }}>ERC-20</option>
                                                    <option value="SOL" {{ $user->network_address == 'SOL' ? 'selected' : '' }}>SOL</option>
                                                    <option value="Polygon" {{ $user->network_address == 'Polygon' ? 'selected' : '' }}>Polygon</option>
                                                    <option value="BTC" {{ $user->network_address == 'BTC' ? 'selected' : '' }}>BTC</option>
                                                </select>
                                            </div>
                        
                                            <!-- Currency -->
                                            <div class="form-group">
                                                <label>Currency</label>
                                                <select class="form-control" name="currency">
                                                    <option value="Paypal USD" {{ $user->currency == 'Paypal USD' ? 'selected' : '' }}>Paypal USD</option>
                                                    <option value="USDC" {{ $user->currency == 'USDC' ? 'selected' : '' }}>USDC</option>
                                                    <option value="ETH" {{ $user->currency == 'ETH' ? 'selected' : '' }}>ETH</option>
                                                    <option value="BTC" {{ $user->currency == 'BTC' ? 'selected' : '' }}>BTC</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Wallet Address -->
                                            <div class="form-group">
                                                <label>Wallet Address</label>
                                                <input type="text" class="form-control" name="wallet_address" value="{{ $user->wallet_address ?? '' }}">
                                            </div>
                        
                                            <!-- Withdrawal Password (Opsional) -->
                                            <div class="form-group">
                                                <label>New Withdrawal Password (Optional)</label>
                                                <input type="text" class="form-control" name="withdrawal_password"  value="{{ $user->finance->withdrawal_password }}">
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal Edit Users Finance -->
                        <div class="modal fade" id="editModalFinance-{{ $user->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Users Finance</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.edit-finance-user', ['id' => $user->id]) }}" method="POST">
                                            @csrf
                        
                                            <!-- Saldo -->
                                            <div class="form-group">
                                                <label>Balance</label>
                                                <input type="number" class="form-control" name="saldo" placeholder="0" step="0.01">
                                            </div>
                                            
                                            <!-- Saldo -->
                                            <div class="form-group">
                                                <label>Rewards</label>
                                                <input type="number" class="form-control" name="saldo_bonus" min="-999999" step="0.01">
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit Users Wallet -->
                        <div class="modal fade" id="editModalWallet-{{ $user->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Users Wallet</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.edit-wallet-user', ['id' => $user->id]) }}" method="POST">
                                            @csrf
                        
                                            <!-- Network Address -->
                                            <div class="form-group">
                                                <label>Network Address</label>
                                                <select class="form-control" name="network_address">
                                                    <option value="ERC-20" {{ $user->network_address == 'ERC-20' ? 'selected' : '' }}>ERC-20</option>
                                                    <option value="SOL" {{ $user->network_address == 'SOL' ? 'selected' : '' }}>SOL</option>
                                                    <option value="Polygon" {{ $user->network_address == 'Polygon' ? 'selected' : '' }}>Polygon</option>
                                                    <option value="BTC" {{ $user->network_address == 'BTC' ? 'selected' : '' }}>BTC</option>
                                                </select>
                                            </div>
                        
                                            <!-- Currency -->
                                            <div class="form-group">
                                                <label>Currency</label>
                                                <select class="form-control" name="currency">
                                                    <option value="Paypal USD" {{ $user->currency == 'Paypal USD' ? 'selected' : '' }}>Paypal USD</option>
                                                    <option value="USDC" {{ $user->currency == 'USDC' ? 'selected' : '' }}>USDC</option>
                                                    <option value="ETH" {{ $user->currency == 'ETH' ? 'selected' : '' }}>ETH</option>
                                                    <option value="BTC" {{ $user->currency == 'BTC' ? 'selected' : '' }}>BTC</option>
                                                </select>
                                            </div>
                        
                                            <!-- Wallet Address -->
                                            <div class="form-group">
                                                <label>Wallet Address</label>
                                                <input type="text" class="form-control" name="wallet_address" value="{{ $user->wallet_address ?? '' }}">
                                            </div>
                        
                                            <!-- Withdrawal Password (Opsional) -->
                                            <div class="form-group">
                                                <label>New Withdrawal Password (Optional)</label>
                                                <input type="withdrawal_password" class="form-control" name="withdrawal_password"  value="{{ $user->finance->withdrawal_password }}">
                                            </div>
                        
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        @endif
                    @endforeach
                    @endif
                </tbody>
            </table>
            <div class="mt-3 d-flex justify-content-center align-items-center">
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
        
        @if(Auth::user()->level == 0)
        <!-- Add Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="/admin/add-users" enctype="multipart/form-data">
                            @csrf
                            <!-- Profile Picture -->
                            <div class="form-group">
                                <label for="profile">Profile Picture</label>
                                <input type="file" class="form-control-file" id="profile" name="profile">
                            </div>

                            <!-- Referral Code -->
                            <div class="form-group">
                                <label for="referral">Referral Code</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="referral" name="referral"  placeholder="Generate Referral" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" onclick="generateReferral()">Generate</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="form-group">
                                <label for="name">User Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter User Name" required>
                            </div>

                            <!-- Email / Phone Number -->
                            <div class="form-group">
                                <label for="phone_email">Phone Number</label>
                                <input type="number" class="form-control" id="phone_email" name="phone_email" placeholder="Enter Phone Number" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email_only">Email</label>
                                <input type="email" class="form-control" id="email_only" name="email_only" placeholder="Enter Email" required>
                            </div>
                            
                            <!-- Password -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" autocomplete="new-password" required>
                            </div>

                            <!-- Withdrawal Password -->
                            <div class="form-group">
                                <label for="withdrawal_password">Withdrawal Password</label>
                                <input type="password" class="form-control" id="withdrawal_password" name="withdrawal_password" placeholder="Enter Withdrawal Password" required>
                            </div>

                            <!-- Referral Upline -->
                            <div class="form-group">
                                <label for="referral_upline">Referral Code (Superior Username)</label>
                                <input type="text" class="form-control" id="referral_upline" name="referral_upline" required>
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Choose Status</option>
                                    <option value="0" selected>Active</option>
                                    <option value="1">Suspend</option>
                                </select>
                            </div>

                            <!-- Level -->
                            <div class="form-group">
                                <label for="level">Type Account</label>
                                <select class="form-control" id="level" name="level">
                                    <option value="">Choose Type</option>
                                    <option value="3">Operator</option>
                                    <option value="1">Members</option>
                                    <option value="2" selected>Training Account</option>
                                </select>
                            </div>

                            <!-- Level -->
                            <div class="form-group">
                                <label for="membership">Membership</label>
                                <select class="form-control" id="membership" name="membership" required>
                                    <option value="">Choose Membership</option>
                                    <option value="Normal" selected>Normal</option>
                                    <option value="Gold">Gold</option>
                                    <option value="Platinum">Platinum</option>
                                    <option value="Crown">Crown</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
</div>
@endsection
