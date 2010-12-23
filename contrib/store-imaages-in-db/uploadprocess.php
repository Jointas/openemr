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
// +------------------------------------------------------------------------------+

include_once("../../globals.php");
include_once("$srcdir/api.inc");
include_once("../../../library/adodb/adodb.inc.php");


$userauthorized =0;

foreach ($_POST as $k => $var) {
$_POST[$k] = mysql_escape_string($var);
//echo "$var\n";
}

//Start the new ADODB connection to the database
$db = ADONewConnection('mysql');
$db->debug = off;
$db->Connect($host,$login,$pass,$dbase);
//$db->Connect($host,$login,$dbase);
if (!$db) die("Connection failed");

$SrcPathFile = $HTTP_POST_FILES["userfile"]["tmp_name"];
$SrcFileType = $HTTP_POST_FILES["userfile"]["type"];
$DstFileName = $HTTP_POST_FILES["userfile"]["name"];
$SrcFileSize = $HTTP_POST_FILES["userfile"]["size"];

clearstatcache();
  $time = filemtime($SrcPathFile);
  $storedate = date("Y-m-d H:i:s", $time);

if (file_exists($SrcPathFile)) {
   $sql = "INSERT INTO imagemetadata  (
        pid,
        groupname,
        user,
        authorized,
        activity,
        description,
        ordering_practitioner,
        category,
        datatype,
        name,
        size,
        filedate) 

        values (

      '".$_SESSION['pid']."',
      '".$_SESSION["authProvider"]."',
      '".$_SESSION["authUser"]."',
      1,
      1, 
      '".$_POST['description']."',
      '".$_POST['ordering_practitioner']."',
      '".$_POST['category']."',
      '".$SrcFileType."',
      '".$DstFileName."',
      '".$SrcFileSize."',
      '".$storedate."'
      )";
   $db->Execute($sql);
   
   $fileid = $db->Insert_ID($sql);
   
         // Insert into the imagedata table
        $fp = fopen($SrcPathFile, "rb");
        while (!feof($fp)) {
   
         // Make the data mysql insert safe
         $binarydata = addslashes(fread($fp, 4194240));
   
         $sql = "insert into imagedata (masterid,filedata) values ('".$fileid."', '" . $binarydata . "')";
         $db->Execute($sql);
        }
}
print "Success";

$address = "{$GLOBALS['rootdir']}/patient_file/history/upload.php";
echo "\n<script language='Javascript'>window.location='$address';</script>\n";
exit;
?>
