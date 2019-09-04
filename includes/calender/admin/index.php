<html>
<head>
	<title>.:Admin:.</title>
	<link href="css/login.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="images/logo.png" />
    <style type="text/css">

<!--
.style1 {
	font-size: 12px
}
.style2 {
	font-size: 18px
}
.style3 {
	font-size: 16px
}
-->
    </style>
</head>
<body>

<center>
<h2 class="style2">Welcome !!!</h2>
<div id="header">
	<div id="content">
		<h2 class="style3">Please Login</h2>
		<form method="POST" action="cek_login.php">
		  <table>
			<tr><td>User Login</td><td>:</td><td><input type="text" name="User"></td></tr>
			<tr><td>Password</td><td>:</td><td><input type="password" name="Password"></td></tr>
			<tr><td colspan="2"><p>
			  <input type="submit" value="Login">
			</p>
			   <!-- Password anda hilang atau lupa, click&nbsp;<a href="lostpass.php"><strong>disini</strong></a> </p></td> -->
		  </tr>
		</table>
		<!--<p class="style1">Apabila anda belum pernah mempergunakan service ini<br>
		  maka terlebih dahulu anda harus me-register NIK anda.<br>
		  Click&nbsp;<a href="registrasi.php"><strong>disini</strong></a>&nbsp;untuk me-register NIK anda</p>-->
	  </form>
	</div>
	<div id="footer">
		Copyright &copy; 2014
	</div>
</div>
</center>

</body>
</html>