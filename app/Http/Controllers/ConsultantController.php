<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\ConsultantModel;
use Session;
use DB;
use Hash;

class ConsultantController extends Controller
{
    public function ConsultantList()
    {
 
    	$u_obj=UserModel::where(['delete'=>0,'role'=>3,'is_active'=>0])->orderby('created_at','DESC')->get();

    	return view('consultant.consultant',compact('u_obj'));

    }

    public function postConsultant(Request $req)
    {
    	$edit_id=empty($req->get('edit_id')) ? null : $req->get('edit_id');
        $consultant_name = $req->get('consultant_name');
        $color = $req->get('color');

    	$a_id=Session::get('USER_ID');

        if($edit_id!=null)
    	{
            if ($consultant_name !='' && $edit_id !='') 
            {
                $u_obj=ConsultantModel::find($edit_id);
                $u_obj->consultant_name=$consultant_name;
                $u_obj->color=$color;
                $u_obj->a_id=$a_id;
                $res=$u_obj->update();
                
                if($res){
                    return ['status' => true,'message' => 'Consultant Update Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }
            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   
        }else{    

            if ($consultant_name !='') 
            {
                $u_obj=new ConsultantModel();
                $u_obj->consultant_name=$consultant_name;
                $u_obj->color=$color;
                $u_obj->delete=0;
                $u_obj->a_id=$a_id;
                $res=$u_obj->save();
                
                if($res){
                    return ['status' => true, 'id'=>$u_obj->id,'message' => 'Consultant Add Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }

            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   
        }
        return ['status' => false, 'message' => 'Please Try Again..']; 
    }

    public function DeleteConsultant(Request $req)
    {
        $id=$req->get('id');
        $u_obj=ConsultantModel::find($id);
        $u_obj->delete=1;
        $res=$u_obj->update();

        if($res){
            return ['status' => true, 'message' => 'Consultant Deleted Successfully'];
        }else{
           return ['status' => false, 'message' => 'Consultant Deletion Unsuccessfull...!'];
        }
    }

    public function getConsultant(Request $req)
    {
        $roles=Session::get('ROLES');
        $a_id=Session::get('USER_ID');
        $data = ConsultantModel::where(['delete'=>0])->orderby('updated_at','DESC')->get();

        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'roles' => $roles ,'message' => 'Data Found'));
         }else{
            return ['status' => false, 'message' => 'No Data Found'];
         }

    }
}
