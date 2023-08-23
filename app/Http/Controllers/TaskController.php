<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CommonController as Common;
use App\Models\AutoValuesModel;
use App\Models\ConveretedAutoValuesModel;
use App\Models\UserModel;
use App\Models\ProjectTypeModel;
use App\Models\ProjectModel;
use App\Models\EnquiryTaskModel;
use App\Models\ConvertedTaskModel;
use Session;
use DB;
use Hash;

class TaskController extends Controller
{
    public function enqTasks()
    {
 
    	$u_obj=UserModel::where(['delete'=>0,'role'=>3,'is_active'=>0])->orderby('created_at','DESC')->get();
        // dd($u_obj);
    	// return view('users.users_list',compact('u_obj'));
    
    	return view('task.enqTasks',compact('u_obj'));

    }

    public function getEnqProject(Request $req)
    {
        $roles=Session::get('ROLES');
        $a_id=Session::get('USER_ID');
        $project_type = $req->get('project_type');
        //for all user
        $u_obj=UserModel::where(['delete'=>0,'role'=>1,'is_active'=>0])->orderby('created_at','DESC')->get();

        //get peoject records
        $data=DB::table('projects as pr')
            ->leftjoin('users as u','u.id','pr.a_id')
            ->select('pr.id','pr.enquiry_no','pr.project_name','pr.client_ph_no','pr.client_name','pr.enq_date','pr.project_type','pr.client_requirement','pr.pr_address','pr.client_document','pr.pr_head_conceptual','pr.team_member_conceptual','pr.site_supervisor','pr.enq_status','pr.a_id','pr.updated_at','pr.delete','pr.enq_status','u.name as name','u.delete as u_delete','u.is_active')
            ->where(['pr.delete'=>0,'pr.project_type'=>$project_type])
            ->where('enq_status','!=',"Converted")
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
                $tm_obj=UserModel::whereIn('id',$tm_id)->where(['delete'=>0,'role'=>1])->orderby('created_at','DESC')->get();
                $d->tm_obj = $tm_obj;       // store tm_obj

                //get name team member conceptual
                $ss_id = array_map('intval', explode(',', $d->site_supervisor));         // create comma seaprated records
                $ss_obj=UserModel::whereIn('id',$ss_id)->where(['delete'=>0,'role'=>1])->orderby('created_at','DESC')->get();
            
                $d->ss_obj = $ss_obj;
            }


        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'u_obj' => $u_obj,'roles' => $roles ,'message' => 'Data Found'));
        }else{
        return ['status' => false, 'message' => 'No Data Found'];
        }

    }

    public function getTeamMember(Request $req)
    {
        $roles=Session::get('ROLES');
        $a_id=Session::get('USER_ID');
        $task_project = $req->get('task_project');
        //for all user
        $u_obj=UserModel::where(['delete'=>0,'role'=>1,'is_active'=>0])->orderby('created_at','DESC')->get();

        //get peoject records
        $data=DB::table('projects as pr')
            ->leftjoin('users as u','u.id','pr.a_id')
            ->select('pr.id','pr.enquiry_no','pr.project_name','pr.client_ph_no','pr.client_name','pr.enq_date','pr.project_type','pr.client_requirement','pr.pr_address','pr.client_document','pr.pr_head_conceptual','pr.team_member_conceptual','pr.site_supervisor','pr.enq_status','pr.a_id','pr.updated_at','pr.delete','pr.enq_status','u.name as name','u.delete as u_delete','u.is_active')
            ->where(['pr.delete'=>0,'pr.id'=>$task_project])
            ->orderby('pr.updated_at','DESC')
            ->get();

            $u_id = [];
            foreach($data as $d)
            {
               
                // get name pr head conceptual
                $u_obj1=UserModel::where(['delete'=>0,'role'=>1,'id'=>$d->pr_head_conceptual])->orderby('created_at','DESC')->get();
                foreach($u_obj1 as $u){
                    array_push($u_id, $u);          // Push user id for task
                }

                //get name team member conceptual
                $tm_id = array_map('intval', explode(',', $d->team_member_conceptual));         // create comma seaprated records
                $tm_obj=UserModel::whereIn('id',$tm_id)->where(['delete'=>0,'role'=>2])->orderby('created_at','DESC')->get();
                foreach($tm_obj as $t){
                    array_push($u_id, $t);          // Push user id for task
                }
            
                //get name team member conceptual
                $ss_id = array_map('intval', explode(',', $d->site_supervisor));         // create comma seaprated records
                $ss_obj=UserModel::whereIn('id',$ss_id)->where(['delete'=>0,'role'=>3])->orderby('created_at','DESC')->get();
                foreach($ss_obj as $s){
                    array_push($u_id, $s);          // Push user id for task
                }
              
            }

           


        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'u_id' => $u_id,'roles' => $roles ,'message' => 'Data Found'));
        }else{
        return ['status' => false, 'message' => 'No Data Found'];
        }

    }

    public function postTask(Request $req)
    {
    	$edit_id=empty($req->get('edit_id')) ? null : $req->get('edit_id');
        // dd($req);

        $project_type = $req->get('project_type');
   		$task_project = $req->get('task_project');
   		$team_member = $req->get('team_member');
        $task_date = $req->get('task_date');
        $end_date = $req->get('end_date');
        $task_remark = $req->get('task_remark');
        $emp_remark = $req->get('emp_remark');
   		$task_status = $req->get('task_status');

    	$a_id=Session::get('USER_ID');

        if($edit_id!=null)
    	{
            if($task_date !='' && $task_remark !='' && $task_status !='')  
            {
                

                $u_obj=EnquiryTaskModel::find($edit_id);
                $u_obj->task_date=$task_date;
                $u_obj->end_date=$end_date;
                $u_obj->task_remark=$task_remark;
                $u_obj->task_status=$task_status;
                if($emp_remark != ""){
                    $u_obj->employee_remark=$emp_remark;

                }
                $u_obj->a_id=$a_id;
                $res=$u_obj->update();
                
                if($res){
                    return ['status' => true,'message' => 'Task Update Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }
            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   

        }else{    

            if($project_type !='' && $task_project !='' && $team_member !='' && $task_date !='' && $task_remark !='' && $task_status !='') 
            {
                $u_obj=new EnquiryTaskModel();
              
                $u_obj->project_type=$project_type;
                $u_obj->enq_pr_id=$task_project;
                $u_obj->team_member=$team_member;
                $u_obj->task_date=$task_date;
                $u_obj->end_date=$end_date;
                $u_obj->task_remark=$task_remark;
                $u_obj->task_status=$task_status;
                $u_obj->assign_id=$a_id;
                $u_obj->delete=0;
                $u_obj->a_id=$a_id;
                $res=$u_obj->save();

                if($res){
                    return ['status' => true,'message' => 'Task Add Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }
            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   
        }
		return redirect()->back();
    }

    public function getTasks(Request $req)
    {
        $roles=Session::get('ROLES');
        $a_id=Session::get('USER_ID');
       
        //for all user
        $u_obj=UserModel::where(['delete'=>0,'is_active'=>0])->where('role','!=','0')->orderby('created_at','DESC')->get();

        if($roles == 0){
            //get peoject records
            $data=DB::table('enquiry_tasks as et')
            ->leftjoin('users as u','u.id','et.team_member')
            ->leftjoin('projects as pr','pr.id','et.enq_pr_id')
            ->select('et.id','pr.enquiry_no','pr.project_name','pr.client_ph_no','pr.client_name','pr.enq_date','pr.project_type','pr.client_requirement','pr.pr_address','pr.client_document','pr.enq_status','pr.a_id','pr.updated_at','pr.delete','pr.team_member_conceptual','et.task_status','et.enq_pr_id','et.task_date','et.assign_id','et.end_date','et.task_remark','et.employee_remark','et.team_member','et.a_id as et_aid','et.delete as et_delete','u.id as uid','u.name as name','u.delete as u_delete','u.is_active')
            ->where(['pr.delete'=>0,'et.delete'=>0])
            ->orderby('pr.updated_at','DESC')
            ->get();

            foreach($data as $d){
            
                // get task assign name
                $u_obj1=UserModel::where(['delete'=>0,'id'=>$d->et_aid])->orderby('created_at','DESC')->get();
                foreach($u_obj1 as $u){
                    $d->assign_name = $u->name;
                }

            }
        }else if($roles == 1){

            $data = [];
            //get peoject records
            $data1=DB::table('enquiry_tasks as et')
            ->leftjoin('users as u','u.id','et.team_member')
            ->leftjoin('projects as pr','pr.id','et.enq_pr_id')
            ->select('et.id','pr.enquiry_no','pr.project_name','pr.client_ph_no','pr.client_name','pr.enq_date','pr.project_type','pr.client_requirement','pr.pr_address','pr.client_document','pr.enq_status','pr.a_id','pr.updated_at','pr.delete','pr.team_member_conceptual','et.task_status','et.enq_pr_id','et.task_date','et.assign_id','et.end_date','et.task_remark','et.employee_remark','et.team_member','et.a_id as et_aid','et.delete as et_delete','u.id as uid','u.name as name','u.delete as u_delete','u.is_active')
            ->where(['pr.delete'=>0,'et.delete'=>0,'et.team_member'=>$a_id])
            ->orderby('pr.updated_at','DESC')
            ->get();

            foreach($data1 as $d1){
                // get task assign name
                $u_obj1=UserModel::where(['delete'=>0,'id'=>$d1->assign_id])->orderby('created_at','DESC')->get();
                foreach($u_obj1 as $u){
                    $d1->assign_name = $u->name;
                }
            }

            foreach($data1 as $d1){
                array_push($data, $d1);          // Push user id for task
            }

            $data2=DB::table('enquiry_tasks as et')
            ->leftjoin('users as u','u.id','et.team_member')
            ->leftjoin('projects as pr','pr.id','et.enq_pr_id')
            ->select('et.id','pr.enquiry_no','pr.project_name','pr.client_ph_no','pr.client_name','pr.enq_date','pr.project_type','pr.client_requirement','pr.pr_address','pr.client_document','pr.enq_status','pr.a_id','pr.updated_at','pr.delete','pr.team_member_conceptual','et.task_status','et.enq_pr_id','et.task_date','et.assign_id','et.end_date','et.task_remark','et.employee_remark','et.team_member','et.a_id as et_aid','et.delete as et_delete','u.id as uid','u.name as name','u.delete as u_delete','u.is_active')
            ->where(['pr.delete'=>0,'et.delete'=>0,'et.assign_id'=>$a_id])
            ->orderby('pr.updated_at','DESC')
            ->get();

            foreach($data2 as $d2){
                // get task assign name
                $u_obj1=UserModel::where(['delete'=>0,'id'=>$d2->assign_id])->orderby('created_at','DESC')->get();
                foreach($u_obj1 as $u){
                    $d2->assign_name = $u->name;
                }
            }

            foreach($data2 as $d2){
                array_push($data, $d2);          // Push user id for task
            }

        }else{

            //get peoject records
            $data=DB::table('enquiry_tasks as et')
            ->leftjoin('users as u','u.id','et.team_member')
            ->leftjoin('projects as pr','pr.id','et.enq_pr_id')
            ->select('et.id','pr.enquiry_no','pr.project_name','pr.client_ph_no','pr.client_name','pr.enq_date','pr.project_type','pr.client_requirement','pr.pr_address','pr.client_document','pr.enq_status','pr.a_id','pr.updated_at','pr.delete','pr.team_member_conceptual','et.task_status','et.enq_pr_id','et.task_date','et.assign_id','et.end_date','et.task_remark','et.employee_remark','et.team_member','et.a_id as et_aid','et.delete as et_delete','u.id as uid','u.name as name','u.delete as u_delete','u.is_active')
            ->where(['pr.delete'=>0,'et.delete'=>0,'et.team_member'=>$a_id])
            ->orderby('pr.updated_at','DESC')
            ->get();

            foreach($data as $d){
            
                // get task assign name
                $u_obj1=UserModel::where(['delete'=>0,'id'=>$d->assign_id])->orderby('created_at','DESC')->get();
                foreach($u_obj1 as $u){
                    $d->assign_name = $u->name;
                }

            }

        }
       

        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'u_obj' => $u_obj,'roles' => $roles,'au_id' => $a_id,'message' => 'Data Found'));
        }else{
        return ['status' => false, 'message' => 'No Data Found'];
        }

    }

    public function deleteTask(Request $req)
    {
        $id=$req->get('id');
        $p_obj=EnquiryTaskModel::find($id);
        $p_obj->delete=1;
        $res=$p_obj->update();

        if($res){
            return ['status' => true, 'message' => 'Task Deleted Successfully'];
        }else{
           return ['status' => false, 'message' => 'Task Deletion Unsuccessfull...!'];
        }
    }

    public function convTasks()
    {
 
    	// $u_obj=UserModel::where(['delete'=>0,'role'=>3,'is_active'=>0])->orderby('created_at','DESC')->get();
        // dd($u_obj);
    	// return view('users.users_list',compact('u_obj'));
    
    	return view('task.convTasks');

    }

    public function getConvProject(Request $req)
    {
        $roles=Session::get('ROLES');
        $a_id=Session::get('USER_ID');
        $project_type = $req->get('project_type');
        //for all user
        $u_obj=UserModel::where(['delete'=>0,'role'=>1,'is_active'=>0])->orderby('created_at','DESC')->get();

        //get peoject records
        $data=DB::table('projects as pr')
            ->leftjoin('users as u','u.id','pr.a_id')
            ->select('pr.id','pr.enquiry_no','pr.project_name','pr.client_ph_no','pr.client_name','pr.enq_date','pr.project_type','pr.client_requirement','pr.pr_address','pr.client_document','pr.pr_head_conceptual','pr.team_member_conceptual','pr.site_supervisor','pr.enq_status','pr.a_id','pr.updated_at','pr.delete','pr.enq_status','u.name as name','u.delete as u_delete','u.is_active')
            ->where(['pr.delete'=>0,'pr.project_type'=>$project_type])
            ->where('enq_status','=',"Converted")
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
                $tm_obj=UserModel::whereIn('id',$tm_id)->where(['delete'=>0,'role'=>1])->orderby('created_at','DESC')->get();
                $d->tm_obj = $tm_obj;       // store tm_obj

                //get name team member conceptual
                $ss_id = array_map('intval', explode(',', $d->site_supervisor));         // create comma seaprated records
                $ss_obj=UserModel::whereIn('id',$ss_id)->where(['delete'=>0,'role'=>1])->orderby('created_at','DESC')->get();
            
                $d->ss_obj = $ss_obj;
            }


        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'u_obj' => $u_obj,'roles' => $roles ,'message' => 'Data Found'));
        }else{
        return ['status' => false, 'message' => 'No Data Found'];
        }

    }

    public function getConvTeamMember(Request $req)
    {
        $roles=Session::get('ROLES');
        $a_id=Session::get('USER_ID');
        $task_project = $req->get('task_project');
        //for all user
        $u_obj=UserModel::where(['delete'=>0,'role'=>1,'is_active'=>0])->orderby('created_at','DESC')->get();

        //get peoject records
        $data=DB::table('projects as pr')
            ->leftjoin('users as u','u.id','pr.a_id')
            ->select('pr.id','pr.enquiry_no','pr.project_name','pr.client_ph_no','pr.client_name','pr.enq_date','pr.project_type','pr.client_requirement','pr.pr_address','pr.client_document','pr.pr_head_conceptual','pr.team_member_conceptual','pr.pr_head_working','pr.team_member_working','pr.site_supervisor','pr.enq_status','pr.a_id','pr.updated_at','pr.delete','pr.enq_status','u.name as name','u.delete as u_delete','u.is_active')
            ->where(['pr.delete'=>0,'pr.id'=>$task_project])
            ->orderby('pr.updated_at','DESC')
            ->get();

            $u_id = [];
            foreach($data as $d)
            {
               
                // get name pr head conceptual
                $u_obj1=UserModel::where(['delete'=>0,'role'=>1,'id'=>$d->pr_head_conceptual])->orderby('created_at','DESC')->get();
                foreach($u_obj1 as $u){
                    array_push($u_id, $u);          // Push user id for task
                }

                // get name pr head working
                $u_obj2=UserModel::where(['delete'=>0,'role'=>1,'id'=>$d->pr_head_working])->orderby('created_at','DESC')->get();
                foreach($u_obj2 as $u2){
                    array_push($u_id, $u2);          // Push user id for task
                }

                //get name team member conceptual
                $tm_id = array_map('intval', explode(',', $d->team_member_conceptual));         // create comma seaprated records
                $tm_obj=UserModel::whereIn('id',$tm_id)->where(['delete'=>0,'role'=>2])->orderby('created_at','DESC')->get();
                foreach($tm_obj as $t){
                    array_push($u_id, $t);          // Push user id for task
                }

                //get name team member working
                $tm_id1 = array_map('intval', explode(',', $d->team_member_working));         // create comma seaprated records
                $tm_obj1=UserModel::whereIn('id',$tm_id1)->where(['delete'=>0,'role'=>2])->orderby('created_at','DESC')->get();
                foreach($tm_obj1 as $t1){
                    array_push($u_id, $t1);          // Push user id for task
                }
            
                //get name supervisor conceptual
                $ss_id = array_map('intval', explode(',', $d->site_supervisor));         // create comma seaprated records
                $ss_obj=UserModel::whereIn('id',$ss_id)->where(['delete'=>0,'role'=>3])->orderby('created_at','DESC')->get();
                foreach($ss_obj as $s){
                    array_push($u_id, $s);          // Push user id for task
                }
              
            }

           


        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'u_id' => $u_id,'roles' => $roles ,'message' => 'Data Found'));
        }else{
        return ['status' => false, 'message' => 'No Data Found'];
        }

    }

    public function postConvTask(Request $req)
    {
    	$edit_id=empty($req->get('edit_id')) ? null : $req->get('edit_id');
        // dd($req);

        $project_type = $req->get('project_type');
   		$task_project = $req->get('task_project');
   		$team_member = $req->get('team_member');
        $task_date = $req->get('task_date');
        $end_date = $req->get('end_date');
        $task_remark = $req->get('task_remark');
        $emp_remark = $req->get('emp_remark');
   		$task_status = $req->get('task_status');

    	$a_id=Session::get('USER_ID');

        if($edit_id!=null)
    	{
            if($task_date !='' && $task_remark !='' && $task_status !='')  
            {
                

                $u_obj=ConvertedTaskModel::find($edit_id);
                $u_obj->task_date=$task_date;
                $u_obj->end_date=$end_date;
                $u_obj->task_remark=$task_remark;
                $u_obj->task_status=$task_status;
                if($emp_remark != ""){
                    $u_obj->employee_remark=$emp_remark;

                }
                $u_obj->a_id=$a_id;
                $res=$u_obj->update();
                
                if($res){
                    return ['status' => true,'message' => 'Task Update Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }
            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   

        }else{    

            if($project_type !='' && $task_project !='' && $team_member !='' && $task_date !='' && $task_remark !='' && $task_status !='') 
            {
                $u_obj=new ConvertedTaskModel();
              
                $u_obj->project_type=$project_type;
                $u_obj->conv_pr_id=$task_project;
                $u_obj->team_member=$team_member;
                $u_obj->task_date=$task_date;
                $u_obj->end_date=$end_date;
                $u_obj->task_remark=$task_remark;
                $u_obj->task_status=$task_status;
                $u_obj->assign_id=$a_id;
                $u_obj->delete=0;
                $u_obj->a_id=$a_id;
                $res=$u_obj->save();

                if($res){
                    return ['status' => true,'message' => 'Task Add Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }
            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   
        }
		return redirect()->back();
    }

    public function getConvTasks(Request $req)
    {
        $roles=Session::get('ROLES');
        $a_id=Session::get('USER_ID');
       
        //for all user
        $u_obj=UserModel::where(['delete'=>0,'is_active'=>0])->where('role','!=','0')->orderby('created_at','DESC')->get();

        if($roles == 0){
            //get peoject records
            $data=DB::table('converted_tasks as et')
            ->leftjoin('users as u','u.id','et.team_member')
            ->leftjoin('projects as pr','pr.id','et.conv_pr_id')
            ->select('et.id','pr.enquiry_no','pr.project_name','pr.client_ph_no','pr.client_name','pr.enq_date','pr.project_type','pr.client_requirement','pr.pr_address','pr.client_document','pr.enq_status','pr.a_id','pr.updated_at','pr.delete','pr.team_member_conceptual','et.task_status','et.conv_pr_id','et.task_date','et.assign_id','et.end_date','et.task_remark','et.employee_remark','et.team_member','et.a_id as et_aid','et.delete as et_delete','u.id as uid','u.name as name','u.delete as u_delete','u.is_active')
            ->where(['pr.delete'=>0,'et.delete'=>0])
            ->orderby('pr.updated_at','DESC')
            ->get();

            foreach($data as $d){
            
                // get task assign name
                $u_obj1=UserModel::where(['delete'=>0,'id'=>$d->assign_id])->orderby('created_at','DESC')->get();
                foreach($u_obj1 as $u){
                    $d->assign_name = $u->name;
                }

            }
        }else if($roles == 1){


            $data = [];
            //get peoject records
            $data1=DB::table('converted_tasks as et')
            ->leftjoin('users as u','u.id','et.team_member')
            ->leftjoin('projects as pr','pr.id','et.conv_pr_id')
            ->select('et.id','pr.enquiry_no','pr.project_name','pr.client_ph_no','pr.client_name','pr.enq_date','pr.project_type','pr.client_requirement','pr.pr_address','pr.client_document','pr.enq_status','pr.a_id','pr.updated_at','pr.delete','pr.team_member_conceptual','et.task_status','et.conv_pr_id','et.task_date','et.assign_id','et.end_date','et.task_remark','et.employee_remark','et.team_member','et.a_id as et_aid','et.delete as et_delete','u.id as uid','u.name as name','u.delete as u_delete','u.is_active')
            ->where(['pr.delete'=>0,'et.delete'=>0,'et.team_member'=>$a_id])
            ->orderby('pr.updated_at','DESC')
            ->get();

            foreach($data1 as $d1){
            
                // get task assign name
                $u_obj1=UserModel::where(['delete'=>0,'id'=>$d1->assign_id])->orderby('created_at','DESC')->get();
                foreach($u_obj1 as $u){
                    $d1->assign_name = $u->name;
                }

            }

            foreach($data1 as $d1){
                array_push($data, $d1);          // Push user id for task
            }

            $data2 =DB::table('converted_tasks as et')
            ->leftjoin('users as u','u.id','et.team_member')
            ->leftjoin('projects as pr','pr.id','et.conv_pr_id')
            ->select('et.id','pr.enquiry_no','pr.project_name','pr.client_ph_no','pr.client_name','pr.enq_date','pr.project_type','pr.client_requirement','pr.pr_address','pr.client_document','pr.enq_status','pr.a_id','pr.updated_at','pr.delete','pr.team_member_conceptual','et.task_status','et.conv_pr_id','et.task_date','et.assign_id','et.end_date','et.task_remark','et.employee_remark','et.team_member','et.a_id as et_aid','et.delete as et_delete','u.id as uid','u.name as name','u.delete as u_delete','u.is_active')
            ->where(['pr.delete'=>0,'et.delete'=>0,'et.assign_id'=>$a_id])
            ->orderby('pr.updated_at','DESC')
            ->get();

            foreach($data2 as $d2){
            
                // get task assign name
                $u_obj1=UserModel::where(['delete'=>0,'id'=>$d2->assign_id])->orderby('created_at','DESC')->get();
                foreach($u_obj1 as $u){
                    $d2->assign_name = $u->name;
                }

            }

            foreach($data2 as $d2){
                array_push($data, $d2);          // Push user id for task
            }

        }else{

            //get peoject records
            $data=DB::table('converted_tasks as et')
            ->leftjoin('users as u','u.id','et.team_member')
            ->leftjoin('projects as pr','pr.id','et.conv_pr_id')
            ->select('et.id','pr.enquiry_no','pr.project_name','pr.client_ph_no','pr.client_name','pr.enq_date','pr.project_type','pr.client_requirement','pr.pr_address','pr.client_document','pr.enq_status','pr.a_id','pr.updated_at','pr.delete','pr.team_member_conceptual','et.task_status','et.conv_pr_id','et.task_date','et.assign_id','et.end_date','et.task_remark','et.employee_remark','et.team_member','et.a_id as et_aid','et.delete as et_delete','u.id as uid','u.name as name','u.delete as u_delete','u.is_active')
            ->where(['pr.delete'=>0,'et.delete'=>0,'et.team_member'=>$a_id])
            ->orderby('pr.updated_at','DESC')
            ->get();

            foreach($data as $d){
            
                // get task assign name
                $u_obj1=UserModel::where(['delete'=>0,'id'=>$d->assign_id])->orderby('created_at','DESC')->get();
                foreach($u_obj1 as $u){
                    $d->assign_name = $u->name;
                }

            }

        }
       

        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'u_obj' => $u_obj,'roles' => $roles,'au_id' => $a_id,'message' => 'Data Found'));
        }else{
        return ['status' => false, 'message' => 'No Data Found'];
        }

    }

    public function deleteConvTask(Request $req)
    {
        $id=$req->get('id');
        $p_obj=ConvertedTaskModel::find($id);
        $p_obj->delete=1;
        $res=$p_obj->update();

        if($res){
            return ['status' => true, 'message' => 'Task Deleted Successfully'];
        }else{
           return ['status' => false, 'message' => 'Task Deletion Unsuccessfull...!'];
        }
    }
}
