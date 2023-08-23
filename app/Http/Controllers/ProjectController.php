<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\ProjectTypeModel;
use App\Models\ProjectStatusModel;
use Session;
use DB;
use Hash;

class ProjectController extends Controller
{
    public function projectStatusList()
    {
 
    	$u_obj=UserModel::where(['delete'=>0,'role'=>3,'is_active'=>0])->orderby('created_at','DESC')->get();
        // dd($u_obj);
    	// return view('users.users_list',compact('u_obj'));
    
    	return view('project.projectStatus',compact('u_obj'));

    }

    public function postProjectStatus(Request $req)
    {
    	$edit_id=empty($req->get('edit_id')) ? null : $req->get('edit_id');
        $status_name = $req->get('status_name');
        $color = $req->get('color');

    	$a_id=Session::get('USER_ID');

        if($edit_id!=null)
    	{
            if ($status_name !='' && $edit_id !='') 
            {
                $u_obj=ProjectStatusModel::find($edit_id);
                $u_obj->status_name=$status_name;
                $u_obj->color=$color;
                $u_obj->a_id=$a_id;
                $res=$u_obj->update();
                
                if($res){
                    return ['status' => true,'message' => 'Project Status Update Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }
            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   
        }else{    

            if ($status_name !='') 
            {
                $u_obj=new ProjectStatusModel();
                $u_obj->status_name=$status_name;
                $u_obj->color=$color;
                $u_obj->delete=0;
                $u_obj->a_id=$a_id;
                $res=$u_obj->save();
                
                if($res){
                    return ['status' => true, 'id'=>$u_obj->id,'message' => 'Project Status Add Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }

            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   
        }
        return ['status' => false, 'message' => 'Please Try Again..']; 
    }

    public function DeleteProjectStatus(Request $req)
    {
        $id=$req->get('id');
        $u_obj=ProjectStatusModel::find($id);
        $u_obj->delete=1;
        $res=$u_obj->update();

        if($res){
            return ['status' => true, 'message' => 'Project Status Deleted Successfully'];
        }else{
           return ['status' => false, 'message' => 'Project Status Deletion Unsuccessfull...!'];
        }
    }

    public function getProjectStatus(Request $req)
    {
        $roles=Session::get('ROLES');
        $a_id=Session::get('USER_ID');
        $data = ProjectStatusModel::where(['delete'=>0])->orderby('updated_at','DESC')->get();

        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'roles' => $roles ,'message' => 'Data Found'));
         }else{
            return ['status' => false, 'message' => 'No Data Found'];
         }

    }

    public function projectTypeList()
    {
 
    	$u_obj=UserModel::where(['delete'=>0,'role'=>3,'is_active'=>0])->orderby('created_at','DESC')->get();

    	return view('project.projectType',compact('u_obj'));

    }

    public function postProjectType(Request $req)
    {
    	$edit_id=empty($req->get('edit_id')) ? null : $req->get('edit_id');
        $type_name = $req->get('type_name');
        $color = $req->get('color');

    	$a_id=Session::get('USER_ID');

        if($edit_id!=null)
    	{
            if ($type_name !='' && $edit_id !='') 
            {
                $u_obj=ProjectTypeModel::find($edit_id);
                $u_obj->type_name=$type_name;
                $u_obj->color=$color;
                $u_obj->a_id=$a_id;
                $res=$u_obj->update();
                
                if($res){
                    return ['status' => true,'message' => 'Project Type Update Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }
            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   
        }else{    

            if ($type_name !='') 
            {
                $u_obj=new ProjectTypeModel();
                $u_obj->type_name=$type_name;
                $u_obj->color=$color;
                $u_obj->delete=0;
                $u_obj->a_id=$a_id;
                $res=$u_obj->save();
                
                if($res){
                    return ['status' => true, 'id'=>$u_obj->id,'message' => 'Project Type Add Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }

            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   
        }
        return ['status' => false, 'message' => 'Please Try Again..']; 
    }

    public function DeleteProjectType(Request $req)
    {
        $id=$req->get('id');
        $u_obj=ProjectTypeModel::find($id);
        $u_obj->delete=1;
        $res=$u_obj->update();

        if($res){
            return ['status' => true, 'message' => 'Project Type Deleted Successfully'];
        }else{
           return ['status' => false, 'message' => 'Project Type Deletion Unsuccessfull...!'];
        }
    }

    public function getProjectType(Request $req)
    {
        $roles=Session::get('ROLES');
        $a_id=Session::get('USER_ID');
        $data = ProjectTypeModel::where(['delete'=>0])->orderby('updated_at','DESC')->get();

        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'roles' => $roles ,'message' => 'Data Found'));
         }else{
            return ['status' => false, 'message' => 'No Data Found'];
         }

    }
}
