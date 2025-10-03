# M-Pesa Integration Guide

## Overview
Your Car Hire application now has a fully integrated M-Pesa payment system that automatically calculates the booking amount and sends payment prompts to customers' phones.

## How It Works

### 1. Frontend Calculation
- When a user enters the number of days or kilometers, the system automatically calculates the total amount
- The amount is displayed in real-time as the user types
- Users can see the exact amount they will pay before proceeding

### 2. Payment Process
- User clicks "Payment & Book" button
- System validates all inputs (phone number format, amount, etc.)
- User confirms the payment amount
- System creates a booking with "Pending" payment status
- M-Pesa STK Push is initiated with the exact booking amount
- User receives payment prompt on their phone with the correct amount

### 3. Payment Confirmation
- M-Pesa sends a callback to your application when payment is completed
- System automatically updates the booking status to "Paid" or "Failed"
- User receives confirmation of payment status

## Configuration Required

### Environment Variables
Add these to your `.env` file:

```env
MPESA_CONSUMER_KEY=your_consumer_key_here
MPESA_CONSUMER_SECRET=your_consumer_secret_here
MPESA_PASSKEY=your_passkey_here
MPESA_SHORTCODE=your_shortcode_here
MPESA_ENVIRONMENT=sandbox
```

### For Production
Change `MPESA_ENVIRONMENT` to `production` when going live.

## Features Implemented

### ✅ Real-time Amount Calculation
- Per-day bookings: `total_days × rate_per_day`
- Per-kilometer bookings: `total_km × rate_per_km`

### ✅ Input Validation
- Minimum 25km for per-kilometer bookings
- Minimum 1 day for per-day bookings
- Phone number format validation (+2547XXXXXXXX)
- Amount validation

### ✅ User Feedback
- Clear display of calculated amounts
- Confirmation dialogs before payment
- Detailed success/error messages
- Payment status updates

### ✅ Error Handling
- Comprehensive error logging
- Graceful failure handling
- User-friendly error messages
- Booking creation even if payment fails

### ✅ M-Pesa Integration
- Automatic phone number formatting
- Proper amount formatting for M-Pesa API
- Callback handling for payment confirmations
- Receipt number storage

## Testing

### Sandbox Testing
1. Use sandbox credentials from Safaricom
2. Test with sandbox phone numbers
3. Check logs for detailed debugging information

### Production Testing
1. Use production credentials from Safaricom
2. Test with real phone numbers
3. Monitor payment confirmations

## Troubleshooting

### Common Issues
1. **Payment not initiated**: Check M-Pesa credentials and network connectivity
2. **Wrong amount**: Verify rate calculations in the database
3. **Phone number errors**: Ensure proper +254 format
4. **Callback not received**: Check server accessibility and callback URL

### Logs
Check Laravel logs for detailed error information:
```bash
tail -f storage/logs/laravel.log
```

## Security Notes
- All M-Pesa credentials are stored in environment variables
- Phone numbers are validated and formatted securely
- Payment amounts are calculated server-side
- Callback URLs are protected from CSRF attacks

## Support
For M-Pesa API issues, contact Safaricom Developer Support.
For application issues, check the Laravel logs for detailed error information. 