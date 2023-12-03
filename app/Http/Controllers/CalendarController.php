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
    	$edit_id=empty($req->get('id')) ? null : $req->get('id');
        $title = $req->get('title');
   		$startDate = $req->get('startDate');
   		$endDate = $req->get('endDate');
   		$calendarId = $req->get('calendarId');
        $location = $req->get('location');
       
    	$a_id=Session::get('USER_ID');

        if($edit_id!=null)
    	{

            $u_obj=ScheduleModel::find($edit_id);
            if($title != null){
                $u_obj->title=$title;
            }

            if($startDate != null){
                $u_obj->start=$startDate;
            }

            if($endDate != null){
                $u_obj->end=$endDate;
            }
            
            if($calendarId != null){
                $u_obj->cal_id=$calendarId;
            }

            if($location != null){
                $u_obj->location=$location;
            }
            
            $u_obj->a_id=$a_id;
            $res=$u_obj->update();
            
            if($res){
                return ['status' => true,'message' => 'Schedule Update Successfully'];
            }else{
                return ['status' => false, 'message' => 'Something went wrong. Please try again.'];
            }
           

        }else{    

            if($title != '' && $startDate != '' && $endDate != '' && $calendarId != '') 
            {
                $u_obj=new ScheduleModel();
                $u_obj->title=$title;
                $u_obj->start=$startDate;
                $u_obj->end=$endDate;
                $u_obj->cal_id=$calendarId;
                if($location != ""){
                    $u_obj->location=$location;
                }
                $u_obj->delete=0;
                $u_obj->a_id=$a_id;
                $res=$u_obj->save();
                $ids=$u_obj->id;


                if($res){
                    return ['status' => true,'message' => 'Schedule Add Successfully', 'ids'=>$ids, 'title'=>$title, 'start'=>$startDate,'end'=>$endDate,'location'=>$location];
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
        $data=ScheduleModel::select('id','title','start','end','cal_id','delete','location')->where(['delete'=>0])->get();

        if(!empty($data)){
            return json_encode(array('status' => true ,'data' => $data,'message' => 'Data Found'));
        }else{
            return ['status' => false, 'message' => 'No Data Found'];
        }
    	
    }

    public function deleteSchedule(Request $req)
    {
        $id=$req->get('id');
        $p_obj=ScheduleModel::find($id);
        $p_obj->delete=1;
        $res=$p_obj->update();

        if($res){
            return ['status' => true, 'message' => 'Schedule Deleted Successfully'];
        }else{
           return ['status' => false, 'message' => 'Schedule Deletion Unsuccessfull...!'];
        }
    }
}
