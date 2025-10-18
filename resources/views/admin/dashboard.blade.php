@extends('layouts.main')
@section('customScript')

@endsection

@section('content')
    <div class="row">
        <!-- Total Users Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Deposits
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $totalDeposits }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Withdraw</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalWithdrawals }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Today's Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Today's Deposits
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $todayDeposits }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayBonus }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Today's Withdraw</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayWithdrawals }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Monthly Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monthlyUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Monthly Deposits
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $monthlyDeposits }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monthlyBonus }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Monthly Withdraw</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monthlyWithdrawals }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                <label for="date" class="mr-2">Tanggal</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
            </div>
        
            <div class="form-group mr-2">
                <label for="month" class="mr-2">Bulan</label>
                <input type="month" name="month" id="month" class="form-control" value="{{ request('month') }}">
            </div>
        
            <div class="form-group mr-2">
                <label for="year" class="mr-2">Tahun</label>
                <select name="year" id="year" class="form-control">
                    @php
                        $currentYear = now()->year;
                    @endphp
                    @for ($i = $currentYear; $i >= $currentYear - 5; $i--)
                        <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        
            <button type="submit" class="btn btn-success">
                <i class="fas fa-file-pdf mr-1"></i> Export PDF
            </button>
        </form>
    </div>
    

    <!-- Content Row -->
    <div class="row">
        <a href="/admin/users" class="col-xl-3 col-md-6 mb-4 text-decoration-none">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-users fa-2x text-gray-300 mb-4 text-decoration-none"></i>
                        <div class="text-xs font-weight-bold text-primary text-decoration-none text-uppercase mb-1">
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
                        <i class="fas fa-box fa-2x text-gray-300 mb-4 text-decoration-none"></i>
                        <div class="text-xs font-weight-bold text-primary text-decoration-none text-uppercase mb-1">
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
                        <i class="fas fa-wallet fa-2x text-gray-300 mb-4 text-decoration-none"></i>
                        <div class="text-xs font-weight-bold text-primary text-decoration-none text-uppercase mb-1">
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
                        <i class="fas fa-dollar-sign fa-2x text-gray-300 mb-4 text-decoration-none"></i>
                        <div class="text-xs font-weight-bold text-primary text-decoration-none text-uppercase mb-1">
                            Withdrawals Page
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endsection
