<?php
class UserController extends BaseController {

    public function showUsers()
    {
        if (Auth::user()->isAdmin())
        {
            return View::make('user.list');   // yes
        }
        else
        {
            return View::make('home');   // no
        }

    }
    public function showUserEdit($uid){

        if (Auth::user()->isAdmin()||Auth::user()->isCurrentUser($uid))
        {


            return View::make('user.edit')->with('uid',(int)$uid);  // yes
        }
        else
        {
            return View::make('home');   // no
        }
    }
    public function postUserPasswordUpdate(){

            $data = array(
                'uid'	=> Input::get('uid'),
                'password'	=> Input::get('userPassword'),
                'password_confirmation'	=> Input::get('userPasswordConfirmation')
            );

            $rules = array(
                'uid'	=> 'required',
                'password'	=> 'required|confirmed',
                'password_confirmation'	=> 'required'

            );


            $validator = Validator::make($data, $rules);

            if ($validator->passes()) {
                if (Auth::user()->isAdmin()||Auth::user()->isCurrentUser($data['uid'])) {
                if ($data['uid']) {
                    $user = User::find($data['uid']);
                    $user->password=Hash::make($data['password']);
                    $user->save();

                    return View::make('user.edit')->with('uid',$data['uid']);

                }



            }}
            if(Auth::user()->isAdmin()){
            return View::make('user.list');
            }
        return View::make('home'); // yes




    }
    public function postUserUpdate(){
        if (Auth::user()->isAdmin()){
            $data = array(
                'uid'	=> Input::get('uid'),
                'firstname'	=> Input::get('firstname'),
                'lastname'	=> Input::get('lastname'),
                'email'	=> Input::get('email'),
                'role'	=> Input::get('role')
            );

            $rules = array(
                'uid'	=> 'required|numeric',
                'firstname'	=> 'required',
                'lastname'	=> 'required',
                'email'	=> 'required|email',
                'role'	=> 'required'
            );
        }else{ //nicht Admins (eigener Nutzer darf keine Rolle setzeb
            $data = array(
                'uid'	=> Input::get('uid'),
                'firstname'	=> Input::get('firstname'),
                'lastname'	=> Input::get('lastname'),
                'email'	=> Input::get('email')
            );

            $rules = array(
                'uid'	=> 'required|numeric',
                'firstname'	=> 'required',
                'lastname'	=> 'required',
                'email'	=> 'required|email'
            );
        }
            $validator = Validator::make($data, $rules);

            if ($validator->passes()) {

                if (Auth::user()->isAdmin()||Auth::user()->isCurrentUser($data['uid'])) {

                    if ($data['uid']) {
                        $user = User::find($data['uid']);

                    } else {
                        $user = new User;
                    }

                    $user->firstname = $data['firstname'];
                    $user->lastname = $data['lastname'];

                    if (Validator::make(array('email' => $data['email']), array('email' => 'unique:user,email,NULL,email' . $user->email))->passes()) {
                        $user->email = $data['email'];
                    }
                    if (Auth::user()->isAdmin()){
                    $user->role = $data['role'];
                    }
                    $user->save();

                    if(Auth::user()->isAdmin()){
                        return View::make('user.list');
                    }
                    return View::make('home'); //everything worked out
                }
            }



               // return View::make('user.edit')->with('uid',(int)$uid);//

                return View::make('home');


}}