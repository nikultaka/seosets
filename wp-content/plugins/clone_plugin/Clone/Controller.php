<?php
add_action('admin_menu', 'custom_clone_menu');

function custom_clone_menu()
{

    add_menu_page('SEO Booster', 'SEO Booster', 'manage_options', 'seo-sets', 'display_clone_set', 'dashicons-chart-area', 56);
    add_submenu_page(
        'seo-sets', // parent slug
        'SEO Sets', // page title
        'SEO Sets', // menu title
        'manage_options', // capability
        'seo-sets', // slug
        'display_clone_set' // callback
    );
  
    add_submenu_page(
        'seo-sets', // parent slug
        'SEO Pages', // page title
        'SEO Pages', // menu title
        'manage_options', // capability
        'seo-pages', // slug
        'display_clone_pages' // callback
    );
}

function display_clone_set()
{
    ob_start();
    wp_enqueue_style('clone_style', plugins_url('../assets/css/style.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_script('script', plugins_url('../assets/js/script.js', __FILE__));

    global $wpdb;
    $table_name = $wpdb->prefix . "posts";
    $meta_table_name = $wpdb->prefix . "postmeta";
    $user_table_name =  $wpdb->prefix . "users";
    // $query = "SELECT DISTINCT post_title,ID,".$meta_table_name.".meta_key FROM ".$table_name." 
    //         left JOIN ".$meta_table_name." ON ".$meta_table_name.".post_id = ".$table_name.".ID and ".$meta_table_name.".meta_key = 'my_clone_meta_key'
    //         WHERE post_type = 'page' 
    //         AND (post_status = 'publish' or post_status = 'draft') 
    //         having meta_key is null";

    $query = "SELECT DISTINCT post_title,post_status," . $table_name . ".ID," . $meta_table_name . ".meta_key ," . $user_table_name . ".user_login AS user_name FROM " . $table_name . " 
    left JOIN " . $meta_table_name . " ON " . $meta_table_name . ".post_id = " . $table_name . ".ID and " . $meta_table_name . ".meta_key = 'my_clone_meta_key'
    LEFT JOIN " . $user_table_name . " ON " . $user_table_name . ".ID = " . $table_name . ".post_author
    WHERE post_type = 'page' 
    AND (post_status = 'publish' or post_status = 'draft') 
    having meta_key is null";

    $pagessql = $wpdb->get_results($query);

    if (is_array($pagessql)) {
        $data['pagessql'] = $pagessql;
    }
    include(dirname(__FILE__) . "/html/add_clone_form.php");
    $s = ob_get_contents();
    ob_end_clean();
    print $s;
}

function display_clone_pages()
{
    ob_start();
    wp_enqueue_style('clone_style', plugins_url('../assets/css/style.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_script('script', plugins_url('../assets/js/clone_pages.js', __FILE__));
    global $wpdb;
    $clone_table_name = $wpdb->prefix . "clone";

    $query = "SELECT page_insert_id,clonename  FROM " . $clone_table_name . " as clone ";

    $pagessql = $wpdb->get_results($query);
    if (is_array($pagessql)) {
        $data['pagessql'] = $pagessql;
    }
    include(dirname(__FILE__) . "/html/clone_page_list.php");
    $s = ob_get_contents();
    ob_end_clean();
    print $s;
}


class Controller
{

    public function new_attachment( $att_id ){
        // the post this was sideloaded into is the attachments parent!

        // fetch the attachment post
        $att = get_post( $att_id );

        // grab it's parent
        $post_id = $att->post_parent;

        // set the featured post
        set_post_thumbnail( $post_id, $att_id );
        return $post_id;
    }

    public function insert_clone()
    {   
        
        global $wpdb;
        $data['status'] = 0;
        $data['msg'] = "Please enter all details";
        $clonename = $_POST['clonename'];
        $pages = implode(",", $_POST['pages']);
        $clone_tags = $_POST['clone_tags'];
        $pages_status = $_POST['pages_status'];
        $table_name = $wpdb->prefix . "clone";
        $pages_table_name = $wpdb->prefix . "posts";

        // decode tags content                          
        $jsonData = stripslashes(html_entity_decode($clone_tags));
        $explodedData = explode(PHP_EOL, $jsonData);

        if (!empty($explodedData)) {
            $newjsonString = '[';
            foreach ($explodedData as $explodeKey => $explodeValue) {
                $newjsonString .= $explodeValue . ',';
            }
            $newjsonString = substr($newjsonString, 0, -1);
            $newjsonString .= ']';
        }

        $decode_clone_tags = json_decode($newjsonString,true);

        // $decode_clone_tags = explode(",",$post_id);
        $pages_id = $_POST['pages'];

        foreach ($pages_id as $value) {
            $pages_title_name = 1;

            //copy selected page content
            $get_post = get_post($value);

            $meta_values = get_post_meta($value);
            $thumbnail_id = get_post_thumbnail_id($value);

            $img_post_parent_id = wp_get_post_parent_id($thumbnail_id);
            $image_alt_content = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

            $title_post = $get_post->post_title;
            $content_post = $get_post->post_content;
            $meta_wpseo_title = $meta_values['_yoast_wpseo_title'];
            $meta_wpseo_metadesc = $meta_values['_yoast_wpseo_metadesc'];
            $implode_meta_wpseo_metadesc = implode(" ", $meta_wpseo_metadesc);
            $implode_meta_wpseo_title = implode(" ", $meta_wpseo_title);
            
            if ($decode_clone_tags != '' && $decode_clone_tags != NULL) {
                
                $page_insert_data = array();
                foreach ($decode_clone_tags as  $create_tags_name_page) {
                    $all_pages_content  = $content_post;
                    $all_meta_content = $implode_meta_wpseo_metadesc;
                    $all_meta_title = $implode_meta_wpseo_title;
                    $all_pages_title  = $title_post;
                    $replace_content = $all_pages_content;
                    $replace_title = $all_pages_title;
                    $image_alt = $image_alt_content;

                    foreach ($create_tags_name_page as $sagkey => $sagvalue) {
                        // replace {{}} tags content
                        $replace_content = str_replace('{{' . $sagkey . '}}', $sagvalue, $replace_content);
                        $all_meta_content = str_replace('{{' . $sagkey . '}}', $sagvalue, $all_meta_content);
                    }
                    $titleContainsTag = 0;
                    if (strpos($all_pages_title, '{{') !== false) {
                        $titleContainsTag = 1;
                    }
                    foreach ($create_tags_name_page as $titlekey => $titlevalue) {
                        $replace_title = str_replace('{{' . $titlekey . '}}', $titlevalue, $replace_title);
                        $all_meta_title = str_replace('{{' . $titlekey . '}}', $titlevalue, $all_meta_title);
                    }
                    foreach ($create_tags_name_page as $imagekey => $imagevalue) {
                        $image_alt = str_replace('{{' . $imagekey . '}}', $imagevalue, $image_alt);
                    }
                    $new_title_post = $get_post->post_title . ' - ' . $pages_title_name;

                    $post_login_data = wp_get_current_user();
                    $post_author = $post_login_data->ID;
                    if ($pages_status == "publish") {

                        // Create post type is publish
                        $my_post = array(
                            'post_type'     => 'page',
                            'post_title'    =>  $titleContainsTag == '0' ? $new_title_post : $replace_title,
                            'post_content'  => $replace_content,
                            'post_author'   => $post_author,
                            'post_status'   => 'publish',

                        );
                    } else {
                        // Create post object
                        $my_post = array(
                            'post_type'     => 'page',
                            'post_title'    => $titleContainsTag == '0' ? $new_title_post : $replace_title,
                            'post_content'  => $replace_content,
                            'post_status'   => 'draft',
                            'post_author'   => $post_author
                        );
                    }
                    $pages_title_name++;

                    $img_meta_values = get_post_meta($thumbnail_id);
                    $_wp_attached_file = $img_meta_values['_wp_attached_file'];
                    $_wp_attachment_metadata = $img_meta_values['_wp_attachment_metadata'];

                    // Insert the post into the database
                    $page_insert_id = wp_insert_post($my_post);
                    $page_insert_data[] = $page_insert_id;
                    update_post_meta($page_insert_id, 'my_clone_meta_key', 1);
                    update_post_meta($page_insert_id, '_yoast_wpseo_title', $all_meta_title);
                    update_post_meta($page_insert_id, '_yoast_wpseo_metadesc', $all_meta_content);

                    //image {{tag}}

                    if(!empty($img_meta_values)) {
                        $imageUrl = wp_upload_dir()['baseurl'].'/'.$_wp_attached_file[0]; 
                        $lastImageID = media_sideload_image($imageUrl,$thumbnail_id,"",'id');   
                        set_post_thumbnail($page_insert_id,$lastImageID);
                        update_post_meta($lastImageID, '_wp_attachment_image_alt',$image_alt);

                        /*update_post_meta($page_insert_id, '_wp_attached_file', $_wp_attached_file);
                        update_post_meta($page_insert_id, '_wp_attachment_metadata', $_wp_attachment_metadata);
                        update_post_meta($page_insert_id, '_wp_attachment_image_alt',$image_alt);
                        update_post_meta($page_insert_id, '_thumbnail_id', $thumbnail_id); */
                    }
                }

                $all_pages_insert_id = implode(",", $page_insert_data);
                // insert new page in database
                $insertsql = $wpdb->insert($table_name, array(
                    'clonename' => $clonename,
                    'pages'     => $pages,
                    'tags'      => $clone_tags,
                    'pages_status'  => $pages_status,
                    'page_insert_id' => $all_pages_insert_id
                ));

                if($insertsql){
                    $data['status'] = 1;
                    $data['msg'] = "Clone created successfully";
                }
                // $insert_post_parent_sql = "UPDATE " . $pages_table_name . "
                //                      SET post_parent = " . $img_post_parent_id . "
                //                      WHERE  " . $pages_table_name . ".ID IN(" . $all_pages_insert_id . ")";
                // $insert_post_parent_sql_result = $wpdb->get_results($insert_post_parent_sql);
            }
        }
        echo json_encode($data);
        exit();
    }

    function loaddata_Datatable()
    {
        global $wpdb;
        $requestData = $_POST;

        $data = array();
        $table_name = $wpdb->prefix . "clone";
        $user_table_data = $wpdb->prefix . "users";
        $posts_table_data = $wpdb->prefix . "posts";
        $short_by_clone_name_id = $_POST['short_clone_name'];

        $result_sql = "SELECT clone.* , " . $user_table_data . ".user_login AS user_name  FROM " . $table_name . " as clone 
                            LEFT JOIN " . $posts_table_data . " ON " . $posts_table_data . ".ID = clone.page_insert_id 
                            LEFT JOIN " . $user_table_data . " ON " . $user_table_data . ".ID = " . $posts_table_data . ".post_author";

        // -------------------------------------------------------------------------------------------------------------
        if ($short_by_clone_name_id != '' && $short_by_clone_name_id != null) {
            $result_sql .=  " WHERE ((clone.clonename LIKE '$short_by_clone_name_id%')
                                  OR (clone.clonename LIKE '" . ucfirst($short_by_clone_name_id) . "%'))";
        }
        //--------------------------------------------------------------------------------------------------------------- 

        $post_login_data = wp_get_current_user();
        $post_author_name = $post_login_data->ID;

        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];

            $result_sql .= " AND ((clone.clonename LIKE '%" . $search . "%')
                                 OR (" . $user_table_data . ".user_login LIKE '%" . $search . "%')
                                 OR (clone.pages_status LIKE '%" . $search . "%')
                                 OR (clone.created_at LIKE '%" . $search . "%'))";
        }
        $columns = array(
            0 => 'clone.id',
            1 => 'clone.clonename',
            2 => 'clone.pages_status',
            3 => 'clone.user_name',
            4 => 'clone.created_at',
            // 3 => 'clone.tags',
        );

        if (isset($requestData['order'][0]['column']) && $requestData['order'][0]['column'] != '') {
            $order_by = $columns[$requestData['order'][0]['column']];
            $result_sql .= " ORDER BY " . $order_by;
        } else {
            $result_sql .= " ORDER BY clone.id DESC";
        }

        if (isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] != '') {
            $result_sql .= " " . $requestData['order'][0]['dir'];
        } else {
            $result_sql .= " DESC ";
        }

        $result = $wpdb->get_results($result_sql, OBJECT);
        $totalData = 0;
        $totalFiltered = 0;
        if (count($result) > 0) {
            $totalData = count($result);
            $totalFiltered = count($result);
        }

        // This is for pagination
        if (isset($requestData['start']) && $requestData['start'] != '' && isset($requestData['length']) && $requestData['length'] != '') {
            $result_sql .= " LIMIT " . $requestData['start'] . "," . $requestData['length'];
        }

        $list_data = $wpdb->get_results($result_sql, "OBJECT");
        $arr_data = array();
        $arr_data = $result;
        $count = 1;

        foreach ($list_data as $row) {
            $temp['id'] = $count;
            $temp['clonename'] = $row->clonename;
            if (strtolower($row->pages_status) == 'publish') {
                $row->pages_status = "Published";
            }
            $temp['pages_status'] = ucfirst($row->pages_status);
            $temp['author_name'] = $row->user_name;
            $temp['datetime'] = $row->created_at != '' ? date('d-m-Y h:i', strtotime($row->created_at)) : '';
            // $temp['tags'] = $row->tags;

            $delete = "<button  class='btn btn-danger btn-sm' onclick='record_delete(" . $row->id . ",[" . $row->page_insert_id . "])'><i class='fa fa-trash' aria-hidden='true'></i></button>";
            // <button  class='btn btn-success'  onclick='record_edit(" . $row->id . ")'><i class='fa fa-pencil-square' aria-hidden='true'></i></button>
            $temp['delete'] = $delete;
            if ($row->pages_status == "draft") {
                $status_change = 'Status Change to Publish';
            } else {
                $status_change = 'Status Change to Draft';
            }
            $switch_status = '';
            if (strtolower($row->pages_status) == "published") {
                $switch_status = 'checked';
            }
            $temp['update_status'] = '<div class="custom-control custom-switch">
                                 <input type="checkbox" class="custom-control-input statusswitch"  data-toggle="tooltip" 
                                 data-placement="top" title="' . $status_change . '" ' . $switch_status . ' data-id="' . $row->id . '" data-prod_id="' . $row->page_insert_id . '" id="customSwitches' . $count . '">
                                 <label  class="custom-control-label" for="customSwitches' . $count . '"></label>
                                 </div>';

            $data[] = $temp;
            $count++;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "sql" => $result_sql
        );

        echo json_encode($json_data);
        exit();
    }

    function delete_record()
    {
        global $wpdb;
        $deleteId = $_POST['id'];
        $page_insert_id = implode(",", $_POST['page_insert_id']);
        $table_name = $wpdb->prefix . "clone";
        $pages_table_name = $wpdb->prefix . "posts";
        $meta_table_name = $wpdb->prefix . "postmeta";

        $result['status'] = 0;
        $result['msg'] = "Error ! DELETE UNsucessfully";
        $delete_sql = $wpdb->delete($table_name, array('id' => $deleteId));
        $delete_pages_sql = $wpdb->get_results("DELETE FROM " . $pages_table_name . " WHERE " . $pages_table_name . ".ID IN($page_insert_id)");
        $meta_delete_pages_sql = $wpdb->get_results("DELETE FROM " . $meta_table_name . " WHERE " . $meta_table_name . ".post_id IN($page_insert_id)");
        if ($delete_pages_sql) {
            $result['status'] = 1;
            $result['msg'] = "Clone deleted sucessfully";
        }
        if ($delete_sql) {
            $result['status'] = 1;
            $result['msg'] = "Clone deleted sucessfully";
        }
        echo json_encode($result);
        exit();
    }

    function change_page_status()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "clone";
        $update_id = $_POST['id'];
        $post_id = $_POST['page_insert_id'];
        $page_insert_id = explode(",", $post_id);
        $status = $_POST['status'];

        foreach ($page_insert_id as $value) {
            if ($status == 1) {
                $wpdb->update(
                    $table_name,
                    array(
                        'pages_status'  => 'publish'
                    ),
                    array('id' => $update_id)
                );

                $update_post_status = array(
                    'post_type' => 'page',
                    'ID' => $value,
                    'post_status' => 'publish'
                );
            } else {
                $wpdb->update(
                    $table_name,
                    array(
                        'pages_status'  => 'draft'
                    ),
                    array('id' => $update_id)
                );

                $update_post_status = array(
                    'post_type' => 'page',
                    'ID' => $value,
                    'post_status' => 'draft'
                );
            }
            wp_update_post($update_post_status);
        }
    }

    function page_click_id_open_url()
    {
        $result['status'] = 0;
        $page_click_id = $_POST['page_click_id'];
        $post_url_link = get_edit_post_link($page_click_id);
        $url_link = str_replace("&amp;", "&", $post_url_link);

        if ($url_link) {
            $result['status'] = 1;
            $result['link'] = $url_link;
        }
        echo json_encode($result);
        exit();
    }

    function search_seo_in_form()
    {
        global $wpdb;
        $seo_search = $_POST['seo_search'];
        $table_name = $wpdb->prefix . "posts";
        $meta_table_name = $wpdb->prefix . "postmeta";
        $user_table_name =  $wpdb->prefix . "users";

        $query = "SELECT DISTINCT post_title,post_status," . $table_name . ".ID," . $meta_table_name . ".meta_key ," . $user_table_name . ".user_login AS user_name FROM " . $table_name . " 
        left JOIN " . $meta_table_name . " ON " . $meta_table_name . ".post_id = " . $table_name . ".ID and " . $meta_table_name . ".meta_key = 'my_clone_meta_key'
        LEFT JOIN " . $user_table_name . " ON " . $user_table_name . ".ID = " . $table_name . ".post_author
        WHERE post_type = 'page' 
        AND (post_status = 'publish' or post_status = 'draft')";
        if ($seo_search != '' && $seo_search != null) {
            $query .=  " AND ((" . $table_name . ".post_title LIKE '%" . $seo_search . "%')
                         OR (" . $table_name . ".post_status LIKE '%" . $seo_search . "%')
                         OR (". $user_table_name . ".user_login LIKE '%" . $seo_search . "%'))";
        }
        $query .= " having meta_key is null";
        $pagessql = $wpdb->get_results($query, OBJECT);

                $table =
                 '<div class="form-group">
                            <div class="list-group menu" id="menu" name="menu">
                            <table class="table table-hover table-sm">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">SEO Set</th>
                                    <th scope="col">Author name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Edit SEO Set</th>
                                </tr>';

                    foreach ($pagessql as $pages) { 
                    $table .='      <tr value="'. $pages->ID .'" style="margin-left: 10px;">
                                        <td><input type="checkbox" name="pages[]" value="'.  $pages->ID .'"></td>
                                        <td>'. $pages->post_title .'</td> 
                                        <td> '. $pages->user_name .'</td> 
                                        <td>'. ucfirst($pages->post_status) .' </td>
                                        <td>
                                        <a href="javascript:void(0)" style="float:right;" data-id="'.$pages->ID.'">
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i></a>
                                        </td>';
                            }
                    $table .= '</tr>
                        </table>
                     </div>
                 </div>';

        echo json_encode($table);       
        exit();
    }


    // function edit_record(){
    //     global $wpdb;
    //     $editId = $_POST['id'];
    //     $result['status'] = 0;
    //     $table_name = $wpdb->prefix . "clone";

    //     $edit_sql = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = '$editId' ");
    //     $edit_tags = $edit_sql[0]->tags;
    //     $pages_tags = stripslashes(html_entity_decode($edit_tags));

    //     if ($edit_sql > 0) {
    //         $result['status'] = 1;
    //         $result['recoed'] = $edit_sql[0];
    //         $result['pages_tags'] = $pages_tags;
    //     }
    //     echo json_encode($result);
    //     exit();
    // }

    function load_clone_pages_Datatable()
    {
        global $wpdb;
        $requestData = $_POST;
        $data = array();
        $table_name = $wpdb->prefix . "posts";
        $meta_table_name = $wpdb->prefix . "postmeta";
        $user_data = $wpdb->prefix . "users";
        $clone_table_name = $wpdb->prefix . "clone";
        $post_login_data = wp_get_current_user();
        $post_author_name = $post_login_data->ID;
        $pages_filter_dropdown_id = $_POST['pages_filter_dropdown'];
        $pagination_filter_id = $_POST['short_name'];


        $result_sql = "SELECT posts.* , " . $user_data . ".user_login AS user_name,
            " . $clone_table_name . ".created_at AS created_at,
            " . $clone_table_name . ".clonename AS clonename
            FROM " . $table_name . " as posts
            LEFT JOIN " . $meta_table_name . " ON " . $meta_table_name . ".post_id = posts.ID
            LEFT JOIN " . $user_data . " ON " . $user_data . ".ID = posts.post_author
            LEFT JOIN ".$clone_table_name." ON FIND_IN_SET(posts.ID, ".$clone_table_name.".page_insert_id)";
        // LEFT JOIN " . $clone_table_name . " ON " . $clone_table_name . ".page_insert_id = posts.ID
        $result_sql .= " WHERE $meta_table_name.meta_value = 1
                             AND  $meta_table_name.meta_key = 'my_clone_meta_key'
                             AND  posts.post_status != 'trash'";
        // -------------------------------------------------------------------------------------------------------------
        if ($pages_filter_dropdown_id != '' && $pages_filter_dropdown_id != null) {
            $result_sql .=  " AND posts.ID IN ($pages_filter_dropdown_id)";
        }
        // -------------------------------------------------------------------------------------------------------------
        if ($pagination_filter_id != '' && $pagination_filter_id != null) {
            $result_sql .=  " AND ((posts.post_title LIKE '$pagination_filter_id%')
                                  OR  (posts.post_title LIKE '" . ucfirst($pagination_filter_id) . "%'))";
        }
        //---------------------------------------------------------------------------------------------------------------

        if (isset($requestData['search']['value']) && $requestData['search']['value'] != '') {
            $search = $requestData['search']['value'];
            $result_sql .= " AND((posts.post_title LIKE '%" . $search . "%')
                                 OR(" . $user_data . ".user_login LIKE '%" . $search . "%')
                                 OR (posts.post_date LIKE '%" . $search . "%')
                                 OR ( " . $clone_table_name . ".clonename LIKE '%" . $search . "%')
                                 OR (posts.post_status LIKE '%" . $search . "%'))";
        }
        $columns = array(
            0 => 'posts.id',
            1 => 'posts.id',
            2 => 'posts.post_title',
            3 => 'posts.post_status',
            4 => 'posts.user_name',
            5 => 'clone.clonename',
            6 => 'posts.post_date'
        );

        if (isset($requestData['order'][0]['column']) && $requestData['order'][0]['column'] != '') {
            $order_by = $columns[$requestData['order'][0]['column']];
            $result_sql .= " ORDER BY " . $order_by;
        } else {
            $result_sql .= " ORDER BY posts.id DESC";
        }

        if (isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] != '') {
            $result_sql .= " " . $requestData['order'][0]['dir'];
        } else {
            $result_sql .= " DESC ";
        }

        $result = $wpdb->get_results($result_sql, OBJECT);

        $totalData = 0;
        $totalFiltered = 0;
        if (count($result) > 0) {
            $totalData = count($result);
            $totalFiltered = count($result);
        }

        // This is for pagination
        if (isset($requestData['start']) && $requestData['start'] != '' && isset($requestData['length']) && $requestData['length'] != '') {
            $result_sql .= " LIMIT " . $requestData['start'] . "," . $requestData['length'];
        }

        $list_data = $wpdb->get_results($result_sql, "OBJECT");
        $arr_data = array();
        $arr_data = $result;

        $count = 1;
        foreach ($list_data as $row) {
            //$temp['select_all'] = "<input type='hidden' value='".$row->ID."'>";
            $temp['select_all'] = $row->ID;
            $temp['id'] = $count;
            $temp['clonepagename'] = $row->post_title;
            if (strtolower($row->post_status) == 'publish') {
                $row->post_status = "Published";
            }
            $temp['pagestatus'] = ucfirst($row->post_status);
            $temp['author_name'] = $row->user_name;
            $temp['clone_name'] = $row->clonename;
            $temp['datetime'] = $row->post_date != '' ? date('d-m-Y h:i', strtotime($row->post_date)) : '';

            $delete = "<button  class='btn btn-danger btn-sm' onclick='clone_page_delete(" . $row->ID . ")'><i class='fa fa-trash' aria-hidden='true'></i></button>";
            $temp['delete'] = $delete;

            if ($row->post_status == "draft") {
                $status_change = 'Status Change to publish';
            } else {
                $status_change = 'Status Change to Draft';
            }
            $switch_status = '';

            if (strtolower($row->post_status) == "published") {
                $switch_status = 'checked';
            }
            $temp['update_status'] = '<div class="custom-control custom-switch">
                               <input type="checkbox" class="custom-control-input statusswitch"  data-toggle="tooltip" 
                               data-placement="top" title="' . $status_change . '" ' . $switch_status . ' data-id="' . $row->ID . '" id="update_status' . $count . '">
                               <label class="custom-control-label" for="update_status' . $count . '"></label>
                               </div>';
            // $temp['select_all'] = '<input type="checkbox"  class="select_all_chacked" name="select_all_chacked[]" value="'. $row->ID .'">';
            $data[] = $temp;

            $count++;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "sql" => $result_sql
        );

        echo json_encode($json_data);
        exit();
    }


    function delete_clone_pages_record()
    {
        global $wpdb;
        $result['status'] = 0;
        $result['msg'] = "Error Not page delete";
        $deleteId = $_POST['id'];
        $table_name = $wpdb->prefix . "posts";

        $delete_sql = $wpdb->delete($table_name, array('id' => $deleteId));
        if ($delete_sql) {
            $result['status'] = 1;
            $result['msg'] = "Your record has been deleted.";
        }
        echo json_encode($result);
        exit();
    }
    function change_post_status()
    {
        $status = $_POST['status'];
        if ($status == 0) {
            $update_post_status = array(
                'post_type' => 'page',
                'ID' => $_POST['id'],
                'post_status' => 'draft'
            );
        } else {
            $update_post_status = array(
                'post_type' => 'page',
                'ID' => $_POST['id'],
                'post_status' => 'publish'
            );
        }
        $status_changed = wp_update_post($update_post_status);
    }

    function delete_selected_pages_record()
    {
        global $wpdb;
        $result['status'] = 0;
        $result['msg'] = "Error page not delete";
        $delete_Id = $_POST['del_id'];
        
        $str_deleteId = implode(",", $delete_Id);        
        $table_name = $wpdb->prefix . "posts";
        $clone_table_name = $wpdb->prefix . "clone";

        if ($str_deleteId != '') {
            $delete_sql = $wpdb->get_results("DELETE FROM " . $table_name . " WHERE " . $table_name . ".ID IN($str_deleteId)");
            $delete_clonename_sql = $wpdb->get_results("DELETE FROM " . $clone_table_name . " WHERE " . $clone_table_name . ".page_insert_id IN($str_deleteId)");
            $result['status'] = 1;
            $result['msg'] = "Your record has been deleted.";
        }

        echo json_encode($result);
        exit();
    }

    function change_selected_post_status()
    {
        $result['status'] = 0;
        $result['msg'] = " Error post status not change";
        $status = $_POST['status'];
        $update_id = $_POST['id'];

        $str_deleteId = implode(",", $update_id);
        $on1 = ["on,", ",on", "on"];
        $on2   = ["", "", ""];

        $update_status_Id = str_replace($on1, $on2, $str_deleteId);
        $update_status_Id_array = explode(",", $update_status_Id);
        if ($update_status_Id_array != '') {
            foreach ($update_status_Id_array as $update_select_status) {
                if ($status == 0) {
                    $update_post_status = array(
                        'post_type' => 'page',
                        'ID' => $update_select_status,
                        'post_status' => 'draft'
                    );
                $result['msg'] = "All post set as Draft sucessfully";
                } else {
                    $update_post_status = array(
                        'post_type' => 'page',
                        'ID' => $update_select_status,
                        'post_status' => 'publish'
                    );
                $result['msg'] = "All post set as Published sucessfully";
                }
                wp_update_post($update_post_status);
            }
            $result['status'] = 1;
        }

        echo json_encode($result);
        exit();
    }
}

$clone_controller = new Controller();
add_action('wp_ajax_Controller::insert_clone', array($clone_controller, 'insert_clone'));
add_action('wp_ajax_Controller::loaddata_Datatable', array($clone_controller, 'loaddata_Datatable'));
add_action('wp_ajax_Controller::delete_record', array($clone_controller, 'delete_record'));
add_action('wp_ajax_Controller::change_page_status', array($clone_controller, 'change_page_status'));
add_action('wp_ajax_Controller::page_click_id_open', array($clone_controller, 'page_click_id_open_url'));
add_action('wp_ajax_Controller::search_seo_in_form', array($clone_controller, 'search_seo_in_form'));

add_action('wp_ajax_Controller::load_clone_pages_Datatable', array($clone_controller, 'load_clone_pages_Datatable'));
add_action('wp_ajax_Controller::delete_clone_pages_record', array($clone_controller, 'delete_clone_pages_record'));
add_action('wp_ajax_Controller::change_post_status', array($clone_controller, 'change_post_status'));
add_action('wp_ajax_Controller::delete_selected_pages_record', array($clone_controller, 'delete_selected_pages_record'));
add_action('wp_ajax_Controller::change_selected_post_status', array($clone_controller, 'change_selected_post_status'));


    // add_action('wp_ajax_Controller::edit_record', Array($clone_controller, 'edit_record'));