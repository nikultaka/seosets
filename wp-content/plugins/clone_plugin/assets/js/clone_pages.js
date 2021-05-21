$(document).ready(function () {
    $('#select_all_delete').hide();
    $('#hide_status').hide();
    $(".tooltip-tiny").tooltip({
        delay: { show: 0, hide: 2000 }
    })
    $('[data-toggle="tooltip"]').tooltip();
    loadclonepagestable();
});

function loadclonepagestable() {
    $("#loader").addClass('loader');
    $('#clone_pages_data-table').dataTable({
        "paging": true,
        // "aLengthMenu": [[100, 300, 500, -1], [100, 300, 500, "All"]],
        "pageLength": 100,
        "bProcessing": true,
        "serverSide": true,
        "bDestroy": true,

        "ajax": {
            url: pageajaxurl,
            type: "post",
            data:
            {
                action: "Controller::load_clone_pages_Datatable"
            },
        },
        "aoColumns": [
            { mData: 'id' },
            { mData: 'clonepagename' },
            { mData: 'pagestatus' },
            { mData: 'author_name' },
            { mData: 'clone_name' },
            { mData: 'datetime' },
            { mData: 'delete' },
            { mData: 'update_status' },
            { mData: 'select_all' }

        ],
        "order": [[0, "asc"]],
        "columnDefs": [{
            "targets": [6, 7, 8],
            "orderable": false
        }]
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

// $("#pages_filtered_id").click(function () {
//     var pages_filter_dropdown = $("#pages_filter_dropdown").val();
//     $.ajax({
//         url: ajaxurl,
//         type: 'POST',
//         data:{
//             pages_filter_dropdown : pages_filter_dropdown,
//             action : "Controller::pages_filtered_id"
//         },
//         success: function(){
//             loadclonepagestable();
//         },
//     });
// });
$("#pages_filtered_id").click(function () {
    var pages_filter_dropdown = $("#pages_filter_dropdown").val();
    $("#loader").addClass('loader');
    $('#clone_pages_data-table').dataTable({
        "paging": true,
        "aLengthMenu": [[100, 300, 500], [100, 300, 500]],
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
            { mData: 'id' },
            { mData: 'clonepagename' },
            { mData: 'pagestatus' },
            { mData: 'author_name' },
            { mData: 'clone_name' },
            { mData: 'datetime' },
            { mData: 'delete' },
            { mData: 'update_status'},
            { mData: 'select_all' }
        ],
        "order": [[0, "asc"]],
        "columnDefs": [{
            "targets": [5, 6],
            "orderable": false
        }]

    });
    $("#loader").removeClass('loader');
});

$("#pages_un_filtered_id").click(function () {
    $("#loader").addClass('loader');
    $('#clone_pages_data-table').dataTable({
        "paging": true,
        "aLengthMenu": [[100, 300, 500], [100, 300, 500]],
        "pageLength": 100,
        "bProcessing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {
            url: pageajaxurl,
            type: "post",
            data:
            {
                action: "Controller::load_clone_pages_Datatable"
            },
        },
        "aoColumns": [
            { mData: 'id' },
            { mData: 'clonepagename' },
            { mData: 'pagestatus' },
            { mData: 'author_name' },
            { mData: 'clone_name' },
            { mData: 'datetime' },
            { mData: 'delete' },
            { mData: 'update_status'},
            { mData: 'select_all' }

        ],
        "order": [[0, "asc"]],
        "columnDefs": [{
            "targets": [5, 6],
            "orderable": false
        }]

    });
    $("#loader").removeClass('loader');
});

$("#filter_pagination a").click(function () {
    var id = $(this).data('id');
    $("#loader").addClass('loader');
    $('#clone_pages_data-table').dataTable({
        "paging": true,
        "aLengthMenu": [[100, 300, 500], [100, 300, 500]],
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
            { mData: 'id' },
            { mData: 'clonepagename' },
            { mData: 'pagestatus' },
            { mData: 'author_name' },
            { mData: 'clone_name' },
            { mData: 'datetime' },
            { mData: 'delete' },
            { mData: 'update_status'},
            { mData: 'select_all' }

        ],
        "order": [[0, "asc"]],
        "columnDefs": [{
            "targets": [5, 6],
            "orderable": false
        }]
    });
    $("#loader").removeClass('loader');
});

var clicked = false;
$("#select_all").on("click", function () {
    $(".select_all_chacked").prop("checked", !clicked);
    clicked = !clicked; 
    var len = $('.select_all_chacked').filter(':checked').length;

    if ($(this).prop("checked") == true) {
        $('#select_all_delete').html('Delete ' + len + ' records');
        $('#select_all_delete').show();
        $('#hide_status').show();
    } else {
        $('#select_all_delete').hide();
        $('#hide_status').hide();
    } 
});

$('body').on("change", '.select_all_chacked', function (status, id) {
    var id = $(this).val();
    var status = 0;
    if ($(this).is(":checked")) {
        status = 1;
    }
    var len = $('.select_all_chacked').filter(':checked').length;

    if (len > 1) {
        $('#select_all_delete').html('Delete ' + len + ' records');
        $('#select_all_delete').show();
        $('#hide_status').show();
    } else {
        $('#select_all_delete').hide();
        $('#hide_status').hide();
    }

});

$('#select_all_delete').click(function (id) {
    var id = [];
    $(':checkbox:checked').each(function (i) {
        id[i] = $(this).val();
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
                        del_id: id,
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
                        $("#select_all_chacked").removeAttr('checked');
                        $("#select_all").removeAttr('checked');
                        $("#select_all_delete").hide();
                        $("#hide_status").hide();
                        loadclonepagestable();
                    }
                });
            }
        });
    });
});

$('body').on('change', '.change_selected_status', function (id) {
// $('#change_selected_status').click(function (id) {
    var id = [];
    $('input:checked').each(function (i) {
        id[i] = $(this).val();
    });

    var status = 0;
    if ($(this).prop("checked") == true) {
        status = 1;
    }
        $("#loader").addClass('loader');
        $.ajax({
            url: pageajaxurl,
            type: 'post',
            data: {
                id: id,
                status: status,
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
                $("#select_all_chacked").removeAttr('checked');
                $('#select_all').removeAttr('checked', true);
                $('#select_all_delete').hide();
                $('#hide_status').hide();
                loadclonepagestable();

            }
        });
});


