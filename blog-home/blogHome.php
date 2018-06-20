<?php
$conn=mysqli_connect("localhost", "root", "", "blog");

if(mysqli_connect_error()){
    die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
}
        
//If page is selected from pagination, get that page number else set it to 1
if(isset($_GET["page"])) {
    $page  = $_GET["page"]; 
} else { 
    $page=1; 
}; 
    
$num_rec_per_page=9;

//Logic for fetching 9 posts according to the page number
$start_from=($page-1)*$num_rec_per_page; 
$sql="SELECT * FROM article ORDER BY serial DESC LIMIT $start_from, $num_rec_per_page"; 
$result=mysqli_query($conn, $sql);
$array = array();//create empty array
    
while($row=$result->fetch_array()){//loop to get all results
         $array[]=$row;//grab everything and store inside array
}  
    
//Logic to count total pages for pagination
$selecAllArticles = "SELECT * FROM article";         	  
$allArticles = mysqli_query($conn, $selecAllArticles);			  
$total_records =mysqli_num_rows($allArticles);  //count number of records					  
$total_pages = ceil($total_records / $num_rec_per_page);   

//Logic to fetch trending articles
$selectTrending="SELECT * FROM article ORDER BY views DESC LIMIT 5"; 
$trending=mysqli_query($conn, $selectTrending);
$trendingArray = array();//create empty array    
while($row2=$trending->fetch_array()){//loop to get all results
         $trendingArray[]=$row2;//grab everything and store inside array
}  

$selectRandom="SELECT * FROM article"; 
$random=mysqli_query($conn, $selectRandom);
$randomArray = array();//create empty array    
while($row3=$random->fetch_array()){//loop to get all results
         $randomArray[]=$row3;//grab everything and store inside array
}  

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Blog Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Import CSS written by me -->
    <link rel="stylesheet" type="text/css" href="blogHome.css">
</head>

<body class="container-fluid">

<!-- Page content -->
<div><br/>  

<!-- Main content -->
<div class="row ">  
<div class="col-xl-9">
 
 <!-- Pagination -->
<div class="container-fluid" >
<div class="row ">
<div class="col-sm-4 col-md-4 col-lg-4"></div>
<div class="col-sm-4 col-md-4 col-lg-4"></div>
<div class="col-sm-4 col-md-4 col-lg-4">

<?php  
    //If page 1-3 is selected, show first 5 pages
    if($page<4){
?>
    <ul class="pagination">
    <?php     
    if($page==1){
        ?>
        <li class="page-item disabled"><a class="page-link" href='blogHome.php?page=1'> << </a></li>
    <?php
    }
    else {
        ?>
        <li class="page-item"><a class="page-link" href='blogHome.php?page=1'> << </a></li>
    <?php
    }    
        
    if($total_pages<=5) {
        for ($i=1; $i<=$total_pages; $i++) { 							 
            if($i == $page){	
                ?>
                <li class="page-item active"><a class="page-link"><?php echo "$i" ?></a></li>	
                <?php				   
            } else{
                ?>
                <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$i" ?>'><?php echo "$i" ?></a></li>
            <?php	
            }							
        };
    }
        
    else {
        for ($i=1; $i<=5; $i++) { 							 
            if($i == $page){	
                ?>
                <li class="page-item active"><a class="page-link"><?php echo "$i" ?></a></li>	
                <?php				   
            } else{
                ?>
                <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$i" ?>'><?php echo "$i" ?></a></li>
            <?php	
            }							
        };
    }
                             
    if($page==$total_pages){
    ?>
    <li class="page-item disabled"><a class="page-link" href='blogHome.php?page=<?php echo "$total_pages" ?>'> >> </a></li>	
    <?php
    }
    else {
        ?>
        <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$total_pages" ?>'> >> </a></li>	
     <?php	
        }
    ?>
</ul> 

<?php	
        }
    //If page selected is more than total-3, show last five pages
    elseif($page>$total_pages-3){
?>
<ul class="pagination">
    <?php     
    if($page==1){
        ?>
        <li class="page-item disabled"><a class="page-link" href='blogHome.php?page=1'> << </a></li>
    <?php
    }
    else {
        ?>
        <li class="page-item"><a class="page-link" href='blogHome.php?page=1'> << </a></li>
    <?php
    }
                             
    for ($i=$total_pages-4; $i<=$total_pages; $i++) { 							 
        if($i == $page){	
            ?>
            <li class="page-item active"><a class="page-link"><?php echo "$i" ?></a></li>	
            <?php				   
        } else{
            ?>
            <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$i" ?>'><?php echo "$i" ?></a></li>
        <?php	
        }							
    };
                             
    if($page==$total_pages){
    ?>
    <li class="page-item disabled"><a class="page-link" href='blogHome.php?page=<?php echo "$total_pages" ?>'> >> </a></li>	
    <?php
    }
    else {
        ?>
        <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$total_pages" ?>'> >> </a></li>	
     <?php	
        }
    ?>
</ul> 

<?php	
        }
    //If any middle page is selected, show that page and left two and right two along with it
    else{
?>

<ul class="pagination">
    <?php     
    if($page==1){
        ?>
        <li class="page-item disabled"><a class="page-link" href='blogHome.php?page=1'> << </a></li>
    <?php
    }
    else {
        ?>
        <li class="page-item"><a class="page-link" href='blogHome.php?page=1'> << </a></li>
    <?php
    }
                             
    for ($i=$page-2; $i<=$page+2; $i++) { 							 
        if($i == $page){	
            ?>
            <li class="page-item active"><a class="page-link"><?php echo "$i" ?></a></li>	
            <?php				   
        } else{
            ?>
            <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$i" ?>'><?php echo "$i" ?></a></li>
        <?php	
        }							
    };
                             
    if($page==$total_pages){
    ?>
    <li class="page-item disabled"><a class="page-link" href='blogHome.php?page=<?php echo "$total_pages" ?>'> >> </a></li>	
    <?php
    }
    else {
        ?>
        <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$total_pages" ?>'> >> </a></li>	
     <?php	
        }
    ?>
</ul> 
<?php	
        }
?>
</div></div></div>
<!-- Pagination Ends -->
 
 <!-- Posts -->
<div class="row ">  
   <?php
      if($page==$total_pages && ($total_records % 9)!=0){
          $n=$total_records % 9;
      }else{
          $n=9;
      }
      
      for($i=0; $i<$n; $i=$i+1){
    ?>
    <div class="col-md-6 col-lg-6 col-xl-4 ">
    <div class="posts">
     <div class="image">
     <?php
        if($array[$i]['image']==NULL){
       
     ?>     
      <a href="article.php?url=<?php echo $array[$i]['url']?>"><img src="1.jpg" style="width:100%" class="articleImage"></a>
      <?php
        }
        else{
     ?>  
         <a href="article.php?url=<?php echo $array[$i]['url']?>"><img src="../post-article/title-image/<?php echo $array[$i]['image']?>" style="width:100%" class="articleImage"></a>
     <?php
        }
     ?>  
      </div>
      <div class="container" id="description">
         <?php 
            $length=strlen($array[$i]['title']);
            if($length>60){
        ?>
          <p title="<?php echo $array[$i]['title'];?>"><a href="article.php?url=<?php echo $array[$i]['url']?>"><b><?php echo substr($array[$i]['title'], 0, 60).'...'?></b></a></p>
          <?php 
            }
          else{
        ?>
        <p title="<?php echo $array[$i]['title'];?>"><a href="article.php?url=<?php echo $array[$i]['url']?>"><b><?php echo $array[$i]['title'] ?></b></a></p>
        <?php 
            }
        ?>
        <p class="meta"><a href="article.php?url=<?php echo $array[$i]['url']?>"><?php echo substr($array[$i]['meta'], 0, 140).'...'?></a></p>

      </div>
    </div>
</div>
    <?php
        }  
     ?>     
    </div> 
<!-- Posts Ends -->

<!-- Pagination --><br/><br/>
<div class="container-fluid" >
<div class="row ">
<div class="col-sm-4 col-md-4 col-lg-4"></div>
<div class="col-sm-4 col-md-4 col-lg-4"></div>
<div class="col-sm-4 col-md-4 col-lg-4">

<?php  
    //If page 1-3 is selected, show first 5 pages
    if($page<4){
?>
    <ul class="pagination">
    <?php     
    if($page==1){
        ?>
        <li class="page-item disabled"><a class="page-link" href='blogHome.php?page=1'> << </a></li>
    <?php
    }
    else {
        ?>
        <li class="page-item"><a class="page-link" href='blogHome.php?page=1'> << </a></li>
    <?php
    }    
        
    if($total_pages<=5) {
        for ($i=1; $i<=$total_pages; $i++) { 							 
            if($i == $page){	
                ?>
                <li class="page-item active"><a class="page-link"><?php echo "$i" ?></a></li>	
                <?php				   
            } else{
                ?>
                <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$i" ?>'><?php echo "$i" ?></a></li>
            <?php	
            }							
        };
    }
        
    else {
        for ($i=1; $i<=5; $i++) { 							 
            if($i == $page){	
                ?>
                <li class="page-item active"><a class="page-link"><?php echo "$i" ?></a></li>	
                <?php				   
            } else{
                ?>
                <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$i" ?>'><?php echo "$i" ?></a></li>
            <?php	
            }							
        };
    }
                             
    if($page==$total_pages){
    ?>
    <li class="page-item disabled"><a class="page-link" href='blogHome.php?page=<?php echo "$total_pages" ?>'> >> </a></li>	
    <?php
    }
    else {
        ?>
        <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$total_pages" ?>'> >> </a></li>	
     <?php	
        }
    ?>
</ul> 

<?php	
        }
    //If page selected is more than total-3, show last five pages
    elseif($page>$total_pages-3){
?>
<ul class="pagination">
    <?php     
    if($page==1){
        ?>
        <li class="page-item disabled"><a class="page-link" href='blogHome.php?page=1'> << </a></li>
    <?php
    }
    else {
        ?>
        <li class="page-item"><a class="page-link" href='blogHome.php?page=1'> << </a></li>
    <?php
    }
                             
    for ($i=$total_pages-4; $i<=$total_pages; $i++) { 							 
        if($i == $page){	
            ?>
            <li class="page-item active"><a class="page-link"><?php echo "$i" ?></a></li>	
            <?php				   
        } else{
            ?>
            <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$i" ?>'><?php echo "$i" ?></a></li>
        <?php	
        }							
    };
                             
    if($page==$total_pages){
    ?>
    <li class="page-item disabled"><a class="page-link" href='blogHome.php?page=<?php echo "$total_pages" ?>'> >> </a></li>	
    <?php
    }
    else {
        ?>
        <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$total_pages" ?>'> >> </a></li>	
     <?php	
        }
    ?>
</ul> 

<?php	
        }
    //If any middle page is selected, show that page and left two and right two along with it
    else{
?>

<ul class="pagination">
    <?php     
    if($page==1){
        ?>
        <li class="page-item disabled"><a class="page-link" href='blogHome.php?page=1'> << </a></li>
    <?php
    }
    else {
        ?>
        <li class="page-item"><a class="page-link" href='blogHome.php?page=1'> << </a></li>
    <?php
    }
                             
    for ($i=$page-2; $i<=$page+2; $i++) { 							 
        if($i == $page){	
            ?>
            <li class="page-item active"><a class="page-link"><?php echo "$i" ?></a></li>	
            <?php				   
        } else{
            ?>
            <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$i" ?>'><?php echo "$i" ?></a></li>
        <?php	
        }							
    };
                             
    if($page==$total_pages){
    ?>
    <li class="page-item disabled"><a class="page-link" href='blogHome.php?page=<?php echo "$total_pages" ?>'> >> </a></li>	
    <?php
    }
    else {
        ?>
        <li class="page-item"><a class="page-link" href='blogHome.php?page=<?php echo "$total_pages" ?>'> >> </a></li>	
     <?php	
        }
    ?>
</ul> 
<?php	
        }
?>
</div></div></div>
<!-- Pagination Ends -->
  </div>
<!-- Main content ends-->
  
<!-- Panel at right-->    
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-3">
<!-- Add 3 break lines in the right panel-->      
<div class="col-sm-12 col-md-12 col-lg-12"><br/></div>
<div class="col-sm-12 col-md-12 col-lg-12"><br/></div>   
    
<div class="container sidePanel">
    <div class="row "> 
    
 <!-- Post article button-->    
 <div class="col-sm-12 col-md-12 col-lg-12"><br/></div>   
<div class="col-sm-12 col-md-12 col-lg-12">
  <div class="postArticle">
      <a href="../post-article/postArticle.html" class="btn btn-primary btn-block" role="button"><i class="fa fa-edit"></i> &nbsp; Post an article</a>
  </div>
  </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br/></div>   
     <div class="container trendingPanel">
    <div class="row ">       
            <!-- Trending header-->    
          <div class="col-sm-12 col-md-12 col-lg-12"><br/></div>
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="trending">
                <button type="button" class="btn btn-danger btn-block" disabled><i class="fa fa-fire"></i> &nbsp;Trending</button>
            </div>
        </div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br/></div>    
        
        <!-- Generate 5 random posts with images-->    
        <?php           
        //Shuffle the arrays randomly
        shuffle($trendingArray);
        shuffle($randomArray);
        for ($i=0; $i<5; $i++) {    
            //Post the shuffled trending array on odd positions
            if($i%2!=0){
        ?> 
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class="trendingImage">
                <a href="article.php?url=<?php echo $trendingArray[$i]['url']?>"><img src="../post-article/title-image/<?php echo $trendingArray[$i]['image']?>" style="width:100px; height:100px;" class="image"></a>
            </div>  
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
            <div class="trendingTitle">            
                <?php 
                    if(strlen($trendingArray[$i]['title']) > 75){
                ?>
                <a href="article.php?url=<?php echo $trendingArray[$i]['url']?>" title="<?php echo $trendingArray[$i]['title'] ?>"><?php echo substr($trendingArray[$i]['title'], 0, 75).'...'?></a>
                <?php 
                    }
                else{
                ?>   
                <a href="article.php?url=<?php echo $trendingArray[$i]['url']?>" title="<?php echo $trendingArray[$i]['title'] ?>"><?php echo $trendingArray[$i]['title'] ?></a>
                <?php 
                    }
                ?>  
            </div>
        </div>
        
        <?php
            }
            //Post the shuffled random array on even positions
            else {
        ?>        
        
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class="randomImage">
                <a href="article.php?url=<?php echo $randomArray[$i]['url']?>"><img src="../post-article/title-image/<?php echo $randomArray[$i]['image']?>" style="width:100px; height:100px;" class="image"></a>
            </div>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
            <div class="randomTitle">            
                <?php 
                    if(strlen($randomArray[$i]['title']) > 75){
                ?>
                <a href="article.php?url=<?php echo $randomArray[$i]['url']?>" title="<?php echo $randomArray[$i]['title'] ?>"><?php echo substr($randomArray[$i]['title'], 0, 75).'...'?></a>
                <?php 
                    }
                else{
                ?>   
                <a href="article.php?url=<?php echo $randomArray[$i]['url']?>" title="<?php echo $randomArray[$i]['title'] ?>"><?php echo $randomArray[$i]['title'] ?></a>
                <?php 
                    }
                ?>  
            </div>
        </div>
        <?php 
            }
        ?> 
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr/></div>
        <?php
        }
        ?>   
             </div>
  </div>  
     </div>
    </div>
</div>
<!-- Panel at right ends-->
</div>
<br/>

<!-- End page content -->
</div>

</body>
</html>