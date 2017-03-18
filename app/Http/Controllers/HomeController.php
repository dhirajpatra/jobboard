<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Auth;

class HomeController extends Controller
{
    /**
     * @return mixed
     */
    public function showLogin()
    {
        try {
            if (Auth::check()) {
                return Redirect::to('jobpost');
            }

            // show the form
            return View::make('home.login');
        } catch (Exception $e) {
            Flash::message('Something went wrong ' . $e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function doLogin()
    {
        try {
            // validate the info, create rules for the inputs
            $rules = array(
                'email'    => 'required|email', // make sure the email is an actual email
                'password' => 'required|min:3' // password can only be alphanumeric and has to be greater than 3 characters
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {
                return Redirect::to('login')
                    ->withErrors($validator) // send back all errors to the login form
                    ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
            } else {

                // create our user data for the authentication
                $userdata = array(
                    'email'     => Input::get('email'),
                    'password'  => Input::get('password')
                );

                // attempt to do the login
                if (Auth::attempt($userdata)) {

                    // validation successful!
                    // redirect them to the secure section or whatever
                    return Redirect::to('jobpost');
                } else {
                    // validation not successful, send back to form
                    return Redirect::to('login');
                }
            }
        } catch (Exception $e) {
            Flash::message('Something went wrong ' . $e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function doLogout()
    {
        try {
            if (Auth::guest()) {
                return Redirect::to('login');
            }

            // log the user out of our application
            Auth::logout();

            // redirect the user to the login screen
            return Redirect::to('login');
        } catch (Exception $e) {
            Flash::message('Something went wrong ' . $e->getMessage());
        }
    }
}
