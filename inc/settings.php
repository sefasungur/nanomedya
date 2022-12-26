<?php
require_once __DIR__ .'/codestar-framework-master/codestar-framework.php';

if( class_exists( 'CSF' ) ) {

    //
    // Set a unique slug-like ID
    $prefix = 'nanomedya';

    //
    // Create options
    CSF::createOptions( $prefix, array(
        'menu_title' => 'Nano Medya',
        'menu_slug'  => 'nanomedya-settings',
        'menu_type'  => 'submenu',
        'menu_parent'   => 'options-general.php',
        'show_bar_menu' => false,
        'theme' => 'light',
        'framework_title' => 'Nano Medya Ayarları <small>v' .getPluginData("Version").'</small>',
        'footer_credit' => '',
        'footer_text' => 'Copyright &copy; Nanomedya'

    ) );

    //
    // Create a section
    CSF::createSection( $prefix, array(
        'title'  => 'Güvenlik Ayarları',
        'fields' => array(
            array(
                'id'    => 'xmlrpc',
                'type'  => 'switcher',
                'title' => 'XML-RPC Durumu',
                'text_on' => 'Açık',
                'text_off' => 'Kapalı',
                'text_width' => 80,
                'default' => false
            ),
            array(
                'id'    => 'login',
                'type'  => 'switcher',
                'title' => 'Farklı admin girişi',
                'text_on' => 'Açık',
                'text_off' => 'Kapalı',
                'text_width' => 80,
                'default' => true,
                'desc' => 'Bu alanın aktif olabilmesi için WPS Hide Login eklentisinin kurulu olması gerekmektedir.'
            ),
            array(
                'id'    => 'loginURL',
                'type'  => 'text',
                'title' => 'Admin giriş adresi',
                'dependency' => array( 'login', '==', 'true' ),
                'default'   => "/admin1250"
            ),
            array(
                'id'    => 'loginRedirectURL',
                'type'  => 'text',
                'title' => 'Admin hatalı giriş adresi',
                'dependency' => array( 'login', '==', 'true' ),
                'default'   => "/404"
            ),
            array(
                'id'    => 'comments',
                'type'  => 'switcher',
                'title' => 'Yorumlar',
                'text_on' => 'Açık',
                'text_off' => 'Kapalı',
                'text_width' => 80,
                'default' => true
            ),
            array(
                'id'    => 'ssl-redirect',
                'type'  => 'switcher',
                'title' => 'SSL (https) Yönlendirme',
                'text_on' => 'Açık',
                'text_off' => 'Kapalı',
                'text_width' => 80,
                'default' => true,
                'desc' => 'Sunucuda SSL yüklü değilse çalışmaz.'
            ),
            array(
                'id'    => '404-redirect',
                'type'  => 'switcher',
                'title' => '404 Farklı Sayfa Yönlendirme',
                'text_on' => 'Açık',
                'text_off' => 'Kapalı',
                'text_width' => 80,
                'default' => false,
                'desc' => '404 veya olmayan bir sayfaya yönlendirildiğinde kısır döngüye girip hata verecektir.'
            ),
            array(
                'id'    => '404URL',
                'type'  => 'text',
                'title' => '404 yönlendirme adresi',
                'dependency' => array( '404-redirect', '==', 'true' ),
                'default'   => get_site_url()."/"
            ),

        )
    ) );

    //
    // Design Settings
    CSF::createSection( $prefix, array(
        'title'  => 'Tasarım Ayarları',
        'fields' => array(
            array(
                'id'    => 'customize-admin-logo',
                'type'  => 'switcher',
                'title' => 'Özel Admin Giriş Logosu',
                'text_on' => 'Açık',
                'text_off' => 'Kapalı',
                'text_width' => 80,
                'default' => false
            ),
            array(
                'id'    => 'customize-admin-logo-img',
                'type'  => 'media',
                'library' => 'image',
                'title' => 'Admin Logosu Seç',
                'default' => plugin_dir_url(dirname(dirname(__FILE__)). "/nanomedya.php")."/assets/default/LoginLogo.png",
                'dependency' => array( 'customize-admin-logo', '==', 'true' ),
            ),
            array(
                'id'    => 'sideBarBg',
                'type' => 'color',
                'title' => 'Yan Panel Renk',
                'default' => '#606060'
            ),

            array(
                'id'    => 'topBarBg',
                'type' => 'color',
                'title' => 'Üst Panel Renk',
                'default' => '#000000'
            ),

            array(
                'id'    => 'activeMenuBg',
                'type' => 'color',
                'title' => 'Aktif Menü Renk',
                'default' => '#000000'
            ),

            array(
                'id'    => 'activeSubMenuBg',
                'type' => 'color',
                'title' => 'Aktif Açılır Menü Renk',
                'default' => '#ee6b00'
            )
        )
    ) );

    CSF::createSection($prefix, array(
        'title'  => 'Kod Alanları',
        'fields' => array(
            array(
                'id' => 'headerCodes',
                'type' => 'textarea',
                'title' => 'Üst Kısım Kodlar',
                'sanitize' => false,
            ),
            array(
                'id' => 'footerCodes',
                'type' => 'textarea',
                'title' => 'Alt Kısım Kodlar',
                'sanitize' => false,
            )
        )
    ));

    CSF::createSection($prefix, array(
        'title' => 'Hakkında',
        'fields' => array(
            array(
                'type'    => 'heading',
                'content' => 'Nanomedya Eklentisi Hakkında',
            ),
            array(
                'type'    => 'content',
                'content' => 'Nanomedya tarafından geliştirilen temalarda güvenlik ve tasarımsal düzenlemeler yapılmasını sağlayan eklentidir.',
            ),

            array(
                'type'    => 'content',
                'content' => 'Version: '.getPluginData("Version"),
            ),
            array(
                'type'    => 'content',
                'content' => 'Min. PHP Version: '.getPluginData("RequiresPHP"),
            ),
            array(
                'type'    => 'content',
                'content' => 'Min. WP Version: '.getPluginData("RequiresWP"),
            ),
            array(
                'type' => 'subheading',
                'content' => 'Yedekleme'
            ),
            array(
                'type' => 'backup',
            ),
        )
    ));
}