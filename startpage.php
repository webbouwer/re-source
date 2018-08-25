<?php
/**
 * Template Name: Start Page
 * Theme custom start file
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
	.'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
    // more info for og api's
    echo '<meta property="og:title" content="' . get_the_title() . '"/>'
        .'<meta property="og:type" content="website"/>'
		.'<meta property="og:url" content="' . get_permalink() . '"/>'
		.'<meta property="og:site_name" content="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'"/>'
		.'<meta property="og:description" content="'.get_bloginfo( 'description' ).'"/>';
        if( !has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
            if( !empty($header_image) ){
                $default_image = get_theme_mod( 'wp_main_theme_identity_logo', get_header_image() );
                echo '<meta property="og:image" content="' . $default_image . '"/>';
            }
		}else{
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
			echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
		}
    // include wp head
    wp_head();

    // https://css-tricks.com/perfect-full-page-background-image/
    $bgposition = get_theme_mod('background_position', 'bottom center');
    $bgattacht = get_theme_mod('background_attachment', 'fixed');
    $bgrepeat = get_theme_mod('background_repeat', 'no-repeat');
    $bgsize = get_theme_mod('background_size', 'cover');
    $headerbgstyle = ' style="background-image:url('.esc_url( get_background_image() ).');background-position:'.$bgposition.';background-attachment:'.$bgattacht.';background-size:'.$bgsize.';background-repeat:'.$bgrepeat.';"';

    $stylesheet = get_template_directory_uri().'/start.css';
    echo '<link rel="stylesheet" id="wp-theme-custom-style"  href="'.$stylesheet.'" type="text/css" media="all" />';
    ?>

    <script>
    jQuery(function($) {

        $(document).ready(function(){
            /*
            console.log( JSON.parse( site_data['customdata'] ) );
            console.log( JSON.parse( site_data['postdata'] ) );
            console.log( JSON.parse( site_data['tagdata'] ) );
            console.log( JSON.parse( site_data['catdata'] ) );
            */
        });

        $(window).load(function() {

           var markupHTMLContent = function(result){

                $('#leftmenucontainer .contentbox, #maincontentcontainer .contentbox, #rightcontentcontainer .contentbox').html('');

                var htmllist = '', oc = 0;
                $.each( result, function(idx,obj){

                        var html = '';
                        var display_tags = gethtmlListTags( obj.tags );
                        var display_cats = gethtmlListCats( obj.cats );

                        var objfilterclasses = '';
                        $(obj.tags).each(function( x , tag ){
                            objfilterclasses += ' '+tag;
                        });
                        var itemsort = 0;
                        $(obj.cats).each(function( x , cat ){
                            if( cat == 'uncategorized' ){
                                itemsort = 1;
                                 objfilterclasses += ' menubutton';
                            }
                            if( cat == 'examples-1' ){
                                itemsort = 2;
                                 objfilterclasses += ' overviewcontent';
                            }
                            objfilterclasses += ' '+cat;
                        });
                        var catreverse = obj.cats.reverse();
                        if(oc = 0){
                            objfilterclasses += ' base';
                        }

                        html += '<div id="post-'+obj.id+'" data-id="'+obj.id+'" ';
                        html += 'class="item '+objfilterclasses+'" ';
                        html += 'data-author="'+obj.author+'" data-timestamp="'+obj.timestamp+'" ';
                        html += 'data-tags="'+obj.tags+'" data-cats="'+obj.cats+'" data-category="'+catreverse[0]+'" data-matchweight="0">';

                        html += '<div class="matchweight moderate">0</div>';

                        html += '<div class="itemcontent">';

                        html += '<div class="intro">';
                        html += '<div class="title"><h3>'+obj.title+'</h3><div class="author">'+obj.author+'</div></div>';
                        if(obj.image && obj.image != ''){
                            html += '<div class="coverimage">'+obj.image+'</div>';
                        }else{
                            html += '<div class="mediaplaceholder"><h3>'+obj.title+'</h3>Media placeholder</div>';
                        }
                        //html += '<div class="excerpt">'+obj.excerpt+'</div>';
                        html += '<div class="itemcatbox">'+display_cats+'</div>';
                        html += '<div class="itemtagbox">'+display_tags+'</div>';

                        html += '</div>';

                        html += '<div class="main"><div class="textbox"></div></div>'; //'+obj.content+'

                        html += '</div>';
                        html += '<div class="infotoggle button"><span>+</span></div>';
                        html += '</div>';
                        oc++;

                        htmllist += html;

                        if( itemsort == 1 ){
                            $('#leftmenucontainer .contentbox').append( html );
                        }else if( itemsort == 2 ){
                            $('#maincontentcontainer .contentbox').append( html );
                        }else{
                            $('#rightcontentcontainer .contentbox').append( html );
                        }
                });

            };

            // display clickable tags
            var gethtmlListTags = function( itemtags ){
                var tags = JSON.parse(site_data['tagdata']);
                //console.log(tags);
                var html = '';
                for(i=0;i<tags.length;i++){
                    for(t=0;t<itemtags.length;t++){
                        if( tags[i]['name'] == itemtags[t] ){
                            html += '<a href="#tags='+tags[i]['slug']+'" class="tagbutton '+tags[i]['slug']+'" data-tag="'+tags[i]['slug']+'">'+tags[i]['name']+'</a> ';
                        }
                    }
                }
                return html;
            };

            // display clickable categories
            var gethtmlListCats = function( itemcats ){
                var cats = JSON.parse(site_data['catdata']);
                //console.log(cats);
                var html = '';
                for(i=0;i<cats.length;i++){

                    for(t=0;t<itemcats.length;t++){
                        if( cats[i]['slug'] == itemcats[t] ){
                            html += '<a href="#cats='+cats[i]['slug']+'" class="catbutton '+cats[i]['slug']+'" data-cats="'+cats[i]['slug']+'">'+cats[i]['cat_name']+'</a> ';
                        }
                    }
                }
                return html;
            };


            if( site_data['postdata'].length > 0 ){
                markupHTMLContent( JSON.parse(site_data['postdata']) );
            }

            // display tag menu
            var markupHTMLTagMenu = function( tags ){
                var html = '';
                for(i=0;i<tags.length;i++){
                    html += '<a href="#tags='+tags[i]['slug']+'" class="tagbutton '+tags[i]['slug']+'" data-tag="'+tags[i]['slug']+'">'+tags[i]['name']+'</a> ';
                }
                $('#rightmenucontainer .contentbox').html( html );
            };
            if( site_data['tagdata'].length > 0 ){
                markupHTMLTagMenu( JSON.parse(site_data['tagdata']) );
            }

            // click event left menubutton
            var setLeftContent = function( el ){
                var content = el.clone();
                $('#leftcontentcontainer .contentbox').html( content.removeClass('menubutton') );
            }

            $('body').addClass('overview');
            //$('body').addClass('theory');
            //$('body').addClass('practice');

            //$('body').addClass('articlemenu');
            //$('body').addClass('filtermenu');

            $('#leftmenucontainer .togglebox').on( 'click', function(){
                $('body').toggleClass('articlemenu');
            });
            $('#rightmenuplaceholder .togglebox').on( 'click', function(){
                $('body').toggleClass('filtermenu');
            });

            $('#rightmenucontainer .tagbutton').on( 'click', function(){
                $('body').removeClass('overview');
                $('body').removeClass('theory');
                $('body').addClass('practice');
            });
            $('#leftmenucontainer .menubutton').on( 'click', function(){
                $('body').removeClass( 'overview' );
                $('body').removeClass( 'practice' );
                $('body').addClass('theory');
                setLeftContent( $(this) );
            });
        });

        $(document).ajaxStart(function() {
        });

        $(document).ajaxComplete(function() { // http://api.jquery.com/ajaxstop/

        });

    });
    </script>

    <?php
    echo '</head>';
    echo '<body '.$headerbgstyle.' '; body_class(); echo '>';
    ?>
    <div id="pagecontainer" class="site">

        <div id="topcontentcontainer">
            <div id="topcontentbox">
                <div id="topbar">
                    menubutton | logo | searchbar
                </div>
                <div id="topcontent">
                    <div id="infomenu">
                        info menu
                    </div>
                    <div id="infocontent">
                        info content
                    </div>
                </div>
            </div>
        </div>
        <div id="leftmenuplaceholder">
        </div>
        <div id="leftmenucontainer">
            <div class="togglebox"><h4>Artikelen</h4></div>
            <div class="contentbox">Artikel menu</div>
        </div>
        <div id="leftcontentcontainer">
            <div class="topplaceholder"></div>
            <div class="contentbox">Artikel content</div>
        </div>

        <div id="maincontentcontainer">
            <div class="topplaceholder"></div>
            <div class="contentbox">Overview content</div>
        </div>

        <div id="rightcontentcontainer">
            <div class="topplaceholder"></div>
            <div class="contentbox">Label content</div>
        </div>
        <div id="rightmenucontainer">
            <div class="topplaceholder"></div>
            <div class="contentbox">Label menu</div>
        </div>
        <div id="rightmenuplaceholder">
            <div class="togglebox"><h4>Labels</h4></div>
        </div>
    <?php
    /* default pageframe elements not to use or overwrite:
    #topcontent, .outerspace, #maincontent, #maincontentbar, #mainsidebar, #bottomcontent
    */
    /*
    wp_main_theme_toplogo_html();
    wp_main_theme_menu_html( 'top' , true  );
    wp_main_theme_widgetarea_html( 'widgets-top-sidebar' );
    if( is_customize_preview() ){
        echo '<div id="area-main-menu" class="customizer-placeholder">Main menu</div>';
    }
    wp_main_theme_menu_html( array( 'main' ) );
    if( is_customize_preview() ){
        echo '<div id="area-page-main-content" class="customizer-placeholder">Page main content</div>';
    }
    wp_main_theme_loop_html();
    if( is_customize_preview() ){
        echo '<div id="area-side-menu" class="customizer-placeholder">Side menu</div>';
    }
    wp_main_theme_menu_html( 'side' );
    wp_main_theme_widgetarea_html( 'sidebar' );
    if( is_customize_preview() ){
        echo '<div id="area-bottom-menu" class="customizer-placeholder">Bottom menu</div>';
    }
    wp_main_theme_menu_html( 'bottom' );
    wp_main_theme_widgetarea_html( 'widgets-bottom-sidebar' );
    */

    wp_footer();

    echo '</body></html>';
?>


