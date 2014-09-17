<?php
include "config.php";
	
$paymentid = date("y").date("m").date("d").rand(000,999);

if(isset($_GET['paymentid'])
	&& isset($_GET['name'])
	&& isset($_GET['amount'])
	&& isset($_GET['email'])
	&& isset($_GET['info'])
	)
{
	$paymentid = $_GET['paymentid'];
	$name = $_GET['name'];
	$amount = number_format(floatval($_GET['amount'])); 
	$amount_incents = $amount*100; //որպիսի դառնա կոպեկներով արտահայտված 
	$email=$_GET['email'];
	$info = $_GET['info'];

	if($paymentid!="" && $name!="" && $amount!="" && $email!="" && $info!="")
	{

		$con=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
		if (mysqli_connect_errno()) {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}


		$sql = "INSERT INTO orders (ordernumber,amount,name,orderdescription,email) VALUES ('$paymentid','$amount_incents','$name','$info','$email')";
		if(mysqli_query($con,$sql))
		{
			$sendmail = true;
		}
		else
		{
			echo "Չստացվեց Փորձիր նորից";
		}

		mysqli_close($con);
	}

	if($sendmail)
	{
		$subject = "Payment Confirmation $paymentid";
		//Կառուցել HTML, տեսքը թողնում եմ քո վրա, ինքդ արա :)
		//Կարող ես օգտագործել հետևյալ փոփոխականները $paymentid,$name,$amount,$email,$info
		$message = "գրիր քո մեյլի HTML պարունակությունը<br>";
		$message.="<a href='processing.php?p=$paymentid'>վճարել հիմա</a>"; 
		
		mail($email,$subject,$message,"From: $adminmail\r\n MIME-Version: 1.0\r\n Content-Type: text/html; charset=utf-8\r\n");
		mail($adminmail,$subject,$message,"From: $adminmail\r\n MIME-Version: 1.0\r\n Content-Type: text/html; charset=utf-8\r\n");
		//echo $message;
			
	}

}

?>

<form action="" method="get">
	<p>Send payment notification to client</p>
	<input type="text" name="paymentid" value="<?php echo $paymentid ?>" placeholder="Transaction Number"><br>
	<input type="text" name="name" placeholder="Name"><br>
	<input type="text" name="amount" placeholder="Amount"><br>
	<input type="email" name="email" placeholder="e-mail"><br>
	<textarea name="info" cols="25" rows="5"></textarea><br>
	<input type="submit" value="Submit"><br>
</form>

