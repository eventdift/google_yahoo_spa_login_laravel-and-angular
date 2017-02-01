<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\areas;
use App\product;
use Validator;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use App\profile;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if(array_key_exists('role', $data)){
           $myUser = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt("customized"),
            ]);
           profile::create([
            'user_id' => $myUser->id,
            'role' => $data['role'],
            'PhoneNo' => $data['PhoneNo']
            ]);

            $myUser->assignRole($data['role']);
        }else{
             $myUser = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password'])
            ]);    
        }

        return $myUser;
    }

    public function getUser($id){
        $user = User::find($id);
        $user['profile'] = $user->profile;
        return \Response::json($user);
    }

    public function deleteUser($id){
        $user = User::find($id);
        $areas = areas::where('marketer',$user->name)->get();
        $products = product::where('ManagedBy',$user->name)->get();
        if($areas){
            session()->flash('error_message','Roles assigned to the user have been removed');
            foreach($areas as $area){
                $area->marketer = '';
                $area->save();
            }
        }
        if($products){
            session()->flash('error_message','Roles assigned to the user have been  removed');
            foreach($products as $product){
                $product->ManagedBy = '';
                $product->save();
            }
        }
        $profile = $user->profile;
        $profile->delete();
        $role = $user->roles()->pluck('name');
        $user->removeRole($role[0]);
        $user->delete();
    }

    public function editUser($id, Request $request){
        $user = User::find($id);
        $profile = $user->profile;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $role = $user->roles()->pluck('name');
        $user->removeRole($role[0]);
        $user->assignRole($request->input('role'));
        $user->save();
        $profile->role = $request->input('role');
        $profile->PhoneNo = $request->input('PhoneNo');
        $profile->save();
    }
}
