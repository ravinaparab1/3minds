<?php
class API {
		public $data = "";
		
		const DB_SERVER = "localhost";
		const DB_USER = "root";
		const DB_PASSWORD = "";
		const DB = "signup";
		public $db = NULL;
		public $mysqli = NULL;
		public function __construct(){
			$this->dbConnect();					// Initiate Database connection
		}
		
		public function dbConnect(){
			$this->mysqli = new mysqli(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB);
		}

		public function getUsers(){	
			$query="SELECT * FROM `users`";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				return $this->json($result); // send user details
			}
		}
		public function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
}
$api = new API;
echo $api->getUsers();
?>