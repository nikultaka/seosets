<style>
    form .error {
        color: #ff0000;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<div class="container" id="content">
    <div class="page-login-form box">
        <h3> Add Paypal Email </h3>
        <form onsubmit="return false" method="POST" name="paypalEmailForm" id="paypalEmailForm">
            <input type="hidden" name="action" value="VideoLinkingController::insert_paypalEmail">
            <div class="form-group">
                <div class="input-icon">
                    <i class="lni-user"></i>
                    <input type="text" id="paypalEmail" class="form-control" name="paypalEmail" placeholder="Enter Paypal Email">
                </div>
            </div>
            <button class="btn btn-info log-btn" id="paypalEmail_btn">Submit</button>
        </form>
    </div>
</div>

<script>
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    $('#paypalEmail_btn').on('click', function() {
        var paypalEmail = $('#paypalEmail').val();
        var form = $("#paypalEmailForm");
        form.validate({
            rules: {
                paypalEmail: {
                    required: true,
                    email: true,
                },
            },
            messages: {
                paypalEmail: {
                    required: 'Paypal Email is required',
                    email: "Enter Valid Email addresss"
                }
            }
        });
        if (form.valid() === true) {
            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                    'paypalEmail': paypalEmail,
                    action: "VideoLinkingController::insert_paypalEmail"
                },
                success: function(responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire(
                            'Deleted!',
                            data.msg,
                            'success',
                            );
                    }else{
                        Swal.fire(
                            'Error!',
                            data.msg,
                            'error'
                        )
                    }
                }
            });
        }
    });
</script>