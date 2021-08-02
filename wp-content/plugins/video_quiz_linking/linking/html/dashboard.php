
<style>
form .error {
  color: #ff0000;
}

button,
input {
  font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
}

a {
  color: #f96332;
}

a:hover,
a:focus {
  color: #f96332;
}

p {
  line-height: 1.61em;
  font-weight: 300;
  font-size: 1.2em;
}

.category {
  text-transform: capitalize;
  font-weight: 700;
  color: #9A9A9A;
}

body {
  color: #2c2c2c;
  font-size: 14px;
  font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
  overflow-x: hidden;
  -moz-osx-font-smoothing: grayscale;
  -webkit-font-smoothing: antialiased;
}

.nav-item .nav-link,
.nav-tabs .nav-link {
  -webkit-transition: all 300ms ease 0s;
  -moz-transition: all 300ms ease 0s;
  -o-transition: all 300ms ease 0s;
  -ms-transition: all 300ms ease 0s;
  transition: all 300ms ease 0s;
}

.card a {
  -webkit-transition: all 150ms ease 0s;
  -moz-transition: all 150ms ease 0s;
  -o-transition: all 150ms ease 0s;
  -ms-transition: all 150ms ease 0s;
  transition: all 150ms ease 0s;
}

[data-toggle="collapse"][data-parent="#accordion"] i {
  -webkit-transition: transform 150ms ease 0s;
  -moz-transition: transform 150ms ease 0s;
  -o-transition: transform 150ms ease 0s;
  -ms-transition: all 150ms ease 0s;
  transition: transform 150ms ease 0s;
}

[data-toggle="collapse"][data-parent="#accordion"][aria-expanded="true"] i {
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
  -webkit-transform: rotate(180deg);
  -ms-transform: rotate(180deg);
  transform: rotate(180deg);
}


.now-ui-icons {
  display: inline-block;
  font: normal normal normal 14px/1 'Nucleo Outline';
  font-size: inherit;
  speak: none;
  text-transform: none;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

@-webkit-keyframes nc-icon-spin {
  0% {
    -webkit-transform: rotate(0deg);
  }

  100% {
    -webkit-transform: rotate(360deg);
  }
}

@-moz-keyframes nc-icon-spin {
  0% {
    -moz-transform: rotate(0deg);
  }

  100% {
    -moz-transform: rotate(360deg);
  }
}

@keyframes nc-icon-spin {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

.now-ui-icons.objects_umbrella-13:before {
  content: "\ea5f";
}

.now-ui-icons.shopping_cart-simple:before {
  content: "\ea1d";
}

.now-ui-icons.shopping_shop:before {
  content: "\ea50";
}

.now-ui-icons.ui-2_settings-90:before {
  content: "\ea4b";
}

.nav-tabs {
  border: 0;
  padding: 15px 0.7rem;
}

.nav-tabs:not(.nav-tabs-neutral)>.nav-item>.nav-link.active {
  /* box-shadow: 0px 5px 35px 0px rgba(0, 0, 0, 0.3); */
  background-color: #444;
  border-radius: 30px;
  color: #FFFFFF;
}

.card .nav-tabs {
  border-top-right-radius: 0.1875rem;
  border-top-left-radius: 0.1875rem;
}

.nav-tabs>.nav-item>.nav-link {
  color: #888888;
  margin: 0;
  margin-right: 5px;
  background-color: transparent;
  border: 1px solid transparent;
  border-radius: 30px;
  font-size: 14px;
  padding: 11px 23px;
  line-height: 1.5;
}

.nav-tabs>.nav-item>.nav-link:hover {
  background-color: transparent;
}

.nav-tabs>.nav-item>.nav-link:focus {
  background-color: #444;
  border-radius: 30px;
  color: #FFFFFF;
}

.nav-tabs>.nav-item>.nav-link.active {
  background-color: #444;
  border-radius: 30px;
  color: #FFFFFF;
}

.nav-tabs>.nav-item>.nav-link i.now-ui-icons {
  font-size: 14px;
  position: relative;
  top: 1px;
  margin-right: 3px;
}

.nav-tabs.nav-tabs-neutral>.nav-item>.nav-link {
  color: #FFFFFF;
}

.nav-tabs.nav-tabs-neutral>.nav-item>.nav-link.active {
  background-color: rgba(255, 255, 255, 0.2);
  color: #FFFFFF;
}

.card {
  border: 0;
  border-radius: 0.1875rem;
  display: inline-block;
  position: relative;
  width: 100%;
  margin-bottom: 30px;
  box-shadow: 0px 5px 25px 0px rgba(0, 0, 0, 0.2);
}

.card .card-header {
  background-color: transparent;
  border-bottom: 0;
  background-color: transparent;
  border-radius: 0;
  padding: 0;
}

.card[data-background-color="orange"] {
  background-color: #f96332;
}

.card[data-background-color="red"] {
  background-color: #FF3636;
}

.card[data-background-color="yellow"] {
  background-color: #FFB236;
}

.card[data-background-color="blue"] {
  background-color: #2CA8FF;
}

.card[data-background-color="green"] {
  background-color: #15b60d;
}

[data-background-color="orange"] {
  background-color: #e95e38;
}

[data-background-color="black"] {
  background-color: #2c2c2c;
}

[data-background-color]:not([data-background-color="gray"]) {
  color: #FFFFFF;
}

[data-background-color]:not([data-background-color="gray"]) p {
  color: #FFFFFF;
}

[data-background-color]:not([data-background-color="gray"]) a:not(.btn):not(.dropdown-item) {
  color: #FFFFFF;
}

[data-background-color]:not([data-background-color="gray"]) .nav-tabs>.nav-item>.nav-link i.now-ui-icons {
  color: #FFFFFF;
}


@font-face {
  font-family: 'Nucleo Outline';
  src: url("https://github.com/creativetimofficial/now-ui-kit/blob/master/assets/fonts/nucleo-outline.eot");
  src: url("https://github.com/creativetimofficial/now-ui-kit/blob/master/assets/fonts/nucleo-outline.eot") format("embedded-opentype");
  src: url("https://raw.githack.com/creativetimofficial/now-ui-kit/master/assets/fonts/nucleo-outline.woff2");
  font-weight: normal;
  font-style: normal;

}

.now-ui-icons {
  display: inline-block;
  font: normal normal normal 14px/1 'Nucleo Outline';
  font-size: inherit;
  speak: none;
  text-transform: none;
  /* Better Font Rendering */
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}


footer {
  margin-top: 50px;
  color: #555;
  background: #fff;
  padding: 25px;
  font-weight: 300;
  background: #f7f7f7;

}

.footer p {
  margin-bottom: 0;
}

footer p a {
  color: #555;
  font-weight: 400;
}

footer p a:hover {
  color: #e86c42;
}

@media screen and (max-width: 768px) {

  .nav-tabs {
    display: inline-block;
    width: 100%;
    padding-left: 100px;
    padding-right: 100px;
    text-align: center;
  }

  .nav-tabs .nav-item>.nav-link {
    margin-bottom: 5px;
  }
}
</style>


<!--========================================================================================================= -->
<div class="container-fluid">
  <!-- Nav tabs -->
  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs justify-content-center" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#seevideo" role="tab">
            <i class="fas fa-camera-retro"></i> See video
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#paypalEmailTab" role="tab">
            <i class="fab fa-paypal"></i> Paypal Email
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#paymentStatus" role="tab">
            <i class="far fa-credit-card"></i> Payment Status
          </a>
        </li>
      </ul>
    </div>
    <div class="card-body" style="margin: 30px;">
      <!-- Tab panes -->
      <div class="tab-content text-center">
        <div class="tab-pane active" id="seevideo" role="tabpanel">
          <?php if (!empty($frontendQuizData)) { ?>
            <div id="videoID_<?php echo $frontendQuizData->id; ?>">
              <video id="linkVid_<?php echo $frontendQuizData->id; ?>" data_id="<?php echo $frontendQuizData->id; ?>" class="linkVid" width="320" height="240" controls style="<?php echo $style; ?>">
                <source src="<?php echo $frontendQuizData->link; ?>">
                  Your browser does not support the video tag.
                </video>
              </div>
              <div id="quizID_<?php echo $frontendQuizData->id; ?>" style="display: none;">
                <?php echo do_shortcode('[ays_quiz id="' . $frontendQuizData->quiz_id . '"]'); ?>
              </div>
            <?php } else { ?>
                <p>No video found</p>
            <?php } ?>  
          </div>   

          <div class="tab-pane" id="paypalEmailTab" role="tabpanel">
            <div class="page-login-form box">
              <!-- <h3> Add Paypal Email </h3> -->
              <form onsubmit="return false" method="POST" name="paypalEmailForm" id="paypalEmailForm">
                <input type="hidden" name="action" value="VideoLinkingController::insert_paypalEmail">
                <div class="form-group">
                  <div class="input-icon">
                    <i class="lni-user"></i>
                    <input type="text" id="paypalEmail" class="form-control" name="paypalEmail" placeholder="Enter Paypal Email" value="<?php echo $paypalEmail; ?>">
                  </div>
                </div>
                <button class="btn btn-info log-btn" id="paypalEmail_btn">Submit</button>
              </form>
            </div>
          </div>

          <div class="tab-pane" id="paymentStatus" role="tabpanel">
            <table id="videoPaymentDataTable" class="table table-striped table-bordered" style="width:100% ; font-size:15px; color:black;">
              <thead>
                <tr>
                  <th>User</th>
                  <th>Video Title</th>
                  <th>Paid Status</th>
                  <!-- <th>Status</th> -->
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($userquizSqlData)) {
                  foreach ($userquizSqlData as $key => $value) {
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
                      <!-- <td><?php echo $status; ?></td> -->
                      <td><?php echo $newDate; ?></td>
                    </tr>
                  <?php }
                } else { ?>
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script>
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
  </script>