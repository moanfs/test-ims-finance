@extends('layouts.app')
@section('content')
   <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Tabel Pinjaman Pelanggan</h4>
            <a href="{{route('tempo', $customer->id)}}" class="btn btn-primary">Bayar</a>
        </div>
        <div class="p-2">
            <h6>Detail Kontrak: {{ $customer->kontrak_no }}</h6>
            <p>Nama Pelanggan: {{ $customer->client_name }}</p>
            <p>Total Angsuran Lunas: Rp {{ number_format($totalAngsuran, 2, ',', '.') }}</p>
            <p>Total Yang Jatuh Tempo Rp {{ number_format($totalBelumDibayar, 2, ',', '.') }}</p>
        </div>
        @if ($message = Session::get('error'))
				<div class="alert alert-danger alert-block">
					<strong>{{ $message }}</strong>
				</div>
				@endif
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No Kontrak</th>
                    <th scope="col">Angsuran Ke</th>
                    <th scope="col">Angsuran / Bulan</th>
                    <th scope="col">Tanggal Jatuh Tempo</th>
                    <th scope="col">Status Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tenors as $index => $tenor)
                <tr>
                    <td>{{$tenor->customer->kontrak_no}}</td>
                    <td>{{$tenor->angsuran_ke}}</td>
                    <td>Rp. {{ number_format($tenor->angsuran_per_bulan, 2, ',', '.') }}</td>
                    <td>{{$tenor->tanggal_jatuh_tempo}}</td>
                    <td>{{$tenor->status_pembayaran}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">Tidak Ada Data Yang Dapat Ditampilkan</td>
                </tr>
                @endforelse

            </tbody>
        </table>
   </div>
@stop
