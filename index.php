<?php
	$host = "localhost";
	$user = "root";
	$password = "";
	$dbname = "test";

	$dsn = "mysql:host=". $host ."; dbname=". $dbname;

	try {
		$pdo = new PDO($dsn, $user, $password);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	} catch (PDOException $e) {
		echo 'Database Connection Failed. <br/>'. $e->getMessage();
	}

	global $pdo;


	class User
	{
	    protected $pdo;
	    public function __construct($pdo)
	    {
	        $this->pdo = $pdo;
	    }

	    public function checkDate($date)
	    {
	    	$sql = "SHOW COLUMNS FROM attendence LIKE :date ";
	    	$stmt = $this->pdo->prepare($sql);
	    	$stmt->bindValue(":date", $date);
	    	$stmt->execute();

	    	$count = $stmt->rowCount();

	    	if ($count > 0) {
	    		return true;
	    	}else {
	    		return false;
	    	}

	    }
	}

	$getFromU = new User($pdo);

	$result = $getFromU->checkDate('2018-04-18');

	if ($result === true) {
		echo 'Attendence Already Taken';
	}else {
		echo "You Can Take attendence!";
	}

?>