<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

$loginError = '';
if (!empty($_POST['email']) && !empty($_POST['pwd'])) {
	include 'Invoice.php';
	$invoice = new Invoice();
	$user = $invoice->loginUsers($_POST['email'], $_POST['pwd']); 
	if(!empty($user)) {
		$_SESSION['user'] = $user[0]['first_name']."".$user[0]['last_name'];
		$_SESSION['userid'] = $user[0]['id'];
		$_SESSION['email'] = $user[0]['email'];		
		$_SESSION['address'] = $user[0]['address'];
		$_SESSION['mobile'] = $user[0]['mobile'];

			echo '<script type="text/javascript">
				location.replace("invoice_list.php");
			  </script>';
		
	} else {
		$loginError = "Invalid email or password!";
	}
}
?>


<title>Хөрөнгийн үнэлгээ</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="row">	
	<div class="demo-heading">
		<h2 align="center">Цахим тайлангийн систем</h2>
	</div>
	<div class="login-form">		
		<h4>Нэвтрэх нэр:</h4>		
		<form method="post" action="">
			<div class="form-group">
			<?php if ($loginError ) { ?>
				<div class="alert alert-warning"><?php echo $loginError; ?></div>
			<?php } ?>
			</div>
			<div class="form-group">
				<input name="email" id="email" type="email" class="form-control" placeholder="Email address" hurungufocus="" required>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="pwd" placeholder="Password" required>
			</div>  
			<div class="form-group">
				<button type="submit" name="login" class="btn btn-info">Login</button>
			</div>
		</form>
		<br>		
	</div>		
</div>		
</div>
<?php include('footer.php');?>