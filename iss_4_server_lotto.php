	<?
    // 데이터베이스 접속 문자열. (db위치, 유저 이름, 비밀번호)
    $connect=mysql_connect( "localhost", "camcu", "camcu12@") or  
        die( "SQL server에 연결할 수 없습니다.");

    mysql_query("SET NAMES UTF8");
	// 데이터베이스 선택 !
	mysql_select_db("camcu",$connect);
 
	// 세션 시작 !
	session_start();

	//POST방식으로 전송된 데이터를 받는다. 
	//$beacon_uuid = $_POST["beacon_uuid"];
	$beacon_uuid = "aaaa";

	// 쿼리문 생성 - 비콘 UUID와 일치하는 음식점의 이름을 검색하는 쿼리
	$sql_shop_name = "select shop_name from SHOP_TABLE where shop_beacon_device_number = '".$beacon_uuid."'";

	// 쿼리문을 수행하여 DB에서 찾아낸 shop_name 찾아낸다. 이후 변수에 결과값을 저장
	$result_shop_name = mysql_query($sql_shop_name, $connect);
	$shop_name = mysql_result($result_shop_name,0);

	//
	$sql_coupon_name = "select coupon_name from COUPON_TABLE where shop_name = '".$shop_name."'";
	$result_coupon_name = mysql_query($sql_coupon_name, $connect);
	$total_record_coupon_name = mysql_num_rows($result_coupon_name);

	//rand()함수를 이용하여 랜덤값 생성. 0~4999 생성.
	$random_val = rand() % 5000 ;

	//배열 생성
	$row_array = array();

	for ($i=0; $i < $total_record_coupon_name; $i++)                    
	{
		// 가져올 레코드로 위치(포인터) 이동  
		mysql_data_seek($result_coupon_name, $i);       
        
		$row = mysql_fetch_array($result_coupon_name);
		
		//현재 &row에 저장되어 있는 
		array_push($row_array, $row[coupon_name]);
	}
	$cnt = count($row_array);
	
	$random_val = rand()%$cnt;
	echo '{"coupon_name":'.$row_array[$random_val].'}'
	/*
	//랜덤 함수를 이용하여 생성된 랜덤값에 따라 쿠폰 출력을 달리한다.
	if($random_val >= 0 && $random_val <= 50)
	{
		echo "{\"coupon_name\":$row_array[1]\"}";
	}
	else if($random_val >= 51 && $random_val <= 500)
	{
		echo "{\"coupon_name\":$row_array[2]\"}";
	}
	else if($random_val >= 501 && $random_val <= 2000)
	{
		echo "{\"coupon_name\":$row_array[3]\"}";
	}
	else if($random_val >= 2001 && $random_val <= 5000)
	{
		echo "{\"coupon_name\":$row_array[4]\"}";
	}
	*/
?>