<?php
// Copyright (C) 2011 Medical Information Integration, LLC www.mi-squared.com 
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.

require_once("../globals.php");
require_once("$srcdir/patient.inc");
require_once("$srcdir/acl.inc");
require_once("$srcdir/formatting.inc.php");
require_once "$srcdir/options.inc.php";
require_once "$srcdir/formdata.inc.php";

if (! acl_check('acct', 'rep')) die(xl("Unauthorized access."));

$INTEGRATED_AR = $GLOBALS['oer_config']['ws_accounting']['enabled'] === 2;
if (!$INTEGRATED_AR)
{

    echo "Sorry, this report must be used with the integrated Accounts Receivable\n";
    exit;
}


require_once("../../library/patient.inc");
require_once("../../library/sql-ledger.inc");
require_once("../../library/invoice_summary.inc.php");
require_once("../../library/sl_eob.inc.php");


$alertmsg = '';
$bgcolor = "#aaaaaa";

$today = date("Y-m-d");

$form_from_date      = fixDate($_POST['form_from_date'], "");
$form_to_date   = fixDate($_POST['form_to_date'], "");
$is_summary = $_POST['form_cb_summary'];


// In the case of CSV export only, a download will be forced.
if ($_POST['form_csvexport']) {
  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Content-Type: application/force-download");
  header("Content-Disposition: attachment; filename=providerincome_report.csv");
  header("Content-Description: File Transfer");
}
else {

?>
<html>
<head>

<?php if (function_exists('html_header_show')) html_header_show(); ?>

<style type="text/css">
/* specifically include & exclude from printing */
@media print {
    #report_parameters {
        visibility: hidden;
        display: none;
    }
    #report_parameters_daterange {
        visibility: visible;
        display: inline;
    }
    #report_results {
       margin-top: 30px;
    }
}

/* specifically exclude some from the screen */
@media screen {
    #report_parameters_daterange {
        visibility: hidden;
        display: none;
    }
}
</style>

<title><?xl('Provider Income Report','e')?></title>

</head>

<body class="body_top">
<span class='title'><?php xl('Report','e'); ?> - <?php xl('Provider Income Report','e'); ?></span>

<form method='post' action='providerincome_report.php' enctype='multipart/form-data' id='theform'>

<div id="report_parameters">

<input type='hidden' name='form_refresh' id='form_refresh' value=''/>
<input type='hidden' name='form_csvexport' id='form_csvexport' value=''/>

<table>
  <td width='85%'>
	<div style='float:left'>

	<table class='text'>
		<tr>
			<td class='label'>
            <?php
              // Build a drop-down list of providers
              //
              $query="select f.provider_id as id, CONCAT(u.fname,' ',u.lname) as provider from form_encounter as f left join users as u on f.provider_id=u.id group by provider";
              $fres = sqlStatement($query);
              echo "   <select name='form_provider'>\n";
              echo "    <option value=''>-- " . xl('All Providers') . " --\n";
              while ($frow = sqlFetchArray($fres)) {
                $provid = $frow['id'];
                if ($provid == 0 || $provid == 1) continue;
                echo "    <option value='$provid'";
                if ($provid == $form_provider) echo " selected";
                echo ">" . $frow['provider'] . "\n";
              }
              echo "   </select>\n";
            ?>
            </td>

           <td>
               <?php xl('Service Date:','e')?>
               <input type='text' name='form_from_date' id="form_from_date" size='10' value='<?php echo $_POST['form_from_date']; ?>'
                onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)'
                title='<?php xl("Date of service mm/dd/yyyy","e")?>' />
               <img src='../pic/show_calendar.gif' align='absbottom' width='24' height='22'
                id='img_from_date' border='0' alt='[?]' style='cursor:pointer'
                title='<?php xl('Click here to choose a date','e'); ?>' />
               &nbsp;
           </td>

           <td>
               <?php xl('To:','e')?>
               <input type='text' name='form_to_date' id="form_to_date" size='10' value='<?php echo $_POST['form_to_date']; ?>'
                onkeyup='datekeyup(this,mypcc)' onblur='dateblur(this,mypcc)'
                title='<?php xl("Ending DOS mm/dd/yyyy if you wish to enter a range","e")?>' />
               <img src='../pic/show_calendar.gif' align='absbottom' width='24' height='22'
                id='img_to_date' border='0' alt='[?]' style='cursor:pointer'
                title='<?php xl('Click here to choose a date','e'); ?>' />
               &nbsp;
           </td>
           <td>
               <input type='checkbox' name='form_cb_summary' <?php if ($form_cb_summary) echo ' checked'; ?> >
               <?php xl('Summary Only','e'); ?>
          </td>
      </tr>
    </table>

</div>

  </td>
  <td align='left' valign='middle' height="100%">
   <table style='border-left:1px solid; width:100%; height:100%'>
        <tr>
           <td>
               <div style='margin-left:15px'>
                 <table>
                  <tr><td>
                   <a href='#' class='css_button' onclick='$("#form_refresh").attr("value","true"); $("#theform").submit();'>
                        <span>
						   <?php xl('Submit','e'); ?>
					    </span>
					</a>
                    &nbsp;            
					<?php if ($_POST['form_refresh']) { ?>
					<a href='#' class='css_button' onclick='window.print()'>
						<span>
							<?php xl('Print','e'); ?>
						</span>
					</a>
					<?php } ?>
                    &nbsp;
					<?php if ($_POST['form_csvexport']) { ?>
					<a href='#' class='css_button' onclick='$("#form_csvexport").attr("value","true"); $("#theform").submit();'>
						<span>
							<?php xl('Export as CSV','e','\'','\''); ?>
						</span>
					</a>
					<?php } ?>
					</td></tr>
			      </table>
				</div>
			</td>
		</tr>
	</table>
  </td>
 </tr>
</table>

<?php
} // end not form_csvexport

if ($_POST['form_refresh'] || $_POST['form_csvexport'] ) {

  $rows = array();
  $where = "";

    if ($form_from_date) {
      if ($where) $where .= " AND ";
      if ($form_to_date) {
        $where .= "f.date >= '$form_from_date 00:00:00' AND f.date <= '$form_to_date 23:59:59'";
      }
      else {
        $where .= "f.date >= '$form_from_date 00:00:00' AND f.date <= '$form_from_date 23:59:59'";
      }
    }
    if ($form_provider) {
      if ($where) $where .= " AND ";
      $where .= "f.provider_id = '$form_provider'";
    }
    if (! $where) {
      $where = "1 = 1";
    }

    $query = "SELECT f.provider_id as provid, CONCAT(eu.fname,' ', eu.lname) AS provider, f.date," .
        "( SELECT SUM(b.fee) FROM billing AS b WHERE " .
        "b.pid = f.pid AND b.encounter = f.encounter AND " .
        "b.activity = 1 AND b.code_type != 'COPAY' ) AS charges, " .
        "( SELECT SUM(b.fee) FROM billing AS b WHERE " .
        "b.pid = f.pid AND b.encounter = f.encounter AND " .
        "b.activity = 1 AND b.code_type = 'COPAY' ) AS copays, " .
        "( SELECT SUM(s.fee) FROM drug_sales AS s WHERE " .
        "s.pid = f.pid AND s.encounter = f.encounter ) AS sales, " .
        "( SELECT SUM(a.pay_amount) FROM ar_activity AS a WHERE " .
        "a.pid = f.pid AND a.encounter = f.encounter ) AS payments, " .
        "( SELECT SUM(a.adj_amount) FROM ar_activity AS a WHERE " .
        "a.pid = f.pid AND a.encounter = f.encounter ) AS adjustments " .
        "FROM form_encounter AS f " .
        "LEFT OUTER JOIN users AS eu ON eu.id = f.provider_id " .
        "WHERE $where " .
//	"AND eu.fname is not NULL and eu.lname is not NULL " .
        "order by provider,f.date" ;

    // debug: 
    echo "QUERY:\n $query\n";

    $eres = sqlStatement($query);

    while ($erow = sqlFetchArray($eres)) {
//jason	echo "\n<!-- ";
//jason	foreach ($erow as $name => $value)
//jason	{
//jason	    echo "\"$name=$value\",";
//jason	}   
//jason	echo "-->\n";
	if ( $erow["provid"] == 0 || $erow["provid"] == 1 )
	    continue;
	  $provider = $erow['provider'];


	foreach ($erow as $name => $value)
	{
	    if ($name == "provider")
	    {
		$index=$value;
		continue;
	    }    

	    // this is a running set of totals.  The first time, $rows[$index][$name] ought to be zero!\
	    // convert to cents!
	    $value=bcmul($value,"100",2);
	    
	    if ( isset ($rows[$index][$name]) )
	    $rows[$index][$name] = $value + $rows[$index][$name]; 
	    else
	    $rows[$index][$name] = $value;	
	}

    } // end while

  ksort($rows);

if ($_POST['form_csvexport']) {
    // CSV headers:
    // @TODO use csv output function ....
      echo xl('Provider') . ',';
      echo xl('Charges') . ',';
      echo xl('Copays') . ',';
      echo xl('Sales') . ',';
      echo xl('Adjustments') . ',';
      echo xl('Payments') . ',';
      echo xl('Total') . "\n";
}
else { 

?>

<div id="report_results">
   <table border='0' cellpadding='1' cellspacing='2' width='98%'>
     <tr bgcolor="#dddddd">
          <td class="dehead">&nbsp;<?php xl('Provider','e')?></td>
          <td class="dehead">&nbsp;<?php xl('Charges','e')?></td>
          <td class="dehead">&nbsp;<?php xl('Copays','e')?></td>
          <td class="dehead">&nbsp;<?php xl('Sales','e')?></td>
          <td class="dehead">&nbsp;<?php xl('Adjustments','e')?></td>
          <td class="dehead">&nbsp;<?php xl('Payments','e')?></td>
          <td class="dehead">&nbsp;<?php xl('Total','e')?></td>
      </tr>

<?php
}   // end of not csvexport

	foreach ($rows as $key => $row) 
	{
		// the following expression is done in cents!
		$rowtotal=$rows[$key]['charges'] + $rows[$key]['sales'] + $rows[$key]['copays'] - $rows[$key]['adjustments'] - $rows[$key]['payments'];

		$rowtotal=bcdiv($rowtotal,100,2);
		$rows[$key]['charges'] = bcdiv( $rows[$key]['charges'],100,2);
		$rows[$key]['copays'] = bcdiv( $rows[$key]['copays'],100,2);
		$rows[$key]['sales'] = bcdiv( $rows[$key]['sales'],100,2);
		$rows[$key]['adjustments'] = bcdiv( $rows[$key]['adjustments'],100,2);
		$rows[$key]['payments'] = bcdiv( $rows[$key]['payments'],100,2);

		$pagetotal += $rowtotal;

	// if we are just outputing html
	if ( $_POST['form_csvexport']) 
	{
	    echo '"' . $key                       . '",';
	    echo '"' . $rows[$key]['charges']     . '",';
	    echo '"' . $rows[$key]['copays']      . '",';
	    echo '"' . $rows[$key]['sales']       . '",';
	    echo '"' . $rows[$key]['adjustments'] . '",';
	    echo '"' . $rows[$key]['payments']    . '",';
	    echo '"' . $rowtotal                  . '"' . "\n";

	}
	else {
	?>    
	<tr bgcolor='<?php echo $bgcolor ?>'>
            <td class='detail' >&nbsp;<?php echo $key?></td>
            <td class='detail' align='right'>&nbsp;<?php echo sprintf("%.2f", $rows[$key]['charges'])?></td>
            <td class='detail' align='right'>&nbsp;<?php echo sprintf("%.2f", $rows[$key]['copays'])?></td>
            <td class='detail' align='right'>&nbsp;<?php echo sprintf("%.2f", $rows[$key]['sales'])?></td>
            <td class='detail' align='right'>&nbsp;<?php echo sprintf("%.2f", $rows[$key]['adjustments'])?></td>
            <td class='detail' align='right'>&nbsp;<?php echo sprintf("%.2f", $rows[$key]['payments'])?></td>
	    <?php
		?>
            <td class='detail' align='right'>&nbsp;<?php echo sprintf("%.2f", $rowtotal)?></td>
	    <?php
	} // end printing html

		$pagecharges += $rows[$key]['charges'];
		$pagecopays += $rows[$key]['copays'];
		$pagesales += $rows[$key]['sales'];
		$pageadjustments += $rows[$key]['adjustments'];
		$pagepayments += $rows[$key]['payments'];

	    ?>	
	<?php
	} // end of foreach "($rows" loop ?>
	    </tr>
    </table>
</div>  

    
<?php

if ( $_POST['form_csvexport']) 
{
    echo '"' . xl('Report Totals')  . '",';
    echo '"' . $pagecharges         . '",';
    echo '"' . $pagecopays          . '",';
    echo '"' . $pagesales           . '",';
    echo '"' . $pageadjustments     . '",';
    echo '"' . $pagepayments        . '",';
    echo '"' . $pagetotal           . '"' . "\n";
}
else {

	echo " <tr bgcolor='#ffffff'>\n";
	echo "  <td class='dehead'>&nbsp;" . xl('Report Totals') . ":</td>\n";
	echo "  <td class='dehead' align='right'>&nbsp;" .
	sprintf("%.2f", $pagecharges) . "&nbsp;</td>\n";
	echo "  <td class='dehead' align='right'>&nbsp;" .
	sprintf("%.2f", $pagecopays) . "&nbsp;</td>\n";
	echo "  <td class='dehead' align='right'>&nbsp;" .
	sprintf("%.2f", $pagesales) . "&nbsp;</td>\n";
	echo "  <td class='dehead' align='right'>&nbsp;" .
	sprintf("%.2f", $pageadjustments) . "&nbsp;</td>\n";
	echo "  <td class='dehead' align='right'>&nbsp;" .
	sprintf("%.2f", $pagepayments) . "&nbsp;</td>\n";
	echo "  <td class='dehead' align='right'>&nbsp;" .
	sprintf("%.2f", $pagetotal) . "&nbsp;</td>\n";
	echo "</tr>\n";

	echo "</table>\n";
    }  
} // end if form_refresh

// if (!$INTEGRATED_AR) SLClose();


if (!$_POST['form_csvexport']) {

?>

</form>
</center>
<script language="JavaScript">
<?php
  if ($alertmsg) {
    echo "alert('" . htmlentities($alertmsg) . "')\n";
  }
?>
</script>
</body>
<!-- stuff for the popup calendar -->
<link rel='stylesheet' href='<?php echo $css_header ?>' type='text/css'>
<style type="text/css">@import url(../../library/dynarch_calendar.css);</style>
<script type="text/javascript" src="../../library/dynarch_calendar.js"></script>
<?php include_once("{$GLOBALS['srcdir']}/dynarch_calendar_en.inc.php"); ?>
<script type="text/javascript" src="../../library/dynarch_calendar_setup.js"></script>
<script type="text/javascript" src="../../library/js/jquery.1.3.2.js"></script>
<script language="Javascript">
 Calendar.setup({inputField:"form_from_date", ifFormat:"%Y-%m-%d", button:"img_from_date"});
 Calendar.setup({inputField:"form_to_date", ifFormat:"%Y-%m-%d", button:"img_to_date"});
</script>

</html>
<?php
} // end not form_csvexport
?>
