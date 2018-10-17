<?php
  session_start();
require __DIR__ . '/config.php';

 ?>



<?php




if ($_SERVER['REQUEST_METHOD']=='POST') {


  $ch = curl_init();
    // // Disable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, "https://api.vultr.com/v1/server/create?api_key=".API_KEY);
    curl_setopt($ch, CURLOPT_POST, 1);

              $label =  trim($_POST['label']);
              $location =  trim($_POST['location']);
              $size =  trim($_POST['size']);
              $number =  trim($_POST['number']);
              $type =  trim($_POST['type']);




              if($type=='ubuntu'){


                if($number>=2){

                  for($m=1;$m<=$number;$m++){

                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
                        'DCID' => $location,
                        'VPSPLANID' => $size,
                        'OSID' => '161',
                        'tag' => 'anytag',
                        'label' => $label.$m
                    )));
                    $res = curl_exec($ch);

                  }

                }else{
                  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
                      'DCID' => $location,
                      'VPSPLANID' => $size,
                      'OSID' => '161',
                      'tag' => 'anytag',
                      'label' => $label
                  )));
                  $res = curl_exec($ch);
                }








                $result = json_decode($res);

              if(isset($result->SUBID)){

                                $_SESSION['message'] = 'server Created Successfully';




                             echo "<script>window.location='./'</script>";

                             exit;
              }else{

                $_SESSION['red_message'] = $res;




             echo "<script>window.location='./'</script>";

             exit;

              }



              }else{

                if($number>=2){

                  for($m=1;$m<=$number;$m++){

                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
                      'DCID' => $location,
                      'VPSPLANID' => $size,
                      'OSID' => '161',
                      'tag' => 'anytag',
                      'label' => $label.$m
                    )));

                    $res = curl_exec($ch);

                  }

                }else{
                  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
                    'DCID' => $location,
                    'VPSPLANID' => $size,
                    'OSID' => '161',
                    'tag' => 'anytag',
                    'label' => $label
                  )));

                  $res = curl_exec($ch);
                }




                  $result = json_decode($res);

                if(isset($result->SUBID)){

                                  $_SESSION['message'] = 'server Created Successfully';




                               echo "<script>window.location='./'</script>";

                               exit;
                }else{

                  $_SESSION['red_message'] = $res;




               echo "<script>window.location='./'</script>";

               exit;

                }





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
  <h2>Create New Server</h2>
  <form action="" method="POST">


    <div class="form-group">
      <label for="label">Server Label:</label>

      <input type="text" class="form-control" id="label" placeholder="Enter label" name="label" required>
    </div>

    <div class="form-group">
      <label for="type">Server Type:</label>
       <select class="form-control" name="type">

        <option value="ubuntu">Ubuntu 14.x64</option>
        <option value="snapshot">b135b9fc645b0(Snapshot)</option>

      </select>
    </div>

    <div class="form-group">
      <label for="location">Server Location:</label>
       <select class="form-control" name="location">

        <option value="6">Atlanta</option>
        <option value="2">Chicago</option>
        <option value="3">Dallas</option>
        <option value="5">Los Angeles</option>
        <option value="39">Miami</option>
        <option value="1">New Jersey</option>
        <option value="4">Seattle</option>
        <option value="12">Silicon Valley</option>
        <option value="40">Singapore</option>
        <option value="7">Amsterdam</option>
        <option value="25">Tokyo</option>
        <option value="8">London</option>
        <option value="24">Paris</option>
        <option value="9">Frankfurt</option>
        <option value="19">Sydney</option>

      </select>
    </div>

    <div class="form-group">
      <label for="size">Server Size:</label>
       <select class="form-control" name="size">

        <option value="201">1024 MB RAM,25 GB SSD,1.00 TB BW</option>
        <option value="202">2048 MB RAM,40 GB SSD,2.00 TB BW</option>
        <option value="203">4096 MB RAM,60 GB SSD,3.00 TB BW</option>
        <option value="204">8192 MB RAM,100 GB SSD,4.00 TB BW</option>
        <option value="205">16384 MB RAM,200 GB SSD,5.00 TB BW</option>
        <option value="206">32768 MB RAM,300 GB SSD,6.00 TB BW</option>
        <option value="207">65536 MB RAM,400 GB SSD,10.00 TB BW</option>
        <option value="208">98304 MB RAM,800 GB SSD,15.00 TB BW</option>


      </select>
    </div>

     <div class="form-group">
      <label for="name">Put the Number of Servers u want to create:</label>
      <input type="number" class="form-control" id="number" placeholder="Enter the number" name="number" required min="1" value="1" max="200">
    </div>


    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

</body>
</html>
