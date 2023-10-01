<?php
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if ($data !== null && isset($data['data'])) {
    $scannedData = $data['data'];

    // Process the scanned data (for demonstration, just echoing it)
    echo "Received and processed data: " . $scannedData;
} else {
    http_response_code(400); // Bad Request
    echo "Invalid input data";
}
?>