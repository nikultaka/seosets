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


  <div class="modal" id="videoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">    
        <div class="modal-header">
          <h5 class="modal-title">Upload Video</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form onsubmit="return false" method="POST" name="formdata" id="formdata">
            <div class="form-group">
              <label for="clonename">Name</label>
              <div class="col-xs-6">
                <input type="text" class="form-control" name="videoName" id="videoName" placeholder="">
              </div>
            </div>  
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="saveVideo();">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->






    <script type="text/javascript">
      var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>