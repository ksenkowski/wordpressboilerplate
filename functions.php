<?php
/*
 *  Author: Keith Senkowski | @ksenkowski
 *  URL: https://github.com/ksenkowski/wordpressboilerplate
 */

if (!isset($content_width)){
    $content_width = 900;
}

if (function_exists('add_theme_support')){
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');
    add_theme_support('automatic-feed-links');

}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// Boilerplate navigation
function boilerplate_nav(){
	//Menu Slug
	$menuName = 'main-menu';
	if(($locations = get_nav_menu_locations()) && isset($locations[$menuName])){
		$menu = wp_get_nav_menu_object($locations[$menuName]);
		$menuItems = wp_get_nav_menu_items($menu->term_id);
		
		$menuList .= "\t\t\t\t". '<ul class="menu-items">' ."\n";
		foreach ((array) $menuItems as $key => $menuItem) {
			$title = $menuItem->title;
			$url = $menuItem->url;
			$menuList .= "\t\t\t\t\t". '<li class="menu-item"><a href="'. $url .'">'. $title .'</a></li>' ."\n";
		}
		$menuList .= "\t\t\t\t". '</ul>' ."\n";
	} else {
		// $menu_list = '<!-- no list defined -->';
	}
	echo $menuList;	
}

// Register HTML5 Blank Navigation
function register_boilerplate_menu(){
    register_nav_menus(array( // Using array to specify more menus if needed
        'main-menu' => __('Header Menu', 'boilerplate'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'boilerplate'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'boilerplate') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}
add_action('init', 'register_boilerplate_menu'); // Add HTML5 Blank Menu


// Load cripts (header.php)
function boilerplate_header_scripts(){
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    	wp_register_script('conditionizr', get_template_directory_uri() . '/assets/js/top/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
        wp_enqueue_script('conditionizr'); // Enqueue it!

        wp_register_script('modernizr', get_template_directory_uri() . '/assets/js/top/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        wp_register_script('scripts', get_template_directory_uri() . '/scripts.js', array('jquery'), '1.0.0', $in_footer = true); // Custom scripts
        wp_enqueue_script('scripts'); // Enqueue it!
		
    }
}
add_action('init', 'boilerplate_header_scripts'); 

// Load conditional scripts
function boilerplate_conditional_scripts(){
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}
add_action('wp_print_scripts', 'boilerplate_conditional_scripts'); 

//Move jQuery scripts to the bottom
function jquery_mumbo_jumbo(){
    wp_dequeue_script('jquery');
    wp_dequeue_script('jquery-core');
    wp_dequeue_script('jquery-migrate');
    wp_enqueue_script('jquery', false, array(), false, true);
    wp_enqueue_script('jquery-core', false, array(), false, true);
    wp_enqueue_script('jquery-migrate', false, array(), false, true);
}
add_action('wp_enqueue_scripts', 'jquery_mumbo_jumbo');

// Load styles
function boilerplate_styles(){
    wp_register_style('boilerplate', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('boilerplate'); // Enqueue it!
}
add_action('wp_enqueue_scripts', 'boilerplate_styles'); 


// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = ''){
    $args['container'] = false;
    return $args;
}
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); 


// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist){
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}
add_filter('the_category', 'remove_category_rel_from_category_list'); 

//Social Sharing
function opengraph() {
    global $post;
 
        if(has_post_thumbnail($post->ID)) {
            $img_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'medium');
        } else {
            $img_src = get_stylesheet_directory_uri() . '/assets/img/share.jpg';
        }
		
        if($excerpt = $post->post_excerpt) {
            $excerpt = strip_tags($post->post_excerpt);
            $excerpt = str_replace("", "'", $excerpt);
        } else {
            $excerpt = get_bloginfo('description');
        }
        ?>
    <meta property="og:title" content="<?php echo the_title(); ?>"/>
    <meta property="twitter:title" content="<?php echo the_title(); ?>"/>
    <meta property="og:description" content="<?php echo $excerpt; ?>"/>
	<meta name="twitter:description" content="<?php echo $excerpt; ?>">
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="<?php echo the_permalink(); ?>"/>
    <meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
    <meta property="og:image" content="<?php echo $img_src; ?>"/>
	<meta name="twitter:card" content="<?php echo $img_src; ?>">	
	<meta name="twitter:site" content="@twitter">
	<meta name="twitter:creator" content="@twitter">

 
<?php
 
}
add_action('wp_head', 'opengraph', 5);


// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes){
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }
    return $classes;
}
add_filter('body_class', 'add_slug_to_body_class'); 

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar')){
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'boilerplate'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'boilerplate'),
        'description' => __('Description for this widget-area...', 'boilerplate'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}


// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function boilerplate_pagination(){
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}
add_action('init', 'boilerplate_pagination'); // Add our HTML5 Pagination

// Create 20 Word Callback for Index page Excerpts;
function boilerplate_index($length){
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('boilerplate_custom_post');
function boilerplate_custom_post($length){
    return 40;
}

// Create the Custom Excerpts callback
function boilerplate_excerpt($length_callback = '', $more_callback = ''){
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function boilerplate_blank_view_article($more){
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'boilerplate') . '</a>';
}
add_filter('excerpt_more', 'boilerplate_blank_view_article'); 

// Remove Admin bar
function remove_admin_bar(){
    return false;
}
add_filter('show_admin_bar', 'remove_admin_bar');

// Remove 'text/css' from our enqueued stylesheet
function boilerplate_style_remove($tag){
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}
add_filter('style_loader_tag', 'boilerplate_style_remove');

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html ){
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); 
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); 



/*------------------------------------*\
	Removing Actions
\*------------------------------------*/

// Remove Actions
// Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links_extra', 3); 
// Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'feed_links', 2); 
// Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'rsd_link'); 
// Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'wlwmanifest_link'); 
// Index link
remove_action('wp_head', 'index_rel_link'); 
 // Prev link
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
// Start link
remove_action('wp_head', 'start_post_rel_link', 10, 0); 
// Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); 
// Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'wp_generator'); 
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
// Remove <p> tags in Dynamic Sidebars (better!)
add_filter('widget_text', 'shortcode_unautop'); 
// Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'shortcode_unautop'); 
// Remove Filters
// Remove <p> tags from Excerpt altogether
remove_filter('the_excerpt', 'wpautop'); 

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5(){
    register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'html5-blank');
    register_post_type('html5-blank', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
            'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
            'add_new' => __('Add New', 'html5blank'),
            'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
            'edit' => __('Edit', 'html5blank'),
            'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
            'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
            'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
            'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
            'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
            'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}
add_action('init', 'create_post_type_html5');

?>
