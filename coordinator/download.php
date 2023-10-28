<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Define the directory path where the files are stored
    $file_path = 'images/' . $file; // Update with your actual file directory

    if (file_exists($file_path)) {
        // Set the appropriate headers for the download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        ob_clean();
        flush();
        readfile($file_path);
        exit;
    } else {
        // Handle file not found
        echo 'File not found';
    }
}
