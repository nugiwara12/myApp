<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificate of Indigency</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.5;
            font-size: 16px;
            position: relative;
        }

        .certificate-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
        }

        /* Logos behind text */
        .logo-container {
            position: relative;
            text-align: center;
        }

        .left-logo,
        .right-logo {
            position: absolute;
            top: 0;
            height: 8rem;
            z-index: 0;
        }

        .left-logo {
            left: 0;
        }

        .right-logo {
            right: 0;
        }

        .barangay {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .header-title1 {
            font-size: 18px;
        }

        .barangay-tabun {
            font-size: 25px;
            font-weight: bold;
        }

        .certificate-title-wrapper {
            margin-top: 2rem;
        }

        .certificate-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 20px 0;
            padding: 10px 0;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
        }

        .indigency {
            font-weight: bold;
            font-size: 20px;
            margin-top: 1rem;
        }

        .content {
            margin-top: 1rem;
            text-align: justify;
        }

        .bold {
            font-weight: bold;
        }

        .italic {
            font-style: italic;
        }

        .signature {
            text-align: left;
            margin-top: 3rem;
        }

        .signature-name {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
            border-top: 1px solid #000;
            padding-top: 5px;
            display: inline-block;
            min-width: 250px;
            text-align: start;
        }

        .mark-sign {
            margin-left: 2rem;
        }

        .Head-class-sec,
        .Head-class-punong {
            font-weight: bold;
            font-size: 16px;
        }

        .verify-text-sec,
        .verify-text-punong {
            font-size: 12px;
            font-weight: bold;
            margin-top: 1rem;
        }

        .brgy-position {
            font-size: 14px;
            font-style: italic;
        }

        .opacity-text {
            text-align: center;
            opacity: 0.6;
            margin-top: 30px;
            font-size: 12px;
        }

        /* Custom indent class to simulate &nbsp; spacing */
        .indent-8 {
            display: block;
            text-indent: 2em;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Logos Behind -->
        <div class="logo-container">
            <img class="left-logo" src="{{ public_path('admin_assets/images/logo-left.png') }}" alt="Left Logo">
            <img class="right-logo" src="{{ public_path('admin_assets/images/sanfernando.png') }}" alt="Right Logo">

            <!-- Header -->
            <div class="barangay">
                <p class="header-title1">
                    Republic of the Philippines<br>
                    Province of Pampanga<br>
                    San Fernando City<br>
                    OFFICE OF THE SANGGUNIANG BARANGAY<br>
                    <span class="barangay-tabun">Barangay Panipuan</span>
                </p>
                <div class="certificate-title-wrapper">
                    <h1 class="certificate-title">CERTIFICATE OF INDIGENCY</h1>
                </div>
            </div>
        </div>

        <!-- Recipient -->
        <div class="recipient">
            <p>TO WHOM IT MAY CONCERN:</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p class="indent-8">
                This is to certify that <span class="bold">{{ strtoupper($indigency->parent_name) }}</span>, of legal age, Filipino, and a resident of <span class="bold">{{ strtoupper($indigency->address) }}</span>, is one of the <span class="italic">indigents</span> in our barangay.
            </p>

            <p>
                This certification is being issued upon the request of the above-named person for <span class="bold" id="purposeText">{{ strtoupper($indigency->purpose) }}</span>.
            </p>

            <p class="indent-8">
                Issued this <strong>{{ \Carbon\Carbon::parse($indigency->date)->format('jS') }}</strong> day of <strong>{{ \Carbon\Carbon::parse($indigency->date)->format('F Y') }}</strong>, at the Office of the Sangguniang Barangay, Barangay Panipuan, San Fernando City, Pampanga.
            </p>

            <p>__________________ <br><span class="mark-sign">Signature</span></p>
        </div>

        <!-- Verification -->
        <p class="verify-text-sec">Checked and Verified by:</p>
        <p class="Head-class-sec">MARC DOMINADO JR.<br><span class="brgy-position">Barangay Secretary</span></p>

        <p class="verify-text-punong">Approved:</p>
        <p class="Head-class-punong">JOHN IVAN O. MICLAT<br><span class="brgy-position">Punong Barangay</span></p>

        <p class="opacity-text">*(Not valid without seal)</p>
    </div>
</body>
</html>
