<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificate of Residency</title>
    <style>
        @page {
            margin: 0.8in;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        .certificate-container {
            max-width: 800px;
            margin: auto;
            padding: 5px 10px;
        }

        .logo-container {
            position: relative;
            text-align: center;
            margin-bottom: 5px;
        }

        .left-logo,
        .right-logo {
            position: absolute;
            top: 0;
            height: 6rem;
            z-index: 0;
        }

        .left-logo {
            left: 0;
        }

        .right-logo {
            right: 0;
        }

        .barangay {
            z-index: 1;
            position: relative;
            text-align: center;
        }

        .header-title1 {
            font-size: 15px;
            margin: 0;
        }

        .barangay-poblacion {
            font-size: 19px;
            font-weight: bold;
        }

        .certificate-title-wrapper {
            margin-top: 1rem;
        }

        .certificate-title {
            font-size: 17px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            border-top: 1px solid #000;
            padding: 5px 0;
            margin: 10px 0;
        }

        .content, .recipient {
            text-align: justify;
            margin-bottom: 6px;
        }

        .bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }

        .signature {
            margin-top: 2.5rem;
        }

        .signature-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2.5rem; /* space between each signature group */
            margin-top: 2rem;
        }

        .mark-sign {
            margin-left: 2rem;
        }

        .signature-item {
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            padding-top: 10px;
            margin-bottom: 6px;
            font-weight: bold;
            text-transform: uppercase;
            width: 300px;
            height: 40px; /* Gives space to write */
        }

        .sign-label {
            font-size: 13px;
            font-style: italic;
            text-align: start;
        }

        .opacity-text {
            text-align: center;
            opacity: 0.6;
            font-size: 11px;
            margin-top: 1rem;
        }

        .certificate-details {
            margin-top: 1.5rem;
            font-size: 13px;
        }

        .indent-8 {
            display: block;
            text-indent: 2em;
        }

        .brgy-position {
            font-size: 13px;
            font-style: italic;
            margin-top: -13px;
        }

        /* Prevent page breaking */
        .certificate-container, .content, .signature, .certificate-details {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Logos -->
        <div class="logo-container">
            <img class="left-logo" src="{{ public_path('admin_assets/images/logo-left.png') }}" alt="Left Logo">
            <img class="right-logo" src="{{ public_path('admin_assets/images/sanfernando.png') }}" alt="Right Logo">
            <div class="barangay">
                <p class="header-title1">
                    Republic of the Philippines<br>
                    Province of Tarlac<br>
                    Municipality of Moncada<br>
                    <span class="barangay-poblacion">BARANGAY PANIPPUAN</span><br>
                    OFFICE OF THE PUNONG BARANGAY
                </p>
                <div class="certificate-title-wrapper">
                    <h1 class="certificate-title">Certificate of Residency</h1>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="recipient">
            <p>TO WHOM IT MAY CONCERN:</p>
        </div>

        <div class="content">
            <p class="indent-8">
                This is to certify that <span class="bold">{{ strtoupper($residence->resident_name) }}</span>,
                <span class="bold">{{ $residence->resident_age }}</span> years of age,
                <span class="bold">{{ $residence->civil_status }}</span>, a natural born
                <strong>{{ strtoupper($residence->nationality) }}</strong>, is a bona fide resident of
                <span class="bold">{{ $residence->address }}</span>.
            </p>

            <p class="indent-8">
                This further certifies that he/she is a law-abiding citizen, of good moral character and reputation.
                That he/she has no derogatory record or pending case filed against him/her in this barangay.
            </p>

            <p class="indent-8">
                This certification is issued upon the request of the above-mentioned name for
                <span class="bold">{{ strtoupper($residence->resident_purpose) }}</span>.
            </p>

            <p>
                Issued this <span class="bold">{{ \Carbon\Carbon::parse($residence->issue_date)->format('jS') }}</span>
                day of <span class="bold">{{ \Carbon\Carbon::parse($residence->issue_date)->format('F') }}</span>,
                <span class="bold">{{ \Carbon\Carbon::parse($residence->issue_date)->format('Y') }}</span> at
                <span>{{ $residence->barangay_name }}, {{ $residence->municipality }} {{ $residence->province }}</span>.
            </p>
        </div>

        <!-- Signature Section -->
        <div class="signature">
            <p>__________________ <br><span class="mark-sign">Signature</span></p>

            <p class="verify-text-sec">Checked and Verified by:</p>
            <p class="sec-name underline">MARC DOMINADO JR.</p>
            <p class="brgy-position">Barangay Secretary</p>

            <p class="signature-name underline">JOHN IVAN O, MICLAT</p>
            <p class="brgy-position">Punong Barangay</p>
        </div>

        <!-- Certificate Details -->
        <div class="certificate-details">
            <p>Res. Cert. No.: <span class="bold underline">{{ $residence->certificate_number }}</span></p>
            <p>Issued At: <span class="bold underline">{{ $residence->barangay_name }}</span></p>
            <p>Issued On: <span class="bold underline">{{ \Carbon\Carbon::parse($residence->issued_on)->format('F j, Y') }}</span></p>
        </div>

        <p class="opacity-text">**Not Valid Without Seal**</p>
    </div>
</body>
</html>
