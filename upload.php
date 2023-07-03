<?php
// Check if a file was uploaded successfully
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Specify the directory where you want to save the uploaded files
    $uploadDirectory = 'uploads/';

    // Get the file name and generate a unique name to prevent overwriting
    $fileName = $file['name'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $uniqueFileName = uniqid().'.'.$fileExtension;

    // Move the file to the upload directory
    $destination = $uploadDirectory . $uniqueFileName;
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        // File uploaded successfully
        echo 'File uploaded successfully.';
    } else {
        // Failed to upload file
        echo 'Failed to upload file.';
    }
} else {
    // No file was uploaded
    echo 'No file received.';
}
?>
