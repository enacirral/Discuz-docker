<?php if(!defined('UC_ROOT')) exit('Access Denied');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo UC_CHARSET;?>" />
<title>UCenter Administrator's Control Panel</title>
<link rel="stylesheet" href="images/admincp.css" type="text/css" media="all" />
<meta content="Comsenz Inc." name="Copyright" />
</head>
<body scroll="no">
<table cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
		<td colspan="2" height="69"><iframe src="<?php echo UC_ADMINSCRIPT;?>?m=frame&a=header&sid=<?php echo $sid;?>" name="header" width="100%" height="69" scrolling="no" frameborder="0"></iframe></td>
	</tr>
	<tr>
		<td valign="top" width="160"><iframe src="<?php echo UC_ADMINSCRIPT;?>?m=frame&a=menu&sid=<?php echo $sid;?>" name="menu" target="main" width="160" height="100%" scrolling="no" frameborder="0"></iframe></td>
		<td valign="top"><iframe src="<?php echo $mainurl;?>" name="main" width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow:visible;"></iframe></td>
	</tr>
</table>
</body>
</html>