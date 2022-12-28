<?php

/* Get Settings */
function nm($setting) {
    $options = get_option( 'nanomedya' );
    return $options[$setting];
}


/* Customize Admin Logo */

function customLogo() {
    $image = nm("customize-admin-logo-img");
?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo $image["url"];?>);
            height:<?php echo $image["height"];?>px;
            width:<?php echo $image["width"];?>px;
            background-size: <?php echo $image["width"];?>px <?php echo $image["height"];?>px;
            background-repeat: no-repeat;
            padding-bottom: 30px;
        }
    </style>
<?php }
if(nm("customize-admin-logo")) :
    add_action( 'login_enqueue_scripts', 'customLogo' );
endif;


function customColor(){ ?>
    <style>
        #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, #adminmenu .wp-menu-arrow, #adminmenu .wp-menu-arrow div, #adminmenu li.current a.menu-top, #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu {
            background-color: <?php echo nm("activeMenuBg");?>!important;
        }

        #adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap {
            background-color: <?php echo nm("sideBarBg");?>!important;
        }

        #adminmenu .wp-submenu {
            background-color: <?php echo nm("activeSubMenuBg");?>!important;
        }

        #wpadminbar {
            background: <?php echo nm("topBarBg");?>!important;
        }
    </style>
<?php }
  add_action( 'admin_enqueue_scripts', 'customColor' );

/* Codes */
function head_hook(){
    echo nm("headerCodes");
}
add_action( 'wp_head','head_hook', 999);

function footer_hook(){
    echo nm("footerCodes");
}
add_action( 'wp_footer','footer_hook', 999);

/* XML - RPC */
if(!nm("xmlrpc")) :
    add_filter( 'xmlrpc_enabled', '__return_false' );
endif;


if(nm("login")) {
    if (!is_plugin_active('wps-hide-login/wps-hide-login.php') )
    {
        activate_plugins(plugin_basename(WP_PLUGIN_DIR . "/wps-hide-login/wps-hide-login.php"));
    }
    update_option("whl_page",nm("loginURL"));
    update_option("whl_redirect_admin",nm("loginRedirectURL"));
} else {
    if (is_plugin_active('wps-hide-login/wps-hide-login.php') )
    {
        deactivate_plugins(plugin_basename(WP_PLUGIN_DIR . "/wps-hide-login/wps-hide-login.php"));
    }
    update_option("whl_page","");
    update_option("whl_redirect_admin","");
}

if(!nm("comments")) {
    add_action('admin_init', function () {
        // Redirect any user trying to access comments page
        global $pagenow;

        if ($pagenow === 'edit-comments.php') {
            wp_redirect(admin_url());
            exit;
        }

        // Remove comments metabox from dashboard
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

        // Disable support for comments and trackbacks in post types
        foreach (get_post_types() as $post_type) {
            if (post_type_supports($post_type, 'comments')) {
                remove_post_type_support($post_type, 'comments');
                remove_post_type_support($post_type, 'trackbacks');
            }
        }
    });

// Close comments on the front-end
    add_filter('comments_open', '__return_false', 20, 2);
    add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
    add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
    add_action('admin_menu', function () {
        remove_menu_page('edit-comments.php');
    });

// Remove comments links from admin bar
    add_action('init', function () {
        if (is_admin_bar_showing()) {
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
        }
    });

    add_action('wp_before_admin_bar_render', function() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('comments');
    });
}
/*
if(nm("ssl-redirect")) {
    function shapeSpace_check_https() {
        if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
            return true;
        }
        return false;
    }


    function bhww_ssl_template_redirect() {
        if ( shapeSpace_check_https() ) {
            if ( 0 === strpos( $_SERVER['REQUEST_URI'], 'http' ) ) {
                wp_redirect( preg_replace( '|^(https://)|', 'http://', $_SERVER['REQUEST_URI'] ), 301 );
                exit();
            } else {
                wp_redirect( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301 );
                exit();
            }
        }
    }

    add_action( 'template_redirect', 'bhww_ssl_template_redirect');
}
*/

if(nm("404-redirect")) {
    if( !function_exists('redirect_404_to_homepage') ){

        add_action( 'template_redirect', 'redirect_404_to_homepage' );

        function redirect_404_to_homepage(){
            if(is_404()):
                wp_safe_redirect( nm("404URL") );
                exit;
            endif;
        }
    }
}
?>
