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

            $data = array(
                'uid'	=> Input::get('uid'),
                'title' => Input::get('title'),
                'firstname'	=> Input::get('firstname'),
                'lastname'	=> Input::get('lastname'),
                'email'	=> Input::get('email')
            );


            $rules = array(
                'uid'	=> 'required|numeric',
                'title' => 'required',
                'firstname'	=> 'required',
                'lastname'	=> 'required',
                'email'	=> 'required|email'
            );

          if(Input::has('role')){
                $data['role']   = Input::get('role');
                $rules['role']  = 'required';
           }

            $validator = Validator::make($data, $rules);

            if ($validator->passes()) {

                if (Auth::user()->isAdmin()||Auth::user()->isCurrentUser($data['uid'])) {

                    $user = User::find($data['uid']);
                    $user->title = $data['title'];
                    $user->firstname = $data['firstname'];
                    $user->lastname = $data['lastname'];

                    if (Validator::make(array('email' => $data['email']), array('email' => 'unique:user,email,NULL,email' . $user->email))->passes()) {
                        $user->email = $data['email'];
                    }
                    if (Auth::user()->isAdmin()){
                    if(!Auth::user()->isCurrentUser($user->uid)){
                            $user->role = $data['role'];
                    }
                    }
                    $user->save();

                    if(Auth::user()->isAdmin()){
                        return Redirect::to('user/list')->with('success', 'Änderung ist erfolgt');
                    }
                    return Redirect::to('user/edit/'.$user->uid)->with('success', 'Änderung ist erfolgt');
                }
            }



               // return View::make('user.edit')->with('uid',(int)$uid);//

                return Redirect::to('')->with('danger', 'Änderung ist fehlgeschlagen');


}
    public function createNewUser(){
        return View::make('user.edit')->with('uid', null);


}
    public function updateNewUser(){
        if(Auth::user()->isAdmin()) {
            $data = array(
                'title' => Input::get('title'),
                'firstname' => Input::get('firstname'),
                'lastname' => Input::get('lastname'),
                'email' => Input::get('email'),
                'role' => Input::get('role'),
                'password' => Input::get('password')
            );


            $rules = array(
                'title' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:user,email',
                'role' => 'required',
                'password' => 'required|min:5'

            );

            $validator = Validator::make($data, $rules);

            if ($validator->passes()) {
                $user = new User;
                $user->title = $data['title'];
                $user->firstname = $data['firstname'];
                $user->lastname = $data['lastname'];
                $user->email = $data['email'];
                $user->role = $data['role'];
                $user->password = Hash::make($data['password']);
                $user->save();
                return Redirect::to('user/list')->with('success', 'Benutzer wurde angelegt.');

            }
            $messages=$validator->messages();
            $returnMessage='';
            foreach ($messages->all() as $message)
            {
            $returnMessage=$returnMessage.' '.$message;
            }

            return Redirect::to('user/list')->with('danger', 'Benutzer anlegen fehlgeschlagen'.' '.$returnMessage);
        }
        return Redirect::to('home')->with('danger', 'Hier ist ein Fehler aufgetreten!');
    }
    /**
     * Delete a User
     *
     * @return \Illuminate\Http\Response
     */
    public function postUserDelete()
    {

        $uid	= Input::get('userUid');


        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make(
            array('uid' => $uid),
            array('uid' => 'required|numeric')
        );


        if ($validator->passes()) {
            User::destroy($uid);

            return Response::make('', 200);
        }

        return Response::make('', 405);
    }



}