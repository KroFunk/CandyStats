<?php
$arr_file_types = ['application/octet-stream'];
 
if (!(in_array($_FILES['file']['type'], $arr_file_types))) {
    echo "Error: Only .log files are supported 'application/octet-stream'.\n\nFile provided: " . $_FILES['file']['type'];
    return;
}
 
if (!file_exists('uploads')) {
    mkdir('uploads', 0777);
}
 
move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . time() . $_FILES['file']['name']);
 
echo "File uploaded successfully.";
?>