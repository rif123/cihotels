  <?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/testimonials') ?>"> <?php echo lang('testimonials')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
				<form method="post" action="<?php echo site_url('admin/testimonials/form/'.$id); ?>" enctype="multipart/form-data">	
				<input  type="hidden" name="rating" id="rating" value="<?php echo $rating?>" />
				<input  type="hidden" name="old_auther_image" value="<?php echo $auther_image?>" />
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('auther_name') ?></label>
                      		<?php
								$data	= array('name'=>'auther_name', 'value'=>set_value('auther_name', $auther_name), 'class'=>'form-control');
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('auther_image') ?></label>
                      		<input type="file" name="auther_image" class="form-control" />
						</div>	
					  	<div class="col-md-4">
							<img src="<?php echo base_url('assets/admin/uploads/images/'.$auther_image)?>" height="120" width="140" />
						</div>
					  </div>		
                    </div>
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
                      		<label><?php echo lang('testimonial') ?></label>
                      		<textarea name="testimonial" class="form-control"><?php echo set_value('testimonial',$testimonial)?></textarea>
						</div>	
						
					  </div>		
                    </div>
					 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-4">
                                	<b><?php echo lang('rating')?></b>
								    <div id="jRate" > </div>
                                </div>
                            </div>
                        </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('country') ?></label>
                      		<?php
								$data	= array('name'=>'country', 'value'=>set_value('country', $country), 'class'=>'form-control');
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>			
					<div class="class="box-footer"">
							<input class="btn btn-primary" type="submit" value="<?php echo lang('save')?>"/>
					</div>
					</form>
     			 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
<script src="<?php echo base_url('assets/admin/plugins/jrate/jRate.min.js')?>" type="text/javascript"></script>
<script>
$(function() {
	//Jrate
	$("#jRate").jRate({
		startColor: '#3c8dbc',
			endColor: '#3c8dbc',
			width: 30,
			height: 30,
			precision: 0.5,
			<?php 
			if(!empty($rating)){
			echo  'rating:'.$rating.',';
			}  ?>
			onSet: function(ratings) {
				$('#rating').val(ratings);
				
			}
			//rating: <?php //echo (@$avg)?$avg:0;?>,
			
	});
});

</script>