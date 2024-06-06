<?php
// Include the database connection file
include 'conn.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imagePath = '../REST/img/' . $username . '.' . $imageExtension;

        // Check if uploaded file is PNG, if so, move it directly
        if ($imageExtension === 'png') {
            move_uploaded_file($image['tmp_name'], $imagePath); // Move the uploaded PNG file directly
        } else {
            move_uploaded_file($image['tmp_name'], $imagePath); // Move the uploaded JPG file directly
        }

        $query = "UPDATE tblsenior SET image='$imagePath' WHERE username='$username'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'Image uploaded successfully.'));
        } else {
            echo json_encode(array('status' => 'fail', 'message' => 'Failed to update image path in database.'));
        }
    } else {
        echo json_encode(array('status' => 'fail', 'message' => 'No image uploaded or upload error.'));
    }

    // Close the database connection
    mysqli_close($connection);
} else {
    // If the request method is not POST
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('status' => 'fail', 'message' => 'Invalid request method.'));
}
?>
