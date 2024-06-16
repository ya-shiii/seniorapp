<?php
// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}
// Include the database connection file
include 'conn.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Parse the JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    $username = $data['username'];
    $newImage = $data['newImage'];

    // Path to the directory where images are stored
    $imageDirectory = '../REST/img/';

    // Construct the image path
    $imagePath = $imageDirectory . $username . '.png';

    // Save the new image
    if ($newImage && file_put_contents($imagePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $newImage)))) {
        // Update the image directory in the database
        $query = "UPDATE tblsenior SET image='$imagePath' WHERE username='$username'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            // Image uploaded and database updated successfully
            echo json_encode(array('status' => 'success', 'message' => 'Image uploaded and database updated successfully.'));
        } else {
            // Failed to update database
            echo json_encode(array('status' => 'fail', 'message' => 'Failed to update database.'));
        }
    } else {
        // No image uploaded or failed to save image
        echo json_encode(array('status' => 'fail', 'message' => 'No image uploaded or failed to save image.'));
    }
} else {
    // If the request method is not POST
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('status' => 'fail', 'message' => 'Invalid request method.'));
}
?>
