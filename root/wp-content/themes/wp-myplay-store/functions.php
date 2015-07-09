<?php
/**
 * rgnrtr functions and definitions.
 * rgnrtr only works in WordPress 3.6 or later.
 */
$svgs = array();

if ( ! defined( 'RG_RGNRTR_LOCALE' ) ) {
	define( 'RG_RGNRTR_LOCALE', '' );
}

if ( ! defined( 'debug_mode' ) ) {
	define( 'debug_mode', true );
}


function rg( $arr ) {
	echo "<pre>";
	print_r( $arr );
	echo "</pre>";
}

function rg_rgnrtr_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	register_nav_menus( array(
		'primary'   => __( 'Navigation Menu', 'rg' ),
		'secondary' => __( 'Footer Nav', 'rg' ),
	) );

	add_theme_support( 'post-thumbnails' );
	add_image_size( 'default-thumb', 400, 400, array( 'top', 'center' ) );

	if ( ! is_admin() ) {
		// Load in main theme css (application.css) for non wp-admin pages
		wp_enqueue_style( 'main', get_template_directory_uri() . '/stylesheets/main.css' );
	}
	if (defined('LOCAL_DEV_MODE')) {
		wp_register_script( 'livereload', 'http://localhost:35729/livereload.js?snipver=1', null, false, true );
		wp_enqueue_script( 'livereload' );
	}
    
    add_action( 'body_class', '_rgnrtrIOSClass' );

}

add_action( 'after_setup_theme', 'rg_rgnrtr_setup' );


//include( get_template_directory() . '/inc/rg-m2store/rg-m2-plugin.php' );
require_once( get_template_directory() . '/inc/metaboxes/meta_box.php' );


/////////////////////////////// STORE URL RE-WRITE ///////////////////////////////

//add_filter( 'query_vars', 'rg_add_query_vars_filter' );
//add_filter('rewrite_rules_array', 'rg_add_rewrite_rules');

function rg_add_query_vars_filter( $qvars ) {
	$qvars[] = 'productID';

	return $qvars;
}

function rg_add_rewrite_rules( $aRules ) {
	$aNewRules = array( 'store/product/([0-9]+)/?$' => 'index.php?pagename=store/product&productID=$matches[1]' );
	$aRules    = $aNewRules + $aRules;

	return $aRules;
}

/**
 * SVG mime type.
 */
function _mimeTypes( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', '_mimeTypes' );

/**
 * SVG object class.
 */
class siteSvgs {

	public static $svg_instance;

	public static function _getSVGInstance() {
		if ( null == self::$svg_instance ) {
			self::$svg_instance = new siteSvgs();
		}

		return self::$svg_instance;
	}

	function __construct() {
		self::$svg_instance = $this;
	}

	function _loadSVG( $svg ) {
		if ( ! empty( $svg ) ):
			//$path = 'http://rgen-custom.s3.amazonaws.com/historystore/svg/'.$svg.'.svg';
			$path = get_bloginfo( 'template_directory' ) . '/images/svg/' . $svg . '.svg';
			//return @file_get_contents( $path );
			//return '<object type="image/svg+xml" width="400" height="400" data="'.$path.'" id="'.$svg.'-svg"></object>';
			return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400"><use xlink:href="' . $path . '#' . $svg . '-svg"></use></svg>';
		else:
			return;
		endif;
	}

	public function getSVG( $name ) {
		return $this->_loadSVG( $name );
	}
}

/**
 * Adds / Substract the values of an array.
 */
function _arrayMath( $array ) {
	$total = 0;
	foreach ( $array as $number ) {
		$total = $number - $total;
	}

	return abs( $total );
}

/**
 * Gets the tag slug / name.
 */
function _rgnrtrGetNameSlug( $tags, $tagName = null, $slug = null, $term = null ) {
	if ( ! empty( $tags ) && is_array( $tags ) && $term != null ):
		foreach ( $tags as $tag ):
			if ( strstr( $tag, $term ) !== false ) {
				if ( $tagName == true ) {
					return str_replace( $term, '', $tag );
				}
				if ( $slug == true ) {
					return strtolower( str_replace( ':', '', preg_replace( '/[\s_]/', '-', $tag ) ) );
				}
			}
		endforeach;
	endif;
}

/**
 * Mobile detection.
 */
function _rgnrtrMobile() {
	static $is_mobile;

	if ( isset( $is_mobile ) ) {
		return $is_mobile;
	}

	if ( empty( $_SERVER['HTTP_USER_AGENT'] ) || strpos( $_SERVER['HTTP_USER_AGENT'], 'iPad' ) != false ) {
		$is_mobile = false;
	} elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Android' ) !== false
	           || strpos( $_SERVER['HTTP_USER_AGENT'], 'Silk/' ) !== false
	           || strpos( $_SERVER['HTTP_USER_AGENT'], 'Kindle' ) !== false
	           || strpos( $_SERVER['HTTP_USER_AGENT'], 'BlackBerry' ) !== false
	           || strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mini' ) !== false
	) {
		$is_mobile = true;
	} elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile' ) !== false && strpos( $_SERVER['HTTP_USER_AGENT'], 'iPad' ) == false ) {
		$is_mobile = true;
	} else {
		$is_mobile = false;
	}

	return $is_mobile;
}

/**
 * Adds mobile class.
 */
function _rgnrtrIOSClass( $classes ) {
	if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Mobile' ) !== false
	     || strpos( $_SERVER['HTTP_USER_AGENT'], 'Android' ) !== false
	     || strpos( $_SERVER['HTTP_USER_AGENT'], 'Silk/' ) !== false
	     || strpos( $_SERVER['HTTP_USER_AGENT'], 'Kindle' ) !== false
	     || strpos( $_SERVER['HTTP_USER_AGENT'], 'BlackBerry' ) !== false
	     || strpos( $_SERVER['HTTP_USER_AGENT'], 'Opera Mini' ) !== false
	) {
		$classes[] = 'mobile_ios';
	} elseif ( strpos( $_SERVER['HTTP_USER_AGENT'], 'iPad' ) !== false ) {
		$classes[] = 'mobile_ios_tablet';
	}

	return $classes;
}

/**
 * String replace function.
 */
function _rgnrtrString( $string, $case, $txt = null ) {
	if ( ! empty( $string ) && ! empty( $case ) ):
		switch ( $case ):
			case 'lowercase':
				//Lower case everything
				return strtolower( $string );
				break;
			case 'alphanumeric':
				//Make alphanumeric (removes all other characters)
				return preg_replace( '/[^a-z0-9_\s-]/', '', $string );
				break;
			case 'removetext':
				//Removes specified text
				return str_replace( $txt, '', $string );
				break;
			case 'dashtowhitespace':
				//Clean up multiple dashes or whitespaces
				return preg_replace( '/[\s-]+/', ' ', $string );
				break;
			case 'removedashes':
				//Clean up multiple dashes or whitespaces
				return preg_replace( '/[\s-]+/', '', $string );
				break;
			case 'underscoretodash':
				//Convert whitespaces and underscore to dash
				return preg_replace( '/[\s_]/', '-', $string );
				break;
			default:
				return $string;
				break;
		endswitch;
	endif;
}

/**
 * Adds login logo.
 */
function _rgnrtrLoginLogo() {
	echo '<style type="text/css">
        .login h1 a {
          width: 100px !important;
          height: 100px !important;
          margin: 0 auto;
          background-image:url(' . get_bloginfo( 'template_directory' ) . '/images/rgenerator.png) !important;
          background-size: contain;
        }
    </style>';
}

add_action( 'login_head', '_rgnrtrLoginLogo' );

/**
 * Add site logo to WP admin header bar.
 */
function _rgnrtrAdminBarLogo() {
	global $wp_admin_bar;

	// Remove wp logo admin menu_id
	$wp_admin_bar->remove_menu( 'wp-logo' );
	//add Rgen logo to front
	$wp_admin_bar->add_menu( array(
		'parent' => false, // use 'false' for a root menu, or pass the ID of the parent menu
		'id'     => 'rg_logo', // link ID, defaults to a sanitized title value
		'title'  => '<img style="margin-top:4px;width: 16px;height: 16px;" src="' . get_template_directory_uri() . '/images/wp_menu_icon.png" />',
		'href'   => false,
		'meta'   => false
	) );
}

add_action( 'admin_bar_menu', '_rgnrtrAdminBarLogo', 0 );
add_action( 'wp_before_admin_bar_render', '_rgnrtrAdminBarLogo', 0 );


/////////////////////////////// SEARCH FORM ///////////////////////////////
function _rgnrtrSearchForm( $form ) {
	$form = '
    <div class="label">' . __( 'Start typing to search:' ) . '</div>
    <form role="search" method="get" id="searchform" class="searchform flex" action="' . home_url( '/' ) . '" >
		<input type="text" value="' . get_search_query() . '" name="s" id="s" />
        <div class="submit-btn">
            <label>
                <input type="submit" id="searchsubmit" value="' . esc_attr__( 'Enter' ) . '" />
            </label>
        </div>
	</form>';

	return $form;
}

add_filter( 'get_search_form', '_historySearchForm' );

/**
 * Enqueues scripts and styles for front end.
 */
function rg_scripts_styles() {
	$_svgs = siteSvgs::_getSVGInstance();
	global $svgs;

	// Loads JavaScript file with functionality specific to rgnrtr.
	wp_enqueue_script( 'plugins', get_template_directory_uri() . '/js/plugins.js', array( 'jquery' ), '1.0.1', true );
	wp_enqueue_script( 'rg-script', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), true );
	wp_localize_script( 'rg-scripts', 'localize', array(
		'siteURL'   => site_url(),
		'permalink' => get_bloginfo( 'template_directory' ),
	) );

	//wp_enqueue_style( 'wp-mediaelement' );
	wp_enqueue_style( 'rg-style', get_stylesheet_uri(), array() );
	wp_enqueue_style( 'rg-genericons', get_template_directory_uri() . '/fonts/genericons.css', array(), '3.0.2' );

	wp_style_add_data( 'rg-ie', 'conditional', 'lt IE 9' );
}

add_action( 'wp_enqueue_scripts', 'rg_scripts_styles' );


/**
 * URL Encoder.
 */
function _rgnrtrencodeURIComponent( $str ) {
	$revert = array( '%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')' );

	return strtr( rawurlencode( $str ), $revert );
}


function _rgnrtrGetImageURL( $postID ) {
	$attachment = wp_get_attachment_image_src( get_post_thumbnail_id( $postID ), 'full-size' );

	if ( isset( $attachment ) ) {
		echo $attachment[0];
	} else {
		echo get_template_directory_uri() . '/images/fb_200x200.png';
	}
}


/**
 * The Excerpt.
 */
if ( ! function_exists( '_rgnrtrExcerpt' ) ) :
	function _rgnrtrExcerpt( $limit, $morelink = false, $moretext = 'read more', $striptags = null ) {
		if ( $morelink == true ) {
			$morelink = '<a href="' . esc_url( get_permalink() ) . '" title="' . get_the_title() . '" class="readmore">' . $moretext . '</a>';
		} else {
			$morelink = '...';
		}
		$excerpt = explode( ' ', get_the_excerpt(), $limit );
		if ( count( $excerpt ) >= $limit ) {
			array_pop( $excerpt );
			if ( isset( $striptags ) ):
				$excerpt = implode( " ", $excerpt ) . '...';
			else:
				$excerpt = '<p>' . implode( " ", $excerpt ) . '...</p>' . $morelink;
			endif;
		} else {
			$excerpt = implode( " ", $excerpt ) . '...';
		}
		$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );

		return $excerpt;
	}
endif;


/**
 * Title Limit.
 *
 * _rgnrtrTitle($post->post_title, 25);
 */
if ( ! function_exists( '_rgnrtrTitle' ) ) :
	function _rgnrtrTitle( $title, $limit ) {
		if ( strlen( $title ) > $limit ) {
			$t = substr( the_title( $before = '', $after = '', false ), 0, $limit ) . '...';
		} else {
			$t = get_the_title();
		}

		return $t;
	}
endif;


/**
 * Displays the gallery.
 */
if ( ! function_exists( '_rgnrtrGallery' ) ) :
	function _rgnrtrGallery( $limit, $size = 'full-size', $last_class = 3 ) {
		global $post;
		$regex_pattern = get_shortcode_regex();
		if ( preg_match_all( '/' . $regex_pattern . '/s', $post->post_content, $matches ) && array_key_exists( 2, $matches ) && in_array( 'gallery', $matches[2] ) ):
			$keys = array_keys( $matches[2], 'gallery' );

			foreach ( $keys as $key ):
				$atts = shortcode_parse_atts( $matches[3][ $key ] );
				if ( array_key_exists( 'ids', $atts ) ):

					$attachments = get_children( array(
						'post_parent'    => $post->post_content,
						'post_status'    => 'inherit',
						'post_type'      => 'attachment',
						'post_mime_type' => 'image',
						'post__in'       => explode( ',', $atts['ids'] ),
						'order'          => 'ASC',
						'orderby'        => 'post__in',
						'numberposts'    => $limit
					) );

					if ( $attachments ):
						$last = 0;
						echo '<div class="gallery-block">';
						foreach ( $attachments as $attachment ):
							$img_title    = $attachment->post_title;
							$permalink    = get_permalink( $post->ID );
							$full_img     = wp_get_attachment_image_src( $attachment->ID, 'full-size' );
							$main_img     = wp_get_attachment_image( $attachment->ID, $size );
							$featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );

							if ( $limit == 1 ) {
								echo '<div class="single-gallery-item">';
								if ( $featured_img ) {
									echo '<a href="' . $permalink . '" title="' . $img_title . '" class="gallery-cover"><img src="' . $featured_img[0] . '" /></a>';
								} elseif ( ! $featured_img ) {
									echo '<a href="' . $permalink . '" title="' . $img_title . '" class="gallery-cover">' . $main_img . '</a>';
								}
								echo '</div>';
							} elseif ( $limit === - 1 ) {
								echo '<div class="gallery-item ' . ( ++ $i % $last_class ? "" : "last" ) . '">';
								echo '<a href="' . $full_img[0] . '" rel="gallery" title="' . $img_title . '">' . $main_img . '</a>';
								echo '</div>';
							}
						endforeach;
						echo '</div>';
					endif;
				endif;
			endforeach;
		endif;
	}
endif;


/**
 * Enque fonts from Google Fonts.
 */
function _rgnrtrFonts() {
	$fonts_url = '';

	$open_sans = _x( 'on', 'Open Sans font: on or off', 'rg' );
	$bitter    = _x( 'on', 'Bitter font: on or off', 'rg' );

	if ( 'off' !== $open_sans || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro ) {
			$font_families[] = 'Open+Sans:400,600,700,800,300';
		}

		if ( 'off' !== $bitter ) {
			$font_families[] = 'Bitter:400,700';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url  = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

function _rgnrtrMCECSS( $mce_css ) {
	$font_url = _rgnrtrFonts();
	if ( empty( $font_url ) ) {
		return $mce_css;
	}
	if ( ! empty( $mce_css ) ) {
		$mce_css .= ',';
	}
	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $font_url ) );

	return $mce_css;
}

add_filter( 'mce_css', '_rgnrtrMCECSS' );


/**
 * WP title.
 */
function _rgnrtrWPTitle() {
	global $page, $paged;

	bloginfo( 'name' );
	wp_title( ' ', true );

	$site_description = get_bloginfo( 'description', 'display' );

	if ( wp_title( ' ', false ) ) {
		echo ' | ';
	}

	if ( $site_description && ( is_home() || is_front_page() || bloginfo( 'description' ) ) ) {
		echo " | $site_description";
	}
}

/**
 * Registers the widget areas.
 */
function _rgnrtrWidgetsInit() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'rg' ),
		'id'            => 'sidebar',
		'description'   => __( 'Appears in the footer section of the site.', 'rg' ),
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
}

add_action( 'widgets_init', '_rgnrtrWidgetsInit' );


/**
 * Displays the thumbnail from YouTube & Vimeo videos.
 */
if ( ! function_exists( '_rgnrtrGetVideoImg' ) ):
	function _rgnrtrGetVideoImg( $url, $size = 'hqdefault' ) {
		$image_src = parse_url( $url );

		if ( $image_src['host'] == 'www.vimeo.com' || $image_src['host'] == 'vimeo.com' || $image_src['host'] == 'player.vimeo.com' ) {
			parse_str( $image_src['query'], $query );
			if ( isset( $query['clip_id'] ) && $query['clip_id'] != "" ) {
				$id = $query['clip_id'];
			} else {
				$path = explode( "/", $image_src['path'] );
				$id   = $path[ ( count( $path ) - 1 ) ];
			}
			if ( function_exists( 'curl_init' ) ) {
				;
				$ch = curl_init();
				curl_setopt( $ch, CURLOPT_URL, "http://vimeo.com/api/v2/video/$id.php" );
				curl_setopt( $ch, CURLOPT_HEADER, 0 );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );
				$output = unserialize( curl_exec( $ch ) );
				$output = $output[0]['thumbnail_small'];
				curl_close( $ch );

				return $output;
			}
		} else if ( $image_src['host'] == 'www.youtube.com' || $image_src['host'] == 'youtu.be' ) {
			parse_str( $image_src['query'], $query );
			if ( isset( $query['v'] ) && $query['v'] != "" ) {
				$id = $query['v'];
			} else {
				$path = explode( "/watch?v=", $image_src['path'] );
				$id   = $path[ count( $path ) - 1 ];
			}
			$output = '';
			$output .= 'http://img.youtube.com/vi/' . $id . '/' . $size . '.jpg'; //default, hqdefault, mqdefault, sddefault, maxresdefault

			return $output;
		} else {
			return false;
		}
	}
endif;

/**
 * Displays the video from YouTube or Vimeo.
 */
if ( ! function_exists( '_rgnrtrGetVideo' ) ):
	function _rgnrtrGetVideo( $url ) {
		$url_src = parse_url( $url );
		$expires = 0;

		if ( $url_src['host'] == 'www.vimeo.com' || $url_src['host'] == 'vimeo.com' ) {
			$host = 'http://' . $url_src['host'] . '/api/oembed.json?url=' . $url;

			if ( false === ( $json = get_transient( 'rg_vid_' . $url ) ) ) {
				$json = file_get_contents( $host );
				set_transient( 'rg_vid_' . $url, $json, $expires );
			}
			delete_transient( 'rg_vid_' . $url );
			$data = json_decode( $json, true );

			if ( empty( $data ) ) {
				return;
			} else {
				$output = '<div class="vid vimeo"><h2>' . $data['title'] . '</h2>' . $data['html'] . '</div>';

				return $output;
			}

		} else if ( $url_src['host'] == 'www.youtube.com' || $url_src['host'] == 'youtu.be' ) {
			$host = 'http://' . $url_src['host'] . '/oembed?url=' . $url . '&format=json';

			if ( false === ( $json = get_transient( 'rg_vid_' . $url ) ) ) {
				$json = file_get_contents( $host );
				set_transient( 'rg_vid_' . $url, $json, $expires );
			}
			delete_transient( 'rg_vid_' . $url );
			$data = json_decode( $json, true );

			if ( empty( $data ) ) {
				return;
			} else {
				$output = '<div class="vid youtube"><h2>' . $data['title'] . '</h2>' . $data['html'] . '</div>';

				return $output;
			}
		}

	}
endif;

/**
 * Displays navigation.
 */
if ( ! function_exists( '_rgnrtrPagination' ) ) :
	function _rgnrtrPagination( $pages = '', $range = 1 ) {
		$showitems = ( $range * 2 ) + 1;
		global $paged;
		if ( empty( $paged ) ) {
			$paged = 1;
		}
		if ( $pages == '' ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if ( ! $pages ) {
				$pages = 1;
			}
		}
		if ( 1 != $pages ) {
			echo '<div class=\'pagination block clearfix\'>';
			echo '<div class=\'pages\'>Page ' . $paged . ' of ' . $pages . ' Pages</div>';
			echo '<div class=\'elements\'>';
			echo '<div class=\'first-prev\'>';
			if ( $paged > 1 && $paged > $range ) {
				echo '<a href="' . get_pagenum_link( 1 ) . '">&lsaquo; First</a>';
			} else {
				echo '<span>&lsaquo; First</span>';
			}
			if ( $paged > 1 ) {
				echo '<a href="' . get_pagenum_link( $paged - 1 ) . '" class=\'prev\'>&lsaquo; Previous</a>';
			} else {
				echo '<span class=\'prev\'>&lsaquo; Previous</span>';
			}
			echo '</div>';

			echo '<ul class=\'numbers\'>';
			for ( $i = 1; $i <= $pages; $i ++ ) {
				if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
					echo ( $paged == $i ) ? '<li><span class=\'current\'>' . $i . '</span></li>' : '<li><a href="' . get_pagenum_link( $i ) . '" class=\'inactive\'>' . $i . '</a></li>';
				}
			}
			echo '</ul>';

			echo '<div class=\'next-last\'>';
			if ( $paged < $pages ) {
				echo '<a href="' . get_pagenum_link( $paged + 1 ) . '" class=\'next\'>Next &rsaquo;</a>';
			} else {
				echo '<span class=\'next\'>Next &rsaquo;</span>';
			}
			if ( $paged < $pages - 0 && $paged + $range - 1 < $pages ) {
				echo '<a href="' . get_pagenum_link( $pages ) . '">Last &rsaquo;</a>';
			} else {
				echo '<span>Last &rsaquo;</span>';
			}
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}
endif;

/**
 * Displays navigation to next/previous set of posts when applicable.
 */
if ( ! function_exists( '_rgnrtrPagingNav' ) ) :
	function _rgnrtrPagingNav() {
		global $wp_query;

		$prev_post = get_previous_post();
		$next_post = get_next_post();

		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}
		?>
		<nav class="navigation paging-navigation" role="navigation">
			<div class="nav-links">

				<?php if ( ! empty( $prev_post ) ) : ?>
					<div class="nav-previous"><a href="<?php echo get_permalink( $prev_post->ID ); ?>">Prev Post</a>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $next_post ) ) : ?>
					<div class="nav-next"><a href="<?php echo get_permalink( $next_post->ID ); ?>">Next Post</a></div>
				<?php endif; ?>

			</div>
			<!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
endif;

/**
 * Returns the URL from the post.
 */
function _rgnrtrGetPostURL() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}


/**
 * Search.
 */
add_filter( 'posts_where', array( 'M2SearchActions', '_m2searchWhere' ) );
add_filter( 'posts_join', array( 'M2SearchActions', '_m2searchJoin' ) );
add_filter( 'posts_groupby', array( 'M2SearchActions', '_m2searchGroupby' ) );

class M2SearchActions {

	static function _m2searchWhere( $where ) {
		if ( is_search() ) {
			global $table_prefix, $wpdb, $wp_query;
			$taxName  = array();
			$taxonomy = get_transient( 'store_posts_types' );

			if ( is_array( $taxonomy ) && ! empty( $taxonomy ) ):
				foreach ( $taxonomy as $item ):
					$taxName[] = '\'' . $item . 'storetags\'';
				endforeach;

				$terms = implode( ', ', $taxName );

				$where .= "OR (t.name like '%" . get_search_query() . "%' AND post_status = 'publish' and tt.taxonomy in ($terms))";
			else:
				$where .= "OR (t.name LIKE '%" . get_search_query() . "%' AND {$wpdb->posts}.post_status = 'publish')";
			endif;
		}

		return $where;
	}

	static function _m2searchJoin( $join ) {
		if ( is_search() ) {
			global $table_prefix, $wpdb;

			$tabletags     = $table_prefix . "terms";
			$tablepost2tag = $table_prefix . "term_relationships";
			$tabletaxonomy = $table_prefix . "term_taxonomy";

			$join .= "LEFT JOIN $tablepost2tag tr ON $wpdb->posts.ID = tr.object_id INNER JOIN $tabletaxonomy tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN $tabletags t ON t.term_id = tt.term_id ";

			//$join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
		}

		return $join;
	}

	static function _m2searchGroupby( $groupby ) {
		global $wpdb;

		// we need to group on post ID
		$groupby_id = "{$wpdb->posts}.ID";
		if ( ! is_search() || strpos( $groupby, $groupby_id ) !== false ) {
			return $groupby;
		}

		// groupby was empty, use ours
		if ( ! strlen( trim( $groupby ) ) ) {
			return $groupby_id;
		}

		// wasn't empty, append ours
		return $groupby . ", " . $groupby_id;
	}

}