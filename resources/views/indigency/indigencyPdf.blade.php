<!-- resources/views/certification/static-pdf.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Barangay Panipuan - Certificate of Indigency</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.5;
            font-size: 16px;
            position: relative;
        }

        body::before {
            content: '';
            /* background: url('{{ public_path('admin_assets/images/bgy-ID-img/tabun.png') }}') center center no-repeat; */
            background-size: 25rem 25rem;
            opacity: 0.2;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
        }

        .certification {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .left-logo,
        .profile-picture {
            height: 8rem;
            position: absolute;
            top: 0;
            z-index: 1;
        }

        .left-logo {
            left: 2rem;
        }

        .profile-picture {
            right: 2rem;
        }

        .barangay {
            text-align: center;
            margin-top: 1rem;
        }

        .header-title1 {
            font-size: 18px;
        }

        .barangay-tabun {
            font-size: 25px;
            font-weight: bold;
        }

        .indigency {
            font-weight: bold;
            font-size: 20px;
        }

        .header {
            text-align: left;
            margin-top: 2rem;
        }

        .clearance {
            margin-top: 1.5rem;
            text-align: justify;
        }

        .name,
        .address,
        .purpose,
        .age,
        .date_of_birth,
        .date {
            font-weight: bold;
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
    </style>
</head>

<body>
    <div class="certification">
        <img class="left-logo" src="{{ public_path('admin_assets/images/logo-left.png') }}" alt="Left Logo">
        <img class="profile-picture" src="{{ public_path('admin_assets/images/sanfernando.png') }}" alt="Right Logo">

        <div class="barangay">
            <p class="header-title1">
                Republic of the Philippines<br>
                Province of Pampanga<br>
                Sanfernando City<br>
                OFFICE OF THE SANGGUNIANG BARANGAY<br>
                <span class="barangay-tabun">Barangay Panipuan</span>
            </p>
            <hr>
            <div class="indigency">CERTIFICATE OF INDIGENCY</div>
            <hr>
        </div>

        <div class="header">
            <h3>To Whom It May Concern:</h3>
        </div>

        <div class="clearance">
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                This is to certify that <span class="name">{{ strtoupper($indigency->parent_name) }}</span>, of legal
                age,
                Filipino citizen, married, and a resident of
                <span class="address">{{ strtoupper($indigency->address) }}</span>, is an
                <strong>INDIGENT</strong> with no sufficient means for daily food, shelter, and necessities for her and
                her family.
            </p>

            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                This certificate is issued upon request for her <strong>child</strong>,
                <span class="purpose">{{ strtoupper($indigency->childs_name) }}</span>, age
                <span class="age">{{ strtoupper($indigency->age) }}</span>, born on
                <span class="date_of_birth">March 25, 2014</span>,
                for the purpose of <span class="purpose">{{ strtoupper($indigency->purpose) }}</span>.
            </p>

            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Issued this <span
                    class="date">{{ \Carbon\Carbon::parse($indigency->date)->format('jS \\of F Y') }}</span> at
                Barangay Panipuan, Mabalacat City, Pampanga.
            </p>

            <p>__________________ <br><span class="mark-sign">Signature</span></p>
        </div>

        <p class="verify-text-sec">Checked and Verified by:</p>
        <p class="Head-class-sec">MARC DOMINADO JR.<br><span class="brgy-position">Barangay Secretary</span></p>

        <p class="verify-text-punong">Approved:</p>
        <p class="Head-class-punong">JOHN IVAN O. MICLAT<br><span class="brgy-position">Punong Barangay</span></p>

        <p class="opacity-text">*(Not valid without seal)</p>
    </div>
</body>

</html>
