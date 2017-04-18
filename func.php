<?php


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
			
//Generates the page based on sql query	
function genPage($result){
	while($row = $result->fetch_array()){	
		echo $row['file_data'];
		echo "<br></br>";
	}
}

?>
