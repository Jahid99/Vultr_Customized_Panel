<?php
  session_start();
require __DIR__ . '/config.php';

 ?>



<?php

if ($_SERVER['REQUEST_METHOD']=='POST') {




  $ip =  trim($_POST['ip']);


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.vultr.com/v1/server/list");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  $headers = array();
  $headers[] = "Api-Key: ".API_KEY;
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $response = curl_exec($ch);
  if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
  }
  curl_close ($ch);
  $response = json_decode($response);

  foreach ($response as $key => $value) {

    if($value->main_ip==$ip){
      $id = $key;
    }

  }

  if(isset($id)){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.vultr.com/v1/server/destroy");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "SUBID=$id");
    curl_setopt($ch, CURLOPT_POST, 1);

    $headers = array();
    $headers[] = "Api-Key: ".API_KEY;
    $headers[] = "Content-Type: application/x-www-form-urlencoded";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);



    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);

    if($result=='Unable to destroy server: Servers cannot be destroyed within 5 minutes of being created'){
      $_SESSION['red_message'] = $result;
       echo "<script>window.location='./'</script>";
    }else{
      $_SESSION['message'] = 'Server Deleted Successfully';
       echo "<script>window.location='./'</script>";
    }




  }else{
    $_SESSION['red_message'] = 'IP did not match';



   echo "<script>window.location='./'</script>";
  }





}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Vultr</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">


  <h2>Enter IP to delete a Server</h2>


  <form action="" method="POST">


    <div class="form-group">
      <label for="ip">IP:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter ip" name="ip" required>
    </div>

    <button type="submit" class="btn btn-default">Submit</button>

  </form>




</div>

</body>
</html>
