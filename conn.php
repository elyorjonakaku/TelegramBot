<?php
$dbhost='localhost';
$dbname='dbname';
$dbuser='username';
$dbpass='********';



try {
    $connect = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
  die('db not connect');
}

function ol($id, $argument){
	global $connect;
	$statement = $connect->prepare('SELECT * FROM taqrizchilar WHERE id=:login');
	$statement->bindParam(':login', $id, PDO::PARAM_STR);
	$statement->execute();
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	return $row[$argument];
}

function olmaqolachi($vaqt, $argument){
	global $connect;
	$statement = $connect->prepare('SELECT * FROM maqolachi WHERE vaqt=:login');
	$statement->bindParam(':login', $vaqt, PDO::PARAM_STR);
	$statement->execute();
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	return $row[$argument];
}

function tekshir($id){
	global $connect;
	$statement = $connect->prepare('SELECT * FROM maqolachi WHERE id=:login');
	$statement->bindParam(':login', $id, PDO::PARAM_STR);
	$statement->execute();
	$row = $statement->fetch(PDO::FETCH_ASSOC);

	if($row){
		return true;
	}
}

function bazagayoz($id, $maqolaId, $vaqt){
	global $connect;
	$statement = $connect->prepare("INSERT INTO `maqolachi`(`id`, `maqolaId`, `status`, `taqrizchiId`, `vaqt`) VALUES ('$id', '$maqolaId', 0, 0, '$vaqt')");
	$statement->execute();
}


function udalitbaza(){
	global $connect;
	$statement = $connect->prepare("DELETE FROM `maqolachi` WHERE `status`=0");
	$statement->execute();

}

function qabulQilinganMaqolalar(){
	$bir=0;
	global $connect;
	$statement = $connect->prepare('SELECT * FROM maqolachi WHERE qabul=:login');
	$statement->bindParam(':login', $bir, PDO::PARAM_STR);
	$statement->execute();
	$row = $statement->fetchAll();
	return $row;

}

function maqolachitahrirlashuchun($id){
	global $connect;
	$statement = $connect->prepare('SELECT * FROM maqolachi WHERE id=:login');
	$statement->bindParam(':login', $id, PDO::PARAM_STR);
	$statement->execute();
	$row = $statement->fetchAll();
	return $row;

}



function getDinamik() {
	$bir=0;
	global $connect;
	$talabaoladi = 'base/'.$chat_id.'_talabaoladi.txt';
	unlink($talabaoladi);

	$statement = $connect->prepare('SELECT * FROM taqrizchilar WHERE olishuchun=:login');
	$statement->bindParam(':login', $bir, PDO::PARAM_STR);
	$statement->execute();
	$row = $statement->fetchAll();
	if(!$row){
	  return "Bironta taqrizchi yuq";
	} else 
	{
		$count = count($row);

		for ($i=0; $i<$count; $i++){

		   
		    $ChLogin = $row[$i][0];
		    $ChLogin8 = $row[$i][1];
		    $ChLogin1 = $row[$i][3];
		    $ChLogin2 = $row[$i][7];


			$text = '
			'.($i+1).') '.$ChLogin.'-> '.$ChLogin8.' '.$ChLogin1.' '.$ChLogin2;
		

			//faylni uchirib qaytadan saqlash
			$handle = fopen($talabaoladi, 'a+'); 
			fwrite($handle, $text);
			fclose($handle);
		}
		$file = file_get_contents($talabaoladi);
	  return  $file;
	}
}

function taqrizchiniyoz($tid1, $mk){
	global $connect;
	$statement = $connect->prepare("UPDATE maqolachi SET taqrizchiId='$tid1', status=1 WHERE vaqt='$mk'");
	$statement->execute();
}

function qabulqil($mk){
	global $connect;
	$statement = $connect->prepare("UPDATE maqolachi SET status=1 WHERE vaqt='$mk'");
	$statement->execute();
}

function olinganMaqolalar() {
	$bir=0;
	global $connect;
	$talabaoladi = 'base/'.$chat_id.'_talabaoladi.txt';
	unlink($talabaoladi);

	$statement = $connect->prepare('SELECT * FROM maqolachi WHERE taqrizchiId=:login');
	$statement->bindParam(':login', $bir, PDO::PARAM_STR);
	$statement->execute();
	$row = $statement->fetchAll();
	if(!$row){
	  return "\nBironta maqola yuq";
	} else 
	{
		$count = count($row);

		for ($i=0; $i<$count; $i++){

		   
		    $ChLogin = $row[$i][0];
		    $ChLogin8 = $row[$i][4];
		    $ChLogin1 = $row[$i][3];
		    $ChLogin2 = $row[$i][7];


			$text = '
			'.($i+1).') Maqolachi ID-> '.$ChLogin.' maxsus kod-> '.$ChLogin8;
		

			//faylni uchirib qaytadan saqlash
			$handle = fopen($talabaoladi, 'a+'); 
			fwrite($handle, $text);
			fclose($handle);
		}
		$file = file_get_contents($talabaoladi);
	  return  $file;
	}
}


