<?php
session_start();
//ECHO "CONNECT YYY";
include("demo.php");
//ECHO "CONNECT";

				$_SESSION['dusername']= 'NWEBPROD';
				$_SESSION['dpassword']= 'NWEBPROD';
				$_SESSION['dcompany']= 'THE EMPIRE JUTE CO LTD';
				
				//$conn = oci_connect('NWEBPROD', 'NWEBPROD', '//localhost/EMPIRE01');


 ?>
		<script>
			$(function() {
				$(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Excel Document Name",
					filename: "myleName",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
			});
		</script>


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

<td font size=45><blink>Welcome To LOOM Portal<blink></td>

</div>

<p></p>



<?php
//session_start();
$passwords="";


$itmc="";

$yarn="";
$yarn=$_GET["education"];

$dt1=$_GET["date1"];

$dt2=$_GET["date2"];


$sql="";
$hsk=$_SESSION['hssk'];


$dt1=$_GET["date1"];
$dt2=$_GET["date2"];
echo $dt1;
$_SESSION['animal']   = 'cat'; 
$_SESSION['date1']= $dt1;
$_SESSION['date2']= $dt2;

$sday = date('d', strtotime($dt1));
$nday = date('d', strtotime($dt2));


$dt1=$_GET["date1"];
$dt2=$_GET["date2"];
$_SESSION['animal']   = 'cat'; 
$sday = date('d', strtotime($dt1));
$nday = date('d', strtotime($dt2));

$dt1 = date('Y-m-d', strtotime(  $dt1 ));
$dt2 = date('Y-m-d', strtotime(  $dt2 ));






//ECHO $dt1;
//ECHO $dt2;

//echo $sday;
//echo $nday;


$var="";
if ($yarn=="H") {
	$var="41";
$_SESSION['hssk']="41";

}
if ($yarn=="S") {
	$var="42";
$_SESSION['hssk']="42";
	}
 
$sql="";

//$conn = oci_connect($_SESSION['dusername'], $_SESSION['dpassword'], 'empire01');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

//ECHO "next";
$var='42';
$sqa="SELECT A.EBNO,TRAN_DATE,WRK_NAME,ROUND(SUM(EFFICIENCY*WRK_HOURS)/SUM(WRK_HOURS),0) EFF FROM DAILY_LOOM_DATA A,WVGATTEN.WORKER_MASTER B 
WHERE A.EBNO=B.EB_NO AND  EFFICIENCY>0 and TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd') and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd') and substr(loom_no,1,2)='$var'
GROUP BY A.EBNO,TRAN_DATE,wrk_name ORDER BY A.EBNO,TRAN_DATE ";



$sqa=" SELECT A.*,NVL(B.EFF_INC,0) EFF_INC,NVL(B.TOT_RATE,0) TOT_RATE FROM (

SELECT A.*,B.GEFF,NVL(C.CNT,0) AS CNT,NODAYS FROM
(
SELECT A.EBNO,TRAN_DATE,WRK_NAME,ROUND(SUM(EFFICIENCY*WRK_HOURS)/SUM(WRK_HOURS),0) EFF FROM DAILY_LOOM_DATA A,
WORKER_MASTER B,LOOM_MASTER C WHERE A.EBNO=B.EB_NO AND EFFICIENCY>0 and TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd') 
and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd') and substr(a.loom_no,1,2)='$var' AND 
A.LOOM_NO=C.LOOM_NO AND C.LOOM_TYPE='G'
GROUP BY A.EBNO,TRAN_DATE,wrk_name ORDER BY A.EBNO,TRAN_DATE
) A,
(
SELECT EBNO,ROUND(SUM(EFFICIENCY*WRK_HOURS)/SUM(WRK_HOURS),0) GEFF FROM DAILY_LOOM_DATA A,LOOM_MASTER C
WHERE  EFFICIENCY>0 and TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd') 
and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd') and substr(a.loom_no,1,2)='$var' AND A.LOOM_NO=C.LOOM_NO 
AND C.LOOM_TYPE='G' GROUP BY EBNO ORDER BY EBNO
) B,
(
SELECT EBNO,COUNT(*) AS CNT FROM (
SELECT A.EBNO,TRAN_DATE,WRK_NAME,ROUND(SUM(EFFICIENCY*WRK_HOURS)/SUM(WRK_HOURS),0) EFF FROM DAILY_LOOM_DATA A,
WORKER_MASTER B,LOOM_MASTER C WHERE A.EBNO=B.EB_NO AND EFFICIENCY>0 and TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd') 
and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd') and substr(a.loom_no,1,2)='$var' AND A.LOOM_NO=C.LOOM_NO 
AND C.LOOM_TYPE='G' 
GROUP BY A.EBNO,TRAN_DATE,wrk_name ORDER BY A.EBNO,TRAN_DATE
) WHERE EFF BETWEEN 0 AND 39.99 GROUP BY EBNO ORDER BY EBNO
) C ,
(
SELECT EBNO,COUNT(*) AS NODAYS FROM
 (
SELECT A.EBNO,TRAN_DATE,WRK_NAME,ROUND(SUM(EFFICIENCY*WRK_HOURS)/SUM(WRK_HOURS),0) EFF FROM DAILY_LOOM_DATA A,
WORKER_MASTER B,LOOM_MASTER C WHERE A.EBNO=B.EB_NO AND EFFICIENCY>0 and TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd') 
and TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd') and substr(a.loom_no,1,2)='$var' AND A.LOOM_NO=C.LOOM_NO 
AND C.LOOM_TYPE='G' GROUP BY A.EBNO,TRAN_DATE,wrk_name ORDER BY A.EBNO,TRAN_DATE
) GROUP BY EBNO
) D 
WHERE  A.EBNO=B.EBNO AND A.EBNO=C.EBNO(+) AND A.EBNO=D.EBNO and SUBSTR(A.EBNO,1,1) NOT IN ('L','C') 
) A,INCENTIVE_TABLE B WHERE A.EFF=B.EFF_INC(+) ORDER BY GEFF,A.EBNO,TRAN_DATE 
";



 
//echo $sqa;
//die();
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
<td font size=45><?php echo "<br>" ." S4 Weavers Incentive Report From Dated :".$date->format('d-m-Y')." To ".$date1->format('d-m-Y') .$yarn."</br>"; ?></td>
</div>

<div>

<?php	

 
echo  "<p>&nbsp</p>";
echo  "<p>&nbsp</p>";
//echo  "<p>&nbsp</p>";




echo "<table border='2' >\n";


$bgcolor1=	"#C9C299";
		$bgcolor2=	"#F9966B";
		$bg4="#E0FFFF";
 
//echo "</table>\n";

 

echo "<table border=\"1\" </td>";
 
echo "<table width=\"100%\" border='1'   
          bgcolor=\"#C9C299\"class=\"scrollTable\">";

echo "    <td font color='#C9C299'>" . "EBNO" . "</td>\n</font>";
echo "    <<td font color='#FFFF00' >" . "Name" . "</td>\n</font>";

		  
		  $a1=$sday;
 
for ($a1=$sday; $a1 <= $nday; $a1++) {
		echo "<td align='center'>" .$a1. "</td>\n";
}
		echo "<td style=word-wrap: break-word;>" .'Avg Eff(%)'. "</td>\n";

//ECHO "<td style=word-wrap: break-word;>";		
		
		echo "<td>" .'No of Days'. "</td>\n";
		echo "<td>" .'Inc Days'. "</td>\n";
		echo "<td>" .'Inc Amt'. "</td>\n";
		 

 
echo "<tr>\n";
$eb="N";	
$clr="";	  
$pda=0;
$cda=1;
$exda=0;
$avg=0;
$noda=0;
$tnoda=0;
$tcntm=0;
$tincamt=0;

$cntm=0;
$incamt=0;
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
//ECHO $row['EBNO'];
    if ($eb<>$row['EBNO']) {
	if ($eb <>'N') {
	$cda=$nday;
	$exda=$cda-$pda;
    $clr="#F8F8F8";
	if ($exda>=1) {
	for ($a1=1; $a1 <= $exda; $a1++) {
		echo "<td align='center' bgcolor=$clr >" .'X'. "</td>\n";
	}
	}	

	$clr="#F8F8F8";
	
	$v=$avg;
	if ($v<40) {
		$clr="#FF0000";
	}
	if ($v>=40 and $v<50) {
		$clr="#FFFF00";
	$clr="#F8F8F8";}
	if ($v>=50 and $v<58) {
		$clr="#B0E0E6";
$clr="#F8F8F8";	}
	
	if ($v>=60) {
		$clr="#7FFF00";
	}
	


	echo "<td align='center'  bgcolor=$clr >" .$avg. "</td>\n";
	echo "<td align='center' bgcolor=$clr >" .$noda. "</td>\n";
	echo "<td align='center' bgcolor=$clr >" .$cntm. "</td>\n";
	echo "<td align='center' bgcolor=$clr >" .$incamt. "</td>\n";
	
	
	$tcntm=$tcntm+$cntm;
	$tincamt=$tincamt+$incamt;	
	$tnoda=$tnoda+$noda;
	$cntm=0;
	$incamt=0;
	
	
	}
	

	
    	echo "<tr>\n";
$clr="#E6E6FA";
		
		$eb=$row['EBNO'];
		echo "<td bgcolor=$clr >" .$row['EBNO']. "</td>\n";
		echo "<td bgcolor=$clr >" .$row['WRK_NAME']. "</td>\n";
		$pda=$sday-1;
		$avg=$row['GEFF'];
		$noda=$row['NODAYS'];
		//$cntm=$row['CNT'];
		
		
	}		
/* 	pda=
	if pda-cda
 */	
	$date=$row['TRAN_DATE'];
	//$date->format('d-m-Y')
	  $dt = new DateTime($date);
	//  echo $dt;
	//echo $date;
	
	$cda=$dt->format('d-m-Y');
	$cda= date('d', strtotime($cda));
	//echo $cda;
	//echo $row['TRAN_DATE'];
	$exda=$cda-$pda;
	if ($eb=="02255" ) {
//echo 'cd '.$cda.' pd '. $pda.' exda '.$exda;

	}
	if($eb=='02255') {
	//echo $cda.'=='.$pda.'=='.$exda.' mm ';
	
}
	
	$clr="#F8F8F8";
	if ($exda>1) {
	for ($a1=1; $a1 < $exda; $a1++) {
	echo "<td align='center' bgcolor=$clr >" .'X'. "</td>\n";
	}
	}	
		

		
	$clr="#F8F8F8";
	
	$v=$row['EFF'];
	
	
	
	if ($v<40) {
		$clr="#FF0000";
	}
	if ($v>=40 and $v<50) {
		$clr="#FFFF00";
		$clr="#F8F8F8";
	}
	if ($v>=50 and $v<58) {
		$clr="#B0E0E6";
		$clr="#F8F8F8";
		}
	
	if ($v>=60) {
		$clr="#7FFF00";
	}
	if ($v>=60) {
		$cntm++;
		$incamt=$incamt+$row['TOT_RATE'];
	}
	
	
	echo "<td bgcolor=$clr >" .$row['EFF']. "</td>\n";
	
	$pda=$cda;

	}
		  
	if ($eb <>'N') {
	$cda=$nday;
	$exda=$cda-$pda;
	/* echo $eb;
	echo 'cda=='.$cda;
	echo 'pda='.$pda;
	echo 'exda='.$exda;
 */	$clr="#F8F8F8";
	if ($exda>=1) {
	for ($a1=1; $a1 <= $exda; $a1++) {
	echo "<td align='center' bgcolor=$clr >" .'X'. "</td>\n";
	}
	}	

	$clr="#F8F8F8";
	
	$v=$avg;
	if ($v<=40) {
		$clr="#FF0000";
	}
	if ($v>40 and $v<=50) {
		$clr="#FFFF00";
$clr="#F8F8F8";	}
	if ($v>50 and $v<=58) {
		$clr="#B0E0E6";
$clr="#F8F8F8";	}
	
	if ($v>=60) {
		$clr="#7FFF00";
	}
	

	echo "<td align='center'  bgcolor=$clr >" .$avg. "</td>\n";
	echo "<td align='center' bgcolor=$clr >" .$noda. "</td>\n";
	echo "<td align='center' bgcolor=$clr >" .$cntm. "</td>\n";
	echo "<td align='center' bgcolor=$clr >" .$incamt. "</td>\n";

	}
	
$tcntm=$tcntm+$cntm;
	$tincamt=$tincamt+$incamt;
	$tnoda=$tnoda+$noda;
    	echo "<tr>\n";
		
	echo "<td align='center' bgcolor=$clr >" .''. "</td>\n";
	echo "<td align='center' bgcolor=$clr >" .'Overall'. "</td>\n";
$pda=0;
$cda=1;
$exda=0;

$sql="SELECT TRAN_DATE,ROUND(SUM(QUANTITY)/SUM(STDPROD)*100,0) EFF  FROM ATTENEMP.DAILY_LOOM_DATA A,ATTENEMP.LOOM_MASTER B WHERE TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd')
AND TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd') AND QUANTITY>0 AND A.LOOM_NO=B.LOOM_NO AND LOOM_TYPE='G'
GROUP BY TRAN_DATE ORDER BY TRAN_DATE";

//echo $sql;

$stid = oci_parse($conn,$sql );
oci_execute($stid);
	
	$cda=1;
	$exda=$nday-$sday+3;
    $clr="#F8F8F8";
	if ($exda>=1) {
	//for ($a1=1; $a1 <= $exda; $a1++) {

$pda=$sday-1;
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	 
	
	$date=$row['TRAN_DATE'];
	//$date->format('d-m-Y')
	 $dt = new DateTime($date);
	 
	
	$cda=$dt->format('d-m-Y');
	$cda= date('d', strtotime($cda));
	 
	 
	$exda=$cda-$pda;
 	 
	
	$clr="#F8F8F8";
	if ($exda>1) {
	 
	for ($a1=1; $a1 < $exda; $a1++) {
		
		echo "<td align='center' bgcolor=$clr >" .'X'. "</td>\n";
		
	}
	}	
	
	
	$clr="#F8F8F8";
	$avg=$row['EFF'];
	$v=$avg;
	if ($v<=40) {
		$clr="#FF0000";
	}
	if ($v>40 and $v<=50) {
		$clr="#FFFF00";
$clr="#F8F8F8";	}
	if ($v>50 and $v<=58) {
		$clr="#B0E0E6";
$clr="#F8F8F8";	}
	
	if ($v>=60) {
		$clr="#7FFF00";
	}
	

	
		echo "<td align='center' bgcolor=$clr >" .$row['EFF']. "</td>\n";
		
		
			$pda=$cda;
	
}

//	echo "<td align='center' bgcolor=$clr >" .'X'. "</td>\n";



		}
//	}	

$sql="SELECT ROUND(SUM(QUANTITY)/SUM(STDPROD)*100,0) EFF  FROM DAILY_LOOM_DATA A,ATTENEMP.LOOM_MASTER B 
WHERE TRAN_DATE>=TO_DATE('$dt1','yyyy/mm/dd')
AND TRAN_DATE<=TO_DATE('$dt2','yyyy/mm/dd') AND QUANTITY>0 AND A.LOOM_NO=B.LOOM_NO AND LOOM_TYPE='G'
";
$stid = oci_parse($conn,$sql );
oci_execute($stid);
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	
	$clr="#F8F8F8";
	$avg=$row['EFF'];
	$v=$avg;
	if ($v<=40) {
		$clr="#FF0000";
	}
	if ($v>40 and $v<=50) {
		$clr="#FFFF00";
$clr="#F8F8F8";	}
	if ($v>50 and $v<=58) {
		$clr="#B0E0E6";
$clr="#F8F8F8";	}
	
	if ($v>=60) {
		$clr="#7FFF00";
	}
	
	
echo "<td align='center' bgcolor=$clr >" .$row['EFF']. "</td>\n";

}

	echo "<td align='center' bgcolor=$clr >" .$tnoda. "</td>\n";
	echo "<td align='center' bgcolor=$clr >" .$tcntm. "</td>\n";
	echo "<td align='center' bgcolor=$clr >" .$tincamt. "</td>\n";


	



	
	
	
	
	
		
?>		
		
		
		
		</table>
		</div>
		
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

 
			<a href="index.php">Home</a>

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

 
			<a href="s4loomdatreptincexlexl.php">Export to Excel</a>

</div>

<div style="buttom :0;    position: absolute;   ">

<?php
if ($yarn=="H") {

?> 
<marquee bgcolor="#000000"><font color="#FF0000">Red - CURRENT EFFICIENCY IS LESS THAN 40%</font></marquee>
<marquee bgcolor="#000000"><font color="#FFFF00">Yellow - CURRENT EFFICIENCY between 40% and 49.90%</font></marquee>
<marquee bgcolor="#000000"><font color="#CCEEFF">Ash - CURRENT EFFICIENCY between 50% and 57.90%</font></marquee>
<marquee bgcolor="#000000"><font color="#00FF00">Green -  CURRENT EFFICIENCY IS 58% Above </font></marquee>
<?php


}
?> 
<?php
if ($yarn=="S") {

?> 
<marquee bgcolor="#000000"><font color="#FF0000">Red - CURRENT EFFICIENCY IS LESS THAN 60%</font></marquee>
<marquee bgcolor="#000000"><font color="#FFFF00">Yellow - CURRENT EFFICIENCY between 60% and 69.90%</font></marquee>
<marquee bgcolor="#000000"><font color="#CCEEFF">Ash - CURRENT EFFICIENCY between 70% and 77.90%</font></marquee>
<marquee bgcolor="#000000"><font color="#00FF00">Green -  CURRENT EFFICIENCY IS 78% and Above</font></marquee>
<?php


}
?> 

		
		
</div>		
		
		  
		  
		  
		  
 </body>
</html>



		