<?php
include "administrator/payments/config.php";

if(isset($_GET["ACTION_CODE"]))
{
	if($_GET["ACTION_CODE"]==000)
	{
		$orderidid = $_GET['orderid'];
		$orderidid = (int)$orderidid;
		//Այստեղ դնել նորմալ տեքստ, սա պիտի տեսննի վճարողը
		echo "Payment recived";


		$con=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
		if (mysqli_connect_errno()) {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		

		$sql = "SELECT * FROM orders WHERE ordernumber=$orderidid";
		$results = mysqli_query($con,$sql);
		$data = mysqli_fetch_array($results);
		$subject = "Payment Recived: ".$data["ordernumber"];
		foreach($data as $key => $value) {
			if(!is_int($key))
			{
				if($key=="amount")
				{
					$value/=100;	
				}	
				$massage.=$key.":".$value."<br>";
			}
				
		}

		//echo "$subject<br>";
		//echo $massage;

		mysqli_close($con);
	
		mail($adminmail, $subject, $massage, "$adminmail\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=utf-8\r\n");

	}
	else
	{
		//Եթե չստացվեց գործարքը, ասենք եթե այդքան փող չունի քարտի վրա կամ այլ պատճառներով
		//Դնել նորմալ տեքստ, վճարողը սա պիտի տեսնի
		echo "try later";
	}
}



if(isset($_GET['p']) && $_GET['p']!="")
{	
	$ORDERNUMBER = $_GET['p']; 
	$ORDERNUMBER = (int)$ORDERNUMBER;
	
	$con=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	if (mysqli_connect_errno()) {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  die();
		}
		$sql = "SELECT ordernumber,amount,name,orderdescription 
				FROM orders 
				WHERE ordernumber=$ORDERNUMBER 
				ORDER BY orderdate DESC";

		$results = mysqli_query($con,$sql);
		$data = mysqli_fetch_array($results);  
		$AMOUNT = $data["amount"];
		$ORDERNUMBER = $data["ordernumber"];
		$ORDERDESCRIPTION = $data["orderdescription"];

		mysqli_close($con);

		if($AMOUNT>0 && $ORDERNUMBER>0)
		{
			$url=$baseURL."Merchant2Rbs?MERCHANTNUMBER=$MERCHANTNUMBER&ORDERNUMBER=$ORDERNUMBER&AMOUNT=$AMOUNT&DEPOSITFLAG=$DEPOSITFLAG&BACKURL=$BACKURL$ORDERNUMBER&".'$ORDERDESCRIPTION'."=$ORDERDESCRIPTION&LANGUAGE=$LANGUAGE&MERCHANTPASSWD=$MERCHANTPASSWD&MODE=1";
			$orderIDatARCA = file_get_contents($url);
			//echo $orderIDatARCA;
			
			$payurl="$baseURL/BPC/AcceptPayment.jsp?MDORDER=$orderIDatARCA"; 
			header("location: ".$payurl);
			//exit;
			//echo "<a target='_blank' href='$url'>click</a>";
			/*
			$url = $baseURL."Merchant2Rbs";
			$params = array('MERCHANTNUMBER'=>$MERCHANTNUMBER
						,'ORDERNUMBER'=>$ORDERNUMBER
						, 'AMOUNT'=>$AMOUNT
						, 'DEPOSITFLAG'=>$DEPOSITFLAG
						, 'BACKURL'=>$BACKURL						
						, '$ORDERDESCRIPTION'=>$ORDERDESCRIPTION
						, 'LANGUAGE'=>$LANGUAGE
						, 'MERCHANTPASSWD'=>$MERCHANTPASSWD
						);
			*/

		}

 } 

?>