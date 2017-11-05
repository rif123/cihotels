<link rel="stylesheet" href="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/datepicker3.css"> 
<?php
$name			= array('name'=>'name', 'value' => set_value('name', $name),'class'=>'form-control');
$enable_date	= array('name'=>'enable_date', 'id'=>'enable_date', 'class'=>'datepicker form-control','value'=>set_value('enable_on', set_value('enable_date', $enable_date)));
$disable_date	= array('name'=>'disable_date', 'id'=>'disable_date', 'class'=>'datepicker form-control','value'=>set_value('disable_on', set_value('disable_date', $disable_date)));
$f_image		= array('name'=>'image', 'id'=>'image');
$link			= array('name'=>'link', 'value' => set_value('link', $link),'class'=>'form-control');	
$new_window		= array('name'=>'new_window', 'value'=>1, 'checked'=>set_checkbox('new_window', 1, $new_window));
?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
          
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/banners') ?>"> <?php echo lang('banners')?></a></li>
            <li class="active"><?php echo $page_title;?></li>
          </ol>
</section>


<section class="content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                     <?php echo form_open_multipart('admin/banners/banner_form/'.$banner_collection_id.'/'.$banner_id); ?>
						<div class="form-group">
						  <div class="row">
							<div class="col-md-4">
								<label for="name"><?php echo lang('name');?> / <?php echo lang('title');?></label>
								<?php echo form_input($name); ?>
							</div>	
						  </div>		
						</div>
						
						<div class="form-group">
						  <div class="row">
							<div class="col-md-4">
								<label for="name"><?php echo lang('heading');?> </label>
								<input type="text" name="heading" value="<?php echo $heading; ?>" class="form-control" />
							</div>	
						  </div>		
						</div>
						
						<div class="form-group">
						  <div class="row">
							<div class="col-md-4">
								<label for="name"><?php echo lang('description');?> </label>
								<textarea name="description" class="form-control"><?php echo $description;?></textarea>
							</div>	
						  </div>		
						</div>
						
						<div class="form-group">
						  <div class="row">
							<div class="col-md-4">
								<label for="link"><?php echo lang('link');?> </label>
						<?php echo form_input($link); ?>
							</div>	
						  </div>		
						</div>
						
						<div class="form-group">
						  <div class="row">
							<div class="col-md-4">
								<label for="enable_date"><?php echo lang('enable_date');?> </label>
								<?php echo form_input($enable_date); ?>
							</div>	
						  </div>		
						</div>
						
						<div class="form-group">
						  <div class="row">
							<div class="col-md-4">
								<label for="disable_date"><?php echo lang('disable_date');?> </label>
								<?php echo form_input($disable_date); ?>
							</div>	
						  </div>		
						</div>
						
						<div class="form-group">
						  <div class="row">
							<div class="col-md-4">
								<label class="checkbox" style="padding-left:18px;">
									<?php echo form_checkbox($new_window); ?> <?php echo lang('new_window');?>
								</label>
							</div>	
						  </div>		
						</div>
						
						<div class="form-group">
						  <div class="row">
							<div class="col-md-4">
								<label for="image"><?php echo lang('image');?> </label>
						<?php echo form_upload($f_image); ?>
					
						<?php if($banner_id && $image != ''):?>
						<div style="text-align:center; padding:5px; border:1px solid #ccc;"><img src="<?php echo base_url('assets/admin/uploads/banners/'.$image);?>" alt="current" style="height:180px; width:200px;"/><br/><?php echo lang('current_file');?></div>
						<?php endif;?>
							</div>	
						  </div>		
						</div>
						
						<div class="form-actions">
							<input class="btn btn-primary" type="submit" value="<?php echo lang('save');?>"/>
						</div>
					</form>

				
				 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
<script src="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>		
<script type="text/javascript">
	$(document).ready(function() {
		$('.datepicker').datepicker({
			todayHighlight: true,
			autoclose: true,
		   format: 'yyyy-mm-dd',
		});
	});
	
	$('form').submit(function() {
		$('.btn').attr('disabled', true).addClass('disabled');
	});
</script>
