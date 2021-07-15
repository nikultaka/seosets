    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
    .has-error {
      color: red;
    }
    </style>

    <div id="loader" style="display:none;"></div>    

    <div class="container">
      <h1>Company Information</h1>
      <form name="companyForm" id="companyForm">
        <div class="form-group">
          <label>Company Title</label>
          <input type="text" class="form-control" name="companyTitle" id="companyTitle" value="<?php echo $title; ?>">
        </div>
        <div class="form-group">
          <label>Company Description</label>
          <textarea class="form-control" name="companyDescription" id="companyDescription"><?php echo $description; ?></textarea>   
        </div>
        <button type="button" id="linkingSubmit" class="btn btn-primary">Save</button>
      </form>  
    </div>

  

    <script type="text/javascript">
      var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>