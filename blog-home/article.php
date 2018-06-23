<?php
$conn=mysqli_connect("localhost", "root", "", "blog");

if(mysqli_connect_error()){
    die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
}
        
$url=$_GET["url"];
$sql="SELECT * FROM article where url='$url'";
$result=mysqli_query($conn, $sql);

$array = array();
while($row=$result->fetch_array()){
         $array[]=$row;
}

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
    <title>Article</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Import CSS written by me -->
    <link rel="stylesheet" type="text/css" href="article.css">
</head>

<!-- Increment views on page load -->
<body onload="checkViews();">
<div class="container-fluid"> 
<div class="row">  

<!-- Left Panel -->
<div class="col-lg-1 col-xl-2">
    <div class="container">            
   
       <div class="sharePanel">
       
       <!-- 10 Break Lines -->
         <?php
           for($i=0; $i<10; $i++){
        ?>
          <div class="col-lg-12 col-xl-12"><br/></div>      
           <?php
           }
        ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a title="Twitter" href="http://twitter.com/share?url=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>&text=<?php echo $array[0]['title'] ?>via=<USERNAME>"><i class="fa fa-twitter "></i></a><br/><br/>
            
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a title="Google+" href="https://plus.google.com/share?url=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>"><i class="fa fa-google-plus "></i></a><br/><br/>
            
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a title="Facebook" href="http://www.facebook.com/sharer/sharer.php?u=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>"><i class="fa fa-facebook "></i></a><br/><br/>
            
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a title="Reddit" href="http://reddit.com/submit?url=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>&title=<?php echo $array[0]['title'] ?>"><i class="fa fa-reddit-alien"></i></a><br/><br/>
            
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a title="Linkedin" href="http://www.linkedin.com/shareArticle?url=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>&title=<?php echo $array[0]['title'] ?>&summary=<SUMMARY>&source=<SOURCE_URL>"><i class="fa fa-linkedin"></i></a><br/><br/>
            
       </div>    
    </div>
</div>
<!-- Left Panel ends-->

<!-- Middle Panel -->
<div class="col-lg-5 col-xl-5">
      <hr/>
      
      <!-- Title, views and author name -->
       <div class="title">
           <h1><?php echo $array[0]['title']; ?></h1>
           <hr style="margin-bottom:10px;"/>
           <div class="container-fluid">
             <div class="row ">
              <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                  <div class="author">- Rajan &nbsp;</div>
              </div>
              <div class="col-sm-4 col-md-4 col-lg-4">
                     <?php $originalDate = $array[0]['datetime'];
                     $newDate = date("jS-F-Y H:i", strtotime($originalDate));?>
                  <div class="date"><?php echo $newDate?></div>
              </div>
              <div class="col-sm-4 col-md-4 col-lg-4">
                   <div class="views">
                   <a title="Twitter" href="http://twitter.com/share?url=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>&text=<?php echo $array[0]['title'] ?>via=<USERNAME>"><i class="fa fa-twitter"></i></a>
            
                    <a title="Google+" href="https://plus.google.com/share?url=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>"><i class="fa fa-google-plus"></i></a>
            
                    <a title="Facebook" href="http://www.facebook.com/sharer/sharer.php?u=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>"><i class="fa fa-facebook"></i></a>
            
                    <a title="Reddit" href="http://reddit.com/submit?url=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>&title=<?php echo $array[0]['title'] ?>"><i class="fa fa-reddit-alien"></i></a>
            
                    <a title="Linkedin" href="http://www.linkedin.com/shareArticle?url=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>&title=<?php echo $array[0]['title'] ?>&summary=<SUMMARY>&source=<SOURCE_URL>"><i class="fa fa-linkedin"></i></a>
                   
                   &nbsp; <i class="fa fa-eye"></i> <?php echo $array[0]['views'];?></div>
              </div> 
              </div>              
           </div>  
       </div><hr/>
       
       <!-- Body -->
       <div class="body">
          <img src="../post-article/title-image/<?php echo $array[0]['image']?>" style="width:100%" class="articleImage"/> 
           <p><?php echo $array[0]['body'];?></p>               
       </div><hr/>
       <div>
       <p class="share">Share: &nbsp;           
            <a title="Twitter" href="http://twitter.com/share?url=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>&text=<?php echo $array[0]['title'] ?>via=<USERNAME>"><i class="fa fa-twitter"></i></a>
            
            <a title="Google+" href="https://plus.google.com/share?url=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>"><i class="fa fa-google-plus"></i></a>
            
            <a title="Facebook" href="http://www.facebook.com/sharer/sharer.php?u=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>"><i class="fa fa-facebook"></i></a>
            
            <a title="Reddit" href="http://reddit.com/submit?url=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>&title=<?php echo $array[0]['title'] ?>"><i class="fa fa-reddit-alien"></i></a>
            
            <a title="Linkedin" href="http://www.linkedin.com/shareArticle?url=http://192.168.1.29/blog/blog-home/article.php?url=<?php echo $array[0]['url']?>&title=<?php echo $array[0]['title'] ?>&summary=<SUMMARY>&source=<SOURCE_URL>"><i class="fa fa-linkedin"></i></a>
       </p>
       </div>
    
    <div id="disqus_thread"></div>
<script>

/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

var disqus_config = function () {
this.page.url = 'https://blognow.000webhostapp.com/blog-home/article.php?url=<?php echo $url ?>';  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = '{{content_id}}'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};

(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://blog-ylnduzqz1q.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>       

</div>
<!-- Middle Panel ends-->


<!-- Gap of 1 column -->
<div class="col-lg-1 col-xl-1"></div>

<!-- Right Panel -->
<div class="col-10 col-sm-6 col-md-6 col-lg-4 col-xl-3">
  <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"><br/></div>  
   
   <!-- Author -->
    <div class="rightPanel">
        <div class="authorPanel">
           <img src="../post-article/title-image/kk.png" class="authorBanner"> 
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"></div> 
              <div class="row">
                  <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div> 
                  <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                      <img src="../post-article/title-image/2.jpg" class="rounded-circle authorImage" style="height:90%; width:100%"> 
                  </div> 
                  <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3"></div> 
                  <div class="col-6 col-sm-6 col-md-6 col-lg-12 col-xl-12"></div> 
              </div>
             
            <hr style="margin-top:-10px"/>
            <p class="name">Rajan Pandey</p>
            <p class="organization">Symbiosis International University</p><hr/>
        </div>
        </div>
        
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"><br/></div>  
        
        <!-- Trending -->
        <div class="trendingPanel">
            <button type="button" class="btn btn-danger btn-block" disabled><i class="fa fa-fire"></i> &nbsp;Trending</button>
            <div class="col-6 col-sm-6 col-md-6 col-lg-12 col-xl-12"><br/></div>   
            
        <?php           
        //Shuffle the arrays randomly
        shuffle($trendingArray);
        shuffle($randomArray);
        for ($i=0; $i<5; $i++) {    
            //Post the shuffled trending array on odd positions
            if($i%2!=0){
        ?> 
        <div class="row">
        <div class="col-4 col-sm-4 col-md-4 col-lg-4">
            <div class="trendingImage">
                <a href="article.php?url=<?php echo $trendingArray[$i]['url']?>"><img src="../post-article/title-image/<?php echo $trendingArray[$i]['image']?>" style="width:100px; height:100px;"></a>
            </div>  
        </div>
        <div class="col-8 col-sm-8 col-md-8 col-lg-8">
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
        </div>
        
        <?php
            }
            //Post the shuffled random array on even positions
            else {
        ?>        
        <div class="row">
        <div class="col-4 col-sm-4 col-md-4 col-lg-4">
            <div class="randomImage">
                <a href="article.php?url=<?php echo $randomArray[$i]['url']?>"><img src="../post-article/title-image/<?php echo $randomArray[$i]['image']?>" style="width:100px; height:100px;"></a>
            </div>
        </div>
        <div class="col-8 col-sm-8 col-md-8 col-lg-8">
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
        </div>
        <?php 
            }
        ?> 
            <div class="col-sm-12 col-md-12 col-lg-12"><hr/></div>
        <?php
        }
        ?>  
        
        </div><br/>
    
  </div>
</div>
<!-- Right Panel ends -->
<div class="col-xl-1"></div>
</div>

<script>
    //AJAX function to increment he number of views on the post
    function incrementViews(url){
		var xhttp=new XMLHttpRequest();
        xhttp.open("POST", "ajaxRequest.php", true);   
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("IncrementBlogViews=true&url="+url+"");
        
        xhttp.onreadystatechange=function(){
            if (xhttp.readyState==4 && xhttp.status==200){	 
                //reload(true);	
                //exit();
            }                                    	
        }        
    }
    
    //Logic for incrementing the views only if a person views article after 1hour on the same browser
    function checkViews(){
        var url='<?php echo $url ?>';
        var time=Date.now();        
    
        //If localStorage doesnt has the url, increment views and set url:time
        if (localStorage.getItem(url)===null || localStorage.getItem(url)===undefined || localStorage.getItem(url).length===0) {
            incrementViews(url);
            localStorage.setItem(url, time);
        }
    
        //If localStorage has the url && its time is less than 1hr, increment views and updae url:time
        else {
            var lastTime=localStorage.getItem(url);
            var timegap=(time-lastTime)/1000;
            
            if(timegap>3600){
                incrementViews(url);
                localStorage.setItem(url, time);
            }
        
            else{    
                exit();
            }
        }
    }
    
</script>
</body>
</html>
