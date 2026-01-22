<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\SaldoUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KasController extends Controller
{
    public function getDataKasMasuk(Request $request)
    {
        $user = $request->user();
        //ORM
        $dataKasMasuk = Kas::where('jenis_2210046', 'masuk')->where('iduser_2210046', $user->id)->get();
        return response()->json([
            'data' => $dataKasMasuk
        ]);
    }
    private function createNoTransaksiKasMasuk($tanggal)
    {
        $randomNumber = rand(0000, 99999);
        $formatTanggal = date('dmY', strtotime($tanggal));
        $noTransaksi = 'M' . $formatTanggal . $randomNumber;
        return $noTransaksi;
    }
    public function insertDataKasMasuk(Request $request)
    {
        $request->validate([
            'tgl' => 'required|date',
            'jmluang' => 'required|numeric',
            'ket' => 'required|string|max:255',
        ], [
            'tgl.required' => 'Tanggal wajib diisi.',
            'tgl.date' => 'Tanggal harus berupa format yang valid.',
            'jmluang.required' => 'Jumlah uang masuk wajib diisi.',
            'jmluang.numeric' => 'Jumlah uang masuk harus berupa angka.',
            'ket.required' => 'Keterangan wajib diisi.',
        ]);
        DB::beginTransaction();
        try {
            $noTransaksi = $this->createNoTransaksiKasMasuk($request->tgl);
            $user = $request->user();
            $kas = Kas::create([
                'notrans_2210046' => $noTransaksi,
                'tanggal_2210046' => $request->tgl,
                'jumlahuang_2210046' => $request->jmluang,
                'keterangan_2210046' => $request->ket,
                'iduser_2210046' => $user->id,
                'jenis_2210046' => 'masuk',
            ]);
            // update saldo
            $dataSaldoUser = SaldoUser::where('iduser_2210046', $user->id)->first();
            $dataSaldoUser->jumlahsaldo_2210046 = $dataSaldoUser->jumlahsaldo_2210046 +
                $request->jmluang;
            $dataSaldoUser->save();
            DB::commit();
            return response()->json([
                'message' => 'Data kas masuk berhasil ditambahkan!',
                'data' => $kas
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'msg' => 'Error : ' . $e->getMessage()
            ]);
        }
    }
    public function getDetailKasMasuk(Request $request, $notrans)
    {
       $user = $request->user();
       $dataKasMasuk = Kas::where('notrans_2210046', $notrans)->where('iduser_2210046', $user->id)->first();

       if(!$dataKasMasuk){
           return response()->json([
               'status' => 'error',
               'msg' => 'Data kas masuk tidak ditemukan'
           ]);
       }
       return response()->json([
           'data' => $dataKasMasuk
       ]);
    }

    public function deleteDataKasMasuk(Request $request, $notrans)
    {
        DB::beginTransaction();
        try {
            $kas = Kas::where('notrans_2210046', $notrans)->first();
            if (!$kas) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Data kas tidak ditemukan!'
                ], 404);
            }
            // Update saldo sebelum menghapus data kas
        $dataSaldoUser = SaldoUser::where('iduser_2210046', $kas->iduser_2210046)->first();
        
        // Validasi saldo tidak boleh negatif
        if (($dataSaldoUser->jumlahsaldo_2210046 - $kas->jumlahuang_2210046) < 0) {
            return response()->json([
                'status' => false,
                'msg' => 'Penghapusan gagal! Saldo tidak mencukupi dan akan menjadi negatif.'
            ], 400);
        }

        $dataSaldoUser->jumlahsaldo_2210046 = $dataSaldoUser->jumlahsaldo_2210046 - $kas->jumlahuang_2210046;
            $dataSaldoUser->save();
            $kas->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data kas masuk berhasil dihapus!'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function updateDataKasMasuk(Request $request, $notrans)
        {
        $request->validate([
            'tgl' => 'required|date',
            'jmluang' => 'required|numeric',
            'ket' => 'required|string|max:255',
        ], [
            'tgl.required' => 'Tanggal wajib diisi.',
            'tgl.date' => 'Tanggal harus berupa format yang valid.',
            'jmluang.required' => 'Jumlah uang masuk wajib diisi.',
            'jmluang.numeric' => 'Jumlah uang masuk harus berupa angka.',
            'ket.required' => 'Keterangan wajib diisi.',
        ]);
        DB::beginTransaction();
        try {
            $kas = Kas::where('notrans_2210046', $notrans)->first();
            if (!$kas) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Data kas tidak ditemukan!'
                ], 404);
            }
            $dataSaldoUser = SaldoUser::where('iduser_2210046', $kas->iduser_2210046)->first();
        
        // Validasi saldo tidak boleh negatif
        $saldoBaru = $dataSaldoUser->jumlahsaldo_2210046 - $kas->getOriginal('jumlahuang_2210046') + $request->jmluang;
        if ($saldoBaru < 0) {
            return response()->json([
                'status' => false,
                'msg' => 'Pembaruan gagal! Saldo tidak mencukupi dan akan menjadi negatif.'
            ], 400);
        }

        $dataSaldoUser->jumlahsaldo_2210046 = $saldoBaru;
            $dataSaldoUser->save();
            $kas->tanggal_2210046 = $request->tgl;
            $kas->jumlahuang_2210046 = $request->jmluang;
            $kas->keterangan_2210046 = $request->ket;
            $kas->save();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data kas masuk berhasil diperbarui!',
                'data' => $kas,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'Error: ' . $e->getMessage()
            ]);
        }
  }

    public function getDataKasKeluar(Request $request)
    {
        $user = $request->user();
        $dataKasKeluar = Kas::where('jenis_2210046', 'keluar')->where('iduser_2210046', $user->id)->get();
        return response()->json([
            'data' => $dataKasKeluar
        ]);
    }
    private function createNoTransaksiKasKeluar($tanggal)
    {
        $randomNumber = rand(0000, 99999);
        $formatTanggal = date('dmY', strtotime($tanggal));
        $noTransaksi = 'K' . $formatTanggal . $randomNumber; // Kode K untuk Keluar
        return $noTransaksi;
    }
    public function insertDataKasKeluar(Request $request)
    {
        $request->validate([
            'tgl' => 'required|date',
            'jmluang' => 'required|numeric',
            'ket' => 'required|string|max:255',
        ], [
            'tgl.required' => 'Tanggal wajib diisi.',
            'tgl.date' => 'Tanggal harus berupa format yang valid.',
            'jmluang.required' => 'Jumlah uang keluar wajib diisi.',
            'jmluang.numeric' => 'Jumlah uang keluar harus berupa angka.',
            'ket.required' => 'Keterangan wajib diisi.',
        ]);
        DB::beginTransaction();
        try {
            $noTransaksi = $this->createNoTransaksiKasKeluar($request->tgl);
            $user = $request->user();
            $kas = Kas::create([
                'notrans_2210046' => $noTransaksi,
                'tanggal_2210046' => $request->tgl,
                'jumlahuang_2210046' => $request->jmluang,
                'keterangan_2210046' => $request->ket,
                'iduser_2210046' => $user->id,
                'jenis_2210046' => 'keluar',
            ]);
            // update saldo (Berkurang untuk kas keluar)
        $dataSaldoUser = SaldoUser::where('iduser_2210046', $user->id)->first();
        
        // Validasi saldo tidak boleh negatif
        if (($dataSaldoUser->jumlahsaldo_2210046 - $request->jmluang) < 0) {
            return response()->json([
                'status' => false,
                'msg' => 'Saldo tidak mencukupi untuk melakukan pengeluaran kas.'
            ], 400);
        }

        $dataSaldoUser->jumlahsaldo_2210046 = $dataSaldoUser->jumlahsaldo_2210046 - $request->jmluang;
            $dataSaldoUser->save();
            DB::commit();
            return response()->json([
                'message' => 'Data kas keluar berhasil ditambahkan!',
                'data' => $kas
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'msg' => 'Error : ' . $e->getMessage()
            ]);
        }
    }
    public function getDetailKasKeluar(Request $request, $notrans)
    {
       $user = $request->user();
       $dataKasKeluar = Kas::where('notrans_2210046', $notrans)->where('iduser_2210046', $user->id)->first();
       if(!$dataKasKeluar){
           return response()->json([
               'status' => 'error',
               'msg' => 'Data kas keluar tidak ditemukan'
           ]);
       }
       return response()->json([
           'data' => $dataKasKeluar
       ]);
    }
    public function deleteDataKasKeluar(Request $request, $notrans)
    {
        DB::beginTransaction();
        try {
            $kas = Kas::where('notrans_2210046', $notrans)->first();
            if (!$kas) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Data kas tidak ditemukan!'
                ], 404);
            }
            // Update saldo sebelum menghapus data kas (Ditambah kembali karena kas keluar dihapus)
            $dataSaldoUser = SaldoUser::where('iduser_2210046', $kas->iduser_2210046)->first();
            $dataSaldoUser->jumlahsaldo_2210046 = $dataSaldoUser->jumlahsaldo_2210046 + $kas->jumlahuang_2210046;
            $dataSaldoUser->save();
            $kas->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data kas keluar berhasil dihapus!'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    public function updateDataKasKeluar(Request $request, $notrans)
    {
        $request->validate([
            'tgl' => 'required|date',
            'jmluang' => 'required|numeric',
            'ket' => 'required|string|max:255',
        ], [
            'tgl.required' => 'Tanggal wajib diisi.',
            'tgl.date' => 'Tanggal harus berupa format yang valid.',
            'jmluang.required' => 'Jumlah uang keluar wajib diisi.',
            'jmluang.numeric' => 'Jumlah uang keluar harus berupa angka.',
            'ket.required' => 'Keterangan wajib diisi.',
        ]);
        DB::beginTransaction();
        try {
            $kas = Kas::where('notrans_2210046', $notrans)->first();
            if (!$kas) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Data kas tidak ditemukan!'
                ], 404);
            }
            // Koreksi Saldo: Kembalikan saldo lama (+), Kurangi saldo baru (-)
        $dataSaldoUser = SaldoUser::where('iduser_2210046', $kas->iduser_2210046)->first();
        
        // Validasi saldo tidak boleh negatif
        $saldoBaru = $dataSaldoUser->jumlahsaldo_2210046 + $kas->getOriginal('jumlahuang_2210046') - $request->jmluang;
        if ($saldoBaru < 0) {
            return response()->json([
                'status' => false,
                'msg' => 'Pembaruan gagal! Saldo tidak mencukupi dan akan menjadi negatif.'
            ], 400);
        }

        $dataSaldoUser->jumlahsaldo_2210046 = $saldoBaru;
            $dataSaldoUser->save();
            $kas->tanggal_2210046 = $request->tgl;
            $kas->jumlahuang_2210046 = $request->jmluang;
            $kas->keterangan_2210046 = $request->ket;
            $kas->save();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data kas keluar berhasil diperbarui!',
                'data' => $kas,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'msg' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}

