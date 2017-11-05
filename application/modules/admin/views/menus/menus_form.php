<section class="content-header">
  <h1>
    <?php echo ucwords($page_title)?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo site_url('admin/dashboard')?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard');?></a></li>
	 <li><a href="<?php echo site_url('admin/menus')?>"> <?php echo lang('menus');?></a></li>
    <li class="active"><?php echo @ucwords($page_title)?></li>
  </ol>
</section>
<section class="content">
    <div class="row">
         <?php if(!empty($menus)){?>
         <div class="col-md-2">
    		<?php echo lang('select_menu_to_edit');?> ::
         </div>   
         <div class="col-md-4">    
            <select name="menu_edit" class="form-control input-sm">
            	<?php foreach($menus as $menu){?>
                	<option value="<?php echo $menu->id?>"><?php echo ucwords($menu->title)?></option>
				<?php }?>
            </select>
        </div>
        <div class="col-md-1">
           <?php echo lang('or');?>
        </div>
        <?php } if($id){?>
        <div class="col-md-5">
        	<a href="<?php echo site_url('admin/menus/form')?>"><?php echo lang('edit');?> <?php echo lang('menu');?></a>
        </div>
        <?php }?>
    </div>    
    
    <div class="row mt20">
      <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    
                	<div class="col-md-9">
                    	<?php echo form_open(site_url('admin/menus/form/'.$id));?>
                        <div class="box box-solid bg-teal">
                            <div class="box-header">
                                <div class="row">
                                    <div class="col-md-2">
                                    	 <h3 class="box-title"> <?php echo lang('menu');?>  <?php echo lang('name');?></h3>
                                    </div>
                                    <div class="col-md-4">
                                    	<input type="text" class="form-control input-sm" name="title" />
                                    </div>
                                    <div class="col-md-2 pull-right">
                               			 <button type="submit" class="btn btn-primary pull-right"><?php echo lang('save');?></button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box-body">
                            </div>
                            
                            <div class="box-footer">
                            	<div class="row">
                                	<?php if($id){?>
                                    <div class="col-md-2">
                                    	<a href="<?php echo site_url('admin/menus/delete/'.$id)?>" onclick="return areyousure(this)" 
                                        	class="btn btn-danger"><?php echo lang('delete');?> <?php echo lang('menu');?></a>
                                    </div>
									<div class="col-md-2 pull-right">
                               			 <button type="submit" class="btn btn-primary pull-right"><?php echo lang('save');?></button>
                                    </div>
                                    <?php }?>
                                    
                                </div>
                            </div>
                        </div>
                        <?php echo form_close();?>
                    </div><!--Col 9--> <!--Menu's-->
                    
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
</section>


<script type="text/javascript">
$(document).ready(function(){
	var TWS = 0;
	
	$(".widget-area").sortable({
		cursor: 'move'
	});
	$('.widget-box').draggable({
		//appendTo: 'body',
		helper: 'clone',
		cursor: 'move', 
	});
	
	$('.widget-area').droppable({
		tolerance: 'touch',
		//activeClass: 'ui-state-default',
		hoverClass: 'widget-area-hover',
		accept: '.widget-box',
		drop: function(event, ui){
			TWS++;
			var widget_type = $(ui.draggable).find('.box-header').attr('data-type');
			var widget_title = $(ui.draggable).find('.box-title').text();
			var widget_html = get_html(widget_type, widget_title, $(this).attr('data-id'));
			$(this).append(widget_html);
			$.AdminLTE.boxWidget.activate();
		} 
	});
	
	/*$(document).on('click','.box-tools > button[data-widget="remove"]',function(){
		alert(12);
	});*/
	
	function get_html(type,title,wa_id)
	{
		html = '<div class="box box-solid bg-olive">'+
					'<div class="box-header">'+
						  '<div class="pull-right box-tools">'+
						  	 '<button class="btn bg-olive btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>'+
							 '<button class="btn bg-olive btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>'+	
						  '</div>'+
	
						  '<h3 class="box-title">'+title+'</h3>'+
					'</div>'+
					'<div class="box-body">';
					   
					 if(type=='recent_posts'){
						html += '<div class="row">'+
							   	   '<div class="col-md-12">'+
								   	  '<label>Widget Title</label>'+
								  	 '<input type="text" class="form-control" name="widgets['+wa_id+']['+TWS+'][title]" placeholder="Title"/>'+
								   '</div>'+
							    '</div>'+
								'<div class="row mt5">'+
							   	   '<div class="col-md-12">'+
								     '<label>Records</label>'+
								  	 '<select class="form-control" name="widgets['+wa_id+']['+TWS+'][records]">'+
									 	'<option value="3">3</option>'+
									 	'<option value="5">5</option>'+
									 	'<option value="10">10</option>'+
									 '</select>'+
								   '</div>'+
							    '</div>';	 
								
					 }else if(type=='search_box'){
						html += '<div class="row">'+
							   	   '<div class="col-md-12">'+
								   	  '<label>Widget Title</label>'+
								  	 '<input type="text" class="form-control" name="widgets['+wa_id+']['+TWS+'][title]" placeholder="Title"/>'+
								   '</div>'+
							    '</div>';	 
								
					}else if(type=='custom_menu'){
						html += '<div class="row">'+
							   	   '<div class="col-md-12">'+
								   	  '<label>Widget Title</label>'+
								  	 '<input type="text" class="form-control" name="widgets['+wa_id+']['+TWS+'][title]" placeholder="Title"/>'+
								   '</div>'+
							    '</div>'+
								'<div class="row mt5">'+
							   	   '<div class="col-md-12">'+
								     '<label>Menu</label>'+
								  	 '<select class="form-control" name="widgets['+wa_id+']['+TWS+'][custom_menu]">'+
									 	'<option value="3">Menu 1</option>'+
									 	'<option value="5">Menu 2</option>'+
									 	'<option value="10">Menu 3</option>'+
									 '</select>'+
								   '</div>'+
							    '</div>';
									 
				    }else if(type=='categories'){
						html += '<div class="row">'+
							   	   '<div class="col-md-12">'+
								   	  '<label>Widget Title</label>'+
								  	 '<input type="text" class="form-control" name="widgets['+wa_id+']['+TWS+'][title]" placeholder="Title"/>'+
								   '</div>'+
							    '</div>'+
								'<div class="row mt5">'+
							   	   '<div class="col-md-12">'+
								     '<label>Records</label>'+
								  	 '<select class="form-control" name="widgets['+wa_id+']['+TWS+'][records]">'+
									 	'<option value="3">Menu 1</option>'+
									 	'<option value="5">Menu 2</option>'+
									 	'<option value="10">Menu 3</option>'+
									 '</select>'+
								   '</div>'+
							    '</div>';
									 
					}else if(type=='offers'){
						html += '<div class="row">'+
							   	   '<div class="col-md-12">'+
								   	  '<label>Widget Title</label>'+
								  	 '<input type="text" class="form-control" name="widgets['+wa_id+']['+TWS+'][title]" placeholder="Title"/>'+
								   '</div>'+
							    '</div>'+
								'<div class="row mt5">'+
							   	   '<div class="col-md-12">'+
								     '<label>Records</label>'+
								  	 '<select class="form-control" name="widgets['+wa_id+']['+TWS+'][records]">'+
									 	'<option value="3">3</option>'+
									 	'<option value="5">5</option>'+
									 	'<option value="10">10</option>'+
									 '</select>'+
								   '</div>'+
							    '</div>';	 
					}else if(type=='newsletter_form'){
						html += '<div class="row">'+
							   	   '<div class="col-md-12">'+
								   	  '<label>Widget Title</label>'+
								  	 '<input type="text" class="form-control" name="widgets['+wa_id+']['+TWS+'][title]" placeholder="Title"/>'+
								   '</div>'+
							    '</div>'+
								'<div class="row mt5">'+
							   	   '<div class="col-md-12">'+
								     '<label>Excerpt</label>'+
								     '<textarea class="form-control" name="widgets['+wa_id+']['+TWS+'][content]" rows="3"></textarea>'+
								   '</div>'+
							    '</div>';	 
					}else if(type=='text'){
						html += '<div class="row">'+
							   	   '<div class="col-md-12">'+
								   	  '<label>Widget Title</label>'+
								  	 '<input type="text" class="form-control" name="widgets['+wa_id+']['+TWS+'][title]" placeholder="Title"/>'+
								   '</div>'+
							    '</div>'+
								'<div class="row mt5">'+
							   	   '<div class="col-md-12">'+
								     '<label>Content</label>'+
								     '<textarea class="form-control" name="widgets['+wa_id+']['+TWS+'][content]" rows="3"></textarea>'+
								   '</div>'+
							    '</div>';	 
					}else if(type=='posts_by_category'){
						html += '<div class="row">'+
							   	   '<div class="col-md-12">'+
								   	  '<label>Widget Title</label>'+
								  	 '<input type="text" class="form-control" name="widgets['+wa_id+']['+TWS+'][title]" placeholder="Title"/>'+
								   '</div>'+
							    '</div>'+
								'<div class="row mt5">'+
							   	   '<div class="col-md-12">'+
								     '<label>Category</label>'+
								  	 '<select class="form-control" name="widgets['+wa_id+']['+TWS+'][category]">'+
									 	'<option value="3">Category 1</option>'+
									 	'<option value="5">Category 2</option>'+
									 	'<option value="10">Category 3</option>'+
									 '</select>'+
								   '</div>'+
							    '</div>';	
								'<div class="row mt5">'+
							   	   '<div class="col-md-12">'+
								     '<label>Records</label>'+
								  	 '<select class="form-control" name="widgets['+wa_id+']['+TWS+'][records]">'+
									 	'<option value="3">3</option>'+
									 	'<option value="5">5</option>'+
									 	'<option value="10">10</option>'+
									 '</select>'+
								   '</div>'+
							    '</div>';		 
					}
					  
					   
		html += 	 '</div>'+
				'</div>';
		
		return html;
	}
	
});
</script>

