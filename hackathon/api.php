<?php
session_start();
error_reporting(0);
ini_set('date.timezone',"Asia/Calcutta");


require_once("Rest.inc.php");

class API extends REST {

    public $data = "";

       
    const DB_SERVER = "localhost";//"wizgift.db.10408667.hostedresource.com";
    const DB_USER = "dotsifrx_parking";
     const DB_PASSWORD = "Nimda@123";
    const DB = "dotsifrx_parking";

    // const DB_SERVER = "localhost";//"wizgift.db.10408667.hostedresource.com";
    //  const DB_USER = "phpadmin";
    //  const DB_PASSWORD = "nimda123";
    //  const DB = "task";
//mysql_connect("localhost","dotsiykt_app","Kalidoss123@");

//mysql_select_db("dotsiykt_app")or die("error");


    private $db = NULL;

    public function __construct() {
	
        parent::__construct();    // Init parent contructor
        $this->dbConnect();     // Initiate Database connection
      //  header("access-control-allow-origin: *");
    }

    /*

     *  Database connection 
     */

	private function dbConnect() {
	$this->db = mysql_connect(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD);
	if ($this->db)
	mysql_select_db(self::DB, $this->db);
	}
	
	private function json($data) {
	if (is_array($data)) {
	return json_encode($data);
	}
	}
	
	
	public function processApi() {
	
	$func = strtolower(trim(str_replace("/", "", $_REQUEST['rquest'])));
	if ((int) method_exists($this, $func) > 0)
	$this->$func();
	else {
	
	$this->response('', 404);
	}
	}

	public function sample()
	{
		//header('content-type: application/json; charset=utf-8');
		header("access-control-allow-origin: *");
		$result = array('status'=>'sample');
		$this->response($this->json($result), 200);
		
		//$data = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
		//echo $_GET['callback'] .json_encode($result);
	}
	
public function signup()
{
	if ($this->get_request_method() != "POST") {
		$this->response('', 406);
	}

	$siteurl='http://dotsit.in/parking/';

	if(!empty($this->_request['fname']) && !empty($this->_request['email']) 
			&& !empty($this->_request['mobile']) && !empty($this->_request['pwd'])
			&& !empty($this->_request['usertype']) ){
		$fname=$this->_request['fname'];
		$email =$this->_request['email'];
		$mobile =$this->_request['mobile'];
		$password =$this->_request['pwd'];
		$usertype =$this->_request['usertype'];
		$tmppassword=md5($password);
                $curdate=date("y-m-d h:i:s");

		if ($usertype=="user"){
			$sql="INSERT INTO vehicleowner (name,email,mobile,username,password,createddt,visible) VALUES ('$fname','$email','$mobile','$mobile','$tmppassword','$curdate','0')";
            mysql_query($sql)or die("query failed");

         $insertstatus=mysql_insert_id();
		$to = $email;
		$from = 'no-reply@dotsit.in';
		$subject= "ParkIt - Registration Verfication";
		$message = '<html><head>
           <title>Email Verification</title>
           </head>
           <body>';
$message .= '<p>Hi ' . $fname . '!</p>';
$message .= '<p>We need to make sure you are human. Please verify your email and get started using your App account.</p>';
$message .= '<p><a href="http://dotsit.in/parking/activate.php?id=' . base64_encode($insertstatus) . '">CLICK TO ACTIVATE YOUR ACCOUNT</a>';
$message .= "</body></html>";

			$headers = 'MIME-Version: 1.0' . "\r\n" . 
			'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
			$headers .= 'From: <no-reply@dotsit.in>' . "\r\n";
			
			

			mail($to, $subject, $message, $headers);


		} else if ($usertype=="owner"){
			$sql="INSERT INTO parkingowner (name,email,mobile,username,password,createddt,visible) VALUES ('$fname','$email','$mobile','$mobile','$tmppassword','$curdate','0')";
            mysql_query($sql)or die("query failed");
            $insertstatus=mysql_insert_id();
		$to = $email;
		$from = 'no-reply@dotsit.in';
		$subject= "ParkIt - Registration Verfication";
$message .= '<p>Hi ' . $fname . '!</p>';
$message .= '<p>We need to make sure you are human. Please verify your email and get started using your App account.</p>';
$message .= '<p><a href="http://dotsit.in/parking/activate1.php?id=' . base64_encode($insertstatus) . '">CLICK TO ACTIVATE YOUR ACCOUNT</a>';
$message .= "</body></html>";

			$headers = 'MIME-Version: 1.0' . "\r\n" . 
			'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
			$headers .= 'From: <no-reply@dotsit.in>' . "\r\n";
			
			

			mail($to, $subject, $message, $headers);
		}

		//$insertstatus=mysql_insert_id();

        if($insertstatus!='')
             {
            
             $result = array('status'=>'success');
                
             }
              else
              {
             $result = array('status'=>'fail');
               }
        }    
        else
        {
            $result = array('status'=>'fail');
        }
        $this->response($this->json($result), 200);
}

public function user_login()
	{
		if ($this->get_request_method() != "POST") 
		{
			$this->response('', 406);
		}
		
// $result = array('status'=>'success');

		if(!empty($this->_request['username']) && !empty($this->_request['password']) )
		//if(!empty($this->_request['mobid']))
		{

			
			$username=$this->_request['username'];
$password =$this->_request['password'];
$usertype =$this->_request['usertype'];
			$tmppassword=md5($password);

			//$deviceid =$this->_request['mobid'];

if ($usertype=="user")
{

			$sql = mysql_query("select * from vehicleowner where username = '".$username."' and password = '".$tmppassword."'");
			$data = mysql_fetch_assoc($sql);

}

if ($usertype=="owner")
{

			$sql = mysql_query("select * from parkingowner where username = '".$username."' and password = '".$tmppassword."'");
			$data = mysql_fetch_assoc($sql);

}

			//$result = array('status'=>$data,'userid'=>$data['id'],'firstname'=>$data['name'],'username'=>$data['username'],'email'=>$data['email']);
			 if($data)
			 {


			 if ($data['visible']=="1")
			 {
			
			 $result = array('status'=>'success','userid'=>$data['userid']);
			}
			else
			{
			$result = array('status'=>'fail2','userid'=>$data['userid']);

			}
				
			 }
			  else
			  {
			 $result = array('status'=>'fail');
			   }
		}	
		else
		{
			$result = array('status'=>'fail');
		}
		
		$this->response($this->json($result), 200);
	}


public function access_parking()
	{
		if ($this->get_request_method() != "POST") 
		{
			$this->response('', 406);
		}

$lat=$this->_request['lat'];
$lng=$this->_request['lng'];
$frmdatatime=$this->_request['frmdatatime'];
$toTime=$this->_request['totime'];


$pieces = explode(" ", $frmdatatime);
$fromDate=$pieces[0]; // piece1
$fromDate = date("Ymd", strtotime($fromDate));

$fromTime=$pieces[1]; // piece2
$fromTime=str_replace(":","",$fromTime);

$toTime=str_replace(":","",$toTime);

$toTime1=($fromDate.$toTime);

$ts1 = strtotime($frmdatatime);
$ts2 = strtotime($toTime1);
$diff = abs($ts1 - $ts2) / 3600;

// $lat='13.067307';
// $lng='80.252386';


// Get parameters from URL
$center_lat = $lat;
$center_lng = $lng;
$radius = '6';



// Search the rows in the markers table
$query = sprintf("SELECT parkingslotid, address,price, Latitude, Longitude, ( 3959 * acos( cos( radians('%s') ) * cos( radians( Latitude ) ) * cos( radians( Longitude ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( Latitude ) ) ) ) AS distance, (select count(*) from bookings where parkingslotid = parkingslot.parkingslotid and fromDate = '%s' and ((fromTime > '%s' and fromTime < '%s') or (toTime > '%s' and toTime < '%s'))) as count FROM parkingslot HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
 mysql_real_escape_string($center_lat),
 mysql_real_escape_string($center_lng),
 mysql_real_escape_string($center_lat),
 mysql_real_escape_string($fromDate),
 mysql_real_escape_string($fromTime),
 mysql_real_escape_string($toTime),
 mysql_real_escape_string($fromTime),
 mysql_real_escape_string($toTime),
 mysql_real_escape_string($radius));
$result = mysql_query($query);

if (!$result) {
  die("Invalid query: " . mysql_error());
}

$num_rows = mysql_num_rows($result);

if ($num_rows!=0)
{

// Iterate through the rows, adding XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // $node = $dom->createElement("marker");
  // $newnode = $parnode->appendChild($node);
  // $newnode->setAttribute("name", $row['name']);
  // $newnode->setAttribute("address", $row['address']);
  // $newnode->setAttribute("lat", $row['lat']);
  // $newnode->setAttribute("lng", $row['lng']);
  // $newnode->setAttribute("distance", $row['distance']);
$price1=$row['price'];
$noofhours=$diff;
$aproxprice=$diff*$price1;


    	$results['parkingdetails'][]=array('status'=>'success', 'parkingname'=>$row['parkingslotid'], 'parkingid'=>$row['parkingslotid'],'address'=>$row['address'],'lat'=>$row['Latitude'],'lng'=>$row['Longitude'],'availcount'=>$row['count'],'noofhours'=>$noofhours,'aproxprice'=>$aproxprice,'price'=>$price1,'fromdate'=>$fromDate,'fromtime'=>$fromTime,'totime'=>$toTime);

}

}
else
{
$results['parkingdetails'][]=array('status'=>'success1', 'parkingname'=>'','address'=>'Your Searched Location','lat'=>$center_lat,'lng'=>$center_lng,'fullset'=>$row['parkingname'].','.$row['lat'].','.$row['lng']);


}



$this->response($this->json($results),200);	
// print_r($results);
}





public function booking()
	{
		if ($this->get_request_method() != "POST") 
		{
			$this->response('', 406);
		}
$bookingid=$this->_request['bookingid'];
$bdate=$this->_request['bdate'];
$fromtime=$this->_request['fromtime'];
$totime=$this->_request['totime'];
$userid=$this->_request['userid'];
$curdate=date("y-m-d h:i:s");

$sql="INSERT INTO bookings (ParkingSlotId,FromDate,ToDate,FromTime,ToTime,createddt,VehicleOwnerId) VALUES ('$bookingid','$bdate','$bdate','$fromtime','$totime','$curdate','$userid')";
mysql_query($sql)or die("query failed");

$insertid=mysql_insert_id();

$firstid=$insertid.$userid*5;

$confirmid=$firstid.$fromtime;

 $updatesql="update bookings set bookingconfirmid='$confirmid' where BookingId='$insertid' ";
 mysql_query($updatesql)or die("update query failed");




 $result = array('status'=>'success','confirmid'=>$confirmid);
 $this->response($this->json($result), 200);

	}	


   
	




		
}

$api = new API;
$api->processApi();
?>
