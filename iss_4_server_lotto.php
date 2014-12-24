	<?
	// 세션 시작 !
	session_start();

    // 데이터베이스 접속 문자열. (db위치, 유저 이름, 비밀번호)
    $connect=mysql_connect( "localhost", "camcu", "camcu12@") or  
        die( "SQL server에 연결할 수 없습니다.");

    mysql_query("SET NAMES UTF8");
	// 데이터베이스 선택 !
	mysql_select_db("camcu",$connect);

	//POST방식으로 전송된 데이터를 받는다. 
	//$beacon_uuid = $_POST["beacon_uuid"];
	$beacon_uuid = "aaaa";

	// 쿼리문 생성 - 비콘 UUID와 일치하는 음식점의 이름을 검색하는 쿼리
	$sql_shop_name = "select shop_name from SHOP_TABLE where shop_beacon_device_number = '".$beacon_uuid."'";
	// 쿼리문 수행
	$result_shop_name = mysql_query($sql_shop_name, $connect);
	// 쿼리문의 결과를 $shop_name에 저장
	$shop_name = mysql_result($result_shop_name,0);

	// 쿼리문 생성 - $shop_name을 이용하여 해당 상점의 쿠폰을 모두 갖어오는 쿼리
	$sql_coupon_name = "select coupon_name from COUPON_TABLE where shop_name = '".$shop_name."' order by coupon_id";
	// 쿼리문의 결과를 $result_coupon_name에 저장
	$result_coupon_name = mysql_query($sql_coupon_name, $connect);
	// 쿼리문의 총 레코드 수를 $total_record_couponname에 저장
	$total_record_coupon_name = mysql_num_rows($result_coupon_name);

	//배열 생성
	$row_array = array();

	for ($i=0; $i < $total_record_coupon_name; $i++)                    
	{
		// 가져올 레코드로 위치(포인터) 이동  
		mysql_data_seek($result_coupon_name, $i);       
        
		//$row 변수에 $result_coupon_name 배열 삽입
		$row = mysql_fetch_array($result_coupon_name);

		//현재 &row에 저장되어 있는 coupon_name을 $row_array 배열에 0부터 저장
		array_push($row_array, $row[coupon_name]);
	}

	//rand()함수를 이용하여 랜덤값 생성. 0~4999 생성.
	$random_val = rand() % 10000 ;

	//총 배열의 수
	$cnt = count($row_array);

	//쿠폰의 개수에 따라서 쿠폰선택 방식을 달리 한다.
	//최소 3개로 정해놓았으며, 3등 이후의 상품들은 전부 동일한 확률로 뽑히도록한다.
	if($cnt == 3)
	{
		if($random_val >= 0 && $random_val <= 50)
		{
			echo '{"coupon_name":'.$row_array[0].'}';
		}
		else if($random_val >= 51 && $random_val <= 500)
		{
			echo '{"coupon_name":'.$row_array[1].'}';
		}
		else if($random_val >= 501 && $random_val <= 9999)
		{
			echo '{"coupon_name":'.$row_array[2].'}';
		}
	}
	else if($cnt > 3)
	{
		if($random_val >= 0 && $random_val <= 50)
		{
			echo '{"coupon_name":'.$row_array[0].'}';
		}
		else if($random_val >= 51 && $random_val <= 150)
		{
			echo '{"coupon_name":'.$row_array[1].'}';
		}
		else if($random_val >= 151 && $random_val <= 300)
		{
			echo '{"coupon_name":'.$row_array[2].'}';
		}
		else if($random_val >= 301 && $random_val <= 9999)
		{
			$random_coupon = mt_rand(3, $cnt-1);

			echo '{"coupon_name":'.$row_array[$random_coupon].'}';
		}
	}
		
?>