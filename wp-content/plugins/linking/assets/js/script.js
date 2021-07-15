$(document).ready(function () {
    $("#linkingSubmit").click(function() {
        var companyTitle = $("#companyTitle").val();
        var companyDescription = $("#companyDescription").val();  
        var countError = 0;
        if(companyTitle == '') {
            countError++;
            $("#companyTitle").parent('div').addClass('has-error');
        } 
        if(companyDescription == '') {
            countError++;
            $("#companyDescription").parent('div').addClass('has-error');
        }    
        if(countError == 0) {
            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: $('#companyForm').serialize()+'&action=LinkingController::insert_linking',
                success: function (responce) {
                    $("#companyTitle").parent('div').removeClass('has-error');
                    $("#companyDescription").parent('div').removeClass('has-error');
                    var data = JSON.parse(responce);
                    if (data.status == 1) {    
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $("#loader").removeClass('loader');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        $("#loader").removeClass('loader');
                    }  
                }
            });
        } else {
            return false;
        }    
    });
});    
