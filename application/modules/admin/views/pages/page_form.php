<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/responsive-tabs.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/style.css')?>" rel="stylesheet" type="text/css" />
 <link type="text/css" href="<?php echo base_url('assets/admin/plugins/redactor/redactor.css');?>" rel="stylesheet" />
<?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/pages') ?>"> <?php echo lang('pages')?></a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('update');?></li>
          </ol>
</section>


<section class="content">
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
						<?php echo form_open('admin/pages/form/'.$id); ?>
						<div id="responsiveTabsDemo">
						<ul>
							<li><a href="#tab-1"> <?php echo lang('content');?> </a></li>
							<li><a href="#tab-2"> <?php echo lang('seo');?></a></li>
						</ul>
					
						<div id="tab-1"> 
								<fieldset>
										
										<div class="form-group">
											<label for="title"><?php echo lang('title');?></label>
											<?php
											$data	= array('name'=>'title', 'value'=>set_value('title', $title), 'class'=>'form-control');
											echo form_input($data);
											?>
										</div>
										<div class="form-group">
										  <div class="row">
											<div class="col-md-12">
										<label for="slug"><?php echo lang('slug');?></label>
										<?php
										$data	= array('name'=>'slug', 'value'=>set_value('slug', $slug), 'class'=>'form-control');
										echo form_input($data);
										?>
											</div>	
										  </div>		
										</div>
										<div class="form-group">
											  <div class="row">
												<div class="col-md-12">
													<label><?php echo lang('short_description') ?></label>
													<?php
														$data	= array('rows'=>'3','name'=>'short_description', 'value'=>set_value('short_description', @$short_description), 'class'=>'form-control ');
														echo form_textarea($data); ?>
												</div>	
											  </div>		
											</div>
											
										<div class="form-group">
											<label for="content"><?php echo lang('description');?></label>
											<?php
											$data	= array('name'=>'description', 'class'=>'redactor form-control', 'value'=>set_value('description', @$description));
											echo form_textarea($data);
											?>
									</fieldset>
						</div>
						<div id="tab-2">
							<fieldset>
									
									<div class="form-group">
										  <div class="row">
											<div class="col-md-12">
										<label for="code"><?php echo lang('seo_title');?></label>
										<?php
										$data	= array('name'=>'meta_title', 'value'=>set_value('meta_title', @$meta_title), 'class'=>'form-control');
										echo form_input($data);
										?>
											</div>	
										  </div>		
										</div>
										
										<div class="form-group">
										  <div class="row">
											<div class="col-md-12">
										<label for="slug"><?php echo lang('meta_description');?></label>
										<label><?php echo lang('meta');?></label>
										<?php
										$data	= array('rows'=>'3', 'name'=>'meta_description', 'value'=>set_value('meta_description', html_entity_decode(@$meta_description)), 'class'=>'form-control');
										echo form_textarea($data);
										?>
										
										<p class="help-block"><?php echo lang('meta_data_description');?></p>
											</div>	
										  </div>		
										</div>
										<div class="form-group">
										  <div class="row">
											<div class="col-md-12">
										<label><?php echo lang('meta_keywords');?></label>
										<?php
										$data	= array('rows'=>'3', 'name'=>'meta_keywords', 'value'=>set_value('meta_keywords', html_entity_decode(@$meta_keywords)), 'class'=>'form-control');
										echo form_textarea($data);
										?>
										
											</div>	
										  </div>		
										</div>
										
									
										
									</fieldset>
						</div>
					</div>
						<div class="form-actions" style="padding:20px;">
							<button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
						</div>	
						</form>
			
				 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
<script type="text/javascript" src="<?php echo base_url('assets/admin/plugins/redactor/redactor.min.js');?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/responsivetabs/jquery.responsiveTabs.min.js')?>" type="text/javascript"></script>
<script>
$(function() {
	$('#responsiveTabsDemo').responsiveTabs({
    	startCollapsed: 'accordion'
	});
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