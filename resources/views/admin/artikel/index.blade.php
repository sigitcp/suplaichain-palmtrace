@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Kelola Artikel</h4>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahArtikelModal">
                + Tambah Artikel
            </button>
        </div>

        <div class="card-body">
            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="table-responsive mt-3">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Thumbnail</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($item->thumbnail)
                                        <img src="{{ asset('storage/'.$item->thumbnail) }}" alt="thumb" width="70" height="50" style="object-fit: cover; cursor:pointer;"
                                             data-bs-toggle="modal" data-bs-target="#fotoModal{{ $item->id }}">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->author->name ?? '-' }}</td>
                                <td>
                                    @if($item->published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('artikel.show', $item->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editArtikelModal{{ $item->id }}">Edit</button>
                                    <form action="{{ route('artikel.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Lihat Thumbnail --}}
                            <div class="modal fade" id="fotoModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-body text-center">
                                    <img src="{{ asset('storage/'.$item->thumbnail) }}" class="img-fluid rounded" alt="thumbnail">
                                  </div>
                                </div>
                              </div>
                            </div>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="editArtikelModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">Edit Artikel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{ route('artikel.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                      @csrf @method('PUT')
                                      <div class="mb-3">
                                        <label>Judul:</label>
                                        <input type="text" name="judul" value="{{ $item->judul }}" class="form-control" required>
                                      </div>
                                      <div class="mb-3">
                                        <label>Isi:</label>
                                        <textarea name="isi" rows="5" class="form-control" required>{{ $item->isi }}</textarea>
                                      </div>
                                      <div class="mb-3">
                                        <label>Thumbnail:</label>
                                        <input type="file" name="thumbnail" class="form-control">
                                      </div>
                                      <div class="form-check mb-3">
                                        <input type="checkbox" name="published" id="published{{ $item->id }}" class="form-check-input" {{ $item->published ? 'checked' : '' }}>
                                        <label class="form-check-label" for="published{{ $item->id }}">Publish Artikel</label>
                                      </div>
                                      <div class="text-end">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada artikel.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="tambahArtikelModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Artikel Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label>Judul:</label>
            <input type="text" name="judul" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Isi:</label>
            <textarea name="isi" rows="5" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label>Thumbnail:</label>
            <input type="file" name="thumbnail" class="form-control">
          </div>
          <div class="form-check mb-3">
            <input type="checkbox" name="published" id="published" class="form-check-input">
            <label class="form-check-label" for="published">Publish Artikel</label>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
