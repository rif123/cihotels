
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list')?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li class="active"><?php echo lang('cities')?></li>
          </ol>
</section>



<section class="content">
         <div class="row">
		 	<div class="col-md-12">
				<div class="btn-group pull-right">
					<a class="btn btn-default" href="<?php echo site_url('admin/locations/country_form'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add_new_country');?></a>
	<a class="btn bg-purple" href="<?php echo site_url('admin/locations/zone_form'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add_new_region');?></a>
	<a class="btn bg-navy" href="<?php echo site_url('admin/locations/zone_area_form/'.$zone->id);?>"><i class="fa fa-plus"></i> <?php echo lang('add_new_city');?></a>
				</div>

			</div>
		 </div>
		 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Zone Areas</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
						
						<table class="table table-striped" cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<th><?php echo lang('name');?></th>
									
									<th></th>
								</tr>
							</thead>
							<tbody>
						<?php foreach ($areas as $location):?>
								<tr>
									<td><?php echo  $location->name; ?></td>
									<td>
										<div class="btn-group" style="float:right;">
											<a class="btn btn-primary" href="<?php echo  site_url('admin/locations/zone_area_form/'.$zone->id.'/'.$location->id); ?>"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
											<a class="btn btn-danger" href="<?php echo  site_url('admin/locations/delete_zone_area/'.$location->id); ?>" onclick="return areyousure(this);"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
										</div>
									</td>
							  </tr>
						<?php endforeach; ?>
						<?php if(count($areas) == 0):?>
								<tr>
									<td colspan="2">
										<?php echo lang('no_zone_areas');?>
									<td>
								</tr>
						<?php endif;?>
							</tbody>
						</table>						
				 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>

