@extends('layouts.app')
@section('title', 'Detail Reservasi')
@section('page-title', 'Detail Reservasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">Reservasi</a></li>
    <li class="breadcrumb-item active">{{ $reservation->booking_number }}</li>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <!-- Guest Info Card -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-person-vcard-fill me-2 text-success"></i>Data Tamu</span>
                <span class="badge-status badge-{{ $reservation->status }}">{{ $reservation->status_label }}</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @php
                    $fields = [
                        ['Nama Lengkap', $reservation->guest->name, 12],
                        ['Pekerjaan', $reservation->guest->profession, 6],
                        ['Perusahaan', $reservation->guest->company, 6],
                        ['Kebangsaan', $reservation->guest->nationality, 4],
                        ['No. KTP', $reservation->guest->id_card_number, 4],
                        ['No. Passport', $reservation->guest->passport_number, 4],
                        ['Tgl Lahir', optional($reservation->guest->birth_date)->format('d/m/Y'), 4],
                        ['No. Telepon', $reservation->guest->phone, 4],
                        ['No. HP', $reservation->guest->mobile_phone, 4],
                        ['Email', $reservation->guest->email, 6],
                        ['Alamat', $reservation->guest->address, 12],
                        ['No. Member', $reservation->guest->member_number, 6],
                    ];
                    @endphp
                    @foreach($fields as [$label, $value, $col])
                    <div class="col-md-{{ $col }}">
                        <div style="font-size:.73rem;font-weight:700;color:#6b8f78;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">{{ $label }}</div>
                        <div style="font-size:.9rem;font-weight:500;">{{ $value ?: '—' }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Room Info Card -->
        <div class="card">
            <div class="card-header"><i class="bi bi-door-open-fill me-2 text-success"></i>Informasi Kamar & Menginap</div>
            <div class="card-body">
                <div class="row g-3">
                    @php
                    $roomFields = [
                        ['No. Booking', $reservation->booking_number, 6],
                        ['Kamar', $reservation->room->room_number, 3],
                        ['Tipe Kamar', $reservation->room->roomType->name, 3],
                        ['Jml Tamu', $reservation->num_persons . ' orang', 3],
                        ['Jml Kamar', '1', 3],
                        ['Tgl Kedatangan', $reservation->arrival_date->format('d F Y'), 4],
                        ['Waktu Kedatangan', $reservation->arrival_time ?? '—', 4],
                        ['Tgl Keberangkatan', $reservation->departure_date->format('d F Y'), 4],
                        ['Jumlah Malam', $reservation->total_nights . ' malam', 3],
                        ['Tarif/Malam', 'Rp ' . number_format($reservation->room_rate,0,',','.'), 3],
                        ['Total', 'Rp ' . number_format($reservation->total_amount,0,',','.'), 3],
                        ['Kotak Deposit', $reservation->safety_deposit_box ?? '—', 3],
                        ['Dikeluarkan oleh', $reservation->issued_by ?? '—', 6],
                        ['Tanggal Dikeluarkan', optional($reservation->issued_date)->format('d/m/Y') ?? '—', 6],
                    ];
                    @endphp
                    @foreach($roomFields as [$label, $value, $col])
                    <div class="col-md-{{ $col }}">
                        <div style="font-size:.73rem;font-weight:700;color:#6b8f78;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px;">{{ $label }}</div>
                        <div style="font-size:.9rem;font-weight:{{ in_array($label, ['Total','No. Booking']) ? '700' : '500' }};color:{{ $label === 'Total' ? 'var(--ppkd-accent)' : 'inherit' }};">{{ $value }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Action Sidebar -->
    <div class="col-lg-4">
        <div class="card" style="position:sticky;top:80px;">
            <div class="card-header"><i class="bi bi-lightning-fill me-2 text-success"></i>Aksi</div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="{{ route('reservations.print', $reservation) }}" target="_blank" class="btn btn-ppkd">
                    <i class="bi bi-printer-fill me-2"></i>Cetak Formulir Registrasi
                </a>
                @if($reservation->status === 'checked_in')
                <form method="POST" action="{{ route('reservations.checkout', $reservation) }}"
                      onsubmit="return confirm('Konfirmasi Check Out tamu {{ $reservation->guest->name }}?')">
                    @csrf
                    <button type="submit" class="btn w-100" style="background:#fee2e2;color:#991b1b;border-radius:10px;font-weight:600;border:none;padding:10px;">
                        <i class="bi bi-box-arrow-right me-2"></i>Proses Check Out
                    </button>
                </form>
                @endif
                <a href="{{ route('reservations.index') }}" class="btn btn-ppkd-outline">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Resepsionis info -->
        <div class="card mt-3">
            <div class="card-body" style="font-size:.83rem;">
                <div style="font-weight:700;color:#6b8f78;margin-bottom:10px;font-size:.72rem;text-transform:uppercase;letter-spacing:.06em;">Info Sistem</div>
                <div class="d-flex justify-content-between mb-1">
                    <span style="color:#6b8f78;">Resepsionis</span>
                    <span style="font-weight:600;">{{ $reservation->user->name }}</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span style="color:#6b8f78;">Dibuat</span>
                    <span>{{ $reservation->created_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($reservation->checked_in_at)
                <div class="d-flex justify-content-between mb-1">
                    <span style="color:#6b8f78;">Check In</span>
                    <span>{{ $reservation->checked_in_at->format('d/m/Y H:i') }}</span>
                </div>
                @endif
                @if($reservation->checked_out_at)
                <div class="d-flex justify-content-between">
                    <span style="color:#6b8f78;">Check Out</span>
                    <span>{{ $reservation->checked_out_at->format('d/m/Y H:i') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
