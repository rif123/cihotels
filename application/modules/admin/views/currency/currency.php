<link href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />

<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list')?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
            <li class="active"><?php echo lang('currency')?></li>
          </ol>
</section>



<section class="content">
         <div class="row">
		 	<div class="col-md-12">
				<div class="btn-group pull-right">
					<a class="btn btn-default" style="float:right;" href="<?php echo site_url('admin/currency/form'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add_new_currency');?></a>

				</div>

			</div>
		 </div>
		 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('currency')?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					
 <table id="example1" class="table table-bordered table-striped">
	<thead>
		<tr>
		  <th><?php echo lang('country');?></th>
		  <th><?php echo lang('currency_name');?></th>
		  <th><?php echo lang('currency_code');?></th>
		  <th><?php echo lang('status');?></th>
		  <th><?php echo lang('action');?></th>
		</tr>
	</thead>
	<tbody>
	
<?php 
if($currency){
foreach ($currency as $new):
$status = ($new->status==1)?'Active':'Deactive';
?>
		<tr>
			<td><?php echo  $new->name; ?></td>
			<td><?php echo  $new->currency_name; ?></td>
			<td><?php echo  $new->currency_code; ?></td>
			<td><?php echo  $status; ?></td>
			<td>
				<div class="btn-group" style="float:right;">
					<a class="btn btn-primary" href="<?php echo site_url('admin/currency/form/'.$new->id); ?>"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
					<a class="btn btn-danger" href="<?php echo site_url('admin/currency/delete/'.$new->id); ?>" onclick="return areyousure(this);"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
				</div>
			</td>
	  </tr>
<?php endforeach; 
}
?>
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
