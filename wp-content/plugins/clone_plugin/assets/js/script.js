$(document).ready(function () {
    $('#CloneModal').modal('hide');
    loaddatatable();
    $('[data-toggle="tooltip"]').tooltip();
    $('#CloneModal').on('hidden.bs.modal', function (event) {
        $('#formdata')[0].reset();
        $('#seo_search').val('');
    });

    $("#formdata").validate({
        rules: {
            clonename: "required",
        },
        messages: {
            clonename: "Clone Name is Required",
        },
        submitHandler: function () {
            $("#loader").addClass('loader');
            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: $('#formdata').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#clonename').val('');
                        $('#clone_tags').val('');
                        $('#pages').val('');
                        $('#pages_status').val('');
                        $('#seo_search').val('');
                        $('#CloneModal').modal('hide');
                        loaddatatable();
                        $("#loader").removeClass('loader');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $("#loader").removeClass('loader');
                    }
                }
            });
        }
    });
});

function loaddatatable() {
    $("#loader").addClass('loader');
    $('#clone_data-table').dataTable({
        "paging": true,
        responsive: true,
        "aLengthMenu": [[100, 500, 1000], [100, 500, 1000]],
        "pageLength": 100,
        "bProcessing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {
            url: ajaxurl,
            type: "post",
            data: {
                action: "Controller::loaddata_Datatable"
            },
        },
        "aoColumns": [
            { mData: 'id' },
            { mData: 'clonename' },
            { mData: 'pages_status' },
            { mData: 'author_name' },
            { mData: 'datetime' },
            // { mData: 'tags' },
            { mData: 'delete' },
            { mData: 'update_status' }

        ],
        "order": [[0, "asc"]],
        "columnDefs": [{
            "targets": [5, 6],
            "orderable": false
        }]
    });
    $("#loader").removeClass('loader');
}

function record_delete(id, page_insert_id) {
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
                url: ajaxurl,
                type: 'POST',
                data: {
                    id: id,
                    page_insert_id: page_insert_id,
                    action: "Controller::delete_record"
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
                        loaddatatable();
                    } else {
                        Swal.fire(
                            'Deleted!',
                            data.msg,
                            'error'
                        )
                        $("#loader").removeClass('loader');
                    }
                    loaddatatable();
                }
            });
            
        }
    })
}

// function record_edit(id){
//     $.ajax({
//         url: ajaxurl,
//         type: 'POST',
//         data:{
//             id : id ,
//             action : "Controller::edit_record"
//         },
//         success: function (responce) {
//             var data = JSON.parse(responce);
//             var pages_tags = data.pages_tags;
//             console.log(pages_tags);
//             $('#submit').html('Update');
//             $('#submit').css('background','info');
//             // console.log(data);
//             if (data.status == 1) {
//                 var result = data.recoed;
//                 console.log(result);
//                 $('#CloneModal').modal('show');
//                 $('#hid').val(result.id);
//                 $('#clonename').val(result.clonename);
//                 $('#clone_tags').val(pages_tags);
//                 var pages_data = result.pages;
//                 var dataarray = pages_data.split(",");
//                 $('#pages').val(dataarray);
//                 $('#pages_status').val(result.pages_status);
//                 loaddatatable();
//             }
//         }
//     });
// }

$('body').on('change', '.statusswitch', function () {
    var id = $(this).data("id");
    var page_insert_id = $(this).data('prod_id');
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
            page_insert_id: page_insert_id,
            status: status,
            action: "Controller::change_page_status"
        },
        success: function () {
            loaddatatable();
        },
    });
    $("#loader").removeClass('loader');
});

$("#clonename_un_filtered").click(function () {
    $("#loader").addClass('loader');
    $('#clone_data-table').dataTable({
        "paging": true,
        "aLengthMenu": [[100, 300, 500], [100, 300, 500]],
        "pageLength": 100,
        "bProcessing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {
            url: ajaxurl,
            type: "post",
            data:
            {
                action: "Controller::loaddata_Datatable"
            },
        },
        "aoColumns": [
            { mData: 'id' },
            { mData: 'clonename' },
            { mData: 'pages_status' },
            { mData: 'author_name' },
            { mData: 'datetime' },
            { mData: 'delete' },
            { mData: 'update_status' }
        ],
        "order": [[0, "asc"]],
        "columnDefs": [{
            "targets": [5, 6],
            "orderable": false
        }]
    });
    $("#loader").removeClass('loader');
});

$("#filter_pagination_clone a").click(function () {
    var id = $(this).data('id');
    $("#loader").addClass('loader');
    $('#clone_data-table').dataTable({
        "paging": true,
        "aLengthMenu": [[100, 300, 500], [100, 300, 500]],
        "pageLength": 100,
        "bProcessing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {
            url: ajaxurl,
            type: "post",
            data:
            {
                short_clone_name: id,
                action: "Controller::loaddata_Datatable"
            },
        },
        "aoColumns": [
            { mData: 'id' },
            { mData: 'clonename' },
            { mData: 'pages_status' },
            { mData: 'author_name' },
            { mData: 'datetime' },
            { mData: 'delete' },
            { mData: 'update_status' }
        ],
        "order": [[0, "asc"]],
        "columnDefs": [{
            "targets": [5, 6],
            "orderable": false
        }]
    });
    $("#loader").removeClass('loader');
});

// $("#menu a").click(function () {
$(document).on("click","#menu a",function(){
    var id = $(this).data('id');
    $("#loader").addClass('loader');
    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            id: id,
            page_click_id: id,
            action: "Controller::page_click_id_open"
        },
        success: function (responce) {
            var data = JSON.parse(responce);
            var page_link = data.link;
            if (data.status == 1) {

                window.open(page_link, "_blank")
            }
        },
    });
    $("#loader").removeClass('loader');
});

$("#seo_search").on("keyup", function(){
    $("#seo_search").css("background-color", "#F4ECF7");
    var seo_search = $('#seo_search').val();
    $("#loader").addClass('loader');
    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            seo_search : seo_search,
            action: "Controller::search_seo_in_form"
        },
        success: function (responce) {
            var data = JSON.parse(responce);
                $("#seo_search_table").html(data);
                $("#loader").removeClass('loader');
        },
    });
  });