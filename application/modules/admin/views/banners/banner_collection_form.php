<?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/banners') ?>"> <?php echo lang('banners')?></a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('update');?></li>
          </ol>
</section>


<section class="content">
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
						<?php
							$name			= array('name'=>'name', 'value' => set_value('name', $name),'class'=>'form-control');
							?>
							
							<?php echo form_open_multipart('admin/banners/banner_collection_form/'.$banner_collection_id); ?>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                							<label for="title"><?php echo lang('name');?> </label>
								<?php echo form_input($name); ?>
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

