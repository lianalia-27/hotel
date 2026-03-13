<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Registrasi — {{ $reservation->guest->name }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        @page { size: A4; margin: 18mm 15mm; }
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #000;
            background: #fff;
        }

        /* ── Header ── */
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header img.logo {
            width: 60px; height: 60px;
            margin-bottom: 4px;
        }
        .header .logo-placeholder {
            width: 60px; height: 60px;
            border: 2px solid #2c6e49;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 4px;
        }
        .header h2 {
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 1px;
        }
        .header h3 {
            font-size: 10.5pt;
            font-style: italic;
            font-weight: normal;
        }

        /* ── Main table ── */
        .reg-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .reg-table td, .reg-table th {
            border: 1px solid #000;
            padding: 4px 7px;
            vertical-align: top;
        }
        .label-bi {
            font-size: 7.5pt;
            color: #555;
            display: block;
        }
        .label-id {
            font-size: 9pt;
            font-weight: bold;
            display: block;
        }
        .value {
            font-size: 10.5pt;
            font-weight: bold;
            min-height: 14px;
            display: block;
            margin-top: 1px;
        }
        .value.red { color: #c0392b; }

        /* ── Room row ── */
        .room-row td { vertical-align: middle; }
        .room-numbers {
            font-size: 11pt;
            font-weight: bold;
            line-height: 1.5;
        }

        /* ── Checkout notice ── */
        .checkout-row td {
            text-align: center;
            font-size: 9.5pt;
            padding: 6px;
        }

        /* ── Guest detail rows ── */
        .field-row td { min-height: 28px; }

        /* ── Deposit / issued row ── */
        .bottom-row td { font-size: 9pt; }

        /* ── Signature area ── */
        .sig-area {
            margin-top: 16px;
            display: flex;
            justify-content: flex-end;
        }
        .sig-box {
            border: 1px solid #000;
            width: 200px;
            min-height: 70px;
            padding: 8px;
            text-align: center;
            font-size: 8.5pt;
        }

        /* ── Print button (screen only) ── */
        .print-btn {
            position: fixed;
            top: 16px; right: 16px;
            background: #2c6e49;
            color: #fff;
            border: none;
            padding: 10px 22px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            font-family: Arial, sans-serif;
            box-shadow: 0 4px 12px rgba(0,0,0,.2);
        }
        @media print {
            .print-btn { display: none; }
        }
    </style>
</head>
<body>

<button class="print-btn" onclick="window.print()">🖨 Cetak Formulir</button>

<!-- Header -->
<div class="header">
    <!-- PPKD Jakarta Pusat Logo (SVG Placeholder matching original badge) -->
    <svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
        <circle cx="30" cy="30" r="29" fill="#fff" stroke="#1a5276" stroke-width="2"/>
        <circle cx="30" cy="30" r="26" fill="#1a5276"/>
        <circle cx="30" cy="30" r="22" fill="#fff"/>
        <text x="50%" y="34%" dominant-baseline="middle" text-anchor="middle" font-size="7" font-family="Arial" font-weight="bold" fill="#1a5276">PPKD</text>
        <rect x="16" y="26" width="28" height="18" rx="2" fill="#27ae60"/>
        <rect x="16" y="26" width="28" height="18" rx="2" fill="none" stroke="#1a5276" stroke-width="1"/>
        <text x="50%" y="70%" dominant-baseline="middle" text-anchor="middle" font-size="5.5" font-family="Arial" fill="#fff" font-weight="bold">JAKARTA</text>
        <text x="50%" y="82%" dominant-baseline="middle" text-anchor="middle" font-size="4.5" font-family="Arial" fill="#fff">PUSAT</text>
        <!-- Tugu Monas icon simplified -->
        <rect x="28" y="27" width="4" height="12" fill="#f0c040"/>
        <polygon points="30,25 27,29 33,29" fill="#f0c040"/>
    </svg>
    <h2>PPKD HOTEL</h2>
    <h3>Formulir Pendaftaran</h3>
    <h3>Registration</h3>
</div>

<!-- Registration Table -->
<table class="reg-table">

    <!-- Row 1: Room No + Jumlah Tamu + Jumlah Kamar + Room Type + Receptionist -->
    <tr class="room-row">
        <td rowspan="2" style="width:18%;">
            <div class="room-numbers">
                Room No. {{ $reservation->room->room_number }}
            </div>
        </td>
        <td style="width:22%;">
            <span class="label-id">Jumlah Tamu</span>
            <span class="label-bi">No. of Person</span>
            <span class="value">{{ $reservation->num_persons }} orang</span>
        </td>
        <td colspan="2" style="width:22%;">&nbsp;</td>
        <td rowspan="2" style="width:20%;">&nbsp;</td>
    </tr>
    <tr class="room-row">
        <td>
            <span class="label-id">Jumlah Kamar</span>
            <span class="label-bi">No. of Room</span>
            <span class="value">1</span>
        </td>
        <td style="width:14%;">
            <span class="label-id">Jenis Kamar</span>
            <span class="label-bi">Room Type</span>
            <span class="value">{{ $reservation->room->roomType->code }}</span>
        </td>
        <td style="width:16%;">
            <span class="value" style="font-size:9pt;font-weight:normal;">Receptionist</span>
            <span class="value">{{ $reservation->user->name }}</span>
        </td>
    </tr>

    <!-- Checkout notice -->
    <tr class="checkout-row">
        <td colspan="5">
            <strong>Check Out Time : 12.00 Noon</strong><br>
            Waktu Lapor Keluar : Jam 12.00 Siang
        </td>
    </tr>

    <!-- Instruction + Arrival Time -->
    <tr class="field-row">
        <td colspan="4" style="font-style:italic;font-size:9pt;">
            Harap tulis dengan huruf cetak — <em>Please print in block letters</em>
        </td>
        <td rowspan="2">
            <span class="label-id">Waktu Kedatangan</span>
            <span class="label-bi">Arrival Time</span>
            <span class="value">{{ $reservation->arrival_time ?? '—' }}</span>
        </td>
    </tr>

    <!-- Name -->
    <tr class="field-row">
        <td colspan="4">
            <span class="label-id">Nama / Name</span>
            <span class="value">{{ strtoupper($reservation->guest->name) }}</span>
        </td>
    </tr>

    <!-- Profession -->
    <tr class="field-row">
        <td colspan="4">
            <span class="label-id">Pekerjaan / Profession</span>
            <span class="value">{{ $reservation->guest->profession ?? '' }}</span>
        </td>
        <td>
            <span class="label-id">Tanggal Kedatangan</span>
            <span class="label-bi">Arrival Date</span>
            <span class="value">{{ $reservation->arrival_date->format('d/m/Y') }}</span>
        </td>
    </tr>

    <!-- Company -->
    <tr class="field-row">
        <td colspan="4">
            <span class="label-id">Perusahaan / Company</span>
            <span class="value">{{ $reservation->guest->company ?? '' }}</span>
        </td>
        <td rowspan="2">
            <span class="label-id" class="red">Tgl Keberangkatan</span>
            <span class="label-bi" style="color:#c0392b;">Departure Date</span>
            <span class="value red">{{ $reservation->departure_date->format('d/m/Y') }}</span>
        </td>
    </tr>

    <!-- Nationality + KTP + Birth Date -->
    <tr class="field-row">
        <td style="width:18%;">
            <span class="label-id">Kebangsaan</span>
            <span class="label-bi">Nationality</span>
            <span class="value">{{ $reservation->guest->nationality ?? 'Indonesia' }}</span>
        </td>
        <td style="width:22%;">
            <span class="label-id">No. KTP</span>
            <span class="label-bi">Passport No.</span>
            <span class="value" style="font-size:9pt;">{{ $reservation->guest->id_card_number ?? $reservation->guest->passport_number ?? '' }}</span>
        </td>
        <td colspan="2">
            <span class="label-id">Tanggal Lahir</span>
            <span class="label-bi">Birth Date</span>
            <span class="value">{{ optional($reservation->guest->birth_date)->format('d/m/Y') ?? '' }}</span>
        </td>
    </tr>

    <!-- Address + Phone -->
    <tr class="field-row">
        <td colspan="2">
            <span class="label-id">Alamat / Address</span>
            <span class="value" style="font-size:9pt;">{{ $reservation->guest->address ?? '' }}</span>
        </td>
        <td colspan="2">
            <span class="label-id">Telephone / Phone</span>
            <span class="value">{{ $reservation->guest->phone ?? '' }}</span>
            <span class="label-id" style="margin-top:4px;">Handphone / Mobile phone</span>
            <span class="value">{{ $reservation->guest->mobile_phone ?? '' }}</span>
        </td>
        <td>
            <span class="label-id" style="color:#c0392b;">Tgl Keberangkatan</span>
            <span class="value red">{{ $reservation->departure_date->format('d/m/Y') }}</span>
        </td>
    </tr>

    <!-- Email -->
    <tr class="field-row">
        <td colspan="5">
            <span class="label-id">Email</span>
            <span class="value">{{ $reservation->guest->email ?? '' }}</span>
        </td>
    </tr>

    <!-- Member No. -->
    <tr class="field-row">
        <td colspan="5">
            <span class="label-id">No. Member /</span>
            <span class="value">{{ $reservation->guest->member_number ?? '' }}</span>
        </td>
    </tr>

    <!-- Blank space for signature / notes -->
    <tr>
        <td colspan="5" style="height:55px;">&nbsp;</td>
    </tr>

    <!-- Deposit Box / Issued By / Date -->
    <tr class="bottom-row">
        <td colspan="2">
            <span class="label-id">Nomor Kotak Deposit</span>
            <span class="label-bi">Safety Deposit Box Number</span>
            <span class="value">{{ $reservation->safety_deposit_box ?? '' }}</span>
        </td>
        <td colspan="2">
            <span class="label-id">Dikeluarkan oleh / Issued</span>
            <span class="value">{{ $reservation->issued_by ?? $reservation->user->name }}</span>
        </td>
        <td>
            <span class="label-id">Tanggal / Date</span>
            <span class="value">{{ optional($reservation->issued_date)->format('d/m/Y') ?? $reservation->created_at->format('d/m/Y') }}</span>
        </td>
    </tr>
</table>

<!-- Tamu Signature -->
<div class="sig-area">
    <div class="sig-box">
        <div style="margin-bottom:40px;">Tanda Tangan Tamu</div>
        <div>(____________________)</div>
        <div style="margin-top:4px;font-size:8pt;">Guest Signature</div>
    </div>
</div>

<!-- Footer info -->
<div style="margin-top:10px;font-size:7.5pt;color:#777;text-align:center;">
    Dicetak pada: {{ now()->format('d/m/Y H:i') }} &nbsp;|&nbsp;
    Booking No: {{ $reservation->booking_number }} &nbsp;|&nbsp;
    Oleh: {{ auth()->user()->name ?? $reservation->user->name }}
</div>

</body>
</html>
