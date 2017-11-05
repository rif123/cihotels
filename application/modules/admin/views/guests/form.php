<link href="<?php echo base_url('assets/admin/plugins/iCheck/all.css')?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/datepicker3.css">  <?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/guests') ?>"> <?php echo lang('guests')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					<div class="box-header">
					  <h3 class="box-title"><?php echo lang('guest_form'); ?></h3>
					</div><!-- /.box-header -->
				<form method="post" action="<?php echo site_url('admin/guests/form/'.$id); ?>" enctype="multipart/form-data">	
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('firstname') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php
								$data	= array('name'=>'firstname', 'value'=>set_value('firstname', $firstname), 'class'=>'form-control');
								echo form_input($data); ?>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('lastname') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php
								$data	= array('name'=>'lastname', 'value'=>set_value('lastname', $lastname), 'class'=>'form-control');
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('gender') ?></label>
                      	</div>
						<div class="col-md-4">
								<select name="gender" class="form-control">
									<option value="">--<?php echo lang('select_gender')?></option>
									<option value="1" <?php echo ($gender==1)?'selected="selected"':'' ?> ><?php echo lang('male')?></option>
									<option value="2" <?php echo ($gender==2)?'selected="selected"':'' ?> ><?php echo lang('female')?></option>
								</select>	
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('dob') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php
								$data	= array('name'=>'dob', 'value'=>set_value('dob', $dob), 'class'=>'form-control datepicker','autocomplete'=>'off');
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('email') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php
								$data	= array('name'=>'email', 'value'=>set_value('email', $email), 'class'=>'form-control');
								echo form_input($data); ?>
								<input type="hidden" name="old_email" value="<?php echo $email?>" />
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('mobile') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php
								$data	= array('name'=>'mobile', 'value'=>set_value('mobile', $mobile), 'class'=>'form-control');
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('password') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php
								$data	= array('name'=>'password', 'value'=>set_value('password', $password), 'class'=>'form-control');
								echo form_password($data); ?>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('password_confirm') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php
								$data	= array('name'=>'confirm', 'value'=>set_value('confirm_password'), 'class'=>'form-control');
								echo form_password($data); ?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('country') ?></label>
                      	</div>
						<div class="col-md-4">
							<select name="country_id" class="form-control"  id="country_id">
								<option value="">--<?php echo lang('select_country')?></option>
								<?php foreach($countries as $cn){?>
									<option value="<?php echo $cn->id?>" <?php echo ($country_id==$cn->id)?'selected="selected"':'' ?> ><?php echo $cn->name?></option>
								<?php } ?>
							</select>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('region') ?></label>
                      	</div>
						<div class="col-md-4">
							<select name="region_id" class="form-control"  id="region_id">
								<option value="">--<?php echo lang('select_region')?></option>
								<?php 
									if(!empty($country_id)){
										$states		=	$this->location_model->get_zones($country_id);
										foreach($states as $st){?>
									<option value="<?php echo $st->id?>" <?php echo ($state_id==$st->id)?'selected="selected"':'' ?> ><?php echo $st->name?></option>
								<?php 	} 
									}
								?>
							</select>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('city') ?></label>
                      	</div>
						<div class="col-md-4">
							<select name="city_id" class="form-control"  id="city_id">
								<option value="">--<?php echo lang('select_city')?></option>
								<?php 
									if(!empty($state_id)){
										$cities		=	$this->location_model->get_zone_areas($state_id);
										foreach($cities as $ct){?>
									<option value="<?php echo $ct->id?>" <?php echo ($city_id==$ct->id)?'selected="selected"':'' ?> ><?php echo $ct->name?></option>
								<?php 	} 
									}
								?>
							</select>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('address') ?></label>
                      	</div>
						<div class="col-md-4">
							<textarea name="address" class="form-control"><?php echo $address?></textarea>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('id') ?></label>
                      	</div>
						<div class="col-md-4">
							<select name="id_type" class="form-control"  id="id_type">
								<option value="">--<?php echo lang('select_id_type')?>--</option>
								<option value="Passport" <?php echo ($id_type=="Passport")?'selected="selected"':'' ?> >Passport</option>
								<option value="Driving License" <?php echo ($id_type=="Driving License")?'selected="selected"':'' ?> >Driving License</option>
								<option value="Adhar Card" <?php echo ($id_type=="Adhar Card")?'selected="selected"':'' ?> >Adhar Card</option>
							</select>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('id_no') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php
								$data	= array('name'=>'id_no', 'value'=>set_value('id_no', $id_no), 'class'=>'form-control');
								echo form_input($data); ?>
								
						</div>		
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('id_upload') ?></label>
                      	</div>
						<div class="col-md-4">
							<input type="file" name="id_upload"  />
							<input type="hidden" name="old_id" value="<?php echo $id_upload?>" />
							<?php if(!empty($id_upload)){?>
								<a href="<?php echo base_url('assets/admin/uploads/ids/'.$id_upload)?>" class="btn btn-default" download><?php echo lang('download')?></a>
								<?php } ?>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('remark') ?></label>
                      	</div>
						<div class="col-md-4">
							<textarea name="remark" class="form-control"><?php echo $remark?></textarea>
						</div>		
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('vip') ?></label>
                      	</div>
						<div class="col-md-4">
							<input type="checkbox" name="vip" value="1" <?php echo ($vip==1)?'checked="checked"':''?> />
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
<script src="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>
<script>
$(function() {
	$('.datepicker').datepicker({
      	todayHighlight: true,
		autoclose: true,
	   format: 'yyyy-mm-dd',
    });
	$('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
     });

	$('#country_id').change(function(){
	  var c_id	=	$(this).val();
	  if(c_id){
		 call_loader();
		  $.ajax({
			url: '<?php echo site_url('admin/guests/get_states') ?>',
			type:'POST',
			data:{country_id:c_id},
			success:function(result){
				remove_loader();
				$("#region_id").html('');
				$("#region_id").html(result);
				
			 }
		  });
	  }  
	});
	$('#region_id').change(function(){
	  var c_id	=	$(this).val();
	  if(c_id){
		 call_loader();
		  $.ajax({
			url: '<?php echo site_url('admin/guests/get_cities') ?>',
			type:'POST',
			data:{state_id:c_id},
			success:function(result){
				remove_loader();
				$("#city_id").html('');
				$("#city_id").html(result);
				
			 }
		  });
	  }  
	});

});	


</script>