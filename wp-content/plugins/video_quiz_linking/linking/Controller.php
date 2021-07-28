<?php
add_action('admin_menu', 'custom_quiz_linking_menu');

function custom_quiz_linking_menu()
{
    add_menu_page('Video Linking', 'Video Linking', 'manage_options', 'video-linking', 'display_video_linking', 'dashicons-chart-area', 56);
    add_submenu_page(
        'video-linking', // parent slug
        'Video Linking', // page title
        'Video Linking', // menu title
        'manage_options', // capability
        'video-linking', // slug 
        'display_video_linking' // callback
    );

    add_submenu_page(
        'video-linking', // parent slug
        'Paypal Payout', // page title
        'Paypal Payout', // menu title
        'manage_options', // capability
        'paypal-payout', // slug
        'payout' // callback 
    );     
}

function display_video_linking()
{
    ob_start();
    wp_enqueue_style('clone_style', plugins_url('../assets/css/style.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_script('datatable-script','https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery') );
    wp_enqueue_script('bootstrap-script','https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery') );
    wp_enqueue_script('sweetalert-script','//cdn.jsdelivr.net/npm/sweetalert2@10', array('jquery') );
    wp_enqueue_script('script', plugins_url('../assets/js/script.js', __FILE__));

    global $wpdb;
    $table_name = $wpdb->prefix . "aysquiz_quizes";
    $table_quiz_linking = $wpdb->prefix . "video_quiz_linking";

    $query = "SELECT * from ".$table_name;
    $quizesData = $wpdb->get_results($query);

    $query = "SELECT ql.id,ql.video_name,ql.amount,aq.title,ql.status from ".$table_quiz_linking." as ql left join ".$table_name." as aq on aq.id = ql.quiz_id";
    $tableData = $wpdb->get_results($query);



    $args = array(
      'post_type' => 'attachment',
      'numberposts' => -1,
      'post_status' => null,
      'post_parent' => null, // any parent
      'post_mime_type' => 'video'
  ); 

    $attachments = get_posts( $args );

    include(dirname(__FILE__) . "/html/linking_quiz_form.php");
    $s = ob_get_contents();
    ob_end_clean();
    print $s;
}

function payout()          
{
    
}

function videoDashboard() {
    ob_start();
    wp_enqueue_style('clone_style', plugins_url('../assets/css/style.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_script('datatable-script','https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js', array('jquery') );
    wp_enqueue_script('bootstrap-script','https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery') );
    wp_enqueue_script('sweetalert-script','//cdn.jsdelivr.net/npm/sweetalert2@10', array('jquery') );
    wp_enqueue_script('script', plugins_url('../assets/js/script.js', __FILE__));

    global $wpdb;
    $table_name = $wpdb->prefix . "aysquiz_quizes";
    $table_quiz_linking = $wpdb->prefix . "video_quiz_linking";

    $query = "SELECT * from ".$table_name;
    $quizesData = $wpdb->get_results($query);

    $query = "SELECT ql.* from ".$table_quiz_linking." as ql 
    left join ".$table_name." as aq on aq.id = ql.quiz_id
    left join ".$table_name." as aq on aq.id = ql.quiz_id";
    $tableData = $wpdb->get_results($query);

    echo '<pre>'; print_r($tableData); exit;

    include(dirname(__FILE__) . "/html/dashboard.php");
    $s = ob_get_contents();
    ob_end_clean();
    print $s;

}
add_shortcode('dashboard', 'videoDashboard');   


class VideoLinkingController
{
    public function insert_video()
    {   
        global $wpdb;
        $hiddenID = $_POST['hiddenID'];
        $videoName = $_POST['videoName'];
        $videoID = $_POST['videoID'];
        $quizName = $_POST['quizName'];
        $amount = $_POST['amount'];
        $status = $_POST['status'];             

        $table_quiz_linking = $wpdb->prefix . "video_quiz_linking";
        $data = array('video_name'=>$videoName,'video_url'=>$videoID,'quiz_id'=>$quizName,'amount'=>$amount,'status'=>$status);

        if($hiddenID =='') {
            $wpdb->insert($table_quiz_linking,$data);       
            $data = array();
            $data['status'] = 1;
            $data['msg'] = "Video added successfully";
        } else {
            $wpdb->update($table_quiz_linking,$data,array('id'=>$hiddenID));    
            $data = array();
            $data['status'] = 1;
            $data['msg'] = "Video updated successfully";
        }
        echo json_encode($data);
        exit();
    }

    public function get_data() {
        global $wpdb;    
        $hiddenID = $_POST['id'];
        $table_quiz_linking = $wpdb->prefix . "video_quiz_linking";

        $query = "SELECT * from ".$table_quiz_linking." where id = ".$hiddenID;
        $quizesData = $wpdb->get_results($query);
        echo json_encode(array('status'=>1,'data'=>$quizesData[0]));
        die;
    }

    public function delete_record()
    {
        global $wpdb;
        $hiddenID = $_POST['id'];
        $table_quiz_linking = $wpdb->prefix . "video_quiz_linking";
        $wpdb->delete($table_quiz_linking,array('id'=>$hiddenID));    
        echo json_encode(array('status'=>1));
        exit();
    }

}

$videoLinkingController = new VideoLinkingController();
add_action('wp_ajax_VideoLinkingController::insert_video', array($videoLinkingController, 'insert_video'));
add_action('wp_ajax_VideoLinkingController::get_data', array($videoLinkingController, 'get_data'));
add_action('wp_ajax_VideoLinkingController::delete_record', array($videoLinkingController, 'delete_record'));
