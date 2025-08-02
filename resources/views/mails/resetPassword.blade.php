<!DOCTYPE html>
<html>
    <head>
        <title>
            Reset Password
        </title>
    </head>
    <body>
        <h1>This are your new login credentials</h1>
        <p>Email: {{ $mailData['email'] }}</p>
        <p>Password: {{ $mailData['password'] }}</p>
        <p>Please login with these credentials</p>
        <p>Thank you</p>
        <p>Car Hire</p> 
    </body>
</html>