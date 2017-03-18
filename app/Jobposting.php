<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;

class Jobposting extends Model
{
    protected $table = 'job_postings';
    //public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_posting_id', 'job_posting_title', 'job_posting_user_id', 'job_posting_description', 'job_posting_email', 'job_posting_approved', 'job_posting_spam', 'job_posting_confirmation_code'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        try {
            return $this->hasOne('App\User', 'id', 'job_posting_user_id');
        } catch (\Exception $e) {
            Flash::message('Something went wrong' . $e->getMessage());
        }
    }

    /**
     * fetch all posts for a user
     * @param $posterEmail
     * @return string
     */
    public function getUserPostings($posterEmail)
    {
        try {
            // fetching posts of this user
            $postings = Jobposting::where('job_posting_email', $posterEmail)
                ->get()
                ->take(1)
                ->toArray();

            return $postings;
        } catch (\Exception $e) {
            Flash::message('Something went wrong' . $e->getMessage());
        }
    }

    /**
     * this will activate and published the post
     * @param $token
     * @return bool
     */
    public function activate($token)
    {
        try {
            $affectedRow = Jobposting::where('job_posting_confirmation_code', '=', $token)
                ->where('job_posting_approved', '=', 0)
                ->where('job_posting_spam', '=', 0)
                ->update(array('job_posting_approved' => 1));

            if ($affectedRow) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            Flash::message('Something went wrong' . $e->getMessage());
        }
    }

    /**
     * this will make the job post as spam
     * @param $id
     * @return bool
     */
    public function makeSpam($id)
    {
        try {
            $affectedRow = Jobposting::where('job_posting_id', '=', $id)
                ->where('job_posting_approved', '=', 0)
                ->where('job_posting_spam', '=', 0)
                ->update(array('job_posting_spam' => 1));

            if ($affectedRow) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            Flash::message('Something went wrong' . $e->getMessage());
        }
    }

    /**
     * save a job post
     * @param $input
     * @return int|mixed
     */
    public function saveJobPost($input)
    {
        try {
            $data = new Jobposting();

            $data->job_posting_user_id = $input['job_posting_user_id'];
            $data->job_posting_title = $input['job_posting_title'];
            $data->job_posting_description = $input['job_posting_description'];
            $data->job_posting_email = $input['job_posting_email'];
            $data->job_posting_approved = 0;
            $data->job_posting_spam = 0;
            $data->job_posting_confirmation_code = $input['job_posting_confirmation_code'];

            if ($data->save()) {
                return $data->id;
            } else {
                return 0;
            }
        } catch (\Exception $e) {
            Flash::message('Something went wrong' . $e->getMessage());
        }
    }
}
