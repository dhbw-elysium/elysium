<?php
class UserController extends BaseController {

    public function showUsers()
    {
        if (Auth::user()->isAdmin())
        {
            return View::make('user');   // yes
        }
        else
        {
            return View::make('home');   // no
        }

    }
}