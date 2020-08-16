<?php

global $aemi_version;

$theme = wp_get_theme('aemi');
$aemi_version = $theme['Version'];


if (!function_exists('aemi_content_width'))
{
	function aemi_content_width()
	{
		$GLOBALS['content_width'] = apply_filters('aemi_content_width', 1024);
	}
}


if (!function_exists('aemi_setup'))
{
	function aemi_setup()
	{
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		// add_image_size('aemi-4k', 4096, 2160, false);
		// add_image_size('aemi-uhd', 3840, 2160, false);
		add_image_size('aemi-large', 1920, 1200, false);
		add_image_size('aemi-fhd', 1920, 1080, false);
		add_image_size('aemi-hd', 1280, 720, false);
		add_image_size('aemi-mid', 720, 480, false);
		add_image_size('aemi-small', 640, 360, false);
		add_image_size('aemi-tiny', 320, 240, false);
		add_image_size('aemi-thumb', 300, 300, false);
		add_image_size('aemi-logo', 92, 276, false);

		register_nav_menus(
			[
				'header-menu'	=> __('Header Menu', 'aemi'),
				'overlay-menu'	=> __('Overlay Menu', 'aemi'),
				'social-menu'	=> __('Social Menu', 'aemi'),
				'footer-menu'	=> __('Footer Menu', 'aemi'),
			]
		);

		add_theme_support( 'html5' );

		add_theme_support(
			'custom-background',
			apply_filters(
				'aemi_custom_background_args',
				[
					'default-color' => '#ffffff',
					'default-image' => ''
				]
			)
		);

		add_theme_support('custom-header', [
			'default-image'          => '',
			'width'                  => 2880,
			'height'                 => 172,
			'flex-height'            => true,
			'flex-width'             => true,
			'uploads'                => true,
			'random-default'         => false,
			'header-text'            => false,
			'default-text-color'     => '',
			'wp-head-callback'       => '',
			'admin-head-callback'    => '',
			'admin-preview-callback' => '',
		]);

		add_theme_support('site-logo');

		add_theme_support('custom-logo', [
			'height'      => 92,
			'width'		  => 276,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => [],
		]);

		add_editor_style([ 'assets/editor-style.css' ]);

		$starter_content = apply_filters('aemi_starter_content', [
			'widgets' => [
				'header-widget-area' => [ 'search' ],
				'footer-widget-area' => [ '' ]
			]
		]);
		add_theme_support('starter-content', $starter_content);
	}
}

if (!function_exists('aemi_header_menu_filter'))
{
	function aemi_header_menu_filter($items, $args)
	{
    	if ($args->theme_location == 'header-menu')
    	{
    	    $top_level_links = 0;
    	    foreach ($items as $key => $item)
    	    {
    	        if ($item->menu_item_parent == 0)
    	        {
    	            $top_level_links++;
    	        }
    	        if ($top_level_links > 3)
    	        {
    	            unset($items[$key]);
    	        }
    	    }
    	}
    	return $items;
	}
}

if (!function_exists('aemi_tagcount_filter'))
{
	function aemi_tagcount_filter($variable)
	{
		$variable = str_replace('<span class="tag-link-count"> (', '<span class="tag-link-count">&bull;', $variable);
		$variable = str_replace(')</span>', '</span>', $variable);
		return $variable;
	}
}


if ( ! function_exists( 'aemi_pingback_header' ) )
{
	function aemi_pingback_header()
	{
		if ( is_singular() && pings_open() )
		{
			echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
		}
	}
}

if (!function_exists('aemi_widgets_init'))
{
	function aemi_widgets_init()
	{
		register_sidebar([
			'name'			=>	__('Header Widget Area', 'aemi'),
			'id'			=>	'header-widget-area',
			'description'	=>	__('Add widgets in this area to display them on header area.', 'aemi'),
			'before_widget'	=>	'<div id="w-%1$s" class="w-cont header-section %2$s">',
			'after_widget'	=>	'</div>',
			'before_title'	=>	'<h4 class="widget-title">',
			'after_title'	=>	'</h4>',
		]);
		register_sidebar([
			'name'			=>	__('Sidebar Widget Area', 'aemi'),
			'id'			=>	'sidebar-widget-area',
			'description'	=>	__('Add widgets in this area to display them on sidebar area.', 'aemi'),
			'before_widget'	=>	'<div id="w-%1$s" class="w-cont %2$s">',
			'after_widget'	=>	'</div>',
			'before_title'	=>	'<h4 class="widget-title">',
			'after_title'	=>	'</h4>',
		]);
		register_sidebar([
			'name'			=>	__('Footer Widget Area', 'aemi'),
			'id'			=>	'footer-widget-area',
			'description'	=>	__('Add widgets in this area to display them on footer area.', 'aemi'),
			'before_widget'	=>	'<div id="w-%1$s" class="w-cont %2$s">',
			'after_widget'	=>	'</div>',
			'before_title'	=>	'<h4 class="widget-title">',
			'after_title'	=>	'</h4>',
		]);
	}
}

if (!function_exists('aemi_custom_comment_fields_order'))
{
	function aemi_custom_comment_fields_order($fields)
	{
		
		$comment_field = $fields['comment'];
		$author_field = $fields['author'];
		$email_field = $fields['email'];
		$url_field = $fields['url'];

		unset($fields['comment']);
		unset($fields['author']);
		unset($fields['email']);
		unset($fields['url']);
		
		$fields['author'] = $author_field;
		$fields['email'] = $email_field;
		$fields['url'] = $url_field;
		$fields['comment'] = $comment_field;
		
		return $fields;
	}
}

if (!function_exists('is_enabled'))
{
	function is_enabled($mod,$default)
	{
		return get_theme_mod($mod,$default) === 1;
	}
}
if (!function_exists('is_disabled'))
{
	function is_disabled($mod,$default)
	{
		return get_theme_mod($mod,$default) === 0;
	}
}
