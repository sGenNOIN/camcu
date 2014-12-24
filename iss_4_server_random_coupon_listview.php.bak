<?
   // 세션 시작
   session_start();

   // 데이터베이스 접속 문자열. (db위치, 유저 이름, 비밀번호)
   $connect=mysql_connect( "localhost", "camcu", "camcu12@") or  
        die( "SQL server에 연결할 수 없습니다.");

   mysql_query("SET NAMES UTF8");
   // 데이터베이스 선택
   mysql_select_db("camcu",$connect);
 

   //쿼리문 : coupon_table의 time과 shop_table의 매장명, 이미지 이름을 불러온다.
   $sql = "select COUPON_TABLE.time, SHOP_TABLE.shop_name, SHOP_TABLE.shop_image_name from SHOP_TABLE left outer join COUPON_TABLE on SHOP_TABLE.shop_name = COUPON_TABLE.shop_name;";
 
   // 쿼리 실행 결과를 $result에 저장
   $result = mysql_query($sql, $connect);
   // 반환된 전체 레코드 수 저장.
   $total_record = mysql_num_rows($result);
 
   // 반환된 각 레코드별로 JSONArray 형식으로 만들기.
   for ($i=0; $i < $total_record; $i++)                    
   {
    // 가져올 레코드로 위치(포인터) 이동  
    mysql_data_seek($result, $i);       
        
	$row = mysql_fetch_array($result);
   echo '{"time":'.$row[time].'}'; //시간
   echo '{"shop name":'.$row[shop_name].'}'; //매장명
   echo '{"shop image name":'.$row[shop_image_name].'}'; //매장 이미지명
   echo '<br>';

   }
?>