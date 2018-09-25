<?php session_start();
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 4/27/2017
 * Time: 11:01 AM
 */
header('Content-type: multipart/form-data; charset=utf-8');

require 'rest/custom/func.php';
require 'rest/classes/User.php';

$u = new User();

$user_id = $_SESSION['id'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if($_FILES["file"]["name"] !== ''){
        $upload = '';
        $img = $_FILES["file"];
        $prefix = 'gistout-';
        $renamed = time();
        $folder = 'docs/img/user_avatar/';

        // if file exist then the path = path/to/folder/$renamed.$extension;
        $allowedExts = array("gif", "jpeg", "jpg", "pjpeg", "png", "JPEG", "JPG", "PJPEG", "PNG");
        $temp = explode(".", $img["name"]);
        $extension = end($temp);
        if ((($img["type"] == "image/jpeg") || ($img["type"] == "image/jpg") || ($img["type"] == "image/png")) && ($img["size"] < 200000) && in_array($extension, $allowedExts))
        {
            if ($img["error"] > 0) {
                echo "Return Error: " . $img["error"] . "<br>";
            } else {
                $altName = $prefix.sha1($user_id).'.'.$extension;
                $path = $folder . $altName;
                $insert = $u->updateByUserAvatar($user_id, $path);
                if ($insert == true) {
                    if (move_uploaded_file($img["tmp_name"], $path)) {
                        print 5; // Upload Successful;
                    }
                } else {
                    print 2; // print 'image could not be uploaded.Didn\'t Insert.';
                }
            }
        } else {
            print 3; // echo "File size to large or File type is not supported";
        }
    }
} else {
    print 0;
}

// Full-size master image URL
//$sourceImageUrl = 'http://example.com/image.png';
//
//// Comma-separated options string
//$options = 'full';
//
//// Settings needed to switch to the POST method
//$postContext = stream_context_create([
//    'http' => [
//        'method' => 'POST',
//    ],
//]);
//
//// Get image data from the API
//$imageData = file_get_contents('https://im2.io/znvfwgxszs/' . $options . '/' . $sourceImageUrl, false, $postContext);
//
//// At this point $imageData contains resized/optimized image
//// You can save it to the disk on the server
//file_put_contents('images/image-optimized.png', $imageData);