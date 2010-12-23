<?php
// +-----------------------------------------------------------------------------+ 
// Copyright (C) 2006 OEMR.org
//
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
//
// A copy of the GNU General Public License is included along with this program:
// openemr/interface/login/GnuGPL.html
// For more information write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//
// Author: 2006 Samuel T. Bowen, MD <drbowen@openmedsoftware.org>
//
// +------------------------------------------------------------------------------+

include_once("../../globals.php");
include_once("$srcdir/patient.inc");
include_once("$srcdir/api.inc");
include_once("../../../library/adodb/adodb.inc.php");


if (isset($_GET["mode"]) && $_GET["mode"] == "authorize") {
newEvent("view",$_SESSION["user"],$_SESSION["authUser"],$_SESSION["authProvider"],$_GET["pid"]);

}



?>

<html>
<head>
<link rel=stylesheet href="<?echo $css_header;?>" type="text/css">
</head>

<body  <?echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0 >

<form method="post" action="getImage.php">


<a href="patient_history.php" target=Main><font class=title>Upload Files</font><font class=back><?echo $tback;?></font></a><br>


<?
foreach ($_POST as $k => $var) {
$_POST[$k] = mysql_escape_string($var);
echo "$var\n";
}
$black=000000;
$red=FB0808;
//$imageDownload="download_process.php";
$submit=submit;



//Start the new ADODB connection to the database
$db = ADONewConnection('mysql');
//$db->debug = off;
$db->Connect($host,$login,$pass,$dbase);
if (!$db) die("Connection failed");

$results = $db->GetAll("SELECT * FROM imagemetadata where pid='".$_SESSION['pid']."'");



// Change the authorized variable

//if ($user == $authUser) {
//$ok = $db->Execute("update imagemetadata set authorized=1 where id=1");
//$ok = $db->Execute("update imagemetadata set authorized=1 where id='".$_SESSION['id']."'");
//
//if (!$ok) mylogerr($db->ErrorMsg());
//               }
?>

<h3>Cardiovascular</h3>

<p align="center"> 
<table width="90%" align="left" border ="1" bordercolor="#C7E0FC" cellpadding="2" cellspacing="0" font face="verdana" size="2"> 
<td><font face="verdana" size="2"> <b>FILE NAME:</b></td>
<td><font face="verdana" size="2"> <b>DESCRIPTION:</b></td>
<td><font face="verdana" size="2"> <b>ORDERING PRACTIONER:</b></td>
<td><font face="verdana" size="2"><b>DATE:</b></td>
<td><font face="verdana" size="2"><b>VIEW PICTURE:</b></td>
</tr>
<tr font face="verdana" size="2"> 

<?
foreach($results AS $result)
   {
	if ($result[category] == cv) 
		if ($result[authorized] == 0) {
//echo "<span class=text> ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp ".$result['filedate']."</span><span class=text><FONT Color=".$red.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
             
echo "<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$red." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
 		} 
else {                  
echo
"<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$black." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
      }

   }

?>
</tr>
</table>
</p>
<br clear="ALL">
</br>


<h3>Correspondence</h3>

<p align="center"> 
<table width="90%" align="left" border ="1" bordercolor="#C7E0FC" cellpadding="2" cellspacing="0" font face="verdana" size="2"> 
<td><font face="verdana" size="2"> <b>FILE NAME:</b></td>
<td><font face="verdana" size="2"> <b>DESCRIPTION:</b></td>
<td><font face="verdana" size="2"> <b>ORDERING PRACTIONER:</b></td>
<td><font face="verdana" size="2"><b>DATE:</b></td>
<td><font face="verdana" size="2"><b>VIEW PICTURE:</b></td>
</tr>
<tr font face="verdana" size="2"> 


<?
foreach($results AS $result)
   {
	if ($result[category] == correspondence)
		if ($result[authorized] == 0) {
         
echo "<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$red." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
	} else {



echo
"<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$black." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
		}
   }

?>
</tr>
</table>
</p>
<br clear="ALL">
</br>


<!--
echo '<p>Gastrointestinal</p>'; 
-->
<h3>Gastrointestinal</h3>
<p align="center"> 
<table width="90%" align="left" border ="1" bordercolor="#C7E0FC" cellpadding="2" cellspacing="0" font face="verdana" size="2"> 
<td><font face="verdana" size="2"><b>FILE NAME:</b></td>
<td><font face="verdana" size="2"><b>DESCRIPTION:</b></td>
<td><font face="verdana" size="2"><b>ORDERING PRACTIONER:</b></td>
<td><font face="verdana" size="2"><b>DATE:</b></td>
<td><font face="verdana" size="2"><b>VIEW PICTURE:</b></td>
</tr>
<tr font face="verdana" size="2"> 

<?
foreach($results AS $result)
   {
	if ($result[category] == gi)
		if ($result[authorized] == 0) {
//echo "<span class=text> ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp ".$result['filedate']."</span><span class=text><FONT Color=".$red.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
echo
"<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$red." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";


	} 
else {		
//echo "<span class=text>  ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."".$result['filedate']."</span><span class=text><FONT Color=".$black.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";

echo
"<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$black." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";

}
   
   }

?>
</tr>
</table>
</p>
<br clear="ALL">
</br>

<h3>Hospital Reports</h3>
<p align="center"> 
<table width="90%" align="left" border ="1" bordercolor="#C7E0FC" cellpadding="2" cellspacing="0" font face="verdana" size="2"> 
<td><font face="verdana" size="2"> <b>FILE NAME:</b></td>
<td><font face="verdana" size="2"> <b>DESCRIPTION:</b></td>
<td><font face="verdana" size="2"> <b>ORDERING PRACTIONER:</b></td>
<td><font face="verdana" size="2"><b>DATE:</b></td>
<td><font face="verdana" size="2"><b>VIEW PICTURE:</b></td>
</tr>
<tr font face="verdana" size="2"> 

<?
foreach($results AS $result)
   {
	if ($result[category] == hospital)
		if ($result[authorized] == 0) {
//echo "<span class=text>".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp ".$result['filedate']."</span><span class=text><FONT Color=".$red.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
echo "<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$red." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";


		} else {




//echo "<span class=text>".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp ".$result['filedate']."</span><span class=text><FONT Color=".$black.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
echo



"<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$black." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
		}
 
   }

?>

  </tr>
</table>
</p>
<br clear="ALL"></br>

<!--
echo '<p>Laboratory</p>'; 
-->

<h3>Laboratory</h3>

<p align="center"> 
<table width="90%" align="left" border ="1" bordercolor="#C7E0FC" cellpadding="2" cellspacing="0" font face="verdana" size="2"> 
<td><font face="verdana" size="2"> <b>FILE NAME:</b></td>
<td><font face="verdana" size="2"> <b>DESCRIPTION:</b></td>
<td><font face="verdana" size="2"> <b>ORDERING PRACTIONER:</b></td>
<td><font face="verdana" size="2"><b>DATE:</b></td>
<td><font face="verdana" size="2"><b>VIEW PICTURE:</b></td>
</tr>
<tr font face="verdana" size="2"> 


<?
foreach($results AS $result)
   {
	if ($result[category] == lab)
		if ($result[authorized] == 0) {
//echo "<span class=text> ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp ".$result['filedate']."</span><span class=text><FONT Color=".$red.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";


      
echo "<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$red." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";



		} else {

//echo "<span class=text>  ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp ".$result['filedate']."</span><span class=text><FONT Color=".$black.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
echo

"<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$black." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
}

   }

?>
  </tr>
</table>
</p>
<br clear="ALL"></br>


<!--
echo '<p>Operative Reports</p>'; 
-->
<h3>Operative Reports</h3>

<p align="center"> 
<table width="90%" align="left" border ="1" bordercolor="#C7E0FC" cellpadding="2" cellspacing="0" font face="verdana" size="2"> 
<td><font face="verdana" size="2"> <b>FILE NAME:</b></td>
<td><font face="verdana" size="2"> <b>DESCRIPTION:</b></td>
<td><font face="verdana" size="2"> <b>ORDERING PRACTIONER:</b></td>
<td><font face="verdana" size="2"><b>DATE:</b></td>
<td><font face="verdana" size="2"><b>VIEW PICTURE:</b></td>
</tr>
<tr font face="verdana" size="2"> 


<?
foreach($results AS $result)
   {
	if ($result[category] == opreports)
		if ($result[authorized] == 0) {

//echo "<span class=text> ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp ".$result['filedate']."</span><span class=text><FONT Color=".$red.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
echo "<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$red." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
 		 

		} else {

//echo "<span class=text>  ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."".$result['filedate']."</span><span class=text><FONT Color=".$black.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";


echo
"<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$black." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
		}
 
   }

?>
  </tr>
</table>
</p>
<br clear="ALL"></br>

<!--
echo '<p>Miscellaneous Reports</p>'; 
-->

<h3>Miscellaneous Reports</h3>
<p align="center"> 
<table width="90%" align="left" border ="1" bordercolor="#C7E0FC" cellpadding="2" cellspacing="0" font face="verdana" size="2"> 
<td><font face="verdana" size="2"> <b>FILE NAME:</b></td>
<td><font face="verdana" size="2"> <b>DESCRIPTION:</b></td>
<td><font face="verdana" size="2"> <b>ORDERING PRACTIONER:</b></td>
<td><font face="verdana" size="2"><b>DATE:</b></td>
<td><font face="verdana" size="2"><b>VIEW PICTURE:</b></td>
</tr>
<tr font face="verdana" size="2"> 
<?
foreach($results AS $result)
   {
	if ($result[category] == miscreports)
		if ($result[authorized] == 0) {
//echo "<span class=text> ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp ".$result['filedate']."</span><span class=text><FONT Color=".$red.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
      
echo "<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$red." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
 
		} else {

//echo "<span class=text>  ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."".$result['filedate']."</span><span class=text><FONT Color=".$black.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
echo
"<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$black." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";

		}
 		   
   }

?>
  </tr>
</table>
</p>
<br clear="ALL"></br>

<!--
echo '<p>Pulmonary</p>'; 
-->
<h3>Pulmonary</h3>
<p align="center"> 
<table width="90%" align="left" border ="1" bordercolor="#C7E0FC" cellpadding="2" cellspacing="0" font face="verdana" size="2"> 
<td><font face="verdana" size="2"> <b>FILE NAME:</b></td>
<td><font face="verdana" size="2"> <b>DESCRIPTION:</b></td>
<td><font face="verdana" size="2"> <b>ORDERING PRACTIONER:</b></td>
<td><font face="verdana" size="2"><b>DATE:</b></td>
<td><font face="verdana" size="2"><b>VIEW PICTURE:</b></td>
</tr>
<tr font face="verdana" size="2"> 
<?
foreach($results AS $result)
   {
	if ($result[category] == pulmonary)
 		if ($result[authorized] == 0) {
//echo "<span class=text> ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp ".$result['filedate']."</span><span class=text><FONT Color=".$red.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
           
echo "<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$red." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
 		

		} else {
//echo "<span class=text>  ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."".$result['filedate']."</span><span class=text><FONT Color=".$black.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
echo
"<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$black." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";

	}   
   }

?>
  </tr>
</table>
</p>
<br clear="ALL"></br>


<!--
echo '<p>X-Ray Reports</p>'; 
-->
<h3>X-Ray Reports</h3>
<p align="center"> 
<table width="90%" align="left" border ="1" bordercolor="#C7E0FC" cellpadding="2" cellspacing="0" font face="verdana" size="2"> 
<td><font face="verdana" size="2"> <b>FILE NAME:</b></td>
<td><font face="verdana" size="2"> <b>DESCRIPTION:</b></td>
<td><font face="verdana" size="2"> <b>ORDERING PRACTIONER:</b></td>
<td><font face="verdana" size="2"><b>DATE:</b></td>
<td><font face="verdana" size="2"><b>VIEW PICTURE:</b></td>
</tr>
<tr font face="verdana" size="2"> 
<?
foreach($results AS $result)
   {
	if ($result[category] == xray)
 		if ($result[authorized] == 0) {
//echo "<span class=text> ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp ".$result['filedate']."</span><span class=text><FONT Color=".$red.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
echo "<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$red." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
 

		} else {

//echo "<span class=text>  ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."".$result['filedate']."</span><span class=text><FONT Color=".$black.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
echo
"<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$black." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
		}   
   }
?>
  </tr>
</table>
</p>
<br clear="ALL"></br>


<!--
echo '<p>Administrative</p>';
-->
<h3>Administrative</h3>
<p align="center">
<table width="90%" align="left" border ="1" bordercolor="#C7E0FC" cellpadding="2" cellspacing="0" font face="verdana" size="2">
<td><font face="verdana" size="2"> <b>FILE NAME:</b></td>
<td><font face="verdana" size="2"> <b>DESCRIPTION:</b></td>
<td><font face="verdana" size="2"> <b>ORDERING PRACTIONER:</b></td>
<td><font face="verdana" size="2"><b>DATE:</b></td>
<td><font face="verdana" size="2"><b>VIEW PICTURE:</b></td>
</tr>
<tr font face="verdana" size="2">
<?
foreach($results AS $result)
   {
        if ($result[category] == admin)
                if ($result[authorized] == 0) {
//echo "<span class=text> ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp ".$result['filedate']."</span><span class=text><FONT Color=".$red.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
echo "<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$red." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";


                } else {

//echo "<span class=text>  ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."".$result['filedate']."</span><span class=text><FONT Color=".$black.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
echo
"<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$black." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
                }
   }
?>
  </tr>
</table>
</p>
<br clear="ALL"></br>


<!--
echo '<p>Billing</p>';
-->
<h3>Billing</h3>
<p align="center">
<table width="90%" align="left" border ="1" bordercolor="#C7E0FC" cellpadding="2" cellspacing="0" font face="verdana" size="2">
<td><font face="verdana" size="2"> <b>FILE NAME:</b></td>
<td><font face="verdana" size="2"> <b>DESCRIPTION:</b></td>
<td><font face="verdana" size="2"> <b>ORDERING PRACTIONER:</b></td>
<td><font face="verdana" size="2"><b>DATE:</b></td>
<td><font face="verdana" size="2"><b>VIEW PICTURE:</b></td>
</tr>
<tr font face="verdana" size="2">
<?
foreach($results AS $result)
   {
        if ($result[category] == billing)
                if ($result[authorized] == 0) {
//echo "<span class=text> ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp ".$result['filedate']."</span><span class=text><FONT Color=".$red.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
echo "<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$red." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";


                } else {

//echo "<span class=text>  ".$result['name']."&nbsp&nbsp&nbsp&nbsp ".$result['description']."&nbsp&nbsp&nbsp&nbsp ".$result['ordering_practitioner']."".$result['filedate']."</span><span class=text><FONT Color=".$black.">View:</FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
echo
"<tr><td>".$result['name']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['description']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['ordering_practitioner']."&nbsp&nbsp&nbsp&nbsp "."</td><td>".$result['filedate']."&nbsp&nbsp&nbsp&nbsp "."</td><td></span><span class=text><FONT Color=".$black." >View: </FONT></span><input type=".$submit." name=".$submit." value=".$result['id']."></input><br />";
                }
   }
?>
  </tr>
</table>
</p>
<br></br>

</form>

</body>
</html>
