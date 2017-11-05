<link href="<?php echo base_url('assets/admin/plugins/iCheck/all.css')?>" rel="stylesheet" type="text/css" />
  <?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/housekepping_status') ?>"> <?php echo lang('housekeping_status')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
				<form method="post" action="<?php echo site_url('admin/housekepping_status/form/'.$id); ?>" enctype="multipart/form-data">	
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('title') ?></label>
                      		<?php
								$data	= array('name'=>'title', 'value'=>set_value('title', $title), 'class'=>'form-control');
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
					
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('short_description') ?></label>
                      		<?php
								$data	= array('name'=>'short_description', 'value'=>set_value('short_description', $short_description), 'class'=>'form-control');
								echo form_textarea($data); ?>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('status') ?></label> &nbsp; &nbsp; 
                      		<input type="radio" name="status" value="0" <?php echo ($status==0)?'checked="checked"':''?>  /> <?php echo lang('inactive')?> &nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="status" value="1" <?php echo ($status==1)?'checked="checked"':''?> /> <?php echo lang('active')?>
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
<script>
$(document).ready(function(){
	$('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
     });
  	
		  
});
</script>