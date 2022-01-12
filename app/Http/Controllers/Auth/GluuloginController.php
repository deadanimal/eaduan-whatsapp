<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\User;
use Session;
use Lang;
use Redirect;
use App\Gluu;
use Illuminate\Support\Facades\Input;
use Jumbojett\OpenIDConnectClient;

class GluuloginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Gluulogin Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
	protected $redirectTo = '/home';
   
  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('guest', ['except' => 'gluulogout']);
    }
     /*
	 *   Gluu login calls gluu url to authenticate and return to function after authentication successful
	 */
    public function gluulogin(Request $request,Gluu $gluu){
		
		$oidc=$gluu->oidc();
		$oidc->authenticate();
		$userinfo=$oidc->requestUserinfo();
		$username=$userinfo->user_name;
	    $users = User::where('username', $username)->where('user_cat',2)->get();

		if($users->count()>0){
			$user=$users->first();
			if($user->status==1){
				if(Auth::login($user, true)){
					
				}
                                return redirect()->route('dashboard')->with('status', 'popupmodal');
			}else{
				return redirect('/kepenggunaan')->with('alert', 'pengguna tidak aktif!'); 
			}
		}else{
			 return redirect('/kepenggunaan')->with('alert', 'pengguna tidak dijumpai !');        
		}	
    }
    
   
 public function gluulogout(Request $request,Gluu $gluu){
        $index=$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"].'/kepenggunaan';
		$oidc=$gluu->oidc();
		$oidc->signOut('',$index);
   }
     protected function guard()
    {
        return Auth::guard();
    }
}
