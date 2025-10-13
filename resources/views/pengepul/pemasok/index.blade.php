@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5 class="mb-0" style="color: #858223;">Daftar Pemasok (Petani)</h5>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive border-bottom my-3">
                        <table id="datatable1" class="table table-striped dataTable text-center align-middle" data-toggle="data-table">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Petani</th>
                                    <th>Nomor HP</th>
                                    <th>Tanggal Terdaftar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($petanis as $index => $petani)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $petani->username ?? '-' }}</td>
                                    <td>{{ $petani->phone ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($petani->created_at)->format('d M Y') }}</td>
                                    <td>
                                        @if ($petani->verified == 1)
                                        <span class="badge bg-primary">Verified</span>
                                        @else
                                        <span class="badge bg-danger">Non Verified</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-muted text-center py-3">
                                        <h5>Belum ada petani yang terdaftar.</h5>
                                    </td>
                                </tr>
                            </tfoot>
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