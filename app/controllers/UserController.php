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
    public function showUserEdit(){
        return View::make('user.edit');
    }
}