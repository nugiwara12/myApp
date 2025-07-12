<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Residence Approved</title>
</head>
<body>
    <h2>Hi {{ $residence->resident_name }},</h2>

    <p>Your residence application has been <strong>approved</strong> 🎉</p>

    <p><strong>Approved by:</strong> {{ $residence->approved_by ?? 'Administrator' }}</p>

    <p>Thank you for submitting your details. If you have any questions, feel free to reach out.</p>

    <br>
    <p>Regards,<br>Barangay Office</p>
</body>
</html>
