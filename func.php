<?php


//Generates the side navigation bases on sql query.
function genNav($servername, $username, $password, $dbname, $q){
		$conn = new mysqli($servername, $username, $password, $dbname);
				
				
				
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
							
	if($result = $conn->query($q)){
		While($row = $result->fetch_array()){
			$nav_item = ucwords(str_replace('_', ' ', $row['proj_name']));
			echo '<li><a href = "index.php?id=' . $row['proj_name'] . '"> ' . $nav_item . '</a></li>';
		}
		mysqli_free_result($result);
	}
		
	mysqli_close($conn);
}


//Generates description and media based on sql query
function genDescription($result){
	echo "<h3>For full descriptions, screen shots or video, and code select and individual project from the left navigation bar</h3>";
	while($row = $result->fetch_array()){
		//$title = ucwords(str_replace('_', ' ', $row['proj_name']));
		//echo "<h3>" . $title . "</h3>";
		echo $row['description'];
		echo "<br></br>";
	}
	echo "<br></br>";
}

//Generates the page based on sql query
function genPage($result){
	while($row = $result->fetch_array()){
		//htmlentities makes html code viewable
		echo htmlentities($row['file_data']);
		echo "<br></br>";
	}
}

//Generates the side navigation using a prepaired statement
function genNavItems($stmt){
	$r;
	$stmt->bind_result($r);
		while($stmt->fetch()){
			$nav_item = ucwords(str_replace('_', ' ', $r));
			echo '<li><a href = "index.php?id=' . $r . '"> ' . $nav_item . '</a></li>';
		}
}

//Generates the page based using a prepaired statement
function genPages($stmt){
	$r;
	$stmt->bind_result($r);
	while($stmt->fetch()){
		echo htmlentities($r);
	}
}

//Generates the description using a prepaired statement.
function genDescriptions($stmt){
	$r;
	$stmt->bind_result($r);
	while($stmt->fetch()){
		echo $r;
		echo "<br></br>";
		echo "<br></br>";
	}
	
}

?>
