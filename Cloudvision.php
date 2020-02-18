<?php

require "vendor/autoload.php";
use Google\Cloud\Vision\VisionClient;

if(isset($_FILES['image'])){
    $file_name = $_FILES['image']['name'];
    $file_tmp =$_FILES['image']['tmp_name'];
    move_uploaded_file($file_tmp,"images/".$file_name);
    echo "<h3>Image Upload Success</h3>";
    echo '<img src="images/'.$file_name.'" style="width:100%">';
    echo "<br><h3>OCR after reading</h3><br><pre>";



    $vision = new VisionClient(['keyFile' => json_decode(file_get_contents("key.json"),true)]);

    $ressource = fopen("images/".$file_name,'r');

    $image = $vision->image($ressource,['TEXT_DETECTION']);

    $result = $vision->annotate($image);

    $text = $result->text();
    $fullText = $result->fullText();
    echo $text[0]->info()['description'];


}
