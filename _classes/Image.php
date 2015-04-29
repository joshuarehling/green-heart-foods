<?php 

class Image {

	public function __construct() {}

    public function upload_image($files_array, $file_name) {
        $unique_id = uniqid();
        $file = $files_array[$file_name]["name"];
        $upload_directory = "../_uploads/";
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $upload_path = $upload_directory . $unique_id ."." . $extension;
        if(move_uploaded_file($files_array[$file_name]["tmp_name"], $upload_path)) {
            return $unique_id.".".$extension;
        } else {
            return null;
        }
    }
}