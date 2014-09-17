<!DOCTYPE html>
<html lang="en">
<head>
<style>
	table{   
	margin: 15px;
	}  
	tr, td{
	padding: 4px;

	}
</style>

	<meta charset="UTF-8">
	<title>Song app</title>
</head>
<body>

		<?php 

			$db = new PDO('mysql:host=localhost;dbname=php-mvc', 'root', '');
		    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		if(isset($_GET['actie'])){
			$actie = $_GET['actie'];}
		else { 
			$actie = null;
		}

		if(isset($_GET['id'])){
			$id = $_GET['id'];}
		else
		{
			$id = null;
		}

$artist = ""; 
$track = "";
$link = "";


		switch ($actie) {
			case 'verwijderen':
				if ($_GET['id'])
				{
				$sql = 'delete from song where id = '.$id.'';
				$result = $db->query($sql);
				header( "refresh:0;url=songapp.php");
				}
				break;

			case 'wijzigen':
				if (!isset($_POST['submit']) && $_GET['id'])
				{
					$sql = 'select * from song where id = '.$id.'';
					$result = $db->query($sql);
					foreach ($result as $row) {
				?>	
				<form method='post' action='songapp.php?actie=wijzigen&id=<?php echo $id ?>'>
				Artist: <input type="text" name="artist" value="<?php echo $row['artist'];?>"><br>
				Track: <input type="text" name="track" value="<?php echo $row['track'];?>"><br>
				Link: <input type="text" name="link" value="<?php echo $row['link'];?>"><br>
				<input type="submit" name="submit" value="Submit"> 
				</form>
				<?php
				}  
				}
				elseif ($_POST['submit'])
				{
				
				$sql = "UPDATE song SET artist = '".$_POST['artist']."', track = '".$_POST['track']."', link = '".$_POST['link']."' WHERE id = $id"; 
				$affected_rows = $db->exec($sql); 

				header( "refresh:0;url=songapp.php");
				}
				break;
			
			case 'toevoegen':
				if (!isset($_POST['submit']))
				{
				?>	
				<form method='post' action='songapp.php?actie=toevoegen'>
				Artist: <input type="text" name="artist"><br>
				Track: <input type="text" name="track"><br>
				Link: <input type="text" name="link"><br>
				<input type="submit" name="submit" value="Submit"> 
				</form>
				<?php
				}  
				elseif ($_POST['submit'])
				{
				
				$sql = "insert into song (artist, track, link)
						values ('".$_POST['artist']."','".$_POST['track']."','".$_POST['link']."')"; 
				$affected_rows = $db->exec($sql); 

				header( "refresh:0;url=songapp.php");
				}
				break;


		default:
		?>
	<table border="1">
	<tr>
		<th>ID</th>
		<th>Artist</th>
		<th>Track</th>
		<th>Link</th>
		<th colspan="2">Actie</th>
	</tr>
		<?php
			$sql = "select * from song";
			$result = $db->query($sql);

			foreach ($result as $row) 
			{
				echo '<tr>
						<td>'.$row['id'].'</td>
						<td>'.$row['artist'].'</td>
						<td>'.$row['track'].'</td>
						<td><a href="'.$row['link']. '">'. $row['link'].'</a></td>
						<td><a href="songapp.php?actie=wijzigen&id='  . $row['id'] . '">Wijzigen</a></td>
						<td><a href="songapp.php?actie=verwijderen&id='  . $row['id'] . '">Verwijderen</a></td>
					</tr>';
			}

			$db = null; 
			?>
			</table>
			<a href="songapp.php?actie=toevoegen">Nieuw nummer toevoegen</a>;
		<?php
				break;

			}
		?>
</body>		
</html>