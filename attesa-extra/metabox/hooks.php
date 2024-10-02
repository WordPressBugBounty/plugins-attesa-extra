<?php
/* Custom header color text if the full width page overlay the menu */
function attesaextra_fullwidth_and_overlayheader_text_color($attesa_custom_css) {
	if (attesaextra_check_use_custom_settings() && attesaextra_check_for_fullwidth_builders() && attesaextra_check_for_overlaytoheader()) {
		$generalOverlayContentToHeaderColor = get_post_meta(attesaextra_get_the_current_ID(), '_general_overlay_contenttoheader_color', true);
		$generalOverlayContentToHeaderBackgroundColor = get_post_meta(attesaextra_get_the_current_ID(), '_general_overlay_contentbackground', true);
		$attesa_custom_css .='
		#masthead:not(.menuMinor) .site-branding .site-description,
		#masthead:not(.menuMinor) .attesa-social-header-desktop .site-social-header a,
		#masthead:not(.menuMinor) .attesa-woo-icons-header a,
		#masthead:not(.menuMinor) .cartwoo-button-mobile a,
		#masthead:not(.menuMinor) .cartedd-button-mobile a,
		#masthead:not(.menuMinor) .attesa_float_cart_icon.position_next_main_menu,
		#masthead:not(.menuMinor) button.menu-toggle,
		#masthead:not(.menuMinor) .main-navigation>div>ul>li.attesaMenuButton>a,
		#masthead:not(.menuMinor) .main-navigation>div>ul>li.attesaMenuButton>a:hover,
		#masthead:not(.menuMinor) .main-navigation>div>ul>li.attesaMenuButton>a:focus,
		#masthead:not(.menuMinor) .main-navigation>div>ul>li.attesaMenuButton>a:active {
			color: '.esc_html($generalOverlayContentToHeaderColor).';
		}
		@media all and (min-width: 1025px) {
			#masthead:not(.menuMinor) .main-navigation>div>ul>li:not(.attesaMenuButton)>a {
				color: '.esc_html($generalOverlayContentToHeaderColor).';
			}
		}
		#masthead:not(.menuMinor) .hamburger-menu .menu__line,
		#masthead:not(.menuMinor) .hamburger-menu .menu__plus,
		body:not(.yesOpenPopupMenu) #masthead:not(.menuMinor) .icon-full-screen .square-full-screen {
			background-color: '.esc_html($generalOverlayContentToHeaderColor).';
		}
		#masthead:not(.menuMinor) .hamburger-menu .menu__circle {
			border-color: '.esc_html($generalOverlayContentToHeaderColor).';
		}';
		if ($generalOverlayContentToHeaderBackgroundColor) {
			$attesa_custom_css .='
				#masthead:not(.menuMinor) .nav-middle,
				#masthead:not(.menuMinor) .nav-middle-top-title {
					background-color: '.esc_html($generalOverlayContentToHeaderBackgroundColor).';
				}
			';
		}
		if (attesa_options('_header_format', 'compat') == 'custom') {
			$attesa_custom_css .='
				#masthead:not(.menuMinor) .awp-social-buttons .site-social-elementor a,
				#masthead:not(.menuMinor) .attesa-custom-logo .site-branding .site-description {
					color: '.esc_html($generalOverlayContentToHeaderColor).' !important;
				}
			';
		}
	}
	return $attesa_custom_css;
}
add_action('attesa_custom_css_style_filter', 'attesaextra_fullwidth_and_overlayheader_text_color', 999);

/* Custom header color text if the post overlay the menu */
function attesaextra_post_overlayheader_text_color($attesa_custom_css) {
	if (attesaextra_check_use_post_settings() && !attesaextra_check_for_fullwidth_builders() && get_post_meta(get_the_ID(), '_post_featured_image_style', true) == 'header') {
		$postOverlayContentToHeaderColor = get_post_meta(get_the_ID(), '_post_overlay_contenttoheader_color', true);
		$attesa_custom_css .='
		.attesaFeatBoxTitle .entry-title {
			color: '.esc_html($postOverlayContentToHeaderColor).';
		}';
		if (get_post_meta(get_the_ID(), '_post_overlay_featured_image', true)) {
			$attesa_custom_css .='
			#masthead:not(.menuMinor) .site-branding .site-description,
			#masthead:not(.menuMinor) .attesa-social-header-desktop .site-social-header a,
			#masthead:not(.menuMinor) .attesa-woo-icons-header a,
			#masthead:not(.menuMinor) .cartwoo-button-mobile a,
			#masthead:not(.menuMinor) .cartedd-button-mobile a,
			#masthead:not(.menuMinor) .attesa_float_cart_icon.position_next_main_menu,
			#masthead:not(.menuMinor) button.menu-toggle,
			#masthead:not(.menuMinor) .main-navigation>div>ul>li.attesaMenuButton>a,
			#masthead:not(.menuMinor) .main-navigation>div>ul>li.attesaMenuButton>a:hover,
			#masthead:not(.menuMinor) .main-navigation>div>ul>li.attesaMenuButton>a:focus,
			#masthead:not(.menuMinor) .main-navigation>div>ul>li.attesaMenuButton>a:active,
			.attesaFeatBoxTitle .entry-title {
				color: '.esc_html($postOverlayContentToHeaderColor).';
			}
			@media all and (min-width: 1025px) {
				#masthead:not(.menuMinor) .main-navigation>div>ul>li:not(.attesaMenuButton)>a {
					color: '.esc_html($postOverlayContentToHeaderColor).';
				}
			}
			#masthead:not(.menuMinor) .hamburger-menu .menu__line,
			#masthead:not(.menuMinor) .hamburger-menu .menu__plus,
			body:not(.yesOpenPopupMenu) #masthead:not(.menuMinor) .icon-full-screen .square-full-screen {
				background-color: '.esc_html($postOverlayContentToHeaderColor).';
			}
			#masthead:not(.menuMinor) .hamburger-menu .menu__circle {
				border-color: '.esc_html($postOverlayContentToHeaderColor).';
			}';
		}
		if (attesa_options('_header_format', 'compat') == 'custom') {
			$attesa_custom_css .='
				#masthead:not(.menuMinor) .awp-social-buttons .site-social-elementor a,
				#masthead:not(.menuMinor) .attesa-custom-logo .site-branding .site-description {
					color: '.esc_html($postOverlayContentToHeaderColor).' !important;
				}
			';
		}
	}
	return $attesa_custom_css;
}
add_action('attesa_custom_css_style_filter', 'attesaextra_post_overlayheader_text_color', 999);

/* Custom header color text if the page overlay the menu */
function attesaextra_page_overlayheader_text_color($attesa_custom_css) {
	if (attesaextra_check_use_page_settings() && !attesaextra_check_for_fullwidth_builders() && get_post_meta(get_the_ID(), '_page_featured_image_style', true) == 'header') {
		$pageOverlayContentToHeaderColor = get_post_meta(get_the_ID(), '_page_overlay_contenttoheader_color', true);
		$attesa_custom_css .='
		.attesaFeatBoxTitle .entry-title {
			color: '.esc_html($pageOverlayContentToHeaderColor).';
		}';
		if (get_post_meta(get_the_ID(), '_page_overlay_featured_image', true)) {
			$attesa_custom_css .='
			#masthead:not(.menuMinor) .site-branding .site-description,
			#masthead:not(.menuMinor) .attesa-social-header-desktop .site-social-header a,
			#masthead:not(.menuMinor) .attesa-woo-icons-header a,
			#masthead:not(.menuMinor) .cartwoo-button-mobile a,
			#masthead:not(.menuMinor) .cartedd-button-mobile a,
			#masthead:not(.menuMinor) .attesa_float_cart_icon.position_next_main_menu,
			#masthead:not(.menuMinor) button.menu-toggle,
			#masthead:not(.menuMinor) .main-navigation>div>ul>li.attesaMenuButton>a,
			#masthead:not(.menuMinor) .main-navigation>div>ul>li.attesaMenuButton>a:hover,
			#masthead:not(.menuMinor) .main-navigation>div>ul>li.attesaMenuButton>a:focus,
			#masthead:not(.menuMinor) .main-navigation>div>ul>li.attesaMenuButton>a:active,
			.attesaFeatBoxTitle .entry-title {
				color: '.esc_html($pageOverlayContentToHeaderColor).';
			}
			@media all and (min-width: 1025px) {
				#masthead:not(.menuMinor) .main-navigation>div>ul>li:not(.attesaMenuButton)>a {
					color: '.esc_html($pageOverlayContentToHeaderColor).';
				}
			}
			#masthead:not(.menuMinor) .hamburger-menu .menu__line,
			#masthead:not(.menuMinor) .hamburger-menu .menu__plus,
			body:not(.yesOpenPopupMenu) #masthead:not(.menuMinor) .icon-full-screen .square-full-screen {
				background-color: '.esc_html($pageOverlayContentToHeaderColor).';
			}
			#masthead:not(.menuMinor) .hamburger-menu .menu__circle {
				border-color: '.esc_html($pageOverlayContentToHeaderColor).';
			}';
		}
		if (attesa_options('_header_format', 'compat') == 'custom') {
			$attesa_custom_css .='
				#masthead:not(.menuMinor) .awp-social-buttons .site-social-elementor a,
				#masthead:not(.menuMinor) .attesa-custom-logo .site-branding .site-description {
					color: '.esc_html($pageOverlayContentToHeaderColor).' !important;
				}
			';
		}
	}
	return $attesa_custom_css;
}
add_action('attesa_custom_css_style_filter', 'attesaextra_page_overlayheader_text_color', 999);

/* Filter for attesa_check_bar() with new features*/
add_filter( 'attesa_check_return_filter', 'attesaextra_check_return_filter', 10, 2 );
function attesaextra_check_return_filter($attesa_check_return,$position) {
	if ($position == 'classic' && attesaextra_check_use_custom_settings() && attesaextra_check_for_fullwidth_builders()) {
		$attesa_check_return = false;
	}
	if ($position == 'classic') {
		$whereToShowMeta = get_post_meta(attesaextra_get_the_current_ID(), '_classic_sidebar_position', true);
	} elseif ($position == 'footer') {
		$whereToShowMeta = get_post_meta(attesaextra_get_the_current_ID(), '_footer_widgets_position', true);
	} else {
		$whereToShowMeta = get_post_meta(attesaextra_get_the_current_ID(), '_push_sidebar_position', true);
	}
	if ($whereToShowMeta == 'show') {
		$attesa_check_return = true;
	} elseif ($whereToShowMeta == 'none') {
		$attesa_check_return = false;
	}
	return $attesa_check_return;
}

/* Class for 100% full width page */
function attesaextra_fullwidth_class($classes) {
	if (attesaextra_check_use_custom_settings() && attesaextra_check_for_fullwidth_builders()) {
		$classes[] = 'attesa-full-width';
		if (attesaextra_check_for_overlaytoheader()) {
			$classes[] = 'withOverlayMenu';
		}
	}
	return $classes;
}
add_filter( 'body_class', 'attesaextra_fullwidth_class' );

/* Filter for website structure */
add_filter( 'attesa_website_structure', 'attesaextra_website_structure' );
function attesaextra_website_structure($websiteStructureNoFilter) {
	if (attesaextra_check_use_custom_settings()) {
		$websiteStructure = get_post_meta(attesaextra_get_the_current_ID(), '_website_structure', true);
		return $websiteStructure ? $websiteStructure : $websiteStructureNoFilter;
	}
	return $websiteStructureNoFilter;
}

/* Filter for max width website structure boxed */
add_filter( 'attesa_max_width_structure', 'attesaextra_max_width_structure' );
function attesaextra_max_width_structure($websiteBoxedWidthNoFilter) {
	if (attesaextra_check_use_custom_settings() && get_post_meta(attesaextra_get_the_current_ID(), '_website_structure', true) == 'boxed') {
		$websiteBoxedWidth = get_post_meta(attesaextra_get_the_current_ID(), '_max_width_structure', true);
		return $websiteBoxedWidth ? $websiteBoxedWidth : $websiteBoxedWidthNoFilter;
	}
	return $websiteBoxedWidthNoFilter;
}

/* Filter for border radius */
add_filter( 'attesa_elements_border_radius', 'attesaextra_elements_border_radius' );
function attesaextra_elements_border_radius($borderRadiusNoFilter) {
	if (attesaextra_check_use_custom_settings()) {
		$borderRadius = get_post_meta(attesaextra_get_the_current_ID(), '_elements_border_radius', true);
		return $borderRadius ? $borderRadius : $borderRadiusNoFilter;
	}
	return $borderRadiusNoFilter;
}

/* Filter for max width site content */
add_filter( 'attesa_max_width_site_content', 'attesaextra_max_width_site_content' );
function attesaextra_max_width_site_content($max_widthNoFilter) {
	if (attesaextra_check_use_custom_settings() && !attesaextra_check_for_fullwidth_builders()) {
		$max_width = get_post_meta(attesaextra_get_the_current_ID(), '_max_width_site_content', true);
		return $max_width ? $max_width : $max_widthNoFilter;
	}
	return $max_widthNoFilter;
}

/* Filter for width side content */
add_filter( 'attesa_width_site_content', 'attesaextra_width_site_content' );
function attesaextra_width_site_content($width_contentNoFilter) {
	if (attesaextra_check_use_custom_settings() && !attesaextra_check_for_fullwidth_builders()) {
		$width_content = get_post_meta(attesaextra_get_the_current_ID(), '_max_width_with_sidebar', true);
		return $width_content ? $width_content : $width_contentNoFilter;
	}
	return $width_contentNoFilter;
}

/* Filter for width side content without sidebar */
add_filter( 'attesa_width_site_content_no_sidebar', 'attesaextra_width_site_content_no_sidebar' );
function attesaextra_width_site_content_no_sidebar($width_content_nosidebarNoFilter) {
	if (attesaextra_check_use_custom_settings() && !attesaextra_check_for_fullwidth_builders()) {
		$width_content_nosidebar = get_post_meta(attesaextra_get_the_current_ID(), '_max_width_without_sidebar', true);
		return $width_content_nosidebar ? $width_content_nosidebar : $width_content_nosidebar;
	}
	return $width_content_nosidebarNoFilter;
}

/* Filter for classic sidebar position */
add_filter( 'attesa_classic_sidebar_position', 'attesaextra_classic_sidebar_position' );
function attesaextra_classic_sidebar_position($classicSidebarPositionCode) {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_classic_sidebar_position', true) == 'show') {
		$classicsidebarPositionMeta = get_post_meta(attesaextra_get_the_current_ID(), '_choose_classic_sidebar_position', true);
		if (empty($classicsidebarPositionMeta) || $classicsidebarPositionMeta == 'default') {
			return $classicSidebarPositionCode;
		} elseif ($classicsidebarPositionMeta == 'right') {
			return '#primary.content-area {float: left;}';
		} else {
			return '#primary.content-area {float: right;}';
		}
	}
	return $classicSidebarPositionCode;
}
/* Filter for push sidebar position */
add_filter( 'attesa_push_sidebar_position', 'attesaextra_push_sidebar_position' );
function attesaextra_push_sidebar_position($pushSidebarPositionCode) {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_push_sidebar_position', true) == 'show') {
		$pushsidebarPositionMeta = get_post_meta(attesaextra_get_the_current_ID(), '_choose_push_sidebar_position', true);
		if (empty($pushsidebarPositionMeta) || $pushsidebarPositionMeta == 'default') {
			return $pushSidebarPositionCode;
		} elseif ($pushsidebarPositionMeta == 'right') {
			return '@media all and (min-width: 1025px) {
						body {
							overflow-x: hidden;
						}
						.attesa-site-wrap {
							left: 0
							transition: left .25s ease-in-out;
						}
						body.yesOpen .attesa-site-wrap, 
						body.yesOpen:not(.format_featuredtitle) #masthead {
							left: -150px;
						}
					}
					body.yesOpen #masthead.noSticky,
					body.yesOpen #masthead.relative
					#masthead {
						left: 0;
					}
					#tertiary {
						border-left-width: 3px;
						border-left-style: solid;
						right: -390px;
						transition-property: right;
					}
					#tertiary.yesOpen {
						right: 0;
					}
					@media all and (max-width: 600px) {
						#tertiary{
							right: -100%
						}
					}';
		} else {
			return '@media all and (min-width: 1025px) {
						body {
							overflow-x: hidden;
						}
						.attesa-site-wrap {
							right: 0;
							transition: right .25s ease-in-out;
						}
						body.yesOpen .attesa-site-wrap,
						body.yesOpen:not(.format_featuredtitle) #masthead {
							right: -150px;
						}
					}
					body.yesOpen #masthead.noSticky,
					body.yesOpen #masthead.relative,
					#masthead {
						right: 0;
					}
					#tertiary {
						border-right-width: 3px;
						border-right-style: solid;
						left: -390px;
						transition-property: left;
					}
					#tertiary.yesOpen {
						left: 0;
					}
					@media all and (max-width: 600px) {
						#tertiary{
							left: -100%
						}
					}';
		}
	}
	return $pushSidebarPositionCode;
}
/* Filter for post featured image style */
add_filter('attesa_post_featured_image_style', 'attesaextra_post_featured_image_style');
function attesaextra_post_featured_image_style($featImagePostsNoFilter) {
	if (attesaextra_check_use_post_settings()) {
		$postFeaturedImageStyle = get_post_meta(get_the_ID(), '_post_featured_image_style', true);
		if (empty($postFeaturedImageStyle) || $postFeaturedImageStyle == 'default') {
			return $featImagePostsNoFilter;
		} else {
			return $postFeaturedImageStyle;
		}
	}
	return $featImagePostsNoFilter;
}
/* Filter for post featured image overlay style */
add_filter('attesa_overlay_featured_image_style', 'attesaextra_overlay_featured_image_style');
function attesaextra_overlay_featured_image_style($overlayFeatImageNoFilter) {
	if (attesaextra_check_use_post_settings()) {
		$overlayFeatImage = get_post_meta(get_the_ID(), '_post_overlay_featured_image', true);
		if (empty($overlayFeatImage)) {
			return '';
		} else {
			return '1';
		}
	}
	return $overlayFeatImageNoFilter;
}
/* Filter for post featured image fixed style */
add_filter('attesa_fixed_featured_image_style', 'attesaextra_fixed_featured_image_style');
function attesaextra_fixed_featured_image_style($fixedFeatImageNoFilter) {
	if (attesaextra_check_use_post_settings()) {
		$fixedFeatImage = get_post_meta(get_the_ID(), '_post_fixed_featured_image', true);
		if (empty($fixedFeatImage)) {
			return '';
		} else {
			return '1';
		}
	}
	return $fixedFeatImageNoFilter;
}
/* Filter for post featured image height style */
add_filter('attesa_height_featured_image_style', 'attesaextra_height_featured_image_style');
function attesaextra_height_featured_image_style($heightFeatImageNoFilter) {
	if (attesaextra_check_use_post_settings()) {
		$heightFeatImage = get_post_meta(get_the_ID(), '_post_height_featured_image', true);
		return $heightFeatImage ? $heightFeatImage : $heightFeatImageNoFilter;
	}
	return $heightFeatImageNoFilter;
}
/* Filter for post featured image opacity style */
add_filter('attesa_opacity_featured_image_style', 'attesaextra_opacity_featured_image_style');
function attesaextra_opacity_featured_image_style($featImagePostsOpacityPrint) {
	if (attesaextra_check_use_post_settings()) {
		$featImagePostsOpacity = get_post_meta(get_the_ID(), '_post_opacity_featured_image', true);
		if (empty($featImagePostsOpacity)) {
			return $featImagePostsOpacityPrint;
		} else {
			list($r, $g, $b) = sscanf($featImagePostsOpacity, '#%02x%02x%02x');
			return '.attesaFeatBox .attesaFeatBoxOpacityPost {background-color: rgba('.esc_html($r).', '.esc_html($g).', '.esc_html($b).',0.3)}';
		}
	}
	return $featImagePostsOpacityPrint;
}
/* Filter for post featured image title style */
add_filter('attesa_title_featured_image_style', 'attesaextra_title_featured_image_style');
function attesaextra_title_featured_image_style($featImageTitleNoFilter) {
	if (attesaextra_check_use_post_settings()) {
		$featImageTitle = get_post_meta(get_the_ID(), '_post_featured_title_style', true);
		if (empty($featImageTitle)) {
			return $featImageTitleNoFilter;
		} else {
			return $featImageTitle;
		}
	}
	return $featImageTitleNoFilter;
}
/* Filter for page featured image style */
add_filter('attesa_page_featured_image_style', 'attesaextra_page_featured_image_style');
function attesaextra_page_featured_image_style($featImagePagesNoFilter) {
	if (attesaextra_check_use_page_settings()) {
		$pageFeaturedImageStyle = get_post_meta(get_the_ID(), '_page_featured_image_style', true);
		if (empty($pageFeaturedImageStyle) || $pageFeaturedImageStyle == 'default') {
			return $featImagePagesNoFilter;
		} else {
			return $pageFeaturedImageStyle;
		}
	}
	return $featImagePagesNoFilter;
}
/* Filter for page featured image overlay style */
add_filter('attesa_overlay_featured_image_style_page', 'attesaextra_overlay_featured_image_style_page');
function attesaextra_overlay_featured_image_style_page($overlayFeatImageNoFilter) {
	if (attesaextra_check_use_page_settings()) {
		$overlayFeatImage = get_post_meta(get_the_ID(), '_page_overlay_featured_image', true);
		if (empty($overlayFeatImage)) {
			return '';
		} else {
			return '1';
		}
	}
	return $overlayFeatImageNoFilter;
}
/* Filter for page featured image fixed style */
add_filter('attesa_fixed_featured_image_style_page', 'attesaextra_fixed_featured_image_style_page');
function attesaextra_fixed_featured_image_style_page($fixedFeatImageNoFilter) {
	if (attesaextra_check_use_page_settings()) {
		$fixedFeatImage = get_post_meta(get_the_ID(), '_page_fixed_featured_image', true);
		if (empty($fixedFeatImage)) {
			return '';
		} else {
			return '1';
		}
	}
	return $fixedFeatImageNoFilter;
}
/* Filter for page featured image height style */
add_filter('attesa_height_featured_image_style_page', 'attesaextra_height_featured_image_style_page');
function attesaextra_height_featured_image_style_page($heightFeatImageNoFilter) {
	if (attesaextra_check_use_page_settings()) {
		$heightFeatImage = get_post_meta(get_the_ID(), '_page_height_featured_image', true);
		return $heightFeatImage ? $heightFeatImage : $heightFeatImageNoFilter;
	}
	return $heightFeatImageNoFilter;
}
/* Filter for page featured image opacity style */
add_filter('attesa_opacity_featured_image_style_page', 'attesaextra_opacity_featured_image_style_page');
function attesaextra_opacity_featured_image_style_page($featImagePagesOpacityPrint) {
	if (attesaextra_check_use_page_settings()) {
		$featImagePagesOpacity = get_post_meta(get_the_ID(), '_page_opacity_featured_image', true);
		if (empty($featImagePagesOpacity)) {
			return $featImagePagesOpacityPrint;
		} else {
			list($r, $g, $b) = sscanf($featImagePagesOpacity, '#%02x%02x%02x');
			return '.attesaFeatBox .attesaFeatBoxOpacityPage {background-color: rgba('.esc_html($r).', '.esc_html($g).', '.esc_html($b).',0.3)}';
		}
	}
	return $featImagePagesOpacityPrint;
}
/* Filter for page featured image title style */
add_filter('attesa_title_featured_image_style_page', 'attesaextra_title_featured_image_style_page');
function attesaextra_title_featured_image_style_page($featImageTitleNoFilter) {
	if (attesaextra_check_use_page_settings()) {
		$featImageTitle = get_post_meta(get_the_ID(), '_page_featured_title_style', true);
		if (empty($featImageTitle)) {
			return $featImageTitleNoFilter;
		} else {
			return $featImageTitle;
		}
	}
	return $featImageTitleNoFilter;
}
/* Filter for header style */
add_filter('attesa_header_style', 'attesaextra_header_style');
function attesaextra_header_style($headerStyleNoFilter) {
	if (attesaextra_check_use_header_settings()) {
		$headerStyle = get_post_meta(attesaextra_get_the_current_ID(), '_header_style', true);
		if (empty($headerStyle) || $headerStyle == 'default') {
			return $headerStyleNoFilter;
		} else {
			return $headerStyle;
		}
	}
	return $headerStyleNoFilter;
}
/* Filter for header to fixed when scroll down */
add_filter('attesa_sticky_header_scroll', 'attesaextra_sticky_header_scroll');
function attesaextra_sticky_header_scroll($stickyHeaderNoFilter) {
	if (attesaextra_check_use_header_settings()) {
		$stickyHeader = get_post_meta(attesaextra_get_the_current_ID(), '_sticky_header_scroll', true);
		if (empty($stickyHeader)) {
			return '';
		} else {
			return '1';
		}
	}
	return $stickyHeaderNoFilter;
}
/* Filter for header to fixed when scroll down also on smartphone/tablet */
add_filter('attesa_sticky_header_scroll_mobile', 'attesaextra_sticky_header_scroll_mobile');
function attesaextra_sticky_header_scroll_mobile($stickyHeaderMobileNoFilter) {
	if (attesaextra_check_use_header_settings()) {
		$stickyHeaderMobile = get_post_meta(attesaextra_get_the_current_ID(), '_sticky_header_scroll_mobile', true);
		if (empty($stickyHeaderMobile)) {
			return '';
		} else {
			return '1';
		}
	}
	return $stickyHeaderMobileNoFilter;
}
/* Filter for header to show top nav bar */
add_filter('attesa_show_top_bar', 'attesaextra_show_top_bar');
function attesaextra_show_top_bar($showTopBarNoFilter) {
	if (attesaextra_check_use_header_settings()) {
		$topNav = get_post_meta(attesaextra_get_the_current_ID(), '_use_top_nav', true);
		if (empty($topNav)) {
			return '';
		} else {
			return '1';
		}
	}
	return $showTopBarNoFilter;
}
/* Filter for header to use header colors */
add_filter('attesa_filter_use_header_colors', 'attesaextra_filter_use_header_colors');
function attesaextra_filter_use_header_colors($headerColorsNoFilter) {
	if (attesaextra_edit_header_colors_settings()) {
		return true;
	}
	return $headerColorsNoFilter;
}
/* Filter for top bar style */
add_filter('attesa_topbar_style', 'attesaextra_topbar_style');
function attesaextra_topbar_style($topBarStyleNoFilter) {
	if (attesaextra_check_use_header_settings()) {
		$topBarStyle = get_post_meta(attesaextra_get_the_current_ID(), '_topbar_style', true);
		if (empty($topBarStyle) || $topBarStyle == 'default') {
			return $topBarStyleNoFilter;
		} else {
			return $topBarStyle;
		}
	}
	return $topBarStyleNoFilter;
}
/* Filter for header to show top nav bar also on smartphone/tablet */
add_filter('attesa_show_top_bar_mobile', 'attesaextra_show_top_bar_mobile');
function attesaextra_show_top_bar_mobile($showTopBarMobileNoFilter) {
	if (attesaextra_check_use_header_settings()) {
		$topNavMobile = get_post_meta(attesaextra_get_the_current_ID(), '_use_top_nav_mobile', true);
		if (empty($topNavMobile)) {
			return '';
		} else {
			return '1';
		}
	}
	return $showTopBarMobileNoFilter;
}
/* Filter for header to choose the nav bar scoll */
add_filter('attesa_choose_top_nav', 'attesaextra_choose_top_nav');
function attesaextra_choose_top_nav($topBarScrollNoFilter) {
	if (attesaextra_check_use_header_settings()) {
		$topBarScroll = get_post_meta(attesaextra_get_the_current_ID(), '_scroll_top_nav', true);
		if (empty($topBarScroll) || $topBarScroll == 'default') {
			return $topBarScrollNoFilter;
		} else {
			return $topBarScroll;
		}
	}
	return $topBarScrollNoFilter;
}
/* Filter for header to upload a custom logo */
add_filter('get_custom_logo', 'attesaextra_upload_custom_logo');
function attesaextra_upload_custom_logo($html) {
	if (attesaextra_check_use_header_settings()) {
		$metaLogo = get_post_meta(attesaextra_get_the_current_ID(), '_upload_custom_logo', true);
		if ($metaLogo) {
			$html = '';
			$logo_attributes = array(
				'class'    => 'custom-logo',
			);
			$image_alt = get_post_meta( $metaLogo, '_wp_attachment_image_alt', true );
			if ( empty( $image_alt ) ) {
				$logo_attributes['alt'] = get_bloginfo( 'name', 'display' );
			}
			$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image( $metaLogo, 'full', false, $logo_attributes )
			);
			return $html;
		}
		return $html;
	}
	return $html;
}
/* Filter to upload costom logo on scroll */
add_filter('attesa_logo_on_scroll_filter', 'attesaextra_upload_custom_logo_on_scroll');
function attesaextra_upload_custom_logo_on_scroll($logoOnScrollNoFilter) {
	if (attesaextra_check_use_header_settings()) {
		$logoOnScroll = get_post_meta(attesaextra_get_the_current_ID(), '_upload_custom_logo_on_scroll', true);
		if ($logoOnScroll) {
			$logoOnScrollSrc = wp_get_attachment_image_src( $attachment_id = $logoOnScroll, 'full' );
			return $logoOnScrollSrc[0];
		}
		return $logoOnScrollNoFilter;
	}
	return $logoOnScrollNoFilter;
}
/* Filter for general link color */
add_filter('attesa_general_link_color', 'attesaextra_general_link_color');
function attesaextra_general_link_color($generalLinkColorNoFilter) {
	if (attesaextra_edit_general_colors_settings()) {
		$generalLinkColor = get_post_meta(attesaextra_get_the_current_ID(), '_general_link_color', true);
		return $generalLinkColor ? $generalLinkColor : $generalLinkColorNoFilter;
	}
	return $generalLinkColorNoFilter;
}
/* Filter for general text color */
add_filter('attesa_general_text_color', 'attesaextra_general_text_color');
function attesaextra_general_text_color($generalTextColorNoFilter) {
	if (attesaextra_edit_general_colors_settings()) {
		$generalTextColor = get_post_meta(attesaextra_get_the_current_ID(), '_general_text_color', true);
		return $generalTextColor ? $generalTextColor : $generalTextColorNoFilter;
	}
	return $generalTextColorNoFilter;
}
/* Filter for general background color */
add_filter('attesa_general_background_color', 'attesaextra_general_background_color');
function attesaextra_general_background_color($generalBackgroundColorNoFilter) {
	if (attesaextra_edit_general_colors_settings()) {
		$generalBackgroundColor = get_post_meta(attesaextra_get_the_current_ID(), '_general_background_color', true);
		return $generalBackgroundColor ? $generalBackgroundColor : $generalBackgroundColorNoFilter;
	}
	return $generalBackgroundColorNoFilter;
}
/* Filter for outer background color */
add_filter('attesa_outer_background_color', 'attesaextra_outer_background_color');
function attesaextra_outer_background_color($outerBackgroundColorNoFilter) {
	if (attesaextra_edit_general_colors_settings() && get_post_meta(attesaextra_get_the_current_ID(), '_website_structure', true) == 'boxed') {
		$outerBackgroundColor = get_post_meta(attesaextra_get_the_current_ID(), '_outer_background_color', true);
		return $outerBackgroundColor ? $outerBackgroundColor : $outerBackgroundColorNoFilter;
	}
	return $outerBackgroundColorNoFilter;
}
/* Filter for alternative background color */
add_filter('attesa_alternative_background_color', 'attesaextra_alternative_background_color');
function attesaextra_alternative_background_color($alternativeBackgroundColorNoFilter) {
	if (attesaextra_edit_general_colors_settings()) {
		$alternativeBackgroundColor = get_post_meta(attesaextra_get_the_current_ID(), '_alternative_background_color', true);
		return $alternativeBackgroundColor ? $alternativeBackgroundColor : $alternativeBackgroundColorNoFilter;
	}
	return $alternativeBackgroundColorNoFilter;
}
/* Filter for content text color */
add_filter('attesa_content_text_color', 'attesaextra_content_text_color');
function attesaextra_content_text_color($contentTextColorNoFilter) {
	if (attesaextra_edit_general_colors_settings()) {
		$contentTextColor = get_post_meta(attesaextra_get_the_current_ID(), '_content_text_color', true);
		return $contentTextColor ? $contentTextColor : $contentTextColorNoFilter;
	}
	return $contentTextColorNoFilter;
}
/* Filter for general border color */
add_filter('attesa_general_border_color', 'attesaextra_general_border_color');
function attesaextra_general_border_color($generalBorderColorNoFilter) {
	if (attesaextra_edit_general_colors_settings()) {
		$generalBorderColor = get_post_meta(attesaextra_get_the_current_ID(), '_general_border_color', true);
		return $generalBorderColor ? $generalBorderColor : $generalBorderColorNoFilter;
	}
	return $generalBorderColorNoFilter;
}
/* Filter for topbar background color */
add_filter('attesa_topbar_background_color', 'attesaextra_topbar_background_color');
function attesaextra_topbar_background_color($topbarBackgroundColorNoFilter) {
	if (attesaextra_edit_topbar_colors_settings()) {
		$topbarBackgroundColor = get_post_meta(attesaextra_get_the_current_ID(), '_topbar_background_color', true);
		return $topbarBackgroundColor ? $topbarBackgroundColor : $topbarBackgroundColorNoFilter;
	}
	return $topbarBackgroundColorNoFilter;
}
/* Filter for topbar text color */
add_filter('attesa_topbar_text_color', 'attesaextra_topbar_text_color');
function attesaextra_topbar_text_color($topbarTextColorNoFilter) {
	if (attesaextra_edit_topbar_colors_settings()) {
		$topbarTextColor = get_post_meta(attesaextra_get_the_current_ID(), '_topbar_text_color', true);
		return $topbarTextColor ? $topbarTextColor : $topbarTextColorNoFilter;
	}
	return $topbarTextColorNoFilter;
}
/* Filter for topbar border color */
add_filter('attesa_topbar_border_color', 'attesaextra_topbar_border_color');
function attesaextra_topbar_border_color($topbarBorderColorNoFilter) {
	if (attesaextra_edit_topbar_colors_settings()) {
		$topbarBorderColor = get_post_meta(attesaextra_get_the_current_ID(), '_topbar_border_color', true);
		return $topbarBorderColor ? $topbarBorderColor : $topbarBorderColorNoFilter;
	}
	return $topbarBorderColorNoFilter;
}
/* Filter for header background color */
add_filter('attesa_header_background_color', 'attesaextra_header_background_color');
function attesaextra_header_background_color($headerBackgroundColorNoFilter) {
	if (attesaextra_edit_header_colors_settings()) {
		$headerBackgroundColor = get_post_meta(attesaextra_get_the_current_ID(), '_header_background_color', true);
		return $headerBackgroundColor ? $headerBackgroundColor : $headerBackgroundColorNoFilter;
	}
	return $headerBackgroundColorNoFilter;
}
/* Filter for header link color */
add_filter('attesa_header_link_color', 'attesaextra_header_link_color');
function attesaextra_header_link_color($headerLinkColorNoFilter) {
	if (attesaextra_edit_header_colors_settings()) {
		$headerLinkColor = get_post_meta(attesaextra_get_the_current_ID(), '_header_link_color', true);
		return $headerLinkColor ? $headerLinkColor : $headerLinkColorNoFilter;
	}
	return $headerLinkColorNoFilter;
}
/* Filter for header text color */
add_filter('attesa_header_text_color', 'attesaextra_header_text_color');
function attesaextra_header_text_color($headerTextColorNoFilter) {
	if (attesaextra_edit_header_colors_settings()) {
		$headerTextColor = get_post_meta(attesaextra_get_the_current_ID(), '_header_text_color', true);
		return $headerTextColor ? $headerTextColor : $headerTextColorNoFilter;
	}
	return $headerTextColorNoFilter;
}
/* Filter for classic sidebar link color */
add_filter('attesa_classicsidebar_link_color', 'attesaextra_classicsidebar_link_color');
function attesaextra_classicsidebar_link_color($classicSidebarLinkColorNoFilter) {
	if (attesaextra_edit_classicsidebar_colors_settings()) {
		$classicSidebarLinkColor = get_post_meta(attesaextra_get_the_current_ID(), '_classicsidebar_link_color', true);
		return $classicSidebarLinkColor ? $classicSidebarLinkColor : $classicSidebarLinkColorNoFilter;
	}
	return $classicSidebarLinkColorNoFilter;
}
/* Filter for classic sidebar text color */
add_filter('attesa_classicsidebar_text_color', 'attesaextra_classicsidebar_text_color');
function attesaextra_classicsidebar_text_color($classicSidebarTextColorNoFilter) {
	if (attesaextra_edit_classicsidebar_colors_settings()) {
		$classicSidebarTextColor = get_post_meta(attesaextra_get_the_current_ID(), '_classicsidebar_text_color', true);
		return $classicSidebarTextColor ? $classicSidebarTextColor : $classicSidebarTextColorNoFilter;
	}
	return $classicSidebarTextColorNoFilter;
}
/* Filter for classic sidebar background color */
add_filter('attesa_classicsidebar_background_color', 'attesaextra_classicsidebar_background_color');
function attesaextra_classicsidebar_background_color($classicSidebarBackgroundColorNoFilter) {
	if (attesaextra_edit_classicsidebar_colors_settings()) {
		$classicSidebarBackgroundColor = get_post_meta(attesaextra_get_the_current_ID(), '_classicsidebar_background_color', true);
		return $classicSidebarBackgroundColor ? $classicSidebarBackgroundColor : $classicSidebarBackgroundColorNoFilter;
	}
	return $classicSidebarBackgroundColorNoFilter;
}
/* Filter for classic sidebar border color */
add_filter('attesa_classicsidebar_border_color', 'attesaextra_classicsidebar_border_color');
function attesaextra_classicsidebar_border_color($classicSidebarBorderColorNoFilter) {
	if (attesaextra_edit_classicsidebar_colors_settings()) {
		$classicSidebarBorderColor = get_post_meta(attesaextra_get_the_current_ID(), '_classicsidebar_border_color', true);
		return $classicSidebarBorderColor ? $classicSidebarBorderColor : $classicSidebarBorderColorNoFilter;
	}
	return $classicSidebarBorderColorNoFilter;
}
/* Filter for push sidebar link color */
add_filter('attesa_pushsidebar_link_color', 'attesaextra_pushsidebar_link_color');
function attesaextra_pushsidebar_link_color($pushSidebarLinkColorNoFilter) {
	if (attesaextra_edit_pushsidebar_colors_settings()) {
		$pushSidebarLinkColor = get_post_meta(attesaextra_get_the_current_ID(), '_pushsidebar_link_color', true);
		return $pushSidebarLinkColor ? $pushSidebarLinkColor : $pushSidebarLinkColorNoFilter;
	}
	return $pushSidebarLinkColorNoFilter;
}
/* Filter for push sidebar text color */
add_filter('attesa_pushsidebar_text_color', 'attesaextra_pushsidebar_text_color');
function attesaextra_pushsidebar_text_color($pushSidebarTextColorNoFilter) {
	if (attesaextra_edit_pushsidebar_colors_settings()) {
		$pushSidebarTextColor = get_post_meta(attesaextra_get_the_current_ID(), '_pushsidebar_text_color', true);
		return $pushSidebarTextColor ? $pushSidebarTextColor : $pushSidebarTextColorNoFilter;
	}
	return $pushSidebarTextColorNoFilter;
}
/* Filter for push sidebar background color */
add_filter('attesa_pushsidebar_background_color', 'attesaextra_pushsidebar_background_color');
function attesaextra_pushsidebar_background_color($pushSidebarBackgroundColorNoFilter) {
	if (attesaextra_edit_pushsidebar_colors_settings()) {
		$pushSidebarBackgroundColor = get_post_meta(attesaextra_get_the_current_ID(), '_pushsidebar_background_color', true);
		return $pushSidebarBackgroundColor ? $pushSidebarBackgroundColor : $pushSidebarBackgroundColorNoFilter;
	}
	return $pushSidebarBackgroundColorNoFilter;
}
/* Filter for push sidebar border color */
add_filter('attesa_pushsidebar_border_color', 'attesaextra_pushsidebar_border_color');
function attesaextra_pushsidebar_border_color($pushSidebarBorderColorNoFilter) {
	if (attesaextra_edit_pushsidebar_colors_settings()) {
		$pushSidebarBorderColor = get_post_meta(attesaextra_get_the_current_ID(), '_pushsidebar_border_color', true);
		return $pushSidebarBorderColor ? $pushSidebarBorderColor : $pushSidebarBorderColorNoFilter;
	}
	return $pushSidebarBorderColorNoFilter;
}
/* Filter for footer link color */
add_filter('attesa_footer_link_color', 'attesaextra_footer_link_color');
function attesaextra_footer_link_color($footerLinkColorNoFilter) {
	if (attesaextra_edit_footer_colors_settings()) {
		$footerLinkColor = get_post_meta(attesaextra_get_the_current_ID(), '_footer_link_color', true);
		return $footerLinkColor ? $footerLinkColor : $footerLinkColorNoFilter;
	}
	return $footerLinkColorNoFilter;
}
/* Filter for footer text color */
add_filter('attesa_footer_text_color', 'attesaextra_footer_text_color');
function attesaextra_footer_text_color($footerTextColorNoFilter) {
	if (attesaextra_edit_footer_colors_settings()) {
		$footerTextColor = get_post_meta(attesaextra_get_the_current_ID(), '_footer_text_color', true);
		return $footerTextColor ? $footerTextColor : $footerTextColorNoFilter;
	}
	return $footerTextColorNoFilter;
}
/* Filter for footer background color */
add_filter('attesa_footer_background_color', 'attesaextra_footer_background_color');
function attesaextra_footer_background_color($footerBackgroundColorNoFilter) {
	if (attesaextra_edit_footer_colors_settings()) {
		$footerBackgroundColor = get_post_meta(attesaextra_get_the_current_ID(), '_footer_background_color', true);
		return $footerBackgroundColor ? $footerBackgroundColor : $footerBackgroundColorNoFilter;
	}
	return $footerBackgroundColorNoFilter;
}
/* Filter for footer border color */
add_filter('attesa_footer_border_color', 'attesaextra_footer_border_color');
function attesaextra_footer_border_color($footerBorderColorNoFilter) {
	if (attesaextra_edit_footer_colors_settings()) {
		$footerBorderColor = get_post_meta(attesaextra_get_the_current_ID(), '_footer_border_color', true);
		return $footerBorderColor ? $footerBorderColor : $footerBorderColorNoFilter;
	}
	return $footerBorderColorNoFilter;
}
/* Filter for subfooter background color */
add_filter('attesa_subfooter_background_color', 'attesaextra_subfooter_background_color');
function attesaextra_subfooter_background_color($subFooterBackgroundColorNoFilter) {
	if (attesaextra_edit_footer_colors_settings()) {
		$subFooterBackgroundColor = get_post_meta(attesaextra_get_the_current_ID(), '_subfooter_background_color', true);
		return $subFooterBackgroundColor ? $subFooterBackgroundColor : $subFooterBackgroundColorNoFilter;
	}
	return $subFooterBackgroundColorNoFilter;
}
/* Filter for subfooter text color */
add_filter('attesa_subfooter_text_color', 'attesaextra_subfooter_text_color');
function attesaextra_subfooter_text_color($subFooterTextColorNoFilter) {
	if (attesaextra_edit_footer_colors_settings()) {
		$subFooterTextColor = get_post_meta(attesaextra_get_the_current_ID(), '_subfooter_text_color', true);
		return $subFooterTextColor ? $subFooterTextColor : $subFooterTextColorNoFilter;
	}
	return $subFooterTextColorNoFilter;
}
/* Filter for subfooter link color */
add_filter('attesa_subfooter_link_color', 'attesaextra_subfooter_link_color');
function attesaextra_subfooter_link_color($subFooterLinkColorNoFilter) {
	if (attesaextra_edit_footer_colors_settings()) {
		$subFooterLinkColor = get_post_meta(attesaextra_get_the_current_ID(), '_subfooter_link_color', true);
		return $subFooterLinkColor ? $subFooterLinkColor : $subFooterLinkColorNoFilter;
	}
	return $subFooterLinkColorNoFilter;
}
/* Action for shortcode before site content */
add_action('attesa_before_site_content', 'attesaextra_before_site_content');
function attesaextra_before_site_content() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_before_site_content', true)) {
		echo do_shortcode(wp_kses_post(get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_before_site_content', true)));
	}
}
/* Action for shortcode after site content */
add_action('attesa_after_site_content', 'attesaextra_after_site_content');
function attesaextra_after_site_content() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_after_site_content', true)) {
		echo do_shortcode(wp_kses_post(get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_after_site_content', true)));
	}
}
/* Filter for shortcode before page content */
add_filter('the_content', 'attesaextra_before_page_content' );
function attesaextra_before_page_content($content) {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_before_page_content', true)) {
		$attesaextra_shortcode_before_page_content = do_shortcode(wp_kses_post(get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_before_page_content', true)));
		$content = $attesaextra_shortcode_before_page_content . $content;
	}
	return $content;
}
/* Filter for shortcode after page content */
add_filter('the_content', 'attesaextra_after_page_content' );
function attesaextra_after_page_content($content) {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_after_page_content', true)) {
		$attesaextra_shortcode_after_page_content = do_shortcode(wp_kses_post(get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_after_page_content', true)));
		$content .= $attesaextra_shortcode_after_page_content;
	}
	return $content;
}
/* Action for shortcode before classic sidebar */
add_action('attesa_before_classic_sidebar', 'attesaextra_before_classic_sidebar');
function attesaextra_before_classic_sidebar() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_before_classic_side', true)) {
		echo do_shortcode(wp_kses_post(get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_before_classic_side', true)));
	}
}
/* Action for shortcode after classic sidebar */
add_action('attesa_after_classic_sidebar', 'attesaextra_after_classic_sidebar');
function attesaextra_after_classic_sidebar() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_after_classic_side', true)) {
		echo do_shortcode(wp_kses_post(get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_after_classic_side', true)));
	}
}
/* Action for shortcode before push sidebar */
add_action('attesa_before_push_sidebar', 'attesaextra_before_push_sidebar');
function attesaextra_before_push_sidebar() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_before_push_side', true)) {
		echo do_shortcode(wp_kses_post(get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_before_push_side', true)));
	}
}
/* Action for shortcode after push sidebar */
add_action('attesa_after_push_sidebar', 'attesaextra_after_push_sidebar');
function attesaextra_after_push_sidebar() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_after_push_side', true)) {
		echo do_shortcode(wp_kses_post(get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_after_push_side', true)));
	}
}
/* Action for shortcode before footer widgets */
add_action('attesa_before_footer_widgets', 'attesaextra_before_footer_widgets');
function attesaextra_before_footer_widgets() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_before_footer_wid', true)) {
		echo do_shortcode(wp_kses_post(get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_before_footer_wid', true)));
	}
}
/* Action for shortcode after footer widgets */
add_action('attesa_after_footer_widgets', 'attesaextra_after_footer_widgets');
function attesaextra_after_footer_widgets() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_after_footer_wid', true)) {
		echo do_shortcode(wp_kses_post(get_post_meta(attesaextra_get_the_current_ID(), '_shortcode_after_footer_wid', true)));
	}
}

/* Filter for Breadcrumb */
add_filter('attesa_the_breadcrumb_filter', 'attesaextra_the_breadcrumb_filter' );
function attesaextra_the_breadcrumb_filter($true) {
	if (attesaextra_check_use_custom_settings()) {
		$yoast_breadcrumb_filter = get_post_meta(attesaextra_get_the_current_ID(), '_show_yoast_breadcrumb', true);
		if (attesaextra_check_for_fullwidth_builders() || $yoast_breadcrumb_filter == 'hide' ) {
			return false;
		}
	}
	return $true;
}