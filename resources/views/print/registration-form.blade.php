<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran — {{ $registration->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">
</head>
<body>

<div class="print-document">

    {{-- Document Header --}}
    <div class="doc-header">
        <div class="doc-header-brand">
            <div class="doc-logo">🏨</div>
            <div class="doc-brand-text">
                <h1>PPKD Hotel</h1>
                <p>Dinas Tenaga Kerja, Transmigrasi dan Energi · Jakarta Pusat</p>
            </div>
        </div>
        <div class="doc-header-info">
            <div class="doc-type">Formulir Pendaftaran</div>
            <div class="doc-no">Registration Form</div>
        </div>
    </div>

    <div class="doc-body">

        {{-- Room Info Row --}}
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;flex-wrap:wrap;">
            <span class="reg-room-badge">Room No. {{ $registration->room_number }}</span>
            <div style="display:flex;gap:20px;flex:1;flex-wrap:wrap;">
                <div class="field-row" style="flex:1;min-width:160px;">
                    <span class="field-label" style="min-width:100px;">Jumlah Tamu / No. of Person</span>
                    <span class="field-colon">:</span>
                    <span class="field-value bold">{{ $registration->no_of_person }}</span>
                </div>
                <div class="field-row" style="flex:1;min-width:160px;">
                    <span class="field-label" style="min-width:100px;">Jumlah Kamar / No. of Room</span>
                    <span class="field-colon">:</span>
                    <span class="field-value bold">{{ $registration->no_of_room }}</span>
                </div>
                <div class="field-row" style="flex:1;min-width:160px;">
                    <span class="field-label" style="min-width:80px;">Jenis Kamar / Room Type</span>
                    <span class="field-colon">:</span>
                    <span class="field-value bold">{{ $registration->room_type }}</span>
                </div>
                <div class="field-row" style="flex:1;min-width:160px;">
                    <span class="field-label" style="min-width:80px;">Resepsionis</span>
                    <span class="field-colon">:</span>
                    <span class="field-value">{{ $registration->receptionist ?: '&nbsp;' }}</span>
                </div>
            </div>
        </div>

        {{-- Check Out Notice --}}
        <div class="checkout-notice">
            <strong>Check Out Time : 12.00 Noon</strong>
            &nbsp;&nbsp;|&nbsp;&nbsp;
            Waktu Lapor Keluar : <strong>Jam 12.00 Siang</strong>
        </div>

        {{-- Instruction + Arrival Time --}}
        <div style="display:flex;justify-content:space-between;align-items:center;
                    background:#f0f7ff;border:1px solid #bfdbfe;border-radius:6px;
                    padding:10px 16px;margin-bottom:16px;">
            <div style="font-size:0.8rem;color:#1e3a5f;font-style:italic;">
                Harap tulis dengan huruf cetak &mdash; <em>Please print in block letters</em>
            </div>
            <div style="text-align:right;">
                <div style="font-size:0.65rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:#60a5fa;">
                    Waktu Kedatangan / Arrival Time
                </div>
                <div style="font-size:1.1rem;font-weight:600;color:#1e3a5f;">
                    {{ $registration->arrival_time ? $registration->arrival_time->format('H:i') : '&nbsp;&nbsp;:&nbsp;&nbsp;' }}
                </div>
            </div>
        </div>

        {{-- Guest Data Table --}}
        <table class="print-table">
            <tbody>
                <tr>
                    <td style="width:30%;font-weight:500;color:#475569;">
                        Nama / <em>Name</em>
                    </td>
                    <td colspan="3" style="font-weight:600;font-size:1rem;color:#1e3a5f;">
                        {{ $registration->name }}
                    </td>
                    <td style="text-align:right;vertical-align:top;padding-right:12px;" rowspan="3">
                        <div style="font-size:0.65rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:#60a5fa;white-space:nowrap;">
                            Tanggal Kedatangan
                        </div>
                        <div style="font-size:0.65rem;letter-spacing:0.06em;color:#94a3b8;margin-bottom:4px;">
                            Arrival Date
                        </div>
                        <div style="font-size:1rem;font-weight:600;color:#1e3a5f;">
                            {{ $registration->arrival_date->format('d M Y') }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500;color:#475569;">
                        Pekerjaan / <em>Profession</em>
                    </td>
                    <td colspan="3">{{ $registration->profession ?: '&nbsp;' }}</td>
                </tr>
                <tr>
                    <td style="font-weight:500;color:#475569;">
                        Perusahaan / <em>Company</em>
                    </td>
                    <td colspan="3">{{ $registration->company ?: '&nbsp;' }}</td>
                </tr>
                <tr>
                    <td style="font-weight:500;color:#475569;">
                        Kebangsaan / <em>Nationality</em>
                    </td>
                    <td>{{ $registration->nationality ?: '&nbsp;' }}</td>
                    <td style="font-weight:500;color:#475569;">
                        No. KTP / <em>Passport No.</em>
                    </td>
                    <td>{{ $registration->passport_no ?: '&nbsp;' }}</td>
                    <td style="text-align:right;vertical-align:top;padding-right:12px;" rowspan="2">
                        <div style="font-size:0.65rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:#ef4444;white-space:nowrap;">
                            Tgl Keberangkatan
                        </div>
                        <div style="font-size:0.65rem;letter-spacing:0.06em;color:#94a3b8;margin-bottom:4px;">
                            Departure Date
                        </div>
                        <div style="font-size:1rem;font-weight:600;color:#dc2626;">
                            {{ $registration->departure_date->format('d M Y') }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500;color:#475569;">
                        Tanggal Lahir / <em>Birth Date</em>
                    </td>
                    <td colspan="3">
                        {{ $registration->birth_date ? $registration->birth_date->format('d M Y') : '&nbsp;' }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight:500;color:#475569;">
                        Alamat / <em>Address</em>
                    </td>
                    <td>{{ $registration->address ?: '&nbsp;' }}</td>
                    <td style="font-weight:500;color:#475569;">
                        Telepon / <em>Phone</em><br>
                        Handphone / <em>Mobile</em>
                    </td>
                    <td>
                        {{ $registration->telephone ?: '&nbsp;' }}<br>
                        {{ $registration->mobile_phone ?: '&nbsp;' }}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td style="font-weight:500;color:#475569;">Email</td>
                    <td colspan="4">{{ $registration->email ?: '&nbsp;' }}</td>
                </tr>
                <tr>
                    <td style="font-weight:500;color:#475569;">No. Member /</td>
                    <td colspan="4">{{ $registration->member_no ?: '&nbsp;' }}</td>
                </tr>
                {{-- Empty signature row --}}
                <tr>
                    <td colspan="5" style="height:80px;vertical-align:bottom;padding-bottom:12px;">
                        <div style="display:flex;justify-content:flex-end;gap:20px;align-items:flex-end;">
                            <div style="text-align:center;width:160px;">
                                <div style="border-top:1px solid #334155;padding-top:4px;font-size:0.72rem;color:#64748b;">
                                    Tanda Tangan Tamu / Guest Signature
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Deposit Box --}}
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0;border:1px solid #bfdbfe;border-radius:6px;overflow:hidden;">
            <div style="padding:12px 16px;border-right:1px solid #bfdbfe;">
                <div class="gsi-label">Nomor Kotak Deposit</div>
                <div class="gsi-label" style="color:#94a3b8;margin-top:1px;">Safety Deposit Box Number</div>
                <div class="gsi-value" style="margin-top:6px;">{{ $registration->safety_deposit_box_no ?: '—' }}</div>
            </div>
            <div style="padding:12px 16px;border-right:1px solid #bfdbfe;">
                <div class="gsi-label">Dikeluarkan Oleh</div>
                <div class="gsi-label" style="color:#94a3b8;margin-top:1px;">Issued</div>
                <div class="gsi-value" style="margin-top:6px;">{{ $registration->issued_by ?: '—' }}</div>
            </div>
            <div style="padding:12px 16px;">
                <div class="gsi-label">Tanggal / Date</div>
                <div class="gsi-value" style="margin-top:6px;">
                    {{ $registration->issued_date ? $registration->issued_date->format('d M Y') : '—' }}
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Print Action Buttons --}}
<div class="print-actions">
    <a href="{{ route('registration.index') }}" class="print-btn print-btn-outline">
        ← Kembali
    </a>
    <button onclick="window.print()" class="print-btn print-btn-primary">
        🖨️ Cetak / Print
    </button>
</div>

</body>
</html>
