<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>/js/datepicker3.css"/>
<link rel="stylesheet" href="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/datepicker3.css" />

<!-- breadcrumbs -->
<div class="services-top-breadcrumbs">
	<div class="container">
		<div class="services-top-breadcrumbs-right">
			<ul>
				<li><a href="<?php echo site_url()?>">Home</a> <i>/</i></li>
				<li><?php echo lang('profile')?></li>
			</ul>
		</div>
		<div class="services-top-breadcrumbs-left">
			<h3><?php echo lang('profile')?></h3>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<!-- //breadcrumbs -->

<div class="testimonials">
    <div class="container">
        <div class="row">
			<h3><span><?php echo lang('profile')?></span></h3>
			<div class="panel-body margin-40-y">
			     <form method="post" enctype="multipart/form-data">
                      <div class="reservation">
                        <div class="reservation-grids">
            				<div class="reservation-grid-left">
            					<div class="keywords">
           							<?php
									   $data	= array('name'=>'firstname', 'placeholder'=>lang('firstname'), 'value'=>set_value('firstname', $firstname));
									   echo form_input($data); 
                                    ?>	
            					</div>
            				</div>
            				<div class="reservation-grid-right">
            					<div class="keywords">
           							<?php
									   $data	= array('name'=>'lastname', 'placeholder'=>lang('lastname'), 'value'=>set_value('lastname', $lastname));
									   echo form_input($data); 
                                    ?>	
            					</div>
            				</div>
            				<div class="clearfix"> </div>
            			</div>
            			<div class="reservation-grids">
            				<div class="reservation-grid-left">
            					<div class="section_room">
            						<select name="gender" id="country2" onchange="change_country(this.value)" class="frm-field required">
                                        <option hidden="hidden"><?php echo lang('gender') ?></option>
            							<option value="1" <?php echo ($gender==1)?'selected="selected"':'' ?> ><?php echo lang('male')?></option>
										<option value="2" <?php echo ($gender==2)?'selected="selected"':'' ?> ><?php echo lang('female')?></option>
            						</select>
            					</div>
            				</div>
            				<div class="reservation-grid-right">
            					<div class="keywords">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
           							<?php
									$data	= array('name'=>'dob', 'placeholder'=>lang('dob'), 'value'=>set_value('dob', $dob), 'class'=>'datepicker','autocomplete'=>'off');
									echo form_input($data); ?>
            					</div>
            				</div>
            				<div class="clearfix"> </div>
            			</div>
                        <div class="reservation-grids">
            				<div class="reservation-grid-left">
            					<div class="keywords">
           							<?php
									$data	= array('name'=>'email','placeholder'=>lang('email'), 'value'=>set_value('email', $email));
									echo form_input($data); ?>
									<input type="hidden" name="old_email" value="<?php echo $email?>" />
            					</div>
            				</div>
            				<div class="reservation-grid-right">
            					<div class="keywords">
           							<?php
									$data	= array('name'=>'mobile', 'placeholder'=>lang('mobile'), 'value'=>set_value('mobile', $mobile));
									echo form_input($data); ?>
            					</div>
            				</div>
            				<div class="clearfix"> </div>
            			</div>
                        <div class="reservation-grids">
            				<div class="reservation-grid-left">
            					<div class="keywords">
           							<?php
									$data	= array('name'=>'password', 'placeholder'=>lang('password'), 'value'=>set_value('password', $password));
									echo form_password($data); ?>
            					</div>
            				</div>
            				<div class="reservation-grid-right">
            					<div class="keywords">
           							<?php
									$data	= array('name'=>'confirm', 'placeholder'=>lang('password_confirm'), 'value'=>set_value('confirm_password'));
									echo form_password($data); 
                                    ?>
            					</div>
            				</div>
            				<div class="clearfix"> </div>
            			</div>
                        <div class="reservation-grids">
            				<div class="reservation-grid-left">
            					<div class="section_room">
            						<select name="country_id" id="country_id" onchange="change_country(this.value)" class="dropdown frm-field required">
                                        <option hidden="hidden"><?php echo lang('country') ?></option>
            							<?php foreach($countries as $cn){?>
										  <option value="<?php echo $cn->id?>" <?php echo ($country_id==$cn->id)?'selected="selected"':'' ?> ><?php echo $cn->name?></option>
                                        <?php } ?>
            						</select>
            					</div>
            				</div>
            				<div class="reservation-grid-right">
            					<div class="section_room">
            						<select name="region_id" id="region_id" onchange="change_country(this.value)" class="dropdown frm-field required">
                                        <option hidden="hidden"><?php echo lang('region') ?></option>
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
            				<div class="clearfix"> </div>
            			</div>
                        
                        
                        <div class="reservation-grids" style="margin-top: 15px;">
            				<div class="reservation-grid-left">
            					<div class="section_room keywords">
            						<select name="city_id" id="city_id" onchange="change_country(this.value)" class="dropdown frm-field required">
                                        <option hidden="hidden"><?php echo lang('city') ?></option>
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
            				</div>
            				<div class="reservation-grid-right">
                                <div class="keywords">
           							<?php
									$data	= array('name'=>'address','placeholder'=>lang('address'), 'value'=>set_value('address', $address));
									echo form_input($data); ?>
            					</div>
            				</div>
            				<div class="clearfix"> </div>
            			</div>
                        
                        
                        <div class="reservation-grids">
            				<div class="reservation-grid-left">
            					<div class="section_room">
            						<select name="id_type" id="id_type" onchange="change_country(this.value)" class="dropdown frm-field required">
                                        <option hidden="hidden"><?php echo lang('select_id_type') ?></option>
            							<option value="Passport" <?php echo ($id_type=="Passport")?'selected="selected"':'' ?> >Passport</option>
									    <option value="Driving License" <?php echo ($id_type=="Driving License")?'selected="selected"':'' ?> >Driving License</option>
									    <option value="Adhar Card" <?php echo ($id_type=="Adhar Card")?'selected="selected"':'' ?> >Adhar Card</option>
            						</select>
            					</div>
            				</div>
            				<div class="reservation-grid-right">
                                <div class="keywords">
           							<?php
									$data	= array('name'=>'id_no','placeholder'=>lang('id_no'), 'value'=>set_value('id_no', $id_no));
									echo form_input($data); ?>
            					</div>
            				</div>
            				<div class="clearfix"> </div>
            			</div>
                        
                        
                        <div class="reservation-grids">
            				<div class="reservation-grid-left">
            					<div class="keywords">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="file" name="id_upload"  />
    								        <input type="hidden" name="old_id" value="<?php echo $id_upload?>" />
                                        </div>
                                        <div class="col-md-6">
                                            <?php if(!empty($id_upload)){?>
        									   <a href="<?php echo base_url('assets/admin/uploads/ids/'.$id_upload)?>" class="btn btn-default" download><?php echo lang('download')?></a>
        									<?php } ?>
                                        </div>
                                    </div>
            					</div>
            				</div>
            				<div class="reservation-grid-right">
                                <div class="keywords">
           							<?php
									$data	= array('name'=>'remark','placeholder'=>lang('remark'), 'value'=>set_value('remark', $remark));
									echo form_input($data); ?>
            					</div>
            				</div>
            				<div class="clearfix"> </div>
            			</div>
                        
            			<div class="keywords">	
				   	         <input type="submit" value="<?php echo lang('update')?>"/>
            			</div>
            		</div>  
				</form>
			</div>
		  </div>
    </div>
</div>        

<script src="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>
<script>
$(function() {
	$('.datepicker').datepicker({
	      todayHighlight: true,
		autoclose: true,
	   format: 'yyyy-mm-dd',
    });
	
	$('#country_id').change(function(){
	  var c_id	=	$(this).val();
	  if(c_id){
		 call_loader();
		  $.ajax({
			url: '<?php echo site_url('front/account/get_states') ?>',
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
			url: '<?php echo site_url('front/account/get_cities') ?>',
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