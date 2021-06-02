<?php
    if(isset($_POST['my_file'])){
        $encoded_file = $_POST['my_file'];
        $title = $_POST['my_file']['name'];
        $file = base64_decode($encoded_file);
        file_put_contents($title, $file);
    }
?>