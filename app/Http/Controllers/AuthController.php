<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SaldoUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        //simpan ke tabel saldousers_2210046
        SaldoUser::create([
            'iduser_2210046' => $user->id,
            'jumlahsaldo_2210046' => 0,
        ]);
        return response()->json(['message' => 'User registered successfully!', 'data' => $user], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $user = Auth::user();
            $user->ip_address = $request->ip();
            $user->user_agent = $request->header('User-Agent');
            $user->fcmtoken = $request->token_fcm;
            $user->save();
            // Buat token
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token]);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });
        return response()->json(['message' => 'Logged out successfully!']);
    }
    public function dataPengguna(Request $request)
    {
        $user = $request->user();
        return response()->json(['user' => $user]);
    }
    public function updateUser(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            if ($request->password !== $request->password_confirmation) {
                return response()->json(['message' => 'Password confirmation does not match'], 400);
            }
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json(['message' => 'User updated successfully!', 'data' => $user]);
    }

   public function updateUserPhoto(Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,jpg,png|max:5120',
    ]);

    $user = $request->user();
    $file = $request->file('photo');

    $timestamp = time();
    $extension = $file->getClientOriginalExtension();

    $fileName      = $timestamp . '.' . $extension;
    $fileNameThumb = 'thumb_' . $timestamp . '.' . $extension;

    // hapus foto lama (AMAN DI RAILWAY)
    if ($user->photo) {
        $oldPhoto = str_replace('/storage/', '', $user->photo);
        Storage::disk('public')->delete($oldPhoto);
    }

    if ($user->photo_thumb) {
        $oldThumb = str_replace('/storage/', '', $user->photo_thumb);
        Storage::disk('public')->delete($oldThumb);
    }

    // simpan foto utama
    $photoPath = $file->storeAs('photos', $fileName, 'public');

    // buat thumbnail di memory → simpan ke storage
    $image = Image::read($file)->scaleDown(width: 200);
    $thumbPath = 'photos/thumbnail/' . $fileNameThumb;

    Storage::disk('public')->put(
        $thumbPath,
        (string) $image->encode()
    );

    // simpan path ke database
    $user->photo       = '/storage/' . $photoPath;
    $user->photo_thumb = '/storage/' . $thumbPath;
    $user->save();

    return response()->json([
        'message' => 'Foto berhasil diperbarui!',
        'foto' => $user->photo,
        'foto_thumb' => $user->photo_thumb,
    ], 200);
}
    public function getSaldoUser(Request $request)
    {
        $user = $request->user();
        $dataSaldo = SaldoUser::where('iduser_2210046', $user->id)->first();

        return response()->json([
            'data' => $dataSaldo
        ]);
    }
}
