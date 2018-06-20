<?php
$conn=mysqli_connect("localhost", "root", "", "blog");

//Used mysqli_real_escape_string o avoid apostrophe conflicts
$title=mysqli_real_escape_string($conn,trim($_POST['title']));
$meta=mysqli_real_escape_string($conn,trim($_POST['meta']));
$body=mysqli_real_escape_string($conn,trim($_POST['body']));

if(mysqli_connect_error()){
    die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
}
else{
    $new_url=friendly_seo_string($title);                                
    $counter=1;		
    $intial_url=$new_url;	
    
    while(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM article WHERE url ='$new_url'" ))){	          
        $counter++;        
        $new_url="{$intial_url}-{$counter}"; 
        //If the url already exists for some other article then put a number (-2, -3...etc) infront of it
    }      
 
    $target_dir = "title-image/";
    
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    
    $target_file = $target_dir.uniqid().".".$imageFileType;
    $new_name=uniqid().".".$imageFileType;
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $sql="INSERT INTO article (title, body, meta, url, image)
            VALUES ('$title', '$body', '$meta', '$new_url', '$new_name')";
            if($conn->query($sql)){
                echo "Done";
            } else {
                echo "Error".$sql."<br>".$conn->error;
            }      
        }    
    }
        
    
}  
                
//Function to generate SEO friendly url
function friendly_seo_string($vp_string){   														
    $vp_string = trim($vp_string);														
    $vp_string = html_entity_decode($vp_string);														
    $vp_string = strip_tags($vp_string);														
    $vp_string = strtolower($vp_string);														
    $vp_string = preg_replace('~[^ a-z0-9_.]~', ' ', $vp_string);														
    $vp_string = preg_replace('~ ~', '-', $vp_string);														
    $vp_string = preg_replace('~-+~', '-', $vp_string);												
    return $vp_string;
						
}        

$conn->close();
?>
