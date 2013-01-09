<?php
	include('functions.php');
?>
<!DOCTYPE html>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Evote - Creating New Voting</title>
	<script type="text/javascript"src="jquery.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="style.css" />
	<script type="text/javascript" src="evote.js"></script>
	

</head>
<body>

	<?php
		//print_r($_SESSION['newVote']);
		//print_r($_SESSION['Voting']);
		//print_r($_SESSION['user']);
		if (!$_SESSION['user']):
	?>
		
		<content id="main">
			<header>Evote - Creating New Voting</header>
			<nav id="left">
				<ul id="menu">
					<li id="" class="active">login/register</li>
					<li id="step1" >STEP 1</li>
					<li id="step2" >STEP 2</li>
					<li id="step3">STEP 3</li>
					<li id="step4">STEP 4</li>
					<li id="step5">STEP 5</li>
					<li id="finish">FINISH</li>
				</ul>
				<aside class="error">
					<span id="infoStep">
						Please login or register account.
					</span>
				</aside>
			</nav>
			<?php include('registerForm.html'); ?>
		</content>
	
	<?php endif;?>
	<?php if ($_SESSION['user']):?>

	<content id="main">
		<header>Evote - Creating New Voting</header>
		<nav id="left">
			<ul id="menu">
				<li id="step1" class="active">STEP 1</li>
				<li id="step2" >STEP 2</li>
				<li id="step3">STEP 3</li>
				<li id="step4">STEP 4</li>
				<li id="step5">STEP 5</li>
				<li id="finish">FINISH</li>
			</ul>
			<aside >
				<span id="infoStep">
				
				</span>
			</aside>
		</nav>
		<content id="content">
			<content id="content1">
			
				<label for="name">Voting name</label><br/>
				<input type="text" id="name" name="name" class="text" size="40" />
				
				<br />
				<label for="voters">Voters quantity</label><br/>
				<input type="text" id="voters" name="voters" class="text" size="40" />
				
				<br/>
				<label for="options">Options quantity</label><br/>
				<input type="text" id="options" name="options" class="text" size="40" />
				
				<br/>
				<button type="submit" class="button positive" id="generateVoteB">
					<img alt="ok" src="http://www.blueprintcss.org/blueprint/plugins/buttons/icons/tick.png" /> Prepare voting
				</button>
				<br /><br />
				<a href="pageVotingList.php">Cancel </a>
			</content>
			
			<content id="content2" style="display:none">
				<label for="p">Primary number</label><br/>
				<input type="text" id="p" name="p" class="text" size="40" readonly/>
				
				<br/>
				<label for="g">Generator number</label><br/>
				<input type="text" id="g" name="g" class="text" size="40" readonly/>
				
				<br/>
				<label for="vuid">VUID</label><br/>
				<input type="text" id="vuid" name="vuid" class="text" size="40" readonly/>
				
				<br />
				<button type="submit" class="button positive" id="saveVote">
					<img alt="ok" src="http://www.blueprintcss.org/blueprint/plugins/buttons/icons/tick.png" /> Save voting
				</button>
			</content>
			
			<content id="content3" style="display:none">
				<label for="options">Options (one option in one line)</label>
				<br />
				<textarea id="options_list" name="options_list" class="text" rows="15" cols="35"></textarea>
				<button type="submit" class="button positive" id="generateOptions">
					<img alt="ok" src="http://www.blueprintcss.org/blueprint/plugins/buttons/icons/tick.png" /> Save Options
				</button>
			</content>
			
			<content id="content4" style="display:none">
				<strong>Generating cards may take some times.<br />Don't panic :)<br/></strong>
				<button type="submit" class="button positive" id="generateCards">
					<img alt="ok" src="http://www.blueprintcss.org/blueprint/plugins/buttons/icons/tick.png" /> Generate Cards
				</button>
			</content>
			
			<content id="content5" style="display:none">
				<label for="emails">Emails (one email in one line)</label>
				<br />
				<textarea id="emails_list" name="emails_list" class="text" rows="15" cols="35"></textarea>
				<button type="submit" class="button positive" id="saveEmail">
					<img alt="ok" src="http://www.blueprintcss.org/blueprint/plugins/buttons/icons/tick.png" /> Save E-mails
				</button>
			</content>
			
			<content id="content6" style="display:none">
				<span>Information</span><br />
				<span>N: </span><span id="info_n"></span><br />
				<span>V: </span><span id="info_v"></span><br />
				<span>O: </span><span id="info_o"></span><br />
				<span>P: </span><span id="info_p"></span><br />
				<span>G: </span><span id="info_g"></span><br />
				<span>VUID: </span><span id="info_VUID"></span><br />
				<span>Options: </span><span id="info_options"></span>
				<br/>
				<button type="submit" class="button positive" id="finishVoting" onclick="window.location.href = '/evote'">
					<img alt="ok" src="http://www.blueprintcss.org/blueprint/plugins/buttons/icons/tick.png" /> Start Voting
				</button>
			</content>
		</content>
	</content>
	<?php endif;?>
	<footer>Piotr Majkrzak, Szymon Nosal</footer>
</body>
</html>