<?php
include("demo.php");
?>


<html>
<body>
<div align="center">

</div>

</body>
</html> 


<HEAD>
<meta http-equiv='refresh' content='5000;url='index.php'>

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

<td font size=45><blink>Welcome To LOOM Portal<blink></td>

</div>

<p></p>

</body>
</html>

<?php
//session_start();
$passwords="";


$itmc="";

$yarn="";
$yarn=$_GET["education"];

$dt1=$_GET["date1"];
$dt2=$_GET["date2"];

$dt1 = date('Y-m-d', strtotime(  $dt1 ));
$dt2 = date('Y-m-d', strtotime(  $dt2 ));


//$dt1=$_GET["date1"];
//$dt2=$_GET["date2"];
$_SESSION['animal']   = 'cat'; 
$_SESSION['date1']= $dt1;
$_SESSION['date2']= $dt2;


 
$sql="";

//$conn = oci_connect($_SESSION['dusername'], $_SESSION['dpassword'], 'empire01');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}


$var="";
$var2="";
if ($yarn=="H") {
	$var="41";
	$var2="Hessian";	

$_SESSION['hssk']="41";
}
if ($yarn=="S") {
	$var="42";
$_SESSION['hssk']="42";
	$var2="Sacking";	
	}

$lmtp=$var;
$sqa="select * FROM (
SELECT A.LOOM_NO,loom_type,SUM(QTYA) QTYA,SUM(WRKA) WRKA,SUM(EFFA) EFFA ,
SUM(QTYB) QTYB,SUM(WRKB) WRKB,SUM(EFFB) EFFB
,SUM(QTYC) QTYC,SUM(WRKC) WRKC, SUM(EFFC) EFFC
FROM
(
SELECT LOOM_NO,QUANTITY QTYA,WRK_HOURS WRKA,STDPROD EFFA,0 QTYB,0 WRKB,0 EFFB,
0 QTYC,0 WRKC , 0 EFFC 
FROM daily_loom_data WHERE 
substr(loom_no,1,2)='$var' AND SUBSTR(SPELL,1,1)='A' AND STDPROD>0
AND TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd')
and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd')
UNION ALL
SELECT LOOM_NO,0 QTYA,0 WRKA,0 EFFA,QUANTITY QTYB,WRK_HOURS WRKB,STDPROD EFFB,
0 QTYC,0 WRKC , 0 EFFC 
FROM daily_loom_data WHERE 
substr(loom_no,1,2)='$var' AND SUBSTR(SPELL,1,1)='B' AND STDPROD>0
AND TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd')
and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd')
UNION ALL
SELECT LOOM_NO,0 QTYA,0 WRKA,0 EFFA,0 QTYB,0 WRKB,0 EFFB,
QUANTITY QTYC,WRK_HOURS WRKC , STDPROD EFFC 
FROM daily_loom_data WHERE 
substr(loom_no,1,2)='$var' AND SUBSTR(SPELL,1,1)='C' AND STDPROD>0
AND TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd')
and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd')
) a,LOOM_MASTER B WHERE A.LOOM_NO=B.LOOM_NO   GROUP BY A.LOOM_NO,LOOM_TYPE 
) ORDER BY LOOM_TYPE,(QTYA+QTYB+QTYC)/(EFFA+EFFB+EFFC)*100";

//ORDER BY A.LOOM_NO";


//echo $sqa;

$stid = oci_parse($conn,$sqa );

oci_execute($stid);


	  $date = new DateTime($dt1);
	  $date1 = new DateTime($dt2);

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

 

<td font size=45><?php echo "<br>" ." Loomwise Report From Dated :".$date->format('d-m-Y')." To ".$date1->format('d-m-Y') ."</br>"; ?></td>


</div>
<?php	
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
 

echo "<tr><th colspan=\"2\"> Loom </td>\n";
echo "<th colspan=\"3\"> Shift A </td>\n";
echo "<th colspan=\"3\"> Shift B </td>\n";
echo "<th colspan=\"3\"> Shift C </td>\n";
echo "<th colspan=\"3\"> Overall </td>\n";


 



echo "    <tr><td align=center  size='24' font color='#FFFF00' >" . "Loom Type". "&nbsp;" . "</td>\n</font>";
echo "    <td align=center  size='24' font color='#FFFF00' >" . "Loom No ". "&nbsp;" . "</td>\n</font>";
echo "    <td align=center  size='24' font color='#FFFF00' >" . "Prod ". "&nbsp;" . "</td>\n</font>";
echo "    <td align=center  size='24' font color='#FFFF00' >" . "Eff%". "&nbsp;" . "</td>\n</font>";
echo "    <td align=center  size='24' font color='#FFFF00' >" . "Hrs". "&nbsp;" . "</td>\n</font>";
echo "    <td align=center  size='24' font color='#FFFF00' >" . "Prod ". "&nbsp;" . "</td>\n</font>";
echo "    <td align=center  size='24' font color='#FFFF00' >" . "Eff%". "&nbsp;" . "</td>\n</font>";
echo "    <td align=center  size='24' font color='#FFFF00' >" . "Hrs". "&nbsp;" . "</td>\n</font>";
echo "    <td align=center  size='24' font color='#FFFF00' >" . "Prod ". "&nbsp;" . "</td>\n</font>";
echo "    <td align=center  size='24' font color='#FFFF00' >" . "Eff%". "&nbsp;" . "</td>\n</font>";
echo "    <td align=center  size='24' font color='#FFFF00' >" . "Hrs". "&nbsp;" . "</td>\n</font>";
echo "    <td align=center  size='24' font color='#FFFF00' >" . "Prod ". "&nbsp;" . "</td>\n</font>";
echo "    <td align=center  size='24' font color='#FFFF00' >" . "Eff%". "&nbsp;" . "</td>\n</font>";
echo "    <td align=center  size='24' font color='#FFFF00' >" . "Hrs". "&nbsp;" . "</td>\n</font>";

 
 


 


  
$x=0;

$qc1="";	
$n=1;
$color="1";


while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
	 $x++; 
  
 $var=1;
if ($var < 6) $color = '#00FF00';
elseif ($var < 10) $color = '#FF8000';
elseif ($var > 10) $color = '#FF0000';
 
 $n=$n+1;

 
 $var=$row['QTYA']+$row['QTYB']+$row['QTYC'];

 if ($var>0) {
 


if ($x%2 == 0) 
 echo "<tr bgcolor='	#F9966B'>";

else 
 echo "<tr bgcolor='#ECD672'>";
	
//	echo "<td><a href='wvg2.php?value=".$row['Q_CODE']."'>".$row['Q_CODE']."</td>";


	if ($row['LOOM_TYPE']=='N') {
		echo "<td align=\"center\">".'General'."</td>";
	}
	if ($row['LOOM_TYPE']=='L') {
	echo "<td align=\"center\">".'Loader'."</td>";
	}
		if ($row['LOOM_TYPE']=='B') {
			echo "<td align=\"center\">".'Big Shuttle'."</td>";
	}

		if ($row['LOOM_TYPE']=='G') {
			echo "<td align=\"center\">".'S4 Loom'."</td>";
		}
			if ($row['LOOM_TYPE']=='R') {
	echo "<td align=\"center\">".'Rapier'."</td>";
	}

	
	
	 echo "<td align=\"center\"><a href='loomDRdrEpt.php?value=".$row['LOOM_NO']."'>".$row['LOOM_NO']."</td>";
	
//	echo "<td align=\"left\">".$row['NAME']."</td>";
	$var=0;
	$ef=0;
	$wk=0;
	if ($row['QTYA']>0) {
		$var=$row['QTYA'] ;
		$ef=round($row['QTYA']/$row['EFFA']*100,2) ;
		$wk=$row['WRKA'] ;
		
	}
 
	echo "<td align=\"center\">".number_format($var,0)."</td>";
	echo "<td align=\"center\">".number_format($ef,2)."</td>";
    echo "<td align=\"center\">".number_format($wk,2)."</td>";
	$var=0;
	$ef=0;
	$wk=0;
	if ($row['QTYB']>0) {
		$var=$row['QTYB'] ;
		$ef=round($row['QTYB']/$row['EFFB']*100,2) ;
		$wk=$row['WRKB'] ;
		
	}
	echo "<td align=\"center\">".number_format($var,0)."</td>";
	echo "<td align=\"center\">".number_format($ef,2)."</td>";
    echo "<td align=\"center\">".number_format($wk,2)."</td>";
	$var=0;
	$ef=0;
	$wk=0;
	if ($row['QTYC']>0) {
		$var=$row['QTYC'] ;
		$ef=round($row['QTYC']/$row['EFFC']*100,2) ;
		$wk=$row['WRKC'] ;
		
	}
	echo "<td align=\"center\">".number_format($var,0)."</td>";
	echo "<td align=\"center\">".number_format($ef,2)."</td>";
    echo "<td align=\"center\">".number_format($wk,2)."</td>";
   
	$var=0;
	$ef=0;
	$wk=0;
	if ($row['QTYA']+$row['QTYB']+$row['QTYC']>0) {
		$var=$row['QTYA']+$row['QTYB']+$row['QTYC'] ;
		$ef=round(($row['QTYA']+$row['QTYB']+$row['QTYC'])/($row['EFFA']+$row['EFFB']+$row['EFFC'])*100,2) ;
		$wk=$row['WRKA']+$row['WRKB']+$row['WRKC'] ;
		
	}
	echo "<td align=\"center\">".number_format($var,2)."</td>";
	echo "<td align=\"center\">".number_format($ef,2)."</td>";
    echo "<td align=\"center\">".number_format($wk,2)."</td>";

	 
     


 
 }
	
//
}
   
  


  	echo "</tr>\n";
  echo "<td align=\"center\">".'Grand Total'."</td>";
$var=$lmtp;
$sqa="select * FROM (
SELECT loom_type,SUM(QTYA) QTYA,SUM(WRKA) WRKA,SUM(EFFA) EFFA ,
SUM(QTYB) QTYB,SUM(WRKB) WRKB,SUM(EFFB) EFFB
,SUM(QTYC) QTYC,SUM(WRKC) WRKC, SUM(EFFC) EFFC
FROM
(
SELECT LOOM_NO,QUANTITY QTYA,WRK_HOURS WRKA,STDPROD EFFA,0 QTYB,0 WRKB,0 EFFB,
0 QTYC,0 WRKC , 0 EFFC 
FROM daily_loom_data WHERE 
substr(loom_no,1,2)='$var' AND SUBSTR(SPELL,1,1)='A' AND STDPROD>0
AND TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd')
and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd')
UNION ALL
SELECT LOOM_NO,0 QTYA,0 WRKA,0 EFFA,QUANTITY QTYB,WRK_HOURS WRKB,STDPROD EFFB,
0 QTYC,0 WRKC , 0 EFFC 
FROM daily_loom_data WHERE 
substr(loom_no,1,2)='$var' AND SUBSTR(SPELL,1,1)='B' AND STDPROD>0
AND TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd')
and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd')
UNION ALL
SELECT LOOM_NO,0 QTYA,0 WRKA,0 EFFA,0 QTYB,0 WRKB,0 EFFB,
QUANTITY QTYC,WRK_HOURS WRKC , STDPROD EFFC 
FROM daily_loom_data WHERE 
substr(loom_no,1,2)='$var' AND SUBSTR(SPELL,1,1)='C' AND STDPROD>0
AND TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd')
and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd')
) a,LOOM_MASTER B WHERE A.LOOM_NO=B.LOOM_NO   GROUP BY LOOM_TYPE 
) ORDER BY LOOM_TYPE,(QTYA+QTYB+QTYC)/(EFFA+EFFB+EFFC)*100";
 
$stid = oci_parse($conn,$sqa );
oci_execute($stid);
 

 while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
	 $x++; 
 $var=1;
if ($var < 6) $color = '#00FF00';
elseif ($var < 10) $color = '#FF8000';
elseif ($var > 10) $color = '#FF0000';
 
 $n=$n+1;

 
 $var=$row['QTYA']+$row['QTYB']+$row['QTYC'];

 if ($var>0) {
 


if ($x%2 == 0) 
 echo "<tr bgcolor='	#F9966B'>";

else 
 echo "<tr bgcolor='#ECD672'>";
	
//	echo "<td><a href='wvg2.php?value=".$row['Q_CODE']."'>".$row['Q_CODE']."</td>";


	if ($row['LOOM_TYPE']=='N') {
		echo "<td align=\"center\">".'General'."</td>";
	}
	if ($row['LOOM_TYPE']=='L') {
	echo "<td align=\"center\">".'Loader'."</td>";
	}
		if ($row['LOOM_TYPE']=='B') {
	echo "<td align=\"center\">".'Big Shuttle'."</td>";
	}

		if ($row['LOOM_TYPE']=='G') {
	echo "<td align=\"center\">".'S4 Loom'."</td>";
	}
			if ($row['LOOM_TYPE']=='R') {
	echo "<td align=\"center\">".'Rapier'."</td>";
	}

	
	
	 echo "<td align=\"center\"></td>";
	
//	echo "<td align=\"left\">".$row['NAME']."</td>";
	$var=0;
	$ef=0;
	$wk=0;
	if ($row['QTYA']>0) {
		$var=$row['QTYA'] ;
		$ef=round($row['QTYA']/$row['EFFA']*100,2) ;
		$wk=$row['WRKA'] ;
		
	}
 
	echo "<td align=\"center\">".number_format($var,0)."</td>";
	echo "<td align=\"center\">".number_format($ef,2)."</td>";
    echo "<td align=\"center\">".number_format($wk,2)."</td>";
	$var=0;
	$ef=0;
	$wk=0;
	if ($row['QTYB']>0) {
		$var=$row['QTYB'] ;
		$ef=round($row['QTYB']/$row['EFFB']*100,2) ;
		$wk=$row['WRKB'] ;
		
	}
	echo "<td align=\"center\">".number_format($var,0)."</td>";
	echo "<td align=\"center\">".number_format($ef,2)."</td>";
    echo "<td align=\"center\">".number_format($wk,2)."</td>";
	$var=0;
	$ef=0;
	$wk=0;
	if ($row['QTYC']>0) {
		$var=$row['QTYC'] ;
		$ef=round($row['QTYC']/$row['EFFC']*100,2) ;
		$wk=$row['WRKC'] ;
		
	}
	echo "<td align=\"center\">".number_format($var,0)."</td>";
	echo "<td align=\"center\">".number_format($ef,2)."</td>";
    echo "<td align=\"center\">".number_format($wk,2)."</td>";
   
	$var=0;
	$ef=0;
	$wk=0;
	if ($row['QTYA']+$row['QTYB']+$row['QTYC']>0) {
		$var=$row['QTYA']+$row['QTYB']+$row['QTYC'] ;
		$ef=round(($row['QTYA']+$row['QTYB']+$row['QTYC'])/($row['EFFA']+$row['EFFB']+$row['EFFC'])*100,2) ;
		$wk=$row['WRKA']+$row['WRKB']+$row['WRKC'] ;
		
	}
	echo "<td align=\"center\">".number_format($var,2)."</td>";
	echo "<td align=\"center\">".number_format($ef,2)."</td>";
    echo "<td align=\"center\">".number_format($wk,2)."</td>";

	 
     


 
 }
	
//
}



$var=$lmtp;
$sqa="select * FROM (
SELECT SUM(QTYA) QTYA,SUM(WRKA) WRKA,SUM(EFFA) EFFA ,
SUM(QTYB) QTYB,SUM(WRKB) WRKB,SUM(EFFB) EFFB
,SUM(QTYC) QTYC,SUM(WRKC) WRKC, SUM(EFFC) EFFC
FROM
(
SELECT LOOM_NO,QUANTITY QTYA,WRK_HOURS WRKA,STDPROD EFFA,0 QTYB,0 WRKB,0 EFFB,
0 QTYC,0 WRKC , 0 EFFC 
FROM daily_loom_data WHERE 
substr(loom_no,1,2)='$var' AND SUBSTR(SPELL,1,1)='A' AND STDPROD>0
AND TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd')
and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd')
UNION ALL
SELECT LOOM_NO,0 QTYA,0 WRKA,0 EFFA,QUANTITY QTYB,WRK_HOURS WRKB,STDPROD EFFB,
0 QTYC,0 WRKC , 0 EFFC 
FROM daily_loom_data WHERE 
substr(loom_no,1,2)='$var' AND SUBSTR(SPELL,1,1)='B' AND STDPROD>0
AND TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd')
and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd')
UNION ALL
SELECT LOOM_NO,0 QTYA,0 WRKA,0 EFFA,0 QTYB,0 WRKB,0 EFFB,
QUANTITY QTYC,WRK_HOURS WRKC , STDPROD EFFC 
FROM daily_loom_data WHERE 
substr(loom_no,1,2)='$var' AND SUBSTR(SPELL,1,1)='C' AND STDPROD>0
AND TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd')
and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd')
) a,LOOM_MASTER B WHERE A.LOOM_NO=B.LOOM_NO   
) ";
 
$stid = oci_parse($conn,$sqa );
//echo $sqa;
oci_execute($stid);
 

 while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
	 $x++; 
  ECHO $var;
 $var=1;
if ($var < 6) $color = '#00FF00';
elseif ($var < 10) $color = '#FF8000';
elseif ($var > 10) $color = '#FF0000';
 
 $n=$n+1;

 
 $var=$row['QTYA']+$row['QTYB']+$row['QTYC'];

 if ($var>0) {
 


if ($x%2 == 0) 
 echo "<tr bgcolor='	#F9966B'>";

else 
 echo "<tr bgcolor='#ECD672'>";
	
//	echo "<td><a href='wvg2.php?value=".$row['Q_CODE']."'>".$row['Q_CODE']."</td>";


	
		echo "<td align=\"center\">".'Overall'."</td>";
	
	

	
	
	 echo "<td align=\"center\"></td>";
	
//	echo "<td align=\"left\">".$row['NAME']."</td>";
	$var=0;
	$ef=0;
	$wk=0;
	if ($row['QTYA']>0) {
		$var=$row['QTYA'] ;
		$ef=round($row['QTYA']/$row['EFFA']*100,2) ;
		$wk=$row['WRKA'] ;
		
	}
 
	echo "<td align=\"center\">".number_format($var,0)."</td>";
	echo "<td align=\"center\">".number_format($ef,2)."</td>";
    echo "<td align=\"center\">".number_format($wk,2)."</td>";
	$var=0;
	$ef=0;
	$wk=0;
	if ($row['QTYB']>0) {
		$var=$row['QTYB'] ;
		$ef=round($row['QTYB']/$row['EFFB']*100,2) ;
		$wk=$row['WRKB'] ;
		
	}
	echo "<td align=\"center\">".number_format($var,0)."</td>";
	echo "<td align=\"center\">".number_format($ef,2)."</td>";
    echo "<td align=\"center\">".number_format($wk,2)."</td>";
	$var=0;
	$ef=0;
	$wk=0;
	if ($row['QTYC']>0) {
		$var=$row['QTYC'] ;
		$ef=round($row['QTYC']/$row['EFFC']*100,2) ;
		$wk=$row['WRKC'] ;
		
	}
	echo "<td align=\"center\">".number_format($var,0)."</td>";
	echo "<td align=\"center\">".number_format($ef,2)."</td>";
    echo "<td align=\"center\">".number_format($wk,2)."</td>";
   
	$var=0;
	$ef=0;
	$wk=0;
	if ($row['QTYA']+$row['QTYB']+$row['QTYC']>0) {
		$var=$row['QTYA']+$row['QTYB']+$row['QTYC'] ;
		$ef=round(($row['QTYA']+$row['QTYB']+$row['QTYC'])/($row['EFFA']+$row['EFFB']+$row['EFFC'])*100,2) ;
		$wk=$row['WRKA']+$row['WRKB']+$row['WRKC'] ;
		
	}
	echo "<td align=\"center\">".number_format($var,2)."</td>";
	echo "<td align=\"center\">".number_format($ef,2)."</td>";
    echo "<td align=\"center\">".number_format($wk,2)."</td>";

	 
     


 
 }
	
//
}
 
 
 
 
  
  

	
	

 echo "</table>\n";

?>


	 


    

 

 
<div
   style="
      top: 49;
      left: 1;
	  text-align:right;
	  width:1000;
	  font-size : 20px;
      position: absolute;
      z-index: 3;
	  visibility: show;">

 
			<a href="LOOMdataEPTexl.php">Export for Data</a>

</div>
<div
   style="
      top: 70;
      left: 1;
	  text-align:right;
	  width:1000;
	  font-size : 20px;
      position: absolute;
      z-index: 3;
	  visibility: show;">

 
			<a href="loomebrpt.php">Back</a>

</div>
<div
   style="
      top: 90;
      left: 1;
	  text-align:right;
	  width:1000;
	  font-size : 20px;
      position: absolute;
      z-index: 3;
	  visibility: show;">

 
			<a href="LOOMEBREPTexl.php">Export to Excel</a>

</div>
