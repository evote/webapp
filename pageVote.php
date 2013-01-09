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
	<script type="text/javascript" src="vote.js"></script>
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
			<header>Evote - Voting</header>
			<content id="content_full">
				<table>
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Vote link</th>
					</tr>
					<?php
						foreach($card->cardList as $id => $obj)
						{
					?>
						<tr><td><?php echo $id+1 ; ?></td><td><?php echo $card->optionList[$id];?></td><td><a href="#<?php echo $obj->idVotes."|".$obj->gtv."|".$obj->pog."|".$obj->gyv."|".$obj->sig ; ?>">Glosuj</a></td></tr>
					<?
						}
						
					?>
				</table>
			</content>
		</content>
	<footer>Piotr Majkrzak, Szymon Nosal</footer>
	
	
</body>
</html>