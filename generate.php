<?php
$password ="123";
$npassword = $password;
$npassword = md5($npassword);
$password = hash('sha512',(md5($password)));
echo "$npassword";
echo "<br>";
echo "$password";
?>