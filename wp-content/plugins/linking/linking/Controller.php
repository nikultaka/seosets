<?php
add_action('admin_menu', 'custom_linking_menu');

function custom_linking_menu()
{
    add_menu_page('SEO Linking', 'SEO Linking', 'manage_options', 'seo-linking', 'linking_form', 'dashicons-admin-site', 56);
}

function linking_form()
{
    ob_start();
    wp_enqueue_style('linking_style', plugins_url('../assets/css/style.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_script('linking_script', plugins_url('../assets/js/script.js', __FILE__));
    global $wpdb;
    $table_name = $wpdb->prefix . "linking";
    $query = "select * from ".$table_name;   
    $data = $wpdb->get_results($query);

    $title = "";
    $description = '';
    if(!empty($data)) {
        $title = stripslashes($data[0]->title);
        $description = stripslashes($data[0]->description);
    }
    include(dirname(__FILE__) . "/html/add_linking_form.php");
    $s = ob_get_contents();
    ob_end_clean();
    print $s;
}


class LinkingController
{
    public function insert_linking()
    {   
        set_time_limit(0);
        global $wpdb;
        global $wp_rewrite;
        $table_name = $wpdb->prefix.'linking';
        $title = $_POST['companyTitle'];
        $description = $_POST['companyDescription'];

        $query = "select * from ".$table_name;   
        $data = $wpdb->get_results($query);

        $commonDB = new db(STORAGE_HOST,STORAGE_USERNAME,STORAGE_PASSWORD,STORAGE_DB);
        $siteUrl = get_site_url();  

        $commonDbData = $commonDB->query("select * from linking")->fetchAll();    
        $commonDBID = '';
        if(!empty($commonDbData)) {
            $commonDBID = $commonDbData[0]['id'];
        }    

        global $user_ID;
        if(!empty($data)) {            
            $commonDB->query('update linking set title="'.addslashes($title).'",description="'.addslashes($description).'",back_link = "'.$siteUrl.'" where id = '.$commonDBID);  
            $insertsql = $wpdb->update($table_name, array( 
                'title' => $title,
                'description' => $description     
            ),array('id'=>$data[0]->id));  

            $data = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'linking' and meta_value = '".$siteUrl."'");     

            if(!empty($data)) {
                $postID = $data[0]->post_id;    
                $post = array();
                $post['ID'] = $postID;
                $post['post_title'] = $title;
                $post['post_content'] = $description;
                wp_update_post($post,true);
            }   
        } else {      
            $insertsql = $wpdb->insert($table_name, array(
                'title' => $title,
                'description' => $description
            ));     
            $new_post = array(   
                'post_title' => $title,     
                'post_content' => $description,
                'post_status' => 'publish',
                'post_date' => date('Y-m-d H:i:s'),
                'post_author' => $user_ID,
                'post_type' => 'post',
                'post_category' => array(0)    
            );         
            $postID = wp_insert_post($new_post);   
            add_post_meta($postID,'linking',$siteUrl);

            $postData = get_post($postID);     
            $query = 'insert into linking (title,description,back_link,post_url) values("'.addslashes($title).'","'.addslashes($description).'","'.$siteUrl.'","'.$postData->guid.'") ';
            $commonDB->query($query);     
        }                    
        
        /*$myFile = ABSPATH.$filename;   
        $fh = fopen($myFile, 'w'); 
        $stringData = "<h1><a href='".$_SERVER['SERVER_NAME']."'>".$title."</a></h1><p>".$description."</p>";      
        fwrite($fh, $stringData);  
        fclose($fh);  
        $data = $commonDB->query("select * from linking")->fetchAll();
        $seostring = '';
        if(!empty($data)) {
            foreach($data as $key => $value) {
                $seostring .= '<url>'.
                    '<loc>'.$value['back_link'].'</loc>'.
                    '<lastmod>'.$value['created_at'].'</lastmod>'.
                    '<changefreq>monthly</changefreq>'.
                '</url>';    
            }             
        }           
        xml_sitemap_linking($seostring);*/


        
        $data['status'] = 1;    
        $data['msg'] = "Company information saved successfully";
        
        echo json_encode($data);
        exit();
    }     
}                  

$linkingController = new LinkingController();
add_action('wp_ajax_LinkingController::insert_linking', array($linkingController,'insert_linking'));

function xml_sitemap_linking($seostring) {
    $postsForSitemap = get_posts(array(
        'numberposts' => -1,
        'orderby' => 'modified',
        'post_type'  => array('post','page'),
        'order'    => 'DESC'
    ));  

    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    foreach($postsForSitemap as $post) {   
        setup_postdata($post);  
        $postdate = explode(" ", $post->post_modified);
        $sitemap .= '<url>'.
        '<loc>'. get_permalink($post->ID) .'</loc>'.
        '<lastmod>'. $postdate[0] .'</lastmod>'.
        '<changefreq>monthly</changefreq>'.
        '</url>';
    }
    $sitemap.=$seostring;        
    $sitemap .= '</urlset>';               

    $fp = fopen(ABSPATH . "sitemap.xml", 'w');
    fwrite($fp, $sitemap);
    fclose($fp);
}  


function callCurl($url,$title,$description,$linking) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $linking.'/wp-json/linking/v1/blog',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('title'=>$title,'linking'=>$linking,'description'=>$description,'url'=>$url),
  ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response);
}



function cron_job($data) {
    $commonDB = new db(STORAGE_HOST,STORAGE_USERNAME,STORAGE_PASSWORD,STORAGE_DB);
    $data = $commonDB->query("select * from linking")->fetchAll();
    if(!empty($data)) {
        foreach($data as $key => $value) {          
            callCurl($value->post_url,$value->title,$value->description,$value->back_link);
        }        
    }
}

function add_blog() {
    global $wpdb;
    $title = $_POST['title'];   
    $description = $_POST['description'];  
    $linking = $_POST['linking'];
    $url = $_POST['url'];        
    $data = get_users();
    $userID = '';
    if(!empty($data)) {
        foreach($data as $key => $value) {
            $role = $value->roles[0];   
            if($role == 'administrator') {
                $userID = $value->data->ID;
                break;
            }
        }           
    }
    $data = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'linking' and meta_value = '".$linking."'");
    if(!empty($data)) {
        $postID = $data[0]->post_id;    
        $post = array();
        $post['ID'] = $postID;
        $post['post_title'] = $title;
        $post['post_content'] = $description.'<div style="display:none;"><a href="'.$url.'">'.$title.'</a><div>';     
        wp_update_post($post,true);    
    } else {     
        $new_post = array(   
            'post_title' => $title,     
            'post_content' => $description.'<div style="display:none;"><a href="'.$url.'">'.$title.'</a><div>',     
            'post_status' => 'publish',
            'post_date' => date('Y-m-d H:i:s'),
            'post_author' => $userID,
            'post_type' => 'post',
            'post_category' => array(0),
        );              
        $postID = wp_insert_post($new_post);        
        add_post_meta($postID,'linking',$linking);
    }    
    return array('status'=>1);
}

add_action( 'rest_api_init', function () {     
    @register_rest_route( 'linking/v1', '/cron', array(
        'methods' => 'GET',
        'callback' => 'cron_job',
    ));     
});     

add_action( 'rest_api_init', function () {
    @register_rest_route( 'linking/v1', '/blog', array(
        'methods' => 'POST',
        'callback' => 'add_blog',
    ));     
});   