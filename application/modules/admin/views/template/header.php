<?php $admin	=	$this->session->userdata('admin');
$user	=	$this->auth->get_admin($admin['id']);
$this->load->model(array('language_model','booking_model'));
$langs	= $this->language_model->get_all();
$new_booking		= $this->booking_model->get_all_new();
$new_canceled		= $this->booking_model->get_canceled_new();
//echo '<pre>'; print_r($new_canceled);die;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->setting->name?> | <?php echo @$page_title?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin')?>/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin')?>/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin')?>/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
	    <link type="text/css" href="<?php echo base_url('assets/admin/plugins/toastr/toastr.min.css');?>" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo base_url('assets/admin')?>/dist/css/skins/_all-skins.min.css">
  <link href="<?php echo base_url('assets/admin/plugins/alertify/alertify.min.css')?>" rel="stylesheet" type="text/css" />
 <script src="<?php echo base_url('assets/admin')?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
 <script src="<?php echo base_url('assets/admin/plugins/alertify/alertify.min.js')?>"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
#overlay1 {
	position: fixed;
	left: 0;
	top: 0;
	bottom: 0;
	right: 0;
	background: #ffffff;
	opacity: 0.7;
	filter: alpha(opacity=80);
	-moz-opacity: 0.6;
	z-index: 10000;
}
</style> 

  <script>
  function areyousure(e){
			event.preventDefault();
			alertify.confirm("This post will be deleted and you won't be able to find it anymore.",
				function(){
					var href = $(this).attr('href');
					//alert(e);
					window.location = e;
					//alertify.success('Ok');
					return true;
				},
				function(){
					//alertify.error('Cancel');
					return true;
			});
			//return false;
		}
	</script>	
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="<?php echo base_url('admin'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><?php echo $this->setting->name?></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo $this->setting->name?></b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
             <i class="fa fa-language"></i>
            </a>
            <ul class="dropdown-menu">
              <?php /*?><li class="header">You have 10 notifications</li><?php */?>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li class="lang" id="0">
                    <a href="#">
					<img src="<?php echo base_url('assets/admin/uploads/languages/eng.png')?>" class="img-circle" height="32" width="32" alt="User Image"/> English
                    </a>
                  </li>
                  <?php foreach ($langs as $new){ ?>
				  	<li class="lang" id="<?php echo $new->id?>">
                    <a href="#" >
					<img src="<?php echo base_url('assets/admin/uploads/languages/'.$new->flag)?>" class="img-circle" height="32" width="32" alt="User Image"/> <?php echo $new->name?>
                    </a>
                  </li>
				  <?php } ?>
                </ul>
              </li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?php echo lang('new')?>">
              <i class="fa fa-flag-o"></i>
              <?php if(count($new_booking) > 0){?>
			  <span class="label label-danger"><?php echo count($new_booking)?></span>
			  <?php } ?>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><?php echo lang('you_have')?> <?php echo count($new_booking)?> <?php echo lang('new')?> <?php echo lang('bookings')?></li>
              <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <?php foreach($new_booking as $booking){?>
					  <li>
                        <a href="<?php echo site_url('admin/bookings/booking/'.$booking->id)?>">
                          #<?php echo $booking->order_no?> <?php echo lang('for')?> <?php echo $booking->room?> <?php echo ($booking->payment_status==1)?lang('success'):''?> <?php echo ($booking->payment_status==2)?lang('pending'):''?><?php echo ($booking->payment_status==0)?lang('failed'):'';?>
                        </a>
                      </li>
					  <?php } ?>
                    </ul>
                  </li>
			  <li class="footer">
                <a href="<?php echo site_url('admin/bookings/newbookings')?>"><?php echo lang('view_all');?> <?php echo lang('bookings');?></a>
              </li>
            </ul>
          </li>
		  
		  
		  <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?php echo lang('new')?> <?php echo lang('canceled_booking')?>">
              <i class="fa fa-bullhorn"></i>
              <?php if(count($new_canceled) > 0){?>
			  <span class="label label-danger"><?php echo count($new_canceled)?></span>
			  <?php } ?>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><?php echo lang('you_have')?> <?php echo count($new_canceled)?> <?php echo lang('new')?> <?php echo lang('canceled_booking')?></li>
              <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <?php foreach($new_canceled as $booking){?>
					  <li>
                        <a href="<?php echo site_url('admin/bookings/booking/'.$booking->id)?>">
                          #<?php echo $booking->order_no?> <?php echo lang('for')?> <?php echo $booking->room?> <?php echo ($booking->payment_status==1)?lang('success'):''?> <?php echo ($booking->payment_status==2)?lang('pending'):''?><?php echo ($booking->payment_status==0)?lang('failed'):'';?> <?php echo ($booking->payment_status==3)?lang('partialy_paid'):'';?>
                        </a>
                      </li>
					  <?php } ?>
                    </ul>
                  </li>
			  <li class="footer">
                <a href="<?php echo site_url('admin/bookings/newcanceled')?>"><?php echo lang('view_all');?> <?php echo lang('canceled_booking');?></a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url('assets/admin')?>/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $user->firstname?> <?php echo $user->lastname?> </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url('assets/admin')?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $user->firstname?> <?php echo $user->lastname?> 
                  <small></small>
                </p>
              </li>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo site_url('admin/account/profile')?>" class="btn btn-default btn-flat"><?php echo lang('profile')?></a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo site_url('admin/login/logout')?>" class="btn btn-default btn-flat"><?php echo lang('signout')?></a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
  </header>
