@extends('layouts.main')

@section('content')
<div class="card p-4">
        <div class="d-flex flex-row justify-content-between align-items-center mb-2">
            <h5 class="font-bold">Logs</h5>
        </div>
        <div class="d-flex flex-row justify-between w-100">
            <form method="GET" class="form-inline mb-3">
                <label for="start_date" class="mr-2">From:</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-control mr-2">
                
                <label for="end_date" class="mr-2">To:</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-control mr-2">
            
                <button type="submit" class="btn btn-success text-white">Filter</button>
            </form>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover">
                <thead class="bg-success text-white">
                    <tr>
                        <th style="text-align:center;">No</th>
                        <th style="text-align:center;">Information</th>
                        <th style="text-align:center;">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($logs->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">No Data Available</td>
                        </tr>
                    @else
                        @php $no = ($logs->currentPage() - 1) * $logs->perPage() + 1; @endphp
                        @foreach($logs as $log)
                        <tr>
                            <td><span class="text-black">{{ $no++ }}</span></td>
                            <td><span class="text-black">{{ $log->keterangan }}</span></td>
                            <td><span class="text-black">{{ $log->created_at }}</span></td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="mt-3 d-flex justify-content-center align-items-center">
                {{ $logs->links('pagination::bootstrap-4') }}
            </div>
        </div>
</div>
@endsection
