<?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/locations') ?>"> <?php echo lang('countries') ?></a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('update');?></li>
          </ol>
</section>

<section class="content">
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					<?php echo form_open('admin/locations/zone_form/'.$id); ?>

						<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
										<label for="country_id"><?php echo lang('country');?></label>
										<?php
										
										$country_ids	= array();
										foreach($countries as $c)
										{
											$country_ids[$c->id] = $c->name;
										}
										
										?>
										<?php echo form_dropdown('country_id', $country_ids, set_value('country_id', $country_id) ,'class="form-control"');?>
								</div>	
							  </div>		
							</div>
							
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
									<label for="name"><?php echo lang('name');?></label>
						<?php
						$data	= array('id'=>'name', 'name'=>'name', 'value'=>set_value('name', $name), 'class'=>'form-control');
						echo form_input($data);
						?>
								</div>	
							  </div>		
							</div>
							
						
						<div class="form-actions">
							<button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
						</div>
					</form>



				 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>




<script type="text/javascript">
$('form').submit(function() {
	$('.btn').attr('disabled', true).addClass('disabled');
});
</script>