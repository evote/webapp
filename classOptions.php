<?php
	class Options
	{
		public $id;			//id in table
		public $idVote;		//id Vote 
		public $idOptions; 	//id in vote increfent from 1 to options quantity in vote
		public $name;		//Options description name
		
		public function __construct($inId=null,$inIdVote=null,$inIdOptions=null,$inName=null)
		{
			$this->id = $inId;
			$this->idVote = $inIdVote;
			$this->idOptions = $inIdOptions;
			$this->name = $inName;
		}
		
		public function show()
		{
			return $this->idOptions.'. '. $this->name;
		}
	
	}
?>