<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
      $title = 'Akun';
      $subtitle = 'Manajemen';
      $users = User::select('id', 'name', 'email', 'role', 'created_at')->get();
      return view('admin.user.index', compact('title', 'subtitle', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $title = 'Akun';
      $subtitle = 'Buat';
      return view('admin.user.create', compact('title', 'subtitle'));
    }

    public function store(Request $request)
{
  $validate = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|unique:users,email',
    'password' => 'required|confirmed|string|min:8',
    'role' => 'required|in:admin,petugas',
  ]);

  try {
    $validate['password'] = bcrypt($validate['password']);
    $user = User::create($validate);

    return response()->json([
      'status' => 200,
      'message' => 'Akun berhasil disimpan!',
    ]);
  } catch (\Exception $e) {
    return response()->json([
      'status' => 500,
      'message' => 'Terjadi kesalahan saat menyimpan data.',
      'error' => $e->getMessage(), // << Tambahkan ini untuk debugging
    ]);
  }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $user = User::findOrFail($id);
      $title = 'Akun';
      $subtitle = 'Edit';
      return view('admin.user.edit', compact('title', 'subtitle', 'user'));
    }

    public function update(Request $request, string $id)
    {
      $user = User::findOrFail($id);
      $validate = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'nullable|confirmed|string|min:8',
        'role' => 'required|in:admin,petugas',
      ],[
        'name.required' => 'Kolom nama lengkap harus diisi.',
        'required' => 'Kolom :attribute harus diisi.',
        'email.unique' => 'Email sudah digunakan, silahkan gunakan alamat email lain.',
        'confirmed' => 'Password dan Konfirmasi Password tidak cocok.',
      ]);

      $simpan = $user->update([
        'name' => $validate['name'],
        'email' => $validate['email'],
        'role' => $validate['role'],
        'password' => $validate['password'] ? bcrypt($validate['password']) : $user->password
      ]);

      if ($simpan) {
        return redirect()->route('users.index')->with('success', 'Akun berhasil diperbarui');
      } else {
        return redirect()->route('users.index')->with('error', 'Data gagal diperbarui');
      }
    }

    public function destroy(string $id)
    {
      try {

        $currentUserId = Auth::id();

        if ($currentUserId == $id) {
          return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Akun berhasil dihapus');
      } catch (\Exception $e) {
        return redirect()->route('users.index')->with('error', 'Akun gagal dihapus');
      }
    }

    public function login(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function registerStore(Request $request){
        $validate = $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8|same:password_confirmation',
        ]);

        $validate['password'] = bcrypt($validate['password']);

        $simpan = User::create($validate);
        if ($simpan) {
            return redirect()->route('login')->with('success', 'Registrasi Berhasil');
        } else {
            return redirect()->route('register ')->with('error', 'Registrasi Gagal');
        }
    }

    public function loginCheck(Request $request) {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($validate)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        } else {
            return back()->with('error', 'Login Gagal');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout Berhasil');
    }
}