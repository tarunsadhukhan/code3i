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


*set proc to oklib
=dbopen1("&mpath.jutemast.dbf")
=dbopen1("&mpath.packmast.dbf")
=dbopen1("&mpath.issufile.dbf")
=dbopen1("&mpath.issumast.dbf")
=dbopen1("&mpath.lotsfile.dbf")
=dbopen1("&mpath.godwnmst.dbf")
=dbopen1("&mpath.recpfile.dbf")
=dbopen1("&mpath.openfile.dbf")
=dbopen1("&mpath.jtadjust.dbf")
=dbopen1("&mpath.stkadjst.dbf")
crea table currstok ;
	(godwncode n(2),jcode n(3),packcode n(4),opbales n(10),gwnno c(9), ;
	recpbales n(10),issubales n(10),trfbales n(10),trtobales n(10),;
	salebales n(10),retbales n(7,2),closbales n(10),closwght n(10))	

*=dbopen1("&mpath.currstok.dbf")

crea table godown ;
	(godwncode n(2),godownno c(9)) 
appe from &mpath.godwnmst
 	


sele issumast
sele packmast
set orde to pack1
sele jutemast
set orde to jute1
sele godwnmst
set orde to godown1

sele currstok
set relation to packcode into packmast
set relation to godwncode into godwnmst addi
set relation to jcode into jutemast addi
DEFI POPUP curr FROM 09,02 TO 15,76 PROM FIEL '  '+str(jcode,4)+' '+(jutemast->quality)+'   '+(packmast->packing)+' '+(godwnmst->godownno)+'   '+str(currstok->closbales,5)+'   '+str(currstok->closwght,7)++'   '+str(currstok->retbales,7,2)   footer "< Stock  Position   >" shadow colo sche 4
sele currstok

sele issufile
inde on issuedate to indt
go bott
indt1=issuedate


set relation to jcode into jutemast addi
DEFI POPUP recp FROM 09,05 TO 18,74 PROM FIEL '  '+ISSUENO+'   '+(a->quality)+' '+(c->godownno)+'    '+str(c->bales,4)+'    '+str(c->weight,7)+'  '+stype SCROLL TITL 'Issu. No.'+spac(3)+'Quality'+SPAC(03)+'Godown'+SPAC(3)+' Bales    '+SPAC(3)+'    Weight'+SPAC(02) footer "< Issue  Qualities  >" shadow colo sche 4
@ 0,0 to 24,79 doub
@ 3,1 to 3,78
@ 2,2 say 'Date '+dtoc(date())
set colo to /w*
@ 2,30 say 'Issue Entry'
set colo to
@ 2,55 say 'Time '
@ 4,2 say 'Issue No.'
@ 4,50 say 'Date '
@ 6,2 say 'Lot No. '
@ 6,50 say 'Fy. Year'
@7,1 to 7,78
@8,2 say ' Quality         Godown       Bales      Weight     Packing Type   S/Type '
@9,2 say '                   No.                                         '
@10,1 to 10,78

@ 20,1 to 20,78
@ 22,1  to 22,78
set colo to /w
@ 23,1  to 23,78
@ 23,3 say '± ± ± ± ± F1 -> New | F2 -> Modify | F3 -> Remove | F10 -> Exit  ± ± ± ± ±'
set colo to
save scre to jmast

ik=0

do whil .t.
   
   ik=inkey()
   
   do case
      
   case ik=28
      
      do gradd
   case ik=-1
      
      do gredt
  
   case ik=27 .or. ik=-9
      clos data
      clos inde
      clea
      retu
   endc
endd



proc gradd
do whil .t.
   sele issufile
   scat to gr blan
   stor spac(15) to jt
   stor spac(10) to pkn
   clea
   restore scre from jmast
   do whil .t.
      clea
      restore scre from jmast
      @ 4,60 get gr(2) vali gr33()
      read
*      chga=gr(2)
*      do dtchg
*      gr(2)=chga
      dajr=ltrim(str(day(gr(2))))
      if len(dajr)=1
         dajr='0'+dajr
      endi
      mnjr=ltrim(str(month(gr(2))))
      if len(mnjr)=1
         mnjr='0'+mnjr
      endi
      
      gr(1)=ltrim(str(year(gr(2))))+mnjr+dajr
      @ 4,15 get gr(1) pict '99999999'
      read
      if lastkey()=27
         retu
      endi
      sele issumast
      set orde to issum1
      seek gr(1)
      if !eof()
         wait wind 'Duplicate Entry....'
         *   loop
      endi
      @ 6,15 get gr(3)
      @ 6,60 get gr(10) pict '9999'
      read
      if len(alltrim(gr(3)))#0
      *   if len(alltrim(gr(3)))<6
      *      wait wind 'There Should Be No Blank' nowait
      *      loop
      *   endi
      endi
      l=11
      sl=1
      do whil .t.
         sele issufile
         scat to pr blan
         @ l,2 get jt pict '!!!!!!!!!!!!!!'
         read
         if lastkey()=27
            exit
         endi
         sele jutemast
         set orde to jute2
         rcc=recno()
         seek jt
         if eof()
            save scre to jttmp
             set orde to jute2
            ak='QUALITY'
		 DEFI POPUP qpop FROM 07,48 TO 21,74 PROM FIEL '   '+' '+(jutemast->quality)+'   '+str(jcode,3)   footer "< QUALITY LISTING   >" shadow colo sche 4
         on key label enter deac popup qpop
         acti popup qpop rest
         deac popup qpop
         on key
             pr(5)=jcode
            jt=quality
            clea
            restore scre from jttmp
         else
            pr(5)=jcode
         endi
         @l,2 say jt pict '!!!!!!!!!!!!!!'
         @l,22 get pr(4) pict '!!!!!!!!!'
         read
         save scre to jttmp
         
         sele godwnmst
         set orde to godown2
         seek pr(4)
         if !found()
            ak='godownno'
		 DEFI POPUP qpop FROM 07,48 TO 21,74 PROM FIEL '   '+' '+(godownno)+'   '   footer "< GODOWN  LISTING   >" shadow colo sche 4
         on key label enter deac popup qpop
         acti popup qpop rest
         deac popup qpop
         on key
*            do m1
            pr(12)=godwncode
            pr(4)=godownno
            clea
            restore scre from jttmp
         else
            pr(12)=godwncode
         endi
         @l,22 SAY pr(4) pict '!!!!!!!!!'
         
         @l,34 get pr(6) pict '999'
         @l,42 get pr(8) pict '999999'
         @l,55 get pkn pict '!!!!!!!!!!'
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
            
            pr(7)=packcode
            pkn=packing
            clea
            restore scre from jttmp
         else
            pr(7)=packcode
            pkn=packing
         endi
         @l,55 say pkn pict '!!!!!!!!!!'
         @l,69 get pr(15) pict '!!' 
         *vali pr(15)$('1234');
         mess '1 = HCF 2 = H/Wp,H/Wt,C/Wp,C/Wt 3 = S/Wp 3A = S/WP(HF) 4 = S/Wt,S/Yarn'
         read
         if last()=27
         	loop
         endi
  		  do calcstok	
          
         sele currstok
*         LOCA FOR 
         if pr(6)>closbales
	           wait wind 'YOUR STOCK IS '+str(closbales,6)+' '+pkn+'  PLEASE CHECK.......' nowait
		       sele packmast
		    	set orde to pack1
				sele jutemast
				set orde to jute1
				sele godwnmst
				set orde to godown1
				sele currstok
 		         on key label enter deac popup curr
		         acti popup curr rest
		         deac popup curr
		         on key
          endi
          
         conf=.t.
         @ 21,12 say 'All Your Entries Are  O.K. ' get conf
         read
         if last()=27
         	loop
         endi	
         if conf=.f.
            loop
         endi
         sele issufile
         appe blan
         gath from gr
         repl jcode with pr(5),bales with pr(6)
         repl packcode with pr(7),weight with pr(8)
         repl godownno with pr(4),godwncode with pr(12)
         repl stype with pr(15)
         
		do userchng		 
          
         sele currstok
         sele issufile
         l=l+1
         if l>19
            scroll 11,1,19,78,1
            l=19
         endi
         
         
         sl=sl+1
         
      endd
      if sl>1
         sele issumast
         seek gr(1)
         if !found()
            appe blan
         endi
         gath from gr
         repl fyyear with gr(10)
		do userchng
      endi
      exit
   endd
endd




 proc gredt
do whil .t.
   sele issufile
   stor spac(15) to jt
   stor spac(10) to pkn
   clea
   restore scre from jmast
   gr1=spac(8)
   do whil .t.
      clea
      restore scre from jmast
      @ 4,15 get gr1 pict '!!!!!!!!'
      read
      if lastkey()=27
         retu
      endi
      sele issumast
      set orde to issum1
      seek gr1
      if eof()
         wait wind 'Invalid Entry....'
         loop
      endi
      scat to gr
      @ 4,60 say gr(2)
      @ 6,15 say gr(3)
      @ 6,60 say gr(4) pict '9999'
      l=11
      sl=1
      
      sele issufile
      set orde to issuf1
      seek gr1
      do whil issueno=gr1
         scat to pr
         
         
         jc=jcode
         sele jutemast
         set orde to jute1
         seek jc
         jt=quality
         @l,2 say jt pict '!!!!!!!!!!!!!!'
         @l,22 say pr(4) pict '!!!!!!!!!'
         @l,29 say pr(6) pict '999'
         @ l,36 say pr(8) pict '999999'
         sele packmast
         set orde to pack1
         seek pr(7)
         pkn=packing
         @ l,55 say pkn pict '!!!!!!!!!!'
         @l,69 say pr(15) pict '!!'
         *  read
         
         l=l+1
         if l>19
            scroll 11,1,19,78,1
            l=11
            *   WAIT WIND 'Press Any Key To Continue.....'
         endi
         sele issufile
         skip
      endd
      
      @ 4,60 get gr(2)
      read
      *   chga=gr(2)
      *   do dtchg
      *   gr(2)=chga
      
      @ 6,15 get gr(3)
      @ 6,60 get gr(4) pict '9999'
      read
      if len(alltrim(gr(3)))#0
         *if len(alltrim(gr(3)))<6
         *   wait wind 'There Should Be No Blank' nowait
         *   loop
         *endi
      endi
       
      do whil .t.
         sele jutemast
         set orde to jute1
         save scre to jms
         @07,20,07,64 box chr(219)
         SELE ISSUFILE
	   sele issufile
       set filt to issueno=gr(1)
       	set orde to issuf5
	      go top
         on key label enter deac popup recp
         acti popup recp rest
         deac popup recp
         on key
         clea
         restore scre from jms
         if lastkey()=27
            exit
         endi
      if last()=-1
      	set orde to issuf5
      	loop
      endi
         set orde to issuf1
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
         
         if monf='E'
            sele issufile
            set filt to
            scat to pr
            ****
            sele issufile
            scat to pr
            pr5=pr(5)
            pr7=pr(7)
            pr12=pr(12)
            pr6=pr(6)
            sele currstok
             
            
            sele issufile
            sele jutemast
            set orde to jute1
            seek pr(5)
            jt=quality
            @ 21,2 get jt pict '!!!!!!!!!!!!!!'
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
               pr(5)=jcode
               jt=quality
               clea
               restore scre from jttmp
            else
               pr(5)=jcode
            endi
            @21,2 say jt pict '!!!!!!!!!!!!!!'
            
            @21,22 get pr(4) pict '!!!!!!!!'
            read
            sele godwnmst
            set orde to 2
            seek pr(4)
            sele godwnmst
            set orde to godown2
            seek pr(4)
            if !found()
               save scre to jttmp
               ak='godownno'
		 DEFI POPUP qpop FROM 07,48 TO 21,74 PROM FIEL '   '+' '+(godownno)+'   '   footer "< GODOWN  LISTING   >" shadow colo sche 4
         on key label enter deac popup qpop
         acti popup qpop rest
         deac popup qpop
         on key
*               do m1
               pr(12)=godwncode
               pr(4)=godownno
               clea
               restore scre from jttmp
            else
               pr(12)=godwncode
            endi
            @21,22 say pr(4) pict '!!!!!!!!'
            
            
            
            @21,29 get pr(6) pict '999'
            @21,36 get pr(8) pict '999999'
            
            sele packmast
            set orde to 1
            seek pr(7)
            pkn=packing
            @21,46 get pkn pict '!!!!!!!!!!'
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
               pr(7)=packcode
               pkn=packing
               clea
               restore scre from jttmp
            else
               pr(7)=packcode
            endi
            @21,55 say pkn pict '!!!!!!!!!!'
            @21,69 get pr(15) pict '!!'
            read
            
            sele currstok
*            seek str(pr(5),4)+str(pr(7),4)+str(pr(12),2)
            if pr(6)>closbales
               wait wind 'YOUR STOCK IS '+str(closbales,6)+' '+pkn+'  PLEASE CHECK.......' nowait
               *         loop
            endi
            
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
               sele currstok
                
               loop
            endi
            sele issufile
            repl issueno with gr(1),issuedate with gr(2),lotno with gr(3),fyyear with gr(4)
            repl jcode with pr(5),bales with pr(6)
            repl packcode with pr(7),weight with pr(8)
            repl godownno with pr(4),godwncode with pr(12)
            repl stype with pr(15)
 			do userchng
             
             
            sele issufile
         else
            sele issufile
            scat to pr
             sele issufile
            dele
         endi
      endd
      sele issufile
      set orde to issuf1
      seek gr1
      if !found()
         sele issumast
         seek gr1
         dele
      else
         
         sele issumast
         seek gr1
         gath from gr
         sele issufile
         do whil issueno=gr1
            repl issueno with gr(1),issuedate with gr(2),lotno with gr(3),fyyear with gr(4)
            skip
         endd
      endi
      
      
      
      
      exit
   endd
endd



*: EOF: ISSUENTR.PRG

proc calcstok
sele currstok
dele all
sele openfile
set orde to open5
sele recpfile
set orde to recf6
set filt to inwarddate<=date()
*gr(2)
sele issufile
set orde to issuf8
set filt to issuedate<=date()
*gr(2)
sele jtadjust
set filt to date<=date()
*gr(2)
sele stkadjst 
set orde to stkjcgc
set filt to date<=date()
*****


sele godown
set filt to
set orde to
go top
do whil !eof()
	gwn2=godwncode
	stor 0 to opbl,opwt
	gwnn=godownno
	sele openfile
	set orde to open5
	seek str(pr(5),4)+str(gwn2,2)
	if found()
   		do whil jcode=pr(5) and godwncode=gwn2
			if packcode=pr(7)
	    		opbl=opbl+bales
	    	  opwt=opwt+weight
  	endi     
      skip
   endd
endi

 


sele recpfile
seek str(pr(5),4)+str(gwn2,2)
if found()
   do whil jcode=pr(5) and godwncode=gwn2
          if tr_type="R"
 	        if packcode=pr(7)
                opbl=opbl+recpbales
               opwt=opwt+netweight
 			endi
          else
              if packcode=pr(7)
               opbl=opbl-chalbales
               opwt=opwt-netweight
 			endi
          endi
       skip
   endd
endi

  
sele stkadjst
seek str(pr(5),4)+str(gwn2,2)
if found()
   do whil jcode=pr(5) and godwncode=gwn2
             if packcode=pr(7)
               opbl=opbl+bales
               opwt=opwt+weight
 	       endi
      skip
   endd
endi

 


sele issufile
seek str(pr(5),4)+str(gwn2,2)
 if found()
   do whil jcode=pr(5) and godwncode=gwn2
          if packcode=pr(7)
            opbl=opbl-bales
            opwt=opwt-weight
       endi
      skip
   endd
endi
 
sele jtadjust
set orde to adj3
seek str(pr(5),4)+str(gwn2,2)
if found()
   do whil jcodefrom=pr(5) and gcodefrm=gwn2
          if packcode=pr(7)
	            opbl=opbl-bales
            opwt=opwt-weight
       endi
       skip
   endd
   
endi

sele jtadjust
set orde to adj4
seek str(pr(5),4)+str(gwn2,2)
if found()
   do whil jcodeto=pr(5) and gcodeto=gwn2
          if  packcode=pr(7)
            opbl=opbl+bales
            opwt=opwt+weight
       endi
      
      skip
   endd
endi

sele currstok
if opbl+opwt#0
	appe blan
	repl jcode with pr(5)
	repl packcode with pr(7)
	repl godwncode with gwn2
	repl closbales with opbl
	repl closwght with opwt
	repl gwnno with gwnn
	if opbl#0
		if opwt#0
			repl retbales with opwt/opbl
		endi
	endi	
endi
sele godown
skip
endd

sele currstok
inde on str(jcode,3)+gwnno to cstk 
 
*: EOF: OPENCALC.PRG

****






sele issufile
set filt to issuedate=gr(2)
 
 
 
 proc gr33
if gr(2)<indt1
	wait wind 'Please Check Already Entered Next Date... '
	abc='Y'
*	retu 0
endi	
