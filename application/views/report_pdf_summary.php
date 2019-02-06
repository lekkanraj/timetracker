<!DOCTYPE html>
<html lang="en">
<head>
  <title>Report by Summary</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <style>
    	.error{
    		color:red;
    		font-weight: normal;
    	}
    </style>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Traking Info In Summary</h2>          
  <table class="table table-bordered">
    <thead>
      <tr>
        <th align='center'>Sno</th>
        <th align='center'>Employee Name</th>
        <th  align='center'>Team</th>
        <th  align='center'>Days</th>
        <th align='center'>Spend Hours</th>
        <th align='center'>Break Hours</th>
      </tr>
    </thead>
    <tbody>
     <?php
        if(!empty($info))
        {
            $i=1;
            foreach($info as $record)
            {
        ?>
          <tr>
            <td align='center'><?php echo $i;?></td>
            <td align='center'><?php echo $record['name']; ?></td>
            <td align='center'><?php echo $record['projectname']; ?></td>
            <td align='center'><?php echo $record['days']; ?></td>
            <td align='center'><?php echo $record['hourscount']; ?></td>
            <td align='center'><?php echo $record['breakscount']; ?></td>
          </tr>
      <?php 
            $i++;
            }
        }else{?>
        <tr>
            <td colspan='6'>No Records Found.</td>
          </tr>
        
        <?php }?>
    </tbody>
  </table>
</div>

</body>
</html>