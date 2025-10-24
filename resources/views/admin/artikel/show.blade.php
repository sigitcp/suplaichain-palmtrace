@extends('layouts.master')
@section('container')

<div class="container py-4">
    <div class="card">
        <div class="card-body">
            <h3>{{ $artikel->judul }}</h3>
            <p class="text-muted">Ditulis oleh: {{ $artikel->author->name ?? '-' }} • {{ $artikel->created_at->format('d M Y') }}</p>

            @if($artikel->thumbnail)
                <img src="{{ asset('storage/'.$artikel->thumbnail) }}" class="img-fluid rounded mb-3" alt="thumbnail">
            @endif

            <p style="white-space: pre-line;">{{ $artikel->isi }}</p>

            <a href="{{ route('artikel.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>

@endsection
