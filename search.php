<?php
// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow the following methods from the frontend
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Allow the following headers from the frontend
header("Access-Control-Allow-Headers: Content-Type");

// Set content type to JSON
header("Content-Type: application/json");

// Check if this is a preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

// Retrieve the POST data sent from the frontend
$postData = json_decode(file_get_contents("php://input"), true);

// Check if both URL and keyword are provided
if (isset($postData['url']) && isset($postData['keyword'])) {
    $url = $postData['url'];
    $keyword = $postData['keyword'];

    // Fetch HTML content from the URL
    $html = file_get_contents($url);

    // Search for the keyword in the HTML content
    $count = substr_count($html, $keyword);

    if ($count > 0) {
        // Keyword found
        $response = array('message' => "Keyword found $count times.", 'count' => $count);
    } else {
        // Keyword not found
        $response = array('message' => 'Keyword not found.', 'count' => 0);
    }

    // Send JSON response back to the frontend
    echo json_encode($response);
} else {
    // If URL or keyword is missing, send an error response
    http_response_code(400);
    echo json_encode(array('error' => 'URL and keyword are required.'));
}
?>
