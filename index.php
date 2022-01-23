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
    echo
    //'<link rel="canonical" href="'.home_url(add_query_arg(array(),$wp->request)).'">'
	'<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'" />'
	.'<link rel="shortcut icon" href="images/favicon.ico" />'
	// tell devices wich screen size to use by default
	.'<meta name="viewport" content="initial-scale=1.0, width=device-width" />'
	.'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">'
    
    .'<meta name="robots" content="index,follow">'."\r\n"
    
    .'<title>' . get_the_title() . ' | RE-Source - design research - online platform - living archive - REsource event 2018 - 2019</title>'."\r\n"
    .'<meta name="description" content="RE-Source 2019 event '.get_bloginfo( 'description' ).'">'."\r\n"
    .'<meta name="author" content="RE-source">'."\r\n"
    .'<meta name="keywords" content="re-source, design, research, circular, map, source, reststromen, urban, resource, re-cycle, ontwerp, design award, ontwerpen, residual, reflect, strategy, empatic, field, mapping, ontwerppraktijk, resource-platform, platform, material, practice, process, re-activate, re-design, redesign, betonstraatsteen, grond en slib, gras, betonstraatstenen, plantmateriaal, slib, straatmeubilair, bank, reststroom, Ester van de Wiel, Joost Adriaanse, David Hamers, Thom Bindels, Jos Klarenbeek, Paul Slot, Simone Post, Manon van Hoeckel, Ginette Verstraete, info, theory, praktijk, flow, reframe, re-frame, onderzoeksproject, education, Biotopische slibfabriek, papierbeheer, groene intocht, publiek depot, tijdsteen, steentijd, stadshovenier, dutch design award, dutch design, dda, re-duce, re-manufacture, re-order, re-pair, re-purpose, re-shape, re-tell, recycle, ontwerpers, We-Are-Amp, Tim Heijmans, Moniek Ellen, Oddsized, Webdesign Den Haag, Carl Muller, Design Academy Eindhoven, lectoraat Places and Traces, Vrije Universiteit Amsterdam, Design Cultures, Faculty of Humanities, Gemeente Rotterdam, NWO, NWO+SIA smart culture">'."\r\n";
        
    // more info for og api's
    echo '<meta property="og:title" content="' . get_the_title() . '"/>'
        .'<meta property="og:type" content="website"/>'
		.'<meta property="og:url" content="' . get_permalink() . '"/>'
		.'<meta property="og:site_name" content="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'"/>'
		.'<meta property="og:description" content="'.get_bloginfo( 'description' ).'"/>';
    $default_image = 'https://avatars3.githubusercontent.com/u/36711733?s=400&u=222c42bbcb09f7639b152cabbe1091b640e78ff2&v=4';
    if( !has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
        if( !empty($header_image) ){
            $default_image = get_header_image();
        }else{
            $default_image = get_theme_mod( 'wp_main_theme_identity_logo', $default_image );
        }
    }else{
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
        $default_image = esc_attr( $thumbnail_src[0] );
    }
    echo '<meta property="og:image" content="' . $default_image . '"/>';

    // include wp head
    wp_head();

    // https://css-tricks.com/perfect-full-page-background-image/
    $bgposition = get_theme_mod('background_position', 'bottom center');
    $bgattacht = get_theme_mod('background_attachment', 'fixed');
    $bgrepeat = get_theme_mod('background_repeat', 'no-repeat');
    $bgsize = get_theme_mod('background_size', 'cover');
    $headerbgstyle = ' style="background-image:url('.esc_url( get_background_image() ).');background-position:'.$bgposition.';background-attachment:'.$bgattacht.';background-size:'.$bgsize.';background-repeat:'.$bgrepeat.';"';

echo '</head>';
echo '<body '.$headerbgstyle.' '; body_class(); echo '>';
?>
    <div id="pagecontainer" class="site">
        <div id="topcontent">
            <div class="outerspace">
            <?php
            wp_main_theme_toplogo_html();
            wp_main_theme_menu_html( 'top' , true  );
            wp_main_theme_widgetarea_html( 'widgets-top-sidebar' );
            ?>
            </div>
        </div>
        <div id="maincontent">
            <div class="outerspace">

                <?php
                if( is_customize_preview() ){
                    echo '<div id="area-main-menu" class="customizer-placeholder">Main menu</div>';
                }
                wp_main_theme_menu_html( array( 'main' ) );
                ?>

                <div id="maincontentbar">
                    <?php
                    if( is_customize_preview() ){
                        echo '<div id="area-page-main-content" class="customizer-placeholder">Page main content</div>';
                    }
                    
                    if(!is_single() && !is_page()){
                        next_posts_link( '&larr; Older posts', $wp_query ->max_num_pages);
                        echo " - ";
                        previous_posts_link( 'Newer posts &rarr;' ); 
                    }
                    
                    wp_main_theme_loop_html();
                    
                    if(!is_single() && !is_page()){
                        next_posts_link( '&larr; Older posts', $wp_query ->max_num_pages);
                        echo " - ";
                        previous_posts_link( 'Newer posts &rarr;' ); 
                    }
                    ?>
                </div>
                <div id="mainsidebar">
                    <?php
                    if( is_customize_preview() ){
                        echo '<div id="area-side-menu" class="customizer-placeholder">Side menu</div>';
                    }
                    wp_main_theme_menu_html( 'side' );

                    wp_main_theme_widgetarea_html( 'sidebar' );

                    ?>
                </div>
                <div class="clr"></div>

            </div>
        </div>
        <div id="bottomcontent">
            <div class="outerspace">
            <?php
            if( is_customize_preview() ){
                echo '<div id="area-bottom-menu" class="customizer-placeholder">Bottom menu</div>';
            }
            wp_main_theme_menu_html( 'bottom' );

            wp_main_theme_widgetarea_html( 'widgets-bottom-sidebar' );
            ?>
            </div>
        </div>
    </div>
    

    
<?php
    wp_footer();
    ?>
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-3063830-64"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-3063830-64');
    </script> 
    <script>
    
    jQuery(function($) { 
        var taglist = $('.post-content').data('tags');
        //setTimeout(function(){
            var url = 'http://www.re-source.info';
            if( taglist && taglist != '' ){
                var url = 'https://www.re-source.info#tags='+taglist;
            }
            window.location = url;
        //},200);   
    });
    </script>
    
    <?php
    
    /* redirect to homepage
    $delay = 3; //seconds 
    sleep($delay); 
    header("Location: http://www.re-source.info"); 
    */
    echo '</body></html>';
?>


