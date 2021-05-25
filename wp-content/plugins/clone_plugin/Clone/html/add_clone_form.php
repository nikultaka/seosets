    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <style>
      form .error {
        color: #ff0000;
      }
      #CloneModal {
        z-index: 99999999;
      }
    </style>

    <!-- Button trigger modal -->

    <!-- Modal -->
    <div id="loader" style="z-index:9999999999;"></div>
    <div class="modal fade bd-example-modal-xl" id="CloneModal" tabindex="-1" role="dialog" aria-labelledby="CloneModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <!-- <div class="modal-header">
            <h5 class="modal-title" id="CloneModalLabel">Add Clone</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div> -->
          <div class="modal-body">
            <form onsubmit="return false" method="POST" name="formdata" id="formdata">
              <input type="hidden" name="action" value="Controller::insert_clone">

              <div class="row">

                <div class="col-sm-6">
                <div class="form-group">
                    <label for="clonename">Clone name</label>
                    <div class="col-xs-6"><input type="text" class="form-control" name="clonename" id="clonename" placeholder="Enter Clone Name"></div>
                  </div>

                  <div style="float: left;">
                    <input type="text" id="seo_search" name="seo_search" placeholder="Search Pages">
                  </div>

                  <div id="seo_search_table">
                    <div class="form-group">
                      <div class="list-group" id="menu" name="menu">
                        <table class="table table-hover table-sm">
                          <tr>
                            <th scope="col"></th>
                            <th scope="col">Pages</th>
                            <th scope="col">Author</th>
                            <th scope="col">Status</th>
                            <th scope="col">Edit Page</th>
                          </tr>

                          <?php
                          foreach ($pagessql as $pages) { ?>
                            <tr value="<?php echo $pages->ID ?>" style="margin-left: 10px;">
                              <td><input type="checkbox" name="pages[]" value="<?php echo $pages->ID ?>"></td>
                              <?php echo "<td> $pages->post_title </td> 
                                <td> $pages->user_name </td> 
                                <td>" . ucfirst($pages->post_status) . " </td>" ?>
                              <td><a href="javascript:void(0)" data-id="<?php echo $pages->ID ?>">
                              <i class="fa fa-pencil-square" aria-hidden="true"></i></a></td>
                            <?php
                          }
                            ?>
                            </tr>

                        </table>
                      </div>
                    </div>
                  </div>


                </div>
                <div class="col-sm-6">
                <div class="form-group">
                    <label for="tags">Tags example</label>
                    <textarea disabled class="form-control" name="clone_tags" id="clone_tags" rows="4">
                    {"city":"city1","name":"Nikul1","title":"title1","seotitle":"seotitle1"}
                    </textarea>
                  </div>

                  <div class="form-group">
                    <label for="tags">Tags</label>
                    <textarea class="form-control" name="clone_tags" id="clone_tags" rows="4"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="pages_status">Pages Status</label>
                    <select class="form-control" id="pages_status" name="pages_status">
                      <option value="draft">Draft</option>
                      <option value="publish" selected>Publish</option>
                    </select>
                  </div>
                </div>
              </div>
          </div>

          <div class="modal-footer">
            <div class="form-group">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button id="submit" name="submit" class="btn btn-success">Add</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->

    <div class="row">
      <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-sm mt-5 mb-3" data-toggle="modal" style="float:left" data-target="#CloneModal">Add SEO Set</button>
      </div>
      <div class="col-md-10">
        <nav id="clonename_pagination">
          <ul class="pagination pagination-sm" id="filter_pagination_clone">
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="a">A</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="b">B</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="c">C</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="d">D</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="e">E</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="f">F</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="g">G</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="h">H</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="i">I</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="j">J</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="k">K</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="l">L</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="m">M</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="n">N</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="o">O</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="p">P</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="q">Q</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="r">R</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="s">S</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="t">T</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="u">U</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="v">V</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="w">W</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="x">X</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="y">Y</a></li>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" data-id="z">Z</a></li>
            <button type="button" class="btn btn-secondary btn-sm" style="margin-left: 20px;" name="clonename_un_filtered" id="clonename_un_filtered">Clear Filter</button>
          </ul>
        </nav>
      </div>
    </div>


    <table class="table" id="clone_data-table" style="width: 1100px">
      <thead>
        <th>ID</th>
        <th>Name</th>
        <th>Status</th>
        <th>Author name</th>
        <th>Date & time</th>
        <th>Delete</th>
        <th>Update Status</th>
      </thead>
    </table>

    <script type="text/javascript">
      var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>