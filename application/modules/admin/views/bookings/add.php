<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>/js/datepicker3.css">  
<link href="<?php echo base_url('assets/admin/plugins/toastr')?>/toastr.min.css" rel="stylesheet" type="text/css" media="all" />
<style>
.datepicker table tr td.disabled, .datepicker table tr td.disabled:hover {
    background: #CCCCCC;
    color: #444;
    cursor: default;
}
</style> 
<?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/bookings') ?>"> <?php echo lang('bookings')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					<div class="box-header">
					  <h3 class="box-title"><?php echo lang('make_reservation'); ?></h3>
					</div><!-- /.box-header -->
				<form method="post"  enctype="multipart/form-data" id="add_form" >	
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('guest') ?></label>
                      	</div>
						<div class="col-md-4">
							<select name="guest_id" class="form-control" id="guest_id">
									<option value="">--<?php echo lang('select')?> <?php echo lang('guest')?>--</option>
									<?php foreach($guests as $guest){?>
										<option value="<?php echo $guest->id?>"><?php echo $guest->firstname;?> <?php echo $guest->lastname?></option>
									<?php } ?>
							</select>
						</div>

                        <div class="col-md-2">
                      		<label><?php echo lang('building') ?></label>
                      	</div>
						<div class="col-md-4">
                            <select name="idBuilding" class="form-control idBuild">
                                    <option value="">--<?php echo lang('building')?>--</option>
									<?php foreach($listGedung as $rt){?>
										<option value="<?php echo $rt->idBuilding?>"><?php echo $rt->nameBuilding;?></option>
									<?php } ?>
							</select>
						</div>	
                    </div>
				  </div>

                  <div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('adults') ?></label>
                      	</div>
						<div class="col-md-4">
							<input type="number" name="adults" class="form-control" min="1" max="10" placeholder="<?php echo lang('adults')?>" />
						</div>	
						
                        <div class="col-md-2">
                      		<label><?php echo lang('room') ?></label>
                      	</div>
					  	<div class="col-md-4">
							<select name="room_type_id" class="form-control room_type_id">			
							</select>
						</div>

                    </div>
				  </div>

                  <div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('kegiatan') ?></label>
                      	</div>
						<div class="col-md-4">
                            <textarea name="kegiatan" class="form-control" id="" cols="30" rows="10"></textarea>
						</div>	

                        <div class="col-md-2">
                      		<label>No Kamar</label>
                      	</div>
					  	<div class="col-md-4">
							<select name="room_no" class="form-control roomNo">			
							</select>
						</div>

                    </div>
				  </div>	


                  <div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo 'Category' ?></label>
                      	</div>
						<div class="col-md-4">
							<select name="idCategory" class="form-control">
								<?php 
									foreach ($listCategory as $key => $val) {
										echo "<option value='".$val['idCategory']."'>".$val['nameCategory']."</option>";
									}
								?>
							</select>
						</div>			
                    </div>
				  </div>


				  <div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('check_in') ?></label>
                      	</div>
						<div class="col-md-4">
							<input type="text" name="check_in" class="form-control datepicker1" placeholder="<?php echo lang('check_in')?>" autocomplete="off" />
						</div>	
						<div class="col-md-2">
                      		<label><?php echo lang('check_out') ?></label>
                      	</div>
					  	<div class="col-md-4">
							<input type="text" name="check_out" class="form-control datepicker2"  placeholder="<?php echo lang('check_out')?>" autocomplete="off" readonly="" />
						</div>		
                    </div>
				  </div>	
                  
				   
					<div id="order_data"></div>
					
					<div class="box-footer">
							<div class="pull-right">
							<input class="btn btn-primary" type="submit" value="Next" style="display:none" id="next" />
							</div>
					</div>
					</form>
     			 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>" type="text/javascript"></script>		
<script src="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>	
<script src="<?php echo base_url('assets/admin/plugins/toastr')?>/toastr.min.js"></script>		
<script>
$(function() {
	$('.datepicker1').datepicker({
      	todayHighlight: true,
		autoclose: true,
	   format: 'yyyy-mm-dd',
	   startDate: new Date(),
	 // endDate : new Date('2014-08-08'),
    }).on('changeDate', function (selected) {
   		 $(".datepicker2").attr("readonly", false);
		$('.datepicker2').focus();
	});;
	$('.datepicker2').datepicker({
      	todayHighlight: true,
		autoclose: true,
	   format: 'yyyy-mm-dd',
	   startDate: new Date(),
    }).on('changeDate', function (selected) {
   		var date1	= $(".datepicker1").datepicker('getDate');
		var date2	= $(".datepicker2").datepicker('getDate');
		if(date2<date1){
			toastr.error('Checkout Date Must Be Greater Then Checkout Date');
			$('.datepicker2').val('');
			$('.datepicker2').focus();
		}else{
			check_availbility();
		}
	});
    $('.idBuild').change(function(){
        var idBuilding = $(this).val();
        getKamarById(idBuilding)
    });
    $('.room_type_id').change(function(){
        var id = $(this).val();
        console.log(id);
        getRoomById(id)
    });

});	

function getRoomById(id) {

    if (id != "") {
        $.ajax({
            url: '<?php echo site_url('admin/bookings/getRoomById') ?>',
            type:'POST',
            dataType: 'json',
            data:{ id : id},
            success:function(result){
                var $el = $(".roomNo");
                $el.empty(); // remove old options
                $.each(result, function(key,value) {
                $el.append($("<option></option>")
                    .attr("value", value.room_no).text(value.room_no));
                });
            }
            
        });
    } else {
        var $el = $(".roomNo");
        $el.empty(); 
    }
}
function getKamarById(idBuilding) {
    if (idBuilding != "") {
        $.ajax({
            url: '<?php echo site_url('admin/bookings/getKamar') ?>',
            type:'POST',
            dataType: 'json',
            data:{ idBuilding : idBuilding},
            success:function(result){
                var $el = $(".room_type_id");
                $el.empty(); // remove old options
                $el.append($("<option></option>")
                    .attr("value", "").text("Pilih Kamar"));
                $.each(result, function(key,value) {
                $el.append($("<option></option>")
                    .attr("value", value.idTypeRooms).text(value.title));
                });
            }
            
        });
    } else {
        var $el = $(".room_type_id");
        $el.empty();
        var $el = $(".roomNo");
        $el.empty();
    }
}


function getKamar() {
    $.ajax({
		url: '<?php echo site_url('admin/bookings/check_availability') ?>',
		type:'POST',
		data:$('#add_form').serialize(),
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					remove_loader();
					get_order_data();
				}
				else
				{
					remove_loader();
					toastr.error(result);
				}
		 }
	  });
}

function check_availbility(){
	call_loader();
	$.ajax({
		url: '<?php echo site_url('admin/bookings/check_availability') ?>',
		type:'POST',
		data:$('#add_form').serialize(),
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					remove_loader();
					get_order_data();
				}
				else
				{
					remove_loader();
					toastr.error(result);
				}
		 }
	  });

}


function get_order_data(){
	call_loader();
	$.ajax({
		url: '<?php echo site_url('admin/bookings/get_booking_data') ?>',
		type:'POST',
		data:$('#add_form').serialize(),
		success:function(result){
			//alert(result);return false;
			  $('#order_data').html(result);
			  $('#next').show();
			  remove_loader();
		 }
	  });
}

</script>