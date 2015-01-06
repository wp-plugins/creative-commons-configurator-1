<?php
/**
 *  Contains generator functions providing the full text of each license.
 */

// Prevent direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    echo 'This file should not be accessed directly!';
    exit; // Exit if accessed directly
}


// Generator for no licensing information (manual)
function bccl_manual_generator( $license_slug, $license_data, $post, $options, $minimal=false ) {
    return '';
}


// ARR Generator
function bccl_arr_generator( $license_slug, $license_data, $post, $options, $minimal=false ) {

    $license_text = sprintf(__('Copyright &copy; %s - All Rights Reserved', 'cc-configurator'), get_the_date('Y'));
    $license_text = apply_filters( 'bccl_arr_license_text', $license_text );

    // Extra perms
    $extra_perms_text = '';
    $extra_perms_url = bccl_get_extra_perms_url( $post, $options );
    $extra_perms_title = bccl_get_extra_perms_title( $post, $options );
    if ( ! empty($extra_perms_url) ) {
        if ( empty($extra_perms_title) ) {
            // If there is no title, use the URL as the anchor text.
            $extra_perms_title = $extra_perms_url;
        }
        $extra_perms_hyperlink = sprintf('<a href="%s">%s</a>', $extra_perms_url, $extra_perms_title);
        $extra_perms_template = __('Information about how to reuse or republish this work may be available at %s.', 'cc-configurator');
        $extra_perms_template = apply_filters( 'bccl_arr_extra_permissions_template', $extra_perms_template );
        $extra_perms_text = sprintf($extra_perms_template, $extra_perms_hyperlink);
        // Alt text: Terms and conditions beyond the scope of this license may be available at %s.
    }

    // Construct HTML block

    if ( $minimal === false ) {
        $cc_block = array();
        // License
        $cc_block[] = $license_text;
        // Extra perms
        if ( ! empty($extra_perms_text) ) {
            $cc_block[] = '<br />';
            $cc_block[] = $extra_perms_text;
        }

        $full_license_block = implode(PHP_EOL, $cc_block);
        $full_license_block = apply_filters( 'bccl_arr_full_license_block', $full_license_block );
        return '<p class="cc-block">' . $full_license_block . '</p>';

    } else {    // $minimal === true
        // Construct HTML block
        $cc_block = array();
        // License
        $cc_block[] = $license_text;
        // $pre_text = 'Copyright &copy; ' . get_the_date('Y') . ' - Some Rights Reserved' . '<br />';
        $minimal_license_block = implode(PHP_EOL, $cc_block);
        $minimal_license_block = apply_filters( 'bccl_arr_minimal_license_block', $minimal_license_block );
        return $minimal_license_block;        
    }
}



// CC Zero Generator
function bccl_cc0_generator( $license_slug, $license_data, $post, $options, $minimal=false ) {

    // License image hyperlink
    $license_button_hyperlink = bccl_cc_generate_image_hyperlink( $license_slug, $license_data, $post, $options );
    // Work hyperlink
    $work_title_hyperlink = bccl_get_work_hyperlink( $post );
    // Creator hyperlink
    $creator_hyperlink = bccl_get_creator_hyperlink( $post, $options["cc_creator"] );

    // License
    if ( $options['cc_extended'] == '1' ) {
        $license_text = sprintf(__('To the extent possible under law, %s has waived all copyright and related or neighboring rights to %s.', 'cc-configurator'), $creator_hyperlink, $work_title_hyperlink);
    } else {
        $license_text = __('To the extent possible under law, the creator has waived all copyright and related or neighboring rights to this work.', 'cc-configurator');
    }
    // Allow filtering of the license text
    $license_text = apply_filters( 'bccl_cc0_license_text', $license_text );

    // Extra perms
    $extra_perms_text = '';
    $extra_perms_url = bccl_get_extra_perms_url( $post, $options );
    $extra_perms_title = bccl_get_extra_perms_title( $post, $options );
    if ( ! empty($extra_perms_url) ) {
        if ( empty($extra_perms_title) ) {
            // If there is no title, use the URL as the anchor text.
            $extra_perms_title = $extra_perms_url;
        }
        $extra_perms_hyperlink = sprintf('<a xmlns:cc="http://creativecommons.org/ns#" href="%s" rel="cc:morePermissions">%s</a>', $extra_perms_url, $extra_perms_title);
        $extra_perms_template = __('Terms and conditions beyond the scope of this waiver may be available at %s.', 'cc-configurator');
        $extra_perms_template = apply_filters( 'bccl_cc0_extra_permissions_template', $extra_perms_template );
        $extra_perms_text = sprintf($extra_perms_template, $extra_perms_hyperlink);
    }

    // Construct HTML block
    if ( $minimal === false ) {
        $cc_block = array();
        // License Button
        if ( ! empty($license_button_hyperlink) ) {
            $cc_block[] = $license_button_hyperlink;
            $cc_block[] = '<br />';
        }
        // License
        $cc_block[] = $license_text;
        // Extra perms
        if ( ! empty($extra_perms_text) ) {
            //$cc_block[] = '<br />';
            $cc_block[] = $extra_perms_text;
        }
        $full_license_block = implode(PHP_EOL, $cc_block);
        $full_license_block = apply_filters( 'bccl_cc0_full_license_block', $full_license_block );
        return '<p class="cc-block">' . $full_license_block . '</p>';

    } else {    // $minimal === true
        // Construct HTML block
        $cc_block = array();
        // License Button
        if ( ! empty($license_button_hyperlink) ) {
            $cc_block[] = $license_button_hyperlink;
            $cc_block[] = '<br /><br />';
        }
        // License
        $cc_block[] = $license_text;
        // $pre_text = 'Copyright &copy; ' . get_the_date('Y') . ' - Some Rights Reserved' . '<br />';
        $minimal_license_block = implode(PHP_EOL, $cc_block);
        $minimal_license_block = apply_filters( 'bccl_cc0_minimal_license_block', $minimal_license_block );
        return $minimal_license_block;        
    }
}


// CC Generator
function bccl_cc_generator( $license_slug, $license_data, $post, $options, $minimal=false ) {

    // License image hyperlink
    $license_button_hyperlink = bccl_cc_generate_image_hyperlink( $license_slug, $license_data, $post, $options );
    // Work hyperlink
    $work_title_hyperlink = bccl_get_work_hyperlink( $post );
    // Creator hyperlink
    $creator_hyperlink = bccl_get_creator_hyperlink( $post, $options["cc_creator"] );

    // License
    $license_hyperlink = sprintf('<a rel="license" href="%s">%s</a>', $license_data['url'], $license_data['name']);
    if ( $options['cc_extended'] == '1' ) {
        $license_text = sprintf(__('%s by %s is licensed under a %s.', 'cc-configurator'), $work_title_hyperlink, $creator_hyperlink, $license_hyperlink);
    } else {
        $license_text = sprintf(__('This work is licensed under a %s.', 'cc-configurator'), $license_hyperlink);
    }
    // Allow filtering of the license text
    $license_text = apply_filters( 'bccl_cc_license_text', $license_text );

    // Extra perms
    $extra_perms_text = '';
    $extra_perms_url = bccl_get_extra_perms_url( $post, $options );
    $extra_perms_title = bccl_get_extra_perms_title( $post, $options );
    if ( ! empty($extra_perms_url) ) {
        if ( empty($extra_perms_title) ) {
            // If there is no title, use the URL as the anchor text.
            $extra_perms_title = $extra_perms_url;
        }
        $extra_perms_hyperlink = sprintf('<a xmlns:cc="http://creativecommons.org/ns#" href="%s" rel="cc:morePermissions">%s</a>', $extra_perms_url, $extra_perms_title);
        $extra_perms_template = __('Permissions beyond the scope of this license may be available at %s.', 'cc-configurator');
        $extra_perms_template = apply_filters( 'bccl_cc_extra_permissions_template', $extra_perms_template );
        $extra_perms_text = sprintf($extra_perms_template, $extra_perms_hyperlink);
        // Alt text: Terms and conditions beyond the scope of this license may be available at %s.
    }

    // Construct HTML block
    if ( $minimal === false ) {

        $cc_block = array();
        // License Button
        if ( ! empty($license_button_hyperlink) ) {
            $cc_block[] = $license_button_hyperlink;
            $cc_block[] = '<br />';
        }
        // License
        $cc_block[] = $license_text;
        // Extra perms
        if ( ! empty($extra_perms_text) ) {
            //$cc_block[] = '<br />';
            $cc_block[] = $extra_perms_text;
        }
        // Source Work
        //if ( ! empty($source_work_html) ) {
        //    $cc_block[] = '<br />';
        //    $cc_block[] = $source_work_html;
        //}

        // $pre_text = 'Copyright &copy; ' . get_the_date('Y') . ' - Some Rights Reserved' . '<br />';
        $full_license_block = implode(PHP_EOL, $cc_block);
        $full_license_block = apply_filters( 'bccl_cc_full_license_block', $full_license_block );
        return '<p class="cc-block">' . $full_license_block . '</p>';

    } else {    // $minimal === true
        // Construct HTML block
        $cc_block = array();
        // License Button
        if ( ! empty($license_button_hyperlink) ) {
            $cc_block[] = $license_button_hyperlink;
            $cc_block[] = '<br /><br />';
        }
        // License
        $cc_block[] = $license_hyperlink;
        // $pre_text = 'Copyright &copy; ' . get_the_date('Y') . ' - Some Rights Reserved' . '<br />';
        $minimal_license_block = implode(PHP_EOL, $cc_block);
        $minimal_license_block = apply_filters( 'bccl_cc_minimal_license_block', $minimal_license_block );
        return $minimal_license_block;        
    }
}


// License Badge Shortcode

function bccl_license_badge_shortcode( $atts ) {
    // Entire list of supported parameters and their default values
    $pairs = array(
        'type'    => '',    // License slug (required)
        'compact' => '1',   // Display compact image.
        'link'    => '1',   // Create hyperlink to the license page at creativecommons.org
    );
    // Combined and filtered attribute list.
	$atts = shortcode_atts( $pairs, $atts, 'license' );

    // Construct the array with the slugs of the licenses supported by the shortcode.
    $license_slugs_all = array_keys( bccl_get_all_licenses() );
    $license_slugs_unsupported = apply_filters( 'bccl_shortcode_license_unsupported_slugs', array( 'manual', 'arr' ) );
    $license_slugs = array();
    foreach ( $license_slugs_all as $slug ) {
        if ( ! in_array( $slug, $license_slugs_unsupported ) ) {
            $license_slugs[] = $slug;
        }
    }

    // Check for required parameters.
    if ( empty( $atts['type'] ) ) {
        return '<code>license error: missing "type" - supported: ' . implode(', ', $license_slugs) . '</code>';
    }

    // Type validation
    if ( ! in_array( $atts['type'], $license_slugs ) ) {
        return '<code>license error: invalid type - supported: ' . implode(', ', $license_slugs) . '</code>';
    }

    // Get license data
    $license_data = bccl_get_license_data( $atts['type'] );

    // Construct absolute image URL
    $license_image_url = $license_data['button_compact_url'];
    if ( empty( $atts['compact'] ) ) {
        $license_image_url = $license_data['button_url'];
    }
    $license_image_url = bccl_make_absolute_image_url( $license_image_url );

    // Construct HTML output
    $html = '<div class="cc-badge">';
    if ( ! empty( $atts['link'] ) ) {
        // We do not use rel="license" so as to avoid confusing the bots.
        $html .= sprintf('<a href="%s" title="%s">', $license_data['url'], $license_data['name']);
    }
    $html .= sprintf('<img src="%s" alt="%s" />', $license_image_url, $license_data['name']);
    if ( ! empty( $atts['link'] ) ) {
        $html .= '</a>';
    }
    $html .= '</div>';

    $html = apply_filters( 'bccl_shortcode_badge_html', $html );

	return $html;
}
add_shortcode( 'license', 'bccl_license_badge_shortcode' );



    /****** VALID CODE FOR SOURCE WORK
    // Determine Source Work
    $source_work_html = '';
    // Source work
    $source_work_url = get_post_meta( $post->ID, '_bccl_source_work_url', true );
    $source_work_title = get_post_meta( $post->ID, '_bccl_source_work_title', true );
    // $source_work_url & $source_work_title are mandatory for the source work HTML to be generated.
    if ( ! empty($source_work_url) && ! empty($source_work_title) ) {
        $source_work_html = 'Based on';
        // Source work creator
        $source_creator_url = get_post_meta( $post->ID, '_bccl_source_creator_url', true );
        $source_creator_name = get_post_meta( $post->ID, '_bccl_source_creator_name', true );
        if ( empty($source_creator_name) ) {
            // If the creator name is empty, use the source creator URL instead.
            $source_creator_name = $source_creator_url;
        }
        $source_work_creator_html = sprintf('<a xmlns:cc="http://creativecommons.org/ns#" href="%s" property="cc:attributionName" rel="cc:attributionURL">%s</a>')
    }

    if ( ! empty($extra_perms_url) ) {
        if ( empty($extra_perms_title) ) {
            // If there is no title, use the URL as the anchor text.
            $extra_perms_title = $extra_perms_url;
        }
        $extra_perms_text = sprintf('Permissions beyond the scope of this license may be available at <a xmlns:cc="http://creativecommons.org/ns#" href="%s" rel="cc:morePermissions">%s</a>.', $extra_perms_url, $extra_perms_title);
    }
    *****/

