<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyProfileModel;
use App\Models\UserModel;
use Session;
use Hash;
class LoginController extends Controller
{
    public function login()
	{   
		$u1_obj=CompanyProfileModel::all();
		return view('pages.login',compact('u1_obj'));
	}

    public function check_login()
	{
		// dd('Hello');
		$mobile=$_POST['mobile'];
		$password=$_POST['password'];

	  	$u_obj=UserModel::where('mobile', 'LIKE', '%'.$mobile.'%')->select('id','name','mobile','password','delete','is_active','role')->get();
		// dd($password,$u_obj);
	
		if(count($u_obj)>0)
		{
            if ( $u_obj[0]->delete == 0)
            {  
                if( $u_obj[0]->is_active == 0)
                {
                    if(Hash::check($password, $u_obj[0]->password)) 
                    {
                        Session::put('NAME',$u_obj[0]->name);
                        Session::put('MOBILE',$u_obj[0]->mobile);
                        Session::put('USER_ID',$u_obj[0]->id);
                        Session::put('ROLES',$u_obj[0]->role);
                        return redirect()->route('dashboard'); 
                        
                    }else{
                        Session::put('ERROR_MESSAGE', 'Wrong Password.Please Try Again...!');
                        return redirect()->route('login.page'); 
                    }
                }else{
                    Session::put('ERROR_MESSAGE', 'This User Is Currently Inactive.Please Contact To SuperAdmin!');
                    return redirect()->route('login.page'); 
                }
            }else{
                Session::put('ERROR_MESSAGE', 'This Admin Account Is Deleted...!');
                return redirect()->route('login.page'); 
            }
		}else{
			Session::put('ERROR_MESSAGE', 'User Not Found...!');
			return redirect()->route('login.page');
		}
	}

    public function index()
	{
		$a_id=Session::get('USER_ID');		
		$role=Session::get('ROLES'); 

		$a_id=Session::get('USER_ID');		
		$role=Session::get('ROLES'); 

		
		if($role == 0){
			return view('dashboard.dashboard');
		}else if($role == 1){
			// dd($role);
			return redirect()->route('project_enquiry.page');
		}else{
			return redirect()->route('enq_tasks.page');
		}

		// return view('dashboard.dashboard');
	
	}

	public function profile()
	{
		$u1_obj=CompanyProfileModel::all();
		$id=Session::get('USER_ID');
		$u_obj=UserModel::find($id);
		return view('pages.profile',compact('u_obj','u1_obj'));
	}

	public function profile_edit(Request $req)
	{
		// dd('hello');
		$edit_id=$req->get('edit_id');
		$name=isset($_POST['name']) ? $_POST['name'] : "NA";
		$email=isset($_POST['email']) ? $_POST['email'] : "NA";
		$mobile=isset($_POST['mobile']) ? $_POST['mobile'] : "NA";

		$u_obj=UserModel::find($edit_id);
		$u_obj->name=$name;
		$u_obj->email=$email;
		$u_obj->mobile=$mobile;
		$res=$u_obj->update();

		if($res)
		{
			Session::put('NAME',$name);
			Session::put('MOBILE',$mobile);
			Session::put('SUCCESS_MESSAGE','User Profile Updated Successfully!');
			$message="Hello User, \r\nYour Profile has been updated. \r\n- ".config('constants.SENDER_NAME');
            $templateid=config('constants.TEMPLATE_ID_4');
            $mobile_number=substr($mobile, -10);
            $SMS_URL= config('constants.SMS_API_LINK');
            $sender = config('constants.SMS_SENDER_ID');
            
            $username=config('constants.SMS_USERNAME');
            $password=config('constants.SMS_PASSWORD');
            $entityid=config('constants.ENTITY_ID');
             

            /*============== 1.SMS LOGIN PASSWORD ============*/

            $ch = curl_init($SMS_URL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$username&authkey=$password&sender=$sender&mobile=$mobile_number&text=$message&entityid=$entityid&templateid=$templateid&output=json");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);
            
		}else{
			Session::put('ERROR_MESSAGE',"User Profile Doesn't Updated..!");
	  	}
	  	return redirect()->back();

	}

	public function check_pass(Request $req)
	{
		$edit_id=$req->get('edit_id');
		$current_password=isset($_POST['current_password']) ? $_POST['current_password'] : "NA";
		$new_password=isset($_POST['new_password']) ? $_POST['new_password'] : "NA";

		$u_obj=UserModel::find($edit_id);
		
		if(Hash::check($current_password, $u_obj->password))
		{
			$pass=Hash::make($new_password);
          	$u_obj->password=$pass;
          	$mobile=$u_obj->mobile;
          	$res=$u_obj->update();

          	if($res){
                Session::put('SUCCESS_MESSAGE',"Password Updated Successfully!");
          	}else{
          		Session::put('ERROR_MESSAGE',"Password Doesn't Updated..!");
          	}
			
		}else{
			Session::put('ERROR_MESSAGE',"Password Doesn't Matched..!");
		}
		return redirect()->back();
	}
}
