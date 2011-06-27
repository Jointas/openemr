--- ndc_drug_lookup.php
+++ ndc_drug_lookup.php
@@ -19,21 +19,23 @@
 include_once("{$GLOBALS['srcdir']}/formdata.inc.php");
 
 $q = formData("q","G",true);
-if (!$q) return;
+if (!trim($q)) return;
 
 $drug = explode("  ",$q);
-$sql="SELECT list_id, CONCAT_WS('-',label_code,product_code) AS ndc, name, strength, unit FROM ndc_drug_list";
+//$sql="SELECT list_id, CONCAT_WS('-',label_code,product_code) AS ndc, name, strength, unit FROM ndc_drug_list";
+$sql="SELECT RXAUI as list_id, CODE AS ndc, STR as name FROM RXNCONSO ";
+//AND SAB =  'RXNORM'
 if($drug[0] != ""){
     $find = mysql_real_escape_string($drug[0]);
-    $sql .= " WHERE name LIKE '%$find%'";
+    $sql .= " WHERE STR LIKE '%$find%' and TTY IN('SCD','SBD')  ";
 }
-$sql .= " GROUP BY name, strength, unit ORDER BY name";
-
+$sql .= "  group by STR ORDER BY STR limit 0,30";
+//echo $sql;
 $result = sqlStatement($sql);
 while( $row = sqlFetchArray($result) ) {
-       $strength = explode(";",$row['strength']);
-       $unit = explode(";",$row['unit']);
-       $dose = implode("-",$strength)." ".$unit[0];
+       //$strength = explode(";",$row['strength']);
+       //$unit = explode(";",$row['unit']);
+       //$dose = implode("-",$strength)." ".$unit[0];
 
        echo $row['name']."  ".$dose."|".$row['list_id']."#".$row['ndc']."#".$row['name']."\n";
 }
