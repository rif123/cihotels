<link href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list')?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
            <li class="active"><?php echo lang('pages');?></li>
          </ol>
</section>

<section class="content">
         <div class="row">
		 	<div class="col-md-12" style="padding:20px;">
				<div class="btn-group pull-right">
						<a class="btn btn-default" href="<?php echo site_url('admin/pages/form'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add_new_page');?></a>
	
				</div>

			</div>
		 </div>
		 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('pages')?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
						<table class="table table-striped" id="example1">
	<thead>
		<tr>
			<th>#</th>
			<th><?php echo lang('title');?></th>
			<th><?php echo lang('slug');?></th>
			<th></th>
		</tr>
	</thead>
	

	<?php if($pages):?>
	<tbody>
		
		<?php
			$i=1;
			foreach($pages as $page)
			{?>
			<tr class="gc_row">
				<td>
					<?php echo $i; ?>
				</td>
				<td>
					<?php echo $page->title; ?>
				</td>
				<td>
					<?php echo $page->slug; ?>
				</td>
				<td>
					<div class="btn-group pull-right">
							<a class="btn btn-primary" href="<?php echo site_url('admin/pages/form/'.$page->id); ?>"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
		
						<a class="btn btn-danger" href="<?php echo site_url('admin/pages/delete/'.$page->id); ?>" onclick="return areyousure(this);"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
					</div>
				</td>
			</tr>
			<?php
			$i++;}
		?>
	</tbody>
	<?php endif;?>
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
