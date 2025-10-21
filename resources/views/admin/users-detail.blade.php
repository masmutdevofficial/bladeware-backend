@extends('layouts.main')
@section('customScript')
<script>
    function generateReferral() {
        let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; // Huruf besar, kecil, dan angka
        let referralCode = '';
        let length = 6; // Panjang kode referral

        for (let i = 0; i < length; i++) {
            let randomIndex = Math.floor(Math.random() * characters.length);
            referralCode += characters[randomIndex];
        }

        document.getElementById("referral").value = referralCode;
    }
</script>
<!-- Script Preview Gambar -->
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('profilePreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection

@section('content')
<style>
    .table td, .table th {
        padding:0.25rem!important;
    }
    /* Ensure all modal form text is black */
    .modal-content, .modal-content label, .modal-content .form-control, .modal-content .modal-title {
        color: #000 !important;
    }
    .modal-content ::placeholder { color: #000 !important; opacity: 1; }
</style>
<div class="card p-4">
    <div class="d-flex justify-content-start align-items-center mb-3">
        <a href="/admin/users" class="btn btn-primary"><i class="fa fa-chevron-left mr-2"></i> Back</a>
    </div>
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs" id="userTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab">Users Info</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="finance-tab" data-toggle="tab" href="#finance" role="tab">Users Finance</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3">
        <!-- Info Users Tab -->
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td><strong>Profile</strong></td>
                        <td>
                            @if ($user->profile)
                                <img src="{{ asset('storage/' . $user->profile) }}" alt="Profile Picture" width="100" height="100" style="border-radius: 50%;">
                            @else
                                <img src="{{ asset('assets/img/tx1.png') }}" alt="Default Profile" width="100" height="100" style="border-radius: 50%;">
                            @endif
                        </td>
                    </tr>
                    <tr><td><strong>UID</strong></td><td>{{ $user->uid }}</td></tr>
                    <tr><td><strong>Name</strong></td><td>{{ $user->name }}</td></tr>
                    <tr><td><strong>Phone/Email</strong></td><td>{{ $user->phone_email }}</td></tr>
                    <tr><td><strong>Referral</strong></td><td>{{ $user->referral }}</td></tr>
                    <tr><td><strong>Upline</strong></td><td>{{ $dataUpline ?? '-' }}</td></tr>
                    <tr><td><strong>Status</strong></td><td>{{ $user->status == 0 ? 'Active' : 'Suspend' }}</td></tr>
                    <tr><td><strong>Level</strong></td><td>{{ $user->level == 0 ? 'Admin' : 'Member' }}</td></tr>
                    <tr><td><strong>Membership</strong></td><td>{{ $user->membership }}</td></tr>
                    <tr><td><strong>Credibility</strong></td><td>{{ $user->credibility }}</td></tr>
                    <tr><td><strong>Created At</strong></td><td>{{ $user->created_at }}</td></tr>
                    <tr><td><strong>Updated At</strong></td><td>{{ $user->updated_at }}</td></tr>
                </tbody>
            </table>
            <button class="btn btn-primary" data-toggle="modal" data-target="#editInfoModal">Edit Info</button>
        </div>

        <!-- Finance Users Tab -->
        <div class="tab-pane fade" id="finance" role="tabpanel">
            <table class="table table-borderless">
                <tbody>
                    <tr><td><strong>Network Address</strong></td><td>{{ $user->network_address ?? 'N/A' }}</td></tr>
                    <tr><td><strong>Currency</strong></td><td>{{ $user->currency ?? 'N/A' }}</td></tr>
                    <tr><td><strong>Wallet Address</strong></td><td>{{ $user->wallet_address ?? 'N/A' }}</td></tr>
                    <tr><td><strong>Balance</strong></td><td>{{ $finance->saldo ?? '0.00' }} {{ $user->currency ?? 'USDC' }}</td></tr>
                    <tr><td><strong>Commision</strong></td><td>{{ $finance->komisi ?? '0.00' }} {{ $user->currency ?? 'USDC' }}</td></tr>
                    <tr><td><strong>Withdrawal Password</strong></td><td>{{ $finance->withdrawal_password ?? 'N/A' }}</td></tr>
                    <tr><td><strong>Updated At</strong></td><td>{{ $finance->updated_at }}</td></tr>
                </tbody>
            </table>
            <button class="btn btn-primary" data-toggle="modal" data-target="#editFinanceModal">Edit Finance</button>
        </div>
    </div>
</div>

<!-- Modal Edit Users Info -->
<div class="modal fade" id="editInfoModal" tabindex="-1" role="dialog">
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
                                src="{{ $user->profile ? asset('storage/' . $user->profile) : asset('images/default-profile.png') }}"
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
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                    </div>

                    <!-- Phone/Email (Tidak Bisa Diedit) -->
                    <div class="form-group">
                        <label>Phone/Email</label>
                        <input type="email" class="form-control" value="{{ $user->phone_email }}" readonly>
                    </div>

                    <!-- Referral (Tidak Bisa Diedit) -->
                    <div class="form-group">
                        <label>Referral</label>
                        <input type="text" class="form-control" value="{{ $user->referral }}" readonly>
                    </div>

                    <!-- Referral Upline -->
                    <div class="form-group">
                        <label for="referral_upline">Referral Upline</label>
                        <select class="form-control" id="referral_upline" name="referral_upline" required>
                            <option value="">Choose Upline</option>
                            @foreach ($referrals as $referral)
                                <option value="{{ $referral->referral }}"
                                    {{ $user->referral_upline == $referral->referral ? 'selected' : '' }}>
                                    {{ $referral->name }} ({{ $referral->referral }})
                                </option>
                            @endforeach
                        </select>
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
                        <label>Level</label>
                        <select class="form-control" name="level">
                            <option value="0" {{ $user->level == 0 ? 'selected' : '' }}>Admin</option>
                            <option value="1" {{ $user->level == 1 ? 'selected' : '' }}>Member</option>
                        </select>
                    </div>

                    <!-- Membership -->
                    <div class="form-group">
                        <label>Membership</label>
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

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Users Finance -->
<div class="modal fade" id="editFinanceModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Users Finance</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.edit-finance-user', ['id' => $user->id]) }}" method="POST">
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

                    <!-- Balance -->
                    <div class="form-group">
                        <label>Balance</label>
                        <input type="number" class="form-control" name="saldo" value="{{ $finance->saldo ?? '0.00' }}">
                    </div>

                    <!-- Commission -->
                    <div class="form-group">
                        <label>Commission</label>
                        <input type="number" class="form-control" name="komisi" value="{{ $finance->komisi ?? '0.00' }}">
                    </div>

                    <!-- Withdrawal Password (Opsional) -->
                    <div class="form-group">
                        <label>New Withdrawal Password (Optional)</label>
                        <input type="withdrawal_password" class="form-control" name="withdrawal_password"  value="{{ $finance->withdrawal_password }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
