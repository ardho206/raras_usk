@extends('master')

@section('content')
    <h1 class="fs-3 fw-semibold">Data User</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle mt-3">
            <thead class="align-center">
                <tr>
                    <th scope="col">ID User</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Opsi</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($user as $s)
                    <tr>
                        <th scope="row">{{ $s->id }}</th>
                        <td>{{ $s->name }}</td>
                        <td>{{ $s->email }}</td>
                        <td>{{ $s->role }}</td>
                        <td>
                            <button class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#DeleteUser{{ $s->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($user as $s)
        <!-- Form Delete -->
        <div class="modal fade" id="DeleteUser{{ $s->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/user/delete/{{ $s->id }}" method="get" class="form-floating">
                            @csrf
                            <div>
                                <h3>Yakin mau menghapus data user <b>{{ $s->name }}</b> ?</h3>
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
    @endforeach
@endsection
