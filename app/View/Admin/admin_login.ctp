<body>
        <!-- Login Background -->
        <div id="login-background">
            <!-- For best results use an image with a resolution of 2560x400 pixels (prefer a blurred image for smaller file size) -->
            <!--<img src="<?php //echo $this->webroot;?>img/placeholders/headers/login_header.jpg" alt="Login Background" class="animation-pulseSlow">-->
        </div>
        <!-- END Login Background -->

        <!-- Login Container -->
        <div id="login-container" class="animation-fadeIn">
            <!-- Login Title -->
            <div class="login-title text-center">
			<?php echo $this->Session->flash(); ?>
                <h1>
				<img  src="<?php  echo $this->webroot;?>img/meetup_logo.png" alt="logo">
				<br><strong>Please Login</strong></h1>
            </div>
            <!-- END Login Title -->

            <!-- Login Block -->
            <div class="block push-bit">
                <!-- Login Form -->
				
				<?php  echo $this->Form->create('User', array('type' => 'post', 'id'=>'form-login','class'=>'form-horizontal form-bordered form-control-borderless','url' => array('controller' => 'Admin', 'action' => 'login'))); ?>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
								<?php echo $this->Form->input('email', array('type' => 'text','name'=>'login-email','class'=>'form-control input-lg','placeholder'=>'Email','label'=>false)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
								<?php echo $this->Form->input('password', array('type' => 'password','name'=>'login-password','class'=>'form-control input-lg','placeholder'=>'Password','label'=>false)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-8 text-right">
							<?php echo $this->Form->button('Login to Dashboard', array('type' => 'submit','class'=>'btn btn-sm btn-primary','escape' => true));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center hide">
                            <a href="javascript:void(0)" id="link-reminder-login"><small>Forgot password?</small></a> 
                        </div>
                    </div>
               <?php echo $this->Form->end(); ?>
                <!-- END Login Form -->

                <!-- Reminder Form -->
				<?php  echo $this->Form->create('User', array('type' => 'post', 'id'=>'form-reminder','class'=>'form-horizontal form-bordered form-control-borderless display-none')); ?>
               
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
								<?php echo $this->Form->input('email', array('type' => 'text', 'id'=>'reminder-email' ,'name'=>'reminder-email','class'=>'form-control input-lg','placeholder'=>'Email','label'=>false)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-12 text-right">
							<?php echo $this->Form->button('Reset Password', array('type' => 'submit','class'=>'btn btn-sm btn-primary','escape' => true));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <small>Did you remember your password?</small> <a href="javascript:void(0)" id="link-reminder"><small>Login</small></a>
                        </div>
                    </div>
               <?php echo $this->Form->end(); ?>
                <!-- END Reminder Form -->
 
                <!-- Register Form -->
				<?php  echo $this->Form->create('User', array('type' => 'post', 'url' => array('controller' => 'Admin', 'action' => 'register'),'id'=>'form-register','class'=>'form-horizontal form-bordered form-control-borderless display-none')); ?>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-user"></i></span>
								<?php echo $this->Form->input('firstname', array('type' => 'text', 'id'=>'register-firstname' ,'name'=>'register-firstname','class'=>'form-control input-lg','placeholder'=>'Firstname','label'=>false)); ?>
                                
                            </div>
                        </div>
                        <div class="col-xs-6">
						<?php echo $this->Form->input('lastname', array('type' => 'text', 'id'=>'register-lastname' ,'name'=>'register-lastname','class'=>'form-control input-lg','placeholder'=>'Lastname','label'=>false)); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
								<?php echo $this->Form->input('email', array('type' => 'text', 'id'=>'register-email' ,'name'=>'register-email','class'=>'form-control input-lg','placeholder'=>'Email','label'=>false)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
								<?php echo $this->Form->input('password', array('type' => 'password', 'id'=>'register-password' ,'name'=>'register-password','class'=>'form-control input-lg','placeholder'=>'Password','label'=>false)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
								<?php echo $this->Form->input('password', array('type' => 'password','id'=>'register-password-verify' ,'name'=>'register-password-verify','class'=>'form-control input-lg','placeholder'=>'Verify Password','label'=>false)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <!--div class="col-xs-6">
                            <a href="#modal-terms" data-toggle="modal" class="register-terms">Terms</a>
                            <label class="switch switch-primary" data-toggle="tooltip" title="Agree to the terms">
                                <input type="checkbox" id="register-terms" name="register-terms">
                                <span></span>
                            </label>
                        </div-->
                        <div class="col-xs-6 text-right">
						<?php echo $this->Form->button('Register Account', array('type' => 'submit','class'=>'btn btn-sm btn-success','escape' => true));?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <small>Do you have an account?</small> <a href="javascript:void(0)" id="link-register"><small>Login</small></a>
                        </div>
                    </div>
                <?php echo $this->Form->end(); ?>
                <!-- END Register Form -->
            </div>
            <!-- END Login Block -->

              <?php echo $this->element('adminElements/footer'); ?>
        </div>
        <!-- END Login Container -->

        
        <!-- Load and execute javascript code used only in this page -->
        <script>$(function(){ Login.init(); });</script>
    </body>