<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CommonController as Common;
use App\Models\AutoValuesModel;
use App\Models\ConveretedAutoValuesModel;
use App\Models\UserModel;
use App\Models\ProjectTypeModel;
use App\Models\ProjectModel;
use Session;
use DB;
use Hash;

class ProjectEnquiryController extends Controller
{
    public function projectEnquiry()
    {
    	$u_obj=UserModel::where(['delete'=>0,'role'=>1,'is_active'=>0])->orderby('created_at','DESC')->get();

    	return view('project.projectEnquiry',compact('u_obj'));
    }

    public function getEnq(Request $req)
    {
        $roles=Session::get('ROLES');
        $a_id=Session::get('USER_ID');

        //for all project Head
        $prhead_obj=UserModel::where(['delete'=>0,'role'=>1,'is_active'=>0])->orderby('created_at','DESC')->get();
        
        //for all Employee
        $employee_obj=UserModel::where(['delete'=>0,'role'=>2,'is_active'=>0])->orderby('created_at','DESC')->get();

        //for all supervisor
        $ssupervisor_obj=UserModel::where(['delete'=>0,'role'=>3,'is_active'=>0])->orderby('created_at','DESC')->get();

        //get peoject records
        $data=DB::table('projects as pr')
            ->leftjoin('users as u','u.id','pr.a_id')
            ->select('pr.id','pr.enquiry_no','pr.project_name','pr.client_ph_no','pr.client_name','pr.enq_date','pr.project_type','pr.client_requirement','pr.pr_address','pr.client_document','pr.pr_head_conceptual','pr.team_member_conceptual','pr.site_supervisor','pr.enq_status','pr.a_id','pr.updated_at','pr.delete','pr.enq_status','u.name as ','u.delete as u_delete','u.is_active')
            ->where(['pr.delete'=>0])
            ->orderby('pr.updated_at','DESC')
            ->get();

            foreach($data as $d){
               
                // get name pr head conceptual
                $u_obj1=UserModel::where(['delete'=>0,'role'=>1,'id'=>$d->pr_head_conceptual])->orderby('created_at','DESC')->get();
                foreach($u_obj1 as $u){
                    $d->pr_head_con_name = $u->name;
                }

                //get name team member conceptual
                $tm_id = array_map('intval', explode(',', $d->team_member_conceptual));         // create comma seaprated records
                $tm_obj=UserModel::whereIn('id',$tm_id)->where(['delete'=>0,'role'=>2])->orderby('created_at','DESC')->get();
                $d->tm_obj = $tm_obj;       // store tm_obj

                //get name team member conceptual
                $ss_id = array_map('intval', explode(',', $d->site_supervisor));         // create comma seaprated records
                $ss_obj=UserModel::whereIn('id',$ss_id)->where(['delete'=>0,'role'=>3])->orderby('created_at','DESC')->get();
            
                $d->ss_obj = $ss_obj;
            }


        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'prhead_obj' => $prhead_obj,'employee_obj' => $employee_obj,'ssupervisor_obj' => $ssupervisor_obj,'roles' => $roles ,'message' => 'Data Found'));
        }else{
        return ['status' => false, 'message' => 'No Data Found'];
        }

    }

    public function postEnq(Request $req)
    {
    	$edit_id=empty($req->get('edit_id')) ? null : $req->get('edit_id');
        // dd($req);

        $project_name = $req->get('project_name');
   		$client_name = $req->get('client_name');
   		$client_ph_no = $req->get('cp_ph_no');
        $enq_date = $req->get('enq_date');
        $project_type = $req->get('project_type');
        $client_requirement = $req->get('client_req');
   		$pr_address = $req->get('project_address');
        $client_document = $req->get('client_document');
        $pr_head_conceptual = $req->get('pr_head_conceptual');                  // Project Head Conceptual
        $team_member_conceptual = $req->get('team_member_conceptual');          // Team Member Conceptual
        $team_member_conceptual=implode(',',$team_member_conceptual);           // Team Member Conceptual store comma separated
        $supervisor = $req->get('supervisor');                                  // Supervisor Conceptual
        $site_supervisor=implode(',',$supervisor);                              // Supervisor Conceptual store comma separated
        $enq_status = $req->get('enq_status');

    	$a_id=Session::get('USER_ID');

        if($edit_id!=null)
    	{
            if($enq_date !='' && $client_name !='' && $project_name !='' && $project_type !='' && $enq_status !='' && $client_ph_no !='') 
            {
                

                $u_obj=ProjectModel::find($edit_id);
                $u_obj->project_name=$project_name;
                $u_obj->client_name=$client_name;
                $u_obj->client_ph_no=$client_ph_no;
                $u_obj->enq_date=$enq_date;
                $u_obj->project_type=$project_type;
                $u_obj->client_requirement=$client_requirement;
                $u_obj->pr_address=$pr_address;
                $u_obj->client_document=$client_document;
                $u_obj->pr_head_conceptual=$pr_head_conceptual;
                $u_obj->team_member_conceptual=$team_member_conceptual;
                $u_obj->site_supervisor=$site_supervisor;
                $u_obj->enq_status=$enq_status;

                if($enq_status == "Converted"){
                    $u_obj->converted_no = CommonController::custConvNumber($project_type);
                    $u_obj->converted_status = "In Process";
                }
                $u_obj->a_id=$a_id;
                $res=$u_obj->update();
                
                if($res){
                    return ['status' => true,'message' => 'Enquiry Update Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }
            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   

        }else{    

            if($enq_date !='' && $client_name !='' && $project_name !='' && $project_type !='' && $enq_status !='' && $client_ph_no !='') 
            {
                $u_obj=new ProjectModel();
                $u_obj->enquiry_no = CommonController::custEnqNumber($project_type);
                $u_obj->project_name=$project_name;
                $u_obj->client_name=$client_name;
                $u_obj->client_ph_no=$client_ph_no;
                $u_obj->enq_date=$enq_date;
                $u_obj->project_type=$project_type;
                $u_obj->client_requirement=$client_requirement;
                $u_obj->pr_address=$pr_address;
                $u_obj->client_document=$client_document;
                $u_obj->pr_head_conceptual=$pr_head_conceptual;
                $u_obj->team_member_conceptual=$team_member_conceptual;
                $u_obj->site_supervisor=$site_supervisor;
                $u_obj->enq_status=$enq_status;
                if($enq_status == "Converted"){
                    $u_obj->converted_no = CommonController::custConvNumber($project_type);
                }
                $u_obj->delete=0;
                $u_obj->a_id=$a_id;
                $res=$u_obj->save();

                if($res){
                    return ['status' => true,'message' => 'Enquiry Add Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }
            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   
        }
		return redirect()->back();
    }

    public function deleteEnq(Request $req)
    {
        $id=$req->get('id');
        $p_obj=ProjectModel::find($id);
        $p_obj->delete=1;
        $res=$p_obj->update();

        if($res){
            return ['status' => true, 'message' => 'Enquiry Deleted Successfully'];
        }else{
           return ['status' => false, 'message' => 'Enquiry Deletion Unsuccessfull...!'];
        }
    }
}
