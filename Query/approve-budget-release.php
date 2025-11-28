<?php
session_start();
include('../connection/connection.php'); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get user ID from session
$user_id = $_SESSION['user_id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['budget_release'])) {

    // Collect form data safely
    $project_id = intval($_POST['id']); // Resolution ID
    $recipient = mysqli_real_escape_string($conn, $_POST['recipient']);
    $release_date = mysqli_real_escape_string($conn, $_POST['release_date']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $reference_number = mysqli_real_escape_string($conn, $_POST['reference_number']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    $approval_notes = mysqli_real_escape_string($conn, $_POST['approval_notes']);

    // Upload directory (must exist and be writable)
    $upload_dir = __DIR__ . '/../uploads/budget_release/';

    if (!is_dir($upload_dir)) {
        die("Folder does not exist: $upload_dir");
    }
    if (!is_writable($upload_dir)) {
        die("Folder exists but is not writable: $upload_dir");
    }

    $allowed_types = ['application/pdf'];

    // Function to handle PDF upload
    function upload_pdf($file_input_name, $upload_dir, $allowed_types) {
        if (!isset($_FILES[$file_input_name]) || $_FILES[$file_input_name]['error'] != 0) {
            return ''; // No file uploaded
        }

        $file_tmp  = $_FILES[$file_input_name]['tmp_name'];
        $file_name = time() . '_' . preg_replace("/[^a-zA-Z0-9_\.-]/", "_", $_FILES[$file_input_name]['name']);
        $file_type = mime_content_type($file_tmp);

        if (!in_array($file_type, $allowed_types)) {
            die(ucwords(str_replace('_', ' ', $file_input_name)) . " must be a PDF file.");
        }

        if (!move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            die("Failed to move file: $file_name. Check folder permissions.");
        }

        return $file_name;
    }

    // Upload acknowledgement receipt
    $ack_file_name = upload_pdf('acknowledgement_receipt', $upload_dir, $allowed_types);

    // Insert into budget_release table
    $sql = "INSERT INTO budget 
            (project_id, recipient, release_date, payment_method, reference_number, acknowledgement_receipt, purpose, approval_notes, created_by, has_release) 
            VALUES 
            ('$project_id', '$recipient', '$release_date', '$payment_method', '$reference_number', '$ack_file_name', '$purpose', '$approval_notes', '$user_id', '1')";

    if (mysqli_query($conn, $sql)) {
        // Update resolution to mark budget released
        mysqli_query($conn, "UPDATE resolution SET is_budget_released = 1 WHERE id = '$project_id'");
        echo "<script>alert('Budget release recorded successfully.'); window.location.href='../Users/treasurer/tres-project.php';</script>";
        exit;
    } else {
        die("Database error: " . mysqli_error($conn));
    }
}
?>
