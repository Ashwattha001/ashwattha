<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AutoValuesModel;
use App\Models\ConveretedAutoValuesModel;

class CommonController extends Controller
{
    static function custEnqNumber($project_type)
    {
        $enq_obj=AutoValuesModel::select('id','architecture_no','interior_no','landscape_no','sustainable_no','cur_yr','nxt_yr')->orderby('id','desc')->first();
        $enquiry_number;
        if($enq_obj){

            $day = date("d"); $month = date("m"); $year = date("y"); 

            if( ($day == '01') && ($month == '04') && ($enq_obj->nxt_yr == $year) ){
                
                // UPDATE AUTO-VALUES ON 1st APRIL.. 1st TIME
                $nxt_yr = $year+1;
                $cpoi_obj=  AutoValuesModel::find($enq_obj->id);
                if($project_type == "Architecture")
                {
                    $cpoi_obj->architecture_no=1;
                }
                elseif($project_type == "Interior")
                {
                    $cpoi_obj->interior_no=1;
                }
                elseif($project_type == "Landscape")
                {
                    $cpoi_obj->landscape_no=1;
                }
                elseif($project_type == "Sustainable")
                {
                    $cpoi_obj->sustainable_no=1;
                }
                $cpoi_obj->cur_yr=$year;
                $cpoi_obj->nxt_yr=$nxt_yr;
                $res=$cpoi_obj->update();

                $num_padded = sprintf("%03d", 1);
                //change on project type
                if($project_type == "Architecture")
                {
                    $enquiry_number = "EQ/$year-$nxt_yr/AR/$num_padded";
                }
                elseif($project_type == "Interior")
                {
                    $enquiry_number = "EQ/$year-$nxt_yr/IN/$num_padded";
                }
                elseif($project_type == "Landscape")
                {
                    $enquiry_number = "EQ/$year-$nxt_yr/LA/$num_padded";
                }
                elseif($project_type == "Sustainable")
                {
                    $enquiry_number = "EQ/$year-$nxt_yr/SA/$num_padded";
                }
                

            }else{

                // UPDATE ONLY Enquiry NO.. OTHER THAN 1st APRIL.. AND ARPIL 02 records and so on
                $cpoi_obj= AutoValuesModel::find($enq_obj->id);
                if($project_type == "Architecture")
                {
                    $cpoi_obj->architecture_no= ($enq_obj->architecture_no) + 1;
                }
                elseif($project_type == "Interior")
                {
                    $cpoi_obj->interior_no= ($enq_obj->interior_no) + 1;
                }
                elseif($project_type == "Landscape")
                {
                    $cpoi_obj->landscape_no= ($enq_obj->landscape_no) + 1;
                }
                elseif($project_type == "Sustainable")
                {
                    $cpoi_obj->sustainable_no= ($enq_obj->sustainable_no) + 1;
                }
                $res=$cpoi_obj->update();



                $nxt_yr = $year+1;
                if($project_type == "Architecture")
                {
                    $num_padded = sprintf("%03d", (($enq_obj->architecture_no) + 1));
                    $enquiry_number = "EQ/$year-$nxt_yr/AR/$num_padded";
                }
                elseif($project_type == "Interior")
                {
                    $num_padded = sprintf("%03d", (($enq_obj->interior_no) + 1));
                    $enquiry_number = "EQ/$year-$nxt_yr/IN/$num_padded";
                }
                elseif($project_type == "Landscape")
                {
                    $num_padded = sprintf("%03d", (($enq_obj->landscape_no) + 1));
                    $enquiry_number = "EQ/$year-$nxt_yr/LA/$num_padded";
                }
                elseif($project_type == "Sustainable")
                {
                    $num_padded = sprintf("%03d", (($enq_obj->sustainable_no) + 1));
                    $enquiry_number = "EQ/$year-$nxt_yr/SA/$num_padded";
                }

                
                
            }
        }else{

            // DATABSE START
            $year = date("y"); 
            //insert new value
            $nxt_yr = $year+1;
            $cpoi_obj= new AutoValuesModel();
            if($project_type == "Architecture")
            {
                $cpoi_obj->architecture_no=1;
            }
            elseif($project_type == "Interior")
            {
                $cpoi_obj->interior_no=1;
            }
            elseif($project_type == "Landscape")
            {
                $cpoi_obj->landscape_no=1;
            }
            elseif($project_type == "Sustainable")
            {
                $cpoi_obj->sustainable_no=1;
            }
            $cpoi_obj->cur_yr=$year;
            $cpoi_obj->nxt_yr=$nxt_yr;
            $res=$cpoi_obj->save();

            $num_padded = sprintf("%03d", 1);
            if($project_type == "Architecture")
            {
                $enquiry_number = "EQ/$year-$nxt_yr/AR/$num_padded";
            }
            elseif($project_type == "Interior")
            {
                $enquiry_number = "EQ/$year-$nxt_yr/IN/$num_padded";
            }
            elseif($project_type == "Landscape")
            {
                $enquiry_number = "EQ/$year-$nxt_yr/LA/$num_padded";
            }
            elseif($project_type == "Sustainable")
            {
                $enquiry_number = "EQ/$year-$nxt_yr/SA/$num_padded";
            }

        }

        return $enquiry_number;
    }

    static function custConvNumber($project_type)
    {
        $conv_obj=ConveretedAutoValuesModel::select('id','architecture_no','interior_no','landscape_no','sustainable_no','cur_yr','nxt_yr')->orderby('id','desc')->first();
        $converted_number;
        if($conv_obj){

            $day = date("d"); $month = date("m"); $year = date("y"); 

            if( ($day == '01') && ($month == '04') && ($conv_obj->nxt_yr == $year) ){
                
                // UPDATE AUTO-VALUES ON 1st APRIL.. 1st TIME
                $nxt_yr = $year+1;
                $cpoi_obj=  ConveretedAutoValuesModel::find($conv_obj->id);
                if($project_type == "Architecture")
                {
                    $cpoi_obj->architecture_no=1;
                }
                elseif($project_type == "Interior")
                {
                    $cpoi_obj->interior_no=1;
                }
                elseif($project_type == "Landscape")
                {
                    $cpoi_obj->landscape_no=1;
                }
                elseif($project_type == "Sustainable")
                {
                    $cpoi_obj->sustainable_no=1;
                }
                $cpoi_obj->cur_yr=$year;
                $cpoi_obj->nxt_yr=$nxt_yr;
                $res=$cpoi_obj->update();

                $num_padded = sprintf("%03d", 1);
                //change on project type
                if($project_type == "Architecture")
                {
                    $converted_number = "ADS/$year-$nxt_yr/AR/$num_padded";
                }
                elseif($project_type == "Interior")
                {
                    $converted_number = "ADS/$year-$nxt_yr/IN/$num_padded";
                }
                elseif($project_type == "Landscape")
                {
                    $converted_number = "ADS/$year-$nxt_yr/LA/$num_padded";
                }
                elseif($project_type == "Sustainable")
                {
                    $converted_number = "ADS/$year-$nxt_yr/SA/$num_padded";
                }
                

            }else{

                // UPDATE ONLY Converted NO.. OTHER THAN 1st APRIL.. AND ARPIL 02 records and so on
                $cpoi_obj= ConveretedAutoValuesModel::find($conv_obj->id);
                if($project_type == "Architecture")
                {
                    $cpoi_obj->architecture_no= ($conv_obj->architecture_no) + 1;
                }
                elseif($project_type == "Interior")
                {
                    $cpoi_obj->interior_no= ($conv_obj->interior_no) + 1;
                }
                elseif($project_type == "Landscape")
                {
                    $cpoi_obj->landscape_no= ($conv_obj->landscape_no) + 1;
                }
                elseif($project_type == "Sustainable")
                {
                    $cpoi_obj->sustainable_no= ($conv_obj->sustainable_no) + 1;
                }
                $res=$cpoi_obj->update();



                $nxt_yr = $year+1;
                if($project_type == "Architecture")
                {
                    $num_padded = sprintf("%03d", (($conv_obj->architecture_no) + 1));
                    $converted_number = "ADS/$year-$nxt_yr/AR/$num_padded";
                }
                elseif($project_type == "Interior")
                {
                    $num_padded = sprintf("%03d", (($conv_obj->interior_no) + 1));
                    $converted_number = "ADS/$year-$nxt_yr/IN/$num_padded";
                }
                elseif($project_type == "Landscape")
                {
                    $num_padded = sprintf("%03d", (($conv_obj->landscape_no) + 1));
                    $converted_number = "ADS/$year-$nxt_yr/LA/$num_padded";
                }
                elseif($project_type == "Sustainable")
                {
                    $num_padded = sprintf("%03d", (($conv_obj->sustainable_no) + 1));
                    $converted_number = "ADS/$year-$nxt_yr/SA/$num_padded";
                }

                
                
            }
        }else{

            // DATABSE START
            $year = date("y"); 
            //insert new value
            $nxt_yr = $year+1;
            $cpoi_obj= new ConveretedAutoValuesModel();
            if($project_type == "Architecture")
            {
                $cpoi_obj->architecture_no=1;
            }
            elseif($project_type == "Interior")
            {
                $cpoi_obj->interior_no=1;
            }
            elseif($project_type == "Landscape")
            {
                $cpoi_obj->landscape_no=1;
            }
            elseif($project_type == "Sustainable")
            {
                $cpoi_obj->sustainable_no=1;
            }
            $cpoi_obj->cur_yr=$year;
            $cpoi_obj->nxt_yr=$nxt_yr;
            $res=$cpoi_obj->save();

            $num_padded = sprintf("%03d", 1);
            if($project_type == "Architecture")
            {
                $converted_number = "ADS/$year-$nxt_yr/AR/$num_padded";
            }
            elseif($project_type == "Interior")
            {
                $converted_number = "ADS/$year-$nxt_yr/IN/$num_padded";
            }
            elseif($project_type == "Landscape")
            {
                $converted_number = "ADS/$year-$nxt_yr/LA/$num_padded";
            }
            elseif($project_type == "Sustainable")
            {
                $converted_number = "ADS/$year-$nxt_yr/SA/$num_padded";
            }

        }

        return $converted_number;
    }

    static function decode_ids($id)
    {
        $sid1=base64_decode($id);
        $nid1=str_rot13($sid1);
        $bid1=explode('IsIpl',$nid1);
        $id1=base64_decode($bid1[0]);
        $olddata=explode('-',$id1);

        return $olddata[0];
    }

    static function encode_ids($id)
    {
        $id3=$id.'-'.time();
        $bid=base64_encode($id3);
        $nid=$bid.'IsIpl'.rand(10,1000);
        $sid=str_rot13($nid);
        $j_id=base64_encode($sid);

        return $j_id;
    }
}
