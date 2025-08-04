<?php
// Test script to check email functionality
header('Content-Type: text/html; charset=UTF-8');

echo "<h2>Email Function Test</h2>";

// Check if mail function exists
if (function_exists('mail')) {
    echo "<p style='color: green;'>✓ mail() function is available</p>";
    
    // Test sending a simple email
    $to = 'admin@ninthresources.com.au';
    $subject = 'Test Email from 9th Resources';
    $message = 'This is a test email to verify the mail function is working.';
    $headers = 'From: 9th Resources <noreply@ninthresources.com.au>';
    
    echo "<h3>Attempting to send test email...</h3>";
    
    $result = @mail($to, $subject, $message, $headers);
    
    if ($result) {
        echo "<p style='color: green;'>✓ Test email sent successfully!</p>";
    } else {
        echo "<p style='color: red;'>✗ Failed to send test email</p>";
        
        // Check for errors
        $error = error_get_last();
        if ($error) {
            echo "<p>Last error: " . htmlspecialchars($error['message']) . "</p>";
        }
    }
    
} else {
    echo "<p style='color: red;'>✗ mail() function is NOT available on this server</p>";
    echo "<p>This server doesn't support the PHP mail() function. You'll need to:</p>";
    echo "<ul>";
    echo "<li>Use SMTP authentication (like PHPMailer)</li>";
    echo "<li>Contact your hosting provider to enable mail functionality</li>";
    echo "<li>Use a third-party email service (like SendGrid, Mailgun)</li>";
    echo "</ul>";
}

// Display PHP configuration
echo "<h3>PHP Mail Configuration:</h3>";
echo "<p>sendmail_path: " . ini_get('sendmail_path') . "</p>";
echo "<p>SMTP: " . ini_get('SMTP') . "</p>";
echo "<p>smtp_port: " . ini_get('smtp_port') . "</p>";

// Check if we're running locally
if (isset($_SERVER['SERVER_NAME']) && (
    $_SERVER['SERVER_NAME'] === 'localhost' || 
    $_SERVER['SERVER_NAME'] === '127.0.0.1' ||
    strpos($_SERVER['SERVER_NAME'], '.local') !== false
)) {
    echo "<p style='color: orange;'>⚠️ Running on local server - email functionality may not work without proper SMTP configuration</p>";
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Email Test</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        h2, h3 { color: #333; }
        p { margin: 10px 0; }
        ul { margin: 10px 0 10px 20px; }
    </style>
</head>
<body>
    <a href="contact.html" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #007cba; color: white; text-decoration: none; border-radius: 5px;">← Back to Contact Form</a>
</body>
</html>