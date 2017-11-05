<?php 
$this->load->model(array('dashboard_model'));

$orders		=	$this->dashboard_model->get_orders();
$guests		=	$this->dashboard_model->get_guests();	
$rooms		=	$this->dashboard_model->get_rooms();
$trevenue			=	$this->dashboard_model->get_todays_revenue();
$new_bookings		=	$this->dashboard_model->get_latest_bookings(5);
?>

 <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
     </div>
    <strong>Copyright &copy; <?php echo date('Y')?> <?php echo $this->setting->name?>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading"><?php echo lang('bookings')?></h3>
        <ul class="control-sidebar-menu">
          <?php foreach($new_bookings as $new){
		  			$status	=	'';
					$cls	=	'';
					if($new->payment_status==0){
						$status	=	lang('failed');
						$cls	=	'danger';
					}
					if($new->payment_status==1){
						$status	=	lang('success');
						$cls	=	'success';
					}
					if($new->payment_status==2){
						$status	=	lang('pending');
						$cls	=	'warning';
					}
					if($new->payment_status==3){
						$status	=	lang('partialy_paid');
						$cls	=	'info';
					}
		  ?>
		  <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                <span style="padding:5px"><a href="<?php echo site_url('admin/bookings/booking/'.$new->id) ?>" target="_blank"><?php echo $new->order_no?></a></span> <?php echo $new->firstname?> <?php echo $new->lastname?>
                <span class="label label-<?php echo $cls?> pull-right"><?php echo $status?></span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-<?php echo $cls?>" style="width: 100%"></div>
              </div>
            </a>
          </li>
          <?php } ?>
        </ul>
        <!-- /.control-sidebar-menu -->


		<h3 class="control-sidebar-heading"><?php echo lang('site_statistics')?></h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-list-alt bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?php echo count($orders)?></h4>

                <p><?php echo lang('orders')?></p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon bg-yellow"><?php echo $this->setting->currency_symbol?></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?php echo number_format($trevenue->amount,2)?></h4>

                <p><?php echo lang('today_revenue')?></p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-home bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?php echo count($rooms)?></h4>

                <p><?php echo lang('rooms')?></p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-users bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?php echo count($guests)?></h4>

                <p><?php echo lang('guests')?></p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        
      </div>
      <!-- /.tab-pane -->

    
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->

<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('assets/admin')?>/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url('assets/admin')?>/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/admin')?>/dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('assets/admin')?>/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('assets/admin')?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url('assets/admin')?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?php echo base_url('assets/admin')?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?php echo base_url('assets/admin')?>/plugins/chartjs/Chart.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/admin')?>/dist/js/demo.js"></script>
<script src="<?php echo base_url('assets/admin/plugins/toastr/toastr.min.js')?>" type="text/javascript"></script>
<script>
$(".lang").click(function(e){
	  //alert(this.id);return false;
	  call_loader();
	$.ajax({
		url: '<?php echo site_url('admin/languages/switch_language') ?>',
		type:'POST',
		data:{id:this.id},
		success:function(result){
		//alert(result);return false;
			  if(result)
				{
					location.reload(); 
			   }
				else
				{
					remove_loader();
				}
		
		 }
	  });
	
	event.preventDefault();
});
function remove_loader()
{
	$('#overlay1').remove();
}
function call_loader(){
	
	if($('#overlay1').length == 0 ){
		var over = '<div id="overlay1">' +
						'<img  style="padding-top:300px; margin: 0 auto; " class="img-responsive " id="loading" src="<?php echo base_url('assets/admin/dist/img/ajax-loader.gif')?>"></div>';
		
		$(over).appendTo('body');
	}
}
</script>
</body>
</html>
