@extends('layouts.app')
@section('title', 'Status Kamar')
@section('page-title', 'Status Kamar')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Status Kamar</li>
@endsection

@section('content')

<!-- Legend + Summary -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-door-open-fill"></i></div>
            <div><div class="stat-value">{{ $rooms->where('status','available')->count() }}</div><div class="stat-label">Tersedia</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon red"><i class="bi bi-person-fill"></i></div>
            <div><div class="stat-value">{{ $rooms->where('status','occupied')->count() }}</div><div class="stat-label">Terisi</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon yellow"><i class="bi bi-brush-fill"></i></div>
            <div><div class="stat-value">{{ $rooms->where('status','cleaning')->count() }}</div><div class="stat-label">Dibersihkan</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-tools"></i></div>
            <div><div class="stat-value">{{ $rooms->where('status','maintenance')->count() }}</div><div class="stat-label">Maintenance</div></div>
        </div>
    </div>
</div>

<!-- Rooms by Floor -->
@foreach($by_floor->sortKeysDesc() as $floor => $floorRooms)
<div class="card mb-4">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-building text-success"></i>
        <span>Lantai {{ $floor }}</span>
        <span class="ms-auto" style="font-size:.78rem;color:#6b8f78;">{{ $floorRooms->count() }} kamar</span>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($floorRooms as $room)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="room-card {{ $room->status }} h-100" style="border-radius:14px;position:relative;">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <span class="room-number">{{ $room->room_number }}</span>
                        @if($room->status === 'cleaning')
                        <span style="font-size:1.1rem;" title="Sedang dibersihkan">🧹</span>
                        @elseif($room->status === 'occupied')
                        <span style="font-size:1.1rem;" title="Terisi">🔴</span>
                        @elseif($room->status === 'available')
                        <span style="font-size:1.1rem;" title="Tersedia">✅</span>
                        @else
                        <span style="font-size:1.1rem;" title="Maintenance">🔧</span>
                        @endif
                    </div>

                    <span class="room-type-badge" style="
                        background:{{ $room->status === 'available' ? '#b8e4c9' : ($room->status === 'occupied' ? '#f5b7b7' : ($room->status === 'cleaning' ? '#fde68a' : '#e5e7eb')) }};
                        color:{{ $room->status === 'available' ? '#1b4332' : ($room->status === 'occupied' ? '#7b2020' : ($room->status === 'cleaning' ? '#78350f' : '#374151')) }};
                    ">{{ $room->roomType->code }}</span>

                    <div style="font-size:.72rem;color:#6b7280;margin-top:6px;">
                        Rp {{ number_format($room->roomType->price_per_night/1000,0,',','.') }}k/mlm
                    </div>

                    @if($room->activeReservation)
                    <div style="font-size:.72rem;font-weight:600;margin-top:4px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $room->activeReservation->guest->name }}">
                        {{ Str::limit($room->activeReservation->guest->name, 12) }}
                    </div>
                    <div style="font-size:.68rem;color:#6b7280;">
                        s/d {{ $room->activeReservation->departure_date->format('d/m') }}
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-2 d-flex gap-1 flex-wrap">
                        @if($room->status === 'cleaning')
                        <form method="POST" action="{{ route('rooms.cleaned', $room) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm" style="background:#d1fae5;color:#065f46;border:none;border-radius:6px;font-size:.7rem;padding:3px 8px;font-weight:600;" title="Tandai sudah bersih">
                                ✓ Bersih
                            </button>
                        </form>
                        @endif
                        @if($room->status === 'available' && auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('rooms.maintenance', $room) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm" style="background:#f3f4f6;color:#374151;border:none;border-radius:6px;font-size:.7rem;padding:3px 8px;" title="Tandai maintenance">
                                🔧
                            </button>
                        </form>
                        @endif
                        @if($room->status === 'available')
                        <a href="{{ route('reservations.create') }}?room={{ $room->id }}" class="btn btn-sm" style="background:var(--ppkd-primary);color:#fff;border:none;border-radius:6px;font-size:.7rem;padding:3px 8px;font-weight:600;">
                            + Tamu
                        </a>
                        @endif
                        @if($room->activeReservation)
                        <a href="{{ route('reservations.show', $room->activeReservation) }}" class="btn btn-sm" style="background:rgba(0,0,0,.06);color:#374151;border:none;border-radius:6px;font-size:.7rem;padding:3px 8px;">
                            👁
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endforeach

@if(auth()->user()->isAdmin())
<!-- Add Room (Admin only) -->
<div class="card">
    <div class="card-header"><i class="bi bi-plus-circle-fill me-2 text-success"></i>Tambah Kamar Baru</div>
    <div class="card-body">
        <form method="POST" action="{{ route('rooms.store') }}" class="row g-3 align-items-end">
            @csrf
            <div class="col-md-3">
                <label class="form-label">Nomor Kamar</label>
                <input type="text" name="room_number" class="form-control" placeholder="Contoh: 0703" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tipe Kamar</label>
                <select name="room_type_id" class="form-select" required>
                    @foreach($room_types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }} — Rp {{ number_format($type->price_per_night,0,',','.') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Lantai</label>
                <input type="number" name="floor" class="form-control" min="1" max="50" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-ppkd w-100">Tambah Kamar</button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
