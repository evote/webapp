<?php
	include('functions.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Evote - Voting page</title>
	<link rel="stylesheet" type="text/css" media="screen" href="style.css" />
	<script type="text/javascript"src="jquery.js"></script>
</head>
<body>
	<?php 
	
		$url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; 
		$voteId = explode('-',explode('c=',$url)[1])[0];
		$cardId = explode('-',explode('c=',$url)[1])[1];
		
		$card = new Cards($voteId,$cardId);
	//	print_r($card->cardList);
	//	print_r($card->optionList);
	?>
		
	<content id="main">
			<header>Evote - Voting List</header>
			<content id="content_full">
				<h1>TA STRONA ISTNIEJE TYLKO NA POTRZEBY ZOBRAZOWANIA DZIAŁANIA GLOSOWANIA!!!<br />NIE JEST CZESCIA APLIKACJI</h1>
				
			<table>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Vote link</th>
				</tr>
			<?php 	
			//$mysqli = new mysqli('snosal.linuxpl.info','snosal_evote','evote','snosal_evote');
			$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
			if(!$_GET['id']){
				//wypisanie glosowan
				$query = "SELECT v . * FROM votes v INNER JOIN result r ON v.id = r.id_vote WHERE r.product_first='0' ";
					//echo $query;		
				if ($result = $mysqli->query($query))
				{
					//echo $query;
					while($obj = $result->fetch_object())
					{
				?>
					<tr><td><? echo $obj->id;?></td><td><? echo $obj->name;?></td><td><a href="list.php?id=<? echo $obj->id;?>">glosowanie</a></td></tr>
				
				<?php }
				$result->close();
				
				}
			}
			
			else{
				$query = "SELECT * FROM xxx WHERE id_card like('".$_GET['id']."%')";
				//echo $query;
				if ($result = $mysqli->query($query))
				{
					//echo $query;
					while($obj = $result->fetch_object())
					{
				?>
					<tr><td><? echo $obj->id_card;?></td><td><? echo $obj->id_voter;?></td><td><a href="pageVote.php?c=<? echo $obj->id_card;?>">glosowanie</a></td></tr>
				
				<?php }
				$result->close();
				
				}}
			$mysqli->close(); 
			?>
			</table>
			</content>
		</content>
	<footer>Piotr Majkrzak, Szymon Nosal</footer>
	
	
</body>
</html>