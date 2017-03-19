# jobboard
jobboard application with Laravel 
In   a   context   of   hypothetical   job   board   project,   please   implement   following   user   stories: 
User Story 1 
 
As   a   HR   manager   I   would   like   to   go   to   job   submission   page,   fill   out   a   form   and   publish   a   job 
offer. 
 
COS: 
 
● new   job   form   should   contain   title,   description   and   email   field. 
● when   i   hit   submit   button,   if   this   is   my   first   job   posting   i   should   receive   email   saying   that 
my   submission   is   in   moderation,   otherwise   it   should   be   public/published. 
 
 
User Story 2 
 
As   a   job   board   moderator   i   would   like   to   receive   email   every   time   someone   posts   a   job   for   a   first 
time. 
 
COS: 
 
● every   time   someone   posts   a   job   for   a   first   time   (based   on   email   address)   i   should   receive 
email   about   it 
● email   notification   should   contain   title   and   description   of   submission,   as   well   as   links   to 
approve   (publish)   or   mark   it   as   a   spam. 

### PSR 2 standard
By php-cs-fixer all cotrollers, models and routes files are PSR 2 standard.

### phpUnit tested

Have tested with ```Laravel\BrowserKitTesting\TestCase as BaseTestCase```

So kindly change the $baseUrl as per your virtual / real host name.

### How to install
* Clone the repository to your virtual host folder
* Run: composer update
* Change the .env file as per your settings including mail settings and database
* Also check the config/database.php for more details database related configuration
* Run: database migration command from root folder [eg. php artisan migrate:refresh --seed]
* there will be two users:
* hrmanager@test.com [password: password]
* moderator@test.com [password: password]
* This application is using Swift Mailer library. So you have to configure the config/mail.php file too.
* All documents including ER diagram, DFD inside public/document folder
* Primacy custom coding files are:
##### routes/web.php
##### controllers/JobpostController.php
##### controllers/HomeController.php
##### app/User.php
##### app/Jobposting.php
##### views/home/*
##### views/jobpost/*
##### views/layouts/*
##### database/migrations/*
##### database/seeds/*
##### tests/Unit/*

### How to run
Run your virtual host or real host from the browser eg. http://jobboard/ so it will show you the login screen. You can enter hrmanager login details to job post.

After login successful it will show you the Job Posting form to post. Validation are there. Fill all the boxes and submit.

```it will process to save the data after checking that this is your first job post or not. If it is first time from you [hrmanager for eg.] then it will send a mail with details links to moderator to activate / spam the mail. Otherwise it will save the mail and make the post automatically published. For the first time post moderator can activate the post through his mail's activation link. She can make it spam too by another link on the same mail.```

#### Future purposes
Though I have created login system for user but there is no registration process now.

Also now link the user table with jobposting table for future purposes so that application take the email and details by default and no need to write email at job post form.

Also need to add more test especially Mock tests.





