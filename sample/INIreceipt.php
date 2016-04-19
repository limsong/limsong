<?php

/* INIreceipt.php
 *
 * ���ݰ���(�ǽð� ���������ü, �������Ա�)�� ���� ���ݰ��� ������ ���� ��û�Ѵ�.
 * 
 *
 * http://www.inicis.com
 * http://support.inicis.com
 * Copyright (C) 2006 Inicis, Co. All rights reserved.
 */


	/**************************
	 * 1. ���̺귯�� ��Ŭ��� *
	 **************************/
	require("../libs/INILib.php");
	
	
	/***************************************
	 * 2. INIpay41 Ŭ������ �ν��Ͻ� ���� *
	 ***************************************/
	$inipay = new INIpay50;
	


	/*********************
	 * 3. �߱� ���� ���� *
	 *********************/
	$inipay->SetField("inipayhome"    ,"/home/ts/www/INIpay50/");	// �̴����� Ȩ���͸�
	$inipay->SetField("type"          ,"receipt"); 					// ����
	$inipay->SetField("pgid"          ,"INIphpRECP"); 			// ����
	$inipay->SetField("paymethod"     ,"CASH");					    // ���� (��û�з�)
	$inipay->SetField("currency"      ,$currency);				  // ȭ����� (����)
    /**************************************************************************************************
     * admin �� Ű�н����� �������Դϴ�. �����Ͻø� �ȵ˴ϴ�. 1111�� �κи� �����ؼ� ����Ͻñ� �ٶ��ϴ�.
     * Ű�н������ ���������� ������(https://iniweb.inicis.com)�� ��й�ȣ�� �ƴմϴ�. ������ �ֽñ� �ٶ��ϴ�.
     * Ű�н������ ���� 4�ڸ��θ� �����˴ϴ�. �� ���� Ű���� �߱޽� �����˴ϴ�.
     * Ű�н����� ���� Ȯ���Ͻ÷��� �������� �߱޵� Ű���� ���� readme.txt ������ ������ �ֽʽÿ�.
     **************************************************************************************************/
	$inipay->SetField("admin"         ,"1111"); 					  // Ű�н�����(�������̵� ���� ����)
	$inipay->SetField("debug"         ,"true"); 					  // �α׸��("true"�� �����ϸ� �󼼷αװ� ������.)
	$inipay->SetField("mid"           ,$mid); 						  // �������̵�
	$inipay->SetField("goodname"      ,$goodname);				// ��ǰ��
	$inipay->SetField("cr_price"      ,$cr_price);				// �� ���ݰ��� �ݾ�
	$inipay->SetField("sup_price"     ,$sup_price);				// ���ް���
	$inipay->SetField("tax"           ,$tax);						  // �ΰ���
	$inipay->SetField("srvc_price"    ,$srvc_price);			// �����
	$inipay->SetField("buyername"     ,$buyername);				// ������ ����
	$inipay->SetField("buyeremail"    ,$buyeremail);			// ������ �̸��� �ּ�
	$inipay->SetField("buyertel"      ,$buyertel);				// ������ ��ȭ��ȣ
	$inipay->SetField("reg_num"       ,$reg_num);					// ���ݰ����� �ֹε�Ϲ�ȣ
	$inipay->SetField("useopt"        ,$useopt);					// ���ݿ����� ����뵵 ("0" - �Һ��� �ҵ������, "1" - ����� ����������)
	$inipay->SetField("companynumber" ,$companynumber);			
	
	
	/****************
	 * 4. �߱� ��û *
	 ****************/
	$inipay->startAction();
	
	
	/********************************************************************************
	 * 5. �߱� ���                           	                 		*
	 *                                              	         		*
	 * ����ڵ� : $inipay->GetResult('ResultCode') ("00" �̸� ���� ����)	 		*
	 * ���ι�ȣ : $inipay->GetResult('ApplNum') (���ݿ����� ���� ���ι�ȣ) 		*
	 * ���γ�¥ : $inipay->GetResult('ApplDate') (YYYYMMDD)              	 		*
	 * ���νð� : $inipay->GetResult('ApplTime') (HHMMSS)                	 		*
	 * �ŷ���ȣ : $inipay->GetResult('TID')				    	 		*
	 * �����ݰ��� �ݾ� : $inipay->GetResult('CSHR_ApplPrice')			    	 		*
	 * ���ް��� : $inipay->GetResult('CSHR_SupplyPrice')		    	    	 		*
	 * �ΰ��� : $inipay->GetResult('CSHR_Tax')				    	 		*		
	 * ����� : $inipay->GetResult('CSHR_ServicePrice')			    	 		*
	 * ��뱸�� : $inipay->GetResult('CSHR_Type')                              	 		*
	 ********************************************************************************/
?>

<html>
<head>
<title>INIpay50 ���ݿ����� ���� ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="css/group.css" type="text/css">
<style>
body, tr, td {font-size:9pt; font-family:����,verdana; color:#433F37; line-height:19px;}
table, img {border:none}

/* Padding ******/ 
.pl_01 {padding:1 10 0 10; line-height:19px;}
.pl_03 {font-size:20pt; font-family:����,verdana; color:#FFFFFF; line-height:29px;}

/* Link ******/ 
.a:link  {font-size:9pt; color:#333333; text-decoration:none}
.a:visited { font-size:9pt; color:#333333; text-decoration:none}
.a:hover  {font-size:9pt; color:#0174CD; text-decoration:underline}

.txt_03a:link  {font-size: 8pt;line-height:18px;color:#333333; text-decoration:none}
.txt_03a:visited {font-size: 8pt;line-height:18px;color:#333333; text-decoration:none}
.txt_03a:hover  {font-size: 8pt;line-height:18px;color:#EC5900; text-decoration:underline}
</style>
<script>
	var openwin=window.open("childwin.html","childwin","width=299,height=149");
	openwin.close();
	
function showreceipt() // ���� ������ ���
{
	var showreceiptUrl = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/Cash_mCmReceipt.jsp?noTid=<?php echo($inipay->GetResult('TID')); ?>" + "&clpaymethod=22";
	window.open(showreceiptUrl,"showreceipt","width=380,height=540, scrollbars=no,resizable=no");
}

	
	
</script>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>
<body bgcolor="#FFFFFF" text="#242424" leftmargin=0 topmargin=15 marginwidth=0 marginheight=0 bottommargin=0 rightmargin=0><center> 
<table width="632" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="83" background="<?php 
    					// ���Ҽ��ܿ� ���� ��� �̹����� ���� �ȴ�
    					
    				if($inipay->GetResult('ResultCode') == "01"){
					echo "img/spool_top.gif";
				}
				else{
					echo "img/cash_top.gif";
				}
				
				?>"style="padding:0 0 0 64">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="3%" valign="top"><img src="../img/title_01.gif" width="8" height="27" vspace="5"></td>
          <td width="97%" height="40" class="pl_03"><font color="#FFFFFF"><b>���ݰ��� ������ �߱ް��</b></font></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td align="center" bgcolor="6095BC"><table width="620" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#FFFFFF" style="padding:0 0 0 56">
		  <table width="510" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="7"><img src="../img/life.gif" width="7" height="30"></td>
                <td background="../img/center.gif"><img src="../img/icon03.gif" width="12" height="10"> 
                  <b>���Բ��� ��û�Ͻ� ���ݿ����� �߱� �����Դϴ�. </b></td>
                <td width="8"><img src="../img/right.gif" width="8" height="30"></td>
              </tr>
            </table>
            <br>
            <table width="510" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="407"  style="padding:0 0 0 9"><img src="../img/icon.gif" width="10" height="11"> 
                  <strong><font color="433F37">�߱޳���</font></strong></td>
                <td width="103">&nbsp;</td>
              </tr>
              <tr> 
                <td colspan="2"  style="padding:0 0 0 23">
		  <table width="470" border="0" cellspacing="0" cellpadding="0">
                    
                    <tr> 
                      <td width="18" align="center"><img src="../img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="26">�� �� �� ��</td>
                      <td width="343"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td><?php echo($inipay->GetResult('ResultCode')); ?></td>
                            <td width='142' align='right'><a href='javascript:showreceipt();'><img src='../img/button_02.gif' width='94' height='24' border='0'></a></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="../img/line.gif"></td>
                    </tr>                    
                    <tr> 
                      <td width="18" align="center"><img src="../img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">�� �� �� ��</td>
                      <td width="343"><?php echo($inipay->GetResult('ResultMsg')); ?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="../img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width="18" align="center"><img src="../img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">�� �� �� ȣ</td>
                      <td width="343"><?php echo($inipay->GetResult('TID')); ?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="../img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width="18" align="center"><img src="../img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">�� �� �� ȣ</td>
                      <td width="343"><?php echo($inipay->GetResult('ApplNum')); ?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="../img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>�� �� �� ¥</td>
                      <td width='343'><?php echo($inipay->GetResult('ApplDate')); ?></td>
                    </tr>
                	    
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>�� �� �� ��</td>
                      <td width='343'><?php echo($inipay->GetResult('ApplTime')); ?></td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>�� ���ݰ����ݾ�</td>
                      <td width='343'><?php echo($inipay->GetResult('CSHR_ApplPrice')); ?> ��</td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>�� �� �� ��</td>
                      <td width='343'><?php echo($inipay->GetResult('CSHR_SupplyPrice')); ?> ��</td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>�� �� ��</td>
                      <td width='343'><?php echo($inipay->GetResult('CSHR_Tax')); ?> ��</td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>�� �� ��</td>
                      <td width='343'><?php echo($inipay->GetResult('CSHR_ServicePrice')); ?> ��</td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>�� �� �� ��</td>
                      <td width='343'><?php 
                      			if($inipay->GetResult('CSHR_Type') == "0")
                      			{
                      				echo "�ҵ������";
                      			}else{
                      				echo "����������";
                      			}
                      		      ?></td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    </tr>
                    
                    
                  </table></td>
              </tr>
            </table>
            <br>
           </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><img src="../img/bottom01.gif" width="632" height="13"></td>
  </tr>
</table>
</center></body>
</html>
