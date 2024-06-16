<?php
// Allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include the database connection file
    include 'conn.php';

    // Get the JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Extract data from the JSON input
    $appointment_id = $data['appointment_id'];
    $barangay = $data['barangay'];
    $appointment_date = $data['appointment_date'];
    $appointment_time = $data['appointment_time'];

    // Validate the input data (you can add more validation as needed)
    if (empty($appointment_id) || empty($barangay) || empty($appointment_date) || empty($appointment_time)) {
        http_response_code(400);
        echo json_encode(array("message" => "Invalid input data."));
        exit();
    }

    // Escape the input data to prevent SQL injection
    $appointment_id = mysqli_real_escape_string($conn, $appointment_id);
    $barangay = mysqli_real_escape_string($conn, $barangay);
    $appointment_date = mysqli_real_escape_string($conn, $appointment_date);
    $appointment_time = mysqli_real_escape_string($conn, $appointment_time);

    // Prepare the SQL query to update the appointment details
    $query = "UPDATE tblappointment 
              SET barangay = '$barangay', appointment_date = '$appointment_date', appointment_time = '$appointment_time' 
              WHERE appointment_id = '$appointment_id'";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Check if any row was updated
        if (mysqli_affected_rows($conn) > 0) {
            http_response_code(200);
            echo json_encode(array("message" => "Appointment updated successfully."));
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Appointment not found or no changes made."));
        }
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Failed to update the appointment."));
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // If the request method is not POST, return a 405 Method Not Allowed response
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
?>
