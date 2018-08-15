<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use Validator;

class HomeController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['viewPath'] = 'AuthenticatedUser.Home.';
		
		$this->data['jsArray'][] = 'Home_OnlineInformation.js';
    }

    private function _setBreadcrumbs($brdcrmb) {
        foreach($brdcrmb as $key => $value){
            $this->data['brdcrmb'][] = array(
                array('title' => $key, 'url' => $value)
            );
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function onlineInformation() {
        
        $breadcrumb = array(
            'Home' => route('home::onlineInfo')
        );
        $this->_setBreadcrumbs($breadcrumb);
        
        $this->data['pageTitle'] = 'Online Information of ' . Auth::user()->full_name;
        
        return view($this->data['viewPath'] . 'onlineInformation', array('data' => $this->data));
    }
	/******************************************* edit profile  ********************************************************/
	  public function edit(Request $request){
        
		 if (!$request->ajax()) {
			 
			 $breadcrumb = array(
                'Home' => route('home::onlineInfo'),
                'Update Profile' => route('home::updateOwnProfile'),
            );
            $this->_setBreadcrumbs($breadcrumb);			 
		
            $this->data['pageTitle'] = 'Update Your Information';
            try {
                return view($this->data['viewPath'] . 'edit', array('data' => $this->data));
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        } else {
            throw new Exception('Invalid request!');
        }
    }
	
	/********************************************* update profile ************************************************/
	
	public function update(Request $request){
		
		 $this->data['Details'] = User::findOrFail( Auth::user()->user_id);
        
        $validator = Validator::make($request->all(), array(
                    'full_name' => 'required|max:255',
                    'email' => 'required',
                    'phone_no' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('home::updateOwnProfile')
                            ->withErrors($validator)
                            ->withInput();
        }
		
        $profile = User::find(Auth::user()->user_id);
      
        $profile->full_name = $request->full_name;
        $profile->email = $request->email;
        $profile->phone_no = $request->phone_no;      
        $profile->save();

        return redirect()->route('home::onlineInfo')
                        ->with('successMessage', 'Data updated successfully.');
    }
	
	/*******************************************  update picture  ***************************************************/
	public function update_image(Request $request){
		
		$this->data['Details'] = User::findOrFail( Auth::user()->user_id);
        		
        $profile = User::find( Auth::user()->user_id);
       
		 if($request->hasFile('image')) {
				  
		   if ($request->file('image')->isValid()) {
   
	            $destinationPath = 'img/ProfilePicture';
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = Auth::user()->user_id.'.'.$extension;

				$request->file('image')->move($destinationPath,$fileName);
				
				$profile->image = $fileName;
                $profile->save();				
            }				   
									  				   				 		         
         }
		
        return redirect()->route('home::onlineInfo')
                        ->with('successMessage', 'picture updated successfully.');
		
	}
	
	
	/**********************************************  update password  **************************************************/
	  
	    public function edit_password(Request $request){        
		 if (!$request->ajax()) {			 
            $breadcrumb = array(
                'Home' => route('home::onlineInfo'),
                'Change Password' => route('home::updateProfilePassword'),
            );
            $this->_setBreadcrumbs($breadcrumb);
			
            $this->data['pageTitle'] = 'Update Your Information';
            try {
                return view($this->data['viewPath'] . 'passwordChange', array('data' => $this->data));
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        } else {
            throw new Exception('Invalid request!');
        }
    }
	  
	  /****************/
	  public function update_password(Request $request){
		  
		  $this->data['Details'] = User::findOrFail( Auth::user()->user_id);       	

           $validator = Validator::make($request->all(), array(
                    'oldpassword' => 'required',
                    'password' => 'required',
                    'cnfpassword' => 'required',
                    
           ));
           if ($validator->fails()) {
            return redirect()->route('home::updateProfilePassword')
                            ->withErrors($validator)
                            ->withInput();
           }		  		  

		   
		   // //// Getting the User  //////////
		   
		   if(!Hash::check($request->oldpassword, Auth::user()->password)){
			   
			   return redirect()->route('home::updateProfilePassword')
                            ->with('errorMessage', 'Your current password didn\'t match.');
		   }
		   
		   if($request->password != $request->cnfpassword){
			   
			   return redirect()->route('home::updateProfilePassword')
                            ->with('errorMessage', 'Your new password and confirm password didn\'t match.');
		   }		   		   		
			$user = User::find(Auth::user()->user_id);
			$user->password = bcrypt($request->password);
			$user->save();
		  
		 
        return redirect()->route('home::onlineInfo')
                        ->with('successMessage', 'Password updated successfully.');
		  
	  }
	
	
	/******************************************************************************************************/
	
	
    public function signOut(Request $request){
        
        Auth::logout();
        $request->session()->flush();
        
        return redirect(route('signInForm'));
    }

	
	
}
