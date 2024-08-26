@extends('layouts.app')
@section('content')
<div class="card mt-5">
    <div class="card-header">
        <h4>Form Pembayaran Customer</h4>
    </div>
    <form method="post" action="{{ route('tempo', $customer->id) }}" class="p-4">
        @method('PUT')
        @csrf
        <div class="mb-3">
            <label for="date" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ $customer->client_name }}" disabled>
            @error('date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">No Kontrak</label>
            <input type="text" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ $customer->kontrak_no }}" disabled>
            @error('date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Telat Pembayaran (Hari)</label>
            <input type="text" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ $hariTerlambat }}" disabled>
            @error('date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="otr" class="form-label ">Total Denda</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="text" class="form-control @error('otr') is-invalid @enderror" id="otr" name="otr" value="{{ number_format($denda, 2, ',', '.') }}" disabled>
            </div>
            @error('otr')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="dp" class="form-label">Total Angsuran Belum Bayar</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="text" class="form-control @error('dp') is-invalid @enderror" id="dp" name="dp" value="{{ number_format($totalBelumDibayar, 2, ',', '.') }}" disabled>
            </div>
            @error('dp')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="dp" class="form-label">Total Yang Harus Dibayar</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="text" class="form-control @error('dp') is-invalid @enderror" id="total_pembayaran" name="total_pembayaran" value="{{ number_format($totalPembayaran, 2, ',', '.') }}" disabled>
            </div>
            @error('dp')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Bayar</button>
    </form>
</div>
@stop
