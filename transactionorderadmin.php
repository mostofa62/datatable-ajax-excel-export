<?php 
	include_once('templates/header.php');
		ini_set("log_errors", 1);
	ini_set("error_log", "errorpage/php-error.log");
	
	
	$page_name = 'transactionorderadmin';
	// $appId = $_SESSION['appId'];
    $merchantid = $_SESSION['merchantid'];
	$sourceFileName ="transactionorderadmin";
$merchantid ="samo";
	
    $usertype = $_SESSION['usertype'];
	
		if  ($_SESSION['usertype'] !== "admin"){
			header('Location: '.SITE_URL.'dashboard.php');
		}
    if($merchantid == null) $merchantid = "";
    $query = $conn->prepare("SELECT * FROM orders where merchantid=?  ORDER BY createddatetime desc LIMIT 200");
    $query->bind_param("s", $merchantid);
    $query->execute();
    $result = $query->get_result();
	
    $query2 = $conn->prepare("SELECT * FROM orders where merchantid=? ORDER BY createddatetime ASC LIMIT 1");
	$query2->bind_param("s", $merchantid);
	$query2->execute();
    $result2 = $query2->get_result();
    $startdateData = $result2->fetch_assoc();
	// $sdate = date("m/d/Y", strtotime($startdateData['createddatetime']));
	// $edate = date("m/d/Y");
	
	$sdate = date("m/d/Y", strtotime($startdateData['createddatetime']));
	$your_date = strtotime("1 day", date("m/d/Y"));
	$new_date = date("Y-m-d", $your_date);
    $edate = $your_date;
	
	
	
    if(isset($_POST['change_status'])) {

			$orderid = $_POST['orderid'];
		error_log("89080orderid:" . $orderid);
			
			
			echo 'success';
			exit;
		}
        //header('Location: '.SITE_URL.'transaction.php');
		
	
	
	
	
?>

<?php include_once('templates/menu.php'); ?>
 <link href='DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
  
		
<section class="content">
	<div class="container-fluid">
		<div class="block-header">
            <h2>订单管理</h2>
		</div>
        <div class="row clearfix">
        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        		<div class="card">
        			<div class="header">
        				<h2>订单管理</h2>
					</div>
        			<div class="body">
        				<div class="row">
        					<div class="col-md-3">
        						<div class="input-group">
			                        <span class="input-group-addon">
			                            <i class="material-icons">email</i>
									</span>
			                        <div class="form-line">
			                            <input class="form-control filter-orderid" placeholder="订单号">
									</div>
								</div>
							</div>
        					<div class="col-md-3">
        						<div class="input-group">
			                        <span class="input-group-addon">
			                            <i class="material-icons">email</i>
									</span>
			                        <div class="form-line">
			                            <select class="form-control show-tick filter-status">
			                                <option value="" disabled selected>状态</option>
			                                <option value="">全部</option>
			                                <option >待定</option>
			                                <option>成功</option>
										</select>
									</div>
								</div>
							</div>
        					
        					<div class="col-md-3">
        						<input type="text" name="daterange" id="daterange" value="" class="form-control filter-date" />
                                <input type="hidden" name="defaultdaterange" id="defaultdaterange" value="<?php echo $sdate.' - '.$edate;?>">
							</div>
						</div>
        				<div class="table-responsive">
        					
							<table id='empTable' class='display dataTable  '>
                <thead>
					<tr>
                    	<th>订单号</th>
						<th>订单号</th>
						<th>金额</th>
						<th>实收金额</th>
						<th>户口</th>
						<th>状态</th>
						<th>创立时间</th>
						<th>成功时间</th>
					</tr>
				</thead>
                
			</table>

			<!-- <table id='empTable1' class='display dataTable  '>
                <thead>
					<tr>
                    	<th>订单号</th>
						<th>订单号</th>
						<th>金额</th>
						<th>实收金额</th>
						<th>户口</th>
						<th>状态</th>
						<th>创立时间</th>
						<th>成功时间</th>
					</tr>
				</thead>
                
			</table> -->
							
							<?php /* ?>
							<table class="table table-bordered table-striped table-hover js-exportable dataTable">
        						<thead>
        							<tr>
										<th>操作</th>
        								<th>订单号</th>
										<th>金额</th>
										<th>实收金额</th>
        								<th>户口</th>
        								<th>状态</th>
        								<th>创立时间</th>
										<th>成功时间</th>
										
        								<!-- <th></th> -->
										
									</tr>
								</thead>
        						<tbody>
        							<?php while($row = $result->fetch_assoc()) {?>
										<tr>
											<td>
												<button class="change_status" value="<?= $row['merchantorderid'];?>"  orderid="<?= $row['merchantorderid'];?>" data-toggle="modal" data-target="#statusModal">Change status</button>
											
												
											</td>
											<td><?= $row['merchantorderid'];?></td>
											<td><?= $row['orderamount'];?></td>
												<td><?= $row['modifyorderamount'];?></td>
											<td><?= $row['bankaccount'];?></td>
											<?php
												$orderstatus = $row['orderstatus'];
												if ($orderstatus =="true") {
													$orderstatus ="成功";
												}
												if ($orderstatus =="Unpaid") {
													$orderstatus ="待定";
												}
											?>
											<td><?= $orderstatus ;?></td>
											
											<td><?= $row['createddatetime'];?></td>
											<td><?= $row['updateddatetime'];?></td>

											
										</tr>
									<?php }?>
								</tbody>
							</table>
							<?php */ ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="statusModalLabel">确认补单?！</h4>
			</div>
            <form method='POST' id="statusForm">
                <div class="modal-body">
                    <input type="hidden" name="orderid" value="">
                    <h4>please confirm</h4>
					
				
				</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect change_btn" name="change_status">确认补单</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">关闭</button>
				</div>
			</form>
		</div>
	</div>
</div>


<?php include_once('templates/footer.php');?>