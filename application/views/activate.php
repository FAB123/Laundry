<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<base href="<?php echo base_url();?>" />
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo 'dist/themes/' . (empty($this->config->item('theme')) ? 'default' : $this->config->item('theme')) . '/main.css' ?>"/>
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <title><?php echo $this->config->item('company') . ' | ' . $this->lang->line('common_powered_by') . ' SalesTime ' . $this->config->item('application_version') ?></title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>SalesTime</h1>
      </div>
      <div class="login-box">
		<?php echo form_open('login/do_activate', array('class' =>'login-form')) ?>
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-cog"></i>Activate !</h3>
		    <div class="form-group">
		    <label class="control-label"><?php echo $reg_key; ?></label>
			<label class="control-label"><?php echo $check_versiqon; ?></label>
          </div>
          <div class="form-group">
		    <input class="form-control" name="activation_key" id="activation_key" type="text" placeholder="<?php echo $this->lang->line('login_key')?>" autofocus>
          </div>

          <div class="form-group">
            <div class="utility">
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">About & Help?</a></p>
            </div>
			<div align="center" style="color:red"><?php echo validation_errors(); ?></div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i><?php echo $this->lang->line('login_send')?></button>
          </div>
        </form>
        <form class="forget-form" action="index.html">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>About & Help</h3>
          <div class="form-group">
            <label class="control-label">Dev : Fysal KT</label><br>
			<label class="control-label"> Al Hasib</label><br>
			<label class="control-label">Jeddha</label><br>
            <label class="control-label">Mob  : 0530829178</label><br>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
  </body>
</html>