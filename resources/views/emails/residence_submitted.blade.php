<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Residence Submission Pending Approval</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 24px;
            border: 1px solid #e2e2e2;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #1B76B5;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        li {
            margin-bottom: 6px;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
        .status {
            background-color: #fff3cd;
            color: #856404;
            padding: 12px;
            border: 1px solid #ffeeba;
            border-radius: 6px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello {{ $residence->resident_name }},</h2>

        <div class="status">
            <strong>Your residence submission has been received and is currently pending approval.</strong>
        </div>

        <p>Thank you for submitting your residence information. Below are the details we received:</p>

        <h4>Residence Details:</h4>
        <ul>
            <li><strong>Name:</strong> {{ $residence->resident_name }}</li>
            <li><strong>Email:</strong> {{ $residence->resident_email_address }}</li>
            <li><strong>Age:</strong> {{ $residence->resident_age }}</li>
            <li><strong>Civil Status:</strong> {{ $residence->civil_status }}</li>
            <li><strong>Nationality:</strong> {{ $residence->nationality }}</li>
            <li><strong>Address:</strong> {{ $residence->address }}</li>
            <li><strong>Zip Code:</strong> {{ $residence->zip_code }}</li>
            <li><strong>Barangay:</strong> {{ $residence->barangay_name }}</li>
            <li><strong>Municipality:</strong> {{ $residence->municipality }}</li>
            <li><strong>Province:</strong> {{ $residence->province }}</li>
            <li><strong>Purpose:</strong> {{ $residence->resident_purpose }}</li>
            <li><strong>Certificate #:</strong> {{ $residence->certificate_number }}</li>
            <li><strong>Issue Date:</strong> {{ \Carbon\Carbon::parse($residence->issue_date)->format('F d, Y') }}</li>
            <li><strong>Voter's ID:</strong> {{ $residence->voters_id_pre_number }}</li>
            <li><strong>Criminal Record:</strong>
                {{ $residence->has_criminal_record ? 'Yes' : 'No' }}
            </li>
            <li><strong>Approved By:</strong> {{ $residence->approved_by ?? 'Pending Approval' }}</li>
        </ul>

        <p>We will notify you by email once your submission has been reviewed and approved.</p>

        <p class="footer">If you did not submit this information, please contact our support team immediately.</p>
    </div>
</body>
</html>
