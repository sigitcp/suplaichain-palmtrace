@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
    <h4 class="fw-bold mb-4">Artikel Edukasi untuk Petani</h4>

    <div class="row g-4">
        @forelse ($artikels as $artikel)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    @if($artikel->thumbnail)
                        <img src="{{ asset('storage/'.$artikel->thumbnail) }}" class="card-img-top" alt="thumbnail" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="no image" style="height: 200px; object-fit: cover;">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary">{{ $artikel->judul }}</h5>
                        <p class="text-muted mb-2" style="font-size: 0.9rem;">
                            Ditulis oleh: {{ $artikel->author->name ?? '-' }} <br>
                            <small>{{ $artikel->created_at->format('d M Y') }}</small>
                        </p>
                        <p class="card-text flex-grow-1" style="font-size: 0.95rem; color: #555;">
                            {{ Str::limit(strip_tags($artikel->isi), 120) }}
                        </p>
                        <a href="{{ route('petani.artikel.detail', $artikel->id) }}" class="btn btn-outline-primary mt-auto w-100">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="alert alert-warning">Belum ada artikel yang dipublikasikan.</div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $artikels->links() }}
    </div>
</div>

@endsection
