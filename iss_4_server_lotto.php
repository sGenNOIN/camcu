	<?
	// ���� ���� !
	session_start();

    // �����ͺ��̽� ���� ���ڿ�. (db��ġ, ���� �̸�, ��й�ȣ)
    $connect=mysql_connect( "localhost", "camcu", "camcu12@") or  
        die( "SQL server�� ������ �� �����ϴ�.");

    mysql_query("SET NAMES UTF8");
	// �����ͺ��̽� ���� !
	mysql_select_db("camcu",$connect);

	//POST������� ���۵� �����͸� �޴´�. 
	//$beacon_uuid = $_POST["beacon_uuid"];
	$beacon_uuid = "aaaa";

	// ������ ���� - ���� UUID�� ��ġ�ϴ� �������� �̸��� �˻��ϴ� ����
	$sql_shop_name = "select shop_name from SHOP_TABLE where shop_beacon_device_number = '".$beacon_uuid."'";
	// ������ ����
	$result_shop_name = mysql_query($sql_shop_name, $connect);
	// �������� ����� $shop_name�� ����
	$shop_name = mysql_result($result_shop_name,0);

	// ������ ���� - $shop_name�� �̿��Ͽ� �ش� ������ ������ ��� ������� ����
	$sql_coupon_name = "select coupon_name from COUPON_TABLE where shop_name = '".$shop_name."' order by coupon_id";
	// �������� ����� $result_coupon_name�� ����
	$result_coupon_name = mysql_query($sql_coupon_name, $connect);
	// �������� �� ���ڵ� ���� $total_record_couponname�� ����
	$total_record_coupon_name = mysql_num_rows($result_coupon_name);

	//�迭 ����
	$row_array = array();

	for ($i=0; $i < $total_record_coupon_name; $i++)                    
	{
		// ������ ���ڵ�� ��ġ(������) �̵�  
		mysql_data_seek($result_coupon_name, $i);       
        
		//$row ������ $result_coupon_name �迭 ����
		$row = mysql_fetch_array($result_coupon_name);

		//���� &row�� ����Ǿ� �ִ� coupon_name�� $row_array �迭�� 0���� ����
		array_push($row_array, $row[coupon_name]);
	}

	//rand()�Լ��� �̿��Ͽ� ������ ����. 0~4999 ����.
	$random_val = rand() % 10000 ;

	//�� �迭�� ��
	$cnt = count($row_array);

	//������ ������ ���� �������� ����� �޸� �Ѵ�.
	//�ּ� 3���� ���س�������, 3�� ������ ��ǰ���� ���� ������ Ȯ���� ���������Ѵ�.
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