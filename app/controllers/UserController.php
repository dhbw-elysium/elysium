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
                'uid'	=> Input::get('userUid'),
                'password'	=> Input::get('userPassword')
            );

            $rules = array(
                'uid'	=> 'required',
                'password'	=> 'required|min:5'
            );

            $validator = Validator::make($data, $rules);

            if ($validator->passes()) {
                if (Auth::user()->isAdmin()||Auth::user()->isCurrentUser($data['uid'])) {
                    $user           = User::find($data['uid']);
                    $user->password = Hash::make($data['password']);
                    $user->save();

                    return Response::make('', 200);
                }
            }
        return Response::make('', 405);
    }

    public function postUserUpdate(){
        $message='';
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
                'role'	=> 'sometimes|required'
            );

            $validator = Validator::make($data, $rules);

            if ($validator->passes()) {

                if (Auth::user()->isAdmin()||Auth::user()->isCurrentUser($data['uid'])) {

                    $user = User::find($data['uid']);

                    $user->firstname = $data['firstname'];
                    $user->lastname = $data['lastname'];

                    if (Validator::make(array('email' => $data['email']), array('email' => 'unique:user,email,NULL,email' . $user->email))->passes()) {
                        $user->email = $data['email'];
                    }
                    if (Auth::user()->isAdmin()){
                    if(Auth::user()->isLastAdmin()&&($data['role']!=Auth::user()->ROLE_ADMIN)){
                        return Redirect::to('user/list')->with('danger', 'Sie können dem letzten Admin nicht die Rechte entziehen!');
                    }else{
                    $user->role = $data['role'];
                    }
                    }
                    $user->save();

                    if(Auth::user()->isAdmin()){
                        return Redirect::to('user/list')->with('success', 'Änderung ist erfolgt');
                    }
                    return Redirect::to('')->with('success', 'Änderung ist erfolgt');
                }
            }



               // return View::make('user.edit')->with('uid',(int)$uid);//

                return Redirect::to('')->with('danger', 'Änderung ist fehlgeschlagen');


}}