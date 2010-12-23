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
include_once("$srcdir/auth.inc");
include_once("../../../library/adodb/adodb.inc.php");


if (isset($_GET["mode"]) && $_GET["mode"] == "authorize") {
newEvent("view",$_SESSION["user"],$_SESSION["authUser"],$_SESSION["userauthorized"],$_SESSION["authProvider"],$_GET["pid"]);
}


// MySQL Connect to retrieve the picture ********************************
mysql_connect($host,$login,$pass,$dbase);
@mysql_select_db($dbase) or die("OpenEMR database connection error");
$img = $_REQUEST["submit"];


//Display the Picture******************************************************
$res=mysql_query("SELECT filedata FROM imagedata WHERE masterid=" . $img. "")
or die("SQL ERROR in line ".__LINE__.", function mysql_query");

while ($row = mysql_fetch_array($res)){ 
$image=$row['filedata']; 
header("Content-type: image/gif");
echo $image;
}
// If  authorized user == 1 then update authorized==1, changes text from red to black
//**********************************************************************
$user = $_SESSION['authUser']; 
$user_autho = $_SESSION['userauthorized'];

if ($user_autho == 1) { 
$conn = @ADONewConnection('mysql');
$conn->Connect($host, $login, $pass, $dbase);
//$conn->debug =true;

$conn->setFetchMode(ADODB_FETCH_Assoc);
$frm = array("authorized"=>"1");
$res1 = $conn->Execute("SELECT * FROM imagemetadata WHERE id=$img");
$sql = $conn->GetUpdateSQL($res1, $frm);
$conn->Execute($sql);
                  }
?>
