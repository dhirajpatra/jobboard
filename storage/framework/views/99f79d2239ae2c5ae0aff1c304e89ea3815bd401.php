<?php
/**
 * Created by PhpStorm.
 * User: dhirajwebappclouds
 * Date: 13/1/17
 * Time: 4:08 PM
 */
?>
<nav class="navbar navbar-inverse navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php if(Auth::user()): ?>
            <ul class="nav navbar-nav">
                <li class="active"><?php echo e(link_to_route('jobpost', 'Job Posting', [], ['class' => 'navbar-brand'])); ?></li>
                <!--li><a href="#">Link</a></li-->
            </ul>
            <?php endif; ?>
            <ul class="nav navbar-nav navbar-right">
                <?php if(Auth::user()): ?>
                    <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo e(Auth::user()->username); ?><span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <!--li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li-->
                            <li class="divider"></li>
                            <li><?php echo e(link_to_route('logout', 'Sign Out')); ?></li>
                        </ul>

                    </li>
                <?php else: ?>
                    <li><?php echo e(link_to_route('login', 'Log In')); ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>