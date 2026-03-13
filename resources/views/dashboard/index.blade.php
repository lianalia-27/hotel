@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-door-open-fill"></i></div>
            <div>
                <div class="stat-value">{{ $stats['available_rooms'] }}</div>
                <div class="stat-label">Kamar Tersedia</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon red"><i class="bi bi-person-fill-check"></i></div>
            <div>
                <div class="stat-value">{{ $stats['occupied_rooms'] }}</div>
                <div class="stat-label">Kamar Terisi</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon yellow"><i class="bi bi-stars"></i></div>
            <div>
                <div class="stat-value">{{ $stats['cleaning_rooms'] }}</div>
                <div class="stat-label">Sedang Dibersihkan</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-calendar2-check"></i></div>
            <div>
                <div class="stat-value">{{ $stats['active_reservations'] }}</div>
                <div class="stat-label">Reservasi Aktif</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Room Map -->
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-map-fill me-2 text-success"></i>Peta Kamar Real-Time</span>
                <div class="d-flex gap-2">
                    <span class="badge-status badge-available">Tersedia</span>
                    <span class="badge-status badge-occupied">Terisi</span>
                    <span class="badge-status badge-cleaning">Bersih-bersih</span>
                </div>
            </div>
            <div class="card-body p-3">
                @foreach($rooms->groupBy('floor')->sortKeysDesc() as $floor => $floorRooms)
                <div class="mb-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span style="font-size:.72rem;font-weight:700;color:#6b8f78;text-transform:uppercase;letter-spacing:.06em;">Lantai {{ $floor }}</span>
                        <div style="flex:1;height:1px;background:#e8f5ee;"></div>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($floorRooms as $room)
                        <a href="{{ route('rooms.index') }}" class="text-decoration-none">
                            <div class="room-card {{ $room->status }}" style="min-width:90px;">
                                <div class="room-number">{{ $room->room_number }}</div>
                                <span class="room-type-badge" style="
                                    background:{{ $room->status === 'available' ? '#b8e4c9' : ($room->status === 'occupied' ? '#f5b7b7' : '#f7dc6f') }};
                                    color:{{ $room->status === 'available' ? '#1b4332' : ($room->status === 'occupied' ? '#7b2020' : '#7d5a00') }};
                                ">{{ $room->roomType->code }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Reservations -->
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2 text-success"></i>Aktivitas Terbaru</span>
                <a href="{{ route('reservations.index') }}" class="btn btn-ppkd-outline btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @forelse($recent_reservations as $res)
                <div class="d-flex align-items-center gap-3 px-4 py-3" style="border-bottom:1px solid #f0faf4;">
                    <div style="width:40px;height:40px;border-radius:50%;background:var(--ppkd-primary-lt);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--ppkd-accent);font-size:.85rem;flex-shrink:0;">
                        {{ strtoupper(substr($res->guest->name, 0, 2)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-weight:600;font-size:.88rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $res->guest->name }}</div>
                        <div style="font-size:.75rem;color:#6b8f78;">Kamar {{ $res->room->room_number }} • {{ $res->room->roomType->name }}</div>
                    </div>
                    <span class="badge-status badge-{{ $res->status }}">{{ $res->status_label }}</span>
                </div>
                @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px;opacity:.4;"></i>
                    Belum ada reservasi
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-3 mt-1">
    <div class="col-12">
        <div class="card">
            <div class="card-body d-flex flex-wrap gap-3 align-items-center">
                <span style="font-weight:700;color:#6b8f78;font-size:.85rem;">Aksi Cepat:</span>
                <a href="{{ route('reservations.create') }}" class="btn btn-ppkd">
                    <i class="bi bi-person-plus-fill me-2"></i>Check In Tamu Baru
                </a>
                <a href="{{ route('rooms.index') }}" class="btn btn-ppkd-outline">
                    <i class="bi bi-door-open me-2"></i>Kelola Kamar
                </a>
                <a href="{{ route('reservations.index') }}?status=checked_in" class="btn btn-ppkd-outline">
                    <i class="bi bi-box-arrow-right me-2"></i>Proses Check Out
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
