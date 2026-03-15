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

    <!-- ═══════════════════════════════════
         KOLOM KIRI
    ═══════════════════════════════════ -->
    <div class="col-lg-8">

        <!-- Informasi Kamar -->
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

        <!-- Data Tamu -->
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

        <!-- ═══════════════════════════════════
             BARU: Informasi Konfirmasi / Booking
             (untuk bagian atas print)
        ═══════════════════════════════════ -->
        <div class="form-section">
            <div class="form-section-title">
                <i class="bi bi-envelope-paper-fill"></i> Informasi Konfirmasi Reservasi
                <small class="text-muted fw-normal ms-2" style="font-size:.75rem;">(untuk surat konfirmasi cetak)</small>
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Kepada (To)</label>
                    <input type="text" name="to_name" class="form-control"
                           placeholder="Nama penerima konfirmasi / perusahaan">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Company / Agent</label>
                    <input type="text" name="company_agent" class="form-control"
                           placeholder="Nama agen atau perusahaan pemesan">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Book By</label>
                    <input type="text" name="book_by" class="form-control"
                           placeholder="Nama yang memesan"
                           value="{{ auth()->user()->name ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone (Pemesan)</label>
                    <input type="text" name="contact_phone" class="form-control"
                           placeholder="No. telepon pemesan">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email (Pemesan)</label>
                    <input type="email" name="contact_email" class="form-control"
                           placeholder="Email pemesan">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Telp Hotel</label>
                    <input type="text" name="hotel_telp" class="form-control"
                           placeholder="021-xxxxxxx">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fax Hotel</label>
                    <input type="text" name="hotel_fax" class="form-control"
                           placeholder="021-xxxxxxx">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email Hotel</label>
                    <input type="email" name="hotel_email" class="form-control"
                           placeholder="hotel@ppkd.go.id">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal Booking</label>
                    <input type="date" name="booking_date" class="form-control"
                           value="{{ date('Y-m-d') }}">
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════
             BARU: Informasi Pembayaran / Jaminan
             (untuk bagian bawah print)
        ═══════════════════════════════════ -->
        <div class="form-section">
            <div class="form-section-title">
                <i class="bi bi-credit-card-2-front-fill"></i> Informasi Pembayaran & Jaminan
                <small class="text-muted fw-normal ms-2" style="font-size:.75rem;">(untuk surat konfirmasi cetak)</small>
            </div>

            {{-- Rekening Bank --}}
            <div class="mb-3" style="font-size:.82rem;font-weight:600;color:#6b8f78;text-transform:uppercase;letter-spacing:.05em;">
                Rekening Bank Transfer
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Mandiri Account (No. Rekening)</label>
                    <input type="text" name="mandiri_account" class="form-control"
                           placeholder="Contoh: 123-456-789-0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mandiri Name Account (Atas Nama)</label>
                    <input type="text" name="mandiri_account_name" class="form-control"
                           placeholder="Contoh: PPKD Hotel Jakarta">
                </div>
            </div>

            {{-- Kartu Kredit --}}
            <div class="mb-3" style="font-size:.82rem;font-weight:600;color:#6b8f78;text-transform:uppercase;letter-spacing:.05em;">
                Jaminan Kartu Kredit
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nomor Kartu</label>
                    <input type="text" name="card_number" class="form-control"
                           placeholder="xxxx xxxx xxxx xxxx" maxlength="19">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Pemegang Kartu</label>
                    <input type="text" name="card_holder_name" class="form-control"
                           placeholder="Sesuai nama di kartu">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tipe Kartu</label>
                    <select name="card_type" class="form-select">
                        <option value="">— Pilih —</option>
                        <option value="Visa">Visa</option>
                        <option value="Mastercard">Mastercard</option>
                        <option value="JCB">JCB</option>
                        <option value="American Express">American Express</option>
                        <option value="BCA">BCA</option>
                        <option value="Mandiri">Mandiri</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Expired (MM/YYYY)</label>
                    <input type="text" name="card_expired" class="form-control"
                           placeholder="Contoh: 12/2027" maxlength="7"
                           pattern="\d{2}/\d{4}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Atau Transfer ke Bank</label>
                    <input type="text" name="bank_transfer_to" class="form-control"
                           placeholder="Contoh: BCA / BNI">
                </div>
            </div>
        </div>

    </div>

    <!-- ═══════════════════════════════════
         KOLOM KANAN — Summary (tidak berubah)
    ═══════════════════════════════════ -->
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

arrDate.addEventListener('change', () => {
    const d = new Date(arrDate.value);
    d.setDate(d.getDate() + 1);
    depDate.min = d.toISOString().split('T')[0];
    if (!depDate.value || depDate.value <= arrDate.value) {
        depDate.value = d.toISOString().split('T')[0];
    }
    updateSummary();
});

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
