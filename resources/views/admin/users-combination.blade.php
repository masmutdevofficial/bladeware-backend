@extends('layouts.main')

@section('content')
<style>
    .text-black, .card, .card *, label, input, select, option, table, th, td, .modal, .modal * {
        color: #000 !important;
    }
    .select2-container .select2-selection--multiple .select2-selection__choice {
        color:#000;
    }
    .select2-container--default .select2-results__option[aria-disabled=true] {
        color: #888;
    }
    .table-sm th, .table-sm td { padding: .4rem; }
    .cursor-pointer { cursor: pointer; }
    .disabled-option { color:#888; }
    .badge-seq { font-size: 12px;color:white!important; }
    .badge-set { font-size: 12px; }
    .form-hint { font-size: 12px; color: #000; opacity:.7; }
    .select2-container { width:100% !important; }
    .w-200 { width:200px; }
</style>

@php $selectedSet = (int) request()->get('set', 1); @endphp
<div class="card p-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="text-black">Setting Combination Products for {{ $user->name }}</h4>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary" style="color:white!important;">Back to Users</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="d-flex justify-content-end align-items-center mb-3">
        <!-- <form method="GET" action="{{ route('admin.users.combinations', ['id' => $user->id]) }}" class="mr-3 d-flex align-items-end">
            <div class="form-group mr-2">
                <label for="set">View Set</label>
                <select name="set" id="set" class="form-control w-200" onchange="this.form.submit()">
                    @php $selectedSet = (int) request()->get('set', 1); @endphp
                    <option value="1" {{ $selectedSet === 1 ? 'selected' : '' }}>Set 1</option>
                    <option value="2" {{ $selectedSet === 2 ? 'selected' : '' }}>Set 2</option>
                    <option value="3" {{ $selectedSet === 3 ? 'selected' : '' }}>Set 3</option>
                </select>
            </div>
        </form> -->

        <button class="btn btn-success mt-2" style="color:white!important;" data-toggle="modal" data-target="#addCombinationModal">Add Combination</button>
    </div>

    @php
        $sets = [1,2,3];
    @endphp

    @foreach($sets as $set)
        @php
            $rows = $combinations[$set] ?? [];
        @endphp
        <div class="card mb-4">
            <div class="card-header bg-light">
                <strong class="text-black">Set {{ $set }}</strong>
            </div>
            <div class="card-body">
                @if(empty($rows))
                    <div class="text-black">No combinations for this set.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="bg-success text-white" style="color:white!important;">
                                <tr>
                                    <th class="text-center" style="color:white!important;">Sequence</th>
                                    <th style="color:white!important;">Products</th>
                                    <th class="text-center" style="color:white!important;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows as $seq => $productIds)
                                    <tr>
                                        <td class="text-center align-middle"><span class="badge badge-success badge-seq" style="color:white!important;">{{ $seq }}</span></td>
                                        <td class="align-middle">
                                            @php $names = []; @endphp
                                            @foreach($productIds as $pid)
                                                @php $names[] = ($productMap[$pid]->product_name ?? 'ID '.$pid).' ('.$pid.')'; @endphp
                                            @endforeach
                                            <div class="text-black">{{ implode(', ', $names) }}</div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-warning btn-sm mr-2" data-toggle="modal" data-target="#editComboModal-{{ $set }}-{{ $seq }}">Edit</button>
                                                <form action="{{ route('admin.delete-combination', ['id' => $user->id]) }}" method="POST" onsubmit="return confirm('Delete sequence {{ $seq }} from set {{ $set }}?')">
                                                    @csrf
                                                    <input type="hidden" name="set_boost" value="{{ $set }}">
                                                    <input type="hidden" name="sequence" value="{{ $seq }}">
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>

                                            <!-- Edit Combination Modal -->
                                            <div class="modal fade" id="editComboModal-{{ $set }}-{{ $seq }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Edit Combination (Set {{ $set }} / Seq {{ $seq }})</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('admin.update-combination', ['id' => $user->id]) }}" id="editForm-{{ $set }}-{{ $seq }}">
                                                                @csrf
                                                                <input type="hidden" name="original_set" value="{{ $set }}" />
                                                                <input type="hidden" name="original_sequence" value="{{ $seq }}" />
                                                                <div class="form-group">
                                                                    <label class="text-black">Set</label>
                                                                    <select class="form-control" name="set_boost">
                                                                        <option value="1" {{ $set == 1 ? 'selected' : '' }}>Set 1</option>
                                                                        <option value="2" {{ $set == 2 ? 'selected' : '' }}>Set 2</option>
                                                                        <option value="3" {{ $set == 3 ? 'selected' : '' }}>Set 3</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="text-black">Sequence (0-based)</label>
                                                                    <input type="number" class="form-control" name="sequence" min="0" value="{{ $seq }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="text-black">Products (max 3)</label>
                                                                    <select class="form-control product-select2" name="products[]" multiple>
                                                                        @foreach($products as $p)
                                                                            @php $selected = in_array($p->id, $productIds); @endphp
                                                                            @php $disabled = !$selected && isset($usedProductIds[$p->id]); @endphp
                                                                            <option value="{{ $p->id }}" @if($selected) selected @endif @if($disabled) disabled class="disabled-option" @endif>
                                                                                {{ $p->id }} - {{ $p->product_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="form-hint">Produk yang sudah digunakan akan di-disable, kecuali yang saat ini ada di kombinasi ini.</div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" class="btn btn-primary" style="color:white!important;">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

<!-- Add Combination Modal -->
<div class="modal fade" id="addCombinationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black">Add Combination</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addComboForm" method="POST" action="{{ route('admin.add-combination', ['id' => $user->id]) }}">
                    @csrf
                    <div class="form-group">
                        <label class="text-black">Set</label>
                        <select class="form-control" name="set_boost" id="modal_set_boost">
                            <option value="1" {{ $selectedSet === 1 ? 'selected' : '' }}>Set 1</option>
                            <option value="2" {{ $selectedSet === 2 ? 'selected' : '' }}>Set 2</option>
                            <option value="3" {{ $selectedSet === 3 ? 'selected' : '' }}>Set 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="text-black">Sequence (0-based)</label>
                        <input type="number" class="form-control" name="sequence" id="modal_sequence" min="0" value="0">
                        <div class="form-hint">Tidak boleh duplikat untuk set yang sama.</div>
                    </div>
                    <div class="form-group">
                        <label class="text-black">Products (max 3)</label>
                        <select class="form-control product-select2" name="products[]" id="modal_products" multiple>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" @if(isset($usedProductIds[$p->id])) disabled class="disabled-option" @endif>
                                    {{ $p->id }} - {{ $p->product_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-hint">Produk yang sudah digunakan akan di-disable.</div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" style="color:white!important;">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('customScript')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Initialize select2 if available
        if (window.$ && $.fn.select2) {
            $('.product-select2').select2({ width: '100%', maximumSelectionLength: 3, placeholder: 'Select up to 3 products' });
        }

        // Enforce 3 items max for all multiples even without select2
        document.querySelectorAll('select[multiple]').forEach(function(sel){
            sel.addEventListener('change', function(){
                if (this.selectedOptions.length > 3) {
                    alert('Max 3 products per combination');
                    this.options[this.selectedOptions[this.selectedOptions.length-1].index].selected = false;
                }
            });
        });

        // Prevent submitting duplicate sequence on modal by quick client-side check
        const addForm = document.getElementById('addComboForm');
        if (addForm) {
            addForm.addEventListener('submit', function(e){
                const setVal = document.getElementById('modal_set_boost').value;
                const seqVal = document.getElementById('modal_sequence').value;
                const tableCard = document.querySelectorAll('.card')[parseInt(setVal, 10)];
                if (tableCard) {
                    // Check existing sequences by reading from first column text
                    const seqCells = tableCard.querySelectorAll('tbody tr td:first-child');
                    for (const el of seqCells) {
                        const existing = parseInt(el.innerText.trim(), 10);
                        if (existing === parseInt(seqVal, 10)) {
                            e.preventDefault();
                            alert('Sequence already exists in this set.');
                            return false;
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
