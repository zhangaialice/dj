<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="../includes/main.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script>
	$(function () {
		$('nav li ul').hide().removeClass('fallback');
		$('nav li').hover(function () {
			$('ul', this).stop().slideToggle(200);
		});
	});
	</script>
	
<link rel="stylesheet" type="text/css" href="../includes/main.css">
</head>

<body>
	<?php include("../includes/navigation.php");?>
		<div class="content">
		<h1 class="define">Instruction</h1><br><br>
		<h2>How to define Fossil Fuel holdings?</h2><br>

		<li>For sector/industry classification, Global Industry Classification Standards (GICS by MSCI & Standard & Poor's) are used for Equity securities, and Bloomberg Industry Classification Standards(Bloomberg) are used for Fixed Income securities.</li><br>
		<li>For Equities, the sub-industry classified as Fossil Fuel holdings are: </li><br>
		<script>
			var f_equity= ['Oil & Gas Drilling','Integrated Oil & Gas','Oil & Gas Exploration & Produc','Oil & Gas Refining & Marketing','Oil & Gas Storage & Transporta','Coal & Consumable Fuels','Diversified Metals & Mining','Gas Utilities','Multi-Utilities','Independent Power Producers & Energy Traders']
			document.write('<table width=100% style="font-style:italic;">');
			
			var num=[0,5];
			for(j in num)
			{
				document.write("<tr>");
				for( var i = num[j]; i <num[j]+5; i++ )
				{
					document.write('<td>'+f_equity[i]+'</td>');
					
				}
				document.write("</tr>");
			}
			document.write('</table><br>');
		</script>

		<li>For Fixed Income, the sub-industry classified as Fossil Fuel holdings are: </li><br>
		<script>
			var f_fi= ['Exploration & Production','Integrated Oils','Oil& Gas','Pipelines','Refining & Marketing','Renewable Energy','Mining','Gas','Gas Distribution']
			document.write('<table width=100% style="font-style:italic;">');
			var num=[0,5];
			for(j in num)
			{
				document.write("<tr>");
				for( var i = num[j]; i <Math.min(num[j]+5,f_fi.length); i++ )
				{
					document.write('<td>'+f_fi[i]+'</td>');
					
				}
				document.write("</tr>");
			}
			document.write('</table><br>');
		</script>
		<li>The following corporation are excluded from Fossil Fuel holdings: 'CAMECO CORP','CAMECO CORPORATION','MAJOR DRILLING GROUP INTERNATI'</li><br>
		<li>All lists above can be edited in the "fossil fuel.py." file</li><br>
		</ul>
		<h2>What asset classes are grouped in Global Equity and Fixed Income?</h2><br>
		<li>Global Equity: US Equity, International Equity and Emerging Market</li><br>
		<li>Fixed Income: Cash, STN, Mortgage, Cash & STN</li><br>
		<h2>How to count Unique Issuers?</h2><br>
		<li>Only unique issuers are counted in the number of holdings at asset class level.  At the overall portfolio level, if the same issuer is held both in equity and fixed income asset classes, it is counted as two unique securities.</li><br>
		</div>



	<div class="footer">
	<img src="image/divider.png" height="30" width="1600">
	</div>
</body>
</html>