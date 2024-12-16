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

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Tangkap inputan user dari form
        $input = $request->input('username'); // contoh inputan user
        
        // Memanggil stored procedure dengan parameter
        $result = DB::select('EXEC sso_getAuthenticationKMS ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', [
            $input, null, null, null, null, null, null, null, null, null, 
            null, null, null, null, null, null, null, null, null, null, 
            null, null, null, null, null, null, null, null, null, null,
            null, null, null, null, null, null, null, null, null, null,
            null, null, null, null, null, null, null, null, null, null
        ]);

        // Periksa hasil query
        if (!empty($result)) {
            $roles = [];
        foreach ($result as $role) {
            $roles[] = [
                'id' => $role->RoleID,  // or whatever fields the role data has
                'name' => $role->Role,
            ];
        }

        // Store roles in the session
        session(['roles' => $roles]);

        // Set flag in session to show role selection modal
        session(['showRoleSelectionModal' => true]);

        //return redirect()->route('login');
        return redirect()->route('beranda_utama');
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Login gagal, data tidak ditemukan'
            ]);
        }
    }
}
