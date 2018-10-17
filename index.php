<?php
  session_start();
  require __DIR__ . '/config.php';

 ?>





<!DOCTYPE html>
<html lang="en">
<head>
  <title>Vultr</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

  <style type="text/css">

  @media only screen and (max-width: 400px) {

    .pull-right {
    float: none!important;
}
}

  </style>

</head>
<body>


<div class="container">


<div class="pull-left"> <h2>Vultr</h2>

    <p>Servers:(<a href="new.php">Create New Srever</a>)</p>

    <p><a href="delete.php">Click Here</a> to Delete Server</p>

    </div>

  <center><div class="pull-right">
   <a href="ip.txt" class="btn btn-info" role="button" style="    margin-top: 30px;
    " download>Export all IPs to TXT File</a>
  </div></center>

</div><br>

<div class="container">



<?php

  if(isset($_SESSION['message'])){ ?>
  <div class="alert alert-success" role="alert">

<center> <strong><?php echo $_SESSION['message']; ?></strong> </center>
 </div>

  <?php session_destroy(); }

 ?>

<?php

  $output = '';

  if(isset($_SESSION['red_message'])){ ?>
  <div class="alert alert-danger" role="alert">

<center> <strong><?php echo $_SESSION['red_message']; ?></strong> </center>
 </div>

  <?php session_destroy(); }

 ?>



  <table class="table table-bordered" id="myTable">
    <thead>
      <tr>
        <th>Label</th>
        <th>Ram</th>
        <th>Disk</th>
        <th>IP Address</th>
        <th>Created at</th>
        <!--<th>Delete</th>-->
      </tr>
    </thead>
    <tbody>

      <?php

      $output='';

      //curl -H 'API-Key: YOURKEY' "https://api.vultr.com/v1/server/list"

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

      // echo "<pre>";
      // print_r($response);
      // exit;

      foreach ($response as $key => $value) { ?>

        <tr>

        <td><?php echo $value->label; ?></td>
        <td><?php echo $value->ram; ?></td>
        <td><?php echo $value->disk; ?></td>
        <td><?php echo $value->main_ip;
        $output.=$value->main_ip." \n";
         ?></td>
        <td><?php echo $value->date_created; ?></td>

</tr>



      <?php }


       ?>







    </tbody>
  </table>
</div>

<?php

  $myfile = fopen("ip.txt", "w")  ;


fwrite($myfile, $output);
fclose($myfile);


 ?>

<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>

  <script type="text/javascript">



    $(document).ready( function () {

   $('#myTable').dataTable( {
  "pageLength": 100,
  dom: 'Blfrtip',
        buttons: [

            {
                extend: 'csv',
                text: 'Export Filtered IPs to CSV File',
                exportOptions: {
                    columns: [ 3 ]
                }
            }
        ]
} );




} );







    </script>

</body>
</html>
