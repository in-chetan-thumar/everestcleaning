<?php
$path = "";
	$gettime = "01 May 2016";
	$name = "John Smith";
	$designation = "Manager";
	$commission = "100";
	$basicpay = "1200";
	
	$allowances = "30";
	$total_deduction = "51";
	$grosspay = "2000";
	$employer_cpf = "11";
	$employee_cpf = "11";
	$totalcpf = "22";
	$nettotal = "1500";
	$overtime= "1";
	$basicsalary="2200";
	$unpaidleave = "40";
	$print_name= "aa";
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
			<title>Title</title>
			<style type="text/css" media="all">
			body, html {			
				font-family:Helvetica;
				font-size:14px;
				text-transform:uppercase;
			}			
			div.nobreak {
				page-break-inside:avoid;
			}
			
			.wrapper{
				width:700px;
			}
			.addwidthx72{
				width:600px;
			}
			.wrapper h1{
				text-align:center;
			}
			.add_border{
				border:1px solid #000;
				padding:10px !important;
			}	
			.add_border1{
				border-top:1px solid #000;
				border-left:1px solid #000;
				border-right:1px solid #000;
				padding:10px !important;
			}
			.add_border_left{
				border-left:1px solid #000;
				padding:10px !important;
			}
			.add_border_right{
				border-right:1px solid #000;
				padding:10px !important;
			}
			.txt_label{
				width:100px;
				display:inline-block;
				height:25px;
			}
			
			.txt_label1{
				width:200px;
				display:inline-block;
				height:25px;
			}
			.txt_label2{
				width:150px;
				display:inline-block;
				height:25px;
			}
			.txt_label3{
				width:150px;
				display:inline-block;
				height:25px;
			}
			.txt_value{
				width:100px;
				display:inline-block !important;
				height:25px;
				text-align:right;
			}
			.txt_value1{
				width:130px;
				display:inline-block;
				height:25px;
				text-align:right;
			}
			.add_height{
				height:200px;
			}
			.add_height1{
				height:80px;
			}
			.net_total{
				font-weight:bold;
				
			}
			.leave_days{
				width:50px;
				display:inline-block;
				text-align:right;
			}
			.leave_days1{
				width:20px;
				display:inline-block;
			}
			.deduct_txt{
				display:inline-block;width:132px;text-align:right;padding-right:8px;
			}
			.space_txt{
				display:inline-block;width:150px;
			}
			.dot{
				width:7px;
				display:inline-block;
				height:25px;
			}
			.name_style{
				text-transform:capitalize;
			}
			.row_style{				
				height:50px;
			}
			</style>
			</head>
			<body>
				<div class="nobreak">
					<div class="wrapper">
					<table border="0" cellpadding="0" cellspacing="0" class="addwidthx72">
					<tr><td><img src="images/everest-logo.png" width="250px"/></td></tr>
					<tr><td><h1>PAYSLIP</h1></td></tr>
					
					<tr><td class="add_border1">						
						<div><span class="txt_label">NAME</span><span class="dot">:</span><span class="txt_label1 name_style">'.$name.'</span><span class="txt_label">PERIOD</span><span class="dot">:</span><span class="txt_label3">'.$gettime.'</span></div>
						<div><span class="txt_label">DESIGNATION</span><span class="dot">:</span><span class="txt_label1 name_style">'.$designation.'</span></div>	
					</td><td>
					</tr>
					<tr><td>
						<table border="0" cellpadding="0" cellspacing="0" class="addwidthx72">
							<tr><td class="add_border" style="width:330px;">
								<div class=row_style><span class="txt_label2">Basic Pay</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$basicpay.'</span></div>
								<div class=row_style>	<span class="txt_label2">Overtime</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$overtime.'</span></div>
								<div class=row_style><span class="txt_label2">Commission</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$commission.'</span></div>
								<div class=row_style><span class="txt_label2">Allowances</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$allowances.'</span></div>
								
								<div class=net_total><span class="txt_label2 ">Gross Pay</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$grosspay.'</span></div>
							</td>
							</td><td class="add_border" style="width:330px">
							    <div class=row_style> <span class="txt_label2">EMPLOYEE CPF</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$employer_cpf.'</span></div>
								<div class=row_style><span class="txt_label2">Unpaid Leave</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$unpaidleave.'</span></div>
								<div class=row_style style="height:100px">&nbsp;</div>
								
								<div class=net_total row_style><span class="txt_label2">Total decduction</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$total_deduction.'</span></div>
						    </td></tr>		
						    <tr><td class="add_border" style="width:330px;">
								<div class=row_style><span class="txt_label2">EMPLOYER CPF</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$employer_cpf.'</span></div>
								<div class=row_style><span class="txt_label2">EMPLOYEE CPF</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$employee_cpf.'</span></div>
								<div class=net_total row_style><span class="txt_label2">TOTAL CPF</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$totalcpf.'</span></div>	
								<div style="height:30px">&nbsp;</div>							
							</td>
							</td><td class="add_border" style="width:330px">							   
								<div style="height:100px">&nbsp;</div>
								<div class=net_total row_style><span class="txt_label2 ">Net Total</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$nettotal.'</span></div>
								<div style="height:30px">&nbsp;</div>
						    </td></tr>	

						</table>
					</tr></td>
				</table>
			    </div>
				</div>
				</body>
			</html>'



?>