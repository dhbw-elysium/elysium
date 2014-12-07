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

        if (Auth::user()->isAdmin())
        {


            return View::make('user.edit')->with('uid',(int)$uid);  // yes
        }
        else
        {
            return View::make('home');   // no
        }
    }

    public function postUserUpdate(){
        if (Auth::user()->isAdmin())
        {
            if (Input::has('uid'))
            {
                $uid= (int) Input::get('uid');
                if ($user	= User::find($uid)){
                    if(Input::has('firstname')){
                    $user->firstname=Input::get('firstname');
                    $user->save();
                    }
                    if(Input::has('lastname')){
                        $user->lastname=Input::get('lastname');
                        $user->save();
                    }
                    if(Input::has('email')){
                        $user->email=Input::get('email');
                        $user->save();
                    }
                    if(Input::has('role')){
                        $user->role=Input::get('role');
                        $user->save();
                    }




                }
               // return View::make('user.edit')->with('uid',(int)$uid);//
                return View::make('user.list');
            }else{
                return View::make('user.list');
            }









        }
        else
        {
            return View::make('home'); // no
        }
    }
}