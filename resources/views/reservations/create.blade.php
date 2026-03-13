@extends('layouts.app')
@section('title', 'Check In Tamu Baru')
@section('page-title', 'Check In Tamu Baru')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('reservations.index') }}">Reservasi</a></li>
    <li class="breadcrumb-item active">Check In Baru</li>
@endsection

@section('content')
<form method="POST" action="{{ route('reservations.store') }}" id="checkin-form">
@csrf
<div class="row g-4">
    <!-- Left column -->
    <div class="col-lg-8">

        <!-- Room Selection -->
        <div class="form-section">
            <div class="form-section-title">
                <i class="bi bi-door-open-fill"></i> Informasi Kamar
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tipe Kamar</label>
                    <select class="form-select" id="room_type_filter">
                        <option value="">— Semua Tipe —</option>
                        @foreach($room_types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }} — Rp {{ number_format($type->price_per_night,0,',','.') }}/malam</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nomor Kamar <span class="text-danger">*</span></label>
                    <select name="room_id" id="room_id" class="form-select" required>
                        <option value="">— Pilih Kamar —</option>
                        @foreach($available_rooms as $room)
                        <option value="{{ $room->id }}"
                            data-type="{{ $room->room_type_id }}"
                            data-price="{{ $room->roomType->price_per_night }}"
                            data-typename="{{ $room->roomType->name }}"
                            data-capacity="{{ $room->roomType->max_capacity }}">
                            Kamar {{ $room->room_number }} — {{ $room->roomType->name }} (Lantai {{ $room->floor }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah Tamu <span class="text-danger">*</span></label>
                    <input type="number" name="num_persons" class="form-control" min="1" max="10" value="1" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tgl Kedatangan <span class="text-danger">*</span></label>
                    <input type="date" name="arrival_date" class="form-control" value="{{ date('Y-m-d') }}" required id="arrival_date">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Waktu Kedatangan</label>
                    <input type="time" name="arrival_time" class="form-control" value="{{ date('H:i') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tgl Keberangkatan <span class="text-danger">*</span></label>
                    <input type="date" name="departure_date" class="form-control" id="departure_date" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nomor Kotak Deposit</label>
                    <input type="text" name="safety_deposit_box" class="form-control" placeholder="Contoh: SDB-05">
                </div>
                <div class="col-md-4">
                    <label class="form-label">No. Member</label>
                    <input type="text" name="member_number" class="form-control" placeholder="Opsional">
                </div>
            </div>
        </div>

        <!-- Guest Data -->
        <div class="form-section">
            <div class="form-section-title">
                <i class="bi bi-person-vcard-fill"></i> Data Tamu
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Tulis nama lengkap" required style="font-size:1rem;font-weight:600;">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pekerjaan / Profesi</label>
                    <input type="text" name="profession" class="form-control" placeholder="Contoh: Pegawai Negeri">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Perusahaan / Instansi</label>
                    <input type="text" name="company" class="form-control" placeholder="Nama perusahaan">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kebangsaan</label>
                    <input type="text" name="nationality" class="form-control" value="Indonesia">
                </div>
                <div class="col-md-4">
                    <label class="form-label">No. KTP</label>
                    <input type="text" name="id_card_number" class="form-control" placeholder="16 digit">
                </div>
                <div class="col-md-4">
                    <label class="form-label">No. Passport</label>
                    <input type="text" name="passport_number" class="form-control" placeholder="Untuk WNA">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="birth_date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Telepon / Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="021-xxxxxxx">
                </div>
                <div class="col-md-4">
                    <label class="form-label">HP / Mobile</label>
                    <input type="text" name="mobile_phone" class="form-control" placeholder="08xxxxxxxxxx">
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-control" rows="2" placeholder="Alamat lengkap tamu"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@domain.com">
                </div>
            </div>
        </div>
    </div>

    <!-- Right column — Summary -->
    <div class="col-lg-4">
        <div class="card" style="position:sticky;top:80px;">
            <div class="card-header">
                <i class="bi bi-receipt-cutoff me-2 text-success"></i>Ringkasan Booking
            </div>
            <div class="card-body">
                <div id="summary-placeholder" class="text-center text-muted py-4">
                    <i class="bi bi-door-open" style="font-size:2.5rem;opacity:.3;display:block;margin-bottom:8px;"></i>
                    <span style="font-size:.85rem;">Pilih kamar untuk melihat ringkasan</span>
                </div>
                <div id="summary-box" style="display:none;">
                    <div style="background:var(--ppkd-soft);border-radius:12px;padding:16px;margin-bottom:16px;">
                        <div style="font-size:.75rem;color:#6b8f78;text-transform:uppercase;letter-spacing:.05em;margin-bottom:6px;">Kamar</div>
                        <div style="font-size:1.4rem;font-weight:800;" id="s-room">—</div>
                        <div style="font-size:.82rem;color:#6b8f78;" id="s-type">—</div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span style="font-size:.83rem;color:#6b8f78;">Tarif per malam</span>
                        <span style="font-weight:600;font-size:.9rem;" id="s-rate">—</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span style="font-size:.83rem;color:#6b8f78;">Jumlah malam</span>
                        <span style="font-weight:600;font-size:.9rem;" id="s-nights">—</span>
                    </div>
                    <hr style="border-color:var(--ppkd-border);">
                    <div class="d-flex justify-content-between">
                        <span style="font-weight:700;">Total</span>
                        <span style="font-weight:800;color:var(--ppkd-accent);font-size:1.1rem;" id="s-total">—</span>
                    </div>
                </div>

                @if($errors->any())
                <div class="alert alert-danger mt-3" style="border-radius:10px;font-size:.82rem;padding:12px;">
                    @foreach($errors->all() as $e)
                    <div>• {{ $e }}</div>
                    @endforeach
                </div>
                @endif

                <button type="submit" class="btn btn-ppkd w-100 mt-3">
                    <i class="bi bi-person-check-fill me-2"></i>Proses Check In
                </button>
                <a href="{{ route('reservations.index') }}" class="btn btn-ppkd-outline w-100 mt-2">Batal</a>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@push('scripts')
<script>
const rooms = @json($available_rooms->keyBy('id'));
const roomSelect = document.getElementById('room_id');
const typeFilter = document.getElementById('room_type_filter');
const arrDate = document.getElementById('arrival_date');
const depDate = document.getElementById('departure_date');

// Set min departure to day after arrival
arrDate.addEventListener('change', () => {
    const d = new Date(arrDate.value);
    d.setDate(d.getDate() + 1);
    depDate.min = d.toISOString().split('T')[0];
    if (!depDate.value || depDate.value <= arrDate.value) {
        depDate.value = d.toISOString().split('T')[0];
    }
    updateSummary();
});

// Set default departure to tomorrow
const tomorrow = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);
depDate.value = tomorrow.toISOString().split('T')[0];
depDate.min = tomorrow.toISOString().split('T')[0];

typeFilter.addEventListener('change', () => {
    const tid = typeFilter.value;
    for (let opt of roomSelect.options) {
        if (!opt.value) continue;
        opt.hidden = tid ? opt.dataset.type !== tid : false;
    }
    roomSelect.value = '';
    updateSummary();
});

roomSelect.addEventListener('change', updateSummary);
depDate.addEventListener('change', updateSummary);

function updateSummary() {
    const rid = roomSelect.value;
    const arr = arrDate.value;
    const dep = depDate.value;
    const box = document.getElementById('summary-box');
    const placeholder = document.getElementById('summary-placeholder');

    if (!rid || !arr || !dep) { box.style.display = 'none'; placeholder.style.display = ''; return; }

    const room = rooms[rid];
    const nights = Math.max(1, Math.round((new Date(dep) - new Date(arr)) / 86400000));
    const total = room.room_type.price_per_night * nights;

    document.getElementById('s-room').textContent = 'Kamar ' + room.room_number;
    document.getElementById('s-type').textContent = room.room_type.name + ' · Lantai ' + room.floor;
    document.getElementById('s-rate').textContent = 'Rp ' + Number(room.room_type.price_per_night).toLocaleString('id-ID');
    document.getElementById('s-nights').textContent = nights + ' malam';
    document.getElementById('s-total').textContent = 'Rp ' + total.toLocaleString('id-ID');

    box.style.display = 'block';
    placeholder.style.display = 'none';
}
</script>
@endpush
