<?php // Initialize the session
session_start();

// If session variable is not set it will redirect to login page

if(!isset($_SESSION['userid']) || empty($_SESSION['userid'])){
    header("location: index.php");
    exit;
} elseif($_SESSION['level']  = 0){
  header("location: index.php");
    exit;
}

require_once "database.php";

include 'head.php';

function punch($names, $databse, $type){
	if ($type==0) $typetext = 'OUT';
	if ($type==1) $typetext = 'IN';
	$sql = "UPDATE users SET punched_in = $type WHERE id={$_SESSION['id']}";
	if (mysqli_query($databse,$sql)) 
		echo "<p class='text-center'>User {$_SESSION['id']}, {$_SESSION['firstname']} {$_SESSION['lastname']}, is now punched $typetext.</p><br>";	
	else echo mysqli_error($databse);
	$sql = "INSERT INTO punches (id, time, type) VALUES ({$_SESSION['id']}, ADDTIME(NOW(), '1:00:00'),$type)";
	if (mysqli_query($databse,$sql)){
	}
	else{
		echo mysqli_error($databse);
	}
}
function hours($databse, $user){
	$sql = "SELECT TIMESTAMPDIFF(MINUTE,(SELECT time FROM punches WHERE id = $user ORDER BY time DESC LIMIT 1),ADDTIME(NOW(), '1:00:00'))";
	if ($minute_array = mysqli_query($databse,$sql)){ 
		$minutes = mysqli_fetch_row($minute_array);
		$hours = round($minutes[0] / 60.0,2);	
		echo "<p class='text-center'>You have logged $hours hours.</p>";
		$sql = "INSERT INTO hours (id, hours, date) VALUES ($user,$hours,ADDTIME(NOW(), '1:00:00'))";
		if (mysqli_query($databse,$sql)) {}
		//echo "<p>Time has been logged in the database.</p>";	
		else echo mysqli_error($databse);
	}
	else echo mysqli_error($databse);
}
function accumulated_hours($databse, $user){
	$sql = "SELECT SUM(hours) as total_hours FROM hours WHERE id=$user AND hours.date > '2017-08-19'";
	if ($total_result = mysqli_query($databse,$sql)){ 
		$hours = round(mysqli_fetch_row($total_result)[0],2);
		echo "<p class='text-center'>You have logged a total of $hours hours this season.</p>";
		}
	else echo mysqli_error($databse);
}


//Find the student's most recent punch that is from the current date.
	//The result will be an empty set (zero rows) if there's no punch from today.
	$sql = "SELECT type, time FROM (SELECT * FROM punches WHERE id={$_SESSION['id']} ORDER BY time DESC LIMIT 1) as custom WHERE DATE(time) = CURDATE()";
	if ($result = mysqli_query($database,$sql)){
		if (mysqli_num_rows($result)!=0){
		    $type_array = mysqli_fetch_assoc($result);
		    $type = $type_array['type'];
		    //Type 1 means punch IN and Type 0 means punch OUT
		    //User punched in (1) most recently today. Punch them out (0).
		    if ($type == 1){
		    	//Log hours into hours table when punching out.
		    	//Hours function must come first so we can do NOW() minus most recent timestamp
		    	hours($database,$_SESSION['id']);
		    	accumulated_hours($database,$_SESSION['id']);
		    	punch($_SESSION['username'], $database,0);
		    }
		    else {
		    	punch($_SESSION['username'], $database,1);
		    	accumulated_hours($database,$_SESSION['id']);}
		    	//User has punched in and out already today. Punch them back in (1).
		}
		else {
			punch($_SESSION['username'], $database,1);
			accumulated_hours($database,$_SESSION['id']);}
			//User has no punches yet today. Punch them in(1).
	}
	else{
		echo mysqli_error($database);
	}

?>