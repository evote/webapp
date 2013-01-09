<?php
	
	class Users
	{	
		public $id;
		public $login;
		private $paswd;
		public $email;
		
		function __construct($inLogin=null,$inPaswd=null,$inEmail=null)
		{	
			//login user
			if($inEmail==null)
			{
				$this->login($inLogin,$inPaswd);
			}
			//register user
			else
			{
				$this->register($inLogin,$inPaswd,$inEmail);
				
			}
		}
		
		public function login($inLogin,$inPaswd)
		{
			//$mysqli = new mysqli('snosal.linuxpl.info','snosal_evote','evote','snosal_evote');
			$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

			$query = "SELECT * FROM users WHERE username = '".$inLogin."' and password = '".$inPaswd."'";
			if ($result = $mysqli->query($query))
			{
				//echo $query;
				while($obje = $result->fetch_object())
				{
					$this->id = $obje->id;
					$this->login = $obje->username;
					$this->email = $obje->email;
					$_SESSION['user'] = $this;
				}
			}
			else 
			{
			
			}
			
			$result->close();
			$mysqli->close(); 
		}
		
		public function register($inLogin,$inPaswd,$inEmail)
		{
			//$mysqli = new mysqli('85.17.184.27','snosal_evote','evote','snosal_evote');
			$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
			
			$query = "INSERT INTO users VALUES(null,'".$inLogin."','".$inPaswd."','".$inEmail."')";
			
			if ($mysqli->query($query) === TRUE)
			{
				//echo 'ok';
				
			}
			else 
			{
				//echo 'Error: '. $mysqli->error;
			}
			$result->close();
			$mysqli->close(); 
		}
		
		public function userinfo()
		{
			return $this->id.'<br/>'.$this->login.'<br />'.$this->email.'<br/>';
		}
		
		public function logout()
		{
			session_destroy();
		}
	}
?>