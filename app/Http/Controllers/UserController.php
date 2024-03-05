<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $user = DB::table('users')->get();
        return view('user', ['user' => $user]);
    }
    public function delete($id)
    {
        // mengambil data user berdasarkan id yang dipilih
        DB::table('users')->where('id', $id)->delete();
        return redirect('/user');
    }
}
