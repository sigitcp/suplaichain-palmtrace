@extends('layouts.master')
@section('container')

<div class="conatiner-fluid content-inner py-3">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4>Daftar Seluruh Petani</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            <table id="lahan-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                                <thead>
                                    <tr class="ligth">
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th style="min-width: 100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($petani as $p)
                                    <tr>
                                        <td class="text-center">
                                            @if($p->foto)
                                            <img class="bg-primary-subtle rounded img-fluid avatar-40 me-3"
                                                src="{{ asset('storage/' . $p->foto) }}" alt="profile">
                                            @else
                                            <img class="bg-primary-subtle rounded img-fluid avatar-40 me-3"
                                                src="./assets/images/avatars/01.png" alt="profile">
                                            @endif
                                        </td>
                                        <td>{{ $p->username }}</td>
                                        <td>
                                            <span class="badge bg-primary">Petani</span>
                                        </td>
                                        <td>
                                            <div class="flex align-items-center list-lahan-action">
                                                <a href="{{ route('kelola-lahan', $p->id) }}"
                                                    class="btn btn-sm btn-icon btn-warning"
                                                    title="Kelola Lahan">
                                                    <span class="btn-inner">Kelola Lahan</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data petani</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection