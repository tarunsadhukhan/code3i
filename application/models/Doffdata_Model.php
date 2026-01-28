<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doffdata_Model extends  CI_Model   {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function create($formarray)
	{
		//$this->load->view('welcome_message');
		//echo 'welcodem to alalal';
    //    $this->load->view('admin/dashboard');
        $this->db->insert('categories',$formarray);
        $admin=$this->db->get('user')->row_array(); 
        return $admin;
 	}

	 public function getCategories() {

	//	$result = $this->db->get('spell_master')->result_array();
//		$query = $this->db->query('YOUR QUERY HERE');

		$result = $this->db->query('select * from spell_master where company_id=2 order by spell_name')->result_array();

		//	return $result;
	/*
		echo '<pre>';
		print_r('mmmm');
		print_r($result);
		echo '</pre>';
	*/
		return $result;
	}

	public function get_name_by_empCode($frameNo) {
        // Perform database query to retrieve the name based on the empCode
        // Replace the following code with your own logic

        // Example query using CodeIgniter's Active Record
       // $this->db->select('name');
       // $this->db->from('employees');
       // $this->db->where('empCode', $empCode);
     //   $query = $this->db->get();
		$sql="select g.trollyno,trolly_weight name from 
		(
		select trollyno,company_id from dofftable dft where  auto_id in 
		(select max(auto_id) auto_id from dofftable dftmx where dftmx.frameno =$frameNo and company_id =1) 
		) g left join 
		 trollymst trmst on g.trollyno=trmst.trollyno and g.company_id=trmst.company_id 
		 where process_type=2";
		$query=$this->db->query($sql);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->name;
        } else {
            return false;
        }
    }




	public function getDoff10sumData($date, $compid, $frameNo)
{
	$sql="select 'Frames Run' mech_code,'' bobbin_count,'' stddoffwt,'' a1stddoff,a1frame a1doff,
	a1netwt,'' a1avgwtdoff,'' a2stddoff,a2frame a2doff,a2netwt,'' a2avgwtdoff,'' adoff,a1netwt+a2netwt anetwt,
	'' aavgwt,'' aeff,'' b1stddoff,b1frame b1doff,
	b1netwt,'' b1avgwtdoff,'' b2stddoff,b2frame b2doff,b2netwt,'' b2avgwtdoff,'' bdoff,b1netwt+b2netwt bnetwt,
	'' bavgwt,'' beff,'' cstddoff,cframe cdoff,
	cnetwt,'' cavgwt,'' ceff,'' odoff,round(a1netwt+a2netwt+b1netwt+b2netwt+cnetwt) onetwt,'' oavgwt,'' oeff
	from(
	SELECT
		company_id,
		doffdate, 
		SUM(CASE WHEN spell = 'A1' THEN framerun ELSE 0 END) AS a1frame,
		SUM(CASE WHEN spell = 'A2' THEN framerun ELSE 0 END) AS a2frame,
		SUM(CASE WHEN spell = 'B1' THEN framerun ELSE 0 END) AS b1frame,
		SUM(CASE WHEN spell = 'B2' THEN framerun ELSE 0 END) AS b2frame,
		SUM(CASE WHEN spell = 'C' THEN framerun ELSE 0 END) AS cframe,
		SUM(CASE WHEN spell = 'A1' THEN round(netwt,0) ELSE 0 END) AS a1netwt,
		SUM(CASE WHEN spell = 'A2' THEN round(netwt,0) ELSE 0 END) AS a2netwt,
		SUM(CASE WHEN spell = 'B1' THEN round(netwt,0) ELSE 0 END) AS b1netwt,
		SUM(CASE WHEN spell = 'B2' THEN round(netwt,0) ELSE 0 END) AS b2netwt,
		SUM(CASE WHEN spell = 'C' THEN round(netwt,0) ELSE 0 END) AS cnetwt
	FROM (
		SELECT
			company_id,
			doffdate,
			spell,
			COUNT(*) AS framerun,
			SUM(netwt) AS netwt
		FROM (
			SELECT
				company_id,
				doffdate,
				spell,
				frameno,
				ROUND(SUM(netwt), 2) AS netwt
			FROM dofftable d
			WHERE d.company_id = ".$compid."
			AND doffdate = '".$date."'
			AND d.is_active = 1
			GROUP BY company_id, doffdate, spell, frameno
		) g
		GROUP BY company_id, doffdate, spell
	) k
	GROUP BY company_id, doffdate
	) h
	";
	$query = $this->db->query($sql)->result_array();
	return $this->db->query($sql)->result();



}

	public function getDoff10Data($date, $compid, $frameNo)
{
$sql="select
v.*,concat(a1qcode,'-',a1quality) a1quality,concat(a1ebno,'-',a1empname) a1empname,
concat(a2qcode,'-',a2quality) a2quality,concat(a2ebno,'-',a2empname) a2empname,
concat(b1qcode,'-',b1quality) b1quality,concat(b1ebno,'-',b1empname) b1empname,
concat(b2qcode,'-',b2quality) b2quality,concat(b2ebno,'-',b2empname) b2empname,
concat(cqcode,'-',cquality) cquality,concat(cebno,'-',cempname) cempname,
case
	when (a1netwt + a2netwt)>0 then round(a1doff + a2doff, 0)
	else 0
end adoff,
case
	when (a1netwt + a2netwt)>0 then round(a1netwt + a2netwt, 2)
	else 0
end anetwt,
case
	when (a1netwt + a2netwt)>0 then round((a1netwt + a2netwt)/(a1doff + a2doff), 2)
	else 0
end aavgwt,
case
	when (a1netwt + a2netwt)>0 then round((a1netwt + a2netwt)/(a1stdwt + a2stdwt)* 100, 2)
	else 0
end aeff,
case
	when (b1netwt + b2netwt)>0 then round(b1doff + b2doff, 0)
	else 0
end bdoff,
case
	when (b1netwt + b2netwt)>0 then round(b1netwt + b2netwt, 0)
	else 0
end bnetwt,
case
	when (b1netwt + b2netwt)>0 then round((b1netwt + b2netwt)/(b1doff + b2doff), 2)
	else 0
end bavgwt,
case
	when (b1netwt + b2netwt)>0 then round((b1netwt + b2netwt)/(b1stdwt + b2stdwt)* 100, 2)
	else 0
end beff,
case
	when (cnetwt)>0 then round((cnetwt)/(cdoff), 2)
	else 0
end cavgwt,
case
	when (cnetwt)>0 then round(cnetwt / cstdwt * 100, 2)
	else 0
end ceff,
case
	when (a1netwt + a2netwt + b1netwt + b2netwt + cnetwt)>0 then round((a1doff + a2doff + b1doff + b2doff + cdoff), 0)
	else 0
end odoff,
case
	when (a1netwt + a2netwt + b1netwt + b2netwt + cnetwt)>0 then round((a1netwt + a2netwt + b1netwt + b2netwt + cnetwt), 0)
	else 0
end onetwt,
case
	when (a1netwt + a2netwt + b1netwt + b2netwt + cnetwt)>0 then round((a1netwt + a2netwt + b1netwt + b2netwt + cnetwt)/(a1doff + a2doff + b1doff + b2doff + cdoff), 2)
	else 0
end oavgwt,
case
	when (a1netwt + a2netwt + b1netwt + b2netwt + cnetwt)>0 then round((a1netwt + a2netwt + b1netwt + b2netwt + cnetwt)/(a1stdwt + a2stdwt + b1stdwt + b2stdwt + cstdwt)* 100, 2)
	else 0
end oeff
from
(
SELECT
	company_id,
	date_format(doffdate,'%d-%m-%Y') doffdate,
	frameno,
	mech_code ,
	mechine_name ,
	bobbin_count,
	stddoffwt,
	MAX(CASE WHEN spell = 'A1' THEN stda3 ELSE 0 END) AS a1stddoff,
	MAX(CASE WHEN spell = 'A1' THEN noofdoff ELSE 0 END) AS a1doff,
	MAX(CASE WHEN spell = 'A1' THEN netwt ELSE 0 END) AS a1netwt,
	MAX(CASE WHEN spell = 'A1' THEN avgwtdoff ELSE 0 END) AS a1avgwtdoff,
	MAX(CASE WHEN spell = 'A1' THEN wrk_hours ELSE 0 END) AS a1whrs,
	MAX(CASE WHEN spell = 'A1' THEN stdwt ELSE 0 END) AS a1stdwt,
	MAX(CASE WHEN spell = 'A1' THEN q_code ELSE 0 END) AS a1qcode,
	MAX(CASE WHEN spell = 'A1' THEN quality_name ELSE 0 END) AS a1quality,
	MAX(CASE WHEN spell = 'A1' THEN ebno ELSE 0 END) AS a1ebno,
	MAX(CASE WHEN spell = 'A1' THEN empname ELSE 0 END) AS a1empname,
	MAX(CASE WHEN spell = 'A2' THEN stda3 ELSE 0 END) AS a2stddoff,
	MAX(CASE WHEN spell = 'A2' THEN noofdoff ELSE 0 END) AS a2doff,
	MAX(CASE WHEN spell = 'A2' THEN netwt ELSE 0 END) AS a2netwt,
	MAX(CASE WHEN spell = 'A2' THEN avgwtdoff ELSE 0 END) AS a2avgwtdoff,
	MAX(CASE WHEN spell = 'A2' THEN wrk_hours ELSE 0 END) AS a2whrs,
	MAX(CASE WHEN spell = 'A2' THEN stdwt ELSE 0 END) AS a2stdwt,
	MAX(CASE WHEN spell = 'A2' THEN q_code ELSE 0 END) AS a2qcode,
	MAX(CASE WHEN spell = 'A2' THEN quality_name ELSE 0 END) AS a2quality,
	MAX(CASE WHEN spell = 'A2' THEN ebno ELSE 0 END) AS a2ebno,
	MAX(CASE WHEN spell = 'A2' THEN empname ELSE 0 END) AS a2empname,
	MAX(CASE WHEN spell = 'B1' THEN stda3 ELSE 0 END) AS b1stddoff,
	MAX(CASE WHEN spell = 'B1' THEN noofdoff ELSE 0 END) AS b1doff,
	MAX(CASE WHEN spell = 'B1' THEN netwt ELSE 0 END) AS b1netwt,
	MAX(CASE WHEN spell = 'B1' THEN avgwtdoff ELSE 0 END) AS b1avgwtdoff,
	MAX(CASE WHEN spell = 'B1' THEN working_hours ELSE 0 END) AS b1whrs,
	MAX(CASE WHEN spell = 'B1' THEN stdwt ELSE 0 END) AS b1stdwt,
	MAX(CASE WHEN spell = 'B1' THEN q_code ELSE 0 END) AS b1qcode,
	MAX(CASE WHEN spell = 'B1' THEN quality_name ELSE 0 END) AS b1quality,
	MAX(CASE WHEN spell = 'B1' THEN ebno ELSE 0 END) AS b1ebno,
	MAX(CASE WHEN spell = 'B1' THEN empname ELSE 0 END) AS b1empname,
	MAX(CASE WHEN spell = 'B2' THEN stda3 ELSE 0 END) AS b2stddoff,
	MAX(CASE WHEN spell = 'B2' THEN noofdoff ELSE 0 END) AS b2doff,
	MAX(CASE WHEN spell = 'B2' THEN netwt ELSE 0 END) AS b2netwt,
	MAX(CASE WHEN spell = 'B2' THEN avgwtdoff ELSE 0 END) AS b2avgwtdoff,
	MAX(CASE WHEN spell = 'B2' THEN wrk_hours ELSE 0 END) AS b2whrs,
	MAX(CASE WHEN spell = 'B2' THEN stdwt ELSE 0 END) AS b2stdwt,
	MAX(CASE WHEN spell = 'B2' THEN q_code ELSE 0 END) AS b2qcode,
	MAX(CASE WHEN spell = 'B2' THEN quality_name ELSE 0 END) AS b2quality,
	MAX(CASE WHEN spell = 'B2' THEN ebno ELSE 0 END) AS b2ebno,
	MAX(CASE WHEN spell = 'B2' THEN empname ELSE 0 END) AS b2empname,
	MAX(CASE WHEN spell = 'C' THEN avgwtdoff ELSE 0 END) AS cavgwtdoff,
	MAX(CASE WHEN spell = 'C' THEN noofdoff ELSE 0 END) AS cdoff,
	MAX(CASE WHEN spell = 'C' THEN netwt ELSE 0 END) AS cnetwt,
	MAX(CASE WHEN spell = 'C' THEN stda3 ELSE 0 END) AS cstddoff,
	MAX(CASE WHEN spell = 'C' THEN working_hours ELSE 0 END) AS cwhrs,
	MAX(CASE WHEN spell = 'C' THEN stdwt ELSE 0 END) AS cstdwt,
	MAX(CASE WHEN spell = 'C' THEN q_code ELSE 0 END) AS cqcode,
	MAX(CASE WHEN spell = 'C' THEN quality_name ELSE 0 END) AS cquality,
	MAX(CASE WHEN spell = 'C' THEN ebno ELSE 0 END) AS cebno,
	MAX(CASE WHEN spell = 'C' THEN empname ELSE 0 END) AS cempname
FROM
	(
	select
		d.*,
		sm.working_hours,
		mm.mech_code ,
		mm.mechine_name ,
		mm.bobbin_count,
		round(350 * mm.bobbin_count / 1000, 2) stddoffwt,
		round(((working_hours * 60)-round(working_hours * 60 /(350 /((wqm.speed / wqm.tpi)*(1 / 36)*(wqm.yarn_count / 14400)* 453.6)), 0)* 2)/ (350 /((wqm.speed / wqm.tpi)*(1 / 36)*(wqm.yarn_count / 14400)* 453.6)), 2) stda3,
		wqm.speed ,
		wqm.tpi,
		wqm.yarn_count,
		tpwqm.spg_actual_count ,
		round(netwt / noofdoff, 2) avgwtdoff,
		case
			when (netwt)>0 then working_hours
			else 0
		end wrk_hours,
		case
			when (netwt)>0 then round(((wqm.speed *(working_hours)* 60 * spg_actual_count * mm.bobbin_count)/(tpi * 14400 * 2.2046 * 36)), 2)
			else 0
		end stdwt,
		wqm.quality_name,concat(thepd.first_name, ' ', ifnull(thepd.middle_name, ''), ' ', thepd.last_name) empname
	from
		(
		select
			company_id,
			doffdate,
			spell,
			frameno,
			q_code,
			ebno,count(*) noofdoff,
			round(sum(netwt), 2) netwt
		from
			dofftable d
		where
			d.company_id = ".$compid." 
			AND doffdate = '".$date."'
			AND d.is_active = 1
		group by
			company_id,
			doffdate,
			spell,
			frameno,
			q_code,ebno ) d
	left join spell_master sm on
		d.spell = sm.spell_name
		and sm.company_id = d.company_id
	left join mechine_master mm on
		d.frameno = mm.frame_no
		and d.company_id = mm.company_id
	left join weaving_quality_master wqm on
		d.q_code = wqm.quality_code
		and d.company_id = wqm.company_id
	left join tbl_prod_weaving_quality_mapping tpwqm on
		wqm.quality_id = tpwqm.quality_id
		and wqm.company_id = tpwqm.company_id
		and tpwqm.mapping_date = d.doffdate
		left join ( select * from tbl_hrms_ed_official_details where is_active=1) theod on
			theod.emp_code = d.ebno
		left join tbl_hrms_ed_personal_details thepd on
			thepd.eb_id = theod.eb_id
			and d.company_id = thepd.company_id			
			where
		mm.type_of_mechine = 36 ) g
GROUP BY
	doffdate,
	frameno,
	mech_code ,
	mechine_name ,
	bobbin_count,
	stddoffwt,
	company_id ) v
order by
CAST(frameno AS UNSIGNED)
";
//echo $sql;

	$query = $this->db->query($sql)->result_array();
	return $this->db->query($sql)->result();
	
}


	
public function getDoffqcsummData($date, $compid, $frameNo)
{
	$stdsfthrsa=8;
	$stdsfthrsb=8;
	$stdsfthrsc=7.5;

	if ( $compid==1) {
		$stdsfthrsa=8;
		$stdsfthrsb=8;
		$stdsfthrsc=8;
	}

	if ($date<='2024-06-13' and $compid==2) {
		$stdsfthrsa=8;
		$stdsfthrsb=8;
		$stdsfthrsc=7.5;
	}
	if ($date>='2024-06-14' and $date<='2024-06-30' and $compid==2) {
		$stdsfthrsa=6;
		$stdsfthrsb=6;
		$stdsfthrsc=7.5;
	}

	$sql="select k.company_id,doffdate,q_code,quality_name, 
	MAX(CASE WHEN shift='A' THEN nofrm ELSE 0 END) AS afrm,
	MAX(CASE WHEN shift='B' THEN nofrm ELSE 0 END) AS bfrm,
	MAX(CASE WHEN shift='C' THEN nofrm ELSE 0 END) AS cfrm,
	MAX(CASE WHEN shift='A' THEN netwt ELSE 0 END) AS awt,
	MAX(CASE WHEN shift='B' THEN netwt ELSE 0 END) AS bwt,
	MAX(CASE WHEN shift='C' THEN netwt ELSE 0 END) AS cwt
	,sum(nofrm) tnofrm,sum(netwt) tnetwt
	from (
	select g.company_id,doffdate,shift,q_code,
	case when shift<>'C' then round(sum(working_hours)/".$stdsfthrsa.",2) 
	 when g.company_id=1 and shift='C' then round(sum(working_hours)/".$stdsfthrsb.",2) 
	else round(sum(working_hours)/".$stdsfthrsc.",2) end nofrm,sum(netwt) netwt from
	(select a.*,sm.working_hours  from
	(
	select company_id,doffdate,substr(spell,1,1) shift,spell,q_code,frameno,round(sum(netwt),0) netwt  from dofftable d
	where doffdate = '".$date."' and company_id= ".$compid." and is_active=1
	group by company_id,doffdate,substr(spell,1,1),spell,q_code,frameno 
	) a
	left join spell_master sm on a.spell=sm.spell_name and a.company_id=sm.company_id 
	) g group by g.company_id,doffdate,shift,q_code
	) k left join weaving_quality_master wqm on k.q_code=wqm.quality_code 
	and k.company_id=wqm.company_id 
	group by k.company_id,doffdate,q_code,quality_name
	
	";
	//echo $sql;
	$query = $this->db->query($sql)->result_array();
	return $this->db->query($sql)->result();



}



	public function getDoff10Data1($date, $compid, $frameNo)
{

	$sql="SELECT
	a.*,
	round(a1doff + a2doff,0) adoff,
	a1netwt + a2netwt anetwt,
	round((a1netwt + a2netwt)/(a1doff + a2doff), 2) aavgwt,
	round((a1netwt + a2netwt)/((speed *(a1whrs + a2whrs)* 60 * spg_actual_count * bobbin_count)/(tpi * 1440022.2046 * 36)), 2) aeff,
	b1doff + b2doff bdoff,
	round(b1netwt + b2netwt,2) bnetwt,
	round((b1netwt + b2netwt)/(b1doff + b2doff), 2) bavgwt,
	round((b1netwt + b2netwt)/((speed *(b1whrs + b2whrs)* 60 * spg_actual_count * bobbin_count)/(tpi * 1440022.2046 * 36)), 2) beff,
	round((cnetwt)/((speed *(cwhrs)* 60 * spg_actual_count * bobbin_count)/(tpi * 1440022.2046 * 36)), 2) ceff,
	round(350 * bobbin_count / 1000, 2) stdwtddoff,
	round((cnetwt)/(cdoff),2) cavgwt,
	round(a1doff + a2doff+b1doff + b2doff+cdoff,0) ovdoff,
	round(a1netwt + a2netwt+b1netwt + b2netwt+cnetwt,0) ovnetwt,
	round((a1netwt + a2netwt+b1netwt + b2netwt+cnetwt)/(a1doff + a2doff+b1doff + b2doff+cdoff), 2) ovavgwt,
	round((a1netwt + a2netwt+b1netwt + b2netwt+cnetwt)/((speed *(a1whrs + a2whrs+a1whrs + a2whrs+cwhrs)* 60 * spg_actual_count * bobbin_count)/(tpi * 1440022.2046 * 36)), 2) oveff
	from
	(
	SELECT
		company_id,
		doffdate,
		frameno,
		q_code,
		mech_code ,
		mechine_name ,
		bobbin_count,
		speed,
		tpi,
		yarn_count,
		spg_actual_count ,
		MAX(CASE WHEN spell = 'A1' THEN stda3 ELSE 0 END) AS a1stddoff,
		MAX(CASE WHEN spell = 'A1' THEN noofdoff ELSE 0 END) AS a1doff,
		MAX(CASE WHEN spell = 'A1' THEN netwt ELSE 0 END) AS a1netwt,
		MAX(CASE WHEN spell = 'A1' THEN avgwtdoff ELSE 0 END) AS a1avgwtdoff,
		MAX(CASE WHEN spell = 'A1' THEN working_hours ELSE 0 END) AS a1whrs,
		MAX(CASE WHEN spell = 'A2' THEN stda3 ELSE 0 END) AS a2stddoff,
		MAX(CASE WHEN spell = 'A2' THEN noofdoff ELSE 0 END) AS a2doff,
		MAX(CASE WHEN spell = 'A2' THEN netwt ELSE 0 END) AS a2netwt,
		MAX(CASE WHEN spell = 'A2' THEN avgwtdoff ELSE 0 END) AS a2avgwtdoff,
		MAX(CASE WHEN spell = 'A2' THEN working_hours ELSE 0 END) AS a2whrs,
		MAX(CASE WHEN spell = 'B1' THEN stda3 ELSE 0 END) AS b1stddoff,
		MAX(CASE WHEN spell = 'B1' THEN noofdoff ELSE 0 END) AS b1doff,
		MAX(CASE WHEN spell = 'B1' THEN netwt ELSE 0 END) AS b1netwt,
		MAX(CASE WHEN spell = 'B1' THEN avgwtdoff ELSE 0 END) AS b1avgwtdoff,
		MAX(CASE WHEN spell = 'B1' THEN working_hours ELSE 0 END) AS b1whrs,
		MAX(CASE WHEN spell = 'B2' THEN stda3 ELSE 0 END) AS b2stddoff,
		MAX(CASE WHEN spell = 'B2' THEN noofdoff ELSE 0 END) AS b2doff,
		MAX(CASE WHEN spell = 'B2' THEN netwt ELSE 0 END) AS b2netwt,
		MAX(CASE WHEN spell = 'B2' THEN avgwtdoff ELSE 0 END) AS b2avgwtdoff,
		MAX(CASE WHEN spell = 'B2' THEN working_hours ELSE 0 END) AS b2whrs,
		MAX(CASE WHEN spell = 'C' THEN avgwtdoff ELSE 0 END) AS cavgwtdoff,
		MAX(CASE WHEN spell = 'C' THEN noofdoff ELSE 0 END) AS cdoff,
		MAX(CASE WHEN spell = 'C' THEN netwt ELSE 0 END) AS cnetwt,
		MAX(CASE WHEN spell = 'C' THEN stda3 ELSE 0 END) AS cstddoff,
		MAX(CASE WHEN spell = 'C' THEN working_hours ELSE 0 END) AS cwhrs
	FROM
		(
		SELECT
			d.company_id,
			doffdate,
			spell,
			frameno,
			q_code,
			mm.mech_code ,
			mm.mechine_name ,
			mm.bobbin_count,
			round(350 * mm.bobbin_count / 1000, 2) stddoffwt,
			(wqm.speed / wqm.tpi) s1,
			(1 / 36) s2,
			(wqm.yarn_count / 14400) s3,
			( (wqm.speed / wqm.tpi) * (1 / 36) * (wqm.yarn_count / 14400) * 453.6) stda1,
			(350 /((wqm.speed / wqm.tpi)*(1 / 36)*(wqm.yarn_count / 14400)* 453.6)) stdn1,
			round(working_hours * 60 /(350 /((wqm.speed / wqm.tpi)*(1 / 36)*(wqm.yarn_count / 14400)* 453.6)), 0)* 2 stda2,
			round(((working_hours * 60)-round(working_hours * 60 /(350 /((wqm.speed / wqm.tpi)*(1 / 36)*(wqm.yarn_count / 14400)* 453.6)), 0)* 2)/ (350 /((wqm.speed / wqm.tpi)*(1 / 36)*(wqm.yarn_count / 14400)* 453.6)), 2) stda3,
			wqm.speed,
			wqm.tpi,
			wqm.yarn_count ,
			tpwqm.spg_actual_count ,
			COUNT(*) AS noofdoff,
			ROUND(SUM(netwt), 2) AS netwt ,
			round(SUM(netwt)/ count(*), 2) avgwtdoff,
			case
				when SUM(netwt)>0 then working_hours
				else 0
			end working_hours		FROM
			dofftable d
		left join mechine_master mm on
			d.frameno = mm.frame_no
			and d.company_id = mm.company_id
		left join spell_master sm on
			d.spell = sm.spell_name
			and sm.company_id = d.company_id
		left join weaving_quality_master wqm on
			d.q_code = wqm.quality_code
			and d.company_id = wqm.company_id
		left join tbl_prod_weaving_quality_mapping tpwqm on
			wqm.quality_id = tpwqm.quality_id
			and wqm.company_id = tpwqm.company_id
			and tpwqm.mapping_date = d.doffdate
		WHERE
			d.company_id = ".$compid."
			AND doffdate = '".$date."'
			AND d.is_active = 1
			and mm.type_of_mechine = 36
		GROUP BY
			doffdate,
			spell,
			d.frameno,
			q_code,
			mm.mech_code ,
			mm.mechine_name ,
			mm.bobbin_count,
			d.company_id,
			working_hours,
			stddoffwt,
			stda1,
			stdn1,
			stda2,
			wqm.speed,
			wqm.tpi,
			wqm.yarn_count,
			s1,
			s2,
			s3,
			stda3,
			tpwqm.spg_actual_count
		order by
			d.frameno,
			d.spell 
			) g
	GROUP BY
		doffdate,
		frameno,
		q_code,
		mech_code ,
		mechine_name ,
		bobbin_count,
		company_id,
		speed,
		tpi,
		yarn_count,
		spg_actual_count ) a  
	";					 

//	echo $sql;
$query = $this->db->query($sql)->result_array();
return $this->db->query($sql)->result();
//return $query;


//    $query = $this->db->get();

    // Return the result
//    return $query->result();
}

public function getDoffrepData($date, $compid, $frameNo,$shiftName)
{

	$sql = "select auto_id, DATE_FORMAT(doffdate , '%d-%m-%Y') doffdate,spell,frameno,ebno,q_code,trollyno,grosswt ,tarewt ,netwt,
	DATE_FORMAT(entrydate , '%H:%i') dofftime, concat(d.ebno,'-',thepd.first_name,' ',ifnull(thepd.middle_name,''),' ',thepd.last_name)  empname,  
	concat(ifnull(d.q_code,''),'-',ifnull(wqm.quality_name,'')) quality
	from dofftable d 
	left join weaving_quality_master wqm on wqm.quality_code =d.q_code and wqm.quality_type =2 and d.company_id =wqm.company_id 
	left join tbl_hrms_ed_official_details theod on theod.emp_code =d.ebno 
	left join tbl_hrms_ed_personal_details thepd on thepd.eb_id =theod.eb_id and d.company_id =thepd.company_id 
	where ifnull(theod.is_active,1)=1 and  d.company_id =".$compid." and d.is_active =1  AND d.doffdate ='".$date."' ";
    if (strlen($shiftName)>0 ) {
			$sql=$sql." and spell='".$shiftName."' ";
	}
	if (strlen($frameNo)>0 ) {
		$sql=$sql." and frameno='".$frameNo."' ";
	}
	"order by auto_id desc
	"; 

	echo $sql;
$query = $this->db->query($sql)->result_array();
return $this->db->query($sql)->result();
//return $query;


//    $query = $this->db->get();

    // Return the result
//    return $query->result();
}

 
public function getloomrepData($date,$endate, $compid)
{

 

	$sql="select DATE_FORMAT(loom_date,'%d/%m/%Y') loomdate,mm.mech_code,spell,prod/fln*16 prod,whrs,round(prod/eff*100,3) stdprod,ebno,qcode,eff,dprd.loom_id,ashots from (
		select loom_date,company_id compid,loom_id,ticket_no_a1 ebno,'A1' spell,'A' Shift,quality_code_a1 qcode,production_a1 prod,working_hrs_a1 whrs,
		efficiency_a1 eff,actual_shots_a1 ashots,speed_a1 speed,finished_length_a1 fln from cuts_jugar_buff_1 cjb  
		where production_a1>0 and loom_date between '".$date."' and '".$endate."' and company_id =".$compid." 
		union all
		select loom_date,company_id compid,loom_id,ticket_no_a2 ebno,'A2' spell,'A' Shift,quality_code_a2 qcode,production_a2 prod,working_hrs_a2 whrs,efficiency_a2 eff
		,actual_shots_a2 ashots,speed_a2 speed,finished_length_a2 fln  from cuts_jugar_buff_1 cjb  
		where production_a2>0 and loom_date between '".$date."' and '".$endate."' and company_id =".$compid." 
		union all
		select loom_date,company_id compid,loom_id,ticket_no_b1 ebno,'B1' spell,'B' Shift,quality_code_b1 qcode,production_b1 prod,working_hrs_b1 whrs,efficiency_b1 eff
		,actual_shots_b1 ashots,speed_b1 speed,finished_length_b1 fln  from cuts_jugar_buff_1 cjb  
		where production_b1>0 and loom_date between '".$date."' and '".$endate."' and company_id =".$compid." 
		union all
		select loom_date,company_id compid,loom_id,ticket_no_b2 ebno,'B2' spell,'B' Shift,quality_code_b2 qcode,production_b2 prod,working_hrs_b2 whrs,efficiency_b2 eff
		,actual_shots_b2 ashots,speed_b2 speed,finished_length_b2 fln  from cuts_jugar_buff_1 cjb  
		where production_b2>0 and loom_date between '".$date."' and '".$endate."' and company_id =".$compid." 
		union all
		select loom_date,company_id compid,loom_id,ticket_no_c ebno,'C' spell,'C' Shift,quality_code_c qcode,production_c prod,working_hrs_c whrs,efficiency_c eff
		,actual_shots_c ashots,speed_c speed,finished_length_c fln  from cuts_jugar_buff_1 cjb  
		where production_c>0 and loom_date between '".$date."' and '".$endate."' and company_id =".$compid." 
		) dprd left join mechine_master mm on dprd.loom_id=mm.mechine_id";

	echo $sql;
$query = $this->db->query($sql)->result_array();
return $this->db->query($sql)->result();

}

public function getQualitydata() {
         
	$company_id = $this->session->userdata('company_id');
	$sql='select wnd_quality_id,concat(WND_Q_CODE,"-",QUALITY) QUALITY from WINDING_QUALITY_MASTER where company_id='.$company_id.'  order by quality';
	$otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
	$resultq = $otherdb->query($sql)->result_array();
	$otherdb->close();
//     var_dump($resultq);
	return $resultq;


}

public function getspgQualitydata() {

	
	$sql="update spining_master set company_id=2,branch_id=29,is_active=1 where company_id is null";

	$data = array(
        'company_id' => 2,
		'branch_id' => 29,
		'is_active' => 1
		);

//var dump($data);
$otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.

$otherdb->where('company_id', null);
$otherdb->update('spining_master', $data);
	$date=date('Y-m-d');	
	$company_id = $this->session->userdata('company_id');


	$sql='select q_code wnd_q_code,concat(q_code,"-",std_count,"LBS-",subgroup_type) QUALITY from spining_master where company_id='.$company_id.'  and is_active=1 order by q_code';
	$otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
//	$resultq = $otherdb->query($sql)->result_array();

	$sql="select wqm.quality_code wnd_q_code,wqm.quality_name QUALITY,ifnull(tpwqm.spg_actual_count,0) spg_actual_count  from tbl_prod_weaving_quality_mapping tpwqm 
	left join weaving_quality_master wqm on tpwqm.quality_id =wqm.quality_id and wqm.company_id =tpwqm.company_id 
	where mapping_date ='".$date."' and tpwqm.company_id =".$company_id." and tpwqm.quality_type =2 and tpwqm.is_active =1";
			
	$resultq = $this->db->query($sql)->result_array();		

	//	echo $otherdb->last_query();
//	var_dump($resultq);
$otherdb->close();
	return $resultq;


}

public function getspgqualityselData($date, $compid,$spgquality_id) {
	$otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
	$sql="select ";
	$otherdb->close();

	$sql="select wqm.quality_code wnd_q_code,wqm.quality_name QUALITY,ifnull(tpwqm.spg_actual_count,0) spg_actual_count  from tbl_prod_weaving_quality_mapping tpwqm 
	left join weaving_quality_master wqm on tpwqm.quality_id =wqm.quality_id and wqm.company_id =tpwqm.company_id 
	where mapping_date ='".$date."' and tpwqm.company_id =".$company_id." and tpwqm.quality_type =2 and tpwqm.is_active =1";



	

	$sql='select q_code wnd_q_code,concat(q_code,"-",std_count,"LBS-",subgroup_type) QUALITY from spining_master where company_id='.$company_id.'  and is_active=1 order by q_code';
	$otherdb = $this->load->database('empmill12', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
	$resultq = $otherdb->query($sql)->result_array();
//	echo $otherdb->last_query();
//	var_dump($resultq);
$otherdb->close();
	return $resultq;


}





}
