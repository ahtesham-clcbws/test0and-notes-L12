<div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 12px; color: #333; line-height: 1.6;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="color: #1a1a1a; font-size: 24px; font-weight: 800; margin: 0;">Test & Notes</h1>
        <p style="color: #666; font-size: 14px; margin-top: 5px;">Secure Authentication</p>
    </div>

    <div style="background-color: #f9f9f9; padding: 30px; border-radius: 8px; text-align: center;">
        <p style="font-size: 16px; margin-bottom: 20px; color: #555;">Dear user,</p>
        <p style="font-size: 16px; margin-bottom: 10px;">Your OTP for login/ signup to <strong>www.testandnotes.com</strong> portal is:</p>
        
        <div style="background: #1a1a1a; color: #ffffff; font-size: 36px; font-weight: 800; padding: 15px 30px; display: inline-block; border-radius: 10px; margin: 20px 0; letter-spacing: 5px;">
            {{ $otp }}
        </div>

        <p style="font-size: 14px; color: #888; margin-top: 20px;">
            Valid for <strong>10 minutes</strong>.<br>
            Do not share this OTP with anyone.
        </p>
    </div>

    <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; text-align: center;">
        <p style="font-size: 14px; color: #999; margin: 0;">
            Regards,<br>
            <strong>Test & Notes Management</strong>
        </p>
        <p style="font-size: 12px; color: #bbb; margin-top: 10px;">
            &copy; {{ date('Y') }} Test & Notes. All rights reserved.
        </p>
    </div>
</div>
