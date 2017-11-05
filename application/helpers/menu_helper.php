<?php

function get_nested_menu($data=false)
{
	//$nestedMenu = '';
	$menu_array = json_decode($data,true);
	$myTree = buildTree($menu_array, 0);
	return buildMenu($myTree);
}

function buildTree($itemList, $parentId) {
  // return an array of items with parent = $parentId
  
  $result = array();
  foreach ($itemList as $item) {
	if ($item['parent_id'] == $parentId) {
	  $newItem = $item;
	  $newItem['children'] = buildTree($itemList, $newItem['id']);
	  $result[] = $newItem;
	}
  }
//echo '<pre>'; print_r($result);die;	
  if (count($result) > 0) return $result;
  return null;
}

function buildMenu($array)
{
	  $i = 1;
  	  foreach ($array as $item)
	  {
		echo '<li  id="menuItem_'.$item['id'].'" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded" style="display: list-item;">';
		echo get_menu_box($item);
		if (!empty($item['children']))
		{
		  echo '<ol>';
		  buildMenu($item['children']);
		  echo '</ol>';
		}
		echo '</li>';
	  	
		$i++;
	  }
}

function get_menu_box($menu)
{
	if($menu['type']=='link'){
		$html = '<div class="box box-solid bg-olive collapsed-box">
						<div class="box-header">
							  <div class="pull-right box-tools">
								<button class="btn btn-danger bg-olive btn-sm pull-right" data-widget="collapse" data-toggle="tooltip"
									title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
							  </div>
		
							  <h3 class="box-title">'.@$menu['label'].'</h3>
						</div>
						<div class="box-body">
							<input type="hidden" name="type" value="'.@$menu['type'].'"/>
							<div class="row">
								<div class="col-md-12">
									<label>URL</label>
									<input type="text" class="form-control" name="value" value="'.@$menu['value'].'" placeholder="Link"/>
								</div>
							</div>
							<div class="row mt5">
								<div class="col-md-12">
									<label>Menu Label</label>
									<input type="text" class="form-control" name="label" value="'.@$menu['label'].'" placeholder="Label"/>
								</div>
							</div>
							<div class="row mt5">
								<div class="col-md-12">
									<label>Menu Label</label>
									<input type="text" class="form-control" name="a_label" value="'.@$menu['label'].'" placeholder="Label"/>
								</div>
							</div>
							<div class="row mt5">
								<div class="col-md-12">
									<a class="btn btn-default btn-sm pull-right remfrmenu">Remove</a>
								</div>
							</div>
						</div>
					</div>';
	
	}else{
		$html = '<div class="box box-solid bg-olive collapsed-box">
				<div class="box-header">
				  <div class="pull-right box-tools">
					<button class="btn btn-danger bg-olive btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" 
					title="Collapse" style="margin-right: 5px;"><i class="fa fa-plus"></i></button>
				  </div>
				  <h3 class="box-title">'.@$menu['label'].'</h3>
				</div>
				<div class="box-body" style="display: none;">
				  <input type="hidden" name="type" value="'.@$menu['type'].'">
				  <input type="hidden" name="value" value="'.@$menu['value'].'">
				  <div class="row">
					<div class="col-md-12">
					  <input type="text" class="form-control" name="label" value="'.@$menu['label'].'" placeholder="Label">
					</div>
				  </div>
				  <div class="row mt5">
					<div class="col-md-12">
					  <input type="text" class="form-control" name="a_label" value="'.@$menu['label'].'" placeholder="Label">
					</div>
				  </div>
				  <div class="row mt5">
					<div class="col-md-12"><a class="btn btn-default btn-sm pull-right remfrmenu">Remove</a></div>
				  </div>
				</div>
			  </div>';
	}
			  
	return $html;		  
}

function front_menu($type=false)
{	
	$CI =& get_instance();
	$CI->db->limit(1);
	if($type=='top')
		$data = $CI->db->get_where('menus',array('position'=>2))->row('content');
	else if($type=='footer1')
		$data = $CI->db->get_where('menus',array('position'=>3))->row('content');	
	else if($type=='custom')
		$data = $CI->db->get_where('menus',array('position'=>1))->row('content');
	else if($type=='footer2')
		$data = $CI->db->get_where('menus',array('position'=>4))->row('content');
	else if($type=='footer3')
		$data = $CI->db->get_where('menus',array('position'=>5))->row('content');						
	
	$menu_array = (array)json_decode($data,true);
	//print_r($menu_array);die;
	$myTree = buildTree($menu_array, 0);
	return make_front_menu($myTree);
}

function make_front_menu($array)
{ 
	  $i = 1;
  	  foreach ($array as $item)
	  {
		if($item['type']=='page')
			$url = site_url('page/'.@$item['value']);
		if($item['type']=='category')
			$url = site_url('categories/'.@$item['value']);	
		if($item['type']=='post')
			$url = site_url('posts/'.@$item['value']);		
		if($item['type']=='link')
			$url = $item['value'];	
		if($item['type']=='other')
			$url = site_url(@$item['value']);				
		
		echo '<li class=""> <a href="'.$url.'">'.ucwords($item['label']).'</a>';
		if (!empty($item['children']))
		{
			echo '<ul class="dropdown-menu">'; 
			make_front_menu($item['children']);
			echo '</ul>';
		}
		echo '</li>';
	  	
		$i++;
	  }
	
}

function top_menu($type=false)
{	
	$CI =& get_instance();
	$CI->db->limit(1);
	if($type=='header')
		$data = $CI->db->get_where('menus',array('position'=>2))->row('content');
	else if($type=='footer1')
		$data = $CI->db->get_where('menus',array('position'=>3))->row('content');	
	else if($type=='custom')
		$data = $CI->db->get_where('menus',array('position'=>1))->row('content');
	else if($type=='footer2')
		$data = $CI->db->get_where('menus',array('position'=>4))->row('content');
	else if($type=='footer3')
		$data = $CI->db->get_where('menus',array('position'=>5))->row('content');						
	//echo '<pre>';print_r($data);die;
	if(!empty($data)){
		$menu_array = (array)json_decode($data,true);
	}else{
		$menu_array=array();;
	}	
	
	$myTree = buildTree($menu_array, 0);
	//echo '<pre>';print_r($myTree);die;
	return header_front_menu($myTree);
}



function header_front_menu($array)
{ 
	if(!empty($array)){ 
	  foreach ($array as $item)
	  { 
		if($item['type']=='page')
			$url = site_url('page/'.@$item['value']);
		if($item['type']=='category')	//rooms
			$url = $item['value'];	
		if($item['type']=='post')
			$url = site_url('posts/'.@$item['value']);		
		if($item['type']=='link')
			$url = @$item['value'];	
		if($item['type']=='other')
			$url = site_url(@$item['value']);				
		//echo '<pre>'; print_r($item);
		//echo '</pre>';
		if($item['parent_id']==0){
		    
            $current_url =  base_url(uri_string());  
			if(count($item['children']) > 0){ $icon=""; }else{ $icon=false;}
			if(count($item['children']) > 0){ 
			     $class='class="dropdown"'; 
            }else{ 
               if($current_url == $url){
                 $class='class="active"';
               } else{
                 $class=false;
               }
                 
            }
			if(count($item['children']) > 0){ $attr='class="dropdown-toggle" data-toggle="dropdown"'; }else{ $attr=false;}
			echo '<li '.$class.'> 
					<a  href="'.$url.'" '.$attr.'>
						'.ucwords(@$item['label']).' 
						'.$icon.'
					</a>';
		}else{ 
		    echo 'test';
			echo '<li><a href="'.$url.'">'.ucwords(@$item['label']).'</a></li>';
		}				
		//$dropdown = ($item['parent_id']==0)?'<a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="caret"></span></a>':''; 
		//echo '<li class=""> <a href="'.$url.'">'.ucwords(trns($item['label'])).'</a>'.$dropdown;
		if (!empty($item['children']))
		{
			echo ' <ul class="dropdown-menu">';
				   	header_front_menu_child($item['children']);
			echo  '</ul>';
		}
		if($item['parent_id']==0){	
			echo '</li>';
		}
	  }
	 } 
	
}

function header_front_menu_child($array)
{ 
	//echo '<pre>'; print_r($array);
	if(!empty($array)){ 
	  foreach ($array as $item)
	  {
	  
		if($item['type']=='page')
			$url = site_url('page/'.@$item['value']);
		if($item['type']=='category')
			$url = @$item['value'];	//rooms;	
		if($item['type']=='post')
			$url = site_url('posts/'.@$item['value']);		
		if($item['type']=='link')
			$url = @$item['value'];	
		if($item['type']=='other')
			$url = site_url(@$item['value']);				
		
			if(count($item['children']) > 0){ $icon=""; }else{ $icon=false;}
			if(count($item['children']) > 0){ $class='class="dropdown""'; }else{ $class=false;}
			if(count($item['children']) > 0){ $attr='class="dropdown-toggle" data-toggle="dropdown"'; }else{ $attr=false;}
			echo '<li '.$class.'> 
					<a  href="'.$url.'" '.$attr.'>
						'.ucwords(@$item['label']).' 
						'.$icon.'
					</a>';
		//$dropdown = ($item['parent_id']==0)?'<a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="caret"></span></a>':''; 
		//echo '<li class=""> <a href="'.$url.'">'.ucwords(trns($item['label'])).'</a>'.$dropdown;
		if (!empty($item['children']))
		{
			echo ' <ul class="dropdown-menu">';
				   	header_front_menu_child(@$item['children']);
			echo  '</ul>';
		}
		if($item['parent_id']==0){	
			echo '</li>';
		}
	  }
	 } 
	
}

function footer_menu($type=false)
{	
	
	$CI =& get_instance();
	$CI->db->limit(1);
	if($type=='header')
		$data = $CI->db->get_where('menus',array('position'=>2))->row('content');
	else if($type=='footer')
		$data = $CI->db->get_where('menus',array('position'=>3))->row('content');	
	else if($type=='custom')
		$data = $CI->db->get_where('menus',array('position'=>1))->row('content');
	else if($type=='footer2')
		$data = $CI->db->get_where('menus',array('position'=>4))->row('content');
	else if($type=='footer3')
		$data = $CI->db->get_where('menus',array('position'=>5))->row('content');						
	
	if(!empty($data)){
		$menu_array = (array)json_decode($data,true);
	}else{
		$menu_array=array();;
	}	
	//echo '<pre>';print_r($menu_array);die;
	$myTree = buildTree($menu_array, 0);
	return footer_front_menu($myTree);
}



function footer_front_menu($array)
{ 


if(!empty($array)){

	  foreach ($array as $item)
	  {
		if($item['type']=='page')
			$url = site_url('page/'.@$item['value']);
		if($item['type']=='category')
			$url = @$item['value'];	
		if($item['type']=='post')
			$url = site_url('posts/'.@$item['value']);		
		if($item['type']=='link')
			$url = @$item['value'];	
		if($item['type']=='other')
			$url = site_url(@$item['value']);				
		
		//echo '<pre>'; print_r($array);'</pre>';;
				
		if($item['parent_id']==0){
			if(count($item['children']) > 0){ $icon="<i class='fa fa-angle-down'></i>"; }else{ $icon=false;}
			if(count($item['children']) > 0){ $class='class="dropdown"'; }else{ $class=false;}
			echo '
			<div class="col-md-3 footer-grid">
						<h4>'.ucwords(@$item['label']).'</h4>';
		
		}else{
			echo '<li><a href="'.$url.'">'.ucwords(@$item['label']).'</a></li>';
		}				
		
		if (!empty($item['children']))
		{
			echo ' <ul>';
				   	footer_front_menu(@$item['children']);
			echo  '</ul>';
		}
		if($item['parent_id']==0){	
			echo '
			</div>';
		}
	  }
	}
}

function mob_menu($type=false)
{	
	$CI =& get_instance();
	$CI->db->limit(1);
	if($type=='top')
		$data = $CI->db->get_where('menus',array('position'=>2))->row('content');
	else if($type=='footer1')
		$data = $CI->db->get_where('menus',array('position'=>3))->row('content');	
	else if($type=='custom')
		$data = $CI->db->get_where('menus',array('position'=>1))->row('content');
	else if($type=='footer2')
		$data = $CI->db->get_where('menus',array('position'=>4))->row('content');
	else if($type=='footer3')
		$data = $CI->db->get_where('menus',array('position'=>5))->row('content');						
	
	$menu_array = (array)json_decode($data,true);
	//print_r($menu_array);die;
	$myTree = buildTree($menu_array, 0);
	return mob_front_menu($myTree);
}

function mob_front_menu($array)
{ 
	  foreach ($array as $item)
	  {
		if($item['type']=='page')
			$url = site_url('page/'.$item['value']);
		if($item['type']=='category')
			$url = site_url('categories/'.$item['value']);	
		if($item['type']=='post')
			$url = site_url('posts/'.$item['value']);		
		if($item['type']=='link')
			$url = $item['value'];	
		if($item['type']=='other')
			$url = site_url($item['value']);	
				
		if($item['parent_id']==0){
			echo '<li class="level-top">
					<a class="level-top" href="'.$url.'"><span>'.ucwords($item['label']).' </span><span class="boder-menu"></span></a>';
		}else{
			echo '<li><a href="'.$url.'">'.ucwords($item['label']).'</a></li>';
		}				
		//$dropdown = ($item['parent_id']==0)?'<a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="caret"></span></a>':''; 
		//echo '<li class=""> <a href="'.$url.'">'.ucwords(trns($item['label'])).'</a>'.$dropdown;
		if (!empty($item['children']))
		{
			echo '<ul>';
				   	mob_front_menu($item['children']);
			echo '</ul>';
		}
		if($item['parent_id']==0){	
			echo '</li>';
		}
	  }
	
}




function get_table_record($table,$where_field=false,$where=false,$limit=false)
{
	$CI =& get_instance();
	if($where_field){
		if($table=='posts' && $where_field=='categories')
			$CI->db->like($where_field,'"'.$where.'"','both');
		else
			$CI->db->where($where_field,$where);
	}
	if($limit)
		$CI->db->limit($limit);
	
	return $CI->db->get($table)->result();
}

function get_widget_area($position=false)
{
	$widget_area = get_table_record('widget_area','position',$position);
	$widgets = ($widget_area[0]->widgets!='')?(array)json_decode($widget_area[0]->widgets,true):array();
	foreach($widgets as $widget){
		echo get_widget($widget,$position);
	}
}

function get_widget($widget,$position=false)
{
	$html = '';
	if($position=='bottom1')
	{
		$rows = get_table_record('posts','categories',$widget['value'],$widget['records']);
		$category = get_table_record('categories','id',$widget['value']);
	    foreach($rows as $row){
			$html .='<div class="sml-blocks pull-left">
						<figure class="imgplace pull-left">
							<img style="border-radius:50%;" src="'.uploads('common/'.$row->image).'" alt="'.ucwords($row->title).'">
						</figure>
						<div class="desc pull-right">
						  <h3>'.ucwords($row->title).'</h3>
						  <!--<h4>DECOUVREZ NOTRE OFFRE EN DETAIL</h4>-->
						  <a href="'.site_url('posts/'.$row->slug).'" class="more">'.lang('learn_more').'</a> </div>
					  </div>';
		}
	}
	
	if($position=='bottom2')
	{
		$html .='<div class="sec03-block pull-left">
					'.$widget['value'].'
				 </div>';
	}
	
	if($position=='bottom3')
	{
		$html .='<div class="sec03-block pull-left">
					'.$widget['value'].'
				 </div>';
	}
	
	if($position=='footer1' || $position=='footer2' || $position=='footer3')
	{
		if($widget['type']=='text'){
		   $html .='<div class="ftboxes pull-left">
						<h3>'.$widget['title'].'</h3>
						'.$widget['value'].'
					</div>';
		}
		if($widget['type']=='posts_by_category'){
		   $html .='<div class="ftboxes pull-left">
					  <h3>'.$widget['title'].'</h3>
						<ul>';
							$category = get_table_record('categories','id',$widget['value']);
							$rows = get_table_record('posts','categories',$widget['value'],$widget['records']);
							foreach($rows as $row){
							  $html.='<li><a href="'.site_url('posts/'.$row->slug).'">'.ucwords($row->title).'</li>';
							}
			  $html .='</ul>
				</div>';
		}
		if($widget['type']=='newsletter_form'){
			 $html .='<div class="ftboxes pull-left">
					   <form action="'.site_url('subcribe').'" method="post">
						  <h3>'.$widget['title'].'</h3>
						  <input type="text" placeholder="'.$widget['value'].'">
						  <input type="submit" value="'.lang('ok').'">
					  </form>		  
					</div>';
		}	
		if($widget['type']=='custom_menu'){
			 $html .='<div class="ftboxes pull-left">
						<h3>'.$widget['title'].'</h3>
						<ul>';
							$menu = get_table_record('menus','id',$widget['value'],$widget['records']);
							$rows = (!empty($menu[0]->content))?(array)json_decode($menu[0]->content,true):array();
							foreach($rows as $row){
							  if($row['type']=='post')
							  	$url = site_url('posts/'.$row['value']);	
							  	$html.='<li><a href="'.$url.'">'.ucwords($row['label']).'</li>';
							}
			  $html .='</ul>		  
					</div>';
		}		
	}
	
	if($position=='right_side')
	{
		if($widget['type']=='text'){
		   $html .='<div class="sideboxes" id="videobox">
					   <h3>'.$widget['title'].'</h3>
					  <div class="showvideo">
						 '.$widget['value'].'
					   </div>
				   </div>';
		}
		if($widget['type']=='posts_by_category'){
		   $html .='<div class="sideboxes blueborderbox" id="rssfeedbox">
					  <div class="title-section clearfix">
						<h3>'.$widget['title'].'</h3>
					  </div>
					  <div class="feedbody">
							<ul>';
								$category = get_table_record('categories','id',$widget['value']);
								$rows = get_table_record('posts','categories',$widget['value'],$widget['records']);
								//echo'<pre>';print_r($rows);exit;
								foreach($rows as $row){
								  $html.='<li><h4>'.ucwords($row->title).'</h4>'.ucfirst($row->excerpt).'</li>';
								}
				  $html .='</ul>
					  </div>
					  <div class="bottombar"> <a href="'.site_url('categories/'.$category[0]->slug).'">'.lang('view_new_content').'</a> </div>
				</div>';
		}
		if($widget['type']=='newsletter_form'){
			$html .='<div class="sideboxes blueborderbox text-center" id="newsletterbox">
					  <form action="'.site_url('subcribe').'" method="post">
						  <h3>'.$widget['title'].'</h3>
						  <input type="text" placeholder="'.$widget['value'].'">
						  <input type="submit" value="'.lang('ok').'">
					  </form>		  
					</div>';
		}
	}
	return $html;
}

function get_widget_box_edit($type,$title,$value,$records)
{
	$html = '<div class="box box-solid bg-olive collapsed-box">
				<div class="box-header">
					  <div class="pull-right box-tools">
						 <button class="btn bg-olive btn-sm" data-widget="collapse"><i class="fa fa-plus"></i></button>
						 <button class="btn bg-olive btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
					  </div>

					  <h3 class="box-title">'.$title.'</h3>
				</div>
				<div class="box-body">';
				   
				 if($type=='recent_posts'){
					 
					 
					$html .= '<div class="row">
							   <div class="col-md-12">
								  <label>Widget Title</label>
								  <input type="hidden" name="type" value="'.$type.'">
								  <input type="hidden" name="value" value="">
								  <input type="text" class="form-control" name="title" placeholder="Title" value="'.$title.'"/>
							   </div>
							</div>
							<div class="row mt5">
							   <div class="col-md-12">
								 <label>Records</label>
								 <select class="form-control" name="records">
									<option value="3" '; $html.=($records==3)?'selected':''; $html .='>3</option>
									<option value="5" '; $html.=($records==5)?'selected':''; $html .='>5</option>
									<option value="10" '; $html.=($records==10)?'selected':''; $html .='>10</option>
								 </select>
							   </div>
							</div>';
							
				 }else if($type=='search_box'){
					$html .= '<div class="row">
							   <div class="col-md-12">
								  <label>Widget Title</label>
								  <input type="hidden" name="type" value="'.$type.'">
								  <input type="hidden" name="records" value="0">
								  <input type="hidden" name="value" value="">
								  <input type="text" class="form-control" name="title" placeholder="Title" value="'.$title.'"/>
							   </div>
							</div>';	 
							
				}else if($type=='custom_menu'){
					$html .= '<div class="row">
							   <div class="col-md-12">
								  <label>Widget Title</label>
								  <input type="hidden" name="type" value="'.$type.'">
								  <input type="hidden" name="records" value="0">
								  <input type="text" class="form-control" name="title" placeholder="Title" value="'.$title.'"/>
							   </div>
							</div>
							<div class="row mt5">
							   <div class="col-md-12">
								 <label>Menu</label>
								 <select class="form-control" name="value">';
									$rows = get_table_record('menus');
									foreach($rows as $row){
										$html.='<option value="'.$row->id.'" ';
										$html.=($row->id==$value)?'selected':'';
										$html.='>'.ucwords($row->title).'</option>';
									}
						$html .='</select>
							   </div>
							</div>';
								 
				}else if($type=='categories'){
					$html .= '<div class="row">
							   <div class="col-md-12">
								  <label>Widget Title</label>
								  <input type="hidden" name="type" value="'.$type.'">
								  <input type="text" class="form-control" name="title" placeholder="Title" value="'.$title.'"/>
							   </div>
							</div>
							<div class="row mt5">
							   <div class="col-md-12">
								 <label>Category</label>
								 <select class="form-control" name="value">';
									$rows = get_table_record('categories');
									foreach($rows as $row){
										$html.='<option value="'.$row->id.'" ';
										$html.=($row->id==$value)?'selected':'';
										$html.='>'.ucwords($row->title).'</option>';
									}
						$html .='</select>
							   </div>
							</div>
							<div class="row mt5">
							   <div class="col-md-12">
								 <label>Records</label>
								 <select class="form-control" name="records">
									<option value="3" '; $html.=($records==3)?'selected':''; $html .='>3</option>
									<option value="5" '; $html.=($records==5)?'selected':''; $html .='>5</option>
									<option value="10" '; $html.=($records==10)?'selected':''; $html .='>10</option>
								 </select>
							   </div>
							</div>';
								 
				}else if($type=='offers'){
				   $html .= '<div class="row">
							   <div class="col-md-12">
								  <label>Widget Title</label>
								  <input type="hidden" name="type" value="'.$type.'">
								  <input type="hidden" name="value" value="">
								  <input type="text" class="form-control" name="title" placeholder="Title" value="'.$title.'"/>
							   </div>
							</div>
							<div class="row mt5">
							   <div class="col-md-12">
								 <label>Records</label>
								 <select class="form-control" name="records">
									<option value="3" '; $html.=($records==3)?'selected':''; $html .='>3</option>
									<option value="5" '; $html.=($records==5)?'selected':''; $html .='>5</option>
									<option value="10" '; $html.=($records==10)?'selected':''; $html .='>10</option>
								 </select>
							   </div>
							</div>';	 
							
				}else if($type=='newsletter_form'){
				   $html .= '<div class="row">
							   <div class="col-md-12">
								  <label>Widget Title</label>
								  <input type="hidden" name="type" value="'.$type.'">
								  <input type="hidden" name="records" value="0">
								  <input type="text" class="form-control" name="title" placeholder="Title" value="'.$title.'"/>
							   </div>
							</div>
							<div class="row mt5">
							   <div class="col-md-12">
								 <label>Excerpt</label>
								 <textarea class="form-control" name="value" rows="3">'.$value.'</textarea>
							   </div>
							</div>';	 
				}else if($type=='text'){
				  $html .= '<div class="row">
							   <div class="col-md-12">
								  <label>Widget Title</label>
								  <input type="hidden" name="type" value="'.$type.'">
								  <input type="hidden" name="records" value="0">
								  <input type="text" class="form-control" name="title" placeholder="Title" value="'.$title.'"/>
							   </div>
							</div>
							<div class="row mt10">
								<div class="col-md-12">
									<a class="btn btn-primary btn-sm pull-right edit-content">Edit Content</a>
								</div>
							</div>
							<div class="row mt5" style="display:none">
							   <div class="col-md-12">
								 <label>Content</label>
								 <textarea class="form-control" name="value" rows="3">'.$value.'</textarea>
							   </div>
							</div>';	 
				}else if($type=='posts_by_category'){
				  $html .= '<div class="row">
							   <div class="col-md-12">
								  <label>Widget Title</label>
								  <input type="hidden" name="type" value="'.$type.'">
								  <input type="text" class="form-control" name="title" placeholder="Title" value="'.$title.'"/>
							   </div>
							</div>
							<div class="row mt5">
							   <div class="col-md-12">
								 <label>Category</label>
								 <select class="form-control" name="value">';
									$rows = get_table_record('categories');
									foreach($rows as $row){
										$html.='<option value="'.$row->id.'" ';
										$html.=($row->id==$value)?'selected':'';
										$html.='>'.ucwords($row->title).'</option>';
									}
						$html .='</select>
							   </div>
							</div>
							<div class="row mt5">
							   <div class="col-md-12">
								 <label>Records</label>
								 <select class="form-control" name="records">
									<option value="3" '; $html.=($records==3)?'selected':''; $html .='>3</option>
									<option value="5" '; $html.=($records==5)?'selected':''; $html .='>5</option>
									<option value="10" '; $html.=($records==10)?'selected':''; $html .='>10</option>
								 </select>
							   </div>
							</div>';		 
				}
				  
				   
	$html .='	 </div>
			</div>';
	
	return $html;
}

//Category Accordian
function catAcc($array)
{
	  $tree = catTree($array,0);	
	  $i = 1;
	  foreach ($tree as $item)
	  {
		  echo '<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<div>
								<a data-toggle="collapse" data-parent="#accordian" href="#'.$item['slug'].'">
									<span class="badge pull-right"><i class="fa fa-plus"></i></span>
								</a>
								<a href="'.site_url($item['slug']).'">'.$item['name'].'</a>
							</div>
						</h4>
					</div>';
		if (!empty($item['children']))
		{
			echo '<div id="'.$item['slug'].'" class="panel-collapse collapse">
					<div class="panel-body">
						<ul>';
							foreach($item['children'] as $child){
								echo ' <li><a href="'.site_url($child['slug']).'">'.$child['name'].'</a></li>';
							}
					echo '</ul>
					</div>
				</div>';
		}
		echo '</div>';
		
		$i++;
	  }
}

function catTree($itemList, $parentId) {
  // return an array of items with parent = $parentId
  $result = array();
  foreach ($itemList as $item) {
	if ($item['parent_id'] == $parentId) {
	  $newItem = $item;
	  $newItem['children'] = buildTree($itemList, $newItem['id']);
	  $result[] = $newItem;
	}
  }

  if (count($result) > 0) return $result;
  return null;
}

