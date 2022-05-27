<?php
if (!session_id()) {
	session_start();
}
include_once 'connect.php';
include_once 'control.php';
$data = new Data();
if (!empty($_SESSION['user'])) {
	$result = $data->select_user($_SESSION['user']);
	$user = mysqli_fetch_assoc($result);
}
?>
<div id="header">
	<script>
		function onLoadAvatarErr(_this) {
			_this.src = 'images/avatar_default.png';
			_this.onerror = '';
		}
	</script>
	<div id="logo">
		<a href="index.php"><img src="images/logo.png" alt="LOGO" height="112" width="118"></a>
		<?php if (empty($_SESSION['user'])) { ?>
			<div>
				<a href="login.php">Login</a> |
				<a href="register.php">Register</a>
			</div>
		<?php } else {
			echo "<div>";
			if (!empty($user['avatar'])) {
				echo "<a href='update.php'><img style='width: 30px;height: 30px;border-radius: 50%;' src='{$user['avatar']}' onerror='onLoadAvatarErr(this)' /></a>";
			}
		?> |
			<a href="logout.php">Logout</a>
		<?php echo "</div>";
		} ?>
	</div>
	<div id="navigation">
		<ul>
			<li>
				<a href="index.php">Home</a>
			</li>
			<li>
				<a href="rooms.php">Rooms</a>
			</li>
			<li>
				<a href="dives.php">Dives</a>
			</li>
			<li>
				<a href="taikhoan.php">Tai khoan</a>
			</li>
			<li>
				<a href="profile.php">Profile</a>
			</li>
			<li>
				<a href="register.php">Register</a>
			</li>
			<li>
				<a href="login.php">Login</a>
			</li>
		</ul>
	</div>
</div>