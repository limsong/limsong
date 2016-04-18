<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>admin System</title>
		<link rel="STYLESHEET" type="text/css" href="stylemain.css">
	</head>
	<style type="text/css">
		.toptab {
			margin-top:10%;
		}
		.input_out{
			height:15px;
			padding-top:2px;
			border:1px solid gray;
			background-color:#FFF;
		}
		.input_on{
			height:15px;
			padding-top:2px;
			border:1px solid #999;
			background-color:#ffff99;
		}
		.input_off{
			height:15px;
			padding-top:2px;
			border:1px solid gray;
			background-color:#FFF;
		}
		.input_move{
			height:15px;
			padding-top:2px;
			border:1px solid #999;
			background-color:#FFFF99;
		}
		.td1 {
			padding-left:55px;
		}
		.bottomtab {
			margin-top:30px;
		}
	</style>
	<script language=javascript>
	window.onload=function() {

		document.Login.UserName.focus();
	}
	function SetFocus(){
		if (document.Login.UserName.value=="")
			document.Login.UserName.focus();
		else
			document.Login.UserName.select();
	}
	function CheckForm(){
		if(document.Login.UserName.value==""){
			alert("게정을 입력하세요!");
			document.Login.UserName.focus();
			return false;
		}
		if(document.Login.Password.value==""){
			alert("비밀번호를 입력하세요!！");
			document.Login.Password.focus();
			return false;
		}
	}
	</script>
<body style="background-color: #f6f6f6;">
    <div style="width: 100%;height: 100%;float: left;">
        <table width="400" class="toptab" border="0" align="center" cellpadding="5" cellspacing="5">
            <tr>
                <td align="left">
                    <form action="login.php" method="post" name="Login" id="Login" onsubmit="return CheckForm(this);">
                        <table align="center" width="300"  border="0" cellpadding="0" cellspacing="2">
                            <tr>
                                <td width="40%" height="25" align="right"><img src="images/login_id.gif" width="84" height="22" alt=""></td>
                                <td height="25" colspan="2"><input name="UserName" class="input_out" type="text" id="UserName" value="" size="20" style="width:110px" onfocus="this.className='input_on';this.onmouseout=''" onblur="this.ClassName='input_off';this.onmouseout=function(){this.className='input_out'};" onmousemove="this.className='input_move'" onmouseout="this.className='input_out'">
                                </td>
                            </tr>
                            <tr>
                                <td width="40%" height="25" align="right"><img src="images/login_password.gif" width="84" height="23" alt=""></td>
                                <td height="25">
                                    <input name="Password" class="input_out" type="Password" value="" id="Password" size="20" style="width:110px" onfocus="this.className='input_on';this.onmouseout=''" onblur="this.className='input_off';this.onmouseout=function(){this.className='input_out'};" onmousemove="this.className='input_move'" onmouseout="this.className='input_out'">
                                <td height="25"><input type="Image" src="images/submit.gif" name="Submit" id="inpimg" /></td>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>

