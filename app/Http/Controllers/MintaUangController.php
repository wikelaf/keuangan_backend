<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MintaUang;   
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\SaldoUser;
use App\Models\Kas;
use App\Models\User;


class MintaUangController extends Controller
{
    private function createNoReferensi($idUser = null)
    {
        $randomNumber = rand(0000, 99999);
        $formatTanggal = date('dmYHis', strtotime(Carbon::now()));
        $noTransaksi = 'MU' . $formatTanggal . $randomNumber . $idUser;
        return $noTransaksi;
    }

    public function insertDataMintaUang(Request $request)
    {
        $request->validate([
            'jmluang' => 'required|numeric',
        ], [
            'jmluang.required' => 'Jumlah uang masuk wajib diisi.',
            'jmluang.numeric' => 'Jumlah uang masuk harus berupa angka.',
        ]);
        $simpanTransaksi = MintaUang::create([
            'noref_2210046' => $this->createNoReferensi($request->user()->id),
            'dari_iduser_2210046' => $request->user()->id,
            'jumlahuang_2210046' => $request->jmluang,
            'stt_2210046' => 'pending'
        ]);
        return response()->json([
            'status' => true,
            'pesan' => 'Permintaan Uang berhasil dilakukan, silahkan disimpan Qr Code yang telah disediakan atau di ScreenShoot.',
            'data' => $simpanTransaksi,
        ]);
    }

    public function getDataDetail(Request $request, $noReferensi)
    {
        $cekData = MintaUang::join('users', 'users.id', '=','dari_iduser_2210046')
        ->select([
            'noref_2210046',
            'tglminta_2210046',
            'dari_iduser_2210046',
            DB::raw('users.name AS dari_namauser'),
            'jumlahuang_2210046'
        ])->where('noref_2210046', $noReferensi)->first();
        if ($cekData) {
            if ($cekData->dari_iduser_2210046 === $request->user()->id) {
                return response()->json([
                    'status' => false,
                    'pesan' => 'Tidak bisa di proses, Qr Code berasal dari permintaan anda sendiri'], 404);
                } else {
                    return response()->json([
                    'status' => true,
                    'result' => $cekData
                ], 200);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'pesan' => 'Data QR tidak terdaftar di sistem'
                ], 404);
            }
    }

    public function prosesPermintaan(Request $request, $noReferensi)
    {
        $jumlahdiMinta = $request->jmluang;
        $saldoUser = SaldoUser::where('iduser_2210046', $request->user()->id)->first();
        
        // cek saldo user yang memberikan (perbaikan nama field ke jumlahsaldo_2210046)
        $jumlahSaldo = $saldoUser->jumlahsaldo_2210046;
        if ($jumlahSaldo < $jumlahdiMinta) {
            return response()->json([
                'status' => false,
                'pesan' => 'Jumlah saldo tidak mencukupi untuk melakukan transfer.'
            ], 400);
        }
        DB::beginTransaction();
        try {
            // Kurangi saldo user yang mengirimkan uang
            $saldoUser->jumlahsaldo_2210046 = $saldoUser->jumlahsaldo_2210046 - $request->jmluang;
            $saldoUser->save();
            // update table minta uang
            $mintaUang = MintaUang::where('noref_2210046', $noReferensi)->first();
            $mintaUang->ke_iduser_2210046 = $request->user()->id;
            $mintaUang->stt_2210046 = 'sukses';
            $mintaUang->tglsukses_2210046 = Carbon::now();
            $mintaUang->save();
            // tambahkan saldo user yang menerima uang
            $saldoUserPenerima = SaldoUser::where('iduser_2210046', $mintaUang->dari_iduser_2210046)->first();
            $saldoUserPenerima->jumlahsaldo_2210046 = $saldoUserPenerima->jumlahsaldo_2210046 + $request->jmluang;
            $saldoUserPenerima->save();

            // Record to Kas table for the balance deduction (Giver/Scanner)
            $userPenerima = User::find($mintaUang->dari_iduser_2210046);
            $namaPenerima = $userPenerima ? $userPenerima->name : 'User';
            
            DB::table('kas_2210046')->insert([
                'notrans_2210046' => $noReferensi . '-OUT',
                'tanggal_2210046' => Carbon::now()->format('Y-m-d'),
                'jumlahuang_2210046' => $request->jmluang,
                'keterangan_2210046' => 'Bayar Scan QR ke ' . $namaPenerima,
                'iduser_2210046' => $request->user()->id,
                'jenis_2210046' => 'keluar',
            ]);

            // Record to Kas table for the balance addition (Requester/Receiver)
            DB::table('kas_2210046')->insert([
                'notrans_2210046' => $noReferensi . '-IN',
                'tanggal_2210046' => Carbon::now()->format('Y-m-d'),
                'jumlahuang_2210046' => $request->jmluang,
                'keterangan_2210046' => 'Terima Scan QR dari ' . $request->user()->name,
                'iduser_2210046' => $mintaUang->dari_iduser_2210046,
                'jenis_2210046' => 'masuk',
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'pesan' => 'Permintaan uang berhasil di proses.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'pesan' => 'Error : ' . $e->getMessage()
            ]);
        }
    }

    public function getDataMintaUang(Request $request)
    {
        $userId = $request->user()->id;
        $data = MintaUang::leftJoin('users', 'users.id', '=', 'ke_iduser_2210046')
            ->select([
                'noref_2210046',
                'tglminta_2210046',
                'jumlahuang_2210046',
                'stt_2210046',
                'tglsukses_2210046',
                DB::raw('users.name as nama_penerima')
            ])
            ->where('dari_iduser_2210046', $userId)
            ->orderBy('tglminta_2210046', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}


