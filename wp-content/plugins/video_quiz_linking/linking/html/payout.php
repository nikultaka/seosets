    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <style>
    form .error {
      color: #ff0000;
    }
    .has-error {
      border-color: red !important ;
    }
    .loading {
      position: relative;
      text-align: center;
      line-height: 140px;
      vertical-align: middle;
    }
  </style>
  <!-- Modal -->
  <div id="loader" style="z-index:9999999999;"></div>

  <div class="row">
    <div class="col-md-12">&nbsp;</div>
  </div>   
      
  <div class="row">   
    <div class="col-md-12">
      <button type="button" class="btn btn-primary pull-left" onclick="doMassPayment();">Mass Payment</button>    
    </div>       
  </div>


  <table id="example" class="display" style="width:100%">
    <thead>
      <tr>
        <th>User</th>
        <th>Video</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
     <?php if(!empty($tableData)) { 
      foreach($tableData as $key => $value) { 
        $status = 'Paid';
        if($value->is_paid == '0') {
          $status = 'Processing';
        }     
        ?>
        <tr>
          <td><?php echo $value->user_nicename; ?></td>
          <td><?php echo $value->video_name; ?></td>
          <td><?php echo $status; ?></td>      
        </tr>  
      <?php } } else { ?>  


      <?php } ?>  
    </tbody>
    <tfoot>
      <tr>
        <th>User</th>
        <th>Video</th>
        <th>Status</th>
      </tr>
    </tfoot>
  </table>   

  <script type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
  </script>