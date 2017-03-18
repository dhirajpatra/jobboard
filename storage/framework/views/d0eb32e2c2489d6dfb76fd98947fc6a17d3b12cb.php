<?php
/**
 * Created by PhpStorm.
 * User: dhirajpatra
 * Date: 16/3/17
 * Time: 11:43 AM
 */
?>
<!-- app/views/login.blade.php -->



<?php $__env->startSection('content'); ?>
    <div id="container">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        <?php if(isset($success)): ?>
            <div class="alert alert-success"> <?php echo e($success); ?> </div>
        <?php endif; ?>
        <div class="page-header">&nbsp;</div>
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <h1>Login to JobBoard</h1>


                    <?php echo e(Form::open(['route' => 'login_post'])); ?>


                    <!-- if there are login errors, show them here -->
                    <div class="form-group">
                        <?php echo e($errors->first('email')); ?>

                        <?php echo e($errors->first('password')); ?>

                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('email', 'Email Address')); ?>

                        <?php echo e(Form::text('email', Input::old('email'), array('required', 'placeholder' => 'your email'))); ?>

                    </div>

                    <div class="form-group">
                        <?php echo e(Form::label('password', 'Password')); ?>

                        <?php echo e(Form::password('password', array('required'))); ?>

                    </div>

                    <div class="form-group">
                    <?php echo e(Form::submit('Submit')); ?>

                    </div>
                    <?php echo e(Form::close()); ?>


<?php $__env->stopSection(); ?>
                    </div>
            </div>
    </div>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>