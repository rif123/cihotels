<?php $admin	=	$this->session->userdata('admin');
$user	=	$this->auth->get_admin($admin['id']);
?>

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
          <p><?php echo $user->firstname?> <?php echo $user->lastname?> </p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
    
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="<?php echo ($this->uri->segment(2)=='dashboard')?'active':''?>"><a href="<?php echo site_url('admin/dashboard')?>"><i class="fa fa-dashboard"></i> <span><?php echo lang('dashboard');?></span></a></li>
		<li class="<?php echo ($this->uri->segment(2)=='bookings')?'active':''?>"><a href="<?php echo site_url('admin/bookings')?>"><i class="fa fa-list-alt"></i> <span><?php echo lang('bookings');?></span></a></li>
		<li class="<?php echo ($this->uri->segment(2)=='guests')?'active':''?>"><a href="<?php echo site_url('admin/guests')?>"><i class="fa fa-users"></i> <span><?php echo lang('guests');?></span></a></li>
		<li class="treeview <?php echo($this->uri->segment(2)=='room_types' || $this->uri->segment(2)=='rooms' || $this->uri->segment(2)=='services' ||$this->uri->segment(2)=='coupons' || $this->uri->segment(2)=='price_manager' || $this->uri->segment(2)=='floors' || $this->uri->segment(2)=='amenities')?'active':'';?>">
          <a href="#">
            <i class="fa fa-cubes"></i>
            <span><?php echo lang('hotel_configration')?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li class="<?php echo ($this->uri->segment(2)=='room_types')?'active':''?>"><a href="<?php echo site_url('admin/room_types')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('room_types');?></span></a></li>
      
      <li class="<?php echo $this->uri->segment(2) == 'building' ? 'active' : ''; ?>">
        <a href="<?php echo site_url('admin/building')?>">
          <i class="fa fa-circle-o"></i> 
            <span><?php echo lang('building');?></span>
          </a>
      </li>
     
		<li class="<?php echo ($this->uri->segment(2)=='rooms')?'active':''?>"><a href="<?php echo site_url('admin/rooms')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('rooms');?></span></a></li>
		<li class="<?php echo ($this->uri->segment(2)=='price_manager')?'active':''?>"><a href="<?php echo site_url('admin/price_manager')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('price_manager');?></span></a></li>
		<li class="<?php echo ($this->uri->segment(2)=='services')?'active':''?>"><a href="<?php echo site_url('admin/services')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('paid_services');?></span></a></li>
		<li class="<?php echo ($this->uri->segment(2)=='coupons')?'active':''?>"><a href="<?php echo site_url('admin/coupons')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('coupon_management');?></span></a></li>
		
		<li class="<?php echo ($this->uri->segment(2)=='floors')?'active':''?>"><a href="<?php echo site_url('admin/floors')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('floors');?></span></a></li>
			<li class="<?php echo ($this->uri->segment(2)=='amenities')?'active':''?>"><a href="<?php echo site_url('admin/amenities')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('amenities');?></span></a></li>
			<li class="<?php echo ($this->uri->segment(2)=='housekepping_status')?'active':''?>"><a href="<?php echo site_url('admin/housekepping_status')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('housekeping_status');?></span></a></li>
		  </ul>
        </li>
		<li class="<?php echo ($this->uri->segment(2)=='calendar')?'active':''?>"><a href="<?php echo site_url('admin/calendar')?>"><i class="fa fa-calendar"></i> <span><?php echo lang('availability_calendar');?></span></a></li>
		
		<li class="<?php echo ($this->uri->segment(2)=='housekeeping')?'active':''?> hide"><a href="<?php echo site_url('admin/housekeeping')?>"><i class="fa fa-home"></i> <span><?php echo lang('housekeeping');?></span></a></li>
		
		
		
		
		
		
		<li class="treeview <?php echo($this->uri->segment(2)=='reports')?'active':'';?>">
          <a href="#">
            <i class="fa fa-th-list"></i>
            <span><?php echo lang('reports')?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li class="<?php echo($this->uri->segment(3)=='occupancy')?'active':'';?>"><a href="<?php echo site_url('admin/reports/occupancy')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('occupancy');?></span></a></li>
			<li class="<?php echo($this->uri->segment(3)=='guest')?'active':'';?>"><a href="<?php echo site_url('admin/reports/guest')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('guest');?></span></a></li>
			<li class="<?php echo($this->uri->segment(3)=='financial')?'active':'';?>"><a href="<?php echo site_url('admin/reports/financial')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('financial');?></span></a></li>
			<li class="<?php echo($this->uri->segment(3)=='coupon')?'active':'';?>"><a href="<?php echo site_url('admin/reports/coupon')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('coupon');?></span></a></li>
			<li class="<?php echo($this->uri->segment(3)=='expenses')?'active':'';?>"><a href="<?php echo site_url('admin/reports/expenses')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('expenses');?></span></a></li>
			<li class="<?php echo($this->uri->segment(3)=='housekeeping')?'active':'';?>"><a href="<?php echo site_url('admin/reports/housekeeping')?>"><i class="fa fa-circle-o"></i> <span><?php echo "housekeeping";?></span></a></li>
		 </ul>
        </li>
		
		<li class="treeview <?php echo($this->uri->segment(2)=='employees' || $this->uri->segment(2)=='departments' ||$this->uri->segment(2)=='designation')?'active':'';?>">
          <a href="#">
            <i class="fa fa-users"></i>
            <span><?php echo lang('hr_management')?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li class="<?php echo($this->uri->segment(2)=='employees')?'active':'';?>"><a href="<?php echo site_url('admin/employees')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('employees');?></span></a></li>
			<li class="<?php echo($this->uri->segment(2)=='departments')?'active':'';?>"><a href="<?php echo site_url('admin/departments')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('departments');?></span></a></li>
			<li class="<?php echo($this->uri->segment(2)=='designation')?'active':'';?>"><a href="<?php echo site_url('admin/designation')?>"><i class="fa fa-circle-o"></i><span><?php echo lang('designations');?></span></a></li>
			  </ul>
        </li>
		
				<li class="<?php echo ($this->uri->segment(2)=='menus')?'active':''?>"><a href="<?php echo site_url('admin/menus')?>"><i class="fa fa-bars"></i> <span><?php echo lang('menus');?></span></a></li>
<li class="treeview <?php echo($this->uri->segment(2)=='settings' || $this->uri->segment(2)=='languages' || $this->uri->segment(2)=='currency' ||$this->uri->segment(2)=='locations'||$this->uri->segment(2)=='taxes'||$this->uri->segment(2)=='testimonials')?'active':'';?>">
          <a href="#">
            <i class="fa fa-cogs"></i>
            <span><?php echo lang('administrative')?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li class="<?php echo ($this->uri->segment(2)=='settings')?'active':''?>"><a href="<?php echo site_url('admin/settings')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('settings');?></span></a></li>
        
			<li class="<?php echo ($this->uri->segment(2)=='languages')?'active':''?>"><a href="<?php echo site_url('admin/languages')?>"><i class="fa fa-circle-o"></i><span><?php echo lang('languages');?></span></a></li>
			<li class="<?php echo ($this->uri->segment(2)=='currency')?'active':''?>"><a href="<?php echo site_url('admin/currency')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('currency');?></span></a></li>
			<li class="<?php echo ($this->uri->segment(2)=='locations')?'active':''?>"><a href="<?php echo site_url('admin/locations')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('locations');?></span></a></li>
			
			<li class="<?php echo ($this->uri->segment(2)=='taxes')?'active':''?>"><a href="<?php echo site_url('admin/taxes')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('tax_manager');?></span></a></li>
			<li class="<?php echo ($this->uri->segment(2)=='testimonials')?'active':''?>"><a href="<?php echo site_url('admin/testimonials')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('testimonials');?></span></a></li>
			
			
		  </ul>
        </li>
		<li class="treeview <?php echo($this->uri->segment(2)=='pages' || $this->uri->segment(2)=='mail_templates' || $this->uri->segment(2)=='banners' ||$this->uri->segment(2)=='gallery'||$this->uri->segment(2)=='gallery_categories')?'active':'';?>">
          <a href="#">
            <i class="fa fa-suitcase"></i>
            <span><?php echo lang('cms')?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li class="<?php echo ($this->uri->segment(2)=='pages')?'active':''?>"><a href="<?php echo site_url('admin/pages')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('pages');?></span></a></li>
			<li class="<?php echo ($this->uri->segment(2)=='banners')?'active':''?>"><a href="<?php echo site_url('admin/banners')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('banners');?></span></a></li>
		 	<li class="<?php echo ($this->uri->segment(2)=='gallery')?'active':''?>"><a href="<?php echo site_url('admin/gallery')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('gallery');?></span></a></li>
			<li class="<?php echo ($this->uri->segment(2)=='mail_templates')?'active':''?>"><a href="<?php echo site_url('admin/mail_templates')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('mail_templates');?></span></a></li>
		  </ul>
        </li>
		
		<li class="treeview <?php echo($this->uri->segment(2)=='expenses' || $this->uri->segment(2)=='expenses_category')?'active':'';?>">
          <a href="#">
            <i class="fa fa-tags"></i>
            <span><?php echo lang('expenses')?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li class="<?php echo ($this->uri->segment(2)=='expenses')?'active':''?>"><a href="<?php echo site_url('admin/expenses')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('expenses');?></span></a></li>
			<li class="<?php echo ($this->uri->segment(2)=='expenses_category')?'active':''?>"><a href="<?php echo site_url('admin/expenses_category')?>"><i class="fa fa-circle-o"></i> <span><?php echo lang('expenses_category');?></span></a></li>
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