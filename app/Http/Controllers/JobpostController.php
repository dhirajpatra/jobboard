<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Crypt;
use Auth;
use Mail;
use Hash;
use Flash;
use App\User;
use App\Jobposting;
use Mockery\Exception;

class JobpostController extends Controller
{
    protected $mailer;

    /**
     * JobpostController constructor.
     */
    public function __construct(Mailer $mailer)
    {
        try {
            $this->mailer = $mailer;
            Redirect('guest');
        } catch (Exception $e) {
            Flash::message('Something went wrong' . $e->getMessage());
        }
    }

    /**
     * this will show the job posting form
     * @return mixed
     */
    public function showPost()
    {
        try {
            // show job post form
            return View::make('jobpost.jobpost');
        } catch (Exception $e) {
            Flash::message('Something went wrong ' . $e->getMessage());
        }
    }

    /**
     * this will process the job posting and send mail
     * @param Request $request
     */
    public function doPost(Request $request)
    {
        try {

            // validation rules for form
            $rules = array(
                'job_posting_title' => 'required|min:6',
                'job_posting_description' => 'required|min:20',
                'job_posting_email' => 'required|email'
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::only('job_posting_title', 'job_posting_description', 'job_posting_email'), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            } else {

                // get the user details from auth and db
                $userId = Auth::user()->id;

                //check if this user has previous posting or not
                $jobPostingObj = new Jobposting();
                $userJobPosting = $jobPostingObj->getUserPostings(Input::get('job_posting_email'));

                if (count($userJobPosting) == 0) {
                    $message = 'Your job submission is in moderation ';

                    // confirmation code for validation
                    $confirmationCode = hash_hmac('sha256', str_random(40), config('app.key'));

                    // save data to jobposting
                    $jobPostingObj = new Jobposting();
                    $jobId = $jobPostingObj->saveJobPost(
                        array(
                            'job_posting_user_id' => $userId,
                            'job_posting_title' => Input::get('job_posting_title'),
                            'job_posting_email' => Input::get('job_posting_email'),
                            'job_posting_description' => Input::get('job_posting_description'),
                            'job_posting_approved' => 0,
                            'job_posting_spam' => 0,
                            'job_posting_confirmation_code' => $confirmationCode,
                        )
                    );

                    // encrypting the id
                    $jobId = Crypt::encryptString($jobId);

                    $jobPostDetails = 'Title: ' . Input::get('job_posting_title') . ', Email: ' . Input::get('job_posting_email') . ', Description: ' . Input::get('job_posting_description');

                    $template = 'jobpost.activate';
                    $data = ['confirmationCode' => $confirmationCode, 'jobPostDetails' => $jobPostDetails, 'id' => $jobId];
                    $email = 'dhiraj.patra@gmail.com';
                    $name = 'Moderator';
                    $subject = 'Activate the first job posting';

                    // first post need to send mail to moderator
                    $this->sendMail($template, $data, $email, $name, $subject);

                    $template = 'jobpost.postsaved';
                    $data = ['message' => $message];
                    $email = Input::get('job_posting_email');
                    $name = User::find($userId)->name;
                    $subject = 'Your post is awiting moderation';

                    // mail send to job poster
                    $this->sendMail($template, $data, $email, $name, $subject);
                } else {
                    $message = 'Your job has been published';

                    // save the data with auto published/status as published
                    Jobposting::create([
                        'job_posting_user_id' => $userId,
                        'job_posting_title' => Input::get('job_posting_title'),
                        'job_posting_email' => Input::get('job_posting_title'),
                        'job_posting_description' => Input::get('job_posting_title'),
                        'job_posting_approved' => 1,
                        'job_posting_spam' => 0,
                    ]);
                }
            }

            return Redirect::route('jobpost')->with('success', $message);
        } catch (Exception $e) {
            Flash::message('Something went wrong ' . $e->getMessage());
        }
    }

    /**
     * this will send mail
     * @param $template
     * @param $data
     * @param $email
     * @param $name
     * @param $subject
     * @return bool
     */
    public function sendMail($template, $data, $email, $name, $subject)
    {
        try {
            Mail::send($template, $data, function ($mailMessage) use ($email, $name, $subject) {
                $mailMessage->to($email, $name)->subject($subject);
            });

            return true;
        } catch (Exception $e) {
            Flash::message('Something went wrong ' . $e->getMessage());
        }
    }

        /**
     * @param $token
     * @return mixed
     */
    public function doActivate($token)
    {
        try {
            $jobPostingObj = new Jobposting();
            $update = $jobPostingObj->activate($token);

            if ($update) {
                echo '<h2>You have successfully activated the job post.</h2>';
            } else {
                echo '<h2>Activation couldnt be successful. May be it used already.</h2>';
            }
            //return Redirect::route('login');
        } catch (Exception $e) {
            Flash::message('Something went wrong ' . $e->getMessage());
        }
    }

    /**
     * make the post as spam
     * @param $id
     * @return mixed
     */
    public function makeSpam($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $jobPostingObj = new Jobposting();
            $update = $jobPostingObj->makeSpam($id);

            if ($update) {
                echo 'You have made the job post as spam.';
            } else {
                echo 'Spam action not successful.';
            }
            //return Redirect::route('login');
        } catch (Exception $e) {
            Flash::message('Something went wrong ' . $e->getMessage());
        }
    }
}
