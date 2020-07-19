<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Giphy Search</title>
  <link rel="stylesheet" href="style1.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<?php

function convert_to_array($str) {
  $arr=array();
  if($str!=''){
  $arr=explode(" ",$str);}
  return $arr;
}

function extract_keyword($arr) {
  $ext=array();
  if(count($arr)!=0)
    {
      $remove_objects=array("in","of","the","to","inside","for");
      $ext=array_diff($arr,$remove_objects);
      if(count($ext)>3){
      $ext=array_slice($arr,0,3);
    }
}
  return $ext;
}

$servername = "localhost";
$username = "root";
$password = "";
// Create connection
$conn = new mysqli($servername, $username, $password,"giphy_db");

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
 if (isset($_POST["searchbutton"])) {
   $search_string=$_POST["search"];
   $converted=convert_to_array($search_string);
   $extracted=extract_keyword($converted);
   $url=array();
   $extractednew=array();
   foreach( $extracted as $element ) {
    array_push($extractednew,$element);
  }
  //echo count($extractednew);
  switch(count($extractednew)){
    case 1:
        $sql1="SELECT gif_url FROM gif_main WHERE (key_1='$extractednew[0]') OR (key_2='$extractednew[0]')";
        $result1 = $conn->query($sql1);
        while($row1 = $result1->fetch_assoc()){
          array_push($url,$row1['gif_url']);
        }
        break;
    case 2:
        $sql1="SELECT gif_url FROM gif_main WHERE (key_1='$extractednew[0]') OR (key_2='$extractednew[0]')";
        $sql2="SELECT gif_url FROM gif_main WHERE (key_1='$extractednew[1]') OR (key_2='$extractednew[1]')";
        $result1 = $conn->query($sql1);
        $result2 = $conn->query($sql2);
        while($row1 = $result1->fetch_assoc()){
          array_push($url,$row1['gif_url']);
        }
        while($row2 = $result2->fetch_assoc()){
          array_push($url,$row2['gif_url']);
        }
        break;
    case 3:
        $sql1="SELECT gif_url FROM gif_main WHERE (key_1='$extractednew[0]') OR (key_2='$extractednew[0]')";
        $sql2="SELECT gif_url FROM gif_main WHERE (key_1='$extractednew[1]') OR (key_2='$extractednew[1]')";
        $sql3="SELECT gif_url FROM gif_main WHERE (key_1='$extractednew[2]') OR (key_2='$extractednew[2]')";
        $result1 = $conn->query($sql1);
        $result2 = $conn->query($sql2);
        $result3 = $conn->query($sql3);
        while($row1 = $result1->fetch_assoc()){
          array_push($url,$row1['gif_url']);
        }
        while($row2 = $result2->fetch_assoc()){
          array_push($url,$row2['gif_url']);
        }
        while($row3 = $result3->fetch_assoc()){
          array_push($url,$row3['gif_url']);
        }
        break;
    default:
        echo '<script type="text/javascript">';
        echo 'alert("Invalid input")';
        echo '</script>';


  }


 }


// https://38.media.tumblr.com/ce664a48a29baf63079c994557674240/tumblr_nhzvfzmSc11rtdnfto1_400.gif"

?>
<body>
<div class="topnav">

<a class="active" href="http://localhost/">Home</a>
<div class="search-container">
  <form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
    <input type="text" placeholder="Search.." name="search">
    <button name="searchbutton" type="submit"><i class="fa fa-search"></i></button>
  </form>
</div>
</div>
  <div class="main">
		<h1>GIFactory</h1>
		<p>Your Search Results :-</p>
    <div class="gallery">
    <?php
      $cls1="img";
      $cls2="overlay";
      $hrf="#";
      $cls3="icon";
      $tt="download";
      $ic="fa fa-download";
      foreach ($url as $i){
        echo "<div class='$cls1'>
          <img src=".$i." >
          <div class='$cls2'>
          <a href='$i' class='$cls3' title='$tt'>
            <i class='$ic'></i>
            </a>
            </div></div>";

      }
    ?>
    </div>

	</div>
</body>
</html>
