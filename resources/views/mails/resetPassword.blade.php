<!DOCTYPE html>
<html>
    <head>
        <title>
            Reset Password
        </title>
    </head>
    <body>
        <p>Dear {{ $mailData['name'] ?? ($mailData['firstname'] ?? ($mailData['user']['name'] ?? 'User')) }},</p>
        <h1>This are your new CARHIRE login credentials</h1>
        <p>Email: {{ $mailData['email'] }}</p>
        <p>Password: {{ $mailData['password'] }}</p>
        <p>Please login with these credentials</p>
        <p>Thank you.</p>
        <p>Kind regards,</p>
        <p>Car Hire</p> 
    </body>
</html>