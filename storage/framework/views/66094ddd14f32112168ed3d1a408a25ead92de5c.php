<?php

?>
        <!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Kindly activate the first job post</h2>

<div>
    One of our HR Manager posted her first job. Kindly activate by clicking this <a href="<?php echo e(URL::to('jobpost/activation/' . $confirmationCode)); ?>">address</a> <br/>

    Otherwise you can make it spam by clicking this <a href="<?php echo e(URL::to('jobpost/spam/' . $id)); ?>">address</a> <br>

    Job details below <?php echo e($jobPostDetails); ?> <br>

    If you have problems, please paste the above URL into your web browser.

</div>
</body>
</html>
