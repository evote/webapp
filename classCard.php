<?php	
	class Card
	{
		public $id;
		public  $idVotes;
		public  $idOption;
		public  $gtv;
		public  $pog;
		public  $gyv;
		public  $sig;
		
		public function __construct($inId,$inIdVotes,$inIdOptions,$inGtv,$inPog,$inGyv,$inSig)
		{
			$this->id=$inId;
			$this->idVotes=$inIdVotes;
			$this->idOption=$inIdOptions;
			$this->gtv=$inGtv;
			$this->pog=$inPog;
			$this->gyv=$inGyv;
			$this->sig=$inSig;
		}
	}
?>