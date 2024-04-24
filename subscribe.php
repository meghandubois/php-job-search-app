<?php
// Set content type to JSON
header("Content-Type: application/json");

// Check if this is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the POST data sent from the frontend
    $postData = json_decode(file_get_contents("php://input"), true);

    // Check if email is provided
    if (isset($postData['email'])) {
        $email = $postData['email'];

        // Email address database code here

        // Send email confirmation
        $to = $email;
        $subject = "Subscription Confirmation";
        $message = "You have been subscribed to our newsletter.";
        $headers = "From: your@example.com"; // Change this to your email address
        $success = mail($to, $subject, $message, $headers);

        if ($success) {
            // Send success response to the frontend
            echo json_encode(array('success' => true, 'message' => 'Email subscribed successfully.'));
        } else {
            // Send error response if email couldn't be sent
            http_response_code(500);
            echo json_encode(array('error' => 'Failed to send email.'));
        }
    } else {
        // If email is missing, send an error response
        http_response_code(400);
        echo json_encode(array('error' => 'Email is required.'));
    }
} else {
    // If it's not a POST request, send an error response
    http_response_code(405);
    echo json_encode(array('error' => 'Method Not Allowed'));
}
?>
r