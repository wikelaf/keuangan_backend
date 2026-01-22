<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\SaldoUser;
use App\Models\KirimUang;
use App\Models\Kas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;

class KirimUangController extends Controller
{
    private function createNoTransaksiKasMasuk()
    {
        $randomNumber = rand(0000, 99999);
        $formatTanggal = date('dmYHis', strtotime(Carbon::now()));
        $noTransaksi = 'KU' . $formatTanggal . $randomNumber;
        return $noTransaksi;
    }
    public function insertDataKirimUang(Request $request)
    {
        $request->validate([
            'email_penerima' => 'required|email',
            'jmluang' => 'required|numeric',
        ], [
            'email_penerima.required' => 'Email wajib diisi.',
            'email_penerima.email' => 'Alamat Email harus yang valid',
            'jmluang.required' => 'Jumlah uang masuk wajib diisi.',
            'jmluang.numeric' => 'Jumlah uang masuk harus berupa angka.',
        ]);
        // cek email penerima user 
        $ambiilDataUser = User::where('email', $request->email_penerima)->first();
        if ($ambiilDataUser) {
            $idUserPenerima = $ambiilDataUser->id;
            $idUserPengirim = $request->user()->id;
        // cek saldo user pengirim jika tidak cukup
        $dataSaldoUser = SaldoUser::where('iduser_2210046', $idUserPengirim)->first();
        $saldoUserPengirim = $dataSaldoUser->jumlahsaldo_2210046;
        if (intval($request->jmluang) > intval($saldoUserPengirim)) {
            return response()->json([
                'status' => false,
                'pesan' => 'Saldo anda tidak mencukupi',
            ]);
        } else {
            DB::beginTransaction();
            try {
                // Lakukan Pengurangan jumlah saldo user dan update data
                $dataSaldoUser->jumlahsaldo_2210046 = $dataSaldoUser->jumlahsaldo_2210046 -
                $request->jmluang;
                $dataSaldoUser->save();

                // simpan ke table kirim uang
                $kirimUang = new KirimUang();
                $kirimUang->noref_2210046 = $this->createNoTransaksiKasMasuk();
                $kirimUang->dari_iduser_2210046 = $idUserPengirim;
                $kirimUang->ke_iduser_2210046 = $idUserPenerima;
                $kirimUang->jumlahuang_2210046 = $request->jmluang;
                $kirimUang->save();
                // lakukan update saldo user penerima
                $saldoUserPenerima = SaldoUser::where('iduser_2210046', $idUserPenerima)->first();
                $saldoUserPenerima->jumlahsaldo_2210046 = $saldoUserPenerima->jumlahsaldo_2210046 + $request->jmluang;
                $saldoUserPenerima->save();

                // Record to Kas table for the balance deduction (Sender)
                Kas::create([
                    'notrans_2210046' => $kirimUang->noref_2210046 . '-OUT',
                    'tanggal_2210046' => Carbon::now()->format('Y-m-d'),
                    'jumlahuang_2210046' => $request->jmluang,
                    'keterangan_2210046' => 'Kirim Uang ke ' . $ambiilDataUser->name,
                    'iduser_2210046' => $idUserPengirim,
                    'jenis_2210046' => 'keluar',
                ]);

                // Record to Kas table for the balance addition (Receiver)
                Kas::create([
                    'notrans_2210046' => $kirimUang->noref_2210046 . '-IN',
                    'tanggal_2210046' => Carbon::now()->format('Y-m-d'),
                    'jumlahuang_2210046' => $request->jmluang,
                    'keterangan_2210046' => 'Terima Transfer Uang dari ' . $request->user()->name,
                    'iduser_2210046' => $idUserPenerima,
                    'jenis_2210046' => 'masuk',
                ]);

                $tokenFcmPenerima = $ambiilDataUser->fcm_token ?? null;

                if($tokenFcmPenerima != null || $tokenFcmPenerima != ''){
                    $messaging = Firebase::messaging();
                    $pesanKePenerima = 'Halo' . $ambiilDataUser->name . ' ada kiriman uang nih dari' . $request->user()->name . 'Sejumlah:' . $request->jmluang;
                    $message = CloudMessage::withTarget('token', $tokenFcmPenerima)
                    ->withNotification(['title' => 'Ada Kiriman Uang', 'body' => $pesanKePenerima])
                    ->withData(['key' => 'value']);
                    $messaging->send($message);
                }

                DB::commit();
                return response()->json([
                    'status' => true,
                    'pesan' => 'Kirim uang berhasil di lakukan'
                ], 201);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['pesan' => 'Gagal Eksekusi Data ' . $e->getMessage(), 'status' => false], 500);
            }
        }
    } else {
        return response()->json([
            'status' => false,
            'pesan' => 'Email yang anda input tidak ditemukan...'
        ]);
    }
    }

    public function getDataKirimUang(Request $request)
    {
        $userId = $request->user()->id;
        $data = KirimUang::join('users', 'users.id', '=', 'ke_iduser_2210046')
            ->select([
                'noref_2210046',
                'tglkirim_2210046',
                'jumlahuang_2210046',
                DB::raw('users.name as nama_penerima')
            ])
            ->where('dari_iduser_2210046', $userId)
            ->orderBy('tglkirim_2210046', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
    