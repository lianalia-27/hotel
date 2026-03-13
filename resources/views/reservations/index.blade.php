@extends('layouts.app')
@section('title', 'Daftar Reservasi')
@section('page-title', 'Daftar Reservasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Reservasi</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <span><i class="bi bi-calendar2-check-fill me-2 text-success"></i>Semua Reservasi</span>
        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama / booking…" value="{{ request('search') }}" style="width:200px;">
                <select name="status" class="form-select form-select-sm" style="width:160px;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="reserved"    {{ request('status') === 'reserved'    ? 'selected' : '' }}>Reservasi</option>
                    <option value="checked_in"  {{ request('status') === 'checked_in'  ? 'selected' : '' }}>Check In</option>
                    <option value="checked_out" {{ request('status') === 'checked_out' ? 'selected' : '' }}>Check Out</option>
                    <option value="cancelled"   {{ request('status') === 'cancelled'   ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button class="btn btn-ppkd btn-sm">Cari</button>
            </form>
            <a href="{{ route('reservations.create') }}" class="btn btn-ppkd btn-sm">
                <i class="bi bi-plus-lg me-1"></i>Check In Baru
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No. Booking</th>
                        <th>Nama Tamu</th>
                        <th>Kamar</th>
                        <th>Tipe</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Malam</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($reservations as $res)
                    <tr>
                        <td style="font-weight:600;font-size:.8rem;color:var(--ppkd-accent);">{{ $res->booking_number }}</td>
                        <td style="font-weight:600;">{{ $res->guest->name }}</td>
                        <td>{{ $res->room->room_number }}</td>
                        <td>{{ $res->room->roomType->name }}</td>
                        <td>{{ $res->arrival_date->format('d/m/Y') }}</td>
                        <td>{{ $res->departure_date->format('d/m/Y') }}</td>
                        <td class="text-center">{{ $res->total_nights }}</td>
                        <td>Rp {{ number_format($res->total_amount,0,',','.') }}</td>
                        <td><span class="badge-status badge-{{ $res->status }}">{{ $res->status_label }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('reservations.show', $res) }}" class="btn btn-sm btn-ppkd-outline" title="Detail">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('reservations.print', $res) }}" class="btn btn-sm" style="border-radius:8px;border:1.5px solid #d4edda;color:var(--ppkd-muted);" target="_blank" title="Cetak">
                                    <i class="bi bi-printer-fill"></i>
                                </a>
                                @if($res->status === 'checked_in')
                                <form method="POST" action="{{ route('reservations.checkout', $res) }}" onsubmit="return confirm('Konfirmasi Check Out tamu {{ $res->guest->name }}?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm" style="border-radius:8px;background:#fee2e2;color:#991b1b;border:none;" title="Check Out">
                                        <i class="bi bi-box-arrow-right"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox" style="font-size:2rem;display:block;opacity:.3;margin-bottom:8px;"></i>
                            Tidak ada data reservasi
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($reservations->hasPages())
    <div class="card-footer d-flex justify-content-end" style="background:#fff;border-top:1px solid var(--ppkd-border);border-radius:0 0 16px 16px;">
        {{ $reservations->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
