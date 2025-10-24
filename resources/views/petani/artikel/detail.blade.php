@extends('layouts.master')
@section('container')

<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h3>{{ $artikel->judul }}</h3>
            <p class="text-muted">
                Ditulis oleh: {{ $artikel->author->name ?? '-' }} • {{ $artikel->created_at->format('d M Y') }}
            </p>

            @if($artikel->thumbnail)
                <img src="{{ asset('storage/'.$artikel->thumbnail) }}" class="img-fluid rounded mb-3" alt="thumbnail">
            @endif

            <div style="white-space: pre-line; font-size: 1.05rem;">
                {{ $artikel->isi }}
            </div>

            <a href="{{ route('artikel.index.petani') }}" class="btn btn-secondary mt-3">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

@endsection
