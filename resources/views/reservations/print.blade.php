<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation — {{ $reservation->booking_number }}</title>
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">
</head>
<body>

<div class="print-document">

    {{-- ═══════════════════════════════════════
         HEADER: Logo bulat + PPKD HOTEL
    ════════════════════════════════════════ --}}
    <div class="doc-header">
        <div class="doc-logo-circle">
           <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <div class="doc-logo-text">PPKD<br>JKT<br>PUSAT</div>
        </div>
        <div class="doc-hotel-name">PPKD HOTEL</div>
    </div>

    {{-- ═══════════════════════════════════════
         JUDUL
    ════════════════════════════════════════ --}}
    <div class="doc-subtitle">Reservation Confirmation</div>
    <hr class="sep">

    {{-- ═══════════════════════════════════════
         BARIS "To."
    ════════════════════════════════════════ --}}
    <div class="field-row" style="margin-bottom:6pt;">
        <span class="fl">To.</span>
        <span class="fc">:</span>
        <span class="fv">{{ $reservation->to_name }}</span>
    </div>

    <hr class="sep">

    {{-- ═══════════════════════════════════════
         DUA KOLOM: Info Pemesan (kiri) + Kontak Hotel (kanan)
    ════════════════════════════════════════ --}}
    <div class="two-col">
        <div class="left-col">
            <div class="field-row">
                <span class="fl">Company / Agent</span>
                <span class="fc">:</span>
                <span class="fv">{{ $reservation->company_agent }}</span>
            </div>
            <div class="field-row">
                <span class="fl">Booking No.</span>
                <span class="fc">:</span>
                <span class="fv">{{ $reservation->booking_number }}</span>
            </div>
            <div class="field-row">
                <span class="fl">Book By</span>
                <span class="fc">:</span>
                <span class="fv">{{ $reservation->book_by }}</span>
            </div>
            <div class="field-row">
                <span class="fl">Phone</span>
                <span class="fc">:</span>
                <span class="fv">{{ $reservation->phone }}</span>
            </div>
            <div class="field-row">
                <span class="fl">Email</span>
                <span class="fc">:</span>
                <span class="fv">{{ $reservation->email }}</span>
            </div>
        </div>
        <div class="right-col">
            <div class="field-row">
                <span class="fl" style="min-width:50px;">Telp</span>
                <span class="fc">:</span>
                <span class="fv">{{ $reservation->telp }}</span>
            </div>
            <div class="field-row">
                <span class="fl" style="min-width:50px;">Fax</span>
                <span class="fc">:</span>
                <span class="fv">{{ $reservation->fax }}</span>
            </div>
            <div class="field-row">
                <span class="fl" style="min-width:50px;">Email</span>
                <span class="fc">:</span>
                <span class="fv">{{ $reservation->email_hotel }}</span>
            </div>
            <div class="field-row">
                <span class="fl" style="min-width:50px;">Date</span>
                <span class="fc">:</span>
                <span class="fv">
                    {{ $reservation->booking_date
                        ? $reservation->booking_date->format('d M Y')
                        : now()->format('d M Y') }}
                </span>
            </div>
        </div>
    </div>

    <hr class="sep">

    {{-- ═══════════════════════════════════════
         INFO TAMU & KAMAR
    ════════════════════════════════════════ --}}
    <div class="field-row">
        <span class="fl">First Name</span>
        <span class="fc">:</span>
        <span class="fv">{{ $reservation->full_name }}</span>
    </div>
    <div class="field-row">
        <span class="fl">Arrival Date</span>
        <span class="fc">:</span>
        <span class="fv">{{ $reservation->arrival_date->format('d M Y') }}</span>
    </div>
    <div class="field-row">
        <span class="fl">Departure Date</span>
        <span class="fc">:</span>
        <span class="fv">{{ $reservation->departure_date->format('d M Y') }}</span>
    </div>
    <div class="field-row">
        <span class="fl">Total Night</span>
        <span class="fc">:</span>
        <span class="fv">{{ $reservation->total_nights }} Night(s)</span>
    </div>
    <div class="field-row">
        <span class="fl">Room/Unit Type</span>
        <span class="fc">:</span>
        <span class="fv">{{ $reservation->room_type }}</span>
    </div>
    <div class="field-row">
        <span class="fl">Person Pax</span>
        <span class="fc">:</span>
        <span class="fv">{{ $reservation->person_pax }} Person(s)</span>
    </div>
    <div class="field-row">
        <span class="fl">Room Rate Net</span>
        <span class="fc">:</span>
        <span class="fv">
            @if($reservation->room_rate_net)
                Rp {{ number_format($reservation->room_rate_net, 0, ',', '.') }}
            @endif
        </span>
    </div>

    <hr class="sep">

    {{-- ═══════════════════════════════════════
         TEKS JAMINAN
    ════════════════════════════════════════ --}}
    <p class="info-text">
        Please guarantee this booking with credit card number with clear copy of the card both sides and card holder
        signature in the column provided the copy of credit card both sides should be faxed to hotel fax number.
        Please settle your outstanding to or account:
    </p>

    {{-- Transfer Bank --}}
    <div class="field-row">
        <span class="fl" style="min-width:160px;">Bank Transfer</span>
        <span class="fv-plain"></span>
    </div>
    <div class="field-row">
        <span class="fl" style="min-width:160px;">Mandiri Account</span>
        <span class="fc">:</span>
        <span class="fv-plain"></span>
    </div>
    <div class="field-row" style="margin-bottom:6pt;">
        <span class="fl" style="min-width:160px;">Mandiri Name Account</span>
        <span class="fc">:</span>
        <span class="fv-plain"></span>
    </div>

    <hr class="sep">

    {{-- ═══════════════════════════════════════
         KARTU KREDIT
    ════════════════════════════════════════ --}}
    <div class="section-label">Reservation guaranteed by the following credit card:</div>

    <div class="field-row">
        <span class="fl">Card Number</span>
        <span class="fc">:</span>
        <span class="fv">
            @if($reservation->card_number)
                •••• •••• •••• {{ substr(str_replace(' ','',$reservation->card_number), -4) }}
            @endif
        </span>
    </div>
    <div class="field-row">
        <span class="fl">Card holder name</span>
        <span class="fc">:</span>
        <span class="fv">{{ $reservation->card_holder_name }}</span>
    </div>
    <div class="field-row">
        <span class="fl">Card Type</span>
        <span class="fc">:</span>
        <span class="fv">{{ $reservation->card_type }}</span>
    </div>
    <div class="field-row">
        <span class="fl">Or by Bank Transfer to</span>
        <span class="fc">:</span>
        <span class="fv">{{ $reservation->bank_transfer_to }}</span>
    </div>
    <div class="field-row">
        <span class="fl">Expired date/month/year</span>
        <span class="fc">:</span>
        <span class="fv">
            {{ $reservation->card_expired_date
                ? $reservation->card_expired_date->format('m/Y')
                : '' }}
        </span>
    </div>
    <div class="field-row" style="margin-bottom:8pt;">
        <span class="fl">Card holder signature</span>
        <span class="fc">:</span>
        <span class="fv"></span>
    </div>

    <hr class="sep">

    {{-- ═══════════════════════════════════════
         KEBIJAKAN PEMBATALAN
    ════════════════════════════════════════ --}}
    <div class="policy-title">Cancellation policy:</div>
    <ol class="policy-ol">
        <li>Please note that check in time is 02.00 pm and check out time 12.00 pm.</li>
        <li>All non guaranteed reservations will automatically be released on 6 pm.</li>
        <li>The Hotel will charge 1 night for guaranteed reservations that have not been canceling
            before the day of arrival. Please carefully note your cancellation number.</li>
    </ol>

    {{-- ═══════════════════════════════════════
         TANDA TANGAN
    ════════════════════════════════════════ --}}
    <div class="sig-row">
        <div class="sig-box">
            <div class="sig-space"></div>
            <div class="sig-line"></div>
            <div class="sig-label">Authorized Signature</div>
        </div>
    </div>

</div>{{-- /.print-document --}}

{{-- ═══════════════════════════════════════
     TOMBOL AKSI (hilang saat print)
════════════════════════════════════════ --}}
<div class="print-actions">
    <a href="{{ route('reservations.show', $reservation) }}" class="print-btn print-btn-outline">
        ← Kembali
    </a>
    <button onclick="window.print()" class="print-btn print-btn-primary">
        🖨️ Cetak / Print
    </button>
</div>

</body>
</html>
