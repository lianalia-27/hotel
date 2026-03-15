@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header"><h5>Edit Tipe Kamar — {{ $roomType->name }}</h5></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('room-types.update', $roomType) }}">
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Tipe *</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name', $roomType->name) }}" required>
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kode *</label>
                            <input type="text" name="code" class="form-control"
                                   value="{{ old('code', $roomType->code) }}"
                                   maxlength="10" style="text-transform:uppercase" required>
                            @error('code') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga per Malam (Rp) *</label>
                            <input type="number" name="price_per_night" class="form-control"
                                   value="{{ old('price_per_night', $roomType->price_per_night) }}" required>
                            @error('price_per_night') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kapasitas Maksimal *</label>
                            <input type="number" name="max_capacity" class="form-control"
                                   value="{{ old('max_capacity', $roomType->max_capacity) }}" min="1" required>
                            @error('max_capacity') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" 
                                      rows="3">{{ old('description', $roomType->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fasilitas</label>
                            <input type="text" name="facilities" class="form-control"
                                   value="{{ old('facilities', $roomType->facilities) }}"
                                   placeholder="AC, TV, WiFi, Kulkas">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('room-types.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection