<html>
<body>


<?php
session_start();

include_once "function.php";

$username = $_SESSION['username'];

?>

<h1> <?php echo $username; ?> MeTube Playlist  </h1>


<form action="browse.php" method="post"> 
	<input name="home" type="submit" value="Home">
</form>

<form action="playlist.php" method="post">
    <input name="playname" type="text" placeholder="Enter new playlist name" required>
	<input name="playsubmit" type="submit" class="button"  VALUE = "Create" >
</form></p> <br>



<?php
  if(isset($register_error))
   {  echo "<div id='passwd_result'> register_error:".$register_error."</div>";
}

if(isset($_POST['playsubmit'])) {
	
	$check = playlist_exist_check($username, $_POST['playname']);		
		if($check == 1){
			//echo "Rigister succeeds";
			//header('Location: playlist.php');
			echo "Playlist successfully created!";
		}
		else if($check == 2){
			echo "Playlist already exists! Please chose a different name";
			$register_error = "Playlist already exists. Please user a different Playlist name.";
		}

}
?>

<?php
$query = "SELECT * FROM playlist WHERE username='$username'"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>	

  <table width="50%" cellpadding="0" cellspacing="0">
	
		<?php
			while ($result_row = mysql_fetch_row($result)) //filename, username, type, mediaid, path
			{ 
				$playlist_id = $result_row[0];
				$playname = $result_row[1];
		?>
        	 <tr valign="top">			
			<td>
					<?php 
						echo $playname; 
					?>
			</td>
			<?php
			$query1 = "SELECT * FROM playlist_media WHERE username='$username' and playlist_name='$playname'"; 
			$result1 = mysql_query( $query1 );
	
                     while ($result_row = mysql_fetch_row($result1)) //filename, username, type, mediaid, path 
					 {
						 $play_media_id = $result_row[0];
						 $play_media_title = $result_row[4];
						 $play_media_path = $result_row[6];
						 $media_id = $result_row[7];
						 ?>
						 <tr valign="top">
						 
							<td>
								
									
									 <a href="media.php?id=<?php echo $media_id;?>" ><?php echo $play_media_title;?></a>
								
							</td>
							</tr>
							<?php
					 }
					 ?>
		</tr>
        	<?php
			}

		?>
	</table>

	
</body>
</html>