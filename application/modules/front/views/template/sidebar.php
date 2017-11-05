<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url('assets/admin')?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
    
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="<?php echo site_url('admin/dashboard')?>"><i class="fa fa-dashboard"></i> <span><?php echo lang('dashboard');?></span></a></li>
		<li><a href="<?php echo site_url('admin/guests')?>"><i class="fa fa-users"></i> <span><?php echo lang('guests');?></span></a></li>
		<li><a href="<?php echo site_url('admin/room_types')?>"><i class="fa fa-home"></i> <span><?php echo lang('room_types');?></span></a></li>
		<li><a href="<?php echo site_url('admin/rooms')?>"><i class="fa fa-hotel"></i> <span><?php echo lang('rooms');?></span></a></li>
		<li><a href="<?php echo site_url('admin/services')?>"><i class="fa fa-chain"></i> <span><?php echo lang('paid_services');?></span></a></li>
		<li><a href="<?php echo site_url('admin/coupons')?>"><i class="fa fa-list-ol"></i> <span><?php echo lang('coupon_management');?></span></a></li>
		<li><a href="<?php echo site_url('admin/price_manager')?>"><i class="fa fa-inr"></i> <span><?php echo lang('price_manager');?></span></a></li>
		<li><a href="<?php echo site_url('admin/gallery')?>"><i class="fa fa-film"></i> <span><?php echo lang('gallery');?></span></a></li>
		<li><a href="<?php echo site_url('admin/housekeeping')?>"><i class="fa fa-home"></i> <span><?php echo lang('housekeeping');?></span></a></li>
		<li><a href="<?php echo site_url('admin/settings')?>"><i class="fa fa-cogs"></i> <span><?php echo lang('settings');?></span></a></li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span><?php echo lang('hr_management')?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li><a href="<?php echo site_url('admin/employees')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('employees');?></span></a></li>
			<li><a href="<?php echo site_url('admin/departments')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('departments');?></span></a></li>
			<li><a href="<?php echo site_url('admin/designation')?>"><i class="fa fa-circle-o"></i><span><?php echo lang('designations');?></span></a></li>
			  </ul>
        </li>
		<li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span><?php echo lang('masters')?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li><a href="<?php echo site_url('admin/floors')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('floors');?></span></a></li>
			<li><a href="<?php echo site_url('admin/languages')?>"><i class="fa fa-circle-o"></i><span><?php echo lang('languages');?></span></a></li>
			<li><a href="<?php echo site_url('admin/currency')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('currency');?></span></a></li>
			<li><a href="<?php echo site_url('admin/locations')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('locations');?></span></a></li>
			<li><a href="<?php echo site_url('admin/amenities')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('amenities');?></span></a></li>
			<li><a href="<?php echo site_url('admin/taxes')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('tax_manager');?></span></a></li>
			<li><a href="<?php echo site_url('admin/expenses_category')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('expenses_category');?></span></a></li>
			<li><a href="<?php echo site_url('admin/expenses')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('expenses');?></span></a></li>
		  	<li><a href="<?php echo site_url('admin/testimonials')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('testimonials');?></span></a></li>
			<li><a href="<?php echo site_url('admin/pages')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('pages');?></span></a></li>
			<li><a href="<?php echo site_url('admin/banners')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('banners');?></span></a></li>
			<li><a href="<?php echo site_url('admin/gallery_categories')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('gallery_categories');?></span></a></li>
			<li><a href="<?php echo site_url('admin/housekepping_status')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('housekeping_status');?></span></a></li>
		  </ul>
        </li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
  <?php 
			
				if($this->session->flashdata('message'))
						$message = $this->session->flashdata('message');
				  if($this->session->flashdata('error'))
						$error  = $this->session->flashdata('error');
					if(function_exists('validation_errors') && validation_errors() != '')
					{
						$error  = validation_errors();
					}
			?>
			
            <?php if(!empty($error) || !empty($message)){ ?>
			<div class="container">		
                    <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissable col-md-11">
                        <i class="fa fa-ban"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $error; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($message)): ?>
                    <div class="alert alert-info alert-dismissable col-md-11">
                        <i class="fa fa-info"></i>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                       <?php echo $message; ?>
                    </div>
                    <?php endif; ?>
                    
           </div>
           <?php }?>