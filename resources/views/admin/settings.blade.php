@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Settings</h1>

    <form action="{{ route('admin.settings-update') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="work_time_start" class="text-black">Work Time</label>
            <div class="d-flex gap-2">
                <input type="time" class="form-control" id="work_time_start" name="work_time_start"
                    value="{{ isset($settings) ? explode(' - ', $settings->work_time)[0] : '' }}" required>
                <span class="mx-2">-</span>
                <input type="time" class="form-control" id="work_time_end" name="work_time_end"
                    value="{{ isset($settings) ? explode(' - ', $settings->work_time)[1] : '' }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="timezone" class="text-black">Timezone</label>
            <input type="text" class="form-control" id="timezone" name="timezone" value="{{ $settings->timezone ?? '' }}" required>
        </div>

        <div class="form-group">
            <label for="closed" class="text-black">Status</label>
            <select class="form-control" id="closed" name="closed">
                <option value="0" {{ isset($settings) && $settings->closed == 0 ? 'selected' : '' }}>Web Open</option>
                <option value="1" {{ isset($settings) && $settings->closed == 1 ? 'selected' : '' }}>Web Closed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
