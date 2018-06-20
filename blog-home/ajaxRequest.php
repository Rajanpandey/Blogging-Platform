<?php
$conn=mysqli_connect("localhost", "root", "", "blog");

if(isset($_POST["IncrementBlogViews"])) {	
    $url = $_POST['url'];
    
    //Fetch the current views from the DB
    $numOfViews="SELECT views FROM article WHERE url='$url'";
    $fetchViews=mysqli_query($conn,$numOfViews);                 
    
    //Increment the number of views by 1
    $row = mysqli_fetch_array($fetchViews, MYSQLI_ASSOC);      
    $incrementViews=$row['views']+1;           

    //Store the updated views in the DB
    $updateViews="UPDATE article SET views ='$incrementViews' where url='$url'";   
    $updatedViews=mysqli_query($conn, $updateViews);        
}	
$conn->close();
?>
