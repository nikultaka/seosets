$(document).ready(function () {
    $('#select_all_delete').hide();
    $('#change_selected_status').hide();
    
    $(".tooltip-tiny").tooltip({
        delay: { show: 0, hide: 2000 }
    })
    $('[data-toggle="tooltip"]').tooltip();
  //  loadclonepagestable();
    var table =  $('#clone_pages_data-table').DataTable({
        "paging": true,
        "aLengthMenu": [[100, 500, 1000], [100,500, 1000]],
        // "pageLength": 100,   
        "bProcessing": true,
        "serverSide": true,
        "bDestroy": true,
        stateSave: true,
        "drawCallback": function( settings ) {
            console.log("testing draw");
            if($('#example-select-all').is(':checked')) {
                $(document).find('.checkall').prop('checked',true);      
            }
        },
        "ajax": {
            url: pageajaxurl,
            type: "post",
            data:
            {
                action: "Controller::load_clone_pages_Datatable"
            },
        },
        "aoColumns": [
            { mData: 'select_all'},
            { mData: 'id' },
            { mData: 'clonepagename' },
            { mData: 'pagestatus' },
            { mData: 'author_name' },
            { mData: 'clone_name' },
            { mData: 'datetime' },
            { mData: 'delete' },
            { mData: 'update_status' },
            // { mData: 'select_all' }

        ],
        "order": [[0, "asc"]],
        'columnDefs': [{
            'targets': 0,
            'searchable': false,
            'orderable': false,
            'className': 'dt-body-center',
            'render': function (data, type, full, meta){
                return '<input type="checkbox" class="checkall" name="id[]" value="' + $('<div/>').text(data).html() + '">';
            }
         },
         {
                    "targets": [0, 7, 8],
                    "orderable": false
                },
        ],
    });

    
    $('#example-select-all').on('change', function(){        
        var cells = table.cells( ).nodes();
        $( cells ).find('.checkall').prop('checked',true);  
     });      

    $('#clone_pages_data-table').on( 'page.dt', function () {
        //var cells = table.cells( ).nodes();
        //$( cells ).find('.checkall').prop('checked', $(this).is(':checked'));  
    }); 

     $('#clone_pages_data-table tbody').on('change', 'input[name="id[]"]', function(){
        // If checkbox is not checked
        if(!this.checked){
           var el = $('#example-select-all').get(0);
           // If "Select all" control is checked and has 'indeterminate' property
           if(el && el.checked && ('indeterminate' in el)){
     
              el.indeterminate = true;
           }
        }
     });
});

function loadclonepagestable() {
    $("#loader").addClass('loader');
     $('#clone_pages_data-table').dataTable({
        "paging": true,
        "aLengthMenu": [[100, 500, 1000], [100,500, 1000]],
        "pageLength": 100,
        "bProcessing": true,
        "serverSide": true,
        "bDestroy": true,
        stateSave: true,

        "ajax": {
            url: pageajaxurl,
            type: "post",
            data:
            {
                action: "Controller::load_clone_pages_Datatable"
            },
        },
        "aoColumns": [
            { mData: 'select_all'},
            { mData: 'id' },
            { mData: 'clonepagename' },
            { mData: 'pagestatus' },
            { mData: 'author_name' },
            { mData: 'clone_name' },
            { mData: 'datetime' },
            { mData: 'delete' },
            { mData: 'update_status' },
            // { mData: 'select_all' }

        ],
        "order": [[0, "asc"]],

        'columnDefs': [{
            'targets': 0,
            'searchable': false,
            'orderable': false,
            'className': 'dt-body-center',
            'render': function (data, type, full, meta){
                return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
            }
         },
         {
                    "targets": [6, 7, 8],
                    "orderable": false
         },
        ],
    });
    $("#loader").removeClass('loader');
}



function clone_page_delete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are sure to delete this record !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $("#loader").addClass('loader');
            $.ajax({
                url: pageajaxurl,
                type: 'POST',
                data: {
                    id: id,
                    action: "Controller::delete_clone_pages_record"
                },
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire(
                            'Deleted!',
                            data.msg,
                            'success'
                        )
                        $("#loader").removeClass('loader');
                        loadclonepagestable();
                    } else {
                        Swal.fire(
                            'Error!',
                            data.msg,
                            'error'
                        )
                    }
                    $("#loader").removeClass('loader');
                    loadclonepagestable();
                }
            });
        }
    })
}

$('body').on('change', '.statusswitch', function () {
    var id = $(this).data("id");
    var status = 0;
    if ($(this).prop("checked") == true) {
        status = 1;
    }
    $("#loader").addClass('loader');
    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            id: id,
            status: status,
            action: "Controller::change_post_status"
        },
        success: function () {
            loadclonepagestable();
        $("#loader").removeClass('loader');
        }
    });
});


$("#pages_filtered_id").click(function () {
    var pages_filter_dropdown = $("#pages_filter_dropdown").val();
    $("#loader").addClass('loader');
    $('#clone_pages_data-table').dataTable({
        "paging": true,
        "aLengthMenu": [[100, 500, 1000], [100,500, 1000]],
        "pageLength": 100,
        "bProcessing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {
            url: pageajaxurl,
            type: "post",
            data:
            {
                pages_filter_dropdown: pages_filter_dropdown,
                action: "Controller::load_clone_pages_Datatable"
            },
        },
        "aoColumns": [
            { mData: 'select_all' },
            { mData: 'id' },
            { mData: 'clonepagename' },
            { mData: 'pagestatus' },
            { mData: 'author_name' },
            { mData: 'clone_name' },
            { mData: 'datetime' },
            { mData: 'delete' },
            { mData: 'update_status'},
        ],
        "order": [[0, "asc"]],
        'columnDefs': [{
            'targets': 0,
            'searchable': false,
            'orderable': false,
            'className': 'dt-body-center',
            'render': function (data, type, full, meta){
                return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
            }
         },
         {
                    "targets": [0, 7, 8],
                    "orderable": false
                },
        ],

    });
    $("#loader").removeClass('loader');
});

$("#filter_pagination a").click(function () {
    var id = $(this).data('id');
    $("#loader").addClass('loader');
    $('#clone_pages_data-table').dataTable({
        "paging": true,
        "aLengthMenu": [[100, 500, 1000], [100,500, 1000]],
        "pageLength": 100,
        "bProcessing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {
            url: pageajaxurl,
            type: "post",
            data:
            {
                short_name: id,
                action: "Controller::load_clone_pages_Datatable"
            },
        },
        "aoColumns": [
            { mData: 'select_all' },
            { mData: 'id' },
            { mData: 'clonepagename' },
            { mData: 'pagestatus' },
            { mData: 'author_name' },
            { mData: 'clone_name' },
            { mData: 'datetime' },
            { mData: 'delete' },
            { mData: 'update_status'},

        ],
        "order": [[0, "asc"]],
        'columnDefs': [{
            'targets': 0,
            'searchable': false,
            'orderable': false,
            'className': 'dt-body-center',
            'render': function (data, type, full, meta){
                return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
            }
         },
         {
                    "targets": [0, 7, 8],
                    "orderable": false
                },
        ],
    });
    $("#loader").removeClass('loader');
});


$('#clone_pages_data-table').on('change', 'input[name ="select_all"]', function(){
    if ($(this).prop("checked") == true) {
                $('#select_all_delete').show();
                $('#change_selected_status').show();
            } else {
                $('#select_all_delete').hide();
                $('#change_selected_status').hide();
            }
});

$('#clone_pages_data-table').on('change', 'input[name ="id[]"]', function(){
    var checked_checkbox_lan = $('input[name="id[]"]:checked').length;  
    if( checked_checkbox_lan > 0){
        $('#select_all_delete').show();
        $('#change_selected_status').show();
    }else{
        $('#select_all_delete').hide();
        $('#change_selected_status').hide();
    }
});

$('#select_all_delete').click(function (id) {
    // e.preventDefault();
    var deleteids_arr = [];
    $("input:checkbox[name='id[]']:checked").each(function () {
        deleteids_arr.push($(this).val());
    });  
        Swal.fire({
            title: 'Are you sure?',
            text: "You are sure to delete this record !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#loader").addClass('loader');
                $.ajax({
                    url: pageajaxurl,
                    type: 'POST',
                    data: {
                        del_id: deleteids_arr,
                        action: "Controller::delete_selected_pages_record"
                    },
                    success: function (responce) {
                        var data = JSON.parse(responce);
                        if (data.status == 1) {
                            Swal.fire(
                                'Deleted!',
                                data.msg,
                                'success'
                            )
                            $("#loader").removeClass('loader');
                            loadclonepagestable();
                        } else {
                            Swal.fire(
                                'Error!',
                                data.msg,
                                'error'
                            )
                            $("#loader").removeClass('loader');
                        }
                        
                        $("#select_all_delete").hide();
                        $("#change_selected_status").hide();
                        $("input[name='select_all']:checkbox").prop('checked',false);
                        loadclonepagestable();
                    }
                });
            }
        });
});

$("#change_status a").click(function () {
    var data_id = $(this).data('id');
    var  change_status = [];
    $("input:checkbox[name='id[]']:checked").each(function () {
        change_status.push($(this).val());
    });
        $("#loader").addClass('loader');
        $.ajax({
            url: pageajaxurl,
            type: 'post',
            data: {
                id: change_status,
                status: data_id,
                action: "Controller::change_selected_post_status"
            },
            success: function (responce) {
                var data = JSON.parse(responce);
                if (data.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: data.msg,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    loadclonepagestable();
                    $("#loader").removeClass('loader');
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: data.msg,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $("#loader").removeClass('loader');
                }
                $('#select_all_delete').hide();
                $('#change_selected_status').hide();
                loadclonepagestable();
                $("input[name='select_all']:checkbox").prop('checked',false);
            }
        });
});


