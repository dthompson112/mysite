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
					<a href= 'index.php?id=cpp'>c++</a>
					<a href= 'index.php?id=c'>c</a>
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
$q;
$q = 'SELECT file_data FROM projects.files as f, projects.proj As p WHERE p.proj_name = "' . $_GET['id'] . '" AND p.file_name = f.file_name';
//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//check connection
if($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}


if(empty($_GET['id'])){
	///if the id is empty display the home page
	echo "<h1>Welcome to my site</h1>";
	$_SESSION['state'] = 'home';
}else if(mysqli_num_rows($result = $conn->query($q)) > 0){
	genPage($result);
	$_SESSION['state'] = $_GET['id'];
} else if(isset($_SESSION['state'])){
	$q = 'SELECT file_data FROM projects.files as f, projects.proj As p WHERE p.proj_name = "' . $_SESSION['state'] . '" AND p.file_name = f.file_name';
	if($result = $conn->query($q)){
		genPage($result);
	}
	$q = 'SELECT file_data FROM projects.files as f, projects.proj As p WHERE p.proj_name = "' . $_GET['id'] . '" AND p.file_name = f.file_name';
}

mysqli_free_result($result);
mysqli_close($conn);

?>

			</code></pre>
			</div>
		</div>
		
	  <div id="navbar">	
		  <div id="innavbar">
			
			<?php
			
			
			//generate navigaton window based on user selection
			switch ($_GET['id']) {
			case "projects_by_name":
				$q = "SELECT DISTINCT proj_name FROM projects.proj ORDER BY proj_name ASC";
				genNav($servername, $username, $password, $dbname, $q);
				break;
			case "cpp":
				$q = "SELECT DISTINCT proj_name FROM projects.lang as l WHERE l.lang = 'cpp' ORDER BY proj_name ASC";
				genNav($servername, $username, $password, $dbname, $q);
				break;
			case "c":
				$q = "SELECT DISTINCT proj_name FROM projects.lang as l WHERE l.lang = 'c' ORDER BY proj_name ASC";
				genNav($servername, $username, $password, $dbname, $q);
				break;	
			default:
				//$q = "SELECT DISTINCT proj_name FROM projects.proj";
				$q = "SELECT DISTINCT proj_name FROM projects.proj ORDER BY proj_name ASC";
				genNav($servername, $username, $password, $dbname, $q);
			}
			
			
			?>
		</div>
	  </div>
	  
	  
  </body>
</html>


