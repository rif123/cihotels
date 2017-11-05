<link href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />

<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list'); ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
            <li class="active"><?php echo lang('guests'); ?></li>
          </ol>
</section>


<section class="content">
         <div class="row">
		 	<div class="col-md-12" style="padding-bottom:10px;">
				<div class="btn-group pull-right">
					<a class="btn btn-success" href="<?php echo site_url('admin/guests/form'); ?>"><i class="fa fa-plus"></i> Add </a>
				</div>

			</div>
		 </div>
		 
		 <div class="row">
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <div class="info-box">
				<span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
	
				<div class="info-box-content">
				  <span class="info-box-text"><?php echo lang('guests')?></span>
				  <span class="info-box-number"><?php echo count($guests)?></span>
				</div>
				<!-- /.info-box-content -->
			  </div>
			  <!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
			  <div class="info-box">
				<span class="info-box-icon bg-red"><i class="fa fa-user-plus"></i></span>
	
				<div class="info-box-content">
				  <span class="info-box-text"><?php echo lang('vip')?></span>
				  <span class="info-box-number"><?php echo count($vip)?></span>
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
				<span class="info-box-icon bg-green"><i class="fa fa-list-alt"></i></span>
	
				<div class="info-box-content">
				  <span class="info-box-text"><?php echo lang('bookings') ?></span>
				  <span class="info-box-number"><?php echo count($orders)?></span>
				</div>
				<!-- /.info-box-content -->
			  </div>
			  <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><?php echo $this->setting->currency_symbol?></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><?php echo lang('income') ?></span>
              <span class="info-box-number"><?php echo $income->amount?></span>
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
                  <h3 class="box-title"><?php echo lang('guests'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
						<table class="table table-striped" id="example1">
							<thead >
								<tr>
									<th>#</th>
									<th><?php echo lang('name'); ?></th>
									<th><?php echo lang('country'); ?></th>
									<th><?php echo lang('email'); ?></th>
									<th><?php echo lang('mobile'); ?></th>
									<th><?php echo lang('action'); ?></th>
								</tr>
							</thead>
							
							<tbody >
						<?php /*if($guests):?>		
						<?php $i=1;foreach ($guests as $new):?>
								<tr>
									<td><?php echo $i;?></td>
									<td class="gc_cell_left" ><?php echo  $new->firstname; ?> <?php echo  $new->lastname; ?></td>
									<td><?php echo  $new->country; ?></td>
									<td><?php echo  $new->email; ?></td>
									<td><?php echo  $new->mobile; ?></td>
									<td>
										<div class="btn-group" style="float:right">
											<a class="btn btn-success" href="<?php echo site_url('admin/guests/vip/'.$new->id.'/'.$new->vip)?>">  <?php echo ($new->vip==1)?'<i class="fa fa-user"></i> '.lang('vip'):'<i class="fa fa-check"></i> '.lang('add_to_vip')?></a>
											<a class="btn btn-default" href="<?php echo site_url('admin/guests/view/'.$new->id); ?>"><i class="fa fa-eye"></i> <?php echo lang('view')?></a>
											<a class="btn btn-primary" href="<?php echo site_url('admin/guests/form/'.$new->id); ?>"><i class="fa fa-edit"></i> <?php echo lang('edit')?></a>
											
											
											<a class="btn btn-danger" href="<?php echo site_url('admin/guests/delete/'.$new->id); ?>" onclick="return areyousure(this);"><i class="fa fa-trash"></i> <?php echo lang('delete')?></a>
										</div>
									</td>
								</tr>
						<?php $i++; endforeach;?>
						<?php endif */?>
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
	//$('#example1').dataTable();
	
});
var table;

$(document).ready(function() {

    //datatables
    table = $('#example1').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/guests/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],

    });

});
</script>
