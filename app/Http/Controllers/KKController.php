<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Services\Encryptor;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\DB;

class KKController extends Controller
{
    
    public function index()
    {
        $dataFilterSort = [
            ['Value' => '[Nama Kelompok Keahlian] asc', 'Text' => 'Nama Kelompok Keahlian [↑]'],
            ['Value' => '[Nama Kelompok Keahlian] desc', 'Text' => 'Nama Kelompok Keahlian [↓]'],
        ];

        $dataFilterStatus = [
            ['Value' => '', 'Text' => 'Semua'],
            ['Value' => 'Menunggu', 'Text' => 'Menunggu PIC Prodi'],
            ['Value' => 'Draft', 'Text' => 'Draft'],
            ['Value' => 'Aktif', 'Text' => 'Aktif'],
            ['Value' => 'Tidak Aktif', 'Text' => 'Tidak Aktif'],
        ];

        return view('page.master-pic-pknow.KelolaKK.KelolaKK', compact('dataFilterSort', 'dataFilterStatus'));
    }

    public function getTempDataKK(Request $request)
    {
        $dataFilterSort = [
            ['Value' => '[Nama Kelompok Keahlian] asc', 'Text' => 'Nama Kelompok Keahlian [↑]'],
            ['Value' => '[Nama Kelompok Keahlian] desc', 'Text' => 'Nama Kelompok Keahlian [↓]'],
        ];

        $dataFilterStatus = [
            ['Value' => '', 'Text' => 'Semua'],
            ['Value' => 'Menunggu', 'Text' => 'Menunggu PIC Prodi'],
            ['Value' => 'Draft', 'Text' => 'Draft'],
            ['Value' => 'Aktif', 'Text' => 'Aktif'],
            ['Value' => 'Tidak Aktif', 'Text' => 'Tidak Aktif'],
        ];

        $params = [
            $request->input('page', 1),                // @p1: Halaman saat ini
            $request->input('query', ''),             // @p2: Filter "Nama Kelompok Keahlian"
            $request->input('sort', '[Nama Kelompok Keahlian] ASC'), // @p3: Urutan
            $request->input('status', ''),            // @p4: Filter status
            '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',
        ];

        try {
            // Panggil stored procedure
            $data = DB::select('EXEC pknow_getTempDataKelompokKeahlian ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', $params);

            // Jika hasil kosong
            if (count($data) === 0) {
                return response()->json(['message' => 'Tidak ada data.'], 404);
            }

            // Return hasil sebagai JSON
            return view('page.master-pic-pknow.KelolaKK.KelolaKK', compact('dataFilterSort', 'dataFilterStatus'))->with('data', $data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}