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
// Modified: 2006 Samuel T. Bowen, MD <drbowen@openmedsoftware.org>
//    Added link to getImageMetaData.php
// +------------------------------------------------------------------------------+

include_once("../../globals.php");
include_once("$srcdir/patient.inc");
?>

<html>
<head>

<link rel=stylesheet href="<?echo $css_header;?>" type="text/css">

</head>
<body <?echo $top_bg_line;?> topmargin=0 rightmargin=0 leftmargin=2 bottommargin=0 marginwidth=2 marginheight=0>

<?
$result = getHistoryData($pid);
?>

<a href="history_full.php" target=Main><font class=title>Patient History / Lifestyle</font><font class=more><?echo $tmore;?></font></a><br>


<table border=0 cellpadding=2>

<tr>
<td valign=top>
<span class=bold>Patient Had:</span><br>
<?if ($result{"cataract_surgery"} != "0000-00-00 00:00:00") {?><span class=text>Cataract Surgery: </span><span class=text><?echo $result{"cataract_surgery"};?></span><br><?}?>
<?if ($result{"tonsillectomy"} != "0000-00-00 00:00:00") {?><span class=text>Tonsillectomy: </span><span class=text><?echo $result{"tonsillectomy"};?></span><br><?}?>
<?if ($result{"appendectomy"} != "0000-00-00 00:00:00") {?><span class=text>Appendectomy: </span><span class=text><?echo $result{"appendectomy"};?></span><br><?}?>
<?if ($result{"cholecystestomy"} != "0000-00-00 00:00:00") {?><span class=text>Cholecystestomy: </span><span class=text><?echo $result{"cholecystestomy"};?></span><br><?}?>
<?if ($result{"heart_surgery"} != "0000-00-00 00:00:00") {?><span class=text>Heart Surgery: </span><span class=text><?echo $result{"heart_surgery"};?></span><br><?}?>
<?if ($result{"hysterectomy"} != "0000-00-00 00:00:00") {?><span class=text>Hysterectomy: </span><span class=text><?echo $result{"hysterectomy"};?></span><br><?}?>
<?if ($result{"hernia_repair"} != "0000-00-00 00:00:00") {?><span class=text>Hernia Repair: </span><span class=text><?echo $result{"hernia_repair"};?></span><br><?}?>
<?if ($result{"hip_replacement"} != "0000-00-00 00:00:00") {?><span class=text>Hip Replacement: </span><span class=text><?echo $result{"hip_replacement"};?></span><br><?}?>
<?if ($result{"knee_replacement"} != "0000-00-00 00:00:00") {?><span class=text>Knee Replacement: </span><span class=text><?echo $result{"knee_replacement"};?></span><br><?}?>
</td>

<td valign=top>
<span class=bold>Date of Last:</span><br>
<?if ($result{"last_breast_exam"} != "0000-00-00 00:00:00") {?><span class=text>Breast Exam: </span><span class=text><?echo $result{"last_breast_exam"};?></span><br><?}?>
<?if ($result{"last_mammogram"} != "0000-00-00 00:00:00") {?><span class=text>Mammogram: </span><span class=text><?echo $result{"last_mammogram"};?></span><br><?}?>
<?if ($result{"last_gynocological_exam"} != "0000-00-00 00:00:00") {?><span class=text>Gynocological Exam: </span><span class=text><?echo $result{"last_gynocological_exam"};?></span><br><?}?>
<?if ($result{"last_rectal_exam"} != "0000-00-00 00:00:00") {?><span class=text>Rectal Exam: </span><span class=text><?echo $result{"last_rectal_exam"};?></span><br><?}?>
<?if ($result{"last_prostate_exam"} != "0000-00-00 00:00:00") {?><span class=text>Prostate Exam: </span><span class=text><?echo $result{"last_prostate_exam"};?></span><br><?}?>
<?if ($result{"last_physical_exam"} != "0000-00-00 00:00:00") {?><span class=text>Physical Exam: </span><span class=text><?echo $result{"last_physical_exam"};?></span><br><?}?>
<?if ($result{"last_sigmoidoscopy_colonoscopy"} != "0000-00-00 00:00:00") {?><span class=text>Sigmoidoscopy/Colonoscopy: </span><span class=text><?echo $result{"last_sigmoidoscopy_colonoscopy"};?></span><br><?}?>
</td>

<td valign=top>
<span class=bold>Lifestyle:</span><br>
<?if ($result{"coffee"} != "") {?><span class=text>Coffee: </span><span class=text><?echo $result{"coffee"};?></span><br><?}?>
<?if ($result{"tobacco"} != "") {?><span class=text>Tobacco: </span><span class=text><?echo $result{"tobacco"};?></span><br><?}?>
<?if ($result{"alcohol"} != "") {?><span class=text>Alcohol: </span><span class=text><?echo $result{"alcohol"};?></span><br><?}?>
<?if ($result{"sleep_patterns"} != "") {?><span class=text>Sleep Patterns: </span><span class=text><?echo $result{"sleep_patterns"};?></span><br><?}?>
<?if ($result{"exercise_patterns"} != "") {?><span class=text>Exercise Patterns: </span><span class=text><?echo $result{"exercise_patterns"};?></span><br><?}?>
<?if ($result{"seatbelt_use"} != "") {?><span class=text>Seatbelt Use: </span><span class=text><?echo $result{"seatbelt_use"};?></span><br><?}?>
<?if ($result{"counseling"} != "") {?><span class=text>Counseling: </span><span class=text><?echo $result{"counseling"};?></span><br><?}?>
<?if ($result{"hazardous_activities"} != "") {?><span class=text>Hazardous Activities: </span><span class=text><?echo $result{"hazardous_activities"};?></span><br><?}?>

</td>

<td>
<a href="upload.php" ><font class=title>Upload Files</font></a><br>
</td>

</tr>

<tr>
<td valign=top>
<span class=bold>Family History:</span><br>
<?if ($result{"history_father"} != "") {?><span class=text>Father: </span><span class=text><?echo $result{"history_father"};?></span><br><?}?>
<?if ($result{"history_mother"} != "") {?><span class=text>Mother: </span><span class=text><?echo $result{"history_mother"};?></span><br><?}?>
<?if ($result{"history_siblings"} != "") {?><span class=text>Siblings: </span><span class=text><?echo $result{"history_siblings"};?></span><br><?}?>
<?if ($result{"history_spouse"} != "") {?><span class=text>Spouse: </span><span class=text><?echo $result{"history_spouse"};?></span><br><?}?>
<?if ($result{"history_offspring"} != "") {?><span class=text>Offspring: </span><span class=text><?echo $result{"history_offspring"};?></span><br><?}?>
</td>

<td valign=top>
<span class=bold>Relatives:</span><br>
<?if ($result{"relatives_cancer"} != "") {?><span class=text>Cancer: </span><span class=text><?echo $result{"relatives_cancer"};?></span><br><?}?>
<?if ($result{"relatives_tuberculosis"} != "") {?><span class=text>Tuberculosis: </span><span class=text><?echo $result{"relatives_tuberculosis"};?></span><br><?}?>
<?if ($result{"relatives_diabetes"} != "") {?><span class=text>Diabetes: </span><span class=text><?echo $result{"relatives_diabetes"};?></span><br><?}?>
<?if ($result{"relatives_high_blood_pressure"} != "") {?><span class=text>High Blood Pressure: </span><span class=text><?echo $result{"relatives_high_blood_pressure"};?></span><br><?}?>
<?if ($result{"relatives_heart_problems"} != "") {?><span class=text>Heart Problems: </span><span class=text><?echo $result{"relatives_heart_problems"};?></span><br><?}?>
<?if ($result{"relatives_stroke"} != "") {?><span class=text>Stroke: </span><span class=text><?echo $result{"relatives_stroke"};?></span><br><?}?>
<?if ($result{"relatives_epilepsy"} != "") {?><span class=text>Epilepsy: </span><span class=text><?echo $result{"relatives_epilepsy"};?></span><br><?}?>
<?if ($result{"relatives_mental_illness"} != "") {?><span class=text>Mental Illness: </span><span class=text><?echo $result{"relatives_mental_illness"};?></span><br><?}?>
<?if ($result{"relatives_suicide"} != "") {?><span class=text>Suicide: </span><span class=text><?echo $result{"relatives_suicide"};?></span><br><?}?>
</td>

<td valign=top>

</td>
<td>
<a href="getImageMetaData.php" target="Main">
<span class=text>Cardiovascular</span><br>
<span class=text>Correspondence</span><br>
<span class=text>Gastrointestinal</span><br>
<span class=text>Hospital Reports</span><br>
<span class=text>Laboratory</span><br>
<span class=text>Operative Reports</span><br>
<span class=text>Miscellaneous</span><br>
<span class=text>Pulmonary</span><br>
<span class=text>X-Ray</span><br>
<span class=text>Administrative</span><br>
<span class=text>Billing</span><br> 
</a>
</td>

</tr>

</table>


</body>
</html>
