<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja" xmlns:fb="http://ogp.me/ns/fb#"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
$ua=$_SERVER['HTTP_USER_AGENT'];
if((strpos($ua,'iPhone')!==false)||(strpos($ua,'iPod')!==false)||(strpos($ua,'Android')!==false)){
echo '<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />';
}else{
echo '<meta name="viewport" content="width=1366">';
}
?>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="description" content="" />
<meta name="keywords" content="" />

<title><%IMAGEPATH></title>

<link href="css/common.css" rel="stylesheet" type="text/css" media="all" />

</head>
<body>

<img src="<%IMAGEPATH>" alt="" />

</body>
</html>
