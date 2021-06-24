<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>

<div id="loader" style="z-index:9999999999;"></div>
<div class="row mt-5">
	<div class="col-md-8">
		<nav id="pagination">
			<ul class="pagination pagination-sm" id="filter_pagination">
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
			</ul>
		</nav>
	</div>

	<div class="col-md-4">
		<diV id="pages_dropdown_id">
			<form id="dropdown_form">
				<select class="" name="pages_filter_dropdown" id="pages_filter_dropdown">
					<option value="">Select SEO SETS</option> 
					<?php
					foreach ($pagessql as $pages) { ?>
						<option value="<?php echo $pages->page_insert_id ?>" <?php if( isset($_REQUEST['id']) && $pages->page_insert_id == $_REQUEST['id']) {  echo "selected = 'selected'";  } ?> ><?php echo $pages->clonename ?></option>
					<?php
					}
					?>
				</select>
				<button type="button" class="btn btn-info btn-sm" name="pages_filtered_id" id="pages_filtered_id">Find Pages</button>
				<button type="button" class="btn btn-secondary btn-sm " onclick="loadclonepagestable();" name="pages_un_filtered_id" id="pages_un_filtered_id">Clear Filter</button>
			</form>
		</div>
	</div>
</div>

<!-- mass update and delete button -->

	<div class="row">
		<div class="col-md-6 pull-right">
				<button  class='btn btn-danger btn-sm pull-right' id="select_all_delete">Mass Delete</button> 
		</div>

		<div class="col-md-6 pull-left dropdown" id="change_status">
			<button class="btn btn-info btn-sm  dropdown-toggle" type="button" id="change_selected_status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Mass Update
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="javascript:void(0)" data-id="1">Published</a>
				<a class="dropdown-item" href="javascript:void(0)" data-id="0">Draft</a>
			</div>
		</div>
	</div>
	<br>

<!-- dataTable -->
<table class="table" id="clone_pages_data-table" style="width: 100%;">
	<thead>
	    <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
		<th>ID</th>
		<th width=15%;>Name</th>
		<th>Status</th>
		<th>Author</th>
		<th>SEO</th>
		<th>Date</th>
		<th>Delete</th>
		<th>Update Status</th>
		<th>Action</th>
	</thead>
	<tbody></tbody>
</table>

<script type="text/javascript">
	//$(document).ready(function () {
		var pageajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		var is_filter = 0;
		<?php if(isset($_REQUEST['id'])) { ?>
				is_filter = 1;
	    <?php } ?>    
	//});
</script>