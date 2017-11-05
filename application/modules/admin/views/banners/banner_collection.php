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
	$('#banners_sortable').sortable({
		scroll: true,
		helper: fixHelper,
		axis: 'y',
		handle:'.handle',
		update: function(){
			save_sortable();
		}
	});	
	$('#banners_sortable').sortable('enable');
}

function save_sortable()
{
	serial=$('#banners_sortable').sortable('serialize');
			
	$.ajax({
		url:'<?php echo site_url('admin/banners/organize');?>',
		type:'POST',
		data:serial
	});
}
//]]>
</script>

<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/banners') ?>"> <?php echo lang('banner_collections');?></a></li>
            <li class="active"><?php echo lang('banners')?></li>
          </ol>
</section>


<section class="content">
         <div class="row">
		 	<div class="col-md-12" style="padding:20px;">
				<div class="btn-group pull-right">
			<a style="float:right;" class="btn bg-purple" href="<?php echo site_url('admin/banners/banner_form/'.$banner_collection_id); ?>"><i class="fa fa-plus"></i> <?php echo lang('add_new_banner');?></a>
<a style="float:right; margin-right:10px;" class="btn bg-navy" href="<?php echo site_url('admin/banners/'); ?>"><?php echo lang('banner_collections');?></a>
				</div>

			</div>
		 </div>
		 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('banners')?></h3>
	                </div><!-- /.box-header -->
                <div class="box-body">
					
<strong style="float:left;"><?php echo lang('sort_banners')?></strong>

<table class="table table-striped">
	<thead>
		<tr>
			<th><?php echo lang('sort');?></th>
			<th><?php echo lang('name');?></th>
			<th><?php echo lang('enable_date');?></th>
			<th><?php echo lang('disable_date');?></th>
			<th></th>
		</tr>
	</thead>
	<?php echo (count($banners) < 1)?'<tr><td style="text-align:center;" colspan="5">'.lang('no_banners').'</td></tr>':''?>
	<?php if ($banners): ?>
	<tbody id="banners_sortable">
	<?php

	foreach ($banners as $banner):

		//clear the dates out if they're all zeros
		if ($banner->enable_date == '0000-00-00')
		{
			$enable_test	= false;
			$enable			= '';
		}
		else
		{
			$eo			 	= explode('-', $banner->enable_date);
			$enable_test	= $eo[0].$eo[1].$eo[2];
			$enable			= $eo[2].'-'.$eo[1].'-'.$eo[0];
		}

		if ($banner->disable_date == '0000-00-00')
		{
			$disable_test	= false;
			$disable		= '';
		}
		else
		{
			$do			 	= explode('-', $banner->disable_date);
			$disable_test	= $do[0].$do[1].$do[2];
			$disable		= $do[2].'-'.$do[1].'-'.$do[0];
		}


		$disabled_icon	= '';
		$curDate		= date('Ymd');

		if (($enable_test && $enable_test > $curDate) || ($disable_test && $disable_test <= $curDate))
		{
			$disabled_icon	= '<span style="color:#ff0000;">&bull;</span> ';
		}
		?>
		<tr id="banners-<?php echo $banner->banner_id;?>">
			<td class="handle"><a class="btn" style="cursor:move"><i class="fa fa-arrows"></i></a></td>
			<td><?php echo $disabled_icon.$banner->name;?></td>
			<td><?php echo $enable;?></td>
			<td><?php echo $disable;?></td>
			<td>
				<div class="btn-group" style="float:right">
					<a class="btn btn-primary" href="<?php echo site_url('admin/banners/banner_form/'.$banner_collection_id.'/'.$banner->banner_id);?>"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
					<a class="btn btn-danger" href="<?php echo  site_url('admin/banners/delete_banner/'.$banner->banner_id);?>" onclick="return areyousure(this);"><i class="fa fa-trash"></i> <?php echo lang('delete');?></a>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<?php endif;?>
</table>
					
				 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>

