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
        case 'merge_blocks':
            merge_blocks($_REQUEST['id1'],$_REQUEST['id2']);
        break;
        case 'get_blocks':
            echo json_encode($_SESSION['image']->get_blocks());
        break;
        case 'add_block':
            add_block($value);
        break;
        case 'delete_block':
            delete_block($id);
        break;
    }
}



function delete_block($id){
    $_SESSION['image']->del_block($id);
}

function add_block($value){
    $block=json_decode($value,true);
    $_SESSION['image']->add_block($block['x1'],$block['y1'],$block['x2'],$block['y2'],$block['x3'],$block['y3'],$block['x4'],$block['y4'],false);
}

function merge_blocks($id1,$id2){
    $_SESSION['image']->merge_blocks($id1,$id2);
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
    if ($_FILES["filename"]["size"] > substr(ini_get('upload_max_filesize'), 0, -1) * 1048576) {
        header("HTTP/1.0 406 File too large. upload_max_filesize:".ini_get(upload_max_filesize));
        $uploadOk = 0;
    }
    if ($_FILES["filename"]["size"] > substr(ini_get('post_max_size'), 0, -1) * 1048576) {
        header("HTTP/1.0 406 File too large. post_max_size:".ini_get(post_max_size));
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