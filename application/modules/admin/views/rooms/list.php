<link href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />

<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list'); ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
            <li class="active"><?php echo lang('rooms'); ?></li>
          </ol>
</section>


<section class="content">

         <div class="row">
		 	<div class="col-md-12" style="padding:20px;">
				<div class="btn-group pull-right">
					<a class="btn btn-success" href="<?php echo site_url('admin/rooms/form'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add')?></a>
				</div>

			</div>
		 </div>
		 
		 <div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <div class="info-box">
				<span class="info-box-icon bg-aqua"><i class="fa fa-leaf"></i></span>
	
				<div class="info-box-content">
				  <span class="info-box-text"><?php echo lang('rooms')?></span>
				  <span class="info-box-number"><?php echo $states->total_rooms?></span>
				</div>
				<!-- /.info-box-content -->
			  </div>
			  <!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <div class="info-box">
				<span class="info-box-icon bg-red"><i class="fa fa-server"></i></span>
	
				<div class="info-box-content">
				  <span class="info-box-text"><?php echo lang('floors')?></span>
				  <span class="info-box-number"><?php echo count($floors)?></span>
				</div>
				<!-- /.info-box-content -->
			  </div>
			  <!-- /.info-box -->
			</div>
			<!-- /.col -->
	
			<!-- fix for small devices only -->
			<div class="clearfix visible-sm-block"></div>
	
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <div class="info-box">
				<span class="info-box-icon bg-green"><i class="fa fa-indent "></i></span>
	
				<div class="info-box-content">
				  <span class="info-box-text"><?php echo lang('room_types')?></span>
				  <span class="info-box-number"><?php echo count($room_types)?></span>
				</div>
				<!-- /.info-box-content -->
			  </div>
			  <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><?php echo lang('booked_room_today')?></span>
              <span class="info-box-number"><?php echo count($booked_rooms_today)?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('rooms'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
				
				
						<table class="table table-striped" id="example1">
							<thead >
								<tr>
									<th>#</th>
									<th><?php echo lang('room_number'); ?></th>
									<th><?php echo lang('room_type'); ?></th>
									<th><?php echo lang('floor_number'); ?></th>
									<th><?php echo lang('action'); ?></th>
								</tr>
							</thead>
							
							<tbody >
						<?php if($rooms):?>		
						<?php $i=1;foreach ($rooms as $new):?>
								<tr>
									<td><?php echo $i;?></td>
									<td class="gc_cell_left" ><?php echo  $new->room_no; ?></td>
									<td><?php echo  $new->room_type; ?></td>
									<td><?php echo  $new->floor_no; ?> - <?php echo  $new->floor; ?></td>
									<td>
										<div class="btn-group" style="float:right">
											<a class="btn btn-info " href="<?php echo site_url('admin/rooms/housekeeping/'.$new->id); ?>"><i class="fa fa-home"></i> <?php echo lang('housekeeping')?></a>
											<a class="btn btn-default hide" href="<?php echo site_url('admin/rooms/view/'.$new->id); ?>"><i class="fa fa-eye"></i> <?php echo lang('view')?></a>
											<a class="btn btn-primary" href="<?php echo site_url('admin/rooms/form/'.$new->id); ?>"><i class="fa fa-edit"></i> <?php echo lang('edit')?></a>
											
											
											<a class="btn btn-danger" href="<?php echo site_url('admin/rooms/delete/'.$new->id); ?>" onclick="return areyousure(this);"><i class="fa fa-trash"></i> <?php echo lang('delete')?></a>
										</div>
									</td>
								</tr>
						<?php $i++; endforeach;?>
						<?php endif?>
							</tbody>
						</table>

				 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>

<script src="<?php echo base_url('assets/admin/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
	
});

</script>
