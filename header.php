<?php
  //echo "<h1>" .  . "</h1>";
  include "config.php";
  $page = basename($_SERVER['PHP_SELF']);
  switch($page){
    case "single.php":
      if(isset($_GET['id'])){
        $sql_title = "SELECT * FROM post WHERE post_id = {$_GET['id']}";
        $result_title = mysqli_query($conn,$sql_title) or die("Tile Query Failed");
        $row_title = mysqli_fetch_assoc($result_title);
        $page_title = $row_title['title'];
      }else{
        $page_title = "No Post Found";
      }
      break;
    case "category.php":
      if(isset($_GET['cid'])){
        $sql_title = "SELECT * FROM category WHERE category_id = {$_GET['cid']}";
        $result_title = mysqli_query($conn,$sql_title) or die("Tile Query Failed");
        $row_title = mysqli_fetch_assoc($result_title);
        $page_title = $row_title['category_name'] . " News";
      }else{
        $page_title = "No Post Found";
      }
      break;
    case "author.php":
      if(isset($_GET['aid'])){
        $sql_title = "SELECT * FROM user WHERE user_id = {$_GET['aid']}";
        $result_title = mysqli_query($conn,$sql_title) or die("Tile Query Failed");
        $row_title = mysqli_fetch_assoc($result_title);
        $page_title = "News By " .$row_title['first_name'] . " " . $row_title['last_name'];
      }else{
        $page_title = "No Post Found";
      }
      break;
    case "search.php":
      if(isset($_GET['search'])){

        $page_title = $_GET['search'];
      }else{
        $page_title = "No Search Result Found";
      }
      break;
    default :
      $sql_title = "SELECT websitename FROM settings";
      $result_title = mysqli_query($conn,$sql_title) or die("Tile Query Failed");
      $row_title = mysqli_fetch_assoc($result_title);
      $page_title = $row_title['websitename'];
      break;
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
#menu-bar {
    background-color: #333;
    padding: 10px 0;
    position: relative; 
}

.menu {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-wrap: wrap;
    /* justify-content: center; */
}

.menu li {
    margin: 0 15px;
}

.menu a {
    text-decoration: none;
    color: #333;
    padding: 8px 16px;
    transition: background-color 0.3s, color 0.3s;
}

.menu a:hover {
    background-color: #007bff;
    color: white;
}

.menu a.active {
    background-color: #007bff;
    color: white;
}

/* Mobile styles */
@media (max-width: 768px) {
    .menu {
        flex-direction: column;
        align-items: center;
    }

    .menu li {
        margin: 5px 0;
    }
}

/* Hamburger Menu */
.hamburger {
    display: none;
    flex-direction: column;
    cursor: pointer;
    margin: 0 auto;
}

.hamburger div {
    width: 25px;
    height: 3px;
    background-color: white;
    margin: 4px 0;
}

@media (max-width: 768px) {
    .menu {
        display: none;
        flex-direction: column;
        width: 100%;
        text-align: center;
    }

    .menu.active {
        display: flex;
    }

    .hamburger {
        display: flex;
    }
}
    </style>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class=" col-md-offset-4 col-md-4">
              <?php
                include "config.php";

                $sql = "SELECT * FROM settings";

                $result = mysqli_query($conn, $sql) or die("Query Failed.");
                if(mysqli_num_rows($result) > 0){
                  while($row = mysqli_fetch_assoc($result)) {
                    if($row['logo'] == ""){
                      echo '<a href="index.php"><h1>'.$row['websitename'].'</h1></a>';
                    }else{
                      echo '<a href="index.php" id="logo"><img src="admin/images/'. $row['logo'] .'"></a>';
                    }

                  }
                }
                ?>
            </div>
            <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->

<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="hamburger">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <?php
                include "config.php";

                if (isset($_GET['cid'])) {
                    $cat_id = $_GET['cid'];
                }

                $sql = "SELECT * FROM category WHERE post > 0";
                $result = mysqli_query($conn, $sql) or die("Query Failed. : Category");
                if (mysqli_num_rows($result) > 0) {
                    $active = "";
                ?>
                <ul class="menu">
                    <li><a href="<?php echo $hostname; ?>">Home</a></li>
                    <?php while ($row = mysqli_fetch_assoc($result)) {
                        $active = (isset($_GET['cid']) && $row['category_id'] == $cat_id) ? "active" : "";
                        echo "<li><a class='{$active}' href='category.php?cid={$row['category_id']}'>{$row['category_name']}</a></li>";
                    } ?>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const hamburger = document.querySelector(".hamburger");
    const menu = document.querySelector(".menu");

    hamburger.addEventListener("click", function() {
        menu.classList.toggle("active");
    });
});
</script>
