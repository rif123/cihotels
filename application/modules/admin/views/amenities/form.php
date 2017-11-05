  <?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/amenities') ?>"> <?php echo lang('amenities')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
				<form method="post" action="<?php echo site_url('admin/amenities/form/'.$id); ?>" enctype="multipart/form-data">	
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('name') ?></label>
                      		<?php
								$data	= array('name'=>'name', 'value'=>set_value('name', $name), 'class'=>'form-control');
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('image') ?></label>
                      		<input type="file" name="image"   class="form-control"/>
						</div>	
						<div class="col-md-4">
							<?php if(!empty($image)){?>
								<img src="<?php echo base_url('assets/admin/uploads/amenities/'.$image)?>" height="100" width="80" />
							<?php } ?>
						</div>
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('description') ?></label>
                      		<?php
								$data	= array('name'=>'description', 'value'=>set_value('description', $description), 'class'=>'form-control');
								echo form_textarea($data); ?>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('active') ?></label> &nbsp; &nbsp; 
                      		<input type="checkbox" name="active" value="1" <?php echo ($active==1)?'checked="checked"':'';?> />
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
