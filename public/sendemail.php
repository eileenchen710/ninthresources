<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors to user
ini_set('log_errors', 1);     // Log errors

// Set the content type to JSON for AJAX responses
header('Content-Type: application/json');

// Configuration
$to_email = 'admin@ninthresources.com.au';
$site_name = '9th Resources';
$site_url = 'https://ninthresources.com.au';

// Initialize response array
$response = array();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-form'])) {
    
    // Get and sanitize form data
    $name = isset($_POST['username']) ? trim(strip_tags($_POST['username'])) : '';
    $email = isset($_POST['email']) ? trim(strip_tags($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? trim(strip_tags($_POST['phone'])) : '';
    $subject = isset($_POST['subject']) ? trim(strip_tags($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';
    
    // Validation
    $errors = array();
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }
    
    if (empty($phone)) {
        $errors[] = 'Phone number is required';
    }
    
    if (empty($subject)) {
        $errors[] = 'Subject is required';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required';
    }
    
    // Basic spam protection
    if (strpos($message, 'http') !== false || strpos($message, 'www') !== false) {
        $errors[] = 'Message contains suspicious content';
    }
    
    // If no errors, send email
    if (empty($errors)) {
        
        // Email subject
        $email_subject = "Contact Form: $subject - $site_name";
        
        // Email body
        $email_body = "
        <html>
        <head>
            <title>Contact Form Submission - $site_name</title>
        </head>
        <body>
            <h2>New Contact Form Submission</h2>
            <p><strong>Website:</strong> $site_name ($site_url)</p>
            <p><strong>Date:</strong> " . date('Y-m-d H:i:s') . "</p>
            <hr>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong></p>
            <p>" . nl2br(htmlspecialchars($message)) . "</p>
            <hr>
            <p><em>This message was sent from the contact form on $site_name</em></p>
        </body>
        </html>
        ";
        
        // Email headers
        $headers = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/html; charset=UTF-8";
        $headers[] = "From: $site_name <noreply@ninthresources.com.au>";
        $headers[] = "Reply-To: $name <$email>";
        $headers[] = "Return-Path: noreply@ninthresources.com.au";
        $headers[] = "X-Mailer: PHP/" . phpversion();
        
        // Send email with error handling
        $mail_sent = @mail($to_email, $email_subject, $email_body, implode("\r\n", $headers));
        
        // Check for mail function availability
        if (!function_exists('mail')) {
            $response['success'] = false;
            $response['message'] = 'Mail function is not available on this server. Please contact us directly at ' . $to_email;
        } elseif ($mail_sent) {
            $response['success'] = true;
            $response['message'] = 'Thank you! Your message has been sent successfully. We will get back to you soon.';
        } else {
            // Get the last error
            $error = error_get_last();
            $error_message = $error ? $error['message'] : 'Unknown error';
            
            $response['success'] = false;
            $response['message'] = 'Sorry, there was an error sending your message. Please contact us directly at ' . $to_email . ' or call (02) 9630 2967.';
            $response['debug'] = 'Error: ' . $error_message; // Only for debugging
        }
        
    } else {
        $response['success'] = false;
        $response['message'] = 'Please correct the following errors: ' . implode(', ', $errors);
    }
    
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request method';
}

// Check if this is an AJAX request
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Return JSON response for AJAX
    echo json_encode($response);
} else {
    // For non-AJAX requests, redirect back to contact page with message
    $message = urlencode($response['message']);
    $status = $response['success'] ? 'success' : 'error';
    header("Location: contact.html?status=$status&message=$message");
}

exit();
?>