<?php

	class Votes
	{
		public $id;
		public $name;
		public $idUser;
		public $voters;
		public $options;
		public $optionsList = Array();
		public $p;
		public $g;
		public $k;
		public $result;
		
		public function __construct($inId=null,$inName=null,$inIdUser=null,$inVoters=null,$inOptions=null,$inP=null,$inG=null,$inK=null,$inOptionsList=null)
		{
			$this->id = $inId;
			$this->name = $inName;
			$this->idUser = $inIdUser;
			$this->voters = $inVoters;
			$this->options = $inOptions;
			$this->optionsList = $inOptionsList;
			$this->p = $inP;
			$this->g = $inG;
			$this->k = $inK;
		}
		
		public function generateOptionsList()
		{
			foreach($this->optionsList as $obj)
			{
				echo $obj->show()."<br/>";
			}
		}
		
		public function generateOptionsString()
		{
			foreach($this->optionsList as $obj)
			{
				echo $obj->name." | ";
			}
		}
		
		public function addOption($option)
		{
			//array_push($this->optionsList,$option);
			$this->optionsList[]=$option;
		}
		
		public function addK($inK)
		{
			$this->k = $inK;
		}
		
		public function addResult($d1,$d2)
		{
			$this->result = Array($d1,$d2);
		}
		
	}


?>