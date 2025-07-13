<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barangay ID Approved</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 40px auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <h2 style="color: #111827;">Hi {{ $barangayId['barangayId_full_name'] }},</h2>

        <p style="font-size: 16px; color: #374151;">Your Barangay ID request has been <strong style="color: #10b981;">approved</strong>.</p>

        <div style="background-color: #f3f4f6; border-left: 5px solid #10b981; padding: 15px 20px; margin: 20px 0; border-radius: 5px;">
            <p style="margin: 0; font-size: 16px;"><strong>Generated Number:</strong> {{ $barangayId['barangayId_generated_number'] }}</p>
            <p style="margin: 0; font-size: 16px;"><strong>Status:</strong> Approved</p>
        </div>

        <p style="font-size: 16px; color: #374151;">You may now claim your Barangay ID from the Barangay Hall.</p>

        <p style="background-color: #fef3c7; border-left: 5px solid #f59e0b; padding: 15px 20px; border-radius: 5px; color: #92400e; font-size: 15px;">
            <strong>Note:</strong> Please present your <strong>Generated Number</strong> when claiming your Barangay ID. This number is required to verify and release your ID.
        </p>

        <p style="font-size: 16px; color: #374151;">Thank you!</p>
    </div>
</body>
</html>
