<h1>Invalid Move</h1>
<p>Please provide valid information and login before accessing this page </p>
<?php
header("refresh: 3 ;/Rentfinder/index.php");
?>

<?php
if(isset($_GET['not']))	{
	echo '<strong>You are not allowed access this page.</strong>';
	header("refresh: 3;/Rentfinder/includes/logout.php");
}
?>