 <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       <?php echo lang('my_profile')?>
    
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/dashboard')?>"><i class="fa fa-dashboard"></i> <?php echo lang('my_profile')?></a></li>
       
        <li class="active"><?php echo lang('my_profile')?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">
					<?php echo lang('my_profile')?>
                    </h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				<form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                       <div class="form-group">
					  <div class="row">
						<div class="col-md-6">
                      		<label><?php echo lang('firstname')?></label>
                      		<?php
								$data	= array('name'=>'firstname', 'value'=>set_value('firstname', $firstname), 'class'=>'form-control');
								echo form_input($data); ?>
						</div>	
					  	<div class="col-md-6">
                      		<label><?php echo lang('lastname')?></label>
                      		<?php
								$data	= array('name'=>'lastname', 'value'=>set_value('lastname', $lastname), 'class'=>'form-control');
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-6">
                      		<label><?php echo lang('username')?></label>
                      		<input type="hidden" name="oldusername" value="<?php echo $username?>" />
							<?php
								$data	= array('name'=>'username', 'value'=>set_value('username', $username), 'class'=>'form-control username');
								echo form_input($data); ?>
						</div>
						<div class="col-md-6">
                      		<label><?php echo lang('email')?></label>
                      		<input type="hidden" name="oldemail" value="<?php echo $email?>" />
							<?php
								$data	= array('name'=>'email', 'value'=>set_value('email', $email), 'class'=>'form-control');
								echo form_input($data); ?>
						</div>		
					  </div>		
                    </div>
						
					<div class="form-group">
					  <div class="row">
						<div class="col-md-6">
                      		<label><?php echo lang('password')?></label>
                      		<?php
								$data	= array('name'=>'password', 'class'=>'form-control');
								echo form_password($data); ?>
						</div>
						<div class="col-md-6">
                      		<label><?php echo lang('password_confirm') ?></label>
                      		<?php
								$data	= array('name'=>'confirm', 'class'=>'form-control');
								echo form_password($data); ?>
						</div>		
					  </div>		
                    </div>
				
					
					 
                    </div><!-- /.box-body -->
    				 <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
             <?php form_close()?>
            </div><!-- /.box -->
        </div>
     </div>
</section>  
<script>
$(".username").on('change, blur',function() {   
	 
	var username	=	$(this).val();
	   if(username){
	   call_loader();
		$.ajax({
			url: '<?php echo site_url('admin/account/check_username_user') ?>',
			type:'POST',
			data:{username:username},
			success:function(result){
				//alert(result);return false;
					$("#overlay1").remove();
				  if(result==1)
					{
						alert('Sorry..This Username Is Taken Try Again');
						$(".username").val(''); 
						$('#username-success').html('');
				   }
				   if(result==0)
					{
						alert('This Username Is Avaialable');
				    	$('#username-error').html('');
					}
							
			 }
		  });
	}
	
});
</script>