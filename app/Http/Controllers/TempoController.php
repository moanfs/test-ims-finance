<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Tenor;

class TempoController extends Controller
{
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        // $tenor = Tenor::findOrFail($id);
        $bulansekarang = now()->month;
        $tahunSekarang = now()->year;
        // dd($bulansekarang);

        $totalBelumDibayar = Tenor::where('customer_id', $customer->id)
            ->where('status_pembayaran', 'belum lunas')
            ->whereYear('tanggal_jatuh_tempo', '<=', $tahunSekarang)
            ->whereMonth('tanggal_jatuh_tempo', '<=', $bulansekarang)
            ->sum('angsuran_per_bulan');

        if ($totalBelumDibayar <= 0) {
            return redirect()->back()->with('error', 'Semua tenor sudah dibayar.');
        }

        $tenors = Tenor::where('customer_id', $customer->id)
            ->where('status_pembayaran', 'belum lunas')
            ->whereYear('tanggal_jatuh_tempo', '<=', $tahunSekarang)
            ->whereMonth('tanggal_jatuh_tempo', '<=', $bulansekarang)
            ->get()->first();
        // dd($tenors);

        // if ($tenors->isEmpty()) {
        //     return redirect()->back()->with('error', 'Semua tenor sudah dibayar.');
        // }

        $totalDenda = 0;
        // $totalPembayaran = 0;
        $hariTerlambat = now()->diffInDays($tenors->tanggal_jatuh_tempo, false);
        // dd($hariTerlambat);
        if ($hariTerlambat < 0) {
            $denda = $tenors->angsuran_per_bulan * 0.001 * abs($hariTerlambat);
            $totalDenda += $denda;
        }
        // dd($totalDenda);
        $totalPembayaran = $totalDenda + $totalBelumDibayar;

        return view('pembayaran.showPembayaran', [
            'customer' => $customer,
            'hariTerlambat' => $hariTerlambat,
            'denda' => $totalDenda,
            'totalBelumDibayar' => $totalBelumDibayar,
            'totalPembayaran' => $totalPembayaran
        ]);
    }

    public function update($id)
    {
        $customer = Customer::findOrFail($id);
        $bulansekarang = now()->month;
        $tahunSekarang = now()->year;

        $totalBelumDibayar = Tenor::where('customer_id', $customer->id)
            ->where('status_pembayaran', 'belum lunas')
            ->whereYear('tanggal_jatuh_tempo', '<=', $tahunSekarang)
            ->whereMonth('tanggal_jatuh_tempo', '<=', $bulansekarang)
            ->sum('angsuran_per_bulan');

        $tenors = Tenor::where('customer_id', $customer->id)
            ->where('status_pembayaran', 'belum lunas')
            ->whereYear('tanggal_jatuh_tempo', '<=', $tahunSekarang)
            ->whereMonth('tanggal_jatuh_tempo', '<=', $bulansekarang)
            ->get()->first();

        $tenor = Tenor::where('customer_id', $customer->id)
            ->where('status_pembayaran', 'belum lunas')
            ->whereYear('tanggal_jatuh_tempo', '<=', $tahunSekarang)
            ->whereMonth('tanggal_jatuh_tempo', '<=', $bulansekarang)
            ->get();

        $totalDenda = 0;
        $hariTerlambat = now()->diffInDays($tenors->tanggal_jatuh_tempo);
        if ($hariTerlambat > 0) {
            $denda = $tenors->angsuran_per_bulan * 0.001 * $hariTerlambat;
            $totalDenda += $denda;
        }
        $totalPembayaran = $totalDenda + $totalBelumDibayar;

        foreach ($tenor as $ten) {
            $ten->status_pembayaran = 'lunas';
            $ten->total_pembayaran = $totalPembayaran;
            $ten->telat = $hariTerlambat;
            $ten->denda = $totalDenda;
            $ten->save(); // Simpan perubahan
        }

        return redirect()->to(route('kontrak.show', $customer->kontrak_no));
    }
}
