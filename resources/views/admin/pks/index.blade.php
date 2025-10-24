@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="header-title">
                        <h4>Daftar Seluruh PKS</h4>
                    </div>
                </div>

                <div class="card-body px-0">
                    <div class="table-responsive">
                        <table id="pks-list-table" class="table table-striped align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width: 80px;">Profil</th>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th class="text-center" style="min-width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pks as $p)
                                    <tr>
                                        <td class="text-center">
                                            @if($p->foto)
                                                <img src="{{ asset('storage/' . $p->foto) }}" 
                                                     alt="profile" 
                                                     class="bg-warning-subtle rounded-circle img-fluid avatar-40 shadow-sm">
                                            @else
                                                <img src="{{ asset('assets/images/avatars/01.png') }}" 
                                                     alt="profile" 
                                                     class="bg-warning-subtle rounded-circle img-fluid avatar-40 shadow-sm">
                                            @endif
                                        </td>

                                        <td class="fw-semibold">{{ $p->username ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-warning">PKS</span>
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('kelola-profil-pks', $p->id) }}"
                                               class="btn btn-sm btn-warning d-inline-flex align-items-center"
                                               title="Kelola Profil">
                                                Kelola Profil
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3">
                                            <em>Tidak ada data PKS yang tersedia.</em>
                                        </td>
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

@endsection
