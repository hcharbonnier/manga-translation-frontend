<?php
require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload
session_start();

$value = $_REQUEST['value'] ?? '';
$id = $_REQUEST['id'] ?? '';

if(isset($_REQUEST["action"])) {
    switch ($_REQUEST["action"]) {
        case 'set_translation':
            if ( isset($_SESSION['image']))
                $_SESSION['image']->set_block_translation($id,$value);
            break;
        case 'set_blocks':
            set_block($value);
            break;
        case 'upload':
            upload();
        break;
    }
}


function set_block($value){
    $old_blocks=$_SESSION['image']->get_blocks();
    echo "old_blocks:".sizeof($old_blocks)."<br>";
        $_SESSION['image']->del_blocks();

    $new_blocks=json_decode($value,true);
    print_r($value);
    print_r($new_blocks);
    
    foreach($new_blocks as $block) {
        $_SESSION['image']->add_block($block['x1'],$block['y1'],$block['x2'],$block['y2'],$block['x3'],$block['y3'],$block['x4'],$block['y4'],false);
        }
}

function upload() {
    if (isset($_FILES['filename'])){
        unset($_SESSION['image']);
    }
    $target_dir = "uploads/";
    $imageFileType = strtolower(pathinfo($_FILES['filename']['name'],PATHINFO_EXTENSION));
    $filename_ori=basename($_FILES["filename"]["name"]);
    $filename=microtime().".".$imageFileType;
    
    $target_file=$target_dir.$filename;

    $uploadOk = 1;
    // Check if image file is a actual image or fake image
    if(isset($_REQUEST["submit"])) {
        $check = getimagesize($_FILES["filename"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Error:File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        header("HTTP/1.0 406 File already exists");
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["filename"]["size"] > 500000) {
        header("HTTP/1.0 406 File too large");
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        header("HTTP/1.0 406 Unsupported format");
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {
            $_SESSION['filename']=$filename;
            $_SESSION['filename_ori']=$filename_ori;
        } else {
            header("HTTP/1.0 406 Unknown upload error");
        }
    } 
}
?>