<html>
<head>

<!create classes for the program>
<style>
.button
{
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  background-color: #008CBA;
}

.button:hover
{
	background-color: #00008B;	
}
.button1
{  
  margin: 0;
  position: absolute;
  top: 30%;
  -ms-transform: translateX(350%);
  transform: translateX(350%);
}

.button2
{  
  margin: 0;
  position: absolute;
  top: 30%;
  -ms-transform: translateX(750%);
  transform: translateX(750%);
}

</style>

</head>
<body>

<!creates buttons and redirects to pages on click> 
<h1 style="text-align:center">Welcome to Uchitsya</h1>
<p style="text-align:center">Uchitsya is a program designed to enable school to be done online.</p>
<button onclick="register()" class="button button1" > Register</button>
<button onclick="login()" class="button button2">Login</button>

<script>
function register()
{
  location.href = "/Uchitsya/register.php";
}
</script>

<script>
function login()
{
  location.href = "/Uchitsya/login.php";
}
</script>

</body>
</html>