<?php
	include('functions.php');
	getVoting($_GET['id']);
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Evote - Voting Info</title>
	<script type="text/javascript"src="jquery.js"></script>
	<script type="text/javascript" src="evote.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="style.css" />
	<script>
		$(document).ready(function(){
			$.ajax({
				type: 'POST',
				url: 'generator.cgi?json',
				dataType: 'json',
				data:JSON.stringify({"type": "count_votes","data":['<?php echo $_SESSION['Voting']->p;?>','<?php echo $_SESSION['Voting']->k;?>','<?php echo $_SESSION['Voting']->result[0];?>','<?php echo $_SESSION['Voting']->result[1];?>']}),
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					$('span#infoNav').text("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
					$('span#infoNav').parent().attr('class',"error");
				},
				success: function(data){
					console.log(data);
					$.ajax({
						type: 'POST',
						url: 'functions.php',
						dataType: 'json',
						data: {prepareResult: JSON.stringify(data.data)},
						error: function(XMLHttpRequest, textStatus, errorThrown) { 
							console.log("responseText: " + XMLHttpRequest.responseText + ", textStatus: " + textStatus + ", errorThrown: " + errorThrown);
						},
						success: function(dataR){
							showResult(dataR);
							console.log(dataR);
						}
					});
				}
			});
		});
		
		function showResult(data)
		{
			var len=data.length;
			for(var i=0;i<len;i++)
			{
				$('#result').append('<tr><td>'+(i+1)+'</td><td>'+ data[i][0] +'</td><td>'+data[i][1]+'</td></tr>');
			}
		}
		
	</script>
</head>
<body>
	<?php
		if (!$_SESSION['user']):
	?>
		<content id="main">
			<header>Evote - Voting Info</header>
			<nav id="left">
				<aside class="error">
					<span id="infoNav">
						Please login or create account.
					</span>
				</aside>
			</nav>
			<?php include('registerForm.html'); ?>
		</content>
	
	<?php endif;?>
	<?php if ($_SESSION['user']):?>
		<content id="main">
			<header>Evote - Voting Info</header>
			<content id="content_full">
				<span>Name: <strong><?php echo $_SESSION['Voting']->name; ?></strong></span><br />
				<span>Options: <strong><?php echo $_SESSION['Voting']->generateOptionsString(); ?></strong></span><br />
				<table id="result">
					<tr>
						<th>Id</th>
						<th>Options</th>
						<th>Count</th>
					</tr>
				</table>
				<a href="pageVotingList.php">Back</a> 
			</content>
		</content>
	<?php endif;?>
	<footer>Piotr Majkrzak, Szymon Nosal</footer>
	
	
	
</body>
</html>