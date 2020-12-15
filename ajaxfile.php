<?php
	//	error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);

	     session_start();
	if ($_SESSION['usertype'] == ""){
		 session_unset();
            session_destroy();
            header('Location: '.SITE_URL.'signin.php');
	}
	
	
	
	  $merchantid = $_SESSION['merchantid'];
    $usertype = $_SESSION['usertype'];
	
	include_once(dirname(__FILE__) . "/local/dbbackoffice.php");
	$conn = OpenCon();
	$merchantid ="long88banktx";
	
	## Read value
	$draw = $_POST['draw'];
	$rowstart = $_POST['start'];
	$rowperpage = $_POST['length']; // Rows display per page
	$columnIndex = $_POST['order'][0]['column']; // Column index
	$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
	$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
	$searchValue = $_POST['search']['value']; // Search value
	//modified by delwar
	$merchantidSearch = $_POST['columns'][1]['search']['value']; // Search value
	$statusSearch = $_POST['columns'][5]['search']['value']; // Status value
	$statusSearchVal = null;
	if(isset($statusSearch) and !empty($statusSearch)){
		if($statusSearch == "成功"){
			$statusSearchVal = "true";
		}elseif ($statusSearch == "待定") {
			$statusSearchVal = "Unpaid";
		}else{
			$statusSearchVal=null;
		}
	}
	
	if(isset($merchantidSearch) and !empty($merchantidSearch)){
		$searchValue = $merchantidSearch;
	}
	//modificed by delwar
	
	$searchArray = array();

	$from = null;
	$to = null;
	if( isset($_GET['from']) && isset($_GET['to']) ){
		$from = $_GET['from'];
		$to = $_GET['to'];
	}
	
	
	
	## Search 

	
	## Total number of records with filtering
	
	$countQuery = "SELECT COUNT(*) AS allcount FROM orders where merchantid='samo'";
	$all= true;
	$stmt = $conn->prepare($countQuery);
	$stmt->execute();
	$result = $stmt->get_result();
	
	if($row = $result->fetch_assoc()) {
		$totalRecords = $row['allcount'];
	}
	$stmt->close(); 

	$stmt = null;
	
	if($searchValue != "" && ($from != null && $to !=null) &&  isset($statusSearchVal)){
		$countQuery = "SELECT COUNT(*) AS allcount FROM orders
		WHERE ((bankaccount = ? or merchantorderid=?) and orderstatus=? and ( date(createddatetime) >= ? and date(createddatetime) <= ? ))  and merchantid='samo'";
		$stmt = $conn->prepare($countQuery);
		$stmt->bind_param('sssss',$searchValue,$searchValue,$statusSearchVal,$from,$to);
		$all = false;
		 
	}else if($searchValue != "" && ($from != null && $to !=null)){
		$countQuery = "SELECT COUNT(*) AS allcount FROM orders
		WHERE ((bankaccount = ? or merchantorderid=?) and ( date(createddatetime) >= ? and date(createddatetime) <= ? ))  and merchantid='samo'";
		$stmt = $conn->prepare($countQuery);
		$stmt->bind_param('ssss',$searchValue,$searchValue,$from,$to);
		$all = false;
		
	}else if(($from != null && $to !=null) &&  isset($statusSearchVal)){
		$countQuery = "SELECT COUNT(*) AS allcount FROM orders
		WHERE (orderstatus=? and ( date(createddatetime) >= ? and date(createddatetime) <= ? ))  and merchantid='samo'";
		$stmt = $conn->prepare($countQuery);
		$stmt->bind_param('sss',$statusSearchVal,$from,$to);
		$all = false;
		
	}elseif($searchValue != "" &&  isset($statusSearchVal)){
		$countQuery = "SELECT COUNT(*) AS allcount FROM orders
		WHERE ((bankaccount = ? or merchantorderid=?) and orderstatus=?)  and merchantid='samo'";
		$stmt = $conn->prepare($countQuery);
		$stmt->bind_param('sss',$searchValue,$searchValue,$statusSearchVal);
		$all = false;
		
	}else{

		if($searchValue != ""){
			$countQuery = "SELECT COUNT(*) AS allcount FROM orders WHERE (bankaccount = ? or merchantorderid=?)  and merchantid='samo'";
			$stmt = $conn->prepare($countQuery);
			$stmt->bind_param('ss',$searchValue,$searchValue);
			$all = false;
		}elseif($from != null && $to !=null){
			$countQuery = "SELECT COUNT(*) AS allcount FROM orders WHERE (( date(createddatetime) >= ? and date(createddatetime) <= ? ))  and merchantid='samo'";
			$stmt = $conn->prepare($countQuery);
			$stmt->bind_param('ss',$from,$to);
			$all = false;
		}elseif(isset($statusSearchVal)){
			$countQuery = "SELECT COUNT(*) AS allcount FROM orders WHERE orderstatus=?  and merchantid='samo'";
			$stmt = $conn->prepare($countQuery);
			$stmt->bind_param('s',$statusSearchVal);
			$all = false;
		}else{
			$stmt = $conn->prepare($countQuery);
			$all = true;
		}
		
	}

	$stmt->execute();
	$result = $stmt->get_result();		
	if($row = $result->fetch_assoc()) {
		
		
			$totalRecordwithFilter = $row['allcount'];
		
	}
	$stmt->close();

	
	
	
	
	
	
	
	## Fetch records
	$query = "SELECT * FROM orders WHERE  merchantid='samo' order by orderid desc LIMIT ?,?";
	if($searchValue != "" && ($from != null && $to !=null) &&  isset($statusSearchVal)){
		$query = "SELECT * FROM orders WHERE ((bankaccount = ? or merchantorderid=?) and orderstatus=? and ( date(createddatetime) >= ? and date(createddatetime) <= ? ))  and merchantid='samo' order by orderid desc LIMIT ?,?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('sssssss',$searchValue,$searchValue,$statusSearchVal,$from,$to,$rowstart, $rowperpage);
		
	}else if($searchValue != "" && ($from != null && $to !=null)){
		$query = "SELECT * FROM orders WHERE ((bankaccount = ? or merchantorderid=?) and ( date(createddatetime) >= ? and date(createddatetime) <= ? ))  and merchantid='samo' order by orderid desc LIMIT ?,?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('ssssss',$searchValue,$searchValue,$from,$to,$rowstart, $rowperpage);
	}elseif($searchValue != "" &&  isset($statusSearchVal)){
		$query = "SELECT * FROM orders WHERE ((bankaccount = ? or merchantorderid=?) and orderstatus=?)  and merchantid='samo' order by orderid desc LIMIT ?,?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('sssss',$searchValue,$searchValue,$statusSearchVal,$rowstart, $rowperpage);
	}else if(($from != null && $to !=null) &&  isset($statusSearchVal)){
		$query = "SELECT * FROM orders WHERE (orderstatus=? and ( date(createddatetime) >= ? and date(createddatetime) <= ? ))  and merchantid='samo' order by orderid desc LIMIT ?,?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('sssss',$statusSearchVal,$from,$to,$rowstart, $rowperpage);
	}else{
		if($searchValue != ""){
			$query = "SELECT * FROM orders WHERE (bankaccount = ? or merchantorderid=?)   and merchantid='samo' order by orderid desc LIMIT ?,?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param('ssss',$searchValue,$searchValue,$rowstart, $rowperpage);
		}elseif($from != null && $to !=null){
			$query = "SELECT * FROM orders WHERE ( date(createddatetime) >= ? and date(createddatetime) <= ? )  and merchantid='samo' order by orderid desc LIMIT ?,?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param('ssss',$from,$to,$rowstart, $rowperpage);
		}elseif(isset($statusSearchVal)){
			$query = "SELECT * FROM orders WHERE orderstatus=? and merchantid='samo' order by orderid desc LIMIT ?,?";
			$stmt = $conn->prepare($query);
			$stmt->bind_param('sss',$statusSearchVal,$rowstart, $rowperpage);	
		}else{
			$stmt = $conn->prepare($query);
			$stmt->bind_param('ss',$rowstart, $rowperpage);
		}
	}
	
	
	$stmt->execute();
	$result = "";
	$result = $stmt->get_result();
	
	
	$data = array();
	$row ="";
	while($row = $result->fetch_assoc()) {
		
		$orderstatus = $row['orderstatus'];
		if ($orderstatus =="true") {
			$orderstatus ="成功";
		}
		if ($orderstatus =="Unpaid") {
			$orderstatus ="待定";
		}
		
		
	
				
//modified by delwar
$layout="<button class='change_status' data-id='".$row['merchantorderid'] ."' value='".$row['merchantorderid'] . "'  data-toggle='modal' data-target='#statusModal'>Change Status</button>";
											 
		
		$data[] = array(
		"layout"=>$layout,
		"merchantorderid"=>$row['merchantorderid'],
		"orderamount"=>$row['orderamount'],
		"modifyorderamount"=>$row['originalorderamount'],
		"bankaccount"=>$row['bankaccount'],
		"orderstatus"=>$orderstatus,
		"createddatetime"=>$row['createddatetime'],
		"updateddatetime"=>$row['updateddatetime']
        );
	}
	
	$stmt->close();
	
	//var_dump($data[]);
	## Response
	$response ="";
	$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
	);
	
	

	
	echo json_encode($response);
