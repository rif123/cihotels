
  <?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/housekeeping') ?>"> <?php echo lang('housekeeping')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('room_number') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php echo $housekeeping->room_number?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('room_type') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php echo $housekeeping->room_type?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('floor') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php echo $housekeeping->floor?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('housekeping_status') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php echo $housekeeping->status?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('room_availblity') ?></label>
                      	</div>
						<div class="col-md-3">
							<?php echo $housekeeping->room_availblity?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('remark') ?></label>
                      	</div>
						<div class="col-md-6">
							<?php echo $housekeeping->remark?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('assigned_to') ?></label>
                      	</div>
						<div class="col-md-6">
							<?php echo $housekeeping->firstname?> <?php echo $housekeeping->lastname?>
						</div>	
					  </div>		
                    </div>
					
     			 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
