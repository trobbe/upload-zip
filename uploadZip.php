<?php
/*
 * control upload event errors by creating an errorMessage variable
 *
 * - check if no file were uploaded
 * - check the content type
 * - check the upload max size limit
 */
$images = [];
switch ($_FILES['the_file']['error']) {
    case UPLOAD_ERR_INI_SIZE:
        $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
        break;
    case UPLOAD_ERR_FORM_SIZE:
        $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
        break;
    case UPLOAD_ERR_PARTIAL:
        $message = "The uploaded file was only partially uploaded";
        break;
    case UPLOAD_ERR_NO_FILE:
        $message = "No file was uploaded";
        break;
    case UPLOAD_ERR_NO_TMP_DIR:
        $message = "Missing a temporary folder";
        break;
    case UPLOAD_ERR_CANT_WRITE:
        $message = "Failed to write file to disk";
        break;
    case UPLOAD_ERR_EXTENSION:
        $message = "File upload stopped by extension";
        break;
    case UPLOAD_ERR_OK:
//uploading successfully done
        if (mime_content_type($_FILES['the_file']['tmp_name']) === 'application/zip') {
            $images[]= $_FILES['the_file']['name'];
            $target_path = "thumbnails/" .microtime(true).'.zip';
            var_dump(move_uploaded_file($_FILES["the_file"]["tmp_name"], $target_path));
        }
        else {
            $message = "The file isn't a zip";
        }
        break;

    default:
        $message = "Unknown upload error";
}

// if all went fine ===>

// 1) create a NEW UNIQUE uploaded zip filename

// 2) upload the zip on the server

// 3) declare an empty array of resized images

// 4) instantiate the ZipArchive class

// 5) open the uploaded zip

// 6) loop on each entries of the zip

// 7) retrieve local entrie filenames

// 8) retrieve file "basename" (filenames without directory)

// 09) we skip directories

// 10) retrieve absolute zip entries filenames $fileZipLocation = "zip://".$tempFileName."#".$filename;

// 11) retrieve file content-type

// 12) we restrict loop to images only

// 13) save the image type that will be used lately in eval();

// 14) create a relative path destination variable

// 15) copy file from zip to thumbnails relative dir

// 16) Resize part
/*
 * retrieve origin image width & height
 *
 * origin ratio => 1200 / 900 = 1.33
 *
 * both new width & height must be defined before!
 *
 *  1.33 > 1
 *
 *  150 / 1.33 = 112.5
 *
 * imagecreatetruecolor()
 * imagecreatefromXXX()
 * imagecopyresampled()
 * imageXXX()
*/

// 17) for imagecreatefromXXX we can use eval(); with function that expect string as parameters

// 18) we cannot use eval with function imageXXX since first param is a resource

// 19) finally push all imagenames in array of images

// 20) close the zip

// 21) delete the zip

// 22) check if there were at least 1 image in the zip

// need to force apache header content type to json if the server always return "text/html" content type
//header('Content-Type: application/json');

// 23) finally return error message or the array of images

/*if($_FILES["the_file"]["name"]) {
    $filename = $_FILES["the_file"]["name"];
    $source = $_FILES["the_file"]["tmp_name"];
    $type = $_FILES["the_file"]["type"];

    $name = explode(".", $filename);
    $accepted_types = 'application/zip';
    if($accepted_types == $type) {
        $okay = true;
    }
}

    $continue = strtolower($name[1]) == 'zip' ? true : false;
    if(!$continue) {
        $message = "The file you are trying to upload is not a .zip file. Please try again.";
    }

    $target_path = "/home/wali12/sites/upload-zip".$filename;  // change this to the correct site path
    if(move_uploaded_file($source, $target_path)) {
        $zip = new ZipArchive();
        $x = $zip->open($target_path);
        if ($x === true) {
            $zip->extractTo("/home/var/yoursite/httpdocs/"); // change this to the correct site path
            $zip->close();

            unlink($target_path);
        }
        $message = "Your .zip file was uploaded and unpacked.";
    } else {
        $message = "There was a problem with the upload. Please try again.";
    }
}*/

echo json_encode($message ?? $images);
