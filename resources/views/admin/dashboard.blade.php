@extends('layouts.main')
@section('customScript')

@endsection

@section('content')
    <style>
        /* Ensure all modal form text is black in dashboard (if any modal is present) */
        .modal-content, .modal-content label, .modal-content .form-control, .modal-content .modal-title {
            color: #000 !important;
        }
        .modal-content ::placeholder { color: #000 !important; opacity: 1; }
    </style>
    <div class="row">
        <!-- Total Users Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-success">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Products</div>
                            <div class="h5 mb-0 font-weight-bold text-success">{{ $totalProducts }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Deposits Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Deposits
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-success">{{ $totalDeposits }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Withdraw Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Withdraw</div>
                            <div class="h5 mb-0 font-weight-bold text-success">{{ $totalWithdrawals }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Total Users Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Today's Users</div>
                            <div class="h5 mb-0 font-weight-bold text-success">{{ $todayUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Deposits Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Today's Deposits
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-success">{{ $todayDeposits }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total Products Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Today's Bonus</div>
                            <div class="h5 mb-0 font-weight-bold text-success">{{ $todayBonus }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Withdraw Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Today's Withdraw</div>
                            <div class="h5 mb-0 font-weight-bold text-success">{{ $todayWithdrawals }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Total Users Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Monthly Users</div>
                            <div class="h5 mb-0 font-weight-bold text-success">{{ $monthlyUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Deposits Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Monthly Deposits
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-success">{{ $monthlyDeposits }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total Products Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Monthly Bonus</div>
                            <div class="h5 mb-0 font-weight-bold text-success">{{ $monthlyBonus }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Withdraw Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Monthly Withdraw</div>
                            <div class="h5 mb-0 font-weight-bold text-success">{{ $monthlyWithdrawals }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex flex-row justify-content-center align-items-center">
        <form action="{{ route('admin.dashboard.export-excel') }}" method="GET" class="form-inline mb-3">
            @csrf
            <div class="form-group mr-2">
                <label for="year" class="mr-2 text-black">Year</label>
                <select name="year" id="year" class="form-control text-black">
                    @php
                        $currentYear = now()->year;
                    @endphp
                    @for ($i = $currentYear; $i >= $currentYear - 5; $i--)
                        <option value="{{ $i }}" {{ request('year', $currentYear) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="form-group mr-2">
                <label for="month" class="mr-2 text-black">Month</label>
                <select name="month" id="month" class="form-control text-black">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ (int)request('month', now()->month) == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endfor
                </select>
            </div>

            

            <button type="submit" class="btn btn-success text-white">
                <i class="fas fa-file-excel text-white mr-1"></i> Export
            </button>
        </form>
    </div>
    

    <!-- Content Row -->
    <div class="row">
        <a href="/admin/users" class="col-xl-3 col-md-6 mb-4 text-decoration-none">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-users fa-2x text-success mb-4 text-decoration-none"></i>
                        <div class="text-xs font-weight-bold text-success text-decoration-none text-uppercase mb-1">
                            Users Page
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="/admin/products" class="col-xl-3 col-md-6 mb-4 text-decoration-none">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-box fa-2x text-success mb-4 text-decoration-none"></i>
                        <div class="text-xs font-weight-bold text-success text-decoration-none text-uppercase mb-1">
                            Products Page
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="/admin/deposits" class="col-xl-3 col-md-6 mb-4 text-decoration-none">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-wallet fa-2x text-success mb-4 text-decoration-none"></i>
                        <div class="text-xs font-weight-bold text-success text-decoration-none text-uppercase mb-1">
                            Deposits Page
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <a href="/admin/withdrawals" class="col-xl-3 col-md-6 mb-4 text-decoration-none">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-dollar-sign fa-2x text-success mb-4 text-decoration-none"></i>
                        <div class="text-xs font-weight-bold text-success text-decoration-none text-uppercase mb-1">
                            Withdrawals Page
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endsection
