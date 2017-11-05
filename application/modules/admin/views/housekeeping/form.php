<link href="<?php echo base_url('assets/admin/plugins/iCheck/all.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/select2/select2.min.css')?>" rel="stylesheet" type="text/css" />
  <?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/housekeeping') ?>"> <?php echo lang('housekeeping')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
				<form method="post" action="<?php echo site_url('admin/housekeeping/form/'.$id); ?>" enctype="multipart/form-data">	
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('room') ?></label>
                      		<select name="room_id" class="form-control select2">
									<option value="">--<?php echo lang('select_room')?>--</option>
									<?php foreach($rooms as $rm){?>
										<option value="<?php echo $rm->id?>" <?php echo ($rm->id==$room_id)?'selected="selected"':'';?> ><?php echo $rm->room_no?> (<?php echo $rm->room_type?>) - <?php echo $rm->floor?> </option>
									<?php } ?>
							</select>
						</div>	
					  </div>		
                    </div>
					<?php ///echo '<pre>-->'; print_r($housekeeping_status);die;?>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('housekeping_status') ?></label>
                      		<select name="housekeeping_status" class="form-control">
									<option value="">--<?php echo lang('select_housekeping_status')?>--</option>
									<?php foreach($housekeeping_status_all as $new){?>
										<option value="<?php echo $new->id?>" <?php echo ($new->id==$housekeeping_status)?'selected="selected"':'';?> ><?php echo $new->title?></option>
									<?php } ?>
							</select>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('room_availblity') ?></label>
                      		<input type="text" name="room_availblity" class="form-control"  value="<?php echo $room_availblity?>"/>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('remark') ?></label>
                      		<textarea name="remark" class="form-control"  ><?php echo $remark?></textarea>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('assigned_to') ?></label>
                      		<select name="assigned_to" class="form-control">
									<option value="">--<?php echo lang('select_employee')?>--</option>
									<?php foreach($employees as $new){?>
										<option value="<?php echo $new->id?>" <?php echo ($new->id==$assigned_to)?'selected="selected"':'';?> ><?php echo $new->firstname?> <?php echo $new->lastname?></option>
									<?php } ?>
							</select>
						</div>	
					  </div>		
                    </div>
					
					
					
					<div class="class="box-footer"">
							<input class="btn btn-primary" type="submit" value="Save"/>
					</div>
					</form>
     			 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/select2/select2.full.min.js')?>" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
     });
	 $(".select2").select2();
  	
		  
});
</script>