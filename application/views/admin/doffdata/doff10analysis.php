<html>
<body>
<div align="center">

</div>
    
</body>
</html> 

<script  src="http://code.jquery.com/jquery-1.9.1.min.js" ></script>    
<HEAD>
<meta http-equiv='refresh' content='500;url='index.php'>

</HEAD>

<script>
    $(document).ready(function(){
        $("#myTable td").click(function() {     
 
            var column_num = parseInt( $(this).index() ) + 1;
            var row_num = parseInt( $(this).parent().index() )+1;    
 
            $("#result").html( "Row_num =" + row_num + "  ,  Rolumn_num ="+ column_num );   
        });
    });
</script>

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

<td font size=45><blink>Welcome To Web Portal<blink></td>

</div>

<p></p>

 

</body>
</html>

<?php

 
/*
$sql="SELECT P1.MC_NUM,P1.DOFFDATE,P1.A1EBNO,P1.WRK_NAME A1NAME,P1.A1QCODE,P1.TYPE A1QUALITY,P1.STD_COUNT A1STDCOUNT,P1.SPEED A1SPEED,substr(P1.FRAME_TYPE,1,1) frame_type,
P1.SPINDLE,P1.FRAME,P1.TPI A1TPI,
NVL(P1.A1NETWT,0) A1NETWT,NVL(P1.A1DOFFNO,0) A1DOFFNO,NVL(P1.A1AVGWT,0) A1AVGWT,A2EBNO,P2.WRK_NAME A2NAME,A2QCODE,P2.TYPE A2QUALITY,
P2.STD_COUNT A2STDCOUNT,P2.SPEED A2SPEED,P2.TPI A2TPI,
NVL(A2NETWT,0) A2NETWT,NVL(A2DOFFNO,0) A2DOFFNO,NVL(A2AVGWT,0) A2AVGWT,
P3.B1EBNO,P3.WRK_NAME B1NAME,P3.B1QCODE,P3.TYPE B1QUALITY,P3.STD_COUNT B1STDCOUNT,P3.SPEED B1SPEED,P3.TPI B1TPI,
NVL(P3.B1NETWT,0) B1NETWT,NVL(P3.B1DOFFNO,0) B1DOFFNO,NVL(P3.B1AVGWT,0) B1AVGWT,
B2EBNO,P4.WRK_NAME B2NAME,B2QCODE,P4.B2QCODE,P4.TYPE B2QUALITY,P4.STD_COUNT B2STDCOUNT,P4.SPEED B2SPEED,P4.TPI B2TPI,NVL(B2NETWT,0) B2NETWT,
NVL(B2DOFFNO,0) B2DOFFNO,NVL(B2AVGWT,0) B2AVGWT,
CEBNO,P5.WRK_NAME CNAME,CQCODE,P5.CQCODE,P5.TYPE CQUALITY,P5.STD_COUNT CSTDCOUNT,P5.SPEED CSPEED,P5.TPI CTPI,NVL(CNETWT,0) CNETWT,NVL(CDOFFNO,0) CDOFFNO,NVL(CAVGWT,0) CAVGWT
FROM 
(
SELECT G.*,SPINDLE_QTY_TYPE FRAME,MC_NUM
FROM (
SELECT DOFFDATE,FRAMENO,STD_COUNT,SPEED,TPI,A.EBNO A1EBNO,C.Q_CODE A1QCODE,SUM(NETWT) AS A1NETWT,COUNT(*) AS A1DOFFNO,
ROUND(SUM(NETWT)/COUNT(*),2) AS A1AVGWT,WRK_NAME,TYPE,SPINDLE,FRAME_TYPE
FROM $dbam.DOFFTABLE A,$dbam.WORKER_MASTER B,$dbam.SPINMAST C WHERE 
SPELL='A1' AND DOFFDATE>=TO_DATE('$dt','yyyy/mm/dd') AND DOFFDATE<=TO_DATE('$dt2','yyyy/mm/dd') AND A.Q_CODE=C.Q_CODE(+) AND A.EBNO=B.EB_NO(+) 
GROUP BY DOFFDATE,FRAMENO,A.EBNO,C.Q_CODE,WRK_NAME,TYPE,SPINDLE,FRAME_TYPE ,STD_COUNT,SPEED,TPI
) G,$dbam.FRAMEMST H WHERE G.FRAMENO(+)=H.FRAMENO AND SIDE<>'W' order by MC_NUM

) P1,
(
SELECT G.*,SPINDLE_QTY_TYPE FRAME,MC_NUM
FROM (
SELECT DOFFDATE,FRAMENO,STD_COUNT,SPEED,TPI,A.EBNO A2EBNO,C.Q_CODE A2QCODE,SUM(NETWT) AS A2NETWT,COUNT(*) AS A2DOFFNO,
ROUND(SUM(NETWT)/COUNT(*),2) AS A2AVGWT,WRK_NAME,TYPE,SPINDLE,FRAME_TYPE
FROM $dbam.DOFFTABLE A,$dbam.WORKER_MASTER B,$dbam.SPINMAST C WHERE 
SPELL='A2' AND DOFFDATE>=TO_DATE('$dt','yyyy/mm/dd') AND DOFFDATE<=TO_DATE('$dt2','yyyy/mm/dd') AND A.Q_CODE=C.Q_CODE(+) AND A.EBNO=B.EB_NO(+) 
GROUP BY DOFFDATE,FRAMENO,A.EBNO,C.Q_CODE,WRK_NAME,TYPE,SPINDLE,FRAME_TYPE ,STD_COUNT,SPEED,TPI
) G,$dbam.FRAMEMST H WHERE G.FRAMENO(+)=H.FRAMENO AND SIDE<>'W' order by MC_NUM

) P2 ,
(
SELECT G.*,SPINDLE_QTY_TYPE FRAME,MC_NUM
FROM (
SELECT DOFFDATE,FRAMENO,STD_COUNT,SPEED,TPI,A.EBNO B1EBNO,C.Q_CODE B1QCODE,SUM(NETWT) AS B1NETWT,COUNT(*) AS B1DOFFNO,
ROUND(SUM(NETWT)/COUNT(*),2) AS B1AVGWT,WRK_NAME,TYPE,SPINDLE,FRAME_TYPE
FROM $dbam.DOFFTABLE A,$dbam.WORKER_MASTER B,$dbam.SPINMAST C WHERE 
SPELL='B1' AND DOFFDATE>=TO_DATE('$dt','yyyy/mm/dd') AND DOFFDATE<=TO_DATE('$dt2','yyyy/mm/dd') AND A.Q_CODE=C.Q_CODE(+) AND A.EBNO=B.EB_NO(+) 
GROUP BY DOFFDATE,FRAMENO,A.EBNO,C.Q_CODE,WRK_NAME,TYPE,SPINDLE,FRAME_TYPE ,STD_COUNT,SPEED,TPI
) G,$dbam.FRAMEMST H WHERE G.FRAMENO(+)=H.FRAMENO AND SIDE<>'W' order by MC_NUM
) P3 ,
(
SELECT G.*,SPINDLE_QTY_TYPE FRAME,MC_NUM
FROM (
SELECT DOFFDATE,FRAMENO,STD_COUNT,SPEED,TPI,A.EBNO B2EBNO,C.Q_CODE B2QCODE,SUM(NETWT) AS B2NETWT,COUNT(*) AS B2DOFFNO,
ROUND(SUM(NETWT)/COUNT(*),2) AS B2AVGWT,WRK_NAME,TYPE,SPINDLE,FRAME_TYPE
FROM $dbam.DOFFTABLE A,$dbam.WORKER_MASTER B,$dbam.SPINMAST C WHERE 
SPELL='B2' AND DOFFDATE>=TO_DATE('$dt','yyyy/mm/dd') AND DOFFDATE<=TO_DATE('$dt2','yyyy/mm/dd') AND A.Q_CODE=C.Q_CODE(+) AND A.EBNO=B.EB_NO(+) 
GROUP BY DOFFDATE,FRAMENO,A.EBNO,C.Q_CODE,WRK_NAME,TYPE,SPINDLE,FRAME_TYPE ,STD_COUNT,SPEED,TPI
) G,$dbam.FRAMEMST H WHERE G.FRAMENO(+)=H.FRAMENO AND SIDE<>'W' order by MC_NUM
) P4 ,
(

SELECT G.*,SPINDLE_QTY_TYPE FRAME,MC_NUM
FROM (
SELECT DOFFDATE,FRAMENO,STD_COUNT,SPEED,TPI,A.EBNO CEBNO,C.Q_CODE CQCODE,SUM(NETWT) AS CNETWT,COUNT(*) AS CDOFFNO,
ROUND(SUM(NETWT)/COUNT(*),2) AS CAVGWT,WRK_NAME,TYPE,SPINDLE,FRAME_TYPE
FROM $dbam.DOFFTABLE A,$dbam.WORKER_MASTER B,$dbam.SPINMAST C WHERE 
(SPELL='C1' OR SPELL='C2') AND DOFFDATE>=TO_DATE('$dt','yyyy/mm/dd') AND DOFFDATE<=TO_DATE('$dt2','yyyy/mm/dd') AND A.Q_CODE=C.Q_CODE(+) AND A.EBNO=B.EB_NO(+) 
GROUP BY DOFFDATE,FRAMENO,A.EBNO,C.Q_CODE,WRK_NAME,TYPE,SPINDLE,FRAME_TYPE ,STD_COUNT,SPEED,TPI
) G,$dbam.FRAMEMST H WHERE G.FRAMENO(+)=H.FRAMENO AND SIDE<>'W' order by MC_NUM

) P5
WHERE P1.MC_NUM=P2.MC_NUM AND P1.MC_NUM=P3.MC_NUM AND 
P1.MC_NUM=P4.MC_NUM AND P1.MC_NUM=P5.MC_NUM ORDER BY P1.MC_NUM";
*/
//echo $sql;

$sql = "select mech_code,bobbin_count,doffdate,
max(case when spell='A1' then doffno else 0 end  ) a1doffno,
max(case when spell='A1' then prod else 0 end  ) a1prod,
max(case when spell='A1' then speed else 0 end  ) a1speed,
max(case when spell='A1' then spindle_count else 0 end  ) a1spindle,
max(case when spell='A1' then std_doff else 0 end  ) a1stddoff,
max(case when spell='A1' then std_doff_wt else 0 end  ) a1stddoffwt,
max(case when spell='A1' then yarn_count else 0 end  ) a1stdcount,
max(case when spell='B1' then doffno else 0 end  ) b1doffno,
max(case when spell='B1' then prod else 0 end  ) b1prod,
max(case when spell='B1' then speed else 0 end  ) b1speed,
max(case when spell='B1' then spindle_count else 0 end  ) b1spindle,
max(case when spell='B1' then std_doff else 0 end  ) b1stddoff,
max(case when spell='B1' then std_doff_wt else 0 end  ) b1stddoffwt,
max(case when spell='B1' then yarn_count else 0 end  ) b1stdcount,
max(case when spell='A2' then doffno else 0 end  ) a2doffno,
max(case when spell='A2' then prod else 0 end  ) a2prod,
max(case when spell='A2' then speed else 0 end  ) a2speed,
max(case when spell='A2' then spindle_count else 0 end  ) a2spindle,
max(case when spell='A2' then std_doff else 0 end  ) a2stddoff,
max(case when spell='A2' then std_doff_wt else 0 end  ) a2stddoffwt,
max(case when spell='A2' then yarn_count else 0 end  ) a2stdcount,
max(case when spell='B2' then doffno else 0 end  ) b2doffno,
max(case when spell='B2' then prod else 0 end  ) b2prod,
max(case when spell='B2' then speed else 0 end  ) b2speed,
max(case when spell='B2' then spindle_count else 0 end  ) b2spindle,
max(case when spell='B2' then std_doff else 0 end  ) b2stddoff,
max(case when spell='B2' then std_doff_wt else 0 end  ) b2stddoffwt,
max(case when spell='B2' then yarn_count else 0 end  ) b2stdcount,
max(case when spell='C' then doffno else 0 end  ) cdoffno,
max(case when spell='C' then prod else 0 end  ) cprod,
max(case when spell='C' then speed else 0 end  ) cspeed,
max(case when spell='C' then spindle_count else 0 end  ) cspindle,
max(case when spell='C' then std_doff else 0 end  ) cstddoff,
max(case when spell='C' then std_doff_wt else 0 end  ) cstddoffwt,
max(case when spell='C' then yarn_count else 0 end  ) cstdcount
from (
select mm.mech_code,mm.bobbin_count,substr(doffdate,1,10) doffdate,substr(d.spell,1,1) shift,d.spell,count(*) doffno,
round(sum(netwt),2) prod,wqm.speed,wqm.tpi,spindle_count,std_doff,std_doff_wt,yarn_count
from dofftable d 
left join mechine_master mm on mm.mach_shr_code =d.frameno and type_of_mechine =36 and d.company_id =mm.company_id
left join (select * from daily_weaving_qualities dwq where dwq.is_active=1 and company_id=2 ) dwq  on d.company_id =dwq.company_id 
and dwq.mc_id =mm.mechine_id and d.doffdate =dwq.wv_qual_date 
and d.spell =dwq.spell
left join (select * from tbl_prod_weaving_quality_mapping tpwqm where tpwqm.is_active =1 and tpwqm.quality_type=2   ) tpwqm
on tpwqm.company_id = d.company_id and mm.mechine_id =dwq.mc_id 
and tpwqm.quality_id =dwq.quality_id 
left join weaving_quality_master wqm on tpwqm.quality_id=tpwqm.quality_id
where doffdate ='2024-01-01' and d.is_active =1
and d.company_id=2 
group by mm.mech_code,mm.bobbin_count,substr(doffdate,1,10) ,substr(d.spell,1,1),spell,wqm.speed,wqm.tpi,spindle_count,std_doff,std_doff_wt,yarn_count
) g group by mech_code,bobbin_count,doffdate
order by mech_code
";

$query2 = $this->db->query($sql);



	  $date = new DateTime($sdate);
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

<td font size=45><?php echo "    <br>" . "Daily DOFF Report (DOFF 10) Dated :".$date->format('d-m-Y'). "</br>"; ?></td>

</div>
<div
   style="
      top: 30;
      left: 1;
	  text-align:right;
	  width:1000;
	  font-size : 20px;
      position: absolute;
      z-index: 3;
	  visibility: show;">

 
			<a href="mainpage.php">Home</a>

</div>
<div
   style="
      top: 50;
      left: 1;
	  text-align:right;
	  width:1000;
	  font-size : 20px;
      position: absolute;
      z-index: 3;
	  visibility: show;">

 
			<a href="spgdof10reptSUMMdatewiseexlspl.php">Spell Report(Excel)</a>

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

 
			<a href="spgdof10reptSUMMdatewiseexl.php">Export to Excel</a>

</div>
<div id="result"> </div>

<?php	
echo  "<p>&nbsp</p>";
echo  "<p>&nbsp</p>";
echo  "<p>&nbsp</p>";

 
//	echo "    <td>" . "The Empire Ju 

//echo "<table border='2' >\n";


?>



<?php





$bgcolor1=	"#C9C299";
		$bgcolor2=	"#F9966B";
		$bg4="#E0FFFF";
 
echo "</table>\n";
?> 
 

  
<?php
 

//echo "<table border=\"1\" </td>";
 
echo "<table width=\"100%\" border='1'   
          bgcolor=\"#C9C299\" class=\"scrollTable\" ><td>";
 



echo "<tr><th colspan=\"1\"> Frame </td>\n";
echo "<th colspan=\"1\"> Frame </td>\n";

echo "<th colspan=\"4\"> Spell A1 </td>\n";
 

echo "<th colspan=\"4\"> Spell A2 </td>\n";
echo "<th colspan=\"4\"> Shift A </td>\n";

echo "<th colspan=\"4\"> Spell B1 </td>\n";
echo "<th colspan=\"4\"> Spell B2 </td>\n";
echo "<th colspan=\"4\"> Shift B </td>\n";

echo "<th colspan=\"5\"> Spell C </td>\n";
echo "<th colspan=\"4\"> Overall </td>\n";



echo "    <tr><td font color='#FFFF00' >" . " No /Spindle". "&nbsp;" . "</td>\n</font>";
echo "    <td font color='#FFFF00' >" . "Std Avg Wt/doff". "&nbsp;" . "</td>\n</font>";

echo "    <td>" . "Std Doff". "&nbsp;" . "</td>\n";
//echo "    <td>" . "Trg Doff". "&nbsp;" . "</td>\n";
echo "    <td>" . "No of Doff". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod". "&nbsp;" . "</td>\n";
echo "    <td>" . "Avg Doff Wt". "&nbsp;" . "</td>\n";

echo "    <td>" . "Std Doff". "&nbsp;" . "</td>\n";
//echo "    <td>" . "Trg Doff". "&nbsp;" . "</td>\n";

echo "    <td>" . "No of Doff". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod". "&nbsp;" . "</td>\n";
echo "    <td>" . "Avg Doff Wt". "&nbsp;" . "</td>\n";
echo "    <td>" . "No of Doff". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod". "&nbsp;" . "</td>\n";
echo "    <td>" . "Avg Doff Wt". "&nbsp;" . "</td>\n";
echo "    <td>" . "Eff(%)". "&nbsp;" . "</td>\n";

echo "    <td>" . "Std Doff". "&nbsp;" . "</td>\n";
echo "    <td>" . "No of Doff". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod". "&nbsp;" . "</td>\n";
echo "    <td>" . "Avg Doff Wt". "&nbsp;" . "</td>\n";
echo "    <td>" . "Std Doff". "&nbsp;" . "</td>\n";
echo "    <td>" . "No of Doff". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod". "&nbsp;" . "</td>\n";
echo "    <td>" . "Avg Doff Wt". "&nbsp;" . "</td>\n";
echo "    <td>" . "No of Doff". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod". "&nbsp;" . "</td>\n";
echo "    <td>" . "Avg Doff Wt". "&nbsp;" . "</td>\n";
echo "    <td>" . "Eff(%)". "&nbsp;" . "</td>\n";
 
echo "    <td>" . "Std Doff". "&nbsp;" . "</td>\n";
echo "    <td>" . "No of Doff". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod". "&nbsp;" . "</td>\n";
echo "    <td>" . "Avg Doff Wt". "&nbsp;" . "</td>\n";
echo "    <td>" . "Eff(%)". "&nbsp;" . "</td>\n";

 
echo "    <td>" . "No of Doff". "&nbsp;" . "</td>\n";
echo "    <td>" . "Prod". "&nbsp;" . "</td>\n";
echo "    <td>" . "Avg Doff Wt". "&nbsp;" . "</td>\n";
echo "    <td>" . "Eff(%)". "&nbsp;" . "</td>\n";


 
 
 




  
$x=0;

$qc1="";	
$n=1;
$color="1";

$a1mc=0;
$a2mc=0;
$b1mc=0;
$b2mc=0;
$cmc=0;
$amc=0;
$bmc=0;
$cmc=0;

$gprda1=0;
$gprda2=0;
$gprda=0;
$gprdb1=0;
$gprdb2=0;
$gprdb=0;
$gprdc=0;



foreach ($query2->result() as $record) {

    echo "<tr>\n";
	 $x++; 
 
$hra1=0;
$hra2=0;
$hrb1=0;
$hrb2=0;
$hrc=0;
$stpda1=0;
$stpda2=0;
$stpdb1=0;
$stpdb2=0;
$stpdc=0;
$stda1=0;
$stda2=0;
$stdb1=0;
$stdb2=0;
$stdc=0;
$stdf=0;
$tgdf=0;

if ($x%2 == 0) 
 echo "<tr bgcolor='	#F9966B'>";

else 
 echo "<tr bgcolor='#ECD672'>";

 //	echo "<td><a href='spgdof10reptdet.php?value=".$row['MC_NUM']."'>".$row['MC_NUM']."&nbsp/&nbsp".number_format($row['FRAME'],0)."</td>";

	
if ($record->a1prod>0) { 
 	$hra1=5;
}
if ($record->a2prod>0) { 
 	$hra2=3;
}
	
if ($record->b1prod>0) { 
 	$hrb1=3;
}
if ($record->b2prod>0) { 
 	$hrb2=5;
}
if ($record->cprod>0) { 
 	$hrc=7.5;
}

	
	

//ECHO $row['A1SPEED']."===".$row['A1TPI']."=====".$row['A1STDCOUNT']."==".$row['MC_NUM'];
		$stdf=round((350*$record->spindle)/1000,2);
 
		IF ($record->a1speed>0) {
		$stda1=($record->a1speed/$record->a1tpi)*(1/36)*($record->a1stdcount/14400)*453.6;
		$stdn1=350/$stda1;
		$stda1=round($hra1/$stdn1,0)*2;
		$stda1=(($hra1*60)-$stda1)/$stdn1;
		}
		IF ($record->A2SPEED>0) {
		$stda2=($record->a2speed/$record->a2tpi)*(1/36)*($record->a2stdcount/14400)*453.6;
		$stdn2=350/$stda2;
		$stda2=round($hra2/$stdn2,0)*2;
		$stda2=(($hra2*60)-$stda2)/$stdn2;
		} 
IF ($record->b1speed>0) {
		$stdb1=($record->b1speed/$record->b1tpi)*(1/36)*($record->b1stdcount/14400)*453.6;
		$stdn1=350/$stdb1;
		$stdb1=round($hrb1/$stdn1,0)*2;
		$stdb1=(($hrb1*60)-$stdb1)/$stdn1;
}
IF ($record->b2speed>0) {
	$stdb2=($record->b2speed/$record->b2tpi)*(1/36)*($record->b2stdcount/14400)*453.6;
		$stdn1=350/$stdb2;
		$stdb2=round($hrb2/$stdn1,0)*2;
		$stdb2=(($hrb2*60)-$stdb2)/$stdn1;
}		
IF ($record->cspeed>0) {
$stdc=($record->cspeed/$record->cspeed)*(1/36)*($record->cstdcount/14400)*453.6;
		$stdn1=350/$stdc;
		$stdc=round($hrc/$stdn1,0)*2;
		$stdc=(($hrc*60)-$stdc)/$stdn1;
}
	
$ef=0; 
$qc=$record->mech_code;
	if ($record->spell=='A1') {
		$stpda1=ROUND(($record->a1speed*$hra1*60*$rowa['ACT_COUNT']*$rowa['SPINDLE'])/($rowa['TWIST_PER_INCH']*14400*2.2046*36),2);
		$ef=0;
		$stda1=($rowa['SPEED']/$rowa['TWIST_PER_INCH'])*(1/36)*($row['A1STDCOUNT']/14400)*453.6;
		$stdn1=350/$stda1;
		$stda1=round($hra1/$stdn1,0)*2;
		$stda1=(($hra1*60)-$stda1)/$stdn1;

		
		
		}
	if ($rowa['SPELL']=='A2') {
		$stpda2=ROUND(($rowa['SPEED']*$hra2*60*$rowa['ACT_COUNT']*$rowa['SPINDLE'])/($rowa['TWIST_PER_INCH']*14400*2.2046*36),2);
		$ef=0;
		$stda2=($rowa['SPEED']/$rowa['TWIST_PER_INCH'])*(1/36)*($row['A2STDCOUNT']/14400)*453.6;
		$stdn2=350/$stda2;
		$stda2=round($hra2/$stdn2,0)*2;
		$stda2=(($hra2*60)-$stda2)/$stdn2;
		
		
		
		
		
	}
	if ($rowa['SPELL']=='B1') {
		$stpdb1=ROUND(($rowa['SPEED']*$hrb1*60*$rowa['ACT_COUNT']*$rowa['SPINDLE'])/($rowa['TWIST_PER_INCH']*14400*2.2046*36),2);
//		$ef=0;

		$stdb1=($rowa['SPEED']/$rowa['TWIST_PER_INCH'])*(1/36)*($row['B1STDCOUNT']/14400)*453.6;
		$stdn1=350/$stdb1;
		$stdb1=round($hrb1/$stdn1,0)*2;
		$stdb1=(($hrb1*60)-$stdb1)/$stdn1;


	}
	if ($rowa['SPELL']=='B2') {
		$stpdb2=ROUND(($rowa['SPEED']*$hrb2*60*$rowa['ACT_COUNT']*$rowa['SPINDLE'])/($rowa['TWIST_PER_INCH']*14400*2.2046*36),2);
		$ef=0;
		$stdb2=($rowa['SPEED']/$rowa['TWIST_PER_INCH'])*(1/36)*($row['B2STDCOUNT']/14400)*453.6;
		$stdn1=350/$stdb2;
		$stdb2=round($hrb2/$stdn1,0)*2;
		$stdb2=(($hrb2*60)-$stdb2)/$stdn1;
		
		
		
	}
	if ($rowa['SPELL']=='C1') {
		$stpdc=ROUND(($rowa['SPEED']*$hrc*60*$rowa['ACT_COUNT']*$rowa['SPINDLE'])/($rowa['TWIST_PER_INCH']*14400*2.2046*36),2);
		$ef=0;
		$stdc=($rowa['SPEED']/$rowa['TWIST_PER_INCH'])*(1/36)*($row['CSTDCOUNT']/14400)*453.6;
		$stdn1=350/$stdc;
		$stdc=round($hrc/$stdn1,0)*2;
		$stdc=(($hrc*60)-$stdc)/$stdn1;
	}

	
	}

//	echo $stda1;
	
$gprda1=$gprda1+ $row['A1NETWT'];
$gprda2=$gprda2+ $row['A2NETWT'];
$gprda=$gprda+ $row['A1NETWT']+ $row['A2NETWT'];

$gprdb1=$gprdb1+ $row['B1NETWT'];
$gprdb2=$gprdb2+ $row['B2NETWT'];
$gprdb=$gprdb+ $row['B1NETWT']+ $row['B2NETWT'];

$gprdc=$gprdc+ $row['CNETWT'];

	
//echo $stpda1;


//	echo "<td><a href='spgdof10reptdet.php?value=".$row['MC_NUM']."'>".$row['MC_NUM']."&nbsp/&nbsp".number_format($row['FRAME'],0)."</td>";

	
 	//echo "<td><a href='spgdof10reptdet.php'>".$row['MC_NUM']."</td>";

echo "<td  align=\"right\"> ".number_format($stdf ,2)."</td>";


	if ($row['A1NETWT']>0) { 
		echo "<td  align=\"right\">".number_format($stda1 ,2)."</td>";
				//	echo "<td  align=\"right\">".number_format($tardoff ,2)."</td>";

	//	echo "<td  align=\"right\">".number_format($tardoff ,2)."</td>";
		
	IF ( $row['A1AVGWT']>0 AND $row['A1AVGWT']<30 ) {
		echo "<td bgcolor='#FF0000' align=\"right\"><a href='spgdof10reptSUMMdatewiseexlspl.php?value="."A1"."'>".number_format($row['A1DOFFNO'],0)."</td>";
	
//	echo "<td> <a href='spgdof10reptdet.php?value="A1"'>"." bgcolor='#FF0000' align=\"right\">".number_format($row['A1DOFFNO'],0)."</td>";
		echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['A1NETWT'],2)."</td>";
		echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['A1AVGWT'],2)."</td>";
	}	
	IF ($row['A1AVGWT']>=30 and $row['A1AVGWT']<32  ) {
	//	echo "<td bgcolor='#9370DB' align=\"right\">".number_format($row['A1DOFFNO'],0)."</td>";
		echo "<td bgcolor='#9370DB' align=\"right\"><a href='spgdof10reptSUMMdatewiseexlspl.php?value=".A1."'>".number_format($row['A1DOFFNO'],0)."</td>";
		echo "<td bgcolor='#9370DB' align=\"right\">".number_format($row['A1NETWT'],2)."</td>";
		echo "<td bgcolor='#9370DB' align=\"right\">".number_format($row['A1AVGWT'],2)."</td>";
	}	
	IF ($row['A1AVGWT']>=32 and $row['A1AVGWT']<35  ) {
		echo "<td bgcolor='#AFEEEE' align=\"right\"><a href='spgdof10reptSUMMdatewiseexlspl.php?value=".A1."'>".number_format($row['A1DOFFNO'],0)."</td>";
		echo "<td bgcolor='#AFEEEE' align=\"right\">".number_format($row['A1NETWT'],2)."</td>";
		echo "<td bgcolor='#AFEEEE' align=\"right\">".number_format($row['A1AVGWT'],2)."</td>";
	}	

	IF ($row['A1AVGWT']>=35  ) {
		echo "<td bgcolor='#32CD32' align=\"right\"><a href='spgdof10reptSUMMdatewiseexlspl.php?value=".A1."'>".number_format($row['A1DOFFNO'],0)."</td>";
		echo "<td bgcolor='#32CD32' align=\"right\">".number_format($row['A1NETWT'],2)."</td>";
		echo "<td bgcolor='#32CD32' align=\"right\">".number_format($row['A1AVGWT'],2)."</td>";
	}	

	$a1mc++;
	$hra1=5;
 } else {
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 echo "<td align=\"center\">"."----"."</td>";
}	

if ($row['A2NETWT']>0) { 
		echo "<td  align=\"right\"><a href='spgdof10reptSUMMdatewiseexlspl.php?value="."A2"."'>".number_format($stda2 ,2)."</td>";

IF ( $row['A2AVGWT']>0 AND $row['A2AVGWT']<30 ) {
 	echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['A2DOFFNO'],0)."</td>";
	echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['A2NETWT'],2)."</td>";
	echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['A2AVGWT'],2)."</td>";
}
	IF ($row['A2AVGWT']>=30 and $row['A2AVGWT']<32  ) {
		echo "<td bgcolor='#9370DB' align=\"right\">".number_format($row['A2DOFFNO'],0)."</td>";
		echo "<td bgcolor='#9370DB' align=\"right\">".number_format($row['A2NETWT'],2)."</td>";
		echo "<td bgcolor='#9370DB' align=\"right\">".number_format($row['A2AVGWT'],2)."</td>";
	}	


	IF ($row['A2AVGWT']>=32 and $row['A2AVGWT']<35  ) {
		echo "<td bgcolor='#AFEEEE' align=\"right\">".number_format($row['A2DOFFNO'],0)."</td>";
		echo "<td bgcolor='#AFEEEE' align=\"right\">".number_format($row['A2NETWT'],2)."</td>";
		echo "<td bgcolor='#AFEEEE' align=\"right\">".number_format($row['A2AVGWT'],2)."</td>";
	}	

	IF ($row['A2AVGWT']>=35  ) {
		echo "<td bgcolor='#32CD32' align=\"right\">".number_format($row['A2DOFFNO'],0)."</td>";
		echo "<td bgcolor='#32CD32' align=\"right\">".number_format($row['A2NETWT'],2)."</td>";
		echo "<td bgcolor='#32CD32' align=\"right\">".number_format($row['A2AVGWT'],2)."</td>";
	}	

	
	
	

	$a2mc++;
	$hra2=3;
 } else {
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 echo "<td align=\"center\">"."----"."</td>";
}	

if ($row['A2NETWT']+$row['A1NETWT']>0) { 
	$v=($row['A2NETWT']+$row['A1NETWT'])/($row['A2DOFFNO']+$row['A1DOFFNO']);

	IF ($v>0 AND $v<30 ) {
		echo "<td bgcolor='#FF0000'  align=center><font color= 	#000000 >".number_format($row['A2DOFFNO']+$row['A1DOFFNO'],0)."</font></td>";
		echo "<td bgcolor='#FF0000'  align=center><font color= 	#000000 >".number_format($row['A2NETWT']+$row['A1NETWT'],2)."</font></td>";
 		echo "<td bgcolor='#FF0000'  align=center><font color= 	#000000 >".number_format($v,2)."</font></td>";
	}
	IF ($v>=30 AND $v<32 ) {
		echo "<td bgcolor='#9370DB'  align=center><font color= 	#000000 >".number_format($row['A2DOFFNO']+$row['A1DOFFNO'],0)."</font></td>";
		echo "<td bgcolor='#9370DB'  align=center><font color= 	#000000 >".number_format($row['A2NETWT']+$row['A1NETWT'],2)."</font></td>";
 		echo "<td bgcolor='#9370DB'  align=center><font color= 	#000000 >".number_format($v,2)."</font></td>";
	}
	IF ($v>=32 AND $v<35 ) {
		echo "<td bgcolor='#AFEEEE'  align=center><font color= 	#000000 >".number_format($row['A2DOFFNO']+$row['A1DOFFNO'],0)."</font></td>";
		echo "<td bgcolor='#AFEEEE'  align=center><font color= 	#000000 >".number_format($row['A2NETWT']+$row['A1NETWT'],2)."</font></td>";
 		echo "<td bgcolor='#AFEEEE'  align=center><font color= 	#000000 >".number_format($v,2)."</font></td>";
	}
	IF ($v>=35  ) {
		echo "<td bgcolor='#32CD32'  align=center><font color= 	#000000 >".number_format($row['A2DOFFNO']+$row['A1DOFFNO'],0)."</font></td>";
		echo "<td bgcolor='#32CD32'  align=center><font color= 	#000000 >".number_format($row['A2NETWT']+$row['A1NETWT'],2)."</font></td>";
 		echo "<td bgcolor='#32CD32'  align=center><font color= 	#000000 >".number_format($v,2)."</font></td>";
	}


	
 	$amc++;
 
 } else {
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";

}	

	if ($stpda1+$stpda2>0) {
		$v=$row['A2NETWT']+$row['A1NETWT'];
			$ef=round($v/($stpda1+$stpda2)*100,2);
 			echo "<td bgcolor= 	 	#FFA07A  align=center><font color= 	#000000 >".number_format($ef,2)."</font></td>";
	} else {
		echo "<td align=\"center\">"."----"."</td>";
	}

	
 

if ($row['B1NETWT']>0) { 
echo "<td  align=\"right\">".number_format($stdb1 ,2)."</td>";
	IF ( $row['B1AVGWT']>0 AND $row['B1AVGWT']<30 ) {
		//echo "<td bgcolor='#FF0000' align=\"right\"><a href='spgdof10reptSUMMdatewiseexlspl.php?value="."A1"."'>".number_format($row['A1DOFFNO'],0)."</td>";
		echo "<td bgcolor='#FF0000' align=\"right\"><a href='spgdof10reptSUMMdatewiseexlspl.php?value="."B1"."'>".number_format($row['B1DOFFNO'],0)."</td>";
		echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['B1NETWT'],2)."</td>";
		echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['B1AVGWT'],2)."</td>";
	}

	IF ( $row['B1AVGWT']>=30 AND $row['B1AVGWT']<32 ) {
		echo "<td bgcolor='#9370DB'  align=\"right\"><a href='spgdof10reptSUMMdatewiseexlspl.php?value="."B1"."'>".number_format($row['B1DOFFNO'],0)."</td>";
		echo "<td bgcolor='#9370DB'  align=\"right\">".number_format($row['B1NETWT'],2)."</td>";
		echo "<td bgcolor='#9370DB'  align=\"right\">".number_format($row['B1AVGWT'],2)."</td>";
	}
	IF ( $row['B1AVGWT']>=32 AND $row['B1AVGWT']<35 ) {
		echo "<td bgcolor='#AFEEEE'  align=\"right\"><a href='spgdof10reptSUMMdatewiseexlspl.php?value="."B1"."'>".number_format($row['B1DOFFNO'],0)."</td>";
		echo "<td bgcolor='#AFEEEE'  align=\"right\">".number_format($row['B1NETWT'],2)."</td>";
		echo "<td bgcolor='#AFEEEE' align=\"right\">".number_format($row['B1AVGWT'],2)."</td>";
	}
	IF ( $row['B1AVGWT']>=35   ) {
		echo "<td bgcolor='#32CD32'  align=\"right\"><a href='spgdof10reptSUMMdatewiseexlspl.php?value="."B1"."'>".number_format($row['B1DOFFNO'],0)."</td>";
		echo "<td bgcolor='#32CD32'  align=\"right\">".number_format($row['B1NETWT'],2)."</td>";
		echo "<td bgcolor='#32CD32' align=\"right\">".number_format($row['B1AVGWT'],2)."</td>";
	}



	$b1mc++;
	$hrb1=3;
} else {
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 echo "<td align=\"center\">"."----"."</td>";
}	

if ($row['B2NETWT']>0) { 
echo "<td  align=\"right\">".number_format($stdb2 ,2)."</td>";
	IF ( $row['B2AVGWT']>0 AND $row['B2AVGWT']<30 ) {
		echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['B2DOFFNO'],0)."</td>";
		echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['B2NETWT'],2)."</td>";
		echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['B2AVGWT'],2)."</td>";
	}

	IF ( $row['B2AVGWT']>=30 AND $row['B2AVGWT']<32 ) {
		echo "<td bgcolor='#9370DB'  align=\"right\">".number_format($row['B2DOFFNO'],0)."</td>";
		echo "<td bgcolor='#9370DB'  align=\"right\">".number_format($row['B2NETWT'],2)."</td>";
		echo "<td bgcolor='#9370DB'  align=\"right\">".number_format($row['B2AVGWT'],2)."</td>";
	}
	IF ( $row['B2AVGWT']>=32 AND $row['B2AVGWT']<35 ) {
		echo "<td bgcolor='#AFEEEE'  align=\"right\">".number_format($row['B2DOFFNO'],0)."</td>";
		echo "<td bgcolor='#AFEEEE'  align=\"right\">".number_format($row['B2NETWT'],2)."</td>";
		echo "<td bgcolor='#AFEEEE' align=\"right\">".number_format($row['B2AVGWT'],2)."</td>";
	}
	IF ( $row['B2AVGWT']>=35   ) {
		echo "<td bgcolor='#32CD32'  align=\"right\">".number_format($row['B2DOFFNO'],0)."</td>";
		echo "<td bgcolor='#32CD32'  align=\"right\">".number_format($row['B2NETWT'],2)."</td>";
		echo "<td bgcolor='#32CD32' align=\"right\">".number_format($row['B2AVGWT'],2)."</td>";
	}
		$b2mc++;
			$hrb2=5;
	} else {
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 echo "<td align=\"center\">"."----"."</td>";
}	

if ($row['B2NETWT']+$row['B1NETWT']>0) { 
	
	$v=($row['B2NETWT']+$row['B1NETWT'])/($row['B2DOFFNO']+$row['B1DOFFNO']);
	$vt=$row['B2NETWT']+$row['B1NETWT'];
	
	IF ( $v>0 AND $v<30 ) {
		echo "<td bgcolor='#FF0000' align=\"right\">".number_format(number_format($row['B2DOFFNO']+$row['B1DOFFNO'],0),0)."</td>";
		echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['B2NETWT']+$row['B1NETWT'],2)."</td>";
		echo "<td bgcolor='#FF0000' align=\"right\">".number_format($v,2)."</td>";
	}

	IF ( $v>=30 AND $v<32 ) {
		echo "<td bgcolor='#9370DB'  align=\"right\">".number_format($row['B2DOFFNO']+$row['B1DOFFNO'],0)."</td>";
		echo "<td bgcolor='#9370DB'  align=\"right\">".number_format($row['B2NETWT']+$row['B1NETWT'],2)."</td>";
		echo "<td bgcolor='#9370DB'  align=\"right\">".number_format($v,2)."</td>";
	}
	IF ( $v>=32 AND $v<35 ) {
		echo "<td bgcolor='#AFEEEE'  align=\"right\">".number_format($row['B2DOFFNO']+$row['B1DOFFNO'],0)."</td>";
		echo "<td bgcolor='#AFEEEE'  align=\"right\">".number_format($row['B2NETWT']+$row['B1NETWT'],2)."</td>";
		echo "<td bgcolor='#AFEEEE' align=\"right\">".number_format($v,2)."</td>";
	}
	IF ( $v>=35   ) {
		echo "<td bgcolor='#32CD32'  align=\"right\">".number_format(number_format($row['B2DOFFNO']+$row['B1DOFFNO'],0),0)."</td>";
		echo "<td bgcolor='#32CD32'  align=\"right\">".number_format($row['B2NETWT']+$row['B1NETWT'],2)."</td>";
		echo "<td bgcolor='#32CD32' align=\"right\">".number_format($v,2)."</td>";
	}


 	
	
 $bmc++;
 } else {
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 
}	

	if ($stpdb1+$stpdb2>0) {
		$v=$row['B2NETWT']+$row['B1NETWT'];
			$ef=round($v/($stpdb1+$stpdb2)*100,2);
 			echo "<td bgcolor= 	 	#FFA07A  align=center><font color= 	#000000 >".number_format($ef,2)."</font></td>";
	} else {
		echo "<td align=\"center\">"."----"."</td>";
	}


	
if ($row['CNETWT']>0) { 	
	echo "<td  align=\"right\">".number_format($stdc ,2)."</td>";
	
		IF ( $row['CAVGWT']>0 AND $row['CAVGWT']<30 ) {
		echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['CDOFFNO'],0)."</td>";
		echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['CNETWT'],2)."</td>";
		echo "<td bgcolor='#FF0000' align=\"right\">".number_format($row['CAVGWT'],2)."</td>";
	}

	IF ( $row['CAVGWT']>=30 AND $row['CAVGWT']<32 ) {
		echo "<td bgcolor='#9370DB'  align=\"right\">".number_format($row['CDOFFNO'],0)."</td>";
		echo "<td bgcolor='#9370DB'  align=\"right\">".number_format($row['CNETWT'],2)."</td>";
		echo "<td bgcolor='#9370DB'  align=\"right\">".number_format($row['CAVGWT'],2)."</td>";
	}
	IF ( $row['CAVGWT']>=32 AND $row['CAVGWT']<35 ) {
		echo "<td bgcolor='#AFEEEE'  align=\"right\">".number_format($row['CDOFFNO'],0)."</td>";
		echo "<td bgcolor='#AFEEEE'  align=\"right\">".number_format($row['CNETWT'],2)."</td>";
		echo "<td bgcolor='#AFEEEE' align=\"right\">".number_format($row['CAVGWT'],2)."</td>";
	}
	IF ( $row['CAVGWT']>=35   ) {
		echo "<td bgcolor='#32CD32'  align=\"right\">".number_format($row['CDOFFNO'],0)."</td>";
		echo "<td bgcolor='#32CD32'  align=\"right\">".number_format($row['CNETWT'],2)."</td>";
		echo "<td bgcolor='#32CD32' align=\"right\">".number_format($row['CAVGWT'],2)."</td>";
	}
 
 	




	$cmc++;
			$hrc=7.5;
	} else {
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
  echo "<td align=\"center\">"."----"."</td>";
}	
#F0E68C

	if ($stpdc>0) {
		$v=$row['CNETWT'];
			$ef=round($v/($stpdc)*100,2);
 			echo "<td bgcolor= 	 	#FFA07A  align=center><font color= 	#000000 >".number_format($ef,2)."</font></td>";
	} else {
		echo "<td align=\"center\">"."----"."</td>";
	}





if ($row['B2NETWT']+$row['B1NETWT']+$row['A2NETWT']+$row['A1NETWT']+$row['CNETWT']>0) { 
	$v=($row['B2NETWT']+$row['B1NETWT']+$row['A2NETWT']+$row['A1NETWT']+$row['CNETWT'])/($row['B2DOFFNO']+$row['B1DOFFNO']+$row['A2DOFFNO']+$row['A1DOFFNO']+$row['CDOFFNO']);
	
	
 	echo "<td bgcolor='#9ACD32'  align=center><font color= 	#000000 >".number_format($row['B2DOFFNO']+$row['B1DOFFNO']+$row['A2DOFFNO']+$row['A1DOFFNO']+$row['CDOFFNO'],0)."</td>";
	echo "<td bgcolor='#9ACD32'  align=center><font color= 	#000000 >".number_format($row['B2NETWT']+$row['B1NETWT']+$row['A2NETWT']+$row['A1NETWT']+$row['CNETWT'],2)."</td>";
	echo "<td bgcolor='#9ACD32'  align=center><font color= 	#000000 >".number_format($v,2)."</td>";
//		$a2mc++;
 } else {
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 	echo "<td align=\"center\">"."----"."</td>";
 
}	

	if (($stpda1+$stpda2+$stpdb1+$stpdb2+$stpdc)>0) {
		$v=($row['B2NETWT']+$row['B1NETWT']+$row['A2NETWT']+$row['A1NETWT']+$row['CNETWT']);
			$ef=round($v/($stpda1+$stpda2+$stpdb1+$stpdb2+$stpdc)*100,2);
 			echo "<td bgcolor= 	 	#FFA07A  align=center><font color= 	#000000 >".number_format($ef,2)."</font></td>";
	} else {
		echo "<td align=\"center\">"."----"."</td>";
	}



	
$var=1;
if ($var < 6) $color = '#00FF00';
elseif ($var < 10) $color = '#FF8000';
elseif ($var > 10) $color = '#FF0000';
 
 
 
 
 
 

  
	 


 $n=$n+1;
 
 $var=1;

 if ($var>0) {
  


if ($x%2 == 0) 
 echo "<tr bgcolor='	#F9966B'>";

else 
 echo "<tr bgcolor='#ECD672'>";

 
 }
	
  


	
	
	echo "</tr>\n";
}
 
 
  echo "<tr bgcolor='#008B8B'>";
  

//-----------
 	echo "<td align=\"center\">"."Frame Runs"."</td>";
	echo "<td align=\"center\">"."."."</td>";
	echo "<td align=\"center\">"."."."</td>";
	 echo "<td bgcolor='#9ACD32'  align=right>".number_format($a1mc,0)."</td>";
	 echo "<td bgcolor='#9ACD32'  align=right>".number_format($gprda1,0)."</td>";
	 //echo "<td><align=\"center\">".number_format($a1mc,0)."</td>";
	//echo "<td><align=\"center\">".number_format($gprda1,0)."</td>";
 	echo "<td align=\"center\">"."."."</td>";
	echo "<td align=\"center\">"."."."</td>";
	 echo "<td bgcolor='#9ACD32'  align=right>".number_format($a2mc,0)."</td>";
	 echo "<td bgcolor='#9ACD32'  align=right>".number_format($gprda2,0)."</td>";
 	echo "<td align=\"center\">"."."."</td>";
 	echo "<td align=\"center\">"."."."</td>";
	 echo "<td bgcolor='#9ACD32'  align=right>".number_format($gprda,0)."</td>";
 	echo "<td align=\"center\">".""."</td>";
  	echo "<td align=\"center\">".""."</td>";
	echo "<td align=\"center\">"."."."</td>";
	 echo "<td bgcolor='#9ACD32'  align=right>".number_format($b1mc,0)."</td>";
	 echo "<td bgcolor='#9ACD32'  align=right>".number_format($gprdb1,0)."</td>";
	echo "<td align=\"center\">".""."</td>";
	echo "<td align=\"center\">"."."."</td>";
	 echo "<td bgcolor='#9ACD32'  align=right>".number_format($b2mc,0)."</td>";
	 echo "<td bgcolor='#9ACD32'  align=right>".number_format($gprdb2,0)."</td>";
  	echo "<td align=\"center\">".""."</td>";
	 
 	echo "<td align=\"center\">".""."</td>";
	 echo "<td bgcolor='#9ACD32'  align=right>".number_format($gprdb,0)."</td>";
	echo "<td align=\"center\">".""."</td>";
  	echo "<td align=\"center\">".""."</td>";
	echo "<td align=\"center\">"."."."</td>";
	 echo "<td bgcolor='#9ACD32'  align=right>".number_format($cmc,0)."</td>";
	 echo "<td bgcolor='#9ACD32'  align=right>".number_format($gprdc,0)."</td>";
 	echo "<td align=\"center\">".""."</td>";
 	echo "<td align=\"center\">".""."</td>";
 	echo "<td align=\"center\">".""."</td>";
//	echo "<td><align=\"right\">".number_format($gprdc+$gprda+$gprdb,0)."</td>";
 echo "<td bgcolor='#9ACD32'  align=center>".number_format(($gprdc+$gprda+$gprdb),0)."</td>";
 	echo "<td align=\"center\">".""."</td>";
 	echo "<td align=\"center\">".""."</td>";
 	echo "<td align=\"center\">".""."</td>";

 
 echo "</table>\n";

 echo "Efficiency will not be shown for current Date";
 echo "<tr>\n";
  

?>


	 
<marquee bgcolor="#000000"><font color="#FF0000">Red - Avg Doff Wt IS LESS THAN 30 Kgs</font></marquee>
<marquee bgcolor="#000000"><font color="#9370DB">Purple - Avg Doff Wt IS between 30 and 32</font></marquee>
<marquee bgcolor="#000000"><font color="#AFEEEE">paleturquoise - Avg Doff Wt IS between 32 and 35</font></marquee>
<marquee bgcolor="#000000"><font color="#32CD32">Green -  Avg Doff Wt IS 35 and Above</font></marquee>

 
 
 

 
