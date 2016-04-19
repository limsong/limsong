<?php
/* INIsecurepay.php
 *
 * �̴����� �÷������� ���� ��û�� ������ ó���Ѵ�.
 * ���� ��û�� ó���Ѵ�.
 * �ڵ忡 ���� �ڼ��� ������ �Ŵ����� �����Ͻʽÿ�.
 * <����> �������� ������ �ݵ�� üũ�ϵ����Ͽ� �����ŷ��� �����Ͽ� �ֽʽÿ�.
 *  
 * http://www.inicis.com
 * Copyright (C) 2006 Inicis Co., Ltd. All rights reserved.
 */

  /****************************
   * 0. ���� ����             *
   ****************************/
  session_start();								//����:���� �ֻ�ܿ� ��ġ�����ּ���!!

	/**************************
	 * 1. ���̺귯�� ��Ŭ��� *
	 **************************/
	require("../libs/INILib.php");
	
	
	/***************************************
	 * 2. INIpay50 Ŭ������ �ν��Ͻ� ���� *
	 ***************************************/
	$inipay = new INIpay50;

	/*********************
	 * 3. ���� ���� ���� *
	 *********************/
	$inipay->SetField("inipayhome", "/home/ts/www/INIpay50"); // �̴����� Ȩ���͸�(�������� �ʿ�)
	$inipay->SetField("type", "securepay");                         // ���� (���� ���� �Ұ�)
	$inipay->SetField("pgid", "INIphp".$pgid);                      // ���� (���� ���� �Ұ�)
	$inipay->SetField("subpgip","203.238.3.10");                    // ���� (���� ���� �Ұ�)
	$inipay->SetField("admin", $_SESSION['INI_ADMIN']);    // Ű�н�����(�������̵� ���� ����)
	$inipay->SetField("debug", "true");                             // �α׸��("true"�� �����ϸ� �󼼷αװ� ������.)
	$inipay->SetField("uid", $uid);                                 // INIpay User ID (���� ���� �Ұ�)
  $inipay->SetField("goodname", $goodname);                       // ��ǰ�� 
	$inipay->SetField("currency", $currency);                       // ȭ�����

	$inipay->SetField("mid", $_SESSION['INI_MID']);        // �������̵�
	$inipay->SetField("rn", $_SESSION['INI_RN']);          // �������� �������� RN��
	$inipay->SetField("price", $_SESSION['INI_PRICE']);		// ����
	$inipay->SetField("enctype", $_SESSION['INI_ENCTYPE']);// ���� (���� ���� �Ұ�)


     /*----------------------------------------------------------------------------------------
       price ���� �߿䵥���ʹ�
       ���������� ���������θ� �ݵ�� Ȯ���ϼž� �մϴ�.

       ���� ��û���������� ��û�� �ݾװ�
       ���� ������ �̷���� �ݾ��� �ݵ�� ���Ͽ� ó���Ͻʽÿ�.

       ��ġ �޴��� 2���� ���� ó�������� �ۼ��κ��� ���Ȱ�� �κ��� Ȯ���Ͻñ� �ٶ��ϴ�.
       ������������: �̴Ͻý�Ȩ������->��������������ڷ��->��Ÿ�ڷ�� ��
                      '���� ó�� ������ �� ���� �ݾ� ���� ������ ���� üũ' ������ �����Ͻñ� �ٶ��ϴ�.
       ����)
       �� ��ǰ ���� ������ OriginalPrice �ϰ�  �� ���� ������ �����ϴ� �Լ��� Return_OrgPrice()�� �����ϸ�
       ���� ���� �����Ͽ� �����ݰ� ������������ Post�Ǿ� �Ѿ�� ������ �� �Ѵ�.

		$OriginalPrice = Return_OrgPrice();
		$PostPrice = $_SESSION['INI_PRICE']; 
		if ( $OriginalPrice != $PostPrice )
		{
			//���� ������ �ߴ��ϰ�  �ݾ� ���� ���ɼ��� ���� �޽��� ��� ó��
			//ó�� ���� 
		}

      ----------------------------------------------------------------------------------------*/
	$inipay->SetField("buyername", $buyername);       // ������ ��
	$inipay->SetField("buyertel",  $buyertel);        // ������ ����ó(�޴��� ��ȣ �Ǵ� ������ȭ��ȣ)
	$inipay->SetField("buyeremail",$buyeremail);      // ������ �̸��� �ּ�
	$inipay->SetField("paymethod", $paymethod);       // ���ҹ�� (���� ���� �Ұ�)
	$inipay->SetField("encrypted", $encrypted);       // ��ȣ��
	$inipay->SetField("sessionkey",$sessionkey);      // ��ȣ��
	$inipay->SetField("url", "http://www.your_domain.co.kr"); // ���� ���񽺵Ǵ� ���� SITE URL�� �����Ұ�
	$inipay->SetField("cardcode", $cardcode);         // ī���ڵ� ����
	$inipay->SetField("parentemail", $parentemail);   // ��ȣ�� �̸��� �ּ�(�ڵ��� , ��ȭ�����ÿ� 14�� �̸��� ���� �����ϸ�  �θ� �̸��Ϸ� ���� �����뺸 �ǹ�, �ٸ����� ���� ���ÿ� ���� ����)
	
	/*-----------------------------------------------------------------*
	 * ������ ���� *                                                   *
	 *-----------------------------------------------------------------*
	 * �ǹ������ �ϴ� ������ ��쿡 ���Ǵ� �ʵ���̸�               *
	 * �Ʒ��� ������ INIsecurepay.html ���������� ����Ʈ �ǵ���        *
	 * �ʵ带 ����� �ֵ��� �Ͻʽÿ�.                                  *
	 * ������ ������ü�� ��� �����ϼŵ� �����մϴ�.                   *
	 *-----------------------------------------------------------------*/
	$inipay->SetField("recvname",$recvname);	// ������ ��
	$inipay->SetField("recvtel",$recvtel);		// ������ ����ó
	$inipay->SetField("recvaddr",$recvaddr);	// ������ �ּ�
	$inipay->SetField("recvpostnum",$recvpostnum);  // ������ �����ȣ
	$inipay->SetField("recvmsg",$recvmsg);		// ���� �޼���

  $inipay->SetField("joincard",$joincard);  // ����ī���ڵ�
  $inipay->SetField("joinexpire",$joinexpire);    // ����ī����ȿ�Ⱓ
  $inipay->SetField("id_customer",$id_customer);    //user_id

	
	/****************
	 * 4. ���� ��û *
	 ****************/
	$inipay->startAction();
	
	/****************************************************************************************************************
	 * 5. ����  ���                  
	 *      												
	 *  1 ��� ���� ���ܿ� ����Ǵ� ���� ��� ������                                                      		
	 * 	�ŷ���ȣ : $inipay->GetResult('TID')                                       					
	 * 	����ڵ� : $inipay->GetResult('ResultCode') ("00"�̸� ���� ����)           				
	 * 	������� : $inipay->GetResult('ResultMsg') (���Ұ���� ���� ����)          			
	 * 	���ҹ�� : $inipay->GetResult('PayMethod') (�Ŵ��� ����)  								
	 * 	�����ֹ���ȣ : $inipay->GetResult('MOID')										
	 *	�����Ϸ�ݾ� : $inipay->GetResult('TotPrice')							
	 *																					
	 * ���� �Ǵ� �ݾ� =>����ǰ���ݰ�  ��������ݾװ� ���Ͽ� �ݾ��� �������� �ʴٸ�  
	 * ���� �ݾ��� �������� �ǽɵ����� �������� ó���� �����ʵ��� ó�� �ٶ��ϴ�. (�ش� �ŷ� ��� ó��) 
	 *													
	 *														
	 *  2. �ſ�ī��,ISP,�ڵ���, ��ȭ ����, ���������ü, OK CASH BAG Point ���� ��� ������        			
	 *      (�������Ա� , ��ȭ ��ǰ�� ����) 								        
	 * 	�̴Ͻý� ���γ�¥ : $inipay->GetResult('ApplDate') (YYYYMMDD)
	 * 	�̴Ͻý� ���νð� : $inipay->GetResult('ApplTime') (HHMMSS)  
	 *  														
	 *  3. �ſ�ī�� ���� ��� ������ 
         *												
	 * 	�ſ�ī�� ���ι�ȣ : $inipay->GetResult('ApplNum')                         				
	 * 	�ҺαⰣ : $inipay->GetResult('CARD_Quota')                                 				
	 * 	�������Һ� ���� : $inipay->GetResult('CARD_Interest') ("1"�̸� �������Һ�) 			
	 * 	�ſ�ī��� �ڵ� : $inipay->GetResult('CARD_Code') (�Ŵ��� ����)             	
	 * 	ī��߱޻� �ڵ� : $inipay->GetResult('CARD_BankCode') (�Ŵ��� ����)       	
	 * 	�������� ���࿩�� : $inipay->GetResult('CARD_AuthType') ("00"�̸� ����)      					
	 *      ���� �̺�Ʈ ���� ���� : $inipay->GetResult('EventCode')                    		
	 *	                                                                       
	 *      ** �޷����� �� ��ȭ�ڵ��  ȯ�� ���� **                           
	 *	�ش� ��ȭ�ڵ� : $inipay->GetResult('OrgCurrency')                               
	 *	ȯ�� : $inipay->GetResult('ExchangeRate')	                                    
	 *														
	 *      �Ʒ��� "�ſ�ī�� �� OK CASH BAG ���հ���" �Ǵ�"�ſ�ī�� ���ҽÿ� OK CASH BAG����"�ÿ� �߰��Ǵ� ������   
	 * 	OK Cashbag ���� ���ι�ȣ : $inipay->GetResult('OCB_SaveApplNum')           					
	 * 	OK Cashbag ��� ���ι�ȣ : $inipay->GetResult('OCB_PayApplNum')            				
	 * 	OK Cashbag �����Ͻ� : $inipay->GetResult('OCB_ApplDate') (YYYYMMDDHHMMSS)   		
	 * 	OCB ī���ȣ : $inipay->GetResult('OCB_Num')			   						
	 * 	OK Cashbag ���հ���� �ſ�ī�� ���ұݾ� : $inipay->GetResult('CARD_ApplPrice')     	
	 * 	OK Cashbag ���հ���� ����Ʈ ���ұݾ� : $inipay->GetResult('OCB_PayPrice')       	
	 *	                                                                                
	 * 4. �ǽð� ������ü ���� ��� ������                                               
	 *                                                                                 
	 * 	�����ڵ� : $inipay->GetResult('ACCT_BankCode')                                
	 *	���ݿ����� �������ڵ� : $inipay->GetResult('CSHR_ResultCode')
	 *	���ݿ����� ���౸���ڵ� : $inipay->GetResult('CSHR_Type') 
	 *														*
	 * 5. OK CASH BAG ���������� �̿�ÿ���  ���� ��� ������		
	 * 	OK Cashbag ���� ���ι�ȣ : $inipay->GetResult('OCB_SaveApplNum')           					
	 * 	OK Cashbag ��� ���ι�ȣ : $inipay->GetResult('OCB_PayApplNum')            				
	 * 	OK Cashbag �����Ͻ� : $inipay->GetResult('OCB_ApplDate') (YYYYMMDDHHMMSS)   		
	 * 	OCB ī���ȣ : $inipay->GetResult('OCB_Num')			   						
	 *														
         * 6. ������ �Ա� ���� ��� ������							                        *
	 * 	������� ä���� ���� �ֹι�ȣ : $inipay->GetResult('VACT_RegNum')              					*
	 * 	������� ��ȣ : $inipay->GetResult('VACT_Num')                                					*
	 * 	�Ա��� ���� �ڵ� : $inipay->GetResult('VACT_BankCode')                           					*
	 * 	�Աݿ����� : $inipay->GetResult('VACT_Date') (YYYYMMDD)                      					*
	 * 	�۱��� �� : $inipay->GetResult('VACT_InputName')                                  					*
	 * 	������ �� : $inipay->GetResult('VACT_Name')                                  					*
	 *														*	
	 * 7. �ڵ���, ��ȭ ���� ��� ������( "���� ���� �ڼ��� ����"���� �ʿ� , ���������� �ʿ���� ������)             *
         * 	��ȭ���� ����� �ڵ� : $inipay->GetResult('HPP_GWCode')                        					*
	 *														*	
	 * 8. �ڵ��� ���� ��� ������								                        *
	 * 	�޴��� ��ȣ : $inipay->GetResult('HPP_Num') (�ڵ��� ������ ���� �޴�����ȣ)       					*
	 *														*
	 * 9. ��ȭ ���� ��� ������								                        *
   * 	��ȭ��ȣ : $inipay->GetResult('ARSB_Num') (��ȭ������  ���� ��ȭ��ȣ)      						*
   * 														*		
   * 10. ��ȭ ��ǰ�� ���� ��� ������							                        *
   * 	���� ���� ID : $inipay->GetResult('CULT_UserID')	                           					*
   *														*
   * 11. K-merce ��ǰ�� ���� ��� ������ (K-merce ID, ƾĳ�� ���̵� ������)                                     *
   *      K-merce ID : $inipay->GetResult('CULT_UserID')                                                                       *
   *                                                                                                              *
   * 12. ��� ���� ���ܿ� ���� ���� ���нÿ��� ���� ��� ������ 							*
   * 	�����ڵ� : $inipay->GetResult('ResultErrorCode')                             					*
   * 														*
   * 13.���ݿ����� �߱� ����ڵ� (���������ü�ÿ��� ����)							*
   *    $inipay->GetResult('CSHR_ResultCode')                                                                                     *
   *                                                                                                              *
   * 14.ƾĳ�� �ܾ� ������                                							*
   *    $inipay->GetResult('TEEN_Remains')                                           	                                *
   *	ƾĳ�� ID : $inipay->GetResult('CULT_UserID')													*
   * 15.���ӹ�ȭ ��ǰ��							*
   *	��� ī�� ���� : $inipay->GetResult('GAMG_Cnt')                 					        *
   *														*
   ****************************************************************************************************************/
         
          

	
	
	/*******************************************************************
	 * 7. DB���� ���� �� �������                                      *
	 *                                                                 *
	 * ���� ����� DB � �����ϰų� ��Ÿ �۾��� �����ϴٰ� �����ϴ�  *
	 * ���, �Ʒ��� �ڵ带 �����Ͽ� �̹� ���ҵ� �ŷ��� ����ϴ� �ڵ带 *
	 * �ۼ��մϴ�.                                                     *
	 *******************************************************************/
	/*
	$cancelFlag = "false";

	// $cancelFlag�� "ture"�� �����ϴ� condition �Ǵ��� ����������
	// �����Ͽ� �ֽʽÿ�.

	if($cancelFlag == "true")
	{
		$TID = $inipay->GetResult("TID");
		$inipay->SetField("type", "cancel"); // ����
		$inipay->SetField("tid", $TID); // ����
		$inipay->SetField("cancelmsg", "DB FAIL"); // ��һ���
		$inipay->startAction();
		if($inipay->GetResult('ResultCode') == "00")
		{
      $inipay->MakeTXErrMsg(MERCHANT_DB_ERR,"Merchant DB FAIL");
		}
	}
	*/
		
	
?>


<!-------------------------------------------------------------------------------------------------------
 *  													*
 *       												*
 *        												*
 *	�Ʒ� ������ ���� ����� ���� ��� ������ �����Դϴ�. 				                *
 *													*
 *													*
 *													*
 -------------------------------------------------------------------------------------------------------->
 
<html>
<head>
<title>INIpay50 ���������� ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="css/group.css" type="text/css">
<style>
body, tr, td {font-size:10pt; font-family:����,verdana; color:#433F37; line-height:19px;}
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
	
	function show_receipt(tid) // ������ ���
	{
		if("<?php echo ($inipay->GetResult('ResultCode')); ?>" == "00")
		{
			var receiptUrl = "https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid=" + "<?php echo($inipay->GetResult('TID')); ?>" + "&noMethod=1";
			window.open(receiptUrl,"receipt","width=430,height=700");
		}
		else
		{
			alert("�ش��ϴ� ���������� �����ϴ�");
		}
	}
		
	function errhelp() // �� �������� ���
	{
		var errhelpUrl = "http://www.inicis.com/ErrCode/Error.jsp?result_err_code=" + "<?php echo($inipay->GetResult('ResultErrorCode')); ?>" + "&mid=" + "<?php echo($inipay->GetResult('MID')); ?>" + "&tid=<?php echo($inipay->GetResult('TID')); ?>" + "&goodname=" + "<?php echo($inipay->GetResult('GoodName')); ?>" + "&price=" + "<?php echo($inipay->GetResult('TotPrice')); ?>" + "&paymethod=" + "<?php echo($inipay->GetResult('PayMethod')); ?>" + "&buyername=" + "<?php echo($inipay->GetResult('BuyerName')); ?>" + "&buyertel=" + "<?php echo($inipay->GetResult('BuyerTel')); ?>" + "&buyeremail=" + "<?php echo($inipay->GetResult('BuyerEmail')); ?>" + "&codegw=" + "<?php echo($inipay->GetResult('HPP_GWCode')); ?>";
		window.open(errhelpUrl,"errhelp","width=520,height=150, scrollbars=yes,resizable=yes");
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
    <td height="85" background=<?php 

/*-------------------------------------------------------------------------------------------------------
 * ���� ����� ���� ��� �̹����� ���� �ȴ�								*
 * 	 ��. ���� ���� �ÿ� "img/spool_top.gif" �̹��� ���						*
 *       ��. ���� ����� ���� ��� �̹����� ����							*
 *       	1. �ſ�ī�� 	- 	"img/card.gif"							*
 *		2. ISP		-	"img/card.gif"							*
 *		3. �������	-	"img/bank.gif"							*
 *		4. �������Ա�	-	"img/bank.gif"							*
 *		5. �ڵ���	- 	"img/hpp.gif"							*
 *		6. ��ȭ���� (ars��ȭ ����)	-	"img/phone.gif"					*
 *		7. ��ȭ���� (�޴���ȭ����)	-	"img/phone.gif"					*
 *		8. OK CASH BAG POINT		-	"img/okcash.gif"				*
 *		9. ��ȭ��ǰ��		-	"img/ticket.gif"					*
 *              10. K-merce ��ǰ�� 	- 	"img/kmerce.gif"                                        *
 *		11. ƾĳ�� ����		- 	"img/teen_top.gif"                                      *
 *              12. ���ӹ�ȭ ��ǰ��    -       "img/dgcl_top.gif"                                       *
 -------------------------------------------------------------------------------------------------------*/
    					
    				if($inipay->GetResult('ResultCode') == "01"){
					echo "img/spool_top.gif";
				}
				else{
					
    					switch($inipay->GetResult('PayMethod')){
	
						case(Card): // �ſ�ī��
							echo "img/card.gif";
							break;
						case(VCard): // ISP
							echo "img/card.gif";
							break;
						case(HPP): // �޴���
							echo "img/hpp.gif";
							break;
						case(Ars1588Bill): // 1588
							echo "img/phone.gif";
							break;
						case(PhoneBill): // ����
							echo "img/phone.gif";
							break;
						case(OCBPoint): // OKCASHBAG
							echo "img/okcash.gif";
							break;
						case(DirectBank):  // ���������ü
							echo "img/bank.gif";
							break;		
						case(VBank):  // ������ �Ա� ����
							echo "img/bank.gif";
							break;
						case(Culture):  // ��ȭ��ǰ�� ����
							echo "img/ticket.gif";
							break;
						case(KMC_):	// K-merce ��ǰ�� ����
							echo "img/kmerce.gif";
							break;
						case(TEEN):	// ƾĳ�� ����
							echo "img/teen_top.gif";
							break;
						case(DGCL):	// ���ӹ�ȭ ��ǰ��
							echo "img/dgcl_top.gif";
							break;

							
						default: // ��Ÿ ���Ҽ����� ���
							echo "img/card.gif";
							break;

					}
				}
					
    				?> style="padding:0 0 0 64">
    				
<!-------------------------------------------------------------------------------------------------------
 *													*
 *  �Ʒ� �κ��� ��� ���������� �������� ����޼��� ��� �κ��Դϴ�.					*
 *  													*
 *	1. $inipay->GetResult('ResultCode') 	(�� �� �� ��) 							*
 *  	2. $inipay->GetResult('ResultMsg')		(��� �޼���)							*
 *  	3. $inipay->GetResult('PayMethod')		(�� �� �� ��)							*
 *  	4. $inipay->GetResult('TID')		(�� �� �� ȣ)							*
 *  	5. $inipay->GetResult('MOID')  		(�� �� �� ȣ)							*
 -------------------------------------------------------------------------------------------------------->
 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="3%" valign="top"><img src="img/title_01.gif" width="8" height="27" vspace="5"></td>
          <td width="97%" height="40" class="pl_03"><font color="#FFFFFF"><b>�������</b></font></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td align="center" bgcolor="6095BC">
      <table width="620" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#FFFFFF" style="padding:0 0 0 56">
		  <table width="510" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="7"><img src="img/life.gif" width="7" height="30"></td>
                <td background="img/center.gif"><img src="img/icon03.gif" width="12" height="10">
                
                <!-------------------------------------------------------------------------------------------------------
                 * 1. $inipay->GetResult('ResultCode') 										*	
                 *       ��. �� �� �� ��: "00" �� ��� ���� ����[�������Ա��� ��� - ������ �������Ա� ��û�� �Ϸ�]	*
                 *       ��. �� �� �� ��: "00"���� ���� ��� ���� ����  						*
                 --------------------------------------------------------------------------------------------------------> 
                  <b><?php if($inipay->GetResult('ResultCode') == "00" && $inipay->GetResult('PayMethod') == "VBank"){ echo "������ �������Ա� ��û�� �Ϸ�Ǿ����ϴ�.";}
                  	   else if($inipay->GetResult('ResultCode') == "00"){ echo "������ ������û�� �����Ǿ����ϴ�.";}
                           else{ echo "������ ������û�� ���еǾ����ϴ�.";} ?> </b></td>
                <td width="8"><img src="img/right.gif" width="8" height="30"></td>
              </tr>
            </table>
            <br>
            <table width="510" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="407"  style="padding:0 0 0 9"><img src="img/icon.gif" width="10" height="11"> 
                  <strong><font color="433F37">��������</font></strong></td>
                <td width="103">&nbsp;</td>                
              </tr>
              <tr> 
                <td colspan="2"  style="padding:0 0 0 23">
		  <table width="470" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    
                <!-------------------------------------------------------------------------------------------------------
                 * 2. $inipay->GetResult('PayMethod') 										*
                 *       ��. ���� ����� ���� ��									*
                 *       	1. �ſ�ī�� 	- 	Card								*
                 *		2. ISP		-	VCard								*
                 *		3. �������	-	DirectBank							*
                 *		4. �������Ա�	-	VBank								*
                 *		5. �ڵ���	- 	HPP								*
                 *		6. ��ȭ���� (ars��ȭ ����)	-	Ars1588Bill					*
                 *		7. ��ȭ���� (�޴���ȭ����)	-	PhoneBill					*
                 *		8. OK CASH BAG POINT		-	OCBPoint					*
                 *		9. ��ȭ��ǰ��			-	Culture						*
                 *		10. K-merce ��ǰ�� 		- 	KMC_                                            *
                 *              11. ƾĳ�� ���� 		- 	TEEN						*
                 *		12. ���ӹ�ȭ ��ǰ�� 		-	DGCL                                            *
                 *-------------------------------------------------------------------------------------------------------->
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">�� �� �� ��</td>
                      <td width="343"><?php echo($inipay->GetResult('PayMethod')); ?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="26">�� �� �� ��</td>
                      <td width="343"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td><?php echo($inipay->GetResult('ResultCode')); ?></td>
                            <td width='142' align='right'>
                          
                <!-------------------------------------------------------------------------------------------------------
                 * 3. $inipay->GetResult('ResultCode') ���� ���� "������ ����" �Ǵ� "���� ���� �ڼ��� ����" ��ư ���		*
                 *       ��. ���� �ڵ��� ���� "00"�� ��쿡�� "������ ����" ��ư ���					*
                 *       ��. ���� �ڵ��� ���� "00" ���� ���� ��쿡�� "���� ���� �ڼ��� ����" ��ư ���			*
                 -------------------------------------------------------------------------------------------------------->
		<!-- ���а�� �� ���� ��ư ��� -->
                            	<?php
                            		if($inipay->GetResult('ResultCode') == "00"){
                				echo "<a href='javascript:show_receipt();'><img src='../img/button_02.gif' width='94' height='24' border='0'></a>";
                			}
                			else{
                            			echo "<a href='javascript:errhelp();'><img src='../img/button_01.gif' width='142' height='24' border='0'></a>";
                            		}
                                                    	
                            	?>                    </td>
                          </tr>
                        </table></td>
                    </tr>
                
                <!-------------------------------------------------------------------------------------------------------
                 * 4. $inipay->GetResult('ResultMsg') 										*
                 *    - ��� ������ ���� �ش� ���нÿ��� "[�����ڵ�] ���� �޼���" ���·� ���� �ش�.                     *
                 *		��> [9121]����Ȯ�ο���									*
                 -------------------------------------------------------------------------------------------------------->
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">�� �� �� ��</td>
                      <td width="343"><?php echo($inipay->GetResult('ResultMsg')); ?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    
                <!-------------------------------------------------------------------------------------------------------
                 * 5. $inipay->GetResult('TID')											*
                 *    - �̴Ͻý��� �ο��� �ŷ� ��ȣ -��� �ŷ��� ������ �� �ִ� Ű�� �Ǵ� ��			        *
                 -------------------------------------------------------------------------------------------------------->
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">�� �� �� ȣ</td>
                      <td width="343"><?php echo($inipay->GetResult('TID')); ?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    
                <!-------------------------------------------------------------------------------------------------------
                 * 6. $inipay->GetResult('MOID')											*
                 *    - �������� �Ҵ��� �ֹ���ȣ 									*
                 -------------------------------------------------------------------------------------------------------->
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">�� �� �� ȣ</td>
                      <td width="343"><?php echo($inipay->GetResult('MOID')); ?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    
                <!-------------------------------------------------------------------------------------------------------
                 * 7. $inipay->GetResult('TotPrice')										*
                 *    - �����Ϸ� �ݾ�                  									*
	 			 *																					*
	 			 * ���� �Ǵ� �ݾ� =>����ǰ���ݰ�  ��������ݾװ� ���Ͽ� �ݾ��� �������� �ʴٸ�  *
	 			 * ���� �ݾ��� �������� �ǽɵ����� �������� ó���� �����ʵ��� ó�� �ٶ��ϴ�. (�ش� �ŷ� ��� ó��) *
	 			 *																									*
                 -------------------------------------------------------------------------------------------------------->
                     
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">�����Ϸ�ݾ�</td>
                      <td width="343"><?php echo($inipay->GetResult('TotPrice')); ?> ��</td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>


<?php                    
                    

	/*-------------------------------------------------------------------------------------------------------
	 *													*
	 *  �Ʒ� �κ��� ���� ���ܺ� ��� �޼��� ��� �κ��Դϴ�.    						*	
	 *													*
	 *  1.  �ſ�ī�� , ISP ���� ��� ��� (OK CASH BAG POINT ���� ���� ���� )				*
	 -------------------------------------------------------------------------------------------------------*/

	if($inipay->GetResult('PayMethod') == "Card" || $inipay->GetResult('PayMethod') == "VCard" ){
		
		echo "		
				<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�ſ�ī���ȣ</td>
                    		  <td width='343'>" .$inipay->GetResult('CARD_Num'). "****</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
				<tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>�� �� �� ¥</td>
                                  <td width='343'>" .$inipay->GetResult('ApplDate'). "</td>
                                </tr>
                                <tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>
                                <tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>�� �� �� ��</td>
                                  <td width='343'>" .$inipay->GetResult('ApplTime'). "</td>
                                </tr>                	    
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�� �� �� ȣ</td>
                    		  <td width='343'>" .$inipay->GetResult('ApplNum'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�� �� �� ��</td>
                    		  <td width='343'>" .$inipay->GetResult('CARD_Quota')."����&nbsp;<b><font color=red>".$interest. "</font></b></td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>ī �� �� ��</td>
                    		  <td width='343'>" .$inipay->GetResult('CARD_Code'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>ī��߱޻�</td>
                    		  <td width='343'>" .$inipay->GetResult('CARD_BankCode'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3'>&nbsp;</td>
                    		</tr>
                    		<tr> 
                		  <td style='padding:0 0 0 9' colspan='3'><img src='../img/icon.gif' width='10' height='11'> 
        	          	  <strong><font color='433F37'>�޷����� ����</font></strong></td>
                		</tr>
                		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�� ȭ �� ��</td>
                    		  <td width='343'>" .$inipay->GetResult('OrgCurrency'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>ȯ    ��</td>
                    		  <td width='343'>" .$inipay->GetResult('ExchangeRate'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>                    		
                    		<tr> 
                    		  <td height='1' colspan='3'>&nbsp;</td>
                    		</tr>
                    		<tr> 
                		  <td style='padding:0 0 0 9' colspan='3'><img src='../img/icon.gif' width='10' height='11'> 
        	          	  <strong><font color='433F37'>OK CASHBAG ���� �� ��볻��</font></strong></td>
                		</tr>
                		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>ī �� �� ȣ</td>
                    		  <td width='343'>" .$inipay->GetResult('OCB_Num'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>���� ���ι�ȣ</td>
                    		  <td width='343'>" .$inipay->GetResult('OCB_SaveApplNum'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>��� ���ι�ȣ</td>
                    		  <td width='343'>" .$inipay->GetResult('OCB_PayApplNum'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�� �� �� ��</td>
                    		  <td width='343'>" .$inipay->GetResult('OCB_ApplDate'). "</td>
                    		</tr>
                		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>����Ʈ���ұݾ�</td>
                    		  <td width='343'>" .$inipay->GetResult('OCB_PayPrice'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>";
                    
          }
        
        /*-------------------------------------------------------------------------------------------------------
	 *													*
	 *  �Ʒ� �κ��� ���� ���ܺ� ��� �޼��� ��� �κ��Դϴ�.    						*	
	 *													*
	 *  2.  ������°��� ��� ��� 										*
	 -------------------------------------------------------------------------------------------------------*/
	 
          else if($inipay->GetResult('PayMethod') == "DirectBank"){
          	
          	echo "		
          			<tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>�� �� �� ¥</td>
                                  <td width='343'>" .$inipay->GetResult('ApplDate'). "</td>
                                </tr>
                                <tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>
                                <tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>�� �� �� ��</td>
                                  <td width='343'>" .$inipay->GetResult('ApplTime'). "</td>
                                </tr>
                                <tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>
                                <tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>�� �� �� ��</td>
                                  <td width='343'>" .$inipay->GetResult('ACCT_BankCode'). "</td>
                                </tr>
                                <tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>
                                <tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>���ݿ�����<br>�߱ް���ڵ�</td>
                                  <td width='343'>" .$inipay->GetResult('CSHR_ResultCode'). "</td>
                                </tr>
                                <tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>
				<tr>
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>���ݿ�����<br>�߱ޱ����ڵ�</td>
                                  <td width='343'>" .$inipay->GetResult('CSHR_Type'). " <font color=red><b>(0 - �ҵ������, 1 - ����������)</b></font></td>
                                </tr>
                                <tr>
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>";
          }
          
        /*-------------------------------------------------------------------------------------------------------
	 *													*
	 *  �Ʒ� �κ��� ���� ���ܺ� ��� �޼��� ��� �κ��Դϴ�.    						*	
	 *													*
	 *  3.  �������Ա� �Ա� ���� ��� ��� (���� ������ �ƴ� �Ա� ���� ���� ����)				*
	 -------------------------------------------------------------------------------------------------------*/
	 
          else if($inipay->GetResult('PayMethod') == "VBank"){
          	
          	echo "		
          			<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�Աݰ��¹�ȣ</td>
                    		  <td width='343'>" .$inipay->GetResult('VACT_Num'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�Ա� �����ڵ�</td>
                    		  <td width='343'>" .$inipay->GetResult('VACT_BankCode'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>������ ��</td>
                    		  <td width='343'>" .$inipay->GetResult('VACT_Name'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�۱��� ��</td>
                    		  <td width='343'>" .$inipay->GetResult('VACT_InputName'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�۱��� �ֹι�ȣ</td>
                    		  <td width='343'>" .$inipay->GetResult('VACT_RegNum'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>��ǰ �ֹ���ȣ</td>
                    		  <td width='343'>" .$inipay->GetResult('MOID'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�۱� ����</td>
                    		  <td width='343'>" .$inipay->GetResult('VACT_Date'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                            <tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�۱� �ð�</td>
                    		  <td width='343'>" .$inipay->GetResult('VACT_Time'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>";
          }
          
        /*-------------------------------------------------------------------------------------------------------
	 *													*
	 *  �Ʒ� �κ��� ���� ���ܺ� ��� �޼��� ��� �κ��Դϴ�.    						*	
	 *													*
	 *  4.  �ڵ��� ���� 											*
	 -------------------------------------------------------------------------------------------------------*/
	 
          else if($inipay->GetResult('PayMethod') == "HPP"){
          	
          	echo "		
          			
          			<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�޴�����ȣ</td>
                    		  <td width='343'>" .$inipay->GetResult('HPP_Num'). "</td>
                    		</tr>
                    		<tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>
                    		<tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>�� �� �� ¥</td>
                                  <td width='343'>" .$inipay->GetResult('ApplDate'). "</td>
                                </tr>
                                <tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>
                                <tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>�� �� �� ��</td>
                                  <td width='343'>" .$inipay->GetResult('ApplTime'). "</td>
                                </tr>
				<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>";
          }
          
        /*-------------------------------------------------------------------------------------------------------
	 *													*
	 *  �Ʒ� �κ��� ���� ���ܺ� ��� �޼��� ��� �κ��Դϴ�.    						*	
	 *													*
	 *  5.  ��ȭ ���� 											*
	 -------------------------------------------------------------------------------------------------------*/
	 
         else if($inipay->GetResult('PayMethod') == "Ars1588Bill" || $inipay->GetResult('PayMethod') == "PhoneBill"){
                    	
                echo " 		
                		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�� ȭ �� ȣ</td>
                    		  <td width='343'>" .$inipay->GetResult('ARSB_Num'). "</td>
                    		</tr>
                    		<tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>
                		<tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>�� �� �� ¥</td>
                                  <td width='343'>" .$inipay->GetResult('ApplDate'). "</td>
                                </tr>
                                <tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>
                                <tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>�� �� �� ��</td>
                                  <td width='343'>" .$inipay->GetResult('ApplTime'). "</td>
                                </tr>
                		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>";
         }
         
        /*-------------------------------------------------------------------------------------------------------
	 *													*
	 *  �Ʒ� �κ��� ���� ���ܺ� ��� �޼��� ��� �κ��Դϴ�.    						*	
	 *													*
	 *  6.  OK CASH BAG POINT ���� �� ���� 									*
	 -------------------------------------------------------------------------------------------------------*/
	 
         else if($inipay->GetResult('PayMethod') == "OCBPoint"){
         	
                echo "		
                		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>ī �� �� ȣ</td>
                    		  <td width='343'>" .$inipay->GetResult('OCB_Num'). "</td>
                    		</tr>
                    		<tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>
                		<tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>�� �� �� ¥</td>
                                  <td width='343'>" .$inipay->GetResult('OCB_ApplDate'). "</td>
                                </tr>
                                <tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>
                                <tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>�� �� �� ��</td>
                                  <td width='343'>" .$inipay->GetResult('OCB_ApplTime'). "</td>
                                </tr>
                                <tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>���� ���ι�ȣ</td>
                    		  <td width='343'>" .$inipay->GetResult('OCB_SaveApplNum'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>��� ���ι�ȣ</td>
                    		  <td width='343'>" .$inipay->GetResult('OCB_PayApplNum'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>�� �� �� ��</td>
                    		  <td width='343'>" .$inipay->GetResult('OCB_ApplDate'). "</td>
                    		</tr>
                		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>
                    		<tr> 
                    		  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                    		  <td width='109' height='25'>����Ʈ���ұݾ�</td>
                    		  <td width='343'>" .$inipay->GetResult('OCB_PayPrice'). "</td>
                    		</tr>
                    		<tr> 
                    		  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                    		</tr>";
         }
         
        /*-------------------------------------------------------------------------------------------------------
	 *													*
	 *  �Ʒ� �κ��� ���� ���ܺ� ��� �޼��� ��� �κ��Դϴ�.    						*	
	 *													*
	 *  7.  ��ȭ ��ǰ��						                			*
	 -------------------------------------------------------------------------------------------------------*/
	 
         else if($inipay->GetResult('PayMethod') == "Culture"){
         	
                echo "		
                		<tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>���ķ��� ID</td>
                                  <td width='343'>" .$inipay->GetResult('CULT_UserID'). "</td>
                                </tr>
                                <tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>";
         }
         
         /*-------------------------------------------------------------------------------------------------------
	 *													*
	 *  �Ʒ� �κ��� ���� ���ܺ� ��� �޼��� ��� �κ��Դϴ�.    						*	
	 *													*
	 *  8.  K-merce ��ǰ��						                			*
	 -------------------------------------------------------------------------------------------------------*/
	 
         else if($inipay->GetResult('PayMethod') == "KMC_"){
         	
                echo "		
                		<tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>K-merce ID</td>
                                  <td width='343'>" .$inipay->GetResult('CULT_UserID'). "</td>
                                </tr>
                                <tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>";
         }
         
         /*-------------------------------------------------------------------------------------------------------
	 *													*
	 *  �Ʒ� �κ��� ���� ���ܺ� ��� �޼��� ��� �κ��Դϴ�.    						*	
	 *													*
	 *  9.  ƾĳ�� ����						                			*
	 -------------------------------------------------------------------------------------------------------*/
	 
         else if($inipay->GetResult('PayMethod') == "TEEN"){
         	
                echo "		
                		<tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>ƾĳ���ܾ�</td>
                                  <td width='343'>" .$inipay->GetResult('TEEN_Remains'). "</td>
                                </tr>
                                <tr> 
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>
				<tr>
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>ƾĳ�þ��̵�</td>
                                  <td width='343'>" .$inipay->GetResult('TEEN_UserID'). "</td>
                                </tr>
                                <tr>
                                  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                </tr>";
         }
          
         /*-------------------------------------------------------------------------------------------------------
	 *													*
	 *  �Ʒ� �κ��� ���� ���ܺ� ��� �޼��� ��� �κ��Դϴ�.    						*	
	 *													*
	 *  10.  ���ӹ�ȭ ��ǰ�� ����						                			*
	 -------------------------------------------------------------------------------------------------------*/
          else if($inipay->GetResult('PayMethod') == "DGCL"){
         	
                echo "		
                		<tr> 
                                  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                  <td width='109' height='25'>����� ī�� ��</td>
                                  <td width='343'>" .$inipay->GetResult('GAMG_Cnt')." ��</td>
                                </tr>";
                             
         /* �Ʒ��κ��� ����� ���ӹ�ȭ ��ǰ�� ��ȣ�� �ܾ��� �����ݴϴ�.(���� ���нÿ��� �ܾ״�� ������������ �����ݴϴ�.) */
         /* �ִ� 6����� ����� �����ϸ�, ������ ���� ī�常 ��µ˴ϴ�. */
                                for($i=1 ; $i <= $inipay->GetResult('GAMG_Cnt') ; $i++)
                                {
                                	                                	                                	
                                   echo "
                                        <tr> 
                                	  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                	</tr>
					<tr>
                                	  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                	  <td width='109' height='25'>����� ī���ȣ</td>
                                	  <td width='343'><b>" .$inipay->GetResult('GAMG_Num'.$i)."</b></td>
                                	</tr>";
                                	
                                	if($inipay->GetResult('ResultCode') == "00")
                                	{
                                		echo "
                                			<tr>
                                	        	  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                			</tr>
                                			<tr> 
                                	        	  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                	  		  <td width='109' height='25'>ī�� �ܾ�</td>
                                	        	  <td width='343'><b>" .$inipay->GetResult('GAMG_Remains'.$i)." ��</b></td>
                                 	        	</tr>";
                                 	
                                 	}else{
                                 		echo "
                                			<tr>
                                	        	  <td height='1' colspan='3' align='center'  background='../img/line.gif'></td>
                                			</tr>
                                			<tr> 
                                	        	  <td width='18' align='center'><img src='../img/icon02.gif' width='7' height='7'></td>
                                	  		  <td width='109' height='25'>�����޼���</td>
                                	        	  <td width='343'><b>" .$inipay->GetResult('GAMG_ErrMsg'.$i)."</b></td>
                                 	        	</tr>";
                                 	}
                                 	
                                }
         }
                                
 
         
?>
                    		<tr>
                                  <td height='1' colspan='3' align='center'  background='img/line.gif'></td>
                                </tr>
                  </table></td>
              </tr>
            </table>
            <br>
            
<!-------------------------------------------------------------------------------------------------------
 *													*
 *  ���� ������($inipay->GetResult('ResultCode') == "00"�� ��� ) "�̿�ȳ�"  �����ֱ� �κ��Դϴ�.			*	    
 *  ���� ���ܺ��� �̿������ ���� ���ܿ� ���� ���� ������ ���� �ݴϴ�. 				*
 *  switch , case�� ���·� ���� ���ܺ��� ��� �ϰ� �ֽ��ϴ�.						*
 *  �Ʒ� ������ ��� �մϴ�.										*
 *													*
 *  1.	�ſ�ī�� 											*
 *  2.  ISP ���� 											*
 *  3.  �ڵ��� 												*
 *  4.  ��ȭ ���� (ARS1588Bill)										*
 *  5.  ��ȭ ���� (PhoneBill)										*
 *  6.	OK CASH BAG POINT										*
 *  7.  ���������ü											*
 *  8.  ������ �Ա� ����										*
 *  9.  ��ȭ��ǰ�� ����											*
 *  10. K-merce ��ǰ�� ����                                                                             *
 *  11. ƾĳ�� ����											*
 *  12. ���ӹ�ȭ ��ǰ�� ����										*
 -------------------------------------------------------------------------------------------------------->
 
            <?php
            	
            	if($inipay->GetResult('ResultCode') == "00"){
            		
            		switch($inipay->GetResult('PayMethod')){
            		       /*--------------------------------------------------------------------------------------------------------
	 			*													*
	 			* ���� ������ �̿�ȳ� �����ֱ� 			    						*	
				*													*
	 			*  1.  �ſ�ī�� 						                			*
	 			--------------------------------------------------------------------------------------------------------*/
	
				case(Card): 
					echo "</b>�� ǥ��˴ϴ�.</td>
         					        </tr>
         					        <tr> 
         					          <td height='1' colspan='2' align='center'  background='img/line.gif'></td>
         					        </tr>
         					        
         					      </table></td>
         					  </tr>
         				      </table>";
					break;
				
			       /*--------------------------------------------------------------------------------------------------------
	 			*													*
	 			* ���� ������ �̿�ȳ� �����ֱ� 			    						*	
				*													*
	 			*  2.  ISP 						                				*
	 			--------------------------------------------------------------------------------------------------------*/
	 			
				case(VCard): // ISP
					echo "<table width='510' border='0' cellspacing='0' cellpadding='0'>
         					<tr> 
         					    <td height='25'  style='padding:0 0 0 9'><img src='img/icon.gif' width='10' height='11'> 
         					      <strong><font color='433F37'>�̿�ȳ�</font></strong></td>
         					  </tr>
         					  <tr> 
         					    <td  style='padding:0 0 0 23'> 
         					      <table width='470' border='0' cellspacing='0' cellpadding='0'>
         					        <tr>          					          
         					          <td height='25'>(1) �ſ�ī�� û������ <b>\"�̴Ͻý�(inicis.com)\"</b>���� ǥ��˴ϴ�.<br>
         					          (2) LGī�� �� BCī���� ��� <b>\"�̴Ͻý�(�̿� ������)\"</b>���� ǥ��ǰ�, �Ｚī���� ��� <b>\"�̴Ͻý�(�̿���� URL)\"</b>�� ǥ��˴ϴ�.</td>
         					        </tr>
         					        <tr> 
         					          <td height='1' colspan='2' align='center'  background='img/line.gif'></td>
         					        </tr>
         					        
         					      </table></td>
         					  </tr>
         				      </table>";
					break;
					
			       /*--------------------------------------------------------------------------------------------------------
	 			*													*
	 			* ���� ������ �̿�ȳ� �����ֱ� 			    						*	
				*													*
	 			*  3. �ڵ��� 						                				*
	 			--------------------------------------------------------------------------------------------------------*/
	 			
				case(HPP): // �޴���
					echo "<table width='510' border='0' cellspacing='0' cellpadding='0'>
         					<tr> 
         					    <td height='25'  style='padding:0 0 0 9'><img src='img/icon.gif' width='10' height='11'> 
         					      <strong><font color='433F37'>�̿�ȳ�</font></strong></td>
         					  </tr>
         					  <tr> 
         					    <td  style='padding:0 0 0 23'> 
         					      <table width='470' border='0' cellspacing='0' cellpadding='0'>
         					        <tr>          					          
         					          <td height='25'>(1) �ڵ��� û������ <b>\"�Ҿװ���\"</b> �Ǵ� <b>\"�ܺ������̿��\"</b>�� û���˴ϴ�.<br>
         					          (2) ������ �� �ѵ��ݾ��� Ȯ���Ͻð��� �� ��� �� �̵���Ż��� �����͸� �̿����ֽʽÿ�.
         					          </td>
         					        </tr>
         					        <tr> 
         					          <td height='1' colspan='2' align='center'  background='img/line.gif'></td>
         					        </tr>
         					        
         					      </table></td>
         					  </tr>
         				      </table>";
					break;				
			       /*--------------------------------------------------------------------------------------------------------
	 			*													*
	 			* ���� ������ �̿�ȳ� �����ֱ� 			    						*	
				*													*
	 			*  4. ��ȭ ���� (ARS1588Bill)				                				*
	 			--------------------------------------------------------------------------------------------------------*/
	 			
				case(Ars1588Bill): 
					echo "<table width='510' border='0' cellspacing='0' cellpadding='0'>
         					<tr> 
         					    <td height='25'  style='padding:0 0 0 9'><img src='img/icon.gif' width='10' height='11'> 
         					      <strong><font color='433F37'>�̿�ȳ�</font></strong></td>
         					  </tr>
         					  <tr> 
         					    <td  style='padding:0 0 0 23'> 
         					      <table width='470' border='0' cellspacing='0' cellpadding='0'>
         					        <tr>          					          
         					          <td height='25'>(1) ��ȭ û������ <b>\"������ �̿��\"</b>�� û���˴ϴ�.<br>
                                                          (2) �� �ѵ��ݾ��� ��� ������ �������� ��� ��ϵ� ��ȭ��ȣ ������ �ƴ� �ֹε�Ϲ�ȣ�� �������� å���Ǿ� �ֽ��ϴ�.<br>
                                                          (3) ��ȭ ������Ҵ� ������� �����մϴ�.
         					          </td>
         					        </tr>
         					        <tr> 
         					          <td height='1' colspan='2' align='center'  background='img/line.gif'></td>
         					        </tr>
         					        
         					      </table></td>
         					  </tr>
         				      </table>";
					break;
					
			       /*--------------------------------------------------------------------------------------------------------
	 			*													*
	 			* ���� ������ �̿�ȳ� �����ֱ� 			    						*	
				*													*
	 			*  5. ���� ���� (PhoneBill)				                				*
	 			--------------------------------------------------------------------------------------------------------*/
				
				case(PhoneBill): 
					echo "<table width='510' border='0' cellspacing='0' cellpadding='0'>
         					<tr> 
         					    <td height='25'  style='padding:0 0 0 9'><img src='img/icon.gif' width='10' height='11'> 
         					      <strong><font color='433F37'>�̿�ȳ�</font></strong></td>
         					  </tr>
         					  <tr> 
         					    <td  style='padding:0 0 0 23'> 
         					      <table width='470' border='0' cellspacing='0' cellpadding='0'>
         					        <tr>          					          
         					          <td height='25'>(1) ��ȭ û������ <b>\"���ͳ� ������ (����)�����̿��\"</b>�� û���˴ϴ�.<br>
                                                          (2) �� �ѵ��ݾ��� ��� ������ �������� ��� ��ϵ� ��ȭ��ȣ ������ �ƴ� �ֹε�Ϲ�ȣ�� �������� å���Ǿ� �ֽ��ϴ�.<br>
                                                          (3) ��ȭ ������Ҵ� ������� �����մϴ�.
         					          </td>
         					        </tr>
         					        <tr> 
         					          <td height='1' colspan='2' align='center'  background='img/line.gif'></td>
         					        </tr>
         					        
         					      </table></td>
         					  </tr>
         				      </table>";
					break;
				
			       /*--------------------------------------------------------------------------------------------------------
	 			*													*
	 			* ���� ������ �̿�ȳ� �����ֱ� 			    						*	
				*													*
	 			*  6. OK CASH BAG POINT					                				*
	 			--------------------------------------------------------------------------------------------------------*/
	 			
				case(OCBPoint): 
					echo "<table width='510' border='0' cellspacing='0' cellpadding='0'>
         					<tr> 
         					    <td height='25'  style='padding:0 0 0 9'><img src='img/icon.gif' width='10' height='11'> 
         					      <strong><font color='433F37'>�̿�ȳ�</font></strong></td>
         					  </tr>
         					  <tr> 
         					    <td  style='padding:0 0 0 23'> 
         					      <table width='470' border='0' cellspacing='0' cellpadding='0'>
         					        <tr>          					          
         					          <td height='25'>(1) OK CASH BAG ����Ʈ ������Ҵ� ������� �����մϴ�.
         					          </td>
         					        </tr>
         					        <tr> 
         					          <td height='1' colspan='2' align='center'  background='img/line.gif'></td>
         					        </tr>
         					        
         					      </table></td>
         					  </tr>
         				      </table>";
					break;
					
			       /*--------------------------------------------------------------------------------------------------------
	 			*													*
	 			* ���� ������ �̿�ȳ� �����ֱ� 			    						*	
				*													*
	 			*  7. ���������ü					                				*
	 			--------------------------------------------------------------------------------------------------------*/
	 			
				case(DirectBank):  
					echo "<table width='510' border='0' cellspacing='0' cellpadding='0'>
         					<tr> 
         					    <td height='25'  style='padding:0 0 0 9'><img src='img/icon.gif' width='10' height='11'> 
         					      <strong><font color='433F37'>�̿�ȳ�</font></strong></td>
         					  </tr>
         					  <tr> 
         					    <td  style='padding:0 0 0 23'> 
         					      <table width='470' border='0' cellspacing='0' cellpadding='0'>
         					        <tr>          					          
         					          <td height='25'>(1) ������ ���忡�� �̿��Ͻ� �������� ǥ��˴ϴ�.<br>
         					                          (2) ������ ���� ����ȸ�� www.inicis.com�� ���� ��� <b>\"��볻�� �� û����� ��ȸ\"</b>������ Ȯ�ΰ����մϴ�.
         					          </td>
         					        </tr>
         					        <tr> 
         					          <td height='1' colspan='2' align='center'  background='img/line.gif'></td>
         					        </tr>
         					        
         					      </table></td>
         					  </tr>
         				      </table>";
					break;
					
			       /*--------------------------------------------------------------------------------------------------------
	 			*													*
	 			* ���� ������ �̿�ȳ� �����ֱ� 			    						*	
				*													*
	 			*  8. ������ �Ա� ����					                			*
	 			--------------------------------------------------------------------------------------------------------*/		
				case(VBank):  
					echo "<table width='510' border='0' cellspacing='0' cellpadding='0'>
         					<tr> 
         					    <td height='25'  style='padding:0 0 0 9'><img src='img/icon.gif' width='10' height='11'> 
         					      <strong><font color='433F37'>�̿�ȳ�</font></strong></td>
         					  </tr>
         					  <tr> 
         					    <td  style='padding:0 0 0 23'> 
         					      <table width='470' border='0' cellspacing='0' cellpadding='0'>
         					        <tr>          					          
         					          (1) ��� ����� �Աݿ����� �Ϸ�� ���ϻ� ���� �ԱݿϷᰡ �̷���� ���� �ƴմϴ�.<br>
         					          (2) ��� �Աݰ��·� �ش� ��ǰ�ݾ��� �������Ա�(â���Ա�)�Ͻðų�, ���ͳ� ��ŷ ���� ���� �¶��� �۱��� �Ͻñ� �ٶ��ϴ�.<br>
                                                          (3) �ݵ�� �Աݱ��� ���� �Ա��Ͻñ� �ٶ��, ����Աݽ� �ݵ�� �ֹ��Ͻ� �ݾ׸� �Ա��Ͻñ� �ٶ��ϴ�.
                                                          </td>
         					        </tr>
         					        <tr> 
         					          <td height='1' colspan='2' align='center'  background='img/line.gif'></td>
         					        </tr>
         					        
         					      </table></td>
         					  </tr>
         				      </table>";
					break;
					
			       /*--------------------------------------------------------------------------------------------------------
	 			*													*
	 			* ���� ������ �̿�ȳ� �����ֱ� 			    						*	
				*													*
	 			*  9. ��ȭ��ǰ�� ����					                				*
	 			--------------------------------------------------------------------------------------------------------*/
	 			
				case(Culture):  
					echo "<table width='510' border='0' cellspacing='0' cellpadding='0'>
         					<tr> 
         					    <td height='25'  style='padding:0 0 0 9'><img src='img/icon.gif' width='10' height='11'> 
         					      <strong><font color='433F37'>�̿�ȳ�</font></strong></td>
         					  </tr>
         					  <tr> 
         					    <td  style='padding:0 0 0 23'> 
         					      <table width='470' border='0' cellspacing='0' cellpadding='0'>
         					        <tr>          					          
         					          <td height='25'>(1) ��ȭ��ǰ���� �¶��ο��� �̿��Ͻ� ��� �������ο����� ����Ͻ� �� �����ϴ�.<br>
         					                          (2) ����ĳ�� �ܾ��� �����ִ� ���, ������ ����ĳ�� �ܾ��� �ٽ� ����Ͻ÷��� ���ķ��� ID�� ����Ͻñ� �ٶ��ϴ�.
         					          </td>
         					        </tr>
         					        <tr> 
         					          <td height='1' colspan='2' align='center'  background='img/line.gif'></td>
         					        </tr>
         					        
         					      </table></td>
         					  </tr>
         				      </table>";
					break;
					
			       /*--------------------------------------------------------------------------------------------------------
	 			*													*
	 			* ���� ������ �̿�ȳ� �����ֱ� 			    						*	
				*													*
	 			*  10. K-merce ��ǰ�� ����					                			*
	 			--------------------------------------------------------------------------------------------------------*/
	 			
				case(KMC_):  
					echo "<table width='510' border='0' cellspacing='0' cellpadding='0'>
         					<tr> 
         					    <td height='25'  style='padding:0 0 0 9'><img src='img/icon.gif' width='10' height='11'> 
         					      <strong><font color='433F37'>�̿�ȳ�</font></strong></td>
         					  </tr>
         					  <tr> 
         					    <td  style='padding:0 0 0 23'> 
         					      <table width='470' border='0' cellspacing='0' cellpadding='0'>
         					        <tr>          					          
         					          <td>(1) K-merce ��ǰ���� �Ҿװ����� �����ϸ�, ��ǰ���� �ܿ� �ݾ׿� ���� ���������� ��밡���մϴ�.<br>
         					              (2) K-merce ��ǰ�� ������ K-merce ����Ʈ(www.k-merce.com)������ ������ �����մϴ�.
         					          </td>
         					        </tr>
         					        <tr> 
         					          <td height='1' colspan='2' align='center'  background='img/line.gif'></td>
         					        </tr>
         					        
         					      </table></td>
         					  </tr>
         				      </table>";
					break;
					
			       /*--------------------------------------------------------------------------------------------------------
	 			*													*
	 			* ���� ������ �̿�ȳ� �����ֱ� 			    						*	
				*													*
	 			*  11. ƾĳ�� ����					                				*
	 			--------------------------------------------------------------------------------------------------------*/
	 			
				case(TEEN):  
					echo "<table width='510' border='0' cellspacing='0' cellpadding='0'>
         					<tr> 
         					    <td height='25'  style='padding:0 0 0 9'><img src='img/icon.gif' width='10' height='11'> 
         					      <strong><font color='433F37'>�̿�ȳ�</font></strong></td>
         					  </tr>
         					  <tr> 
         					    <td  style='padding:0 0 0 23'> 
         					      <table width='470' border='0' cellspacing='0' cellpadding='0'>
         					        <tr>          					          
         					          <td>(1)ƾĳ�ô� ���ͳ� ����Ʈ �Ǵ� PC�濡�� �����Ӱ� ����� �� �ִ� ���� ���������Դϴ�.<br>
							      (2)ƾĳ�� ī���ȣ ���� : ƾĳ�� ī�� �޸鿡 ���� 12�ڸ� ��ȣ�� �Է��Ͽ� �����ϴ� ����Դϴ�.<br>
							      (3)ƾĳ�� ���̵� ���� : ƾĳ�� ����Ʈ (www.teencash.co.kr)�� ȸ������ �� ƾĳ�� ����Ʈ�� �����Ͽ� ������ ƾĳ�� ī�带 ����Ͽ� �̿��ϴ� ����Դϴ�.
         					          </td>
         					        </tr>
         					        <tr> 
         					          <td height='1' colspan='2' align='center'  background='img/line.gif'></td>
         					        </tr>
         					        
         					      </table></td>
         					  </tr>
         				      </table>";
					break;
					
			       /*--------------------------------------------------------------------------------------------------------
	 			*													*
	 			* ���� ������ �̿�ȳ� �����ֱ� 			    						*	
				*													*
	 			*  12. ���ӹ�ȭ ��ǰ�� ����				                				*
	 			--------------------------------------------------------------------------------------------------------*/
	 			
				case(DGCL):  
					echo "<table width='510' border='0' cellspacing='0' cellpadding='0'>
         					<tr> 
         					    <td height='25'  style='padding:0 0 0 9'><img src='img/icon.gif' width='10' height='11'> 
         					      <strong><font color='433F37'>�̿�ȳ�</font></strong></td>
         					  </tr>
         					  <tr> 
         					    <td  style='padding:0 0 0 23'> 
         					      <table width='470' border='0' cellspacing='0' cellpadding='0'>
         					        <tr>          					          
         					          <td>(1)���ӹ�ȭ ��ǰ���� ��ǰ�ǿ� �μ�Ǿ��ִ� ��ũ��ġ ��ȣ�� �����ϴ� ����Դϴ�.<br>
         					              (2)���ӹ�ȭ ��ǰ�� ������ ��ȭ��ǰ��(www.cultureland.co.kr)���� ���� �ϽǼ� �ֽ��ϴ�.<br>
         					              (3)���ӹ�ȭ ��ǰ���� �ִ� 6����� ����� �����մϴ�.
         					          </td>
         					        </tr>
         					        <tr> 
         					          <td height='1' colspan='2' align='center'  background='img/line.gif'></td>
         					        </tr>
         					        
         					      </table></td>
         					  </tr>
         				      </table>";
					break;
			}
		}
		
	    ?>		
            
            <!-- �̿�ȳ� �� -->
            
          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><img src="img/bottom01.gif" width="632" height="13"></td>
  </tr>
</table>
</center></body>
</html>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
