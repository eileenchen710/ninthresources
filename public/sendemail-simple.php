<?php
// Simple fallback email handler
header('Content-Type: application/json');

// Configuration
$to_email = 'admin@ninthresources.com.au';
$site_name = '9th Resources';

// Initialize response
$response = array();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit-form'])) {
    
    // Get form data
    $name = isset($_POST['username']) ? strip_tags(trim($_POST['username'])) : '';
    $email = isset($_POST['email']) ? strip_tags(trim($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? strip_tags(trim($_POST['phone'])) : '';
    $subject = isset($_POST['subject']) ? strip_tags(trim($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? strip_tags(trim($_POST['message'])) : '';
    
    // Basic validation
    if (empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)) {
        $response['success'] = false;
        $response['message'] = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['success'] = false;
        $response['message'] = 'Please enter a valid email address.';
    } else {
        
        // Simple email format
        $email_subject = "Contact Form: $subject";
        $email_message = "New contact form submission:\n\n";
        $email_message .= "Name: $name\n";
        $email_message .= "Email: $email\n";
        $email_message .= "Phone: $phone\n";
        $email_message .= "Subject: $subject\n";
        $email_message .= "Message:\n$message\n\n";
        $email_message .= "Sent from: $site_name website\n";
        $email_message .= "Date: " . date('Y-m-d H:i:s') . "\n";
        
        // Simple headers
        $headers = "From: $site_name <noreply@ninthresources.com.au>\r\n";
        $headers .= "Reply-To: $name <$email>\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        // Try to send email
        if (function_exists('mail')) {
            $mail_sent = @mail($to_email, $email_subject, $email_message, $headers);
            
            if ($mail_sent) {
                $response['success'] = true;
                $response['message'] = 'Thank you! Your message has been sent successfully.';
            } else {
                $response['success'] = false;
                $response['message'] = 'Unable to send email. Please contact us directly at ' . $to_email . ' or call (02) 9630 2967.';
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Email functionality is not available. Please contact us directly at ' . $to_email . ' or call (02) 9630 2967.';
        }
    }
    
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request method';
}

// Return response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    echo json_encode($response);
} else {
    $status = $response['success'] ? 'success' : 'error';
    $message = urlencode($response['message']);
    header("Location: contact.html?status=$status&message=$message");
}

exit();
?>