<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobPostings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_postings', function (Blueprint $table) {
            $table->increments('job_posting_id');
            $table->integer('job_posting_user_id');
            $table->string('job_posting_title');
            $table->text('job_posting_description');
            $table->string('job_posting_email');
            $table->tinyInteger('job_posting_approved')->default(0);
            $table->tinyInteger('job_posting_spam')->default(0);
            $table->string('job_posting_confirmation_code')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_postings');
    }
}
