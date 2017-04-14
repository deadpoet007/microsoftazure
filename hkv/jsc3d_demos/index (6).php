<!DOCTYPE html>
<html>
<head>
<div align="center">
<img src="top.png">	
</br></br></br>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NoFOLLOW" />
<title>Multiple File Upload</title>
<script type="text/javascript" src="js/jquery_1.5.2.js"></script>
<script type="text/javascript" src="js/uploader.js"></script>


<link type="text/css" href="css/uploader.css" rel="stylesheet" />


<script type="text/javascript">
$(document).ready(function()
{
	new multiple_file_uploader
	({
		form_id: "fileUpload", 
		autoSubmit: true,
		server_url: "uploader.php" // PHP file for uploading the browsed files
	});
});
</script>
</div>
</head>

<body>
<div align="center">
			<div class="upload_box">
				<form name="fileUpload" id="fileUpload" action="javascript:void(0);" method="post" enctype="multipart/form-data">
				<div class="file_browser"><input type="file" name="multiple_files[]" id="_multiple_files" class="hide_broswe" multiple /></div>
				<div class="file_upload"><input type="submit" value="Upload" class="upload_button" /> </div>
				</form>

			</div>	
			<?php
			  //echo $form_action;
			session_start();
			$user_name = "shap2353541893";
			$password = "Ed@t=Ge-6B+K";
			$database = "shap2353541893";
			$server = "shap2353541893.db.2353541.hostedresource.com:3313";  
			$db_handle = mysql_connect($server, $user_name, $password);
			$db_found = mysql_select_db($database, $db_handle);
			$_SESSION['file_name']=$filen;
			  echo '<form action="db_insert.php" method="POST">';
			echo '<table>';
			echo "<tr><td>";
			echo '<input type="text" name="name" placeholder="customer name"><br>';
			echo "</td></tr><tr><td>";
			echo '<textarea name="address" rows="3" cols="30" placeholder="customer address"></textarea><br>';
			echo "</td></tr><tr><td>";
			echo '<input type="email" name="email" placeholder="Email ID">';
			echo "</td></tr>";
			echo "</table>";
			      $sql = "SELECT user_login,printer_location,price FROM wp_4cnt67vspy_users where user_type like 'a'";
			    //Run the query
			    $query_resource = mysql_query($sql);
				echo '<table>';
				echo "<tr>";
				
				while($field=mysql_fetch_field($query_resource)) {
						echo "<th>";
						echo ucfirst($field->name);
						echo "</th>";	
						}
			    while( $row = mysql_fetch_assoc($query_resource) ){
					$loc=$row['printer_location'];
					$name=$row['user_login'];
			      $price=$row['price'];
					echo "<tr>";
			   echo "<td>$name</a></td>";
			  echo "<td>$loc </td>";
			  echo "<td>$price </td>";
			 // echo "<a href=/checkout?location[]=$name>$name</a>";
			 echo '<td><input type="radio" name="location[]"  value="'. $name.'"></td>';
			  echo "</tr>";
			}
			echo "</table>";
			echo '<input type="submit" name="submit" value="order">';
			?>
</form>

	<div class="file_boxes">

	</div>
<span id="removed_files"></span>
</br></br></br>
<img src="end.png">	
</div>
