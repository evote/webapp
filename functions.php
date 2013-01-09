<?php
	ob_start();
	include('conf.php');
	include('classUsers.php');
	include('classVotes.php');
	include('classOptions.php');
	include('classCard.php');
	include('classCards.php');
	
	session_start();
	
	//$mysqli = new mysqli('snosal.linuxpl.info','snosal_evote','evote','snosal_evote');
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	
	//Zapisywanie glosowania
	if(isset($_POST['saveVote'])){
		$obj = json_decode($_POST['saveVote']);
		
		$query = 'INSERT INTO votes VALUES("'.$obj->vuid.'","'.$obj->name.'","'.$_SESSION['user']->id.'","'.$obj->voters.'","'.$obj->options.'","'.$obj->p.'","'.$obj->g.'",null)';
		//$query = 'INSERT INTO votes VALUES(null,2,"'.$obj->voters.'","'.$obj->options.'","'.$obj->p.'","'.$obj->q.'")';
		
		if ($mysqli->query($query) === TRUE)
		{	
		/*	$query = 'SELECT MAX(id) as MAX FROM votes WHERE id_user = "'.$_SESSION['user']->id.'"';
			//$query = 'SELECT MAX(id) as MAX FROM votes WHERE id_user = "16"';
			$max = 0;
			if ($result = $mysqli->query($query))
			{
				while($row = $result->fetch_object())
				{
					$max = $row->MAX;
				}
			}*/
			$query = 'INSERT INTO result VALUES("'.$obj->vuid.'","0","0")';
			$mysqli->query($query);
			
			$_SESSION['Voting'] = new Votes($obj->vuid,$obj->name,$_SESSION['user']->id,$obj->voters,$obj->options,$obj->p,$obj->g,0,null);
			$jsonReturn=array("success"=>"Zapisano poprawnie glosowanie.");
		}
		else 
		{
			$jsonReturn=array('error'=>$mysqli->error);
		}
		header('Content-type: application/json');
		print json_encode($jsonReturn);
	}
	
	if(isset($_POST['saveOptions']))
	{
		$obj = json_decode($_POST['saveOptions']);
		
		$optionsList = explode("\n",$obj->options_list);
		$i=0;
		for($i;$i<$_SESSION['Voting']->options;$i++)
		{
			$obj = $optionsList[$i];
			$query = 'INSERT INTO options VALUES(null,'.($i+1).',"'.$_SESSION['Voting']->id.'","'.$obj.'")';
			//print_r ();
			if ($mysqli->query($query) === TRUE)
			{	
				$query = 'SELECT MAX(id) as MAX FROM options WHERE id_votes = "'.$_SESSION['Voting']->id.'"';
				$max = 0;
				if ($result = $mysqli->query($query))
				{
					while($row = $result->fetch_object())
					{
						$max = $row->MAX;
					}
					$result->close();
				}
				$option = new Options($max,$_SESSION['Voting']->id,$i,$obj);
				$_SESSION['Voting']->addOption($option);
				$jsonReturn=array("success"=>"Zapisano poprawnie opcje.");
				
			}
			else 
			{
				$jsonReturn=array('success'=>$mysqli->error);
			}	
		}
		header('Content-type: application/json');
		print json_encode($jsonReturn);
	}
	
	if(isset($_POST['saveCards']))
	{
		$json = json_decode($_POST['saveCards']);
		
		//Aktualizacja k dla Vote
		$query = 'UPDATE votes SET k="'.$json[0][0].'" WHERE id="'.$_SESSION['Voting']->id.'"';
		$mysqli->query($query);
		$_SESSION['Voting']->addK($json[0][0]);
		
		//Dodanie kart do bazy
		//petla po wszystkich kartach
		foreach($json[1] as $card => $card_value)
		{
			//petla po wszystkich opcjach
			foreach($card_value as $opt => $obj)
			{
				//print $card.'  '.$opt.'   ';
				//print_r($obj);
				$query = 'INSERT INTO card VALUES(null,"'.$_SESSION['Voting']->id.'",'.($opt+1).',"'.$obj[0].'","'.$obj[1].'","'.$obj[2].'","'.$obj[3].'")'."\n";
				$mysqli->query($query);
			}
		}
		print json_encode($json[0][1]);
	}
	
	
	if(isset($_POST['saveEmail']))
	{
		$obj = json_decode($_POST['saveEmail']);
		
		$emailList = explode("\n",$obj->email_list);
		$query='SELECT gtv FROM  card WHERE id_votes ="'.$_SESSION['Voting']->id.'" GROUP BY gtv';
		$card_gtv=array();
		if ($result = $mysqli->query($query))
		{
			while($row = $result->fetch_object())
			{
				array_push($card_gtv,$row->gtv);
			}
			$result->close();
		}
		foreach ($emailList as $id => $mail)
		{
			$query = 'INSERT INTO xxx VALUES(null,"'.$mail.'","'.$_SESSION['Voting']->id.'-'.$card_gtv[$id].'",null)';
			$mysqli->query($query);
			$jsonReturn=array("success"=>"Zapisano poprawnie emaile.");
		}
		header('Content-type: application/json');
		print json_encode($jsonReturn);
	}
	
	if(isset($_POST['updateResult']))
	{
		$obj = json_decode($_POST['updateResult']);
		//print_r($obj);
		$query='UPDATE result SET product_first="'.$obj->data[0].'",product_second="'.$obj->data[1].'" WHERE id_vote="'.$obj->vuid.'"';
		$mysqli->query($query);
		header('Content-type: application/json');
		print json_encode($query);
	}
	
	if(isset($_POST['prepareResult']))
	{
		$obj = json_decode($_POST['prepareResult'],true);
		//$return = Array(Array("Option","Value"));
		$len = $_SESSION['Voting']->options;
		$return = Array();
		for($i=0;$i<$len;$i++)
		{
			if(isset($obj[$i]))
			{
				$return[] = Array($_SESSION['Voting']->optionsList[$i]->name."",$obj[$i]."");
			}
			else
			{
				$return[] = Array($_SESSION['Voting']->optionsList[$i]->name."","0");
			}
		}
		print json_encode($return);
	}
	
	//Logowanie uzytkownika, przechwycenie danych z formularza.
	if(isset($_POST['login']) && isset($_POST['password']))
	{
		$user = new Users($_POST['login'],sha1($_POST['password']));
		header('Location:'.$_SERVER['HTTP_REFERER'].'');
	}
	
	//Rejestrowanie uzytkownika, przechwycenie danych z formularza.
	if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email']))
	{
		$user = new Users($_POST['login'],sha1($_POST['password']),$_POST['email']);
		header('Location:'.$_SERVER['HTTP_REFERER'].'');
	}
	
	if(isset($_GET['logout']))
	{
		$_SESSION['user']->logout();
		header('Location:'.$_SERVER['HTTP_REFERER'].'');
	}
	
	function fixObject (&$object)
	{
		if (!is_object ($object) && gettype ($object) == 'object')
			return ($object = unserialize (serialize ($object)));
		return $object;
	}
	
	function getVotingList()
	{
		$mysqli1 = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		//$mysqli1 = new mysqli('snosal.linuxpl.info','snosal_evote','evote','snosal_evote');
		$return = array();
		$query = "SELECT v . * FROM votes v INNER JOIN result r ON v.id = r.id_vote WHERE id_user = '".$_SESSION['user']->id."' and r.product_first='0' ";
		//echo $query;
		
		if ($result = $mysqli1->query($query))
		{
			//echo $query;
			while($obj = $result->fetch_object())
			{
				$temp = Array(
							"id" => $obj->id,
							"type" => 0,
							"name" => $obj->name
						);
				array_push($return,$temp);
			}
			$result->close();
		}	
		
		//print_r($return);
		
		$query = "SELECT v . * FROM votes v INNER JOIN result r ON v.id = r.id_vote WHERE id_user = '".$_SESSION['user']->id."' and r.product_first<>'0' ";
		//echo $query;
		
		if ($result = $mysqli1->query($query))
		{
			//echo $query;
			while($obj = $result->fetch_object())
			{
				$temp = Array(
							"id" => $obj->id,
							"type" => 1,
							"name" => $obj->name
						);
				array_push($return,$temp);
			}
			$result->close();
		}	
		
		//print_r($return);
		
		$mysqli1->close(); 
		return $return;
	}
	
	function getVoting($id)
	{
		//$mysqli1 = new mysqli('snosal.linuxpl.info','snosal_evote','evote','snosal_evote');
		$mysqli1 = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$query = 'SELECT v.*,r.product_first,r.product_second FROM votes v INNER JOIN result r ON r.id_vote = v.id WHERE id="'.$id.'"';
		//echo $query;
		
		if ($result = $mysqli1->query($query))
		{
			//echo $query;
			while($obj = $result->fetch_object())
			{
				//($inId=null,$inName=null,$inIdUser=null,$inVoters=null,$inOptions=null,$inP=null,$inG=null,$inK=null,$inOptionsList=null)
				
				$_SESSION['Voting'] = new Votes($obj->id,$obj->name,$obj->id_user,$obj->voters,$obj->options,$obj->p,$obj->g,$obj->k);
				$_SESSION['Voting']->addResult($obj->product_first,$obj->product_second);
				//print_r($_SESSION['Voting']);
			}
			$result->close();
		}	
		
		$query = 'SELECT * FROM options WHERE id_votes="'.$id.'"';
	//echo $query;
		
		if ($result = $mysqli1->query($query))
		{
			//echo $query;
			while($obj = $result->fetch_object())
			{		
				$option = new Options($obj->id,$_SESSION['Voting']->id,$obj->id_option,$obj->name);
				//echo $option->show();
				$_SESSION['Voting']->addOption($option);
				
			}
			$result->close();
		}
		//print_r($_SESSION['Voting']);
	//	$_SESSION['Voting']->generateOptionsList();
		$mysqli1->close(); 
	}
	
	
	$mysqli->close(); 
	
?>
