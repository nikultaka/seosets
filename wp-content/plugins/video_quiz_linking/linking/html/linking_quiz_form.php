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
            <input type="hidden" name="action" value="VideoLinkingController::insert_video">
            <input type="hidden" name="hiddenID" id="hiddenID" value="">
            <div class="form-group">
              <label for="clonename">Name</label>
              <div class="col-xs-6">
                <input type="text" class="form-control" name="videoName" id="videoName" placeholder="">
              </div>
            </div>   

            <div class="form-group">
              <label for="clonename">Video</label>    
              <select class="form-control" id="videoID" name="videoID">
                <option value="">-- Select Video --</option>
                <?php 
                if(!empty($attachments)) {
                  foreach($attachments as $key => $value) { ?>
                    <option value="<?php echo $value->ID; ?>"><?php echo $value->post_title; ?></option>
                  <?php } } ?>       
                </select>  
              </div>  

              <div class="form-group">
                <label for="pages_status">Quiz</label>
                <select class="form-control" id="quizName" name="quizName">
                  <option value="">-- Select Quiz --</option>
                  <?php 
                  if(!empty($quizesData)) {
                    foreach($quizesData as $key => $value) { ?>
                      <option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
                    <?php } } ?>       
                  </select>  
                </div>

                <div class="form-group">
                  <label>Amount (USD)</label>
                  <input type="text" class="form-control" name="amount" id="amount" value="">
                </div>

                <div class="form-group">
                  <label for="pages_status">Status</label>
                  <select class="form-control" id="status" name="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
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

      <div class="row">
        <div class="col-md-12">&nbsp;</div>
      </div>   
      <div class="row">   
        <div class="col-md-12">
          <button type="button" class="btn btn-primary pull-left" onclick="addVideo();">Add Video</button>    
        </div>       
      </div>


      <table id="example" class="display" style="width:100%">
        <thead>
          <tr>
            <th>Video Name</th>
            <th>Quiz Title</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
         <?php if(!empty($tableData)) { 
          foreach($tableData as $key => $value) { 
            $status = 'Inactive';
            if($value->status == '1') {
              $status = 'Active';
            }
            ?>
            <tr>
              <td><?php echo $value->video_name; ?></td>
              <td><?php echo $value->title; ?></td>
              <td><?php echo $status; ?></td>
              <td>
                <button type="button" class="btn btn-primary" onclick="editVideo(<?php echo $value->id; ?>);" name="editButton">Edit</button>  
                &nbsp;
                <button type="button" class="btn btn-danger" onclick="deleteVideo(<?php echo $value->id; ?>);" name="deleteButton">Delete</button>  
                &nbsp;
                <button type="button" class="btn btn-primary" onclick="payout(<?php echo $value->id; ?>);" name="payout">Payout</button>  
              </td>
            </tr>  
          <?php } } else { ?>  


          <?php } ?>  
        </tbody>
        <tfoot>
          <tr>
            <th>Video Name</th>
            <th>Quize Title</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </tfoot>
      </table>   

      <script type="text/javascript">
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
      </script>