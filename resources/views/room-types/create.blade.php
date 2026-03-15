@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header"><h5>Tambah Tipe Kamar</h5></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('room-types.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Tipe *</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name') }}" placeholder="contoh: Deluxe" required>
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kode *</label>
                            <input type="text" name="code" class="form-control"
                                   value="{{ old('code') }}" placeholder="contoh: DLX" 
                                   maxlength="10" style="text-transform:uppercase" required>
                            @error('code') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga per Malam (Rp) *</label>
                            <input type="number" name="price_per_night" class="form-control"
                                   value="{{ old('price_per_night') }}" placeholder="350000" required>
                            @error('price_per_night') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kapasitas Maksimal *</label>
                            <input type="number" name="max_capacity" class="form-control"
                                   value="{{ old('max_capacity', 2) }}" min="1" required>
                            @error('max_capacity') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" 
                                      rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fasilitas</label>
                            <input type="text" name="facilities" class="form-control"
                                   value="{{ old('facilities') }}" 
                                   placeholder="AC, TV, WiFi, Kulkas (pisahkan dengan koma)">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('room-types.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection