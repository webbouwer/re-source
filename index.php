<?php
/**
 * Theme main index file
 */

require_once('functions.php');
 
// the current page/post data
global $post;

// determine header image
$header_image = get_header_image();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php
    if ( ! isset( $content_width ) ) $content_width = 360; // mobile first
    echo '<link rel="canonical" href="'.home_url(add_query_arg(array(),$wp->request)).'">'
	.'<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'" />'
	.'<link rel="shortcut icon" href="images/favicon.ico" />'
	// tell devices wich screen size to use by default
	.'<meta name="viewport" content="initial-scale=1.0, width=device-width" />'
	.'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
    // more info for og api's
    echo '<meta property="og:title" content="' . get_the_title() . '"/>'
        .'<meta property="og:type" content="website"/>'
		.'<meta property="og:url" content="' . get_permalink() . '"/>'
		.'<meta property="og:site_name" content="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'"/>'
		.'<meta property="og:description" content="'.get_bloginfo( 'description' ).'"/>';
        if( !has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
            if( !empty($header_image) ){
                $default_image = get_theme_mod( 'imagazine_globalshare_defaultimage', get_header_image() );
                echo '<meta property="og:image" content="' . $default_image . '"/>';
            }
		}else{
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
			echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
		}
    // include wp head
    wp_head();
?>
</head>
<body <?php body_class(); ?>>
     <div id="pagecontainer" class="site">
<?php echo 'This the basic template'; ?>
    </div>
<?php wp_footer(); ?>
</body>
</html>
