<!DOCTYPE html>
<html>
<head>
  <meta charset="utf8">
  <meta name="viewport" content="width=device-width, user-scalable=no">
  <link rel="stylesheet" type="text/css" href="public/css/style.css">
  <script language="javascript">
      document.title = "Camagru - Error 404";
  </script>
</head>
<body>
  <h1>Seems like your page doesn't exist anymore !</h1>
  <img id="error404" src=""></img>
</body>
</html>
<script type="text/javascript">
	let rand = Math.floor(Math.random() * (4 - 1) + 1);
	let img = document.querySelector("#error404");
	img.setAttribute("src", "https://profile.intra.42.fr/images/"+rand+"-sorry.gif");
</script>
