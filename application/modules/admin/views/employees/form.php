<link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/daterangepicker/daterangepicker.css')?>">
<link href="<?php echo base_url('assets/admin/plugins/iCheck/all.css')?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/datepicker3.css"> 
<style>
.error{
    color: #FF0000;
}
#gender-error{
width:200px;
padding-top:15px;
}
</style>         

  <?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/employees') ?>"> <?php echo lang('employees')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
			  	 <div class="box-header">
                  <h3 class="box-title"><?php echo lang('employee_form'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					
				<form method="post" action="<?php echo site_url('admin/employees/form/'.$id); ?>" enctype="multipart/form-data" id="signup_form">	
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('title') ?></label>
                      	</div>
						<div class="col-md-3">
							<select name="title" class="form-control" id="title">
								<option value="">--<?php echo lang('select_title');?>--</option>
								<option value="<?php echo lang('mr');?>" <?php echo ($title==lang('mr'))?'selected="selected"':'';?> ><?php echo lang('mr');?></option>
								<option value="<?php echo lang('miss');?>" <?php echo ($title==lang('miss'))?'selected="selected"':'';?>><?php echo lang('miss');?></option>
							</select>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('gender') ?></label>
                      	</div>
						<div class="col-md-3">
							<select name="gender" class="form-control" id="gender">
								<option value="">--<?php echo lang('select_gender');?>--</option>
								<option value="<?php echo lang('male');?>" <?php echo ($gender==lang('male'))?'selected="selected"':'';?> ><?php echo lang('male');?></option>
								<option value="<?php echo lang('female');?>" <?php echo ($gender==lang('female'))?'selected="selected"':'';?>><?php echo lang('female');?></option>
							</select>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('firstname') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php
								$data	= array('name'=>'firstname', 'value'=>set_value('firstname', $firstname), 'class'=>'form-control', 'placeholder'=>'Firstname','id'=>'firstname',);
								echo form_input($data); ?>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('lastname') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php
								$data	= array('name'=>'lastname', 'value'=>set_value('lastname', $lastname), 'class'=>'form-control', 'placeholder'=>'Lastname','id'=>'lastname',);
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('username') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php if($id){?>
								<input type="text" name="username" class="form-control" value="<?php echo $username?>" disabled="disabled" />
							<?php }else{	$data	= array('name'=>'username', 'value'=>set_value('username', $username), 'class'=>'form-control', 'placeholder'=>'Username','id'=>'username',);
								echo form_input($data);
							} ?>
							<label id="username-error" class="error " for="username"></label>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('email') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php
								$data	= array('name'=>'email', 'value'=>set_value('email', $email), 'class'=>'form-control', 'placeholder'=>'Email','id'=>'email',);
								echo form_input($data); ?>
								<input type="hidden" name="old_email" value="<?php echo $email?>" />
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('password') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php
								$data	= array('name'=>'password', 'value'=>set_value('password'), 'class'=>'form-control', 'id'=>'password',);
								echo form_password($data); ?>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('password_confirm') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php
								$data	= array('name'=>'password_confirm', 'value'=>set_value('password_confirm'), 'class'=>'form-control', 'id'=>'password_confirm',);
								echo form_password($data); ?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('dob') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php
								$data	= array('name'=>'dob', 'value'=>set_value('dob', $dob), 'class'=>'form-control datepicker', 'placeholder'=>'Date of birth','id'=>'dob','autocomplete'=>'off');
								echo form_input($data); ?>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('phone') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php
								$data	= array('name'=>'phone', 'value'=>set_value('phone', $phone), 'class'=>'form-control', 'placeholder'=>'Phone','id'=>'phone',);
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('department') ?></label>
                      	</div>
						<div class="col-md-3">
							<select name="department_id" id="department_id" class="form-control">
								<option value="">--Select Department--</option>
								<?php foreach($departments as $dt){?>
									<option value="<?php echo $dt->id?>" <?php echo ($dt->id==$department_id)?'selected="selected"':'';?> ><?php echo $dt->name?></option>
								<?php } ?>
							</select>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('designation') ?></label>
                      	</div>
						<div class="col-md-3">
							<select name="designation_id" id="designation_id" class="form-control">
								<option value="">--Select Designation--</option>
								<?php foreach($designations as $dn){?>
									<option value="<?php echo $dn->id?>" <?php echo ($dn->id==$designation_id)?'selected="selected"':'';?> ><?php echo $dn->name?></option>
								<?php } ?>
							</select>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('country') ?></label>
                      	</div>
						<div class="col-md-3">
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
						<div class="col-md-3">
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
						<div class="col-md-3">
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
						<div class="col-md-3">
							<textarea name="address" class="form-control"><?php echo $address?></textarea>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('id') ?></label>
                      	</div>
						<div class="col-md-3">
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
						<div class="col-md-3">
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
						<div class="col-md-3">
							<input type="file" name="id_upload"  />
							<input type="hidden" name="old_id" value="<?php echo $id_upload?>" />
							<?php if(!empty($id_upload)){?>
								<a href="<?php echo base_url('assets/admin/uploads/ids/'.$id_upload)?>" class="btn btn-default" download><?php echo lang('download')?></a>
								<?php } ?>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('remark') ?></label>
                      	</div>
						<div class="col-md-3">
							<textarea name="remarks" class="form-control"><?php echo $remarks?></textarea>
						</div>		
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('join_date') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php
								$data	= array('name'=>'join_date', 'value'=>set_value('join_date', $join_date), 'class'=>'form-control datepicker', 'placeholder'=>'Date Of Joining','id'=>'join_date');
								echo form_input($data); ?>
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('salary') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php
								$data	= array('name'=>'salary', 'value'=>set_value('salary', $salary), 'class'=>'form-control', 'placeholder'=>'Salary','id'=>'salary',);
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
						<div class="row">
								<div class="col-md-2">
									<label><?php echo lang('salary') ?></label>
								</div>
								<div class="col-md-3">
								  <input type="text" name="shift" class="form-control " id="reservationtime" value="<?php echo set_value('shift',$shift)?>" autocomplete='off'>
								</div>
								<!-- /.input group -->
							</div>
						</div>
					</div>
					<div class="box-footer">
							<input class="btn btn-primary" type="submit" value="Save"/>
					</div>
					</form>
     			 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url('assets/admin/plugins/daterangepicker/daterangepicker.js')?>"></script>

<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>" type="text/javascript"></script>				
<script src="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url('assets/admin/plugins')?>/jquery-validation/jquery.validate.min.js"></script>
<script>
$(function() {
	$('#reservationtime').daterangepicker({
        timePicker: true,
		timePickerIncrement: 5,
        locale: {
            format: 'YYYY-MM-DD h:mm A'
        }
    });
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
		$.validator.setDefaults({ ignore: ":hidden:not(select)" });
			$('#username-error').hide();
			$('#email-error').hide();
			$('#contact-error').hide();
			$("#signup_form").validate({
					//{
				   //errorElement: "div",
                    //place all errors in a <div id="errors"> element
                    //errorPlacement: function(error, element) {
                      //  error.appendTo("div#errors");
                    //}, 
				  rules: {
					firstname: { required: true},
					title: { required: true},
					lastname: { required: true},
					username: { required: true ,minlength: 4},
					email: { required: true ,email: true},
					phone: { required: true},
				<?php if($id){?>
					password: {minlength: 4},
					password_confirm: { equalTo: "#password" },
				<?php } else {?>
					password: { required: true ,minlength: 4},
					password_confirm: { required: true, equalTo: "#password" },
				<?php } ?>	
					
					gender: { required: true},
					dob: {required:true},
					city_id: {required:true},
					region_id: {required:true},
					address: {required:true},
				  	country_id: {required:true},
					department_id: {required:true},
					designation_id: {required:true},
					id_type: {required:true},
					id_no: {required:true},
				  },messages: {
                        name: {
                            required: "You must select title",
                        },
						name: {
                            required: "You must enter firstname",
                        },
						last: {
                            required: "You must enter lastname ",
                        },
						
						username: {
                            required: "You must enter username",
                            minlength: "Username must be at least 4 characters long",
						},  
						email: {
                            required: "You must enter email",
                         
                        }, 
						password: {
                            required: "You must enter password",
                         	minlength: "Password must be at least 4 characters long"
                        },
						password_confirm: {
                            required: "You must re-enter password ",
							equalTo: "Confirm passsword not macthed to Password",
						},
						phone: {
                            required: "You must enter phone",
                         
                        },
						gender: {
                            required: "You must select gender",
                         
                        },
						dob: {
                            required: "You must enter date of birth",
                         
                        },
						city_id: {
                            required: "You must select your city",
                         
                        },
						country_id: {
                            required: "You must enter Country",
                         
                        },
						region_id: {
                            required: "You must enter Region",
                         
                        },
						address: {
                            required: "You must enter address",
                         
                        },
						department_id: {
                            required: "You must select Department",
                         
                        },
						designation_id: {
                            required: "You must select Designation",
                         
                        },
						id_type: {
                            required: "You must select Id",
                         
                        },
						id_no: {
                            required: "You must enter Id number",
                         
                        },
                    },submitHandler: function(form) {
						// do other things for a valid form
						form.submit();
					  }
			});
			
				$("#signup_form").validate({ 
					submitHandler: function(form) {  
										   if ($(form).valid()) 
											   form.submit(); 
										   return false; // prevent normal form posting
									}
				 });
			
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
$("#username").on('blur',function() {   
    var val = $('#username').val();
     if(val){
	 	$.ajax({
		url: '<?php echo site_url('admin/employees/check_username') ?>',
		type:'POST',
		data:{username:val},
		success:function(result){
		  
		  if(result==1){
		  	$('#username').val('');
			$('#username').focus();
			$('#username-error').show();
			$('#username-error').html('This Username Is Exists Try Again..');
		  }
		  
		}
	  });
	 }     
}); 
	
</script>