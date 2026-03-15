@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center my-3">
        <h2>Tipe Kamar</h2>
        <a href="{{ route('room-types.create') }}" class="btn btn-primary">
            + Tambah Tipe Kamar
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Kode</th>
                        <th>Harga/Malam</th>
                        <th>Kapasitas</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roomTypes as $rt)
                    <tr>
                        <td><strong>{{ $rt->name }}</strong></td>
                        <td><span class="badge bg-primary">{{ $rt->code }}</span></td>
                        <td>Rp {{ number_format($rt->price_per_night, 0, ',', '.') }}</td>
                        <td>{{ $rt->max_capacity }} orang</td>
                        <td>{{ Str::limit($rt->description, 50) }}</td>
                        <td>
                            <a href="{{ route('room-types.edit', $rt) }}" 
                               class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" 
                                  action="{{ route('room-types.destroy', $rt) }}" 
                                  style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Hapus tipe kamar {{ $rt->name }}?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada tipe kamar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection