<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
	create_sortable();	
});
// Return a helper with preserved width of cells
var fixHelper = function(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
};
function create_sortable()
{
	$('#countries').sortable({
		scroll: true,
		helper: fixHelper,
		axis: 'y',
		handle:'.handle',
		update: function(){
			save_sortable();
		}
	});	
	$('#countries').sortable('enable');
}

function save_sortable()
{
	serial=$('#countries').sortable('serialize');
			
	$.ajax({
		url:'<?php echo site_url('admin/locations/organize_countries');?>',
		type:'POST',
		data:serial
	});
}
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_country');?>');
}
//]]>
</script>


<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list')?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li class="active"><?php echo lang('countries');?></li>
          </ol>
</section>


<section class="content">
         <div class="row">
		 	<div class="col-md-12">
				<div class="btn-group pull-right">
						<a class="btn btn-default" href="<?php echo site_url('admin/locations/country_form'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add_new_country');?></a>
	<a class="btn bg-navy" href="<?php echo site_url('admin/locations/zone_form'); ?>"><i class="fa fa-map-marker"></i> <?php echo lang('add_new_region');?></a>

				</div>

			</div>
		 </div>
		 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('countries');?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<strong style="float:left;"><?php echo lang('sort_countries')?></strong>
						
						<table class="table table-striped" cellspacing="0" cellpadding="0">
							<thead>
								<tr>
									<th><?php echo lang('sort');?></th>
									<th><?php echo lang('name');?></th>
									<th><?php echo lang('sortname');?></th>
									<th align="center"><?php echo lang('action');?></th>
									<th></th>
								</tr>
							</thead>
							<tbody id="countries">
						<?php foreach ($locations as $location):?>
								<tr id="country-<?php echo $location->id;?>">
									<td class="handle"><a class="btn btn-default" style="cursor:move"><span class="fa fa-arrows"></span></a></td>
									<td><?php echo  $location->name; ?></td>
									<td><?php echo $location->sortname;?></td>
									<td>
										<div class="btn-group" style="float:right;">
											<a class="btn btn-default" href="<?php echo site_url('admin/locations/country_form/'.$location->id); ?>"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
											<a class="btn btn-primary" href="<?php echo site_url('admin/locations/zones/'.$location->id); ?>"><i class="fa fa-map-marker"></i> <?php echo lang('regions');?></a>
											<a class="btn btn-danger" href="<?php echo site_url('admin/locations/delete_country/'.$location->id); ?>" onclick="return areyousure(this);"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
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
