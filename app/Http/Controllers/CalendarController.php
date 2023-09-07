<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleModel;
use Session;
use DB;
use Hash;
use PDF;

class CalendarController extends Controller
{
    public function createSchedule(Request $req)
    {
    	$edit_id=empty($req->get('edit_id')) ? null : $req->get('edit_id');
        $title = $req->get('title');
   		$start = $req->get('start');
   		$end = $req->get('end');
       
    	$a_id=Session::get('USER_ID');

        if($edit_id!=null)
    	{
            if($title !='' && $start !='' && $end !='') 
            {
                
                $u_obj=ScheduleModel::find($edit_id);
                $u_obj->title=$title;
                $u_obj->start=$start;
                $u_obj->end=$end;
                $u_obj->a_id=$a_id;
                $res=$u_obj->update();
                
                if($res){
                    return ['status' => true,'message' => 'Schedule Update Successfully'];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }
            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   

        }else{    

            if($title !='' && $start !='' && $end !='') 
            {
                $u_obj=new ScheduleModel();
                $u_obj->title=$title;
                $u_obj->start=$start;
                $u_obj->end=$end;
                $u_obj->delete=0;
                $u_obj->a_id=$a_id;
                $res=$u_obj->save();
                $ids=$u_obj->id;


                if($res){
                    return ['status' => true,'message' => 'Schedule Add Successfully', 'ids'=>$ids, 'title'=>$title, 'start'=>$start,'end'=>$end];
                }else{
                   return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
                }
            }else{
                return ['status' => false, 'message' => 'Please Try Again..']; 
            }   
        }
		return redirect()->back();
    }

    public function getSchedules()
    {
        //for all project Head
        $data=ScheduleModel::select('id','title','start','end','delete')->where(['delete'=>0])->get();

        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'message' => 'Data Found'));
        }else{
            return ['status' => false, 'message' => 'No Data Found'];
        }
    	
    }
}
