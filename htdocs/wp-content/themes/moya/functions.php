<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images, 
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bones.php
    - head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
    - custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once('library/bones.php'); // if you remove this, bones will break
/*
2. library/custom-post-project.php
*/
require_once('library/custom-post-project.php'); // if you remove this projects will break
/*
3. library/admin.php
    - removing some default WordPress dashboard widgets
    - an example custom dashboard widget
    - adding custom login css
    - changing text in footer of admin
*/
//require_once('library/admin.php'); // this comes turned off by default
/*
4. library/translation/translation.php
    - adding support for other languages
*/
// require_once('library/translation/translation.php'); // this comes turned off by default
/*
5. library/includes/constants.php
    - adding neccesary constants for the particular project setup by Fishgate
*/
require_once('library/includes/constants.php');

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'thumb-700', 700, null, false );


/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
    register_sidebar(array(
    	'id' => 'sidebar1',
    	'name' => __('Sidebar 1', 'bonestheme'),
    	'description' => __('The first (primary) sidebar.', 'bonestheme'),
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
    
    /* 
    to add more sidebars or widgetized areas, just copy
    and edit the above sidebar code. In order to call 
    your new sidebar just use the following code:
    
    Just change the name to whatever your new
    sidebar's id is, for example:
    
    register_sidebar(array(
    	'id' => 'sidebar2',
    	'name' => __('Sidebar 2', 'bonestheme'),
    	'description' => __('The second (secondary) sidebar.', 'bonestheme'),
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
    
    To call the sidebar in your template, you can just copy
    the sidebar.php file and rename it to your sidebar's name.
    So using the above example, it would be:
    sidebar-sidebar2.php
    
    */
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/
		
// Comment Layout
function bones_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
			    <?php 
			    /*
			        this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
			        echo get_avatar($comment,$size='32',$default='<path_to_url>' );
			    */ 
			    ?>
			    <!-- custom gravatar call -->
			    <?php
			    	// create variable
			    	$bgauthemail = get_comment_author_email();
			    ?>
			    <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
			    <!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>', 'bonestheme'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'bonestheme')); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'bonestheme'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
       			<div class="alert info">
          			<p><?php _e('Your comment is awaiting moderation.', 'bonestheme') ?></p>
          		</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
    <!-- </li> is added by WordPress automatically -->
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __('Search for:', 'bonestheme') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','bonestheme').'" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </form>';
    return $form;
}

/************ FISHGATE FUNCTIONS *****************/

function get_work($post_type, $numberposts, $category, $offset){
    $work_posts = get_posts(array( 
        'post_type' => $post_type, //'custom_projects'
        'numberposts' => $numberposts, 
        'offset' => $offset,
        'category' => $category
    ));

    foreach($work_posts as $work){ ?>
        
            <div class='isotope-me'>
                    <div class="preview left" data-id="<?php echo $work->ID; ?>">
                        <div class="preview_title"><?php echo $work->post_title; ?></div><!-- POST TITLE -->
                            <div class="pointer dim">
                                <div class="loader hidden"><img src="<?php echo get_template_directory_uri(); ?>/library/images/10.gif" alt="loading..." /></div>
                                <?php if( has_post_thumbnail($work->ID) ){ ?>
                                <img class="preview_img" src="<?php $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id($work->ID), 'thumb-700' ); echo $thumb_url[0]; ?>" /><!-- FEATURE IMAGE DESKTOP-->
                                <?php }else{ ?>
                                <img class="preview_img" src="<?php echo get_template_directory_uri()."/library/images/moya_placeholder.png"; ?>" /><!-- FEATURE IMAGE DESKTOP-->
                                <?php } ?>
                            </div>
                        <div class="excerpt"><?php echo $work->post_excerpt ?></div>
                    </div>
            </div>
            <?php 
    }
} //get_work() close

function get_total_posts_num($post_type, $category){
    $fetched_posts = get_posts(array( 
        'post_type' => $post_type,
        'numberposts' => -1, //all
        'category' => $category
    ));
    
    return count($fetched_posts);
} //get_total_posts_num() close

function get_single_project( $post_id ){ 
    $work = wp_get_single_post( $post_id ); ?>
    
    <div class="the_project left" data-id="<?php echo $post_id ?>">
        <div class="project_title"><?php echo $work->post_title; ?></div><!-- POST TITLE -->
        <?php if( get_field('embed_code', $work->ID) ){ ?> <div class='flex-video'> <?php echo get_field('embed_code', $work->ID); ?> </div><!-- YOUTUBE EMBED --> <?php } ?>
        <p><?php echo apply_filters('the_content', $work->post_content); ?></p><!-- THE_CONTENT(); -->
    </div>
    
<?php } //get_single_project() close

?>