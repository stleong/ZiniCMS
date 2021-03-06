<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Input;
use Redirect;
use Hash;
use Auth;
use App\User;
use App\Concept;
use App\Role;

class UserController extends BaseController {

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function index(){
        $users = User::with("roles")->get();
        return view("admin.user.index")->with(array("users" =>$users, "page_title"=>"View Users"));
    }

    /**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
    public function create(){
        return view("admin.user.create")->with("page_title", "Add a User");
    }

    /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
    public function store(){
        $validator = Validator::make(Input::all(), array(
            "name" => "required|max:60",
            "email" => "required|max:50|email|unique:users",
            "password" => "required|min:6",
            "password_again" => "required|same:password",
        ));

        if($validator->fails()){
            return Redirect::route("admin.user.create")->withErrors($validator)->withInput();
        }else{
            $name = Input::get("name");
            $email = Input::get("email");
            $password = Input::get("password");

            $user = User::create(array(
                "name"     =>$name,
                "email"     =>$email,
                "password"  => Hash::make($password),
            ));

            if($user){
                $user->attachRole(4);
                return Redirect::route("admin.user.index")->with("global", "User added successfully!");
            }
        }
    }

    /**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function show($id){

    }

    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function edit($id){
        $user = User::with("roles")->find($id);
        $allRoles = Role::all();
        return view("admin.user.edit")->with(array("user" => $user, "allRoles"=>$allRoles, "page_title"=>"Edit a User"));
    }

    /**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update($id){
        $user = User::find($id);
        $roles = Input::get("rolesCheckBox");
        $synced = $user->roles()->sync($roles);
        if($synced){
            return Redirect::route("admin.user.index")->with("global", "User successfully updated!");
        }
    }

    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id){
        $deleted = User::find($id)->delete();
        if($deleted){
            return Redirect::route("admin.user.index")->with("global", "User deleted");
        }else{
            return Redirect::route("admin.user.index")->with("global", "Something went wrong, try again later!");
        }
    }

}
