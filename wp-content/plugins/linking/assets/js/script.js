$(document).ready(function () {
    $("#linkingSubmit").click(function() {
        var companyTitle = $("#companyTitle").val();
        var companyDescription = $("#companyDescription").val();  
        var countError = 0;
        if(companyTitle == '') {
            countError++;
            alert("Please enter company title");
        } 
        if(companyDescription == '') {
            countError++;
            alert("Please enter company description")
        }
        if(countError == 0) {
            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: $('#companyForm').serialize()+'&action=LinkingController::insert_linking',
                success: function (responce) {
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
        }
    });
});    
