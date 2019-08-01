<?php

$dir = "Home"; // Change directory name

// If using a GET/POST request
if (isset($_REQUEST) && $_REQUEST['folder_name'] != '') {
    $dir = $_REQUEST['folder_name'];
}

// function scans the files folder recursively, and builds a array of files and folders

function scan($dir)
{
    
    $files = array();
    
    // checking for a folder/file?
    
    if (file_exists($dir)) {
        
        foreach (scandir($dir) as $f) {
            
            if (!$f || $f[0] == '.') {
                continue; // Ignore hidden files
            }
            // Check for folder
            if (is_dir($dir . '/' . $f)) {
                $files[] = array(
                    "name" => $f,
                    "type" => "folder",
                    "path" => $dir . '/' . $f,
                    "items" => scan($dir . '/' . $f) // Recursively get the contents of the folder
                );
            }
            // Check for file
            else if (is_file($dir . '/' . $f)) {
                $files[] = array(
                    "name" => $f,
                    "type" => "file",
                    "path" => $dir . '/' . $f,
                    "size" => filesize($dir . '/' . $f) // Gets the size of this file
                );
            }
        }
        
    }
    
    return $files;
}


// Output the data as JSON

header('Content-type: application/json');

echo json_encode(array(
    "name" => basename($dir),
    "type" => "folder",
    "path" => $dir,
    "items" => $response
));



// call the function

$response = scan($dir);

echo "<pre>";
print_r($response);
echo "</pre>";

?>
