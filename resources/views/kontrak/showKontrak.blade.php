@extends('layouts.app')
@section('content')
   <div class="card">
        <div class="card-header">
            <h5>Tabel Pinjaman Pelanggan</h5>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No Kontrak</th>
                    <th scope="col">Nama Pelanggan</th>
                    <th scope="col">OTR</th>
                    <th scope="col">Bunga</th>
                    <th scope="col">Tenor</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $index => $customer)
                <tr>
                    <td>{{$customer->kontrak_no}}</td>
                    <td>{{$customer->client_name}}</td>
                    <td>Rp. {{ number_format($customer->otr, 2, ',', '.') }}</td>
                    <td>{{$customer->bunga}}%</td>
                    <td>{{$customer->jangka_waktu}} Bulan</td>
                    <td>
                        <a href="{{route('kontrak.show' , $customer->kontrak_no)}}" class="btn btn-primary">Lihat</a>
                    </td>
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
