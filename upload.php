<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["videoFile"]["name"]);
$uploadOk = 1;
$videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (isset($_POST["submit"])) {
    
    if ($_FILES["videoFile"]["size"] > 50000000) {
        echo "Xin lỗi, tệp của bạn quá lớn.";
        $uploadOk = 0;
    }

    
    if ($videoFileType != "mp4" && $videoFileType != "avi" && $videoFileType != "mov"
        && $videoFileType != "wmv") {
        echo "Xin lỗi, chỉ cho phép các định dạng MP4, AVI, MOV & WMV.";
        $uploadOk = 0;
    }
}

if ($uploadOk == 0) {
    echo "Video của bạn chưa được tải lên.";
} else {
  
    if (move_uploaded_file($_FILES["videoFile"]["tmp_name"], $target_file)) {
       
        header("Location: videos.php");
        exit(); 
    } else {
        echo "Đã xảy ra lỗi khi tải video của bạn lên.";
    }
}
?>
