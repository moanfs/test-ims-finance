<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Tenor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        // dd($customer);
        return view('kontrak.showKontrak', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kontrak.createKontrak');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required',
            'client_name' => 'required|string|max:255',
            'otr' => 'required|numeric',
            // 'dp' => 'required|numeric',
            'dp' => 'required|in:10,15,20,25',
            'jangka_waktu' => 'required|in:6,8,12,18,24,36',
        ]);

        DB::beginTransaction();
        try {
            $count = Customer::count() + 1;
            $kontrak_no = 'AGR' . str_pad($count, 5, '0', STR_PAD_LEFT);
            $otr = $validated['otr'];
            $dp = $otr * $validated['dp'] / 100;
            // $dp = $uangmuka;
            $date = Carbon::parse($validated['date']);
            $pokok_utang = $otr - $dp;
            $jangka_waktu = $validated['jangka_waktu'];

            // Menentukan bunga berdasarkan jangka waktu
            if ($jangka_waktu <= 12) {
                $bunga = 12;
            } elseif ($jangka_waktu <= 24) {
                $bunga = 14;
            } else {
                $bunga = 16.5;
            }

            // Menghitung angsuran per bulan
            $angsuran_per_bulan = ($pokok_utang + ($pokok_utang * $bunga / 100)) / $jangka_waktu;

            // Menyimpan data ke tabel kontrak
            $kontrak = new Customer();
            $kontrak->kontrak_no = $kontrak_no;
            $kontrak->client_name = $validated['client_name'];
            $kontrak->otr = $otr;
            $kontrak->dp = $dp;
            $kontrak->pokok_utang = $pokok_utang;
            $kontrak->jangka_waktu = $jangka_waktu;
            $kontrak->bunga = $bunga;
            $kontrak->date = $date->toDateString();;
            $kontrak->save();

            // Mengisi tabel jadwal_angsuran
            for ($i = 1; $i <= $jangka_waktu; $i++) {
                $jadwal = new Tenor();
                $jadwal->customer_id = $kontrak->id;
                $jadwal->angsuran_ke = $i;
                $jadwal->angsuran_per_bulan = $angsuran_per_bulan;
                $jadwal->tanggal_jatuh_tempo =  $date->copy()->addMonths($i);;
                $jadwal->status_pembayaran = 'belum lunas';
                $jadwal->save();
            }

            DB::commit();
            return redirect()->to(route('kontrak.index'))->with('success', 'Kontrak dan jadwal angsuran berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $kontrak_no)
    {
        $customer = Customer::where('kontrak_no', $kontrak_no)->firstOrFail();
        $tahunSekarang = now()->year;
        $bulansekarang = now()->month;
        // dd($customer->id);
        $tenors = Tenor::with('customer')
            ->where('customer_id', $customer->id)
            ->orderBy('status_pembayaran', 'desc')
            ->get();
        $totalBelumDibayar = Tenor::where('customer_id', $customer->id)
            ->where('status_pembayaran', 'belum lunas')
            ->whereYear('tanggal_jatuh_tempo', '<=', $tahunSekarang)
            ->whereMonth('tanggal_jatuh_tempo', '<=', $bulansekarang)
            ->sum('angsuran_per_bulan');

        $totalAngsuran = $tenors->where('status_pembayaran', 'lunas')->sum('angsuran_per_bulan');

        return view('kontrak.showTenor', [
            'customer' => $customer,
            'tenors' => $tenors,
            'totalAngsuran' => $totalAngsuran,
            'totalBelumDibayar' => $totalBelumDibayar
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
