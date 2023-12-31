<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteVisitModel;
use App\Models\VisitInstructionModel;
use App\Models\CountSiteVisitModel;

use Session;
use DB;
use Hash;
use PDF;


class VisitController extends Controller
{
    public function visitManage()
    {
    	return view('visit.siteVisitReport');
    }

    public function getVisits(Request $req)
    {
        $roles=Session::get('ROLES');
        $a_id=Session::get('USER_ID');
       
        //for all user
        // $u_obj=UserModel::where(['delete'=>0,'is_active'=>0])->where('role','!=','0')->orderby('created_at','DESC')->get();


        //get visit records

        $data=DB::table('site_visits as sv')
                ->leftjoin('projects as p','p.id','sv.pr_id')
                ->leftjoin('users as u','u.id','sv.u_id')
                ->select('sv.id','sv.project_type','sv.visit_date','sv.pr_id','sv.stage_contr','sv.visit_no','sv.attendees','sv.delete','sv.a_id','p.project_name','p.contractor','u.name')
                ->where(['sv.delete'=>0]);
                if($roles !=0){
                    $data =$data->where('sv.a_id',$a_id);
                }
                 $data = $data->get();

        // foreach($data as $d){
        
        //     // get task assign name
        //     $u_obj1=UserModel::where(['delete'=>0,'id'=>$d->et_aid])->orderby('created_at','DESC')->get();
        //     foreach($u_obj1 as $u){
        //         $d->assign_name = $u->name;
        //     }

        // }      

        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'roles' => $roles,'message' => 'Data Found'));
        }else{
        return ['status' => false, 'message' => 'No Data Found'];
        }

    }

    public function postVisitReport(Request $req)
    {
        $a_id=Session::get('USER_ID');
        $visit_date=isset($_POST['visit_date']) ? $_POST['visit_date'] : '';
        $project_type=isset($_POST['project_type']) ? $_POST['project_type'] : '';
        $pr_id=isset($_POST['pr_id']) ? $_POST['pr_id'] : '';
        $stage_contr=isset($_POST['stage_contr']) ? $_POST['stage_contr'] : '';
        $attendees=isset($_POST['attendees']) ? $_POST['attendees'] : '';

        // dd($customer_id);
        if($project_type == '' || $pr_id == ''){
            Session::put('ERROR_MESSAGE', 'Please select Project Type & Project.');
            return redirect()->back();
        }

        $c_obj=new SiteVisitModel();
        $c_obj->project_type=$project_type;
        $c_obj->visit_date=$visit_date;
        $c_obj->pr_id=$pr_id;                       // conv project id
        $c_obj->stage_contr=$stage_contr;
        $c_obj->attendees=$attendees;
        $c_obj->u_id=$a_id;                             // who create first visit entry- user id
        $c_obj->delete=0;
        $c_obj->a_id=$a_id;
        $res=$c_obj->save();
            
        $visit_id=$c_obj->id;

        $visit_count = CountSiteVisitModel::where(['delete'=>0,'pr_id'=>$pr_id])->get();
        if(count($visit_count) > 0){
            $csv_obj=CountSiteVisitModel::find($visit_count[0]->id);
            $csv_obj->project_type=$project_type;
            $csv_obj->pr_id=$pr_id;                                 // conv project id
            $csv_obj->visit_count=$visit_count[0]->visit_count+1;   // conv visit
            $csv_obj->delete=0;
            $csv_obj->a_id=$a_id;
            $res=$csv_obj->update();

            $visit_count = SiteVisitModel::where(['delete'=>0,'id'=>$visit_id])->update(['visit_no'=>$csv_obj->visit_count]);

        }else{
            $csv_obj=new CountSiteVisitModel();
            $csv_obj->project_type=$project_type;
            $csv_obj->pr_id=$pr_id;                       // conv project id
            $csv_obj->visit_count="1";
            $csv_obj->delete=0;
            $csv_obj->a_id=$a_id;
            $res=$csv_obj->save();

            $visit_count = SiteVisitModel::where(['delete'=>0,'id'=>$visit_id])->update(['visit_no'=>$csv_obj->visit_count]);
        }

       
       
        return redirect()->route('add.visit.instruction',$visit_id);
    }

    public function addVisit($visit_id)
    {
        //dd(Session::get('ROLES'));
        $sv_obj=DB::table('site_visits as sv')
                ->leftjoin('projects as p','p.id','sv.pr_id')
                ->leftjoin('users as u','u.id','sv.u_id')
                ->select('sv.id','sv.project_type','sv.visit_date','sv.attendees','sv.pr_id','sv.stage_contr','sv.delete','sv.a_id','sv.visit_no','p.project_name','p.contractor','u.name')
                ->where(['sv.id'=>$visit_id])
                ->get();

        $icount=VisitInstructionModel::where(['delete'=>0,'site_visit_id'=>$visit_id])->count();
        return view('visit.visit_add',compact('sv_obj','visit_id','icount'));
    }

    public function editVisit($visit_id)
    {
        //dd(Session::get('ROLES'));
        $sv_obj=DB::table('site_visits as sv')
                ->leftjoin('projects as p','p.id','sv.pr_id')
                ->leftjoin('users as u','u.id','sv.u_id')
                ->select('sv.id','sv.project_type','sv.visit_date','sv.pr_id','sv.stage_contr','sv.attendees','sv.delete','sv.a_id','p.project_name','p.contractor','u.name')
                ->where(['sv.id'=>$visit_id])
                ->get();
  
        $icount=VisitInstructionModel::where(['delete'=>0,'site_visit_id'=>$visit_id])->count();

        return view('visit.visit_add',compact('sv_obj','visit_id','icount'));
    }

    public function postInstruction(Request $req)
    {
        
    	$edit_id=empty($req->get('edit_id')) ? null : $req->get('edit_id');

    	$visit_id=empty($req->get('visit_id')) ? null : $req->get('visit_id');
        $instructions = $req->get('instructions');
   		$act_req_form = $req->get('act_req_form');
        $instr_date = $req->get('instr_date');
    	$a_id=Session::get('USER_ID');

        if($edit_id!=null)
    	{
            if($visit_id !='' && $instructions !='' && $act_req_form !='')
            {
                $u_obj=VisitInstructionModel::find($edit_id);
                $u_obj->site_visit_id=$visit_id;
                $u_obj->instructions=$instructions;
                $u_obj->act_req_form=$act_req_form;
                $u_obj->instr_date=$instr_date;
                $u_obj->u_id=$a_id;                             //Record created user id
                $u_obj->delete=0;
                $u_obj->a_id=$a_id;
                $res=$u_obj->update();
                
                if($res){
                    return ['status' => true,'message' => 'Instruction Update Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }
            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   

        }else{    

            if($visit_id !='' && $instructions !='' && $act_req_form !='') 
            {
                $u_obj=new VisitInstructionModel();
                $u_obj->site_visit_id=$visit_id;
                $u_obj->instructions=$instructions;
                $u_obj->act_req_form=$act_req_form;
                $u_obj->instr_date=$instr_date;
                $u_obj->u_id=$a_id;                             //Record created user id
                $u_obj->delete=0;
                $u_obj->a_id=$a_id;
                $res=$u_obj->save();

                if($res){
                    return ['status' => true,'message' => 'Instruction Add Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }
            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   
        }
        return ['status' => false, 'message' => 'Please Try Again..']; 
    }

    public function getInstructions(Request $req)
    {
        $roles=Session::get('ROLES');
        $a_id=Session::get('USER_ID');
       
        //for all user
        // $u_obj=UserModel::where(['delete'=>0,'is_active'=>0])->where('role','!=','0')->orderby('created_at','DESC')->get();

    	$visit_id=empty($req->get('visit_id')) ? null : $req->get('visit_id');

        //get visit records
        $data=DB::table('visit_instructions as vi')
                ->leftjoin('site_visits as sv','sv.id','vi.site_visit_id')
                ->leftjoin('projects as p','p.id','sv.pr_id')
                ->leftjoin('users as u','u.id','sv.u_id')
                ->select('vi.id','vi.instr_date','vi.site_visit_id','vi.instructions','vi.act_req_form','vi.delete','sv.project_type','sv.visit_date','sv.pr_id','sv.stage_contr','sv.delete','sv.a_id','p.project_name','p.contractor','u.name')
                ->where(['vi.delete'=>0])
                ->where(['vi.site_visit_id'=>$visit_id])
                ->get();

        // foreach($data as $d){
        
        //     // get task assign name
        //     $u_obj1=UserModel::where(['delete'=>0,'id'=>$d->et_aid])->orderby('created_at','DESC')->get();
        //     foreach($u_obj1 as $u){
        //         $d->assign_name = $u->name;
        //     }

        // }      
        $icount=VisitInstructionModel::where(['delete'=>0,'site_visit_id'=>$visit_id])->count();

        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'roles' => $roles,'icount' => $icount,'message' => 'Data Found'));
        }else{
        return ['status' => false, 'message' => 'No Data Found'];
        }

    }

    public function deleteInstruc(Request $req)
    {
        $id=$req->get('id');
        $p_obj=VisitInstructionModel::find($id);
        $p_obj->delete=1;
        $res=$p_obj->update();

        if($res){
            return ['status' => true, 'message' => 'Instruction Deleted Successfully'];
        }else{
           return ['status' => false, 'message' => 'Instruction Deletion Unsuccessfull...!'];
        }
    }

    public function generateVisitPDF($visit_id)
    {
        $a_id=Session::get('USER_ID');
        $attendees=isset($_POST['attendees']) ? $_POST['attendees'] : '';
        $site_vobj = SiteVisitModel::where(['delete'=>0,'id'=>$visit_id])->update(['attendees'=>$attendees]);

        $sv_obj=DB::table('site_visits as sv')
            ->leftjoin('projects as p','p.id','sv.pr_id')
            ->leftjoin('users as u','u.id','sv.u_id')
            ->select('sv.id','sv.project_type','sv.visit_date','sv.pr_id','sv.stage_contr','sv.attendees','sv.delete','sv.a_id','p.project_name','p.contractor','u.name')
            ->where(['sv.id'=>$visit_id])
            ->get();
            foreach($sv_obj as $sv)
            {
                $sv->vdate = date('d-m-Y', strtotime($sv->visit_date));
                $visit_count = CountSiteVisitModel::where(['delete'=>0,'pr_id'=>$sv->pr_id])->get();
                foreach($visit_count as $vc)
                {
                    $sv->visit_count = $vc->visit_count;
                }

            }

        $data=DB::table('visit_instructions as vi')
            ->leftjoin('site_visits as sv','sv.id','vi.site_visit_id')
            ->leftjoin('projects as p','p.id','sv.pr_id')
            ->leftjoin('users as u','u.id','sv.u_id')
            ->select('vi.id','vi.instr_date','vi.site_visit_id','vi.instructions','vi.act_req_form','vi.delete','sv.project_type','sv.visit_date','sv.pr_id','sv.stage_contr','sv.attendees','sv.delete','sv.a_id','p.project_name','p.contractor','u.name')
            ->where(['vi.delete'=>0])
            ->where(['vi.site_visit_id'=>$visit_id])
            ->get();

        foreach($data as $d)
        {
            $d->date = date('d-m-Y', strtotime($d->instr_date));
        }

        // return view('report.siteExpensePdf');
        $pdf1 =PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('visit.siteVisitPdf',compact('sv_obj','data'))->setPaper('a4', 'potrait');
        
        $pdf1->getDomPDF()->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed'=> TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );
        // $file_name="Expense.pdf";
        // $delOldPDF = "public/files/temp/$file_name";
        // file_put_contents("public/files/temp/$file_name", $pdf1->download());
        
        return $pdf1->download();
    }
}
