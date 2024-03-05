<?php
require 'admin/inc/config.php';

	$fetcingelections = mysqli_query($con,"SELECT * FROM elections") or die ("SQL not working");

	while($data = mysqli_fetch_assoc($fetcingelections))
	{
		$start_date = $data['starting_date'];
		$ending_date = $data['ending_date'];
		$curunt_date = date("y-m-d");
		$election_id = $data['id'];
		$status = $data['status'];

		if($status == "Active")
		{
			$date1 = date_create($curunt_date);
			$date2 = date_create($ending_date);
			$diff = date_diff($date1,$date2);
			
			if((int)$diff->format("%R%a") < 0)
			{
			   // Update

			   mysqli_query($con , "UPDATE elections SET `status` =  'Expired' WHERE id = '$election_id'" ) or die("SQL not working");
			}
		}elseif($status == "InActive")
		{
			$date1 = date_create($curunt_date);
			$date2 = date_create($start_date);
			$diff = date_diff($date1,$date2);
			
			if((int)$diff->format("%R%a") <= 0)
			{
			 // Update

			 mysqli_query($con , "UPDATE elections SET `status` =  'Active' WHERE id = '$election_id'" ) or die("SQL not working");
			}
		}

		
	
	}

?>



<!DOCTYPE html>
<html>   
<head>
	<title>Login Page | Online Voting</title>
	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="asset/css/login.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="asset/css/style.css">
	<style>
		body 
		{
			font-family: 'Roboto', sans-serif;
		}
	</style>
	</head>
<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="asset/img/logo.png" class="brand_logo" alt="Logo">
					</div>
				</div>
				<?php 
					if(isset($_GET['sign-up']))
					{
						?>
							<div class="d-flex justify-content-center form_container">
					<form method="post">
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class='bx bxs-user' style='color:#eea47f'  ></i></span>
							</div>
							<input type="text" name="su_user" class="form-control input_user" placeholder="username" required />
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class='bx bxs-contact' style='color:#eea47f'  ></i></span>
							</div>
							<input type="text" name="su_contact" class="form-control input_pass" placeholder="contact #" required />
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class='bx bxs-key' style='color:#eea47f'></i></span>
							</div>
							<input type="password" name="su_password" class="form-control input_pass" placeholder="password #" required />
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class='bx bxs-key' style='color:#eea47f'></i></span>
							</div>
							<input type="password" name="su_retype_password" class="form-control input_pass" placeholder="Retype password #" required />
						</div>
							<div class="d-flex justify-content-center mt-3 login_container  text-white">
				 	<button type="submit" name="sign_up_button" class="btn login_btn">Registered</button>
				   </div>
					</form>
				</div>
		
				<div class="mt-4">
					<div class="d-flex justify-content-center links  text-white">
						Already created account? <a href="index.php" class="ml-2 text-white"> Sign In</a>
					</div>
						<?php

					}else{
						?>
						<div class="d-flex justify-content-center form_container">
					<form method='post'>
						<div class="input-group mb-3">
							<div class="input-group-append">
								<span class="input-group-text"><i class='bx bxs-user' style='color:#eea47f'  ></i></i></span>
							</div>
							<input type="text" name="si_user" class="form-control input_user" value="" placeholder="Username" required />
						</div>
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text"><i class='bx bxs-key' style='color:#eea47f'  ></i></span>
							</div>
							<input type="password" name="si_password" class="form-control input_pass" value="" placeholder="Password" required />
						</div>
							<div class="d-flex justify-content-center mt-3 login_container  text-white">
				 	<button type="submit" name="login_btn" class="btn login_btn">Login</button>
				   </div>
					</form>
				</div>
		
				<div class="mt-4">
					<div class="d-flex justify-content-center links  text-white">
						Don't have an account? <a href="?sign-up=1" class="ml-2 text-color"> Sign Up</a>
					</div>
						<?php
					}
				
				?>
				<?php
				if(isset($_GET['registered']))
				{
					?>
					<span class='bg-white text-success text-center my-3'>Your Account Has Been Created!</span>
					<?php
				}elseif(isset($_GET['invalid']))
				{
					?>
					<h3 class='bg-white text-danger text-center my-2' style="border-radius:8px;">Password Mis Mach</h3>
					<?php
				}elseif(isset($_GET['not_registered']))
				{
					?>
					<h3 class='bg-white text-warnig text-center my-2' style="border-radius:8px;">Sorry You Are Not Rgistered</h3>
					<?php
				}elseif(isset($_GET['invalid_access']))
				{
					?>
					<h5 class='bg-white text-danger text-center my-2' style="border-radius:8px;">Invalid Username Or Password</h5>
					<?php
				}
				 
				?>
				
				</div>
			</div>
		</div>
	</div>
	<script src="asset/js/bootstrap.min.js"></script>
	<script src="asset/js/jquery-3.7.1.min.js"></script>
</body>
</html>

<?php
//su_user su_contact su_password su_retype_password
require("admin/inc/config.php");
if(isset($_POST['sign_up_button']))
{
	$su_user = strip_tags($con->real_escape_string($_POST['su_user']));
	$su_contact = strip_tags($con->real_escape_string($_POST['su_contact']));
	$su_password = strip_tags($con->real_escape_string(sha1($_POST['su_password'])));
	$su_retype_password = strip_tags($con->real_escape_string(sha1($_POST['su_retype_password'])));
	$user_role = "Voter";

	if($su_password == $su_retype_password)
	{
		// Insert SQL Query
		$SQL = "INSERT INTO su_user(username, contact_no, `password`, user_role) VALUES('$su_user', '$su_contact', '$su_password', '$user_role')";

		$execute_SQL = $con->query($SQL) or die("SQL no wrking");

		?>
		<script>location.assign("index.php?sign-up=1&registered=1");</script>
		<?php

	}else{
		?>
			<script>location.assign("index.php?sign-up=1&invalid=1");</script>
		<?php
	}
}elseif(isset($_POST['login_btn']))
{
// su_user su_password 
    $si_user = strip_tags($con->real_escape_string($_POST['si_user']));
	$si_password = strip_tags($con->real_escape_string(sha1($_POST['si_password'])));

	// SQL Query

	$SQL_login = "SELECT * FROM su_user WHERE username = '$si_user'";
	

	$SQL_login_run = $con->query($SQL_login) or die('SQL not working');
	
	if(mysqli_num_rows($SQL_login_run) > 0)
	{
		
		$fatch_data = mysqli_fetch_assoc($SQL_login_run);
		if($si_user == $fatch_data['username'] and $si_password == $fatch_data['password'])
		{
			session_start();
			$_SESSION['user_role'] = $fatch_data['user_role'];
			$_SESSION['username'] = $fatch_data['username'];
			$_SESSION['user_id'] = $fatch_data['id'];
			if($fatch_data['user_role'] == "Admin")
			{
				$_SESSION['key'] = "AdminKey";
				?>
				<script> location.assign("admin/index.php?homepage=1"); </script>
				<?php

			}else{
				$_SESSION['key'] = "VotersKey";
				?>
				<script> location.assign("voters/index.php"); </script>
				<?php
			}
		}else
		{
			?>
			<script>location.assign("index.php?invalid_access=1");</script>
			<?php
		}
	}else{
		?>
			<script>location.assign("index.php?sign-up=1&not_registered=1");</script>
		<?php
	}
}


?>