<?php
	include('functions.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Evote - Voting List</title>
	<script type="text/javascript"src="jquery.js"></script>
	<script type="text/javascript" src="evote.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="style.css" />
</head>
<body>
	<?php
		if (!$_SESSION['user']):
	?>
		<content id="main">
			<header>Evote - Voting List</header>
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
			<header>Evote - Voting List</header>
			<content id="content_full">
				<table><tbody>
				<tr>
					<th class="t10">Nr</th>
					<th class="t60">Name</th>
					<th class="t25">Op</th>
				</tr>
				<?php $list = getVotingList(); 
					foreach ($list as $id => $obj)
					{
				?>
					<tr><td><?php echo $id+1 ;?></td><td><?php echo $obj['name'];?></td>
					<?php if(!$obj['type']): ?>
						<td><a href="#<?php echo $obj['id'];?>" id="stopVoting">Stop</a></td></tr>
					<?php else: ?>
						<td><a href="pageVotingInfo.php?id=<?php echo $obj['id']; ?>" id="infoVoting">Info</a></td></tr>
					<?endif;?>
				<?php } ?>
				</tbody></table>
				<a href="pageCreateVoting.php">Create new Voting </a> | <a href="functions.php?logout=true">Logout</a>
			</content>
		</content>
	<?php endif;?>
	<footer>Piotr Majkrzak, Szymon Nosal</footer>
</body>
</html>