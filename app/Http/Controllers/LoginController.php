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

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Cookie::has('activeUser')) {
            return redirect('/');
        }

        return view('auth.login');
    }

    public function handleLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:50',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $response = Http::post(config('services.api_link') . 'Utilities/Login', [
                'username' => $request->username,
                'password' => $request->password,
            ]);

            if ($response->failed() || $response->json() === 'ERROR') {
                return back()->withErrors(['message' => 'Nama akun atau kata sandi salah.'])->withInput();
            }

            $data = $response->json();

            if ($data[0]['Status'] === 'LOGIN FAILED') {
                return back()->withErrors(['message' => 'Nama akun atau kata sandi salah.'])->withInput();
            }

            session(['listRole' => $data]);
            return view('auth.role-selection', ['roles' => $data]);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Terjadi kesalahan. Silakan coba lagi.'])->withInput();
        }
    }

    public function handleRoleSelection(Request $request)
    {
        $request->validate([
            'role' => 'required',
        ]);

        try {
            $ipAddress = $request->ip();

            $response = Http::post(config('services.api_link') . 'Utilities/CreateJWTToken', [
                'username' => session('listRole')[0]['NamaPengguna'],
                'role' => $request->role,
                'nama' => session('listRole')[0]['Nama'],
            ]);

            if ($response->failed() || $response->json() === 'ERROR') {
                return back()->withErrors(['message' => 'Gagal mendapatkan token autentikasi.']);
            }

            $token = $response->json()['Token'];

            $userInfo = [
                'username' => session('listRole')[0]['NamaPengguna'],
                'role' => $request->role,
                'nama' => session('listRole')[0]['Nama'],
                'peran' => $request->input('roleName'),
                'lastLogin' => null,
            ];

            $encryptedUserInfo = Encryptor::encrypt(json_encode($userInfo));

            Cookie::queue('activeUser', $encryptedUserInfo, 1440); // Expire in 1 day

            switch ($userInfo['peran']) {
                case 'PIC P-KNOW':
                case 'PIC Kelompok Keahlian':
                case 'Tenaga Pendidik':
                    return redirect('/beranda_utama');
                case 'Program Studi':
                    return redirect('/beranda_prodi');
                case 'Tenaga Kependidikan':
                    return redirect('/beranda_tenaga_kependidikan');
                case 'Mahasiswa':
                    return redirect('/beranda_mahasiswa');
                default:
                    return redirect('/');
            }
        } catch (\Exception $e) {
            Log::error('Role selection error: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }
}
