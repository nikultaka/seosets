<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<table id="videoPaymentDataTable" class="table table-striped table-bordered" style="width:100% ; font-size:15px; color:black;" >
    <thead>
        <tr>
            <th>User Name</th>
            <th>Video Title</th>
            <th>Is_paid</th>
            <th>Status</th>
            <th>Paid Date</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($tableData)) {
            foreach ($tableData as $key => $value) {
                $status = 'Inactive';
                if ($value->status == '1') {
                    $status = 'Active';
                }

                $is_paid = 'NO';
                    if ($value->is_paid == '1') {
                        $is_paid = 'YES';
                }
                $newDate = date("F j, Y", strtotime($value->created_at));  
         ?>
                <tr>
                    <td><?php echo $value->user_nicename; ?></td>
                    <td><?php echo ucfirst($value->video_name); ?></td>
                    <td><?php echo $is_paid; ?></td>
                    <td><?php echo $status; ?></td>
                    <td><?php echo $newDate; ?></td>
                </tr>
            <?php }
        } else { ?>
        <?php } ?>
    </tbody>
</table>

<script>
$(document).ready( function () {
        $('#videoPaymentDataTable').DataTable();
} );
</script>