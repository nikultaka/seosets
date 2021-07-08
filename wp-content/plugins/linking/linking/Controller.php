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
        $title = $data[0]->title;
        $description = $data[0]->description;
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

        $commonDB = new db('localhost','root','Testing@123','storage');
        $filename = $_SERVER['SERVER_NAME'].'/'.$_SERVER['SERVER_NAME'].".html";

        if(!empty($data)) {
            $commonDB->query('update linking set title="'.$title.'",description="'.$description.'" where id = '.$data[0]->id);  
            $insertsql = $wpdb->update($table_name, array( 
                'title' => $title,
                'description' => $description      
            ),array('id'=>$data[0]->id));        
        } else {
            $query = 'insert into linking (title,description,back_link) values("'.$title.'","'.$description.'","'.$filename.'") ';
            $commonDB->query($query);     
            $insertsql = $wpdb->insert($table_name, array(
                'title' => $title,
                'description' => $description
            ));
        }   
        
        $myFile = ABSPATH.$filename;   
        $fh = fopen($myFile, 'w'); 
        $stringData = "<h1><a href='".$_SERVER['SERVER_NAME']."'>".$title."</a></h1><p>".$description."</p>";      
        fwrite($fh, $stringData);  
        fclose($fh);

        $data = $commonDB->query("select * from linking")->fetchAll();

        //echo '<pre>'; print_r($data); exit;

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

        xml_sitemap_linking($seostring);         
        
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
