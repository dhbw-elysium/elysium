<?php

use \Illuminate\Support\Facades\Auth;

class AuthController extends BaseController {

    public function showLogin()
    {
        // Check if we already logged in
        if (Auth::check())
        {
            // Redirect to homepage
            return Redirect::to('')->with('success', 'Sie sind bereits angemeldet');
        }

        // Show the login page
        return View::make('auth/login');
    }

	public function postLogin()
    {
        // Get all the inputs
        // id is used for login, username is used for validation to return correct error-strings
        $userdata = array(
            'email'		=> Input::get('email'),
            'password'	=> Input::get('password')
        );

        // Declare the rules for the form validation.
        $rules = array(
            'email'		=> 'required|email',
            'password'	=> 'required'
        );

        // Validate the inputs.
        $validator = Validator::make($userdata, $rules);

		usleep(rand(0,60));

        // Check if the form validates with success.
        if ($validator->passes())
        {
            // Try to log the user in.
            if (Auth::attempt($userdata))
            {
				// Redirect to homepage
               return Redirect::to('');
            }
            else
            {
                // Redirect to the login page.
//                return Redirect::to('login')->withErrors(array('password' => 'Password invalid'))->withInput(Input::except('password'));
                return Redirect::to('login')->with('danger', 'Anmeldung fehlgeschlagen')->withInput(Input::except('password'));
            }
        }


        // Something went wrong.
        return Redirect::to('login')->withErrors($validator)->withInput(Input::except('password'));
    }

	public function getLogout()
    {
        // Log out
        Auth::logout();

        // Redirect to homepage
        return Redirect::to('')->with('success', 'Sie haben sich erfolgreich abgemeldet. Auf Wiedersehen!');
    }
}
