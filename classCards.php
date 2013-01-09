<?php
	class Cards
	{
		public $cardList = array();
		public $optionList = array();
		public $cardId;	//card id second element in url
		public $voteId;	//vote id first element in url
		
		public function __construct($inVoteId,$inCardId)
		{
			$this->cardId = $inCardId;
			$this->voteId = $inVoteId;
			
			$this->prepareCard();
			$this->prepareOptions();
		}
		
		public function prepareCard()
		{
			//$mysqli = new mysqli('snosal.linuxpl.info','snosal_evote','evote','snosal_evote');
			$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
			$query = 'SELECT * FROM card WHERE id_votes ="'.$this->voteId.'" and gtv="'.$this->cardId.'" ORDER BY id_option ASC ';
			
			if ($result = $mysqli->query($query))
			{
				while($obj = $result->fetch_object())
				{
					$card = new Card($obj->id,$this->voteId,$obj->id_option,$obj->gtv,$obj->Pog,$obj->gyv,$obj->sig);
					array_push($this->cardList,$card);
				}
			}
			else 
			{
			
			}
			$mysqli->close(); 
		}
		
		public function prepareOptions()
		{
			//$mysqli = new mysqli('snosal.linuxpl.info','snosal_evote','evote','snosal_evote');
			$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
			$query = 'SELECT name FROM options WHERE id_votes ="'.$this->voteId.'" ORDER BY id_option ASC ';
			if ($result = $mysqli->query($query))
			{
				while($obj = $result->fetch_object())
				{
					array_push($this->optionList,$obj->name);
				}
			}
			else 
			{
			
			}
			$mysqli->close(); 
		}
		
	}
	
	
?>