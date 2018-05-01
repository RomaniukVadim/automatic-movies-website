<?php
class td_more_article_box {


    static function on_wp_footer_render_box() {
        global $post;
        /**
        * More articles on post page
        */

        if(is_single() and td_util::get_option('tds_more_articles_on_post_pages_enable') == 'show') {

            //if to run the query
            $td_run_query = false;

            //current post ID
            $td_this_post_id = 0;

            //holds the tags for this post
            $td_get_post_tags = '';
            $td_post_tags = array();

            //primary category
            $primary_category = 0;

            //get the $post->ID
            if(!empty($post->ID) and intval($post->ID) > 0) {
                $td_this_post_id = intval($post->ID);
            }


            //create $args array  //'orderby' => 'date', 'order' => 'DESC' - this is the default for WP_Query
            switch(td_util::get_option('tds_more_articles_on_post_pages_display')){
                //Same Tag
                case 'same_tag':
                    if($td_this_post_id > 0) {
                        $td_get_post_tags = get_the_tags($td_this_post_id);

                        //itinerate to get the tags ids
                        if(!empty($td_get_post_tags)){
                            foreach($td_get_post_tags as $td_object_tag){
                                $td_post_tags[] = $td_object_tag->term_id;
                            }
                        }

                        //if we have some tags
                        if(!empty($td_post_tags) and count($td_post_tags) > 0) {
                            $args = array('tag__in' => $td_post_tags, 'orderby' => 'rand');
                            $td_run_query = true;
                        }
                    }
                    break;

                //Same Author
                case 'same_author':
                    if(!empty($post->post_author) and intval($post->post_author) > 0) {
                        $args = array('author' => intval($post->post_author), 'orderby' => 'rand');
                        $td_run_query = true;
                    }
                    break;

                //Random
                case 'random':
                    $args = array ( 'orderby' => 'rand');
                    $td_run_query = true;
                    break;

                //Same Category
                case 'same_category':
                    $primary_category = intval(td_global::get_primary_category_id());
                    if($primary_category > 0) {
                        $args = array('cat' => $primary_category, 'orderby' => 'rand');
                        $td_run_query = true;
                    }
                    break;

                //Latest Article
                default:
                    $args = array('orderby' => 'date', 'order' => 'DESC');
                    $td_run_query = true;
                    break;
            }

            //if to run the query
            if($td_run_query === true) {
                //add number of post to $args
                $td_nr_of_posts= intval(td_util::get_option('tds_more_articles_on_post_pages_number'));
                if($td_nr_of_posts > 0) {
                    $args['posts_per_page'] = $td_nr_of_posts;
                } else {
                    $args['posts_per_page'] = 1;
                }

                if($td_this_post_id > 0) {
                    $args['post__not_in'] = array( $td_this_post_id );
                }

                $args['ignore_sticky_posts'] = 1;

                //creating a new wp_query object foar our query
                $td_query_more_article = new WP_Query($args);
            }

            //add o post pages the more stories box
            if(!empty($td_query_more_article->posts)) {?>
                <div class="td-more-articles-box">
                    <i class="td-icon-close td-close-more-articles-box"></i>
                    <span class="td-more-articles-box-title"><?php echo __td('MORE STORIES', TD_THEME_NAME) ?></span>
                    <div class="td-content-more-articles-box">

                    <?php
                    $td_display_module = intval(td_util::get_option('tds_more_articles_on_post_pages_display_module'));
                    //itinerate thru the resultset and display resuts
                    foreach($td_query_more_article->posts as $each_post) {
                        switch($td_display_module) {
                            //module 2
                            case 2:
                                $td_mod = new td_module_2($each_post);
                                echo $td_mod->render();
                                break;

                            //module 3
                            case 3:
                                $td_mod = new td_module_3($each_post);
                                echo $td_mod->render();
                                break;

                            //module 4
                            case 4:
                                $td_mod = new td_module_4($each_post);
                                echo $td_mod->render();
                                break;

                            //module 5
                            case 5:
                                $td_mod = new td_module_5($each_post);
                                echo $td_mod->render();
                                break;

                            //module 6
                            case 6:
                                $td_mod = new td_module_6($each_post);
                                echo $td_mod->render();
                                break;

                            //module 7
                            case 7:
                                $td_mod = new td_module_7($each_post);
                                echo $td_mod->render();
                                break;

                            //module 8
                            case 8:
                                $td_mod = new td_module_8($each_post);
                                echo $td_mod->render();
                                break;

                            //module 9
                            case 9:
                                $td_mod = new td_module_9($each_post);
                                echo $td_mod->render();
                                break;

                            default:
                                $td_mod = new td_module_1($each_post);
                                echo $td_mod->render();
                                break;
                        }

                    }?>
                    </div>
                </div><?php
            }//if we have posts
        }//end more articles on post

    }//end function render
}

