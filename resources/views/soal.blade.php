@extends('master')

@section('content')
    <h1 class="fs-3 fw-semibold">Data Soal</h1>
    @if (Auth::user()->role == 'guru')
        <button class="btn btn-info mt-2" data-bs-toggle="modal" data-bs-target="#TambahSoal">+ Tambah Tugas</button>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle mt-3">
            <thead class="align-center">
                <tr>
                    <th scope="col">ID Tugas</th>
                    <th scope="col">Judul Materi</th>
                    <th scope="col">Deskripsi Tugas</th>
                    <th scope="col">Batas Waktu</th>
                    <th scope="col">Opsi</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($soal as $s)
                    <tr>
                        <th scope="row">{{ $s->id_soal }}</th>
                        <td>{{ $s->judul_materi }}</td>
                        <td>{{ $s->deskripsi_soal }}</td>
                        <td>{{ $s->batas_waktu }}</td>
                        <td>
                            @if (Auth::user()->role == 'guru')
                                <button class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#EditSoal{{ $s->id_soal }}">Edit</button>
                                <button class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#DeleteSoal{{ $s->id_soal }}">Delete</button>
                            @elseif (Auth::user()->role == 'siswa')
                                @if ($s->jawaban_soal > 0)
                                    <button class="btn btn-success">Selesai</button>
                                @else
                                    @if ($s->batas_waktu < date('Y-m-d'))
                                        <button class="btn btn-danger">Waktu Habis</button>
                                    @else
                                        <button class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#WorkSoal{{ $s->id_soal }}">Kerjakan</button>
                                    @endif
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @foreach ($soal as $s)
        <!-- Form Update -->
        <div class="modal fade" id="EditSoal{{ $s->id_soal }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Soal</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/soal/storeupdate" method="post">
                            @csrf
                            <input type="hidden" name="idsoal" value="{{ $s->id_soal }}">
                            <div class="mb-3">
                                <label for="judulmateri" class="form-label">Judul Materi</label>
                                <input type="text" id="judulmateri" name="judulmateri" required="required"
                                    class="form-control" value="{{ $s->judul_materi }}">
                            </div>
                            <div class="mb-3">
                                <label for="deskripsisoal" class="form-label">Deskripsi Tugas</label>
                                <textarea class="form-control" id="deskripsisoal" name="deskripsisoal" rows="5">{{ $s->deskripsi_soal }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="bataswaktu" class="form-label">Tenggat Waktu</label>
                                <input type="date" id="bataswaktu" name="bataswaktu" required="required"
                                    class="form-control" value="{{ $s->batas_waktu }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Delete -->
        <div class="modal fade" id="DeleteSoal{{ $s->id_soal }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Soal</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/soal/delete/{{ $s->id_soal }}" method="get">
                            @csrf
                            <div>
                                <h3>Yakin mau menghapus data <b>{{ $s->judul_materi }}</b> ?</h3>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Kerjakan -->
        <div class="modal fade" id="WorkSoal{{ $s->id_soal }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Kerjakan Soal</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/nilai/storeinput" method="post">
                            @csrf
                            <input type="hidden" name="idsoal" readonly class="form-control"
                                value="{{ $s->id_soal }}">
                            <div class="mb-2">
                                <p>Judul Materi : {{ $s->judul_materi }}</p>
                            </div>
                            <div class="mb-2">
                                <p>Deskripsi Tugas : {{ $s->deskripsi_soal }}</p>
                            </div>
                            <div class="mb-2">
                                <p>Batas Waktu : {{ $s->batas_waktu }}</p>
                            </div>
                            <div class="mb-2">
                                <label for="jawaban_soal" class="form-label">Jawaban</label>
                                <textarea class="form-control" id="jawaban_soal" name="jawaban_soal" rows="7"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Form Tambah -->
    <div class="modal fade" id="TambahSoal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Soal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/soal/storeinput" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="judulmateri" class="form-label">Judul Materi</label>
                            <input type="text" id="judulmateri" name="judulmateri" required="required"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsisoal" class="form-label">Deskripsi Tugas</label>
                            <textarea class="form-control" id="deskripsisoal" name="deskripsisoal" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="bataswaktu" class="form-label">Tenggat Waktu</label>
                            <input type="date" id="bataswaktu" name="bataswaktu" required="required"
                                class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
