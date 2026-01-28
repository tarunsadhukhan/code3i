<?php
include("demo.php");
require_once('odbcPROD.php');
?>
<html>
<body>
<div align="center">
</div>
</body>
</html> 
<HEAD>
<meta http-equiv='' content='500;url='index.php'>
</HEAD>
</head>
<body bgcolor="pink">
 


 <div
   style="
      top: 19;
      left: 1;
	  text-align:center;
	  width:1000;
	  font-size : 25px;
      position: absolute;
      z-index: 3;
	  visibility: show;">

<td font size=45><blink>Welcome To JUTE Portal<blink></td>

</div>

<p></p>

</body>
</html>

<?php
$db="ATTENEMP";
 
$dt3=$_GET["date1"];
$dt2=$_GET["date1"];
echo $dt3;
$sql="";
$dt2= date("Y-m-d", strtotime($dt2));


//$conn = oci_connect($_SESSION['dusername'], $_SESSION['dpassword'], 'empire01');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
 

	$Query1="DELETE FROM ".$db.".FNGPRODDATA where TRAN_DATE=TO_DATE('$dt2','YYYY/MM/DD') ";	
	//echo $Query1;
 	$stid = oci_parse($conn,$Query1 );
	oci_execute($stid);
//	echo $Query1;
	$Query1= "commit";
 	$stid = oci_parse($conn,$Query1 );
	oci_execute($stid);
  
 
 $strsql="select * FROM HEMMFILE where date=#$dt2#";
	//echo $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
 	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'H','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
	
}

 $strsql="select * FROM HERAFILE where date=#$dt2#";
//	echo $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
 	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'R','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
	
}



$strsql="select * FROM LAPPTRAN where date=#$dt2#";

$strsql="SELECT A.DATE ,A.SHIFT+'1' AS SPELL,EBNO_1 AS EBNO,A.HRS_1 AS HOURS,CUTS1 AS BUNDLES ,' ' AS Q_CODE,
'O' AS OPER_HELP
FROM LAPPEMPL A,LAPPTRAN B WHERE A.DATE=B.DATE AND A.MCNO=B.MCNO AND A.SHIFT=B.SHIFT and A.SHIFT<>'C'
and a.date=#$dt2#";
//echo $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'L','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
}
 
 
$strsql="SELECT A.DATE ,A.SHIFT AS SPELL,EBNO_1 AS EBNO,A.HRS_1 AS HOURS,CUTS1 AS BUNDLES ,' ' AS Q_CODE,
'O' AS OPER_HELP
FROM LAPPEMPL A,LAPPTRAN B WHERE A.DATE=B.DATE AND A.MCNO=B.MCNO AND A.SHIFT=B.SHIFT  
and a.date=#$dt2#";
//echo $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'L','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
}
 
 
 
 
$strsql="SELECT A.DATE ,A.SHIFT+'2' AS SPELL,EBNO_2 AS EBNO,A.HRS_2 AS HOURS,CUTS2 AS BUNDLES ,' ' AS Q_CODE,
'O' AS OPER_HELP
FROM LAPPEMPL A,LAPPTRAN B WHERE A.DATE=B.DATE AND A.MCNO=B.MCNO AND A.SHIFT=B.SHIFT and A.SHIFT<>'C'
and a.date=#$dt2#";
//echo $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'L','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
}
 
$strsql="SELECT A.DATE ,A.SHIFT+'2' AS SPELL,EBNO_2 AS EBNO,A.HRS_2 AS HOURS,CUTS2 AS BUNDLES ,' ' AS Q_CODE,
'O' AS OPER_HELP
FROM LAPPEMPL A,LAPPTRAN B WHERE A.DATE=B.DATE AND A.MCNO=B.MCNO AND A.SHIFT=B.SHIFT and A.SHIFT='C'
and a.date=#$dt2#";
//echo $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'L','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
}



$strsql="SELECT A.DATE ,A.SHIFT+'2' AS SPELL,EBNO_2 AS EBNO,A.HRS_2 AS HOURS,CUTS2 AS BUNDLES ,' ' AS Q_CODE,
'O' AS OPER_HELP
FROM LAPPEMPL A,LAPPTRAN B WHERE A.DATE=B.DATE AND A.MCNO=B.MCNO AND A.SHIFT=B.SHIFT and A.SHIFT='C'
and a.date=#$dt2#";
//echo $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'L','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
}


$strsql="SELECT A.EBNO,A.DATE,A.SPELL,HOURS,Q_CODE,BUNDLES,'H' AS OPER_HELP FROM HEMMEMPL A,
HEMMFILE B WHERE A.DATE=B.DATE AND A.SPELL=B.SPELL AND A.MCNO=B.MCNO AND a.date=#$dt2#";
//ECHO $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'H','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
}

$strsql="SELECT A.EBNO,A.DATE,A.SPELL,HOURS,Q_CODE,BUNDLES,'H' AS OPER_HELP FROM HERAEMPL A,
HERAFILE B WHERE A.DATE=B.DATE AND A.SPELL=B.SPELL AND A.MCNO=B.MCNO AND a.date=#$dt2#";
//ECHO $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'R','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
}


$strsql="SELECT DATE,SHIFT+'1' AS SPELL,FEED_1 AS EBNO,ROLL_1 AS BUNDLES,'O' AS OPER_HELP,HRS_1 AS HOURS 
FROM SPRDTRAN WHERE SHIFT<>'C' AND ROLL_1>0 AND date=#$dt2#";
//ECHO $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'S','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
}

$strsql="SELECT DATE,SHIFT+'2' AS SPELL,FEED_2 AS EBNO,ROLL_2 AS BUNDLES,'O' AS OPER_HELP,HRS_2 AS HOURS 
FROM SPRDTRAN WHERE SHIFT<>'C' AND ROLL_2>0 AND date=#$dt2#";
//ECHO $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'S','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
}


$strsql="SELECT DATE,SHIFT AS SPELL,FEED_1 AS EBNO,ROLL_1 AS BUNDLES,'O' AS OPER_HELP,HRS_1 AS HOURS 
FROM SPRDTRAN WHERE SHIFT='C' AND ROLL_1>0 AND date=#$dt2#";
//ECHO $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'S','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
}

$strsql="SELECT DATE,SHIFT+'1' AS SPELL,RECV_1 AS EBNO,ROLL_1 AS BUNDLES,'O' AS OPER_HELP,HRS_1 AS HOURS 
FROM SPRDTRAN WHERE SHIFT<>'C' AND ROLL_1>0 AND date=#$dt2#";
//ECHO $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'S','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
}

$strsql="SELECT DATE,SHIFT+'2' AS SPELL,RECV_2 AS EBNO,ROLL_2 AS BUNDLES,'O' AS OPER_HELP,HRS_2 AS HOURS 
FROM SPRDTRAN WHERE SHIFT<>'C' AND ROLL_2>0 AND date=#$dt2#";
//ECHO $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'S','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
}


$strsql="SELECT DATE,SHIFT AS SPELL,RECV_1 AS EBNO,ROLL_1 AS BUNDLES,'O' AS OPER_HELP,HRS_1 AS HOURS 
FROM SPRDTRAN WHERE SHIFT='C' AND ROLL_1>0 AND date=#$dt2#";
//ECHO $strsql;
	$query = odbc_exec($odbc, $strsql) or die (odbc_errormsg());
	while($row = odbc_fetch_array($query))
{	
	  $sql="insert into $db.FNGPRODDATA (  TRAN_DATE,TRAN_TYPE,EBNO,SPELL,QCODE,PRODUCTION,WRK_HOURS,OPER_HELP )           
         values ( TO_DATE('".$row['DATE']."','yyyy/MM/dd')".",'S','".$row['EBNO']."','".$row['SPELL']."','".$row['Q_CODE']."'," 
		.$row['BUNDLES'].",".$row['HOURS'].",'".$row['OPER_HELP']."'".
	  	  ")";
	$stid = oci_parse($conn,$sql );
	oci_execute($stid);
}







 

$sql="SELECT A.*,B.EB_NO,B.WORKING_HRS,B.SPELL ATT_SPELL FROM 
(
SELECT DISTINCT(EBNO) EBNO,WRK_NAME,TRAN_DATE,SPELL,(WRK_HOURS) FROM fngproddata A,WORKERALL B
WHERE TRAN_DATE=TO_DATE('$dt2','yyyy/mm/dd') AND TRAN_TYPE='L' AND A.EBNO=B.EB_NO and PRODUCTION>0
) A, (
SELECT EB_NO,ATTANDANCE_DATE,SPELL,WORKING_HRS FROM DAILY_ATTENDANCE WHERE
ATTANDANCE_DATE=TO_DATE('$dt2','yyyy/mm/dd') AND (OCCU_ID=92 OR OCCU_ID=93) AND WORKING_HRS>0
) B WHERE A.EBNO(+)=B.EB_NO AND A.SPELL(+)=B.SPELL ORDER BY EB_NO,B.SPELL";
 	  $date = new DateTime($ldt);
 	  $date1 = new DateTime($dt3);

?>
<div
   style="
      top: 59;
      left: 1;
	  text-align:center;
	  width:1000;
	  font-size : 30px;
      position: absolute;
      z-index: 3;
	  visibility: show;">

<td font size=45>The Empire Jute Co. Ltd</td>

</div>

<div
   style="
      top: 70;
      left: 1;
	  text-align:center;
	  width:1000;
	  font-size : 20px;
      position: absolute;
      z-index: 3;
	  visibility: show;">

 

<td font size=45><?php echo "<br>" ." Daily   Attendance Report Dated :".$date1->format('d-m-Y')  . "</br>"; ?></td>
 


</div>



<?php	
echo  "<p>&nbsp</p>";
echo  "<p>&nbsp</p>";
echo  "<p>&nbsp</p>";
echo  "<p>&nbsp</p>";
 
 
//	echo "    <td>" . "The Empire Ju 

echo "<table border='2' >\n";



?>



<?php





$bgcolor1=	"#C9C299";
		$bgcolor2=	"#F9966B";
		$bg4="#E0FFFF";
 
echo "</table>\n";
?> 

 
<?php
 

echo "<table border=\"1\" </td>";
 
echo "<table width=\"100%\" border='1'   
          bgcolor=\"#C9C299\" class=\"scrollTable\" ><td>";
echo "    <tr><td font color='#FFFF00' >" . "LAPPING OPERATORS ". "&nbsp;" . "</td>\n</font>";
echo "    <tr><td font color='#FFFF00' >" . "Spell(ATT) ". "&nbsp;" . "</td>\n</font>";
echo "    <td>" . "EBNO( Att)". "&nbsp;" . "</td>\n";
echo "    <td>" . "Spell( prd)". "&nbsp;" . "</td>\n";
echo "    <td>" . "EB No(Prod)". "&nbsp;" . "</td>\n";
echo "    <td>" . "Name". "&nbsp;" . "</td>\n";
echo "    <td>" . "Work Hrs(Att)". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod (hrs)". "&nbsp;" . "</td>\n";
$stid = oci_parse($conn,$sql );
oci_execute($stid);
$x=0;
$qc1="";	
$n=1;
$color="1";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

if ($row['EBNO']== $row['EB_NO'] ) 
	echo "<tr bgcolor='	#00FFFF'>";
else 
 echo "<tr bgcolor='#ECD672'>";
	
if ($row['WRK_HOURS']<> $row['WORKING_HRS'] ) 
	echo "<tr bgcolor='	 	#7FFF00'>";
  	
	echo "<td align=\"left\">".$row['ATT_SPELL']."</td>";
 	echo "<td align=\"center\">".$row['EB_NO']."</td>";
	echo "<td align=\"left\">".$row['SPELL']."</td>";
	echo "<td align=\"center\">".$row['EBNO']."</td>";
	echo "<td align=\"center\">".$row['WRK_NAME']."</td>";
	echo "<td align=\"center\">".$row['WORKING_HRS']."</td>";
	echo "<td align=\"center\">".$row['WRK_HOURS']."</td>";
	
	echo "</tr>\n";
}

echo "    <tr><td font color='#FFFF00' >" . "HEMMING OPERATORS ". "&nbsp;" . "</td>\n</font>";
echo "    <tr><td font color='#FFFF00' >" . "Spell(ATT) ". "&nbsp;" . "</td>\n</font>";
echo "    <td>" . "EBNO( Att)". "&nbsp;" . "</td>\n";
echo "    <td>" . "Spell( prd)". "&nbsp;" . "</td>\n";
echo "    <td>" . "EB No(Prod)". "&nbsp;" . "</td>\n";
echo "    <td>" . "Name". "&nbsp;" . "</td>\n";
echo "    <td>" . "Working Hrs". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod(HRS)". "&nbsp;" . "</td>\n";


$sql="SELECT A.*,B.EB_NO,B.WORKING_HRS,B.SPELL ATT_SPELL FROM 
(
SELECT DISTINCT(EBNO) EBNO,WRK_NAME,TRAN_DATE,SPELL,(WRK_HOURS) FROM fngproddata A,WORKERALL B
WHERE TRAN_DATE=TO_DATE('$dt2','yyyy/mm/dd') AND TRAN_TYPE='H' AND A.EBNO=B.EB_NO AND OPER_HELP='O' and PRODUCTION>0
) A, (
SELECT EB_NO,ATTANDANCE_DATE,SPELL,WORKING_HRS FROM DAILY_ATTENDANCE WHERE
ATTANDANCE_DATE=TO_DATE('$dt2','yyyy/mm/dd') AND (OCCU_ID=105 ) AND WORKING_HRS>0
) B WHERE A.EBNO(+)=B.EB_NO AND A.SPELL(+)=B.SPELL ORDER BY EB_NO,B.SPELL";

//ECHO $sql;
$stid = oci_parse($conn,$sql );
oci_execute($stid);


$x=0;
$qc1="";	
$n=1;
$color="1";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
if ($row['EBNO']== $row['EB_NO'] ) 
	echo "<tr bgcolor='	#00FFFF'>";
else 
 echo "<tr bgcolor='#ECD672'>";
	
if ($row['WRK_HOURS']<> $row['WORKING_HRS'] ) 
	echo "<tr bgcolor='	 	#7FFF00'>";
  	
	echo "<td align=\"left\">".$row['ATT_SPELL']."</td>";
 	echo "<td align=\"center\">".$row['EB_NO']."</td>";
	echo "<td align=\"left\">".$row['SPELL']."</td>";
	echo "<td align=\"center\">".$row['EBNO']."</td>";
	echo "<td align=\"center\">".$row['WRK_NAME']."</td>";
	echo "<td align=\"center\">".$row['WORKING_HRS']."</td>";
	echo "<td align=\"center\">".$row['WRK_HOURS']."</td>";
	echo "</tr>\n";
}


echo "    <tr><td font color='#FFFF00' >" . "HERACLE OPERATORS ". "&nbsp;" . "</td>\n</font>";
echo "    <tr><td font color='#FFFF00' >" . "Spell(ATT) ". "&nbsp;" . "</td>\n</font>";
echo "    <td>" . "EBNO( Att)". "&nbsp;" . "</td>\n";
echo "    <td>" . "Spell( prd)". "&nbsp;" . "</td>\n";
echo "    <td>" . "EB No(Prod)". "&nbsp;" . "</td>\n";
echo "    <td>" . "Name". "&nbsp;" . "</td>\n";
echo "    <td>" . "Working Hrs". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod(Hrs)". "&nbsp;" . "</td>\n";


$sql="SELECT A.*,B.EB_NO,B.WORKING_HRS,B.SPELL ATT_SPELL FROM 
(
SELECT DISTINCT(EBNO) EBNO,WRK_NAME,TRAN_DATE,SPELL,(WRK_HOURS) FROM fngproddata A,WORKERALL B
WHERE TRAN_DATE=TO_DATE('$dt2','yyyy/mm/dd') AND TRAN_TYPE='R' AND A.EBNO=B.EB_NO AND OPER_HELP='O' and PRODUCTION>0
) A, (
SELECT EB_NO,ATTANDANCE_DATE,SPELL,WORKING_HRS FROM DAILY_ATTENDANCE WHERE
ATTANDANCE_DATE=TO_DATE('$dt2','yyyy/mm/dd') AND (OCCU_ID=108 ) AND WORKING_HRS>0
) B WHERE A.EBNO(+)=B.EB_NO AND A.SPELL(+)=B.SPELL ORDER BY EB_NO,B.SPELL";


$stid = oci_parse($conn,$sql );
oci_execute($stid);


$x=0;
$qc1="";	
$n=1;
$color="1";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
if ($row['EBNO']== $row['EB_NO'] ) 
	echo "<tr bgcolor='	#00FFFF'>";
else 
 echo "<tr bgcolor='#ECD672'>";
	
if ($row['WRK_HOURS']<> $row['WORKING_HRS'] ) 
	echo "<tr bgcolor='	 	#7FFF00'>";
  	
	echo "<td align=\"left\">".$row['ATT_SPELL']."</td>";
 	echo "<td align=\"center\">".$row['EB_NO']."</td>";
	echo "<td align=\"left\">".$row['SPELL']."</td>";
	echo "<td align=\"center\">".$row['EBNO']."</td>";
	echo "<td align=\"center\">".$row['WRK_NAME']."</td>";
	echo "<td align=\"center\">".$row['WORKING_HRS']."</td>";
	echo "<td align=\"center\">".$row['WRK_HOURS']."</td>";
	echo "</tr>\n";
}

/*-------------------*/
echo "    <tr><td font color='#FFFF00' >" . "HERACLE HELPERS ". "&nbsp;" . "</td>\n</font>";
echo "    <tr><td font color='#FFFF00' >" . "Spell(ATT) ". "&nbsp;" . "</td>\n</font>";
echo "    <td>" . "EBNO( Att)". "&nbsp;" . "</td>\n";
echo "    <td>" . "Spell( prd)". "&nbsp;" . "</td>\n";
echo "    <td>" . "EB No(Prod)". "&nbsp;" . "</td>\n";
echo "    <td>" . "Name". "&nbsp;" . "</td>\n";
echo "    <td>" . "Working Hrs". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod(Hrs)". "&nbsp;" . "</td>\n";


$sql="SELECT A.*,B.EB_NO,B.WORKING_HRS,B.SPELL ATT_SPELL FROM 
(
SELECT DISTINCT(EBNO) EBNO,WRK_NAME,TRAN_DATE,SPELL,(WRK_HOURS) FROM fngproddata A,WORKERALL B
WHERE TRAN_DATE=TO_DATE('$dt2','yyyy/mm/dd') AND TRAN_TYPE='R' AND A.EBNO=B.EB_NO AND OPER_HELP='H' and PRODUCTION>0
) A, (
SELECT EB_NO,ATTANDANCE_DATE,SPELL,WORKING_HRS FROM DAILY_ATTENDANCE WHERE
ATTANDANCE_DATE=TO_DATE('$dt2','yyyy/mm/dd') AND (OCCU_ID=109 ) AND WORKING_HRS>0
) B WHERE A.EBNO(+)=B.EB_NO AND A.SPELL(+)=B.SPELL ORDER BY EB_NO,B.SPELL";


$stid = oci_parse($conn,$sql );
oci_execute($stid);


$x=0;
$qc1="";	
$n=1;
$color="1";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
if ($row['EBNO']== $row['EB_NO'] ) 
	echo "<tr bgcolor='	#00FFFF'>";
else 
 echo "<tr bgcolor='#ECD672'>";
	
if ($row['WRK_HOURS']<> $row['WORKING_HRS'] ) 
	echo "<tr bgcolor='	 	#7FFF00'>";
  	
	echo "<td align=\"left\">".$row['ATT_SPELL']."</td>";
 	echo "<td align=\"center\">".$row['EB_NO']."</td>";
	echo "<td align=\"left\">".$row['SPELL']."</td>";
	echo "<td align=\"center\">".$row['EBNO']."</td>";
	echo "<td align=\"center\">".$row['WRK_NAME']."</td>";
	echo "<td align=\"center\">".$row['WORKING_HRS']."</td>";
	echo "<td align=\"center\">".$row['WRK_HOURS']."</td>";
	echo "</tr>\n";
}
 

/*-------------------*/
echo "    <tr><td font color='#FFFF00' >" . "HEMMING HELPERS ". "&nbsp;" . "</td>\n</font>";
echo "    <tr><td font color='#FFFF00' >" . "Spell(ATT) ". "&nbsp;" . "</td>\n</font>";
echo "    <td>" . "EBNO( Att)". "&nbsp;" . "</td>\n";
echo "    <td>" . "Spell( prd)". "&nbsp;" . "</td>\n";
echo "    <td>" . "EB No(Prod)". "&nbsp;" . "</td>\n";
echo "    <td>" . "Name". "&nbsp;" . "</td>\n";
echo "    <td>" . "Working Hrs". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod(Hrs)". "&nbsp;" . "</td>\n";


$sql="SELECT A.*,B.EB_NO,B.WORKING_HRS,B.SPELL ATT_SPELL FROM 
(
SELECT DISTINCT(EBNO) EBNO,WRK_NAME,TRAN_DATE,SPELL,(WRK_HOURS) FROM fngproddata A,WORKERALL B
WHERE TRAN_DATE=TO_DATE('$dt2','yyyy/mm/dd') AND TRAN_TYPE='H' AND A.EBNO=B.EB_NO AND OPER_HELP='H' and PRODUCTION>0
) A, (
SELECT EB_NO,ATTANDANCE_DATE,SPELL,WORKING_HRS FROM DAILY_ATTENDANCE WHERE
ATTANDANCE_DATE=TO_DATE('$dt2','yyyy/mm/dd') AND (OCCU_ID=106 ) AND WORKING_HRS>0
) B WHERE A.EBNO(+)=B.EB_NO AND A.SPELL(+)=B.SPELL ORDER BY EB_NO,B.SPELL";

$stid = oci_parse($conn,$sql );
oci_execute($stid);


$x=0;
$qc1="";	
$n=1;
$color="1";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
if ($row['EBNO']== $row['EB_NO'] ) 
	echo "<tr bgcolor='	#00FFFF'>";
else 
 echo "<tr bgcolor='#ECD672'>";
	
if ($row['WRK_HOURS']<> $row['WORKING_HRS'] ) 
	echo "<tr bgcolor='	 	#7FFF00'>";
  	
	echo "<td align=\"left\">".$row['ATT_SPELL']."</td>";
 	echo "<td align=\"center\">".$row['EB_NO']."</td>";
	echo "<td align=\"left\">".$row['SPELL']."</td>";
	echo "<td align=\"center\">".$row['EBNO']."</td>";
	echo "<td align=\"center\">".$row['WRK_NAME']."</td>";
	echo "<td align=\"center\">".$row['WORKING_HRS']."</td>";
	echo "<td align=\"center\">".$row['WRK_HOURS']."</td>";
	echo "</tr>\n";
}
 

/*-------------------*/
echo "    <tr><td font color='#FFFF00' >" . "SPREADER OPERATORS ". "&nbsp;" . "</td>\n</font>";
echo "    <tr><td font color='#FFFF00' >" . "Spell(ATT) ". "&nbsp;" . "</td>\n</font>";
echo "    <td>" . "EBNO( Att)". "&nbsp;" . "</td>\n";
echo "    <td>" . "Spell( prd)". "&nbsp;" . "</td>\n";
echo "    <td>" . "EB No(Prod)". "&nbsp;" . "</td>\n";
echo "    <td>" . "Name". "&nbsp;" . "</td>\n";
echo "    <td>" . "Working Hrs". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod(Hrs)". "&nbsp;" . "</td>\n";


$sql="SELECT A.*,B.EB_NO,B.WORKING_HRS,B.SPELL ATT_SPELL FROM 
(
SELECT DISTINCT(EBNO) EBNO,WRK_NAME,TRAN_DATE,SPELL,(WRK_HOURS) FROM fngproddata A,WORKERALL B
WHERE TRAN_DATE=TO_DATE('$dt2','yyyy/mm/dd') AND TRAN_TYPE='S' AND A.EBNO=B.EB_NO AND OPER_HELP='O' and PRODUCTION>0
) A, (
SELECT EB_NO,ATTANDANCE_DATE,SPELL,WORKING_HRS FROM DAILY_ATTENDANCE WHERE
ATTANDANCE_DATE=TO_DATE('$dt2','yyyy/mm/dd') AND (OCCU_ID=11 OR OCCU_ID=12 ) AND WORKING_HRS>0
) B WHERE A.EBNO(+)=B.EB_NO AND A.SPELL(+)=B.SPELL ORDER BY EB_NO,B.SPELL";

$stid = oci_parse($conn,$sql );
oci_execute($stid);


$x=0;
$qc1="";	
$n=1;
$color="1";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
if ($row['EBNO']== $row['EB_NO'] ) 
	echo "<tr bgcolor='	#00FFFF'>";
else 
 echo "<tr bgcolor='#ECD672'>";
	
if ($row['WRK_HOURS']<> $row['WORKING_HRS'] ) 
	echo "<tr bgcolor='	 	#7FFF00'>";
  	
	echo "<td align=\"left\">".$row['ATT_SPELL']."</td>";
 	echo "<td align=\"center\">".$row['EB_NO']."</td>";
	echo "<td align=\"left\">".$row['SPELL']."</td>";
	echo "<td align=\"center\">".$row['EBNO']."</td>";
	echo "<td align=\"center\">".$row['WRK_NAME']."</td>";
	echo "<td align=\"center\">".$row['WORKING_HRS']."</td>";
	echo "<td align=\"center\">".$row['WRK_HOURS']."</td>";
	echo "</tr>\n";
}
 
 
 
 echo "</table>\n";

 
 
 
 
?>


	 


 
 

 
 