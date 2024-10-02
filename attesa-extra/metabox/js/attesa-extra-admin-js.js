( function( $ ) {
	"use strict";

	$( document ).on( 'ready', function() {		
		/* General Settings */
		
		/* Hide/Show for custom settings general */
		var general_use_custom_settings = $('#butterbean-control-_general_use_custom_settings input'),
			general_use_custom_settings_items = $('#butterbean-control-_general_use_full_width_builders, #butterbean-control-_general_overlay_contenttoheader, #butterbean-control-_general_overlay_contenttoheader_color, #butterbean-control-_general_overlay_contentbackground, #butterbean-control-_website_structure, #butterbean-control-_max_width_structure, #butterbean-control-_elements_border_radius, #butterbean-control-_max_width_site_content, #butterbean-control-_max_width_with_sidebar, #butterbean-control-_max_width_without_sidebar, #butterbean-control-_use_share_buttons, #butterbean-control-_use_contact_buttons, #butterbean-control-_show_yoast_breadcrumb');
			
		general_use_custom_settings_items.hide();
		
		if ( general_use_custom_settings.is(":checked") ) {
			general_use_custom_settings_items.show('fast');
		}
		
		general_use_custom_settings.change( function () {
			general_use_custom_settings_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				general_use_custom_settings_items.show('fast');
			}
		} );
		
		/* If set 100% full width for page builders */
		var general_use_full_width_builders = $('#butterbean-control-_general_use_full_width_builders input'),
			general_use_full_width_builders_items = $('#butterbean-control-_max_width_site_content .attesa-mb-field, #butterbean-control-_max_width_with_sidebar .attesa-mb-field, #butterbean-control-_max_width_without_sidebar .attesa-mb-field, #butterbean-control-_classic_sidebar_position .attesa-mb-field, #butterbean-control-_show_yoast_breadcrumb .attesa-mb-field'),
			general_use_full_width_builders_itemsVisible = $('#butterbean-control-_general_overlay_contenttoheader .attesa-mb-field');
			
		general_use_full_width_builders_itemsVisible.hide();
			
		if ( general_use_full_width_builders.is(":checked") ) {
			general_use_full_width_builders_items.hide('fast');
			general_use_full_width_builders_itemsVisible.show('fast');
		}
		
		general_use_full_width_builders.change( function () {
			general_use_full_width_builders_items.show('fast');
			general_use_full_width_builders_itemsVisible.hide('fast');
			if ( $( this ).is(":checked") ) {
				general_use_full_width_builders_items.hide('fast');
				general_use_full_width_builders_itemsVisible.show('fast');
			}
		} );
		
		/* If set overlay header for page builders */
		var use_overlay_header_full_width = $('#butterbean-control-_general_overlay_contenttoheader input'),
			use_overlay_header_full_width_items = $('#butterbean-control-_general_overlay_contenttoheader_color .attesa-mb-field, #butterbean-control-_general_overlay_contentbackground .attesa-mb-field');
		
		use_overlay_header_full_width_items.hide();
		
		if ( use_overlay_header_full_width.is(":checked") ) {
			use_overlay_header_full_width_items.show('fast');
		}
		
		use_overlay_header_full_width.change( function () {
			use_overlay_header_full_width_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				use_overlay_header_full_width_items.show('fast');
			}
		} );
		
		/* Hide/Show for website structure */
		var choose_website_structure = $('#butterbean-control-_website_structure select'),
			choose_website_structure_val = choose_website_structure.val(),
			choose_website_structure_items = $('#butterbean-control-_max_width_structure .attesa-mb-field');
			
		choose_website_structure_items.hide();
		
		if ( choose_website_structure_val === 'boxed' ) {
			choose_website_structure_items.show('fast');
		}
		
		choose_website_structure.change( function () {
			choose_website_structure_items.hide('fast');
			if ( $( this ).val() == 'boxed' ) {
				choose_website_structure_items.show('fast');
			}
		} );
		
		
		/* Widgets Settings */
		var classic_sidebar_position = $('#butterbean-control-_classic_sidebar_position select'),
			classic_sidebar_position_val = classic_sidebar_position.val(),
			choose_sidebar_position_classic = $('#butterbean-control-_choose_classic_sidebar_position .attesa-mb-field, #butterbean-control-_choose_classic_sidebar_area .attesa-mb-field'),
			push_sidebar_position = $('#butterbean-control-_push_sidebar_position select'),
			push_sidebar_position_val = push_sidebar_position.val(),
			choose_sidebar_position_push = $('#butterbean-control-_choose_push_sidebar_position .attesa-mb-field, #butterbean-control-_choose_push_sidebar_area .attesa-mb-field');
			
		choose_sidebar_position_classic.hide();
		choose_sidebar_position_push.hide();
		
		if ( classic_sidebar_position_val === 'show' ) {
			choose_sidebar_position_classic.show('fast');
		}
		if ( push_sidebar_position_val === 'show' ) {
			choose_sidebar_position_push.show('fast');
		}
		
		classic_sidebar_position.change( function () {
			choose_sidebar_position_classic.hide('fast');
			if ( $( this ).val() == 'show' ) {
				choose_sidebar_position_classic.show('fast');
			}
		} );
		
		push_sidebar_position.change( function () {
			choose_sidebar_position_push.hide('fast');
			if ( $( this ).val() == 'show' ) {
				choose_sidebar_position_push.show('fast');
			}
		} );
		
		/* Header Settings */
		/* Hide/Show for use custom button header */
		var custom_button_header = $('#butterbean-control-_header_use_custom_settings input'),
			custom_button_header_items = $('#butterbean-control-_header_style, #butterbean-control-_sticky_header_scroll, #butterbean-control-_sticky_header_scroll_mobile, #butterbean-control-_use_top_nav, #butterbean-control-_use_top_nav_mobile, #butterbean-control-_topbar_style, #butterbean-control-_scroll_top_nav, #butterbean-control-_upload_custom_logo, #butterbean-control-_upload_custom_logo_on_scroll');
			
		custom_button_header_items.hide();
		
		if ( custom_button_header.is(":checked") ) {
			custom_button_header_items.show('fast');
		}
		
		custom_button_header.change( function () {
			custom_button_header_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				custom_button_header_items.show('fast');
			}
		} );
		
		/* Hide/Show for sticky header also on tablet/smartphone */
		var sticky_header_settings = $('#butterbean-control-_sticky_header_scroll input'),
			sticky_header_settings_items = $('#butterbean-control-_sticky_header_scroll_mobile .attesa-mb-field, #butterbean-control-_upload_custom_logo_on_scroll .attesa-mb-field');
			
		sticky_header_settings_items.hide();
		
		if ( sticky_header_settings.is(":checked") ) {
			sticky_header_settings_items.show('fast');
		}
		
		sticky_header_settings.change( function () {
			sticky_header_settings_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				sticky_header_settings_items.show('fast');
			}
		} );
		
		/* Hide/Show for top bar */
		var use_top_nav = $('#butterbean-control-_use_top_nav input'),
			choose_top_nav = $('#butterbean-control-_use_top_nav_mobile .attesa-mb-field, #butterbean-control-_topbar_style .attesa-mb-field, #butterbean-control-_scroll_top_nav .attesa-mb-field');
			
		choose_top_nav.hide();
		
		if ( use_top_nav.is(":checked") ) {
			choose_top_nav.show('fast');
		}
		
		use_top_nav.change( function () {
			choose_top_nav.hide('fast');
			if ( $( this ).is(":checked") ) {
				choose_top_nav.show('fast');
			}
		} );
		
		/* Post Settings */
		/* Hide/Show for custom settings post */
		var post_use_custom_settings = $('#butterbean-control-_post_use_custom_settings input'),
			post_use_custom_settings_items = $('#butterbean-control-_post_featured_image_style, #butterbean-control-_post_overlay_featured_image, #butterbean-control-_post_fixed_featured_image, #butterbean-control-_post_height_featured_image, #butterbean-control-_post_opacity_featured_image, #butterbean-control-_post_overlay_contenttoheader_color, #butterbean-control-_post_featured_title_style, #butterbean-control-_use_custom_header_button_post, #butterbean-control-_text_custom_header_button_post, #butterbean-control-_url_custom_header_button_post, #butterbean-control-_open_custom_header_button_post');
			
		post_use_custom_settings_items.hide();
		
		if ( post_use_custom_settings.is(":checked") ) {
			post_use_custom_settings_items.show('fast');
		}
		
		post_use_custom_settings.change( function () {
			post_use_custom_settings_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				post_use_custom_settings_items.show('fast');
			}
		} );
		
		/* Hide/Show for big featured images post */
		var big_featured_image_post = $('#butterbean-control-_post_featured_image_style select'),
			big_featured_image_post_val = big_featured_image_post.val(),
			choose_big_featured_image_post = $('#butterbean-control-_post_overlay_featured_image .attesa-mb-field, #butterbean-control-_post_fixed_featured_image .attesa-mb-field, #butterbean-control-_post_height_featured_image .attesa-mb-field, #butterbean-control-_post_opacity_featured_image .attesa-mb-field, #butterbean-control-_post_overlay_contenttoheader_color .attesa-mb-field, #butterbean-control-_post_featured_title_style .attesa-mb-field, #butterbean-control-_use_custom_header_button_post .attesa-mb-field');
			
		choose_big_featured_image_post.hide();
		
		if ( big_featured_image_post_val === 'header' ) {
			choose_big_featured_image_post.show('fast');
		}
		
		big_featured_image_post.change( function () {
			choose_big_featured_image_post.hide('fast');
			if ( $( this ).val() == 'header' ) {
				choose_big_featured_image_post.show('fast');
			}
		} );
		
		/* Hide/Show for use custom buttons in post */
		var post_use_custom_button = $('#butterbean-control-_use_custom_header_button_post input'),
			post_use_custom_button_items = $('#butterbean-control-_text_custom_header_button_post .attesa-mb-field, #butterbean-control-_url_custom_header_button_post .attesa-mb-field, #butterbean-control-_open_custom_header_button_post .attesa-mb-field');
			
		post_use_custom_button_items.hide();
		
		if ( post_use_custom_button.is(":checked") ) {
			post_use_custom_button_items.show('fast');
		}
		
		post_use_custom_button.change( function () {
			post_use_custom_button_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				post_use_custom_button_items.show('fast');
			}
		} );
		
		/* Page Settings */
		/* Hide/Show for custom settings page */
		var page_use_custom_settings = $('#butterbean-control-_page_use_custom_settings input'),
			page_use_custom_settings_items = $('#butterbean-control-_page_featured_image_style, #butterbean-control-_page_overlay_featured_image, #butterbean-control-_page_fixed_featured_image, #butterbean-control-_page_height_featured_image, #butterbean-control-_page_opacity_featured_image, #butterbean-control-_page_overlay_contenttoheader_color, #butterbean-control-_page_featured_title_style, #butterbean-control-_use_custom_header_button_page, #butterbean-control-_text_custom_header_button_page, #butterbean-control-_url_custom_header_button_page, #butterbean-control-_open_custom_header_button_page');
			
		page_use_custom_settings_items.hide();
		
		if ( page_use_custom_settings.is(":checked") ) {
			page_use_custom_settings_items.show('fast');
		}
		
		page_use_custom_settings.change( function () {
			page_use_custom_settings_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				page_use_custom_settings_items.show('fast');
			}
		} );
		
		/* Hide/Show for big featured images page */
		var big_featured_image_page = $('#butterbean-control-_page_featured_image_style select'),
			big_featured_image_page_val = big_featured_image_page.val(),
			choose_big_featured_image_page = $('#butterbean-control-_page_overlay_featured_image .attesa-mb-field, #butterbean-control-_page_fixed_featured_image .attesa-mb-field, #butterbean-control-_page_height_featured_image .attesa-mb-field, #butterbean-control-_page_opacity_featured_image .attesa-mb-field, #butterbean-control-_page_overlay_contenttoheader_color .attesa-mb-field, #butterbean-control-_page_featured_title_style .attesa-mb-field, #butterbean-control-_use_custom_header_button_page .attesa-mb-field');
			
		choose_big_featured_image_page.hide();
		
		if ( big_featured_image_page_val === 'header' ) {
			choose_big_featured_image_page.show('fast');
		}
		
		big_featured_image_page.change( function () {
			choose_big_featured_image_page.hide('fast');
			if ( $( this ).val() == 'header' ) {
				choose_big_featured_image_page.show('fast');
			}
		} );
		
		/* Hide/Show for use custom buttons in page */
		var page_use_custom_button = $('#butterbean-control-_use_custom_header_button_page input'),
			page_use_custom_button_items = $('#butterbean-control-_text_custom_header_button_page .attesa-mb-field, #butterbean-control-_url_custom_header_button_page .attesa-mb-field, #butterbean-control-_open_custom_header_button_page .attesa-mb-field');
			
		page_use_custom_button_items.hide();
		
		if ( page_use_custom_button.is(":checked") ) {
			page_use_custom_button_items.show('fast');
		}
		
		page_use_custom_button.change( function () {
			page_use_custom_button_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				page_use_custom_button_items.show('fast');
			}
		} );
		
		/* Colors Settings */
		/* Hide/Show for colors settings page */
		var colors_use_custom_settings = $('#butterbean-control-_color_use_custom_settings input'),
			colors_use_custom_settings_items = $('#butterbean-control-_color_use_general_color, #butterbean-control-_outer_background_color, #butterbean-control-_general_background_color, #butterbean-control-_alternative_background_color, #butterbean-control-_general_text_color, #butterbean-control-_content_text_color, #butterbean-control-_general_link_color, #butterbean-control-_general_border_color, #butterbean-control-_color_use_topnav_color, #butterbean-control-_topbar_background_color, #butterbean-control-_topbar_text_color, #butterbean-control-_topbar_border_color, #butterbean-control-_color_use_header_color, #butterbean-control-_header_text_color, #butterbean-control-_header_background_color, #butterbean-control-_header_link_color, #butterbean-control-_color_use_classic_sidebar_color, #butterbean-control-_classicsidebar_background_color, #butterbean-control-_classicsidebar_text_color, #butterbean-control-_classicsidebar_link_color, #butterbean-control-_classicsidebar_border_color, #butterbean-control-_color_use_push_sidebar_color, #butterbean-control-_pushsidebar_background_color, #butterbean-control-_pushsidebar_text_color, #butterbean-control-_pushsidebar_link_color, #butterbean-control-_pushsidebar_border_color, #butterbean-control-_color_use_footer_color, #butterbean-control-_footer_background_color, #butterbean-control-_footer_text_color, #butterbean-control-_footer_link_color, #butterbean-control-_footer_border_color, #butterbean-control-_subfooter_background_color, #butterbean-control-_subfooter_text_color, #butterbean-control-_subfooter_link_color');
			
		colors_use_custom_settings_items.hide();
		
		if ( colors_use_custom_settings.is(":checked") ) {
			colors_use_custom_settings_items.show('fast');
		}
		
		colors_use_custom_settings.change( function () {
			colors_use_custom_settings_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				colors_use_custom_settings_items.show('fast');
			}
		} );
		
		/* Hide/Show for edit general colors */
		var custom_general_colors_settings = $('#butterbean-control-_color_use_general_color input'),
			custom_general_colors_settings_items = $('#butterbean-control-_outer_background_color .attesa-mb-field, #butterbean-control-_general_background_color .attesa-mb-field, #butterbean-control-_alternative_background_color .attesa-mb-field, #butterbean-control-_general_text_color .attesa-mb-field, #butterbean-control-_content_text_color .attesa-mb-field, #butterbean-control-_general_link_color .attesa-mb-field, #butterbean-control-_general_border_color .attesa-mb-field');
			
		custom_general_colors_settings_items.hide();
		
		if ( custom_general_colors_settings.is(":checked") ) {
			custom_general_colors_settings_items.show('fast');
		}
		
		custom_general_colors_settings.change( function () {
			custom_general_colors_settings_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				custom_general_colors_settings_items.show('fast');
			}
		} );
		
		/* Hide/Show for edit topbar colors */
		var custom_top_colors_settings = $('#butterbean-control-_color_use_topnav_color input'),
			custom_top_colors_settings_items = $('#butterbean-control-_topbar_background_color .attesa-mb-field, #butterbean-control-_topbar_text_color .attesa-mb-field, #butterbean-control-_topbar_border_color .attesa-mb-field');
			
		custom_top_colors_settings_items.hide();
		
		if ( custom_top_colors_settings.is(":checked") ) {
			custom_top_colors_settings_items.show('fast');
		}
		
		custom_top_colors_settings.change( function () {
			custom_top_colors_settings_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				custom_top_colors_settings_items.show('fast');
			}
		} );
		
		/* Hide/Show for edit header colors */
		var custom_header_colors_settings = $('#butterbean-control-_color_use_header_color input'),
			custom_header_colors_settings_items = $('#butterbean-control-_header_background_color .attesa-mb-field, #butterbean-control-_header_text_color .attesa-mb-field, #butterbean-control-_header_link_color .attesa-mb-field');
			
		custom_header_colors_settings_items.hide();
		
		if ( custom_header_colors_settings.is(":checked") ) {
			custom_header_colors_settings_items.show('fast');
		}
		
		custom_header_colors_settings.change( function () {
			custom_header_colors_settings_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				custom_header_colors_settings_items.show('fast');
			}
		} );
		
		/* Hide/Show for edit classic sidebar colors */
		var custom_classicsidebar_colors_settings = $('#butterbean-control-_color_use_classic_sidebar_color input'),
			custom_classicsidebar_colors_settings_items = $('#butterbean-control-_classicsidebar_background_color .attesa-mb-field, #butterbean-control-_classicsidebar_text_color .attesa-mb-field, #butterbean-control-_classicsidebar_link_color .attesa-mb-field, #butterbean-control-_classicsidebar_border_color .attesa-mb-field');
			
		custom_classicsidebar_colors_settings_items.hide();
		
		if ( custom_classicsidebar_colors_settings.is(":checked") ) {
			custom_classicsidebar_colors_settings_items.show('fast');
		}
		
		custom_classicsidebar_colors_settings.change( function () {
			custom_classicsidebar_colors_settings_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				custom_classicsidebar_colors_settings_items.show('fast');
			}
		} );
		
		/* Hide/Show for edit push sidebar colors */
		var custom_pushsidebar_colors_settings = $('#butterbean-control-_color_use_push_sidebar_color input'),
			custom_pushsidebar_colors_settings_items = $('#butterbean-control-_pushsidebar_background_color .attesa-mb-field, #butterbean-control-_pushsidebar_text_color .attesa-mb-field, #butterbean-control-_pushsidebar_link_color .attesa-mb-field, #butterbean-control-_pushsidebar_border_color .attesa-mb-field');
			
		custom_pushsidebar_colors_settings_items.hide();
		
		if ( custom_pushsidebar_colors_settings.is(":checked") ) {
			custom_pushsidebar_colors_settings_items.show('fast');
		}
		
		custom_pushsidebar_colors_settings.change( function () {
			custom_pushsidebar_colors_settings_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				custom_pushsidebar_colors_settings_items.show('fast');
			}
		} );
		
		/* Hide/Show for edit footer colors */
		var custom_footer_colors_settings = $('#butterbean-control-_color_use_footer_color input'),
			custom_footer_colors_settings_items = $('#butterbean-control-_footer_background_color .attesa-mb-field, #butterbean-control-_footer_text_color .attesa-mb-field, #butterbean-control-_footer_link_color .attesa-mb-field, #butterbean-control-_footer_border_color .attesa-mb-field, #butterbean-control-_subfooter_background_color .attesa-mb-field, #butterbean-control-_subfooter_text_color .attesa-mb-field, #butterbean-control-_subfooter_link_color .attesa-mb-field');
			
		custom_footer_colors_settings_items.hide();
		
		if ( custom_footer_colors_settings.is(":checked") ) {
			custom_footer_colors_settings_items.show('fast');
		}
		
		custom_footer_colors_settings.change( function () {
			custom_footer_colors_settings_items.hide('fast');
			if ( $( this ).is(":checked") ) {
				custom_footer_colors_settings_items.show('fast');
			}
		} );
		
		/* Hide/Show for footer callout */
		var footer_callout_setting = $('#butterbean-control-_use_footer_callout select'),
			footer_callout_setting_val = footer_callout_setting.val(),
			footer_callout_setting_choose = $('#butterbean-control-_footer_callout_text, #butterbean-control-_footer_callout_subtext, #butterbean-control-_footer_callout_text_button, #butterbean-control-_footer_callout_link_button, #butterbean-control-_footer_callout_shortcode, #butterbean-control-_footer_callout_block_style, #butterbean-control-_footer_callout_open_button, #butterbean-control-_footer_callout_padding, #butterbean-control-_footer_callout_background_color, #butterbean-control-_footer_callout_text_color, #butterbean-control-_footer_callout_button_color, #butterbean-control-_footer_callout_image, #butterbean-control-_footer_callout_image_alignment, #butterbean-control-_footer_callout_image_max_height'),
			footer_callout_settings_custom_template = $('#butterbean-control-_footer_callout_get_attesa_template');
			
		footer_callout_setting_choose.hide();
		footer_callout_settings_custom_template.hide();
		
		if ( footer_callout_setting_val === 'custom' ) {
			footer_callout_setting_choose.show('fast');
		}
		
		if ( footer_callout_setting_val === 'custom_template' ) {
			footer_callout_settings_custom_template.show('fast');
		}
		
		footer_callout_setting.change( function () {
			footer_callout_setting_choose.hide('fast');
			footer_callout_settings_custom_template.hide('fast');
			if ( $( this ).val() == 'custom' ) {
				footer_callout_setting_choose.show('fast');
			}
			if ( $( this ).val() == 'custom_template' ) {
				footer_callout_settings_custom_template.show('fast');
			}
		} );
		
	} );

} ) ( jQuery );