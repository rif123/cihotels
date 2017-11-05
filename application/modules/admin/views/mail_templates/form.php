 <link type="text/css" href="<?php echo base_url('assets/admin/plugins/redactor/redactor.css');?>" rel="stylesheet" />
<?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
            
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/mail_templates') ?>"> <?php echo lang('mail_templates')?></a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('update');?></li>
          </ol>
</section>


<section class="content">
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
						<?php //echo form_open('admin/mail_templates/form/'.$id); ?>
						<form method="post" action="<?php echo site_url('admin/mail_templates/form/'.$id)?>">
							<div class="form-group">
							  <div class="row">
								<div class="col-md-12">
									<label for="name"><?php echo lang('name');?> </label>
										<?php
										$name_array = array('name' =>'name', 'class'=>'form-control', 'value'=>set_value('name', $name));
									
										echo form_input($name_array);?>
								</div>	
							  </div>		
							</div>
							
							<div class="form-group">
							  <div class="row">
								<div class="col-md-12">
								<label for="subject"><?php echo lang('subject');?> </label>
							<?php echo form_input(array('name'=>'subject', 'class'=>'form-control', 'value'=>set_value('subject', $subject)));?>
								</div>	
							  </div>		
							</div>
							
							<div class="form-group">
							  <div class="row">
								<div class="col-md-12">
								<label for="description"><?php echo lang('content');?></label>
							<textarea name="content" class="form-control redactor"><?php echo $content?></textarea>

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

<script type="text/javascript" src="<?php echo base_url('assets/admin/plugins/redactor/redactor.min.js');?>"></script>		
<script type="text/javascript">
	$('form').submit(function() {
		$('.btn').attr('disabled', true).addClass('disabled');
	});
$(function() {
	 $('.redactor').redactor({
			  // formatting: ['p', 'blockquote', 'h2','img'],
            minHeight: 200,
            imageUpload: '<?php echo site_url('/wysiwyg/upload_image');?>',
            fileUpload: '<?php echo site_url('/wysiwyg/upload_file');?>',
            imageGetJson: '<?php echo site_url('/wysiwyg/get_images');?>',
            imageUploadErrorCallback: function(json)
            {
                alert(json.error);
            },
            fileUploadErrorCallback: function(json)
            {
                alert(json.error);
            }
      });
});
	
</script>