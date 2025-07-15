<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Barangay Clearance for Minor</title>
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
                    City of San Fernando<br>
                    OFFICE OF THE SANGGUNIANG BARANGAY<br>
                    <span class="barangay-tabun">Barangay Panipuan</span>
                </p>
                <div class="certificate-title-wrapper">
                    <h1 class="certificate-title">Barangay Clearance</h1>
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
                This is to certify that <span class="bold">{{ strtoupper($clearance->full_name) }}</span>, <strong>{{ $clearance->clearance_age }}</strong> years old, a minor and a Filipino citizen, is a resident of <span class="bold">{{ strtoupper($clearance->purok) }}</span>, Barangay Panipuan, City of San Fernando, Pampanga.
            </p>

            <p class="indent-8">
                Based on the records of this office, the above-named minor has no derogatory record or pending case filed in this barangay. He/She is known to be of good moral character and proper behavior.
            </p>

            <p class="indent-8">
                This clearance is issued upon the request of the parent/guardian of the said minor for the purpose of <span class="bold">{{ strtoupper($clearance->clearance_purpose) }}</span>.
            </p>

            <p class="indent-8">
                Issued this <strong>{{ \Carbon\Carbon::parse($clearance->date)->format('jS') }}</strong> day of <strong>{{ \Carbon\Carbon::parse($clearance->date)->format('F Y') }}</strong>, at the Office of the Sangguniang Barangay, Barangay Panipuan, City of San Fernando, Pampanga.
            </p>

            <p>__________________ <br><span class="mark-sign">Signature of Parent/Guardian</span></p>
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
