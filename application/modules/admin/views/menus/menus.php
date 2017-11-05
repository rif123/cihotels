<link href="<?php echo base_url('assets/admin/plugins/iCheck/all.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/netstedSortableAlpha/jquery.mjs.nestedSortable.css')?>" rel="stylesheet" type="text/css" />
<style>
li > .box{ margin-top:-18px;}
</style>
<section class="content-header">
  <h1>
    <?php echo ucwords($page_title)?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo site_url('admin/dashboard')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
    <li class="active"><?php echo @ucwords($page_title)?></li>
  </ol>
</section>
<section class="content">
     <div class="row">
         <?php if(!empty($menus)){?>
         <div class="col-md-2">
    		 <?php echo lang('select_menu_to_edit');?>:
         </div>   
         <div class="col-md-4">    
            <select name="menu_edit" class="form-control input-sm">
            	<?php foreach($menus as $menu){?>
                	<option value="<?php echo $menu->id?>" <?php echo($main->id==$menu->id)?'selected':'';?>><?php echo ucwords($menu->title)?></option>
				<?php }?>
            </select>
        </div>
        <div class="col-md-1">    
            <a class="btn btn-default btn-sm edit-menu"><?php echo lang('edit');?></a>
            &nbsp;Or 
        </div>
        <?php }?>
        <div class="col-md-4">
        	<a href="<?php echo site_url('admin/menus/form')?>" class="btn btn-info"> <?php echo lang('create_menu');?>  </a>
        </div>
    </div>    
    
    <div class="row mt20">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        
                        <div class="col-md-3">
                            <div class="box box-solid bg-teal">
                                <div class="box-header">
                                      <div class="pull-right box-tools">
                                        <button class="btn btn-danger bg-teal btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" 
                                            title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                                      </div><!-- /. tools -->
                
                                      <h3 class="box-title">
                                         <?php echo lang('pages');?>
                                      </h3>
                                </div>
                                <div class="box-body">
                                   <div class="row">
                                        <div class="col-md-12">
                                            <label>
                                                <input type="checkbox" class="icheck" data-type="page" data-title="<?php echo lang('gallery')?>"
                                                value="gallery"/> &nbsp;<?php echo lang('gallery')?>
                                            </label>
                                        </div>
                                    </div>
								    <?php foreach($pages as $page){?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>
                                                <input type="checkbox" class="icheck" data-type="page" data-title="<?php echo ucwords($page->title)?>"
                                                value="<?php echo $page->slug?>"/> &nbsp;<?php echo ucwords($page->title)?>
                                            </label>
                                        </div>
                                    </div>
                                    <?php }?>	
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="btn btn-default btn-sm pull-right addtomenu"> <?php echo lang('add_to_menu');?>  </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box box-solid bg-teal collapsed-box hide">
                                <div class="box-header">
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-danger bg-teal btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" 
                                         title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                                    </div><!-- /. tools -->
                
                                    <h3 class="box-title"> <?php echo lang('posts');?></h3>
                                </div>
                                <div class="box-body">
                                    <?php foreach($posts as $post){?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>
                                                <input type="checkbox" class="icheck" data-type="post" data-title="<?php echo ucwords($post->title)?>"
                                                value="<?php echo $post->slug?>"/> &nbsp;<?php echo ucwords($post->title)?>
                                            </label>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="btn btn-default btn-sm pull-right addtomenu"> <?php echo lang('add_to_menu');?> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box box-solid bg-teal collapsed-box">
                                <div class="box-header">
                                      <div class="pull-right box-tools">
                                        <button class="btn btn-danger bg-teal btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" 
                                            title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                                      </div><!-- /. tools -->
                
                                      <h3 class="box-title">
                                         <?php echo lang('links');?>
                                      </h3>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" class="info" data-type="link" />
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>URL</label>
                                            <input type="text" class="form-control url" value="http://"/>
                                        </div>
                                    </div>
                                    <div class="row mt5">
                                        <div class="col-md-12">
                                            <label><?php echo lang('links');?> <?php echo lang('text');?></label>
                                            <input type="text" class="form-control link-text" placeholder="Menu Label"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="btn btn-default btn-sm pull-right addlinktomenu"> <?php echo lang('add_to_menu');?>  </a>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box box-solid bg-teal collapsed-box">
                                <div class="box-header">
                                      <div class="pull-right box-tools">
                                        <button class="btn btn-danger bg-teal btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" 
                                            title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
                                      </div><!-- /. tools -->
                
                                      <h3 class="box-title">
                                        <?php echo lang('room_types');?>
                                      </h3>
                                </div>
                                <div class="box-body">
                                    <?php foreach($room_types as $category){ ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>
                                                <input type="checkbox" class="icheck" data-type="category" data-title="<?php echo ucwords($category->title)?>"
                                                value="<?php echo site_url('rooms')?>/<?php echo $category->slug?>"/> &nbsp;<?php echo ucwords($category->title)?>
                                            </label>
                                        </div>
                                    </div>
                                    <?php }?>	
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="btn btn-default btn-sm pull-right addtomenu"> <?php echo lang('add_to_menu');?> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--Col 5--3><!--Items-->
                        
                        <div class="col-md-9">
							<form method="post" action="<?php echo site_url('admin/menus/index/'.@$main->id)?>">
                                <input type="hidden" id="menu-id" value="<?php echo @$main->id?>"/>
                                <div class="box box-solid bg-teal">
                                    <div class="box-header">
                                        <div class="row">
                                            <div class="col-md-2">
                                                 <h3 class="box-title"><?php echo lang('menu');?> <?php echo lang('name');?></h3>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control input-sm" id="menu-title" value="<?php echo($main)?$main->title:''?>" />
                                            </div>
                                            <div class="col-md-2 pull-right">
                                                 <a class="btn btn-primary pull-right save-menu"><?php echo lang('save');?></a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="box-title" style="margin-top:5px;"><?php echo lang('menu');?> <?php echo lang('structure');?></h3>
                                                <?php echo lang('menu_caption');?>
                                            </div>
                                        </div>
                                        <div class="row mt10">
                                            <div class="col-md-12">
                                                <ol class="nestable">
                                                    <?php echo (!empty($main->content))?get_nested_menu($main->content):'';?>
                                                </ol>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="box-title"><?php echo lang('menu');?> <?php echo lang('settings');?></h3>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label><?php echo lang('menu');?> <?php echo lang('position');?></label>
                                                        <select id="menu-position" class="form-control">

                                                            <option value="2" <?php echo(@$main->position==2)?'selected':'';?>>Header</option>
                                                            <option value="3" <?php echo(@$main->position==3)?'selected':'';?>>Footer</option>
                                                            <option value="1" <?php echo(@$main->position==1)?'selected':'';?>>Custom Menu</option>
                                                        </select>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="box-footer">
                                        <div class="row">
                                            <?php if($id){?>
                                            <div class="col-md-2">
                                                <a href="<?php echo site_url('admin/menus/delete_group/'.$id)?>" onclick="return areyousure()" 
                                                    class="btn btn-danger"><?php echo lang('delete');?> <?php echo lang('menu');?></a>
                                            </div>
                                            <?php }?>
                                            <div class="col-md-2 pull-right">
                                                 <a class="btn btn-primary pull-right save-menu"><?php echo lang('save');?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!--Col 9--> <!--Menu's-->
                        
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>" type="text/javascript"></script>		
<script src="<?php echo base_url('assets/admin/plugins/netstedSortableAlpha/jquery.mjs.nestedSortable.js')?>" type="text/javascript"></script>
<script type="text/javascript">
var admin_url	=	'<?php echo site_url('admin/')?>';
var TMS = '<?php echo $highestmenu?>';
$(function(){
	var ns = $('ol.nestable').nestedSortable({
					forcePlaceholderSize: true,
					handle: 'div',
					helper: 'clone',
					items: 'li',
					opacity: .6,
					placeholder: 'placeholder',
					revert: 250,
					tabSize: 25,
					tolerance: 'pointer',
					toleranceElement: '> div',
					maxLevels: 5,
					isTree: true,
					expandOnHover: 700,
					startCollapsed: false,
					change: function(){}
			});
});

$(document).on('click','.save-menu',function(){
	 var saveObj = new Array();
	 var ol = $('ol.nestable');
	 var ms = toArray(); 
	 call_loader();
	 $.each(ms, function(i, obj){
	   	 ind = (i-1);
		 if(obj.item_id!=null){
			 parent_id = (obj.parent_id==null)?0:obj.parent_id;
		 	 saveObj[ind] ={id:obj.item_id,
							parent_id:parent_id,
							type:ol.find('li').eq(ind).find('input[name="type"]').val(),
							label:ol.find('li').eq(ind).find('input[name="label"]').val(),
							value:ol.find('li').eq(ind).find('input[name="value"]').val()}; 
		 }
	 });	
	 
	var menu_id = $('#menu-id').val();
	var menu_title = $('#menu-title').val();
	var menu_position = $('#menu-position option:selected').val();
	$.ajax({
		url: admin_url+'menus/ajax_save',
		type:'POST',
		data:{id:menu_id,title:menu_title,position:menu_position,content:saveObj},
		success:function(result){
			remove_loader();
			result = JSON.parse(result);
			if(result.status=='error'){
				toastr['error'](result.result, 'Error!');	
			}else{
				toastr['info'](result.result, 'Success!');	
			}
		}
	});
})

$(document).on('click','.addtomenu',function(){
	 var box = $(this).closest('.box');
	 var box_body = box.find('.box-body');
	 $.each(box_body.find('input[type="checkbox"]'), function( key, value ) {
	   	  if($(this).prop('checked')==true){
				TMS++;
				html = get_html($(this).attr('data-type'),$(this).attr('data-title'), $(this).val(), TMS);
				$('ol.nestable').append(html);
				$.AdminLTE.boxWidget.activate();
				$(this).iCheck('uncheck');
		  }
	 });
});

function get_html(type,label,value,id)
{
	html = '<li id="menuItem_'+id+'">'+
                 '<div class="box box-solid collapsed-box bg-olive">'+
					'<div class="box-header">'+
						  '<div class="pull-right box-tools">'+
							'<button class="btn btn-danger bg-olive btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" '+
								'title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>'+
						  '</div>'+
	
						  '<h3 class="box-title">'+label+'</h3>'+
					'</div>'+
					'<div class="box-body">'+
						'<input type="hidden" name="type" value="'+type+'"/>'+
						'<input type="hidden" name="value" value="'+value+'"/>'+
						'<div class="row">'+
							'<div class="col-md-12">'+
								'<input type="text" class="form-control" name="label" value="'+label+'" placeholder="Label"/>'+
							'</div>'+
						'</div>'+
						'<div class="row mt5">'+
							'<div class="col-md-12">'+
								'<a class="btn btn-default btn-sm pull-right remfrmenu">Remove</a>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>'+
		'</li>';
	
	return html;}
	
$(document).on('click','.remfrmenu',function(){
	$(this).closest('li').remove();
});

$(document).on('click','.addlinktomenu',function(){
	 TMS++;
	 var box = $(this).closest('.box').find('.box-body');
	 
	 label = box.find('.link-text').val();
	 url = box.find('.url').val();
	 type = box.find('.info').attr('data-type');
	 
	 html =  get_html_for_link(type,label,url,TMS);
	 $('ol.nestable').append(html);
	 $.AdminLTE.boxWidget.activate();
	
	 box.find('.url').val('http://');
	 box.find('.link-text').val('');
});


function get_html_for_link(type,label,value,id)
{
	html = '<li id="menuItem_'+id+'">'+
                 '<div class="box box-solid bg-olive collapsed-box">'+
					'<div class="box-header">'+
						  '<div class="pull-right box-tools">'+
							'<button class="btn btn-danger bg-olive btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" '+
								'title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>'+
						  '</div>'+
	
						  '<h3 class="box-title">'+label+'</h3>'+
					'</div>'+
					'<div class="box-body">'+
						'<input type="hidden" name="type" value="'+type+'"/>'+
						
						'<div class="row">'+
							'<div class="col-md-12">'+
								'<label>URL</label>'+
								'<input type="text" class="form-control" name="value" value="'+value+'" placeholder="Link"/>'+
							'</div>'+
						'</div>'+
						'<div class="row mt5">'+
							'<div class="col-md-12">'+
								'<label>Menu Label</label>'+
								'<input type="text" class="form-control" name="label" value="'+label+'" placeholder="Label"/>'+
							'</div>'+
						'</div>'+
						'<div class="row mt5">'+
							'<div class="col-md-12">'+
								'<a class="btn btn-default btn-sm pull-right remfrmenu">Remove</a>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>'+
		'</li>';
	
	return html;
}

function toArray(){
	return $('ol.nestable').nestedSortable('toArray', {startDepthCount: 0});
}

function check_array()
{
	array = toArray();
	$.each(array, function( index, value ) {
	  console.log(array[index]);
	});
}

$(document).on('click','.edit-menu',function(){
	id = $('select[name="menu_edit"] option:selected').val();
	urlgo = admin_url+'menus/index/'+id;
	
	window.location.href=urlgo;
});


</script>
<script type="text/javascript">
var path = '<?php echo base_url('assets/dist/img')?>';
function call_loader(){
	
	if($('#overlay').length == 0 ){
		var over = '<div id="overlay">' +
						'<img id="loading" src="'+path+'/ajax-loader1.gif">'+
				   '</div>';
		
		$(over).appendTo('body');
	}
}

function loader_status()
{
	flag = false;
	if($('#overlay').length>0)
		flag = true;
	
	return flag;	
}

function remove_loader()
{
	$('#overlay').remove();
}


</script>           

