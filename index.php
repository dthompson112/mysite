

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
				<a href= '#?id=projects_by_language' class='dropbtn'>Projects by Language</a>
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
ini_set('display_errors', 'On');
error_reporting(E_ALL);
//include 'func.php';


//site_level does not have access to the new table permissions must be changed.
$servername = "localhost";
$username = "site_level"; //restricted user 
$password = "mypass";
$dbname = "projects";
$q;
//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);



//check connection
if($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}


if(empty($_GET['id'])){
	///if the id is empty display the home page
	echo "<h1>Welcome to my site</h1>";
	
	//}
} else if ($_GET['id'] == 'c' || $_GET['id'] == 'cpp'){
			$q = 'SELECT proj_name FROM projects.lang as l WHERE l.lang = ."' . $_GET['id'] . '"';

//change it to if a query using $_GET['id'] on project name does not return null.
} else {
	///////////////display selected code or project
	$q = 'SELECT file_data FROM projects.files as f, projects.proj As p WHERE p.proj_name = "' . $_GET['id'] . '" AND p.file_name = f.file_name';
	if($result = $conn->query($q)){
		$row = $result->fetch_array();	
		echo $row['file_data'];
	}
	mysqli_free_result($result);
	mysqli_close($conn);
}

/*$row = $result->fetch_array();	
		echo $row[file_data];
		mysqli_free_result($result);
$conn->close;
*/

?>

			</code></pre>
			</div>
		</div>
	
	
	
	
	  <div id="navbar"></div>
		<div id="innavbar">
			
			<?php
			
			function genPage($servername, $username, $password, $dbname, $q){
				$conn = new mysqli($servername, $username, $password, $dbname);
				
				if($conn->connect_error){
					die("Connection failed: " . $conn->connect_error);
				}
				
				if($result = $conn->query($q)){
					While($row = $result->fetch_array()){
						//get rid of underscores and capitalize the first letter of each word.
						$nav_item = ucwords(str_replace('_', ' ', $row['proj_name']));
						echo '<li><a href = "index.php?id=' . $row['proj_name'] . '"> ' . $nav_item . '</a></li>';
						//echo "<li><a href = 'index.php? id=\"$row[proj_name]\"'>$nav_item</a></li>"
						//echo "<li>$row[proj_name]</li>";
					}
					mysqli_free_result($result);
				}
				mysqli_close($conn);
			}
				
			if(is_null($_GET['id'])){
				$q = "SELECT proj_name FROM projects.proj";
				genPage($servername, $username, $password, $dbname, $q);
			}	
			else if ($_GET['id'] == 'projects_by_name'){
				$q = "SELECT proj_name FROM projects.proj";
				genPage($servername, $username, $password, $dbname, $q);
			} else if ($_GET['id'] == 'cpp'){
				$q = "SELECT proj_name FROM projects.lang as l WHERE l.lang = 'cpp'";
				genPage($servername, $username, $password, $dbname, $q);	
			}
			
			?>
		</div>
	  </div>
	  
	  
  </body>
</html>


