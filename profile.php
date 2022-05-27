<?php
session_start();

if (empty($_SESSION['user'])) {
	header('Location:login.php');
	exit();
}

include 'src/control.php';

$data = new Data();

$result = $data->select_user($_SESSION['user']);

$user = mysqli_fetch_assoc($result);


?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
	<meta charset="UTF-8">
	<title>News - Bhaccasyoniztas Beach Resort Website Template</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
	<div id="background">
		<div id="page">
			<?php include 'src/header.php' ?>
			<div id="contents">
				<div class="box">
					<div>
						<div id="news" class="body">
							<?php
							echo $_SESSION['user'];

							echo "<h1>Username: {$user['username']}</h1>";

							if (!empty($user['avatar'])) {
								echo "<img style='width: 500px;' src='{$user['avatar']}' />";
							}
							?>
							<div>
								<a href="logout.php">Logout</a>
								<a href="update.php">Update</a>
								<a href="changepassword.php">Đổi mật khẩu</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include 'src/footer.php' ?>

	</div>
</body>

</html>