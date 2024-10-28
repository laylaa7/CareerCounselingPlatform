<?php 
$userId = (isset($_GET['ID']) && $_GET['ID'] != '') ? $_GET['ID'] : 0;
$rid = (isset($_GET['RID']) && $_GET['RID'] != '') ? $_GET['RID'] : 0;
$usql	= "SELECT *, r.NameOfStudent, r.status as status FROM tbl_users u, tbl_reservations r WHERE u.id = $userId AND r.id = $rid";
$res 	= dbQuery($usql);
while($row = dbFetchAssoc($res)) {
	extract($row);
	$stat = '';
	
	if($status == "ACTIVE") {$stat = 'success';}
	else if($status == "PENDING") {$stat = 'warning';}
	else if($status == "DENIED") {$stat = 'danger';}
?>
<div class="col-md-9">
  <div class="box box-solid">
    <div class="box-header with-border"> <i class="fa fa-text-width"></i>
      <h3 class="box-title">Counselor Details</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <dl class="dl-horizontal">
        <dt>Counselor Name</dt>
        <dd><?php echo $name; ?></dd>
        
		<dt>Address</dt>
        <dd><?php echo $address; ?></dd>
		
		<dt>Email</dt>
        <dd><?php echo $email; ?></dd>
		
		<dt>Phone</dt>
        <dd><?php echo $phone; ?></dd>
    
    <dt>Name of Student</dt>
        <dd><?php echo $NameOfStudent; ?> </dd>
		
		<dt>Booking Status</dt>
        <dd><span class="label label-<?php echo $stat; ?>"><?php echo $status; ?></span></dd>
		
      </dl>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
<?php 
}
?>
