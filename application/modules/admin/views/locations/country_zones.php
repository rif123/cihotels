<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/locations') ?>"> <?php echo lang('countries') ?></a></li>
            <li class="active"><?php echo lang('regions')?></li>
          </ol>
</section>



<section class="content">
         <div class="row">
		 	<div class="col-md-12">
				<div class="btn-group pull-right">
					<a class="btn btn-default" href="<?php echo site_url('admin/locations/country_form'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add_new_country');?></a>
	<a class="btn bg-navy" href="<?php echo site_url('admin/locations/zone_form'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add_new_region');?></a>
				</div>

			</div>
		 </div>
		 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo $page_title; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
							
					<table class="table table-striped">
						<thead>
							<tr>
								<th><?php echo lang('name');?></th>
								<th class="gc_cell_right"></th>
							</tr>
						</thead>
						<tbody>
					<?php foreach ($zones as $location):?>
							<tr>
								<td class="gc_cell_left"><?php echo  $location->name; ?></td>
								<td>
									<div class="btn-group" style="float:right;">
										<a class="btn btn-default" href="<?php echo site_url('admin/locations/zone_form/'.$location->id); ?>"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
										<a class="btn bg-purple" href="<?php echo site_url('admin/locations/zone_areas/'.$location->id); ?>"><i class="fa fa-map-marker"></i> <?php echo lang('cities');?></a>
										<a class="btn btn-danger" href="<?php echo site_url('admin/locations/delete_zone/'.$location->id); ?>" onclick="return areyousure(this);"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
									</div>
								</td>
						  </tr>
					<?php endforeach; ?>
						</tbody>
					</table>
				 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
