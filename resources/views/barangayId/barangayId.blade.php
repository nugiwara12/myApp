<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Panipuan: PDF FORM</title>


    <style>

        .watermark-bg {
            content: '';
            background: url('admin_assets/images/wallpaper.png') center center no-repeat;
            background-size: 20rem 12rem; /* Adjust the size as needed */
            opacity: 0.4;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            position: absolute;
            z-index: -1;
        }


        #clearance-container {
            /* display: flex; */
            /* flex-direction: column; */
            justify-content: center;
            align-items: left;
            text-align: center;
            padding: 20px;
            border: solid black 1px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(241, 241, 241, 0.1);
            max-width: 690px;
            background-color: rgba(255, 255, 255, 0.7);
            position: relative;
            height: 182px; /* Adjust the height as needed */
            width: 295px;
            word-wrap: break-word; /* Ensure long words are broken and don't overflow the container */
        }

        #clearance-container p {
            margin-top: -9;
            font-size: 10px;
            justify-content: end;
            position: relative;

        }

        .body-p {
            text-align: left;
            justify-content: space-between;
        }


        .left-logo,
        .profile-picture {
            height: 3.5rem;
            position: absolute;
            top: 0;
            left: 10rem;
            z-index: 1; /* Images are stacked on top of the text */
        }


        .right-logo,
        .profile-picture {
            height: 3.5rem;
            position: absolute;
            top: 0;
            right: 10rem;
            z-index: 1; /* Images are stacked on top of the text */
        }

        .header-left {
            position: relative;
            display: inline-block; /* Make sure the container only takes as much width as its content */
        }


        .profile-user {
            position: absolute;
            margin-top: 2rem; /* Change 'top' to 'bottom' */
            right: 2rem;
            max-width: 4.5em;
            max-height: 4.5em;
            border: 1px solid #000;
            border-radius: 5px;
            z-index: 10; /* Place the image behind the text */
        }

        /* back */
        #back-container {
            text-align: center;
            margin-top: 12px;
            padding: 20px;
            border: solid black 1px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 690px;
            background-color: rgba(255, 255, 255, 0.7);
            position: relative;
            height: 182px;
            width: 295px;
            word-wrap: break-word;
        }

        #back-container p {
            font-size: 10px;
            margin: 0.2rem 0;
        }

        .back-content {
            text-align: center;
            font-size: 10px;
            padding: 5px 10px;
        }

        .section-title {
            font-weight: bold;
            font-size: 11px;
            margin-top: 0.5rem;
            margin-bottom: 0.3rem;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .section-content {
            margin-bottom: 0.8rem;
            line-height: 1.4;
        }


    </style>
</head>
<body>
<center>
<div id="clearance-container">
    <div class="certification">
        <!-- Watermark logo as background image for the entire container -->
        <div class="watermark-bg"></div>

        <div class="header-left">
            <img class="left-logo" src="{{ public_path('admin_assets/images/sanfernando.png') }}" alt="Panipuan Logo">
            <img class="right-logo" src="{{ public_path('admin_assets/images/logo-left.png') }}" alt="Mabalacat Logo">
        </div>
        <p class="header-title1">Republic of the Philippines <br>Province of Pampanga
        <br>Mabalacat City <br>OFFICE OF THE  SANGGUNIANG BARANGAY <br> <span>Barangay Panipuan</span></p>
        <!-- <p class="behind-text"><strong>BARANGAY ID</strong></p> -->

        <img class="profile-user" src="{{ public_path('barangayId/' . $barangayIds->barangayId_image) }}" alt="Profile Image">

        <section class="info-elements">
            <p class="body-p"><strong>ID No:</strong> <span class="dynamic-content1">{{ $barangayIds->id }}</span><br>
                <strong>Name:</strong> <span class="dynamic-content1">{{ $barangayIds->barangayId_full_name }}</span><br>
                <span dynamic-content1><strong>Address: </strong>{{ $barangayIds->barangayId_address }}</span><br>
                <span><strong>Date of Birth: </strong>{{ $barangayIds->barangayId_birthdate }}
                <span><strong>| Age:</strong> {{ $barangayIds->barangayId_age }}</span></span><br>
                <span dynamic-content1><strong>Place of Birth: </strong>{{ $barangayIds->barangayId_place_of_birth }}</span><br>
                <span><strong>Citizenship: </strong>{{ $barangayIds->barangayId_citizenship }}</span><br>
                <span dynamic-content1><strong>Gender: </strong>{{ $barangayIds->barangayId_gender }}</span><br>
                <span><strong>Civil Status: </strong>{{ $barangayIds->barangayId_civil_status }}</span><br>
                <span>__________</strong><br>Signature</span>
            </p>
        </section>
    </div>
</div>

{{-- BACK PAGE --}}
<div id="back-container">
    <div class="watermark-bg"></div>

    <div class="back-content">
        <p class="section-title">Emergency Contact Information</p>
        <p class="section-content">
            <strong>Name:</strong> {{ $barangayIds->barangayId_guardian ?? 'N/A' }}<br>
            <strong>Contact No:</strong> {{ $barangayIds->barangayId_contact_no ?? 'N/A' }}<br>
            <strong>Address:</strong> {{ $barangayIds->barangayId_email ?? 'N/A' }}
        </p>

        <p class="section-title">In Case of Emergency</p>
        <p class="section-content">
            Please contact the emergency contact listed above<br>
            or report to the nearest health center or barangay office.
        </p>
    </div>
</div>


</center>
</body>
</html>


