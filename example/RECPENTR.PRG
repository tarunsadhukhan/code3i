*wait wind 'dddd'
SET CENT ON
clea
clos data
clos inde
ver='N'
do userchek
use
if ver='N'
	clos data
	clos inde
	clea
	retu
endi	
=dbopen1("&mpath.jutemast.dbf")
=dbopen1("&mpath.packmast.dbf")
=dbopen1("&mpath.recpfile.dbf")
=dbopen1("&mpath.recpmast.dbf")
=dbopen1("&mpath.partmast.dbf")
=dbopen1("&mpath.agenmast.dbf")
=dbopen1("&mpath.lotsfile.dbf")
=dbopen1("&mpath.godwnmst.dbf")

sele recpfile
inde on inwarddate to indt
go bott
indt1=inwarddate


sele godwnmst
set orde to godown2
sele jutemast
set orde to jute1
sele recpfile
set relation to jcode into jutemast
DEFI POPUP recp FROM 09,05 TO 18,74 PROM FIEL '      '+(recpno)+'       '+(a->quality)+' '+(c->godownno)+'       '+str(c->recpbales,4)+'          '+str(c->netweight,6,3) SCROLL TITL 'Recp. No.'+spac(3)+'Quality'+SPAC(03)+'Godown'+SPAC(3)+'Recp.Bales'+SPAC(3)+'Net Weight'+SPAC(02) footer "< Receipt Qualities [F2-ADD/ENTER-MODIFY >" shadow colo sche 4
DEFI POPUP gown FROM 12,50 TO 18,74 PROM FIEL '      '+(godownno) SCROLL TITL 'Recp. No.'+spac(3)+'Quality'+SPAC(03)+'Godown'+SPAC(3)+'Recp.Bales'+SPAC(3)+'Net Weight'+SPAC(02) footer "< GOWODWN DETAILS >" shadow colo sche 4

@ 0,0 TO 24,79 DOUB
@ 3,1 to 3,78
@ 2,2 say 'Date '+dtoc(Date())
set colo to /w*
@ 2,30 say 'Receipt Entry'
set colo to
@ 2,55 say 'Time ' 
@ 4,2 say 'Receipt No.'
@ 4,30 say 'F/Year'
@ 4,50 say 'Date '
@ 5,2 SAY 'M.R Date   '
@ 6,2 say 'Purchase No'
@ 6,50 say ' Date  '
@ 7,2 say 'Contract No'
@ 7,50 say ' Date  '
@ 8,2 say 'Party Name'
@ 9,2 say 'Broker Name'
@10,2 say 'Challan No'
@10,50 say 'Date  '
@12,2 say 'Mukam'
@12,50 say 'Lorry No.'
@13,1 to 13,78
@14,2 say ' Quality         Godown    Bales    Weight    Packing Type    Claim    Claim'
@15,2 say '                   No.                                         Qual    Moist'
@16,1 to 16,78
@ 20,1 to 20,78
@ 22,1  TO 22,78
set colo to /w
@ 23,1  TO 23,78
@ 23,3 SAY '± ± ± ± ± F1 -> New | F2 -> Modify | F3 -> Remove | F10 -> Exit  ± ± ± ± ±'
set colo to
save scre to jmast


ik=0

do whil .t.

ik=inkey()

do case
   case ik=28
DO GRADD 
case ik=-1
do gredt
case ik=-3
do grdel
 case ik=27 .or. ik=-9
 clos data
 clos inde
 clea
 retu
 
 endc
 endd  
 
 proc gradd
    do whil .t.
   clea
dat=date()
yr=space(4)
do case
	case month(dat)>=4 and month(dat)<=12
		y=year(dat)
		yr=subs(allt(str(y)),3,2)+subs(allt(str(y+1)),3,2) 
	case month(dat)>=1 and month(dat)<=3
		y=year(dat)
		yr=subs(allt(str(y-1)),3,2)+subs(allt(str(y)),3,2) 
endc

   restore scre from jmast
   sele recpfile
   scat to gr blan
   stor spac(15) to jt,agn
   stor spac(10) to pkn
   stor spac(30) to pcn,bcn
   stor spac(4) to sbno
   GR(18)=YR
   clea 
   restore scre from jmast
   do whil .t.
   @ 4,15 get gr(1)  
   @ 4,38 get gr(18)
   read
   if lastkey()=27
	   retu
   endi
   sele recpmast
   set orde to recpFY
   seek gr(1)+gr(18)
   if !eof()
	   wait wind 'Duplicate Entry....'
	   loop
   endi
   @ 4,24 get sbno pict '9999'
   @ 4,60 get gr(3)  vali gr33()  
   @ 6,15 get gr(27)
   read
   if last()=27
   		exit
   	endi	
   if len(alltrim(gr(2)))#0
   if len(alltrim(gr(2)))<6
   wait wind 'There Should Be No Blank' nowait
   loop
   endi
   endi
   mrdt=gr(3)+2
   @ 5,15 get mrdt	
   @ 6,60 get gr(28) 
   @ 7,15 get gr(29)
   @ 7,60 get gr(30) 
   read
   @ 8,15 get pcn pict '!!!!!!!!!!!!!!!!!!!!!!!!!!!!!'
   read
   sele partmast
   set orde to part2
   seek pcn
   if eof()
   save scre to jttmp
   set orde to 
   go bott
   rcc=recno()
   set orde to part2
   ak='party'
   do npdttm
   gr(5)=partcode
   pcn=party
   clea
   restore scre from jttmp
   else
   GR(5)=partcode
   ENDI 
   @ 8,15 say pcn pict '!!!!!!!!!!!!!!!!!!!!!!!!!!!!'
   
   save scre to jmst
   @ 8,2 clea to 8,50
   @ 9,15 get bcn pict '!!!!!!!!!!!!!!!!!!!!!!!!!!!!'
   read
   IF BCN#'  '
   sele partmast
   set orde to part2
   seek bcn
   if eof()
   save scre to jttmp
   set orde to part2
   ak='party'
		 DEFI POPUP qpop FROM 07,48 TO 21,74 PROM FIEL '   '+' '+(PARTY)  footer "< PARTY LISTING   >" shadow colo sche 4
         on key label enter deac popup qpop
         acti popup qpop rest
         deac popup qpop
         on key
*   do m1
   gr(24)=partcode
   bcn=party
   clea
   restore scre from jttmp
   else
   GR(24)=partcode
   ENDI 
   @ 9,15 say bcn pict '!!!!!!!!!!!!!!!!!!!!!!!!!!!!'
   read
   clea
   restore scre from jmst
   ENDI 
    
    
   @10,15 get gr(6)
   @10,60 get gr(7)
   @12,15 get agn pict '!!!!!!!!!!!!!!!'
   read
   sele agenmast
   set orde to agn2
   seek agn
   if eof()
   save scre to jttmp
   set orde to 
   go bott
   rcc=recno()
   set orde to agn2
   ak='agency'
   do npdttm
   gr(9)=agcode
   AGN=agency
   clea
   restore scre from jttmp
   else
   GR(9)=agcode
   ENDI 
   @ 12,15 say agn pict '!!!!!!!!!!!!!!!'

   @ 12,60 get gr(8)   
   read
   save scre to jttmp
   @ 10,20 clea to 12,60
   @ 10,20 to 13,60
   @ 11,22 say 'Mark : ' get gr(19)
   @ 12,22 SAY '     : ' GET GR(21)
   READ
   clea
   restore scre from jttmp  
   l=17
  sl=1
  do whil .t.
   sele recpfile
   scat to pr blan
   @ l,2 get jt pict '!!!!!!!!!!!!!!'
   read
   if lastkey()=27
    exit
   endi
   sele jutemast
   set orde to jute2
   seek jt
   if eof()
    save scre to jttmp
    set orde to 
    go bott
    rcc=recno()
    set orde to jute2
    ak='QUALITY'
    do npdttm
    pr(10)=JCODE
    JT=quality
    clea
    restore scre from jttmp
   else
    pR(10)=JCODE
   ENDI 
   @l,2 say jt pict '!!!!!!!!!!!!!!'
   @l,18 get pr(4) pict '@!9'
   read
	sele godwnmst
	set orde to  godown2
	SEEK PR(4)
	if !found()
   ON KEY LABEL ENTER DEAC POPUP GOWN
  ACTI POPUP GOWN rest
  DEAC POPUP GOWN
  on key
  ENDI 
	PR(32)=GODWNCODE
   PR(4)=GODOWNNO
   @l,18 SAY pr(4)  
   
   save scre to jttmp
   @ 10,20 clea to 12,60
   @ 10,20 to 13,60
   @ 11,22 say 'Mark : ' get pr(19)
   @ 12,22 SAY '     : ' GET pR(21)
   READ
   clea
   restore scre from jttmp  
   save scre to jttmp
   @ 17,20 clea to 19,70
   @ 17,30 to 19,72
   @ 18,32 say 'Qua. Details ' get GR(25) 
   read
   clea
   restore scre from jttmp  
   save scre to jttmp
   @ 17,30 clea to 19,60
   @ 17,30 to 19,60
   @ 18,32 say 'Season ' get GR(26) 
   read
   clea
   restore scre from jttmp  
   save scre to jttmp
   @ 17,30 clea to 19,60
   @ 17,30 to 19,60
   @ 18,32 say 'Challan Bales ' get pr(11) pict '999999'
   read
   clea
   restore scre from jttmp  
   save scre to jttmp
   @ 17,30 clea to 19,60
   @ 17,30 to 19,60
   @ 18,32 say 'Receipt Bales ' get pr(12) pict '999999'
   read
   clea
   restore scre from jttmp  
   @ l,27 say pr(12) pict '999999'
   save scre to jttmp
   @ 17,30 clea to 19,60
   @ 17,30 to 19,60
   @ 18,32 say 'Challan Wt. ' get pr(14) pict '99999.999'
   read
   clea
   restore scre from jttmp  
   save scre to jttmp
   @ 17,30 clea to 19,60
   @ 17,30 to 19,60
   @ 18,32 say 'Receipt Wt. ' get pr(15) pict '99999.999'
   read
   clea
   restore scre from jttmp  
   @ l,36 say pr(15) pict '99999.999'
   @ l,46 get pkn pict '!!!!!!!!!!'
   read
   sele packmast
   set orde to pack2
   seek pkn
   if eof()
   save scre to jttmp
   set orde to 
   go bott
   rcc=recno()
   set orde to pack2
   ak='packing'
   do npdttm
   pr(13)=packcode
   pkn=packing
   clea
   restore scre from jttmp
   else
   pR(13)=packcode
   ENDI 
   @l,46 say pkn pict '!!!!!!!!!!'
   @ l,64 get pr(16) pict '99.99'
   @ l,74 get pr(17) pict '99.99'
   save scre to jmst
   @ 16,10 clea to 20,60
   @ 16,10,20,60 box chr(177)
   @ 18,12 say 'Remarks ' get pr(20)
   read
   clea
   restore scre from jmst
   save scre to jmst
   @ 16,10 clea to 20,60
   @ 16,10,20,60 box chr(177)
   @ 18,12 say 'Report ' get pr(23)
   read
   clea
   restore scre from jmst
    
   save scre to jmst
   @ 16,10 clea to 20,60
   @ 16,10,20,60 box chr(177)
   @ 18,12 say 'Oth Detl. ' get pr(31)
   read
   clea
   restore scre from jmst
   
   conf=.F.
   @ 21,12 say 'All Your Entries Are  O.K. ' get conf
   read
   if conf=.f.
    loop
   endi
  sele recpfile
  appe blan

  gath from gr
  repl jcode with pr(10),chalbales with pr(11),recpbales with pr(12)
  repl packcode with pr(13),chalweight with pr(14),netweight with pr(15)
  repl claimqt with pr(16),claimmoist with pr(17),godownno with pr(4)
  REPL brcode with Gr(24),qualdetl with GR(25),season with GR(26)
  repl report with pr(23),remarks with pr(20),mark with pr(19),othdetl with pr(31)
  repl mark2 with pr(21),godwncode with pr(32)
  repl godwncode with godwnmst->godwncode,tr_type with TRTYPE	
  DO USERCHNG
  sele recpfile  
  l=l+1
  IF L>20
  	SCROLL 17,1,20,79,1
	L=20
ENDI	
  sl=sl+1
endd
if sl>1
 sele recpmast
 appe blan
 gath from gr
 repl fyyear with gr(18)
 repl mrdate with mrdt
 repl jcino with sbno
DO USERCHNG
endi
exit
endd

endd





proc gredt
do whil .t.
 clea
 restore scre from jmast
 sele recpfile
 Set filt to tr_type=TRTYPE
 scat to gr blan
 jt=spac(15)
 agn=spac(15)
 pkn=spac(10)
 pcn=spac(3)
 bcn=spac(30)
 sbno=spac(4)
 clea 
 restore scre from jmast
 gr1=spac(5)
 do whil .t.
  @ 4,15 get gr1 pict '!!!!!'
  @ 4,38 get gr(18)
  read
  if lastkey()=27
	   retu
  endi
  sele recpmast
  set orde to recpFY
  seek gr1+GR(18)
  if eof()
   wait wind 'Invalid Entry....'
   loop
  endi
  sbno=jcino
  sele recpfile
  set orde to recpfY
  seek gr1+GR(18)
  scat to gr
*  WAIT WIND GR(22)
  @ 4,22 say recpmast->jcino 
  @ 4,60 say gr(3)  
  @ 5,15 say recpmast->mrdate
  @ 6,15 say gr(27)
  @ 6,60 say gr(28) 
  @ 7,15 say gr(29)
  @ 7,60 say gr(30) 
  sele partmast
  set orde to part1
  seek gr(5)
  pcn=party
  @ 8,15 say pcn pict '!!!!!!!!!!!!!!!!!!!!!!!!!!!!!'
  @10,15 say gr(6)
  @10,60 say gr(7)
  sele agenmast
  set orde to agn1
  seek gr(9)
  agn=agency
  @12,15 say agn pict '!!!!!!!!!!!!!!!'
  @ 12,60 say gr(8)   
  l=17  
  sele recpfile
  set orde to recpfY
  seek gr1+GR(18)
  do whil recpno=gr(1) AND FYYEAR=GR(18) AND !EOF()
   scat to pr
   sele jutemast
   set orde to jute1
   seek pr(10)
   jt=quality
   @ l,2 say jt pict '!!!!!!!!!!!!!!'
	sele godwnmst
	seek pr(4)
   @l,18 say pr(4)  
   @ l,27 say pr(12) pict '999999'
   @ l,36 say pr(15) pict '99999.999'
   sele packmast
   set orde to pack1
   SEEK PR(13)
   pkn=packing
   @ l,46 say pkn pict '!!!!!!!!!!'
   @ l,64 say pr(16) pict '99.99'
   @ l,74 say pr(17) pict '99.99'
   l=l+1
   sele recpfile
   skip
  endd
* wait wind 'Complete'   
  @ 4,22 get sbno pict '9999'
  @ 4,60 get gr(3) 
  @ 6,15 get gr(27)
  read
  if last()=27
  	exit
  endi	
  if len(alltrim(gr(2)))#0
 *  if len(alltrim(gr(2)))<6
 **   wait wind 'There Should Be No Blank-2' nowait
 *   loop
 *  endi
  endi
  mrdt=gr(3)
  @ 5,15 get mrdt	
  @ 6,60 get gr(28)  
  @ 7,15 get gr(29)
  @ 7,60 get gr(30) 
  @ 8,15 get pcn pict '!!!!!!!!!!!!!!!!!!!!!!!!!!!!!'
  read
  sele partmast
  set orde to part2
  seek pcn
  if eof()
   save scre to jttmp
   set orde to 
   go bott
   rcc=recno()
   set orde to part2
   ak='party'
   do npdttm
   gr(5)=partcode
   pcn=party
   clea
   restore scre from jttmp
  else
   GR(5)=partcode
  ENDI 
  @ 8,15 say pcn pict '!!!!!!!!!!!!!!!!!!!!!!!!!!!!'
  sele partmast
  set orde to 1
  seek gr(24)
  if found()
   bcn=party
  endi
  save scre to jmst
  @ 8,2 clea to 8,50
  @ 9,15 get bcn pict '!!!!!!!!!!!!!!!!!!!!!!!!!!!!'
  read
  IF BCN#'  '
   sele partmast
   set orde to part2
   seek bcn
   if eof()
    save scre to jttmp
    set orde to part2
    ak='party'
		 DEFI POPUP qpop FROM 07,48 TO 21,74 PROM FIEL '   '+' '+(PARTY)  footer "< PARTY LISTING   >" shadow colo sche 4
         on key label enter deac popup qpop
         acti popup qpop rest
         deac popup qpop
         on key
*    do m1
    gr(24)=partcode
    bcn=party
    clea
    restore scre from jttmp
   else
    GR(24)=partcode
   ENDI 
   @ 9,15 say bcn pict '!!!!!!!!!!!!!!!!!!!!!!!!!!!!'
   read
   clea
   restore scre from jmst
  ENDI 
  @10,15 get gr(6)
  @10,60 get gr(7)
  @12,15 get agn pict '!!!!!!!!!!!!!!!'
  read
  sele agenmast
  set orde to agn2
  seek agn
  if eof()
   save scre to jttmp
   set orde to 
   go bott
   rcc=recno()
   set orde to agn2
   ak='agency'
   do npdttm
   gr(9)=agcode
   AGN=agency
   clea
   restore scre from jttmp
  else
   GR(9)=agcode
  ENDI 
  @ 12,15 say agn pict '!!!!!!!!!!!!!!!'
  @ 12,60 get gr(8)   
  read
  conf=.f.
  save scre to jttmp
  @ 18,60 clea to 22,78
  @ 18,60 to 22,78
  @ 20,62 say 'Entries Are O.K.'
  @ 21,72 get conf
  read
  clea
  restore scre from jttmp
  if conf=.f.
   loop
  endi
  SELE recpmast
  do whil recpno=gr1 AND FYYEAR=GR(18)
     gath from gr
    repl jcino with sbno
	REPL FYYEAR WITH GR(18)
 	DO USERCHNG
    skip
  endd
  
  sele recpfile
  seek gr1+GR(18)
  do whil recpno=gr1 AND FYYEAR=GR(18) AND !EOF()
   repl lotno with gr(2),inwarddate with gr(3),partcode with gr(5),challno with gr(6)
   repl chaldate with gr(7),lorryno with gr(8),agcode with gr(9),BRCODE WITH GR(24)
   repl fyyear with gr(18)
   REPL RUKKANO WITH gr(27),rukkadate with gr(28),contno with gr(29),contdate with gr(30)
*   REPL REMARKS WITH GR(22)
   skip
  endd
  
  abc='N'
  DO GR33
  if abc='Y'
*  	loop
  endi		
  
  sele recpfile
  seek gr1+GR(18)
  sele jutemast
  APP=.F.
  set orde to jute1
  sele recpfile
  set filt to recpno=gr(1) AND FYYEAR=GR(18) AND tr_type=TRTYPE
  
  go top
  save scre to jms
  @07,20,07,64 box chr(219)
  ON KEY LABEL ENTER DEAC POPUP recp
  ACTI POPUP recp rest
  DEAC POPUP recp
  on key
  clea
  restore scre from jms
  IF LASTKEY()=-1
   SELE RECPFILE
   SCAT TO PR BLAN
   APP=.T.
  ELSE
   sele recpfile
   set filt to
   scat to pr
  ENDI
  do whil .t.
   monf='E'
   save scre to jttmp
   @ 18,60 clea to 22,78
   @ 18,60 to 22,78
   @ 20,62 say 'Modify/Delete   '
   @ 21,72 get monf pict '!' valid monf$'ED'
   read
   clea
   restore scre from jttmp
   if lastkey()=27
    exit
   endi
   if monf='D'
    exit
   endi
   if monf='E'
    exit
   endi
  endd
  if lastkey()=27
   loop
  endi
  IF MONF='E'
   l=21
   sele recpfile
   scat to pr
   sele jutemast
   seek pr(10)
   jt=quality
   @ l,2 get jt pict '!!!!!!!!!!!!!!'
   read
   if lastkey()=27
    exit
   endi
   sele jutemast
   set orde to jute2
   seek jt
   if eof()
    save scre to jttmp
    set orde to 
    go bott
    rcc=recno()
    set orde to jute2
    ak='QUALITY'
    do npdttm
    pr(10)=JCODE
    JT=quality
    clea
    restore scre from jttmp
   else
    pR(10)=JCODE
   ENDI 
   @l,2 say jt pict '!!!!!!!!!!!!!!'
   @l,18 get pr(4) pict '@!9'
   read
	sele godwnmst
	set orde to  godown2
	SEEK PR(4)
	if !found()
   ON KEY LABEL ENTER DEAC POPUP GOWN
  ACTI POPUP GOWN rest
  DEAC POPUP GOWN
  on key
  ENDI 
   PR(32)=GODWNCODE
   PR(4)=GODOWNNO
   @l,18 SAY pr(4)  
   save scre to jttmp
   @ 10,20 clea to 12,60
   @ 10,20 to 13,60
   @ 11,22 say 'Mark : ' get pr(19)
   @ 12,22 SAY '     : ' GET pR(21)
   READ
   clea
   restore scre from jttmp  
   save scre to jttmp
   @ 17,20 clea to 19,70
   @ 17,30 to 19,60
   @ 18,32 say 'Qua. Details ' get pr(25) 
   read
   clea
   restore scre from jttmp  
   save scre to jttmp
   @ 17,30 clea to 19,60
   @ 17,30 to 19,60
   @ 18,32 say 'Season ' get pr(26) 
   read
   clea
   restore scre from jttmp  
   save scre to jttmp
   @ 17,30 clea to 19,60
   @ 17,30 to 19,60
   @ 18,32 say 'Challan Bales ' get pr(11) pict '999999'
   read
   clea
   restore scre from jttmp  
   save scre to jttmp
   @ 17,30 clea to 19,60
   @ 17,30 to 19,60
   @ 18,32 say 'Receipt Bales ' get pr(12) pict '999999'
   read
   clea
   restore scre from jttmp  
   @ l,27 say pr(12) pict '999999'
   save scre to jttmp
   @ 17,30 clea to 19,60
   @ 17,30 to 19,60
   @ 18,32 say 'Challan Wt. ' get pr(14) pict '99999.999'
   read
   clea
   restore scre from jttmp  
   save scre to jttmp
   @ 17,30 clea to 19,60
   @ 17,30 to 19,60
   @ 18,32 say 'Receipt Wt. ' get pr(15) pict '99999.999'
   read
   clea
   restore scre from jttmp  
   @ l,36 say pr(15) pict '99999.999'
   @ l,46 get pkn pict '!!!!!!!!!!'
   read
   sele packmast
   set orde to pack2
   seek pkn
   if eof()
    save scre to jttmp
    set orde to 
    go bott
    rcc=recno()
    set orde to pack2
    ak='packing'
    do npdttm
    pr(13)=packcode
    pkn=packing
    clea
    restore scre from jttmp
   else
    pR(13)=packcode
   ENDI 
   @l,46 say pkn pict '!!!!!!!!!!'
   @ l,64 get pr(16) pict '99.99'
   @ l,74 get pr(17) pict '99.99'
   read  
   save scre to jmst
   @ 16,10 clea to 20,60
   @ 16,10,20,60 box chr(177)
   @ 18,12 say 'Remarks ' get pr(22)
   read
   clea
   restore scre from jmst
   save scre to jmst
   @ 16,10 clea to 20,60
   @ 16,10,20,60 box chr(177)
   @ 18,12 say 'Report ' get pr(23)
   read
   clea
   restore scre from jmst
   save scre to jmst
   @ 16,10 clea to 20,60
   @ 16,10,20,60 box chr(177)
   @ 18,12 say 'Oth Detl. ' get pr(31)
   read
   clea
   restore scre from jmst
   conf=.F.
   save scre to jttmp
   @ 18,60 clea to 22,78
   @ 18,60 to 22,78
   @ 20,62 say 'Entries Are O.K.'
   @ 21,72 get conf
   read
   clea
   restore scre from jttmp
   if conf=.f.
    loop
   endi
   sele recpfile
   IF APP=.T.
    APPE BLAN
   ENDI
   gath from gr
   repl jcode with pr(10),chalbales with pr(11),recpbales with pr(12)
   repl packcode with pr(13),chalweight with pr(14),netweight with pr(15)
   repl claimqt with pr(16),claimmoist with pr(17),godownno with pr(4)
   REPL report with pr(23),othdetl with pr(31),godwncode with pr(32)
   REPL remarks with pr(22)
   REPL brcode with GR(24)
   REPL QUALDETL WITH PR(25)
   REPL SEASON WITH PR(26)
   REPL mark with pr(19)
   repl mark2 with pr(21)
   REPL RUKKANO WITH gr(27),rukkadate with gr(28),contno with gr(29),contdate with gr(30)
   repl godwncode with godwnmst->godwncode,tr_type with TRTYPE	
 
	DO USERCHNG
    sele recpfile  
   sele recpmast
   seek gr1+GR(18)
    gath from gr
    repl fyyear with gr(18)
	repl mrdate with mrdt
 	repl jcino with sbno
	DO USERCHNG
*    endd
  else
   sele recpfile
   dele
  endi
  sele recpfile
  set orde to RECPFY
  seek gr1+GR(18)
  if !found()
   sele recpmast
   seek gr1+GR(18)
   dele
  ENDI 
  exit
 endd
endd



proc gr3
if gr(3)<indt1
	wait wind 'Wrong Date Cannot Be Entered/Modify....'
	retu 0
endi	

proc gr33
if gr(3)<indt1
	wait wind 'Please Check Already Entered Next Date... '
	abc='Y'
*	retu 0
endi	


