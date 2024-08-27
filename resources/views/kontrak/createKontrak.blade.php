@extends('layouts.app')
@section('content')
<div class="card mt-5">
    <div class="card-header">
        <h4>Form Pinjaman Customer</h4>
    </div>
    <form method="post" action="{{route('kontrak.store')}}" class="p-4">
        @csrf
        <div class="mb-3">
            <label for="client_name" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control @error('client_name') is-invalid @enderror" id="client_name" name="client_name">
            @error('client_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Tanggal Pinjaman</label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date">
            @error('date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
          <label for="jangka_waktu" class="form-label">Jangka Waktu</label>
          <div class="input-group mb-3">
            <select class="form-select @error('jangka_waktu') is-invalid @enderror" id="jangka_waktu" name="jangka_waktu">
              <option selected>Pilih Jangka Waktu</option>
              <option value="6">6</option>
              <option value="8">8</option>
              <option value="12">12</option>
              <option value="18">18</option>
              <option value="24">24</option>
              <option value="36">36</option>
            </select>
            <label class="input-group-text" for="jangka_waktu">/Bulan</label>
          </div>
            @error('jangka_waktu')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="otr" class="form-label ">Pinjaman</label>
            <div class="input-group">
              <span class="input-group-text">Rp</span>
              <input type="text" class="form-control @error('otr') is-invalid @enderror" id="otr" name="otr">
              <span class="input-group-text">.00</span>
            </div>
            @error('otr')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="dp" class="form-label">Uang Muka</label>
            <div class="input-group mb-3">
                <select class="form-select @error('dp') is-invalid @enderror" id="dp" name="dp">
                    <option selected>Uang Muka dalam persen</option>
                    <option value="10">10 %</option>
                    <option value="15">15 %</option>
                    <option value="20">20 %</option>
                    <option value="25">25 %</option>
                </select>
              <label class="input-group-text" for="dp">%</label>
            </div>
              @error('dp')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
              @enderror
          </div>

        {{-- <div class="mb-3">
            <label for="dp" class="form-label">Uang Muka</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="text" class="form-control @error('dp') is-invalid @enderror" id="dp" name="dp">
                <span class="input-group-text">.00</span>
            </div>
             @error('dp')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div> --}}

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>
@stop
