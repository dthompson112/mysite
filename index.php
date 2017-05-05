<?php
session_start();
?>


<!DOCTYPE html>
<html>

  <head>
    <link rel="stylesheet" type"text/css" href="style.css">
    <h1 class="title">Dan Thompson's Projects and Code</h1>
  </head>
  
  <!--top bar-->
	  <ul>
		  <li class = topnav><a href="index.php" class = topnav>Home</a></li>
		  <li class = topnav><a href="index.php?id=projects_by_name" class = topnav>Projects By Name</a></li>
		  <li class = topnav>
				<a href= '?id=projects_by_language' class= dropbtn>Projects by Language</a>
				<div class='dropbtn-content'>
					<a href= 'index.php?id=cpp'>C++</a>
					<a href= 'index.php?id=c'>C</a>
					<a href= 'index.php?id=full_stack'>Web</a>
				</div>
		  </li>
	  </ul>
	  
  <body>
	  
	  <div id="container">
		<div id="content">
			<div id="incontent">
			<pre><code>

<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
include 'func.php';

$servername = "localhost";
$username = "site_level"; //restricted user 
$password = "mypass";
$dbname = "projects";

//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$id;
$lang;
$d;

//file prepared statement
$stmtf = $conn->prepare("SELECT file_data FROM projects.files as f WHERE f.proj_name = ?");
$stmtf->bind_param("s",$id);
$id = $_GET['id'];

//description prepared statement
$stmtd = $conn->prepare("SELECT description FROM projects.proj as p WHERE p.proj_name = ?");
$stmtd->bind_param("s",$d);
$d = $_GET['id'];

//check connection
if($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}


if(empty($_GET['id'])){
	///if the id is empty display the home page
	echo "<h1>Welcome to my site!</h1>";
	echo "<p>Welcome, I created this site to display the projects I have completed over the past few years.  Because I have completed a lot of projects on different operating systems, servers, and multiple hard drives, I have decided to bring the site live with only five initial projects and then add projects, screen shots, and features as time allows.</p>";
	echo "<p>Of course, this website is really its own project.  Rather than using Word Press or a similar content management system I built the back end of the site using the lamp stack (Linux, Apache2, MySQL, PHP) and the front end of the site with HTML5 and CSS.  I built the database, wrote the SQL queries, used PHP to generate the page content, created all the CSS rules, and wrote all of the HTML tags.</p>";
	echo "<p>I built the site from scratch because the coding is the fun part.  I hope you enjoy it.</p>";
	$_SESSION['state'] = 'home';
}else if($stmtd->execute()){
	
	genDescriptions($stmtd);
	
	if($stmtf->execute()){
		genPages($stmtf);
	}
	
	$_SESSION['state'] = $_GET['id'];
} else if(isset($_SESSION['state'])){

	$id = $_SESSION['state'];
	$d = $_SESSION['state'];
	

	if($stmtd->execute())
	{
		genDescriptions($stmtd);
	}


	if($stmtf->execute()){
		genPages($stmtf);
	}
	
	$id = $_SESSION['state'];
	$d = $_SESSION['state'];
}


$stmtf->close();
$stmtd->close();
$conn->close();

?>

			</code></pre>
			</div>
		</div>
		
	  <div id="navbar">	
		  <div id="innavbar">
			
			
			
			<?php
			
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			//language query
			$stmtl = $conn->prepare("SELECT DISTINCT proj_name FROM projects.files as f WHERE f.lang = ? ORDER BY proj_name ASC");
			$stmtl->bind_param("s",$lang);
			
			
			//generate navigaton window based on user selection
			switch ($_GET['id']) {
			case "projects_by_name":
				$q = "SELECT DISTINCT proj_name FROM projects.files ORDER BY proj_name ASC";
				genNav($servername, $username, $password, $dbname, $q);
				break;
			case "cpp":
				$lang = "cpp";
				$stmtl->execute();
				genNavItems($stmtl);
				break;
			case "c":
				$lang = "c";
				$stmtl->execute();
				genNavItems($stmtl);
				break;
			case "full_stack":
				$lang = "full_stack";
				$stmtl->execute();
				genNavItems($stmtl);
				break;	
			default:
				$q = "SELECT DISTINCT proj_name FROM projects.files ORDER BY proj_name ASC";
				genNav($servername, $username, $password, $dbname, $q);
			}
			
			
			$stmtl->close();
			$conn->close();
			
			?>
		</div>
	  </div>
	  
	  
  </body>
</html>


