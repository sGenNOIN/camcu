	<?
    // 데이터베이스 접속 문자열. (db위치, 유저 이름, 비밀번호)
    $connect=mysql_connect( "localhost", "camcu", "camcu12@") or  
        die( "SQL server에 연결할 수 없습니다.");

    mysql_query("SET NAMES UTF8");
	// 데이터베이스 선택 !
	mysql_select_db("camcu",$connect);
 
	// 세션 시작 !
	session_start();

	//진입 테스트
	echo "in iss_4_server_lotto.php\n";
	
	//get방식으로 전송된 데이터를 받는다.
	//$beacon_uuid = $_POST["beacon_uuid"];
	$beacon_uuid = "aaaa";

	echo " 비콘 값 : $beacon_uuid\n";

	// 쿼리문 생성 - 비콘 UUID와 일치하는 음식점의 이름을 검색하는 쿼리
	//$sql_shop_name = "select shop_name from SHOP_TABLE where shop_beacon_device_number =.'$beacon_uuid'.";
	$sql_shop_name = "select shop_name from SHOP_TABLE where shop_beacon_device_number = '".$beacon_uuid."'";

	// 쿼리문을 수행하여 DB에서 찾아낸 shop_name 찾아낸다. 이후 변수에 결과값을 저장
	$result_shop_name = mysql_query($sql_shop_name, $connect);
	$shop_name = mysql_result($result_shop_name,0);

	echo " 출력 결과 : $shop_name";

	$sql_coupon_name = "select coupon_name from COUPON_TABLE where shop_name = '".$shop_name."'";

	$result_coupon_name = mysql_query($sql_coupon_name, $connect);

	$total_record_coupon_name = mysql_num_rows($result_coupon_name);

	//랜덤값 생성
	$random_val = rand() % 5000 ;

	echo "random : $random_val";

	for ($i=0; $i < $total_record_coupon_name; $i++)                    
	{
		// 가져올 레코드로 위치(포인터) 이동  
		mysql_data_seek($result_coupon_name, $i);       
        
		$row = mysql_fetch_array($result_coupon_name);
		echo "{\"coupon_name\":\"$row[coupon_name]\"}";
    
	}

   //****** 모든 수행절차 종료 후 Json 형식으로 리턴시 사용
   
   /* 반환된 전체 레코드 수 저장.
   $total_record = mysql_num_rows($result);
	 
   /* JSONArray 형식으로 만들기 위해서...
   echo "{\"status\":\"OK\",\"num_results\":\"$total_record\",\"results\":[";

   // 반환된 각 레코드별로 JSONArray 형식으로 만들기.
   for ($i=0; $i < $total_record; $i++)                    
   {
      // 가져올 레코드로 위치(포인터) 이동  
      mysql_data_seek($result, $i);       
        
      $row = mysql_fetch_array($result);
   echo "{\"id\":$row[id]\"}";
 
   // 마지막 레코드 이전엔 ,를 붙인다. 그래야 데이터 구분이 되니깐.  
   if($i<$total_record-1){
      echo ",";
   }
    
   }
   
   // JSONArray의 마지막 닫기
   echo "]}";
	
	*/


?>