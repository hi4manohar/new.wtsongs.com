<?php
session_start();

function manage_session( $id ) {
	global $common_obj;
	$user = $common_obj->execute_query( "SELECT * FROM wt_users WHERE fb_id=$id" );
	$user = mysqli_fetch_assoc( $user );
	$user_id = $user['id'];
	$firstname = $user['firstname'];
	$user_email = $user['email'];

	$_SESSION['user_id'] = $user_id;
  $_SESSION['user_email']=$user_email;
  $_SESSION['user_name']=$firstname;
}

$root_dir = $_SERVER['DOCUMENT_ROOT'];
include_once $root_dir . '/include/controller/common/common_class.php';
$common_obj = new commonClass();

if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['name'])) {
	if( isset($_POST['email']) && !empty($_POST['email']) ) {
		include_once $root_dir . '/include/controller/db/DBConfig.php';
		extract($_POST); // extract post variables

		//check if facebook ID already exits
		$check_user_query = "select * from wt_users WHERE fb_id = $id";
		$result = $common_obj->execute_query( $check_user_query );
		if( !mysqli_num_rows($result) > 0 ) {

			//new user - we need to insert a record
			$time = time();
			$parts = explode(" ", $name);
			$lastname = array_pop($parts);
			$firstname = $parts[0];

			$email = $email;
			if( $common_obj->email_exist( $email ) ) {
				$arr = array(
					'error' => 1,
					'error_dis' => 'Your facebook email address is already assigned with us, Please login with that email address'
				);
				echo json_encode($arr);
				exit();
			} else {
				$emailparts = explode('@', $email);
				$unique_user_name = $emailparts[0];
			}		

			$insert_user_query = "Insert into wt_users (`name`, `unique_user_name`, `firstname`, `lastname`, `email`, `fb_id`, `fb_doj`) VALUES ('$name', '$unique_user_name', '$firstname', '$lastname', '$email', $id, $time)";
			if( mysqli_query( $link, $insert_user_query ) ) {
				$arr = array(
					'error' => 0
				);
			} else {
				$arr = array(
					'error'     => 1,
					'error_dis' => 'Something going Wrong to arranging data'
				);
				echo json_encode($arr);
				exit();
			}

			//manage session data
			manage_session($id);

			echo json_encode($_POST);
		} else {

			$parts = explode(" ", $name);
			$lastname = array_pop($parts);
			$firstname = $parts[0];

			$email = $_POST['email'];

			//update
			//in the updation of fb user we are escaping the email address
			$update_user_query = "update wt_users set name = '$name', firstname='$firstname', lastname='$lastname' WHERE fb_id = $id";
			$update_user = mysqli_query( $link, $update_user_query );

			//manage session
			manage_session( $id );
    
			echo json_encode($_POST);
		}
	} else {
		$arr = array(
			'error' => 1,
			'error_dis' => 'You have not provided email address on your facebook id'
		);
		echo json_encode($arr);
	}
} else {
	$arr = array(
		'error' => 1,
		'error' => 'Something Went Wrong!'
	);
	echo json_encode($arr);
}
?>