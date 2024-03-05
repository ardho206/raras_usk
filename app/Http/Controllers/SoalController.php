<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SoalController extends Controller
{
    public function index()
    {
        $soal = DB::table('soal')->leftJoin('nilai', function ($join) {
            $join->on('soal.id_soal', '=', 'nilai.id_soal')->where('nilai.id_user', '=', Auth::user()->id);
        })->select('soal.*', DB::raw('IFNULL(nilai.id_user, 0) AS jawaban_soal'))->get();

        return view('soal', ['soal' => $soal]);
    }

    public function storeinput(Request $request)
    {
        if ($request->bataswaktu < date('Y-m-d')) {
            return redirect()->back()->with('error', 'Waktu Tidak Valid');
        }

        DB::table('soal')->insert([
            'judul_materi' => $request->judulmateri,
            'deskripsi_soal' => $request->deskripsisoal,
            'batas_waktu' => $request->bataswaktu
        ]);

        return redirect('/soal')->with('status', 'Data berhasil ditambahkan');
    }

    public function storeupdate(Request $request)
    {
        if ($request->bataswaktu < date('Y-m-d')) {
            return redirect()->back()->with('error', 'Waktu Tidak Valid');
        }

        DB::table('soal')->where('id_soal', $request->idsoal)->update([
            'judul_materi' => $request->judulmateri,
            'deskripsi_soal' => $request->deskripsisoal,
            'batas_waktu' => $request->bataswaktu
        ]);

        return redirect('/soal');
    }

    public function delete($id)
    {
        // mengambil data user berdasarkan id yang dipilih
        DB::table('soal')->where('id_soal', $id)->delete();
        return redirect('/soal');
    }
}
