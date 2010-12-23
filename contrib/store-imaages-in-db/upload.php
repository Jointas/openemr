<?
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
include_once("$srcdir/patient.inc");
?>

<html>
<head>

<link rel=stylesheet href="<?echo $css_header;?>" type="text/css">
</head>

<body <?echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0>


<form method="post" action="uploadprocess.php" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="4000000"></input>
<br></br>

<table>
<th><a href="patient_history.php" target=Main><font class=title>Upload Files</font><font class=back><?echo $tback;?>
</font></a><br>
</th>

<tr>
<td><span>Ordering Practitioner:</span></td>
<td><select name="ordering_practitioner" >
      <option value="drbowen">Sam Bowen, MD</option>
      <option value="connie">Connie Kurth, PA-C</option>
      <option value="joym">Joy Moretz, PA-C</option>
      <option value="pmorgante">Patrick Morgante, DO</option>
      <option value="krector">Kim Rector, FNP</option>
    </select></td>
</tr>
<tr>
<td><span>Category:</span></td>
<td><select name="category">
      <option value="cv">Cardiovascular</option>
      <option value="correspondence">Correspondence</option>
      <option value="gi">Gastrointestinal</option>
      <option value="hospital">Hospital Reports</option>
      <option value="lab">Laboratory</option>
      <option value="opreports">Operative Reports</option>
      <option value="miscreports">Miscellaneous</option>
      <option value="pulmonary">Pulmonary</option>
      <option value="xray">X-Ray</option>
      <option value="admin">Administrative</option>
      <option value="billing">Billing</option>
    </select></td>
</tr> 
<tr>
<td><span>File to Upload:</span></td>
<td><input type="file" name="userfile" </td>
</tr>
<td><span>Short description of the file:</span></td>
<td><input type:"text" name="description"></input></td>
</tr>
</table>
<br><br>


<input type="submit" name="submit" value="submit">

</form>
</body>
</html>
