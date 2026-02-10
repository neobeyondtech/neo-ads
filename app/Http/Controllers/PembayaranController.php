<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();

       /* if (request('tab') === 'berjalan') {
            $pembayaran = $pembayaran->where('status', 'Berjalan');
        }*/
        $pembayaran = Pembayaran::where('user_id', $user->id)
            ->with('iklan')
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();

        $riwayatDeposit = Deposit::where('user_id', $user->id)
            ->where('status', 'Berhasil')
            ->orderBy('tanggal_transaksi', 'desc')
            ->limit(10)
            ->get();

        // Hitung saldo deposit
        $saldoDeposit = Deposit::where('user_id', $user->id)
            ->where('status', 'Berhasil')
            ->sum('jumlah');

        // Hitung total pengeluaran
        $totalPengeluaran = Pembayaran::where('user_id', $user->id)
            ->where('status', 'Berhasil')
            ->sum('jumlah');

        $saldoAkhir = $saldoDeposit - $totalPengeluaran;

        return view('customer.payment.index', compact('pembayaran', 'riwayatDeposit', 'saldoAkhir'));
    }
}