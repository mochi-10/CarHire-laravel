# M-Pesa Sandbox Troubleshooting Guide

## Common Sandbox Issues & Solutions

### 1. **Sandbox Phone Numbers Only**
**Problem**: M-Pesa sandbox only works with specific test phone numbers.

**Solution**: Use these sandbox phone numbers for testing:
```
+254708374149
+254708374150
+254708374151
+254708374152
+254708374153
+254708374154
+254708374155
+254708374156
+254708374157
+254708374158
+254708374159
```

### 2. **Sandbox Credentials Required**
**Problem**: You need specific sandbox credentials, not production ones.

**Solution**: Get sandbox credentials from Safaricom Developer Portal:
```env
MPESA_CONSUMER_KEY=sandbox_consumer_key_here
MPESA_CONSUMER_SECRET=sandbox_consumer_secret_here
MPESA_PASSKEY=sandbox_passkey_here
MPESA_SHORTCODE=174379
MPESA_ENVIRONMENT=sandbox
```

### 3. **Amount Limitations**
**Problem**: Sandbox has specific amount requirements.

**Solution**: 
- Use amounts between 1-1000 KSH for testing
- Avoid decimal amounts (use whole numbers)
- Test with common amounts like: 100, 500, 1000

### 4. **Network Connectivity**
**Problem**: Sandbox API might be slow or unreachable.

**Solution**: 
- Check your internet connection
- Ensure your server can reach `sandbox.safaricom.co.ke`
- Add timeout handling to your requests

### 5. **Callback URL Issues**
**Problem**: Sandbox can't reach your local callback URL.

**Solution**: 
- Use ngrok or similar tool to expose your local server
- Update your callback URL to be publicly accessible
- Test callback URL manually

## Quick Fixes

### 1. **Update Your .env File**
```env
MPESA_CONSUMER_KEY=your_sandbox_consumer_key
MPESA_CONSUMER_SECRET=your_sandbox_consumer_secret
MPESA_PASSKEY=your_sandbox_passkey
MPESA_SHORTCODE=174379
MPESA_ENVIRONMENT=sandbox
```

### 2. **Test with Sandbox Phone Numbers**
Only use the sandbox phone numbers listed above for testing.

### 3. **Use Simple Amounts**
Test with amounts like 100, 500, or 1000 KSH.

### 4. **Check Logs**
Monitor your Laravel logs for detailed error messages:
```bash
tail -f storage/logs/laravel.log
```

## Testing Steps

### Step 1: Verify Configuration
1. Check your `.env` file has sandbox credentials
2. Ensure `MPESA_ENVIRONMENT=sandbox`
3. Verify `MPESA_SHORTCODE=174379`

### Step 2: Test with Sandbox Phone
1. Use one of the sandbox phone numbers
2. Try a simple amount (e.g., 100 KSH)
3. Check the logs for any errors

### Step 3: Monitor Response
1. Check if you get a `CheckoutRequestID`
2. Look for any error messages in logs
3. Verify the phone number format

## Common Error Messages

### "Invalid phone number"
- Use only sandbox phone numbers
- Ensure proper +254 format

### "Invalid amount"
- Use amounts between 1-1000
- Use whole numbers only

### "Authentication failed"
- Check your sandbox credentials
- Ensure you're using sandbox API URL

### "Network timeout"
- Check your internet connection
- Increase timeout settings

## Production vs Sandbox Differences

| Feature | Sandbox | Production |
|---------|---------|------------|
| API URL | sandbox.safaricom.co.ke | api.safaricom.co.ke |
| Phone Numbers | Limited test numbers | Any valid M-Pesa number |
| Amounts | 1-1000 KSH | Any valid amount |
| Credentials | Sandbox specific | Production credentials |
| Callbacks | May be delayed | Real-time |

## Getting Sandbox Credentials

1. Go to [Safaricom Developer Portal](https://developer.safaricom.co.ke/)
2. Create a sandbox app
3. Get your sandbox credentials
4. Use the test phone numbers provided

## Next Steps

1. **Get proper sandbox credentials** from Safaricom
2. **Test with sandbox phone numbers** only
3. **Use simple amounts** for testing
4. **Monitor logs** for detailed error information
5. **Once working, switch to production** when ready

## Need Help?

If you're still having issues:
1. Check the Laravel logs for specific error messages
2. Verify your sandbox credentials are correct
3. Test with the exact sandbox phone numbers
4. Contact Safaricom Developer Support for sandbox issues 