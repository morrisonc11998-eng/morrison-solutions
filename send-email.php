<?php
// Email configuration
$recipient = "morrisonc11998@gmail.com";
$subject = "New Project Request from CForged Website";

// Get form data
$name = htmlspecialchars($_POST['name'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? '');
$message = htmlspecialchars($_POST['message'] ?? '');

// Validate required fields
if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

// Create email body
$emailBody = "You have received a new project request from CForged website.\n\n";
$emailBody .= "Client Name: $name\n";
$emailBody .= "Client Email: $email\n";
$emailBody .= "Submitted: " . date('Y-m-d H:i:s') . "\n";
$emailBody .= "---\n\n";
$emailBody .= "Project Details:\n";
$emailBody .= "$message\n\n";
$emailBody .= "---\n";
$emailBody .= "Reply to: $email\n";

// Email headers
$headers = "From: noreply@cforged.local\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
if (mail($recipient, $subject, $emailBody, $headers)) {
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Project request sent successfully!']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to send email. Please try again.']);
}
?>
