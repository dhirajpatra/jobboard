<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class JobpostTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * this will test create job posting
     */
    public function testCreate()
    {
        // by passing authentication
        $this->withoutMiddleware();
        $response = $this->call('POST', 'jobpost', array(
            '_token' => csrf_token(),
        ));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * this will test the form validation for create job post
     */
    public function testCreateJobpostFormValidation()
    {
        // fake user
        //$user = new User(array('username' => 'testuser'));
        //$this->be($user);
        $this->withoutMiddleware();

        $parameters = array(
            'job_posting_title' =>  'Test Jobpost Title',
            'job_posting_description' => 'Test description for job post. This job post only to test the validation.',
            'job_posting_email' => 'testemail@gmail.com'
        );
        $response = $this->call('GET', '/jobpost', $parameters);
        $this->assertContains('job post', $response->getContent());
    }

    /**
     * this will test the application can send a mail
     */
    public function testSendMailFromApplication()
    {
        $mock = \Mockery::mock($this->app['mailer']->getSwiftMailer());
        $this->app['mailer']->setSwiftMailer($mock);
        $mock
            ->shouldReceive('send')->never()
            ->withArgs([\Mockery::on(function ($message) {
                $this->assertEquals('Activate the first job posting', $message->getSubject());
                $this->assertSame(['testuser@gmail.com' => null], $message->getTo());
                $this->assertContains('<h2>Activation couldnt be successful. May be it used already.</h2>', $message->getBody());
                return true;
            }), \Mockery::any()]);
    }

    /**
     * testing that wrong token cant make activation
     */
    public function testDoActivation()
    {
        $response = $this->action('GET', 'JobpostController@doActivate', array('token' => 'fake_token'));
        $this->assertResponseOk('<h2>Activation couldnt be successful. May be it used already.</h2>', $response->getContent());
    }
}
