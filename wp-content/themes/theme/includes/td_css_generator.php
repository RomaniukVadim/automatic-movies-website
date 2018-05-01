<?php

/**
 * @big_grid_large_image is put after @big_grid_small_images so that it will overwrite small posts style
 */

function td_css_generator() {

    $raw_css = "
    <style>
    /* ------------------------------------------------------ */
    /* Newspaper 6 */

    /* ------------------------------------------------------ */
    /* GENERAL Theme Colors */

    /* THEME ACCENT COLOR */
    /* @theme_color */
    .td-header-wrap .black-menu .sf-menu > .current-menu-item > a,
    .td-header-wrap .black-menu .sf-menu > .current-menu-ancestor > a,
    .td-header-wrap .black-menu .sf-menu > .current-category-ancestor > a,
    .td-header-wrap .black-menu .sf-menu > li > a:hover,
    .td-header-wrap .black-menu .sf-menu > .sfHover > a,
    .td-header-style-12 .td-header-menu-wrap-full,
    .sf-menu > .current-menu-item > a:after,
    .sf-menu > .current-menu-ancestor > a:after,
    .sf-menu > .current-category-ancestor > a:after,
    .sf-menu > li:hover > a:after,
    .sf-menu > .sfHover > a:after,
    .sf-menu ul .td-menu-item > a:hover,
    .sf-menu ul .sfHover > a,
    .sf-menu ul .current-menu-ancestor > a,
    .sf-menu ul .current-category-ancestor > a,
    .sf-menu ul .current-menu-item > a,
    .td-header-style-12 .td-affix,
    .header-search-wrap .td-drop-down-search:after,
    .header-search-wrap .td-drop-down-search .btn:hover,
    input[type=submit]:hover,
    .td-read-more a,
    .td-post-category:hover,
    .td-grid-style-1.td-hover-1 .td-big-grid-post:hover .td-post-category,
    .td-grid-style-5.td-hover-1 .td-big-grid-post:hover .td-post-category,
    .td_top_authors .td-active .td-author-post-count,
    .td_top_authors .td-active .td-author-comments-count,
    .td_top_authors .td_mod_wrap:hover .td-author-post-count,
    .td_top_authors .td_mod_wrap:hover .td-author-comments-count,
    .td-404-sub-sub-title a:hover,
    .td-search-form-widget .wpb_button:hover,
    .td-rating-bar-wrap div,
    .td_category_template_3 .td-current-sub-category,
    .mfp-content .td-login-wrap .btn,
    .mfp-content .td_display_err,
    .mfp-content .td_display_msg_ok,
    .dropcap,
    .td_wrapper_video_playlist .td_video_controls_playlist_wrapper,
    .wpb_default,
    .wpb_default:hover,
    .td-left-smart-list:hover,
    .td-right-smart-list:hover,
    .woocommerce-checkout .woocommerce input.button:hover,
    .woocommerce-page .woocommerce a.button:hover,
    .woocommerce-account div.woocommerce .button:hover,
    #bbpress-forums button:hover,
    .bbp_widget_login .button:hover,
    .td-footer-wrapper .td-post-category,
    .td-footer-wrapper .widget_product_search input[type=\"submit\"]:hover,
    .woocommerce .product a.button:hover,
    .woocommerce .product #respond input#submit:hover,
    .woocommerce .checkout input#place_order:hover,
    .woocommerce .woocommerce.widget .button:hover,
    .single-product .product .summary .cart .button:hover,
    .woocommerce-cart .woocommerce table.cart .button:hover,
    .woocommerce-cart .woocommerce .shipping-calculator-form .button:hover,
    .td-next-prev-wrap a:hover,
    .td-load-more-wrap a:hover,
    .td-post-small-box a:hover,
    .page-nav .current,
    .page-nav:first-child > div,
    .td_category_template_8 .td-category-header .td-category a.td-current-sub-category,
    .td_category_template_4 .td-category-siblings .td-category a:hover,
    #bbpress-forums .bbp-pagination .current,
    #bbpress-forums #bbp-single-user-details #bbp-user-navigation li.current a,
    .td-theme-slider:hover .slide-meta-cat a,
    a.vc_btn-black:hover,
    .td-trending-now-wrapper:hover .td-trending-now-title,
    .td-scroll-up,
    .td-smart-list-button:hover,
    .td-weather-information:before,
    .td-weather-week:before,
    .td_block_exchange .td-exchange-header:before,
    .td_block_big_grid_9.td-grid-style-1 .td-post-category,
    .td_block_big_grid_9.td-grid-style-5 .td-post-category,
    .td-grid-style-6.td-hover-1 .td-module-thumb:after {
        background-color: @theme_color;
    }

    .woocommerce .woocommerce-message .button:hover,
    .woocommerce .woocommerce-error .button:hover,
    .woocommerce .woocommerce-info .button:hover {
        background-color: @theme_color !important;
    }

    .woocommerce .product .onsale,
    .woocommerce.widget .ui-slider .ui-slider-handle {
        background: none @theme_color;
    }

    .woocommerce.widget.widget_layered_nav_filters ul li a {
        background: none repeat scroll 0 0 @theme_color !important;
    }

    a,
    cite a:hover,
    .td_mega_menu_sub_cats .cur-sub-cat,
    .td-mega-span h3 a:hover,
    .td_mod_mega_menu:hover .entry-title a,
    .header-search-wrap .result-msg a:hover,
    .top-header-menu li a:hover,
    .top-header-menu .current-menu-item > a,
    .top-header-menu .current-menu-ancestor > a,
    .top-header-menu .current-category-ancestor > a,
    .td-social-icon-wrap > a:hover,
    .td-header-sp-top-widget .td-social-icon-wrap a:hover,
    .td-page-content blockquote p,
    .td-post-content blockquote p,
    .mce-content-body blockquote p,
    .comment-content blockquote p,
    .wpb_text_column blockquote p,
    .td_block_text_with_title blockquote p,
    .td_module_wrap:hover .entry-title a,
    .td-subcat-filter .td-subcat-list a:hover,
    .td-subcat-filter .td-subcat-dropdown a:hover,
    .td_quote_on_blocks,
    .dropcap2,
    .dropcap3,
    .td_top_authors .td-active .td-authors-name a,
    .td_top_authors .td_mod_wrap:hover .td-authors-name a,
    .td-post-next-prev-content a:hover,
    .author-box-wrap .td-author-social a:hover,
    .td-author-name a:hover,
    .td-author-url a:hover,
    .td_mod_related_posts:hover h3 > a,
    .td-post-template-11 .td-related-title .td-related-left:hover,
    .td-post-template-11 .td-related-title .td-related-right:hover,
    .td-post-template-11 .td-related-title .td-cur-simple-item,
    .td-post-template-11 .td_block_related_posts .td-next-prev-wrap a:hover,
    .comment-reply-link:hover,
    .logged-in-as a:hover,
    #cancel-comment-reply-link:hover,
    .td-search-query,
    .td-category-header .td-pulldown-category-filter-link:hover,
    .td-category-siblings .td-subcat-dropdown a:hover,
    .td-category-siblings .td-subcat-dropdown a.td-current-sub-category,
    .mfp-content .td-login-wrap .td-login-info-text a:hover,
    .widget a:hover,
    .widget_calendar tfoot a:hover,
    .woocommerce a.added_to_cart:hover,
    #bbpress-forums li.bbp-header .bbp-reply-content span a:hover,
    #bbpress-forums .bbp-forum-freshness a:hover,
    #bbpress-forums .bbp-topic-freshness a:hover,
    #bbpress-forums .bbp-forums-list li a:hover,
    #bbpress-forums .bbp-forum-title:hover,
    #bbpress-forums .bbp-topic-permalink:hover,
    #bbpress-forums .bbp-topic-started-by a:hover,
    #bbpress-forums .bbp-topic-started-in a:hover,
    #bbpress-forums .bbp-body .super-sticky li.bbp-topic-title .bbp-topic-permalink,
    #bbpress-forums .bbp-body .sticky li.bbp-topic-title .bbp-topic-permalink,
    .widget_display_replies .bbp-author-name,
    .widget_display_topics .bbp-author-name,
    .footer-text-wrap .footer-email-wrap a,
    .td-subfooter-menu li a:hover,
    .footer-social-wrap a:hover,
    a.vc_btn-black:hover,
    .td-smart-list-dropdown-wrap .td-smart-list-button:hover,
    .td_module_17 .td-read-more a:hover,
    .td_module_18 .td-read-more a:hover,
    .td_module_19 .td-post-author-name a:hover,
    .td-instagram-user a {
        color: @theme_color;
    }

    .mfp-content .td_login_tab_focus,
    a.vc_btn-black.vc_btn_square_outlined:hover,
    a.vc_btn-black.vc_btn_outlined:hover,
    .td-mega-menu-page .wpb_content_element ul li a:hover {
        color: @theme_color !important;
    }

    .td-next-prev-wrap a:hover,
    .td-load-more-wrap a:hover,
    .td-post-small-box a:hover,
    .page-nav .current,
    .page-nav:first-child > div,
    .td_category_template_8 .td-category-header .td-category a.td-current-sub-category,
    .td_category_template_4 .td-category-siblings .td-category a:hover,
    #bbpress-forums .bbp-pagination .current,
    .mfp-content .td-login-panel-title,
    .post .td_quote_box,
    .page .td_quote_box,
    a.vc_btn-black:hover {
        border-color: @theme_color;
    }

    .td_wrapper_video_playlist .td_video_currently_playing:after {
        border-color: @theme_color !important;
    }

    .header-search-wrap .td-drop-down-search:before {
        border-color: transparent transparent @theme_color transparent;
    }

    .block-title > span,
    .block-title > a,
    .block-title > label,
    .widgettitle,
    .widgettitle:after,
    .td-trending-now-title,
    .td-trending-now-wrapper:hover .td-trending-now-title,
    .wpb_tabs li.ui-tabs-active a,
    .wpb_tabs li:hover a,
    .vc_tta-container .vc_tta-color-grey.vc_tta-tabs-position-top.vc_tta-style-classic .vc_tta-tabs-container .vc_tta-tab.vc_active > a,
    .vc_tta-container .vc_tta-color-grey.vc_tta-tabs-position-top.vc_tta-style-classic .vc_tta-tabs-container .vc_tta-tab:hover > a,
    .td-related-title .td-cur-simple-item,
    .woocommerce .product .products h2,
    .td-subcat-filter .td-subcat-dropdown:hover .td-subcat-more {
    	background-color: @theme_color;
    }

    .woocommerce div.product .woocommerce-tabs ul.tabs li.active {
    	background-color: @theme_color !important;
    }

    .block-title,
    .td-related-title,
    .wpb_tabs .wpb_tabs_nav,
    .vc_tta-container .vc_tta-color-grey.vc_tta-tabs-position-top.vc_tta-style-classic .vc_tta-tabs-container,
    .woocommerce div.product .woocommerce-tabs ul.tabs:before {
        border-color: @theme_color;
    }
    .td_block_wrap .td-subcat-item .td-cur-simple-item {
	    color: @theme_color;
	}


    /* @slider_text */
    .td-grid-style-4 .entry-title
    {
        background-color: @slider_text;
    }

    /* @header_color */
    .block-title > span,
    .block-title > a,
    .block-title > label,
    .widgettitle,
    .widgettitle:after,
    .td-trending-now-title,
    .td-trending-now-wrapper:hover .td-trending-now-title,
    .wpb_tabs li.ui-tabs-active a,
    .wpb_tabs li:hover a,
    .vc_tta-container .vc_tta-color-grey.vc_tta-tabs-position-top.vc_tta-style-classic .vc_tta-tabs-container .vc_tta-tab.vc_active > a,
    .vc_tta-container .vc_tta-color-grey.vc_tta-tabs-position-top.vc_tta-style-classic .vc_tta-tabs-container .vc_tta-tab:hover > a,
    .td-related-title .td-cur-simple-item,
    .woocommerce .product .products h2,
    .td-subcat-filter .td-subcat-dropdown:hover .td-subcat-more,
    .td-weather-information:before,
    .td-weather-week:before,
    .td_block_exchange .td-exchange-header:before {
        background-color: @header_color;
    }

    .woocommerce div.product .woocommerce-tabs ul.tabs li.active {
    	background-color: @header_color !important;
    }

    .block-title,
    .td-related-title,
    .wpb_tabs .wpb_tabs_nav,
    .vc_tta-container .vc_tta-color-grey.vc_tta-tabs-position-top.vc_tta-style-classic .vc_tta-tabs-container,
    .woocommerce div.product .woocommerce-tabs ul.tabs:before {
        border-color: @header_color;
    }

    /* @text_header_color */
    .block-title > span,
    .block-title > a,
    .widgettitle,
    .td-trending-now-title,
    .wpb_tabs li.ui-tabs-active a,
    .wpb_tabs li:hover a,
    .vc_tta-container .vc_tta-color-grey.vc_tta-tabs-position-top.vc_tta-style-classic .vc_tta-tabs-container .vc_tta-tab.vc_active > a,
    .vc_tta-container .vc_tta-color-grey.vc_tta-tabs-position-top.vc_tta-style-classic .vc_tta-tabs-container .vc_tta-tab:hover > a,
    .td-related-title .td-cur-simple-item,
    .woocommerce div.product .woocommerce-tabs ul.tabs li.active,
    .woocommerce .product .products h2 {
    	color: @text_header_color;
    }


    /* ------------------------------------------------------ */
    /* TOP Menu */


    /* @top_menu_color */
    .td-header-wrap .td-header-top-menu-full,
    .td-header-wrap .top-header-menu .sub-menu {
        background-color: @top_menu_color;
    }
    .td-header-style-8 .td-header-top-menu-full {
        background-color: transparent;
    }
    .td-header-style-8 .td-header-top-menu-full .td-header-top-menu {
        background-color: @top_menu_color;
        padding-left: 15px;
        padding-right: 15px;
    }

    .td-header-wrap .td-header-top-menu-full .td-header-top-menu,
    .td-header-wrap .td-header-top-menu-full {
        border-bottom: none;
    }


    /* @top_menu_text_color */
    .td-header-top-menu,
    .td-header-top-menu a,
    .td-header-wrap .td-header-top-menu-full .td-header-top-menu,
    .td-header-wrap .td-header-top-menu-full a,
    .td-header-style-8 .td-header-top-menu,
    .td-header-style-8 .td-header-top-menu a {
        color: @top_menu_text_color;
    }

    /* @top_menu_text_hover_color */
    .top-header-menu .current-menu-item > a,
    .top-header-menu .current-menu-ancestor > a,
    .top-header-menu .current-category-ancestor > a,
    .top-header-menu li a:hover {
        color: @top_menu_text_hover_color;
    }

    /* @top_social_icons_color */
    .td-header-wrap .td-header-sp-top-widget .td-icon-font {
        color: @top_social_icons_color;
    }

    /* @top_social_icons_hover_color */
    .td-header-wrap .td-header-sp-top-widget i.td-icon-font:hover {
        color: @top_social_icons_hover_color;
    }


    /* ------------------------------------------------------ */
    /* Main Menu */

    /* @menu_color */
    .td-header-wrap .td-header-menu-wrap-full,
    .sf-menu > .current-menu-ancestor > a,
    .sf-menu > .current-category-ancestor > a,
    .td-header-menu-wrap.td-affix,
    .td-header-style-3 .td-header-main-menu,
    .td-header-style-3 .td-affix .td-header-main-menu,
    .td-header-style-4 .td-header-main-menu,
    .td-header-style-4 .td-affix .td-header-main-menu,
    .td-header-style-8 .td-header-menu-wrap.td-affix,
    .td-header-style-8 .td-header-top-menu-full {
		background-color: @menu_color;
    }


    .td-boxed-layout .td-header-style-3 .td-header-menu-wrap,
    .td-boxed-layout .td-header-style-4 .td-header-menu-wrap {
    	background-color: @menu_color !important;
    }


    @media (min-width: 1019px) {
        .td-header-style-1 .td-header-sp-recs,
        .td-header-style-1 .td-header-sp-logo {
            margin-bottom: 28px;
        }
    }

    @media (min-width: 768px) and (max-width: 1018px) {
        .td-header-style-1 .td-header-sp-recs,
        .td-header-style-1 .td-header-sp-logo {
            margin-bottom: 14px;
        }
    }

    .td-header-style-7 .td-header-top-menu {
        border-bottom: none;
    }


    /* @submenu_hover_color */
    .sf-menu ul .td-menu-item > a:hover,
    .sf-menu ul .sfHover > a,
    .sf-menu ul .current-menu-ancestor > a,
    .sf-menu ul .current-category-ancestor > a,
    .sf-menu ul .current-menu-item > a,
    .sf-menu > .current-menu-item > a:after,
    .sf-menu > .current-menu-ancestor > a:after,
    .sf-menu > .current-category-ancestor > a:after,
    .sf-menu > li:hover > a:after,
    .sf-menu > .sfHover > a:after,
    .td_block_mega_menu .td-next-prev-wrap a:hover,
    .td-mega-span .td-post-category:hover,
    .td-header-wrap .black-menu .sf-menu > li > a:hover,
    .td-header-wrap .black-menu .sf-menu > .current-menu-ancestor > a,
    .td-header-wrap .black-menu .sf-menu > .sfHover > a,
    .header-search-wrap .td-drop-down-search:after,
    .header-search-wrap .td-drop-down-search .btn:hover,
    .td-header-wrap .black-menu .sf-menu > .current-menu-item > a,
    .td-header-wrap .black-menu .sf-menu > .current-menu-ancestor > a,
    .td-header-wrap .black-menu .sf-menu > .current-category-ancestor > a {
        background-color: @submenu_hover_color;
    }


    .td_block_mega_menu .td-next-prev-wrap a:hover {
        border-color: @submenu_hover_color;
    }

    .header-search-wrap .td-drop-down-search:before {
        border-color: transparent transparent @submenu_hover_color transparent;
    }

    .td_mega_menu_sub_cats .cur-sub-cat,
    .td_mod_mega_menu:hover .entry-title a {
        color: @submenu_hover_color;
    }


    /* @menu_text_color */
    .td-header-wrap .td-header-menu-wrap .sf-menu > li > a,
    .td-header-wrap .header-search-wrap .td-icon-search {
        color: @menu_text_color;
    }


    /* @mobile_menu_color */
    @media (max-width: 767px) {
        body .td-header-wrap .td-header-main-menu {
            background-color: @mobile_menu_color !important;
        }
    }


    /* @mobile_icons_color */
    @media (max-width: 767px) {
        body #td-top-mobile-toggle i,
        .td-header-wrap .header-search-wrap .td-icon-search {
            color: @mobile_icons_color !important;
        }
    }

    /* @mobile_gradient_one_mob */
    .td-menu-background:before,
    .td-search-background:before {
        background: @mobile_gradient_one_mob;
        background: -moz-linear-gradient(top, @mobile_gradient_one_mob 0%, @mobile_gradient_two_mob 100%);
        background: -webkit-gradient(left top, left bottom, color-stop(0%, @mobile_gradient_one_mob), color-stop(100%, @mobile_gradient_two_mob));
        background: -webkit-linear-gradient(top, @mobile_gradient_one_mob 0%, @mobile_gradient_two_mob 100%);
        background: -o-linear-gradient(top, @mobile_gradient_one_mob 0%, @mobileu_gradient_two_mob 100%);
        background: -ms-linear-gradient(top, @mobile_gradient_one_mob 0%, @mobile_gradient_two_mob 100%);
        background: linear-gradient(to bottom, @mobile_gradient_one_mob 0%, @mobile_gradient_two_mob 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='@mobile_gradient_one_mob', endColorstr='@mobile_gradient_two_mob', GradientType=0 );
    }

    /* @mobile_text_active_color */
    .td-mobile-content .current-menu-item > a,
    .td-mobile-content .current-menu-ancestor > a,
    .td-mobile-content .current-category-ancestor > a,
    #td-mobile-nav .td-menu-login-section a:hover,
    #td-mobile-nav .td-register-section a:hover,
    #td-mobile-nav .td-menu-socials-wrap a:hover i,
    .td-search-close a:hover i {
        color: @mobile_text_active_color;
    }

    /* @mobile_button_background_mob */
    #td-mobile-nav .td-register-section .td-login-button,
    .td-search-wrap-mob .result-msg a {
        background-color: @mobile_button_background_mob;
    }

    /* @mobile_button_color_mob */
    #td-mobile-nav .td-register-section .td-login-button,
    .td-search-wrap-mob .result-msg a {
        color: @mobile_button_color_mob;
    }



    /* @mobile_text_color */
    .td-mobile-content li a,
    .td-mobile-content .td-icon-menu-right,
    .td-mobile-content .sub-menu .td-icon-menu-right,
    #td-mobile-nav .td-menu-login-section a,
    #td-mobile-nav .td-menu-logout a,
    #td-mobile-nav .td-menu-socials-wrap .td-icon-font,
    .td-mobile-close .td-icon-close-mobile,
    .td-search-close .td-icon-close-mobile,
    .td-search-wrap-mob,
    .td-search-wrap-mob #td-header-search-mob,
    #td-mobile-nav .td-register-section,
    #td-mobile-nav .td-register-section .td-login-input,
    #td-mobile-nav label,
    #td-mobile-nav .td-register-section i,
    #td-mobile-nav .td-register-section a,
    #td-mobile-nav .td_display_err,
    .td-search-wrap-mob .td_module_wrap .entry-title a,
    .td-search-wrap-mob .td_module_wrap:hover .entry-title a,
    .td-search-wrap-mob .td-post-date {
        color: @mobile_text_color;
    }
    .td-search-wrap-mob .td-search-input:before,
    .td-search-wrap-mob .td-search-input:after,
    #td-mobile-nav .td-menu-login-section .td-menu-login span {
        background-color: @mobile_text_color;
    }

    #td-mobile-nav .td-register-section .td-login-input {
        border-bottom-color: @mobile_text_color !important;
    }


    /* @header_wrap_color */
    .td-banner-wrap-full,
    .td-header-style-11 .td-logo-wrap-full {
        background-color: @header_wrap_color;
    }

    .td-header-style-11 .td-logo-wrap-full {
        border-bottom: 0;
    }

    @media (min-width: 1019px) {
        .td-header-style-2 .td-header-sp-recs,
        .td-header-style-5 .td-a-rec-id-header > div,
        .td-header-style-5 .td-g-rec-id-header > .adsbygoogle,
        .td-header-style-6 .td-a-rec-id-header > div,
        .td-header-style-6 .td-g-rec-id-header > .adsbygoogle,
        .td-header-style-7 .td-a-rec-id-header > div,
        .td-header-style-7 .td-g-rec-id-header > .adsbygoogle,
        .td-header-style-8 .td-a-rec-id-header > div,
        .td-header-style-8 .td-g-rec-id-header > .adsbygoogle,
        .td-header-style-12 .td-a-rec-id-header > div,
        .td-header-style-12 .td-g-rec-id-header > .adsbygoogle {
            margin-bottom: 24px !important;
        }
    }

    @media (min-width: 768px) and (max-width: 1018px) {
        .td-header-style-2 .td-header-sp-recs,
        .td-header-style-5 .td-a-rec-id-header > div,
        .td-header-style-5 .td-g-rec-id-header > .adsbygoogle,
        .td-header-style-6 .td-a-rec-id-header > div,
        .td-header-style-6 .td-g-rec-id-header > .adsbygoogle,
        .td-header-style-7 .td-a-rec-id-header > div,
        .td-header-style-7 .td-g-rec-id-header > .adsbygoogle,
        .td-header-style-8 .td-a-rec-id-header > div,
        .td-header-style-8 .td-g-rec-id-header > .adsbygoogle,
        .td-header-style-12 .td-a-rec-id-header > div,
        .td-header-style-12 .td-g-rec-id-header > .adsbygoogle {
            margin-bottom: 14px !important;
        }
    }

     /* @text_logo_color */
    .td-header-wrap .td-logo-text-container .td-logo-text {
        color: @text_logo_color;
    }

    /* @text_logo_tagline_color */
    .td-header-wrap .td-logo-text-container .td-tagline-text {
        color: @text_logo_tagline_color;
    }





    /* ------------------------------------------------------ */
    /* Footer */

    /* @footer_color */
    .td-footer-wrapper {
        background-color: @footer_color;
    }

    /* @footer_text_color */
    .td-footer-wrapper,
    .td-footer-wrapper a,
    .td-footer-wrapper .block-title a,
    .td-footer-wrapper .block-title span,
    .td-footer-wrapper .block-title label,
    .td-footer-wrapper .td-excerpt,
    .td-footer-wrapper .td-post-author-name span,
    .td-footer-wrapper .td-post-date,
    .td-footer-wrapper .td-social-style3 .td_social_type a,
    .td-footer-wrapper .td-social-style3,
    .td-footer-wrapper .td-social-style4 .td_social_type a,
    .td-footer-wrapper .td-social-style4,
    .td-footer-wrapper .td-social-style9,
    .td-footer-wrapper .td-social-style10,
    .td-footer-wrapper .td-social-style2 .td_social_type a,
    .td-footer-wrapper .td-social-style8 .td_social_type a,
    .td-footer-wrapper .td-social-style2 .td_social_type,
    .td-footer-wrapper .td-social-style8 .td_social_type,
    .td-footer-template-13 .td-social-name {
        color: @footer_text_color;
    }

    .td-footer-wrapper .widget_calendar th,
    .td-footer-wrapper .widget_calendar td,
    .td-footer-wrapper .td-social-style2 .td_social_type .td-social-box,
    .td-footer-wrapper .td-social-style8 .td_social_type .td-social-box,
    .td-social-style-2 .td-icon-font:after {
        border-color: @footer_text_color;
    }

    .td-footer-wrapper .td-module-comments a,
    .td-footer-wrapper .td-post-category,
    .td-footer-wrapper .td-slide-meta .td-post-author-name span,
    .td-footer-wrapper .td-slide-meta .td-post-date {
        color: #fff;
    }

    /* @border_opacity */
    .td-footer-bottom-full .td-container::before {
        background-color: @border_opacity;
    }

    /* @footer_widget_text_color */
	.td-footer-wrapper .block-title > span,
    .td-footer-wrapper .block-title > a,
    .td-footer-wrapper .widgettitle {
    	color: @footer_widget_text_color;
    }

    /* @footer_bottom_color */
    .td-sub-footer-container {
        background-color: @footer_bottom_color;
    }

    /* @footer_bottom_text_color */
    .td-sub-footer-container,
    .td-subfooter-menu li a {
        color: @footer_bottom_text_color;
    }

    /* @footer_bottom_hover_color */
    .td-subfooter-menu li a:hover {
        color: @footer_bottom_hover_color;
    }


    /* ------------------------------------------------------ */
    /* Content */

    /* Posts */

    /* @post_title_color */
    .post .td-post-header .entry-title {
        color: @post_title_color;
    }
    .td_module_15 .entry-title a {
        color: @post_title_color;
    }

    /* @post_author_name_color */
    .td-module-meta-info .td-post-author-name a {
    	color: @post_author_name_color;
    }

    /* @post_content_color */
    .td-post-content,
    .td-post-content p {
    	color: @post_content_color;
    }

    /* @post_h_color */
    .td-post-content h1,
    .td-post-content h2,
    .td-post-content h3,
    .td-post-content h4,
    .td-post-content h5,
    .td-post-content h6 {
    	color: @post_h_color;
    }

    /* @post_blockquote_color */
    .post blockquote p,
    .page blockquote p {
    	color: @post_blockquote_color;
    }
    .post .td_quote_box,
    .page .td_quote_box {
        border-color: @post_blockquote_color;
    }


    /* @page_title_color */
    .td-page-header h1,
    .woocommerce-page .page-title {
    	color: @page_title_color;
    }

    /* @page_content_color */
    .td-page-content p,
    .td-page-content .td_block_text_with_title,
    .woocommerce-page .page-description > p {
    	color: @page_content_color;
    }

    /* @page_h_color */
    .td-page-content h1,
    .td-page-content h2,
    .td-page-content h3,
    .td-page-content h4,
    .td-page-content h5,
    .td-page-content h6 {
    	color: @page_h_color;
    }

    .td-page-content .widgettitle {
        color: #fff;
    }



    /* @footer_background_image */
    .td-footer-wrapper::before {
        background-image: url('@footer_background_image');
    }

    /* @footer_background_repeat */
    .td-footer-wrapper::before {
        background-repeat: @footer_background_repeat;
    }

    /* @footer_background_size */
    .td-footer-wrapper::before {
        background-size: @footer_background_size;
    }

    /* @footer_background_position */
    .td-footer-wrapper::before {
        background-position: @footer_background_position;
    }

    /* @footer_background_opacity */
    .td-footer-wrapper::before {
        opacity: @footer_background_opacity;
    }



    /* @mobile_background_image */
    .td-menu-background,
    .td-search-background {
        background-image: url('@mobile_background_image');
    }

    /* @mobile_background_repeat */
    .td-menu-background,
    .td-search-background {
        background-repeat: @mobile_background_repeat;
    }

    /* @mobile_background_size */
    .td-menu-background,
    .td-search-background {
        background-size: @mobile_background_size;
    }

    /* @mobile_background_position */
    .td-menu-background,
    .td-search-background {
        background-position: @mobile_background_position;
    }



    /* ------------------------------------------------------ */
    /* @top_menu */
    .top-header-menu > li > a,
    .td-weather-top-widget .td-weather-now .td-big-degrees,
    .td-weather-top-widget .td-weather-header .td-weather-city,
    .td-header-sp-top-menu .td_data_time {
        @top_menu
    }
    /* @top_sub_menu */
    .top-header-menu .menu-item-has-children li a {
    	@top_sub_menu
    }
    /* @main_menu */
    ul.sf-menu > .td-menu-item > a {
        @main_menu
    }
    /* @main_sub_menu */
    .sf-menu ul .td-menu-item a {
        @main_sub_menu
    }
	/* @mega_menu */
    .td_mod_mega_menu .item-details a {
        @mega_menu
    }
    /* @mega_menu_categ */
    .td_mega_menu_sub_cats .block-mega-child-cats a {
        @mega_menu_categ
    }
    /* @mobile_menu */
    .td-mobile-content .td-mobile-main-menu > li > a {
        @mobile_menu
    }
    /* @mobile_sub_menu */
    .td-mobile-content .sub-menu a {
        @mobile_sub_menu
    }



	/* @blocks_title */
    .block-title > span,
    .block-title > a,
    .widgettitle,
    .td-trending-now-title,
    .wpb_tabs li a,
    .vc_tta-container .vc_tta-color-grey.vc_tta-tabs-position-top.vc_tta-style-classic .vc_tta-tabs-container .vc_tta-tab > a,
    .td-related-title a,
    .woocommerce div.product .woocommerce-tabs ul.tabs li a,
    .woocommerce .product .products h2 {
        @blocks_title
    }
    /* @blocks_author */
    .td-post-author-name a {
        @blocks_author
    }
    /* @blocks_date */
    .td-post-date .entry-date {
        @blocks_date
    }
    /* @blocks_comment */
    .td-module-comments a,
    .td-post-views span,
    .td-post-comments a {
        @blocks_comment
    }
    /* @blocks_category */
    .td-big-grid-meta .td-post-category,
    .td_module_wrap .td-post-category,
    .td-module-image .td-post-category {
        @blocks_category
    }
    /* @blocks_filter */
    .td-subcat-filter .td-subcat-dropdown a,
    .td-subcat-filter .td-subcat-list a,
    .td-subcat-filter .td-subcat-dropdown span {
        @blocks_filter
    }
    /* @blocks_excerpt */
    .td-excerpt {
        @blocks_excerpt
    }


	/* modules_general */
	.td_module_wrap .td-module-title {
		@modules_general
	}
     /* @module_1 */
    .td_module_1 .td-module-title {
    	@module_1
    }
    /* @module_2 */
    .td_module_2 .td-module-title {
    	@module_2
    }
    /* @module_3 */
    .td_module_3 .td-module-title {
    	@module_3
    }
    /* @module_4 */
    .td_module_4 .td-module-title {
    	@module_4
    }
    /* @module_5 */
    .td_module_5 .td-module-title {
    	@module_5
    }
    /* @module_6 */
    .td_module_6 .td-module-title {
    	@module_6
    }
    /* @module_7 */
    .td_module_7 .td-module-title {
    	@module_7
    }
    /* @module_8 */
    .td_module_8 .td-module-title {
    	@module_8
    }
    /* @module_9 */
    .td_module_9 .td-module-title {
    	@module_9
    }
    /* @module_10 */
    .td_module_10 .td-module-title {
    	@module_10
    }
    /* @module_11 */
    .td_module_11 .td-module-title {
    	@module_11
    }
    /* @module_12 */
    .td_module_12 .td-module-title {
    	@module_12
    }
    /* @module_13 */
    .td_module_13 .td-module-title {
    	@module_13
    }
    /* @module_14 */
    .td_module_14 .td-module-title {
    	@module_14
    }
    /* @module_15 */
    .td_module_15 .entry-title {
    	@module_15
    }
    /* @module_16 */
    .td_module_16 .td-module-title {
    	@module_16
    }
    /* @module_17 */
    .td_module_17 .td-module-title {
    	@module_17
    }
    /* @module_18 */
    .td_module_18 .td-module-title {
    	@module_18
    }
    /* @module_19 */
    .td_module_19 .td-module-title {
    	@module_19
    }




	/* other_modules_general */
	.td_block_trending_now .entry-title a,
	.td-theme-slider .td-module-title a,
    .td-big-grid-post .entry-title {
		@other_modules_general
	}
    /* @module_mx1 */
    .td_module_mx1 .td-module-title a {
    	@module_mx1
    }
    /* @module_mx2 */
    .td_module_mx2 .td-module-title a {
    	@module_mx2
    }
    /* @module_mx3 */
    .td_module_mx3 .td-module-title a {
    	@module_mx3
    }
    /* @module_mx4 */
    .td_module_mx4 .td-module-title a {
    	@module_mx4
    }
    /* @module_mx7 */
    .td_module_mx7 .td-module-title a {
    	@module_mx7
    }
    /* @module_mx8 */
    .td_module_mx8 .td-module-title a {
    	@module_mx8
    }
    /* @module_mx9 */
    .td_module_mx9 .td-module-title a {
    	@module_mx9
    }
    /* @module_mx16 */
    .td_module_mx16 .td-module-title a {
    	@module_mx16
    }
    /* @module_mx17 */
    .td_module_mx17 .td-module-title a {
    	@module_mx17
    }
    /* @news_ticker */
    .td_block_trending_now .entry-title a {
    	@news_ticker
    }
    /* @slider_1columns */
    .td-theme-slider.iosSlider-col-1 .td-module-title a {
        @slider_1columns
    }
    /* @slider_2columns */
    .td-theme-slider.iosSlider-col-2 .td-module-title a {
        @slider_2columns
    }
    /* @slider_3columns */
    .td-theme-slider.iosSlider-col-3 .td-module-title a {
        @slider_3columns
    }
    /* @big_grid_big */
    .td-big-grid-post.td-big-thumb .td-big-grid-meta,
    .td-big-thumb .td-big-grid-meta .entry-title {
        @big_grid_big
    }
    /* @big_grid_medium */
    .td-big-grid-post.td-medium-thumb .td-big-grid-meta,
    .td-medium-thumb .td-big-grid-meta .entry-title {
        @big_grid_medium
    }
    /* @big_grid_small */
    .td-big-grid-post.td-small-thumb .td-big-grid-meta,
    .td-small-thumb .td-big-grid-meta .entry-title {
        @big_grid_small
    }
    /* @big_grid_tiny */
    .td-big-grid-post.td-tiny-thumb .td-big-grid-meta,
    .td-tiny-thumb .td-big-grid-meta .entry-title {
        @big_grid_tiny
    }
    /* @homepage_post */
    .homepage-post .td-post-template-8 .td-post-header .entry-title {
        @homepage_post
    }


    /* mobile_general */
	#td-mobile-nav,
	#td-mobile-nav .wpb_button,
	.td-search-wrap-mob {
		@mobile_general
	}


	/* post_general */
	.post .td-post-header .entry-title {
		@post_general
	}
    /* @post_title */
    .td-post-template-default .td-post-header .entry-title {
        @post_title
    }
    /* @post_title_style1 */
    .td-post-template-1 .td-post-header .entry-title {
        @post_title_style1
    }
    /* @post_title_style2 */
    .td-post-template-2 .td-post-header .entry-title {
        @post_title_style2
    }
    /* @post_title_style3 */
    .td-post-template-3 .td-post-header .entry-title {
        @post_title_style3
    }
    /* @post_title_style4 */
    .td-post-template-4 .td-post-header .entry-title {
        @post_title_style4
    }
    /* @post_title_style5 */
    .td-post-template-5 .td-post-header .entry-title {
        @post_title_style5
    }
    /* @post_title_style6 */
    .td-post-template-6 .td-post-header .entry-title {
        @post_title_style6
    }
    /* @post_title_style7 */
    .td-post-template-7 .td-post-header .entry-title {
        @post_title_style7
    }
    /* @post_title_style8 */
    .td-post-template-8 .td-post-header .entry-title {
        @post_title_style8
    }
    /* @post_title_style9 */
    .td-post-template-9 .td-post-header .entry-title {
        @post_title_style9
    }
    /* @post_title_style10 */
    .td-post-template-10 .td-post-header .entry-title {
        @post_title_style10
    }
    /* @post_title_style11 */
    .td-post-template-11 .td-post-header .entry-title {
        @post_title_style11
    }
    /* @post_title_style12 */
    .td-post-template-12 .td-post-header .entry-title {
        @post_title_style12
    }
    /* @post_title_style13 */
    .td-post-template-13 .td-post-header .entry-title {
        @post_title_style13
    }





	/* @post_content */
    .td-post-content p,
    .td-post-content {
        @post_content
    }
    /* @post_blockquote */
    .post blockquote p,
    .page blockquote p,
    .td-post-text-content blockquote p {
        @post_blockquote
    }
    /* @post_box_quote */
    .post .td_quote_box p,
    .page .td_quote_box p {
        @post_box_quote
    }
    /* @post_pull_quote */
    .post .td_pull_quote p,
    .page .td_pull_quote p {
        @post_pull_quote
    }
    /* @post_lists */
    .td-post-content li {
        @post_lists
    }
    /* @post_h1 */
    .td-post-content h1 {
        @post_h1
    }
    /* @post_h2 */
    .td-post-content h2 {
        @post_h2
    }
    /* @post_h3 */
    .td-post-content h3 {
        @post_h3
    }
    /* @post_h4 */
    .td-post-content h4 {
        @post_h4
    }
    /* @post_h5 */
    .td-post-content h5 {
        @post_h5
    }
    /* @post_h6 */
    .td-post-content h6 {
        @post_h6
    }





    /* @post_category */
    .post .td-category a {
        @post_category
    }
    /* @post_author */
    .post header .td-post-author-name,
    .post header .td-post-author-name a {
        @post_author
    }
    /* @post_date */
    .post header .td-post-date .entry-date {
        @post_date
    }
    /* @post_comment */
    .post header .td-post-views span,
    .post header .td-post-comments {
        @post_comment
    }
    /* @via_source_tag */
    .post .td-post-source-tags a,
    .post .td-post-source-tags span {
        @via_source_tag
    }
    /* @post_next_prev_text */
    .post .td-post-next-prev-content span {
        @post_next_prev_text
    }
    /* @post_next_prev */
    .post .td-post-next-prev-content a {
        @post_next_prev
    }
    /* @box_author_name */
    .post .author-box-wrap .td-author-name a {
        @box_author_name
    }
    /* @box_author_url */
    .post .author-box-wrap .td-author-url a {
        @box_author_url
    }
    /* @box_author_description */
    .post .author-box-wrap .td-author-description {
        @box_author_description
    }
    /* @post_related */
    .td_block_related_posts .entry-title a {
        @post_related
    }
    /* @post_share */
    .post .td-post-share-title {
        @post_share
    }
    /* @post_image_caption */
	.wp-caption-text,
	.wp-caption-dd {
		@post_image_caption
	}
    /* @post_subtitle_small */
    .td-post-template-default .td-post-sub-title,
    .td-post-template-1 .td-post-sub-title,
    .td-post-template-4 .td-post-sub-title,
    .td-post-template-5 .td-post-sub-title,
    .td-post-template-9 .td-post-sub-title,
    .td-post-template-10 .td-post-sub-title,
    .td-post-template-11 .td-post-sub-title {
        @post_subtitle_small
    }
    /* @post_subtitle_large */
    .td-post-template-2 .td-post-sub-title,
    .td-post-template-3 .td-post-sub-title,
    .td-post-template-6 .td-post-sub-title,
    .td-post-template-7 .td-post-sub-title,
    .td-post-template-8 .td-post-sub-title {
        @post_subtitle_large
    }




	/* @page_title */
    .td-page-title,
    .woocommerce-page .page-title,
    .td-category-title-holder .td-page-title {
    	@page_title
    }
    /* @page_content */
    .td-page-content p,
    .td-page-content .td_block_text_with_title,
    .woocommerce-page .page-description > p,
    .wpb_text_column p {
    	@page_content
    }
    /* @page_h1 */
    .td-page-content h1,
    .wpb_text_column h1 {
    	@page_h1
    }
    /* @page_h2 */
    .td-page-content h2,
    .wpb_text_column h2 {
    	@page_h2
    }
    /* @page_h3 */
    .td-page-content h3,
    .wpb_text_column h3 {
    	@page_h3
    }
    /* @page_h4 */
    .td-page-content h4,
    .wpb_text_column h4 {
    	@page_h4
    }
    /* @page_h5 */
    .td-page-content h5,
    .wpb_text_column h5 {
    	@page_h5
    }
    /* @page_h6 */
    .td-page-content h6,
    .wpb_text_column h6 {
    	@page_h6
    }




    /* @footer_text_about */
	.footer-text-wrap {
		@footer_text_about
	}
	/* @footer_copyright_text */
	.td-sub-footer-copy {
		@footer_copyright_text
	}
	/* @footer_menu_text */
	.td-sub-footer-menu ul li a {
		@footer_menu_text
	}




	/* @breadcrumb */
    .entry-crumbs a,
    .entry-crumbs span,
    #bbpress-forums .bbp-breadcrumb a,
    #bbpress-forums .bbp-breadcrumb .bbp-breadcrumb-current {
    	@breadcrumb
    }
    /* @category_tag */
    .category .td-category a {
    	@category_tag
    }
    /* @news_ticker_title */
    .td-trending-now-display-area .entry-title {
    	@news_ticker_title
    }
    /* @pagination */
    .page-nav a,
    .page-nav span {
    	@pagination
    }
    /* @dropcap */
    #td-outer-wrap span.dropcap {
    	@dropcap
    }
    /* @default_widgets */
    .widget_archive a,
    .widget_calendar,
    .widget_categories a,
    .widget_nav_menu a,
    .widget_meta a,
    .widget_pages a,
    .widget_recent_comments a,
    .widget_recent_entries a,
    .widget_text .textwidget,
    .widget_tag_cloud a,
    .widget_search input,
    .woocommerce .product-categories a,
    .widget_display_forums a,
    .widget_display_replies a,
    .widget_display_topics a,
    .widget_display_views a,
    .widget_display_stats {
    	@default_widgets
    }
    /* @default_buttons */
	input[type=\"submit\"],
	.td-read-more a,
	.vc_btn,
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce #respond input#submit {
		@default_buttons
	}
	/* @woocommerce_products */
	.woocommerce .product a h3,
	.woocommerce .widget.woocommerce .product_list_widget a,
	.woocommerce-cart .woocommerce .product-name a {
		@woocommerce_products
	}
	/* @woocommerce_product_title */
	.woocommerce .product .summary .product_title {
		@woocommerce_product_title
	}





	/* @body_text */
    body, p {
    	@body_text
    }




    /* @bbpress_header */
    #bbpress-forums .bbp-header .bbp-forums,
    #bbpress-forums .bbp-header .bbp-topics,
    #bbpress-forums .bbp-header {
    	@bbpress_header
    }
    /* @bbpress_titles */
    #bbpress-forums .hentry .bbp-forum-title,
    #bbpress-forums .hentry .bbp-topic-permalink {
    	@bbpress_titles
    }
    /* @bbpress_subcategories */
    #bbpress-forums .bbp-forums-list li {
    	@bbpress_subcategories
    }
    /* @bbpress_description */
    #bbpress-forums .bbp-forum-info .bbp-forum-content {
    	@bbpress_description
    }
    /* @bbpress_author */
    #bbpress-forums div.bbp-forum-author a.bbp-author-name,
    #bbpress-forums div.bbp-topic-author a.bbp-author-name,
    #bbpress-forums div.bbp-reply-author a.bbp-author-name,
    #bbpress-forums div.bbp-search-author a.bbp-author-name,
    #bbpress-forums .bbp-forum-freshness .bbp-author-name,
    #bbpress-forums .bbp-topic-freshness a:last-child {
    	@bbpress_author
    }
    /* @bbpress_replies */
    #bbpress-forums .hentry .bbp-topic-content p,
    #bbpress-forums .hentry .bbp-reply-content p {
    	@bbpress_replies
    }
    /* @bbpress_notices */
    #bbpress-forums div.bbp-template-notice p {
    	@bbpress_notices
    }
    /* @bbpress_pagination */
    #bbpress-forums .bbp-pagination-count,
    #bbpress-forums .page-numbers {
    	@bbpress_pagination
    }
    /* @bbpress_topic */
    #bbpress-forums .bbp-topic-started-by,
    #bbpress-forums .bbp-topic-started-by a,
    #bbpress-forums .bbp-topic-started-in,
    #bbpress-forums .bbp-topic-started-in a {
    	@bbpress_topic
    }

    /* @top-menu-height */
    .td-header-sp-top-widget .td-social-icon-wrap .td-icon-font {
        line-height: @top-menu-height;
    }

    /* @main-menu-height */
    @media (min-width: 768px) {
        #td-header-menu {
            min-height: @main-menu-height !important;
        }
        .td-header-style-4 .td-main-menu-logo img,
        .td-header-style-5 .td-main-menu-logo img,
        .td-header-style-6 .td-main-menu-logo img,
        .td-header-style-7 .td-header-sp-logo img,
        .td-header-style-12 .td-main-menu-logo img {
            max-height: @main-menu-height;
        }
        .td-header-style-4 .td-main-menu-logo,
        .td-header-style-5 .td-main-menu-logo,
        .td-header-style-6 .td-main-menu-logo,
        .td-header-style-7 .td-header-sp-logo,
        .td-header-style-12 .td-main-menu-logo {
            height: @main-menu-height;
        }
        .td-header-style-4 .td-main-menu-logo a,
        .td-header-style-5 .td-main-menu-logo a,
        .td-header-style-6 .td-main-menu-logo a,
        .td-header-style-7 .td-header-sp-logo a,
        .td-header-style-7 .td-header-sp-logo img,
        .td-header-style-7 .header-search-wrap .td-icon-search,
        .td-header-style-12 .td-main-menu-logo a,
        .td-header-style-12 .td-header-menu-wrap .sf-menu > li > a {
            line-height: @main-menu-height;
        }
        .td-header-style-7 .sf-menu {
            margin-top: 0;
        }
        .td-header-style-7 #td-top-search {
            top: 0;
            bottom: 0;
        }
    }

    </style>
    ";



    $td_css_compiler = new td_css_compiler($raw_css);
    //the template directory uri
    $td_css_compiler->load_setting_raw('get_template_directory_uri', get_template_directory_uri());


    //get $typography array from db and added to generated css
    $td_typography_array = td_fonts::td_get_typography_sections_from_db();
    if(is_array($td_typography_array) and !empty($td_typography_array)) {

        foreach ($td_typography_array as $section_id => $section_css_array) {
            $td_css_compiler->load_setting_array(array($section_id => $section_css_array));
        }
    }

	// read line-height for the main-menu to align the logo in menu // nu e folosit
	$td_menu_height = td_util::get_option('td_fonts');
	if (!empty($td_menu_height['main_menu']['line_height'])) {
		$td_css_compiler->load_setting_raw('main-menu-height', $td_menu_height['main_menu']['line_height']);
	}

    // read line-height for the top-menu to align the social icons in top menu
    $td_top_menu_height = td_util::get_option('td_fonts');
    if (!empty($td_top_menu_height['top_menu']['line_height'])) {
        $td_css_compiler->load_setting_raw('top-menu-height', $td_top_menu_height['top_menu']['line_height']);
    }

    // footer text color used for borders with opacity
    $tds_footer_text_color = td_util::get_option('tds_footer_text_color');
    if (!empty($tds_footer_text_color)) {
        $td_css_compiler->load_setting_raw('border_opacity', td_util::hex2rgba($tds_footer_text_color, 0.1));
    }

    // footer background
    $td_css_compiler->load_setting('footer_background_image');
    $td_css_compiler->load_setting('footer_background_repeat');
    $td_css_compiler->load_setting('footer_background_size');
    $td_css_compiler->load_setting('footer_background_position');
    $td_css_compiler->load_setting('footer_background_opacity');

    // mobile menu/search background
    $td_css_compiler->load_setting('mobile_background_image');
    $td_css_compiler->load_setting('mobile_background_repeat');
    $td_css_compiler->load_setting('mobile_background_size');
    $td_css_compiler->load_setting('mobile_background_position');

    //load the user settings
    // general
    $td_css_compiler->load_setting('theme_color');
    $td_css_compiler->load_setting('header_color');
    $td_css_compiler->load_setting('text_header_color');

    // header ---------
    $td_css_compiler->load_setting('top_menu_color');
    $td_css_compiler->load_setting('top_menu_text_color');
    $td_css_compiler->load_setting('top_menu_text_hover_color');
    $td_css_compiler->load_setting('top_social_icons_color');
    $td_css_compiler->load_setting('top_social_icons_hover_color');
    $td_css_compiler->load_setting('menu_color');
    $td_css_compiler->load_setting('submenu_hover_color');
    $td_css_compiler->load_setting('menu_text_color');
    $td_css_compiler->load_setting('header_wrap_color');
    $td_css_compiler->load_setting('text_logo_color');
    $td_css_compiler->load_setting('text_logo_tagline_color');

    // mobile menu
    $td_css_compiler->load_setting('mobile_menu_color');
    $td_css_compiler->load_setting('mobile_icons_color');
    $td_css_compiler->load_setting('mobile_text_color');
    $td_css_compiler->load_setting('mobile_text_active_color');

    // menu gradient color
    $td_css_compiler->load_setting('mobile_gradient_one_mob');
    $td_css_compiler->load_setting('mobile_gradient_two_mob');
    //color one is empty
    if (empty($td_css_compiler->settings['mobile_gradient_one_mob']) && !empty($td_css_compiler->settings['mobile_gradient_two_mob'])) {
        $td_css_compiler->load_setting_raw('mobile_gradient_one_mob', '#333145');
    }
    //color two is empty
    if (!empty($td_css_compiler->settings['mobile_gradient_one_mob']) && empty($td_css_compiler->settings['mobile_gradient_two_mob'])) {
        $td_css_compiler->load_setting_raw('mobile_gradient_two_mob', '#b8333e');
    }

    $td_css_compiler->load_setting('mobile_button_background_mob');
    $td_css_compiler->load_setting('mobile_button_color_mob');

    // footer ---------
    $td_css_compiler->load_setting('footer_color');
    $td_css_compiler->load_setting('footer_text_color');
    $td_css_compiler->load_setting('footer_bottom_color');
    $td_css_compiler->load_setting('footer_bottom_text_color');
    $td_css_compiler->load_setting('footer_bottom_hover_color');
    $td_css_compiler->load_setting('footer_widget_text_color');

	// posts ---------
	$td_css_compiler->load_setting('post_title_color');
	$td_css_compiler->load_setting('post_author_name_color');
	$td_css_compiler->load_setting('post_content_color');
	$td_css_compiler->load_setting('post_h_color');
	$td_css_compiler->load_setting('post_blockquote_color');

	// pages ---------
	$td_css_compiler->load_setting('page_title_color');
	$td_css_compiler->load_setting('page_content_color');
	$td_css_compiler->load_setting('page_h_color');



    //load the selection color
    $tds_theme_color = td_util::get_option('tds_theme_color');
    if (!empty($tds_theme_color)) {
        //the select
        $td_css_compiler->load_setting_raw('select_color', td_util::adjustBrightness($tds_theme_color, 50));

        //the sliders text
        $td_css_compiler->load_setting_raw('slider_text', td_util::hex2rgba($tds_theme_color, 0.7));
    }


    /**
     * add td_fonts_css_buffer from database into the source of the page
     *
     * td_fonts_css_buffer : used to store the css generated for custom font files in the database
     */
    $td_fonts_css_buffer = td_fonts::td_add_fonts_css_buffer();



    /* add block styles */
    $td_block_styles = td_util::get_option('td_block_styles');

    //check if we have something set by the user
    if(!empty($td_block_styles)) {
        foreach($td_block_styles as $style_name => $array_style_options) {
            foreach($array_style_options as $option_key => $option_val){
                if(!empty($td_block_styles[$style_name][$option_key])) {

                    $option_name_generator = str_replace('tds_', $style_name . '_', $option_key);

                    switch ($option_key) {
                        case 'tds_block_drop_down_background_color':
                            $td_css_compiler->load_setting_raw($option_name_generator, td_util::hex2rgba($td_block_styles[$style_name][$option_key], 0.95));
                            $td_css_compiler->load_setting_raw($option_name_generator . '_ie8' , $td_block_styles[$style_name][$option_key]);
                            break;

                        case 'tds_block_module_post_comments_box_background_color':
                            $td_css_compiler->load_setting_raw($option_name_generator , $td_block_styles[$style_name][$option_key]);

                            //converting hex color to rgb
                            $rgb_color = td_util::html2rgb($td_block_styles[$style_name][$option_key]);

                            //converting rgb to hsl
                            $hsl_color = td_util::rgb2Hsl($rgb_color[0], $rgb_color[1], $rgb_color[2]);

                            //this is a hack for HLS color: red is 0 in HLS and no output is generated
                            if(intval($hsl_color[0] == 0)) {
                                $hsl_color[0] = 1;
                            }

                            $td_css_compiler->load_setting_raw($option_name_generator . '_after' , $hsl_color[0]);
                            break;

                        default:
                            $td_css_compiler->load_setting_raw($option_name_generator, $td_block_styles[$style_name][$option_key]);
                    }
                }
            }
        }
    }


    //output the style
    //td_css_buffer::add($td_css_compiler->compile_css());
    return $td_fonts_css_buffer . $td_css_compiler->compile_css();

}

