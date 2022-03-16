<?php
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5f6c21b525f25',
        'title' => 'Users',
        'fields' => array(
            array(
                'key' => 'field_5f6c21d339f5e',
                'label' => 'Favourites',
                'name' => 'favourites',
                'type' => 'post_object',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'offer',
                ),
                'taxonomy' => '',
                'allow_null' => 0,
                'multiple' => 1,
                'return_format' => 'id',
                'ui' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'current_user_role',
                    'operator' => '==',
                    'value' => 'customer',
                ),
            ),
            array(
                array(
                    'param' => 'current_user_role',
                    'operator' => '==',
                    'value' => 'administrator',
                ),
            ),
            array(
                array(
                    'param' => 'current_user_role',
                    'operator' => '==',
                    'value' => 'pms_subscription_plan_1323',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => false,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_5c22ece22b719',
        'title' => 'Affiliate Details',
        'fields' => array(
            array(
                'key' => 'field_5badb5cfa4d4a',
                'label' => 'Code',
                'name' => 'code_',
                'type' => 'text',
                'instructions' => 'Copy and Paste The Affiliate Code Here',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'Code',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5bd5a9a32ad2b',
                'label' => 'Featured Offer',
                'name' => 'featured_offer',
                'type' => 'true_false',
                'instructions' => 'Featured offers are always shown regardless of what the user searches',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 0,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_5bd8fbcb7be2b',
                'label' => 'Affiliate Manager',
                'name' => 'affiliate_manager',
                'type' => 'radio',
                'instructions' => 'Select which company manages the affiliate partner',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'Commission Factory' => 'Commission Factory',
                    'Rakuten' => 'Rakuten',
                    'Hotels Combined' => 'Hotels Combined',
                    'Commission Junction' => 'Commission Junction',
                    'AWIN' => 'AWIN',
                    'Partnerize' => 'Partnerize',
                ),
                'allow_null' => 0,
                'other_choice' => 0,
                'default_value' => '',
                'layout' => 'horizontal',
                'return_format' => 'value',
                'save_other_choice' => 0,
            ),
            array(
                'key' => 'field_5bfa1d800222c',
                'label' => 'Grid Display Text',
                'name' => 'grid_text',
                'type' => 'text',
                'instructions' => 'Enter a small amount of text that will display on the main grid',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => 20,
            ),
            array(
                'key' => 'field_5f167178b6533',
                'label' => 'Grid Display Long Text',
                'name' => 'grid_text_long',
                'type' => 'textarea',
                'instructions' => 'Enter more detail about the offer or retailer, usually longer than the short text area',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'offer',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'seamless',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => false,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_5c22ece239233',
        'title' => 'Client Details',
        'fields' => array(
            array(
                'key' => 'field_5b88d08bbf9af',
                'label' => 'Client Logo',
                'name' => 'client_logo',
                'type' => 'image',
                'instructions' => 'Client Logo For Top Of Page',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'preview_size' => 'thumbnail',
                'library' => 'all',
                'return_format' => 'url',
                'min_width' => 0,
                'min_height' => 0,
                'min_size' => 0,
                'max_width' => 0,
                'max_height' => 0,
                'max_size' => 0,
                'mime_types' => '',
            ),
            array(
                'key' => 'field_5b88d0fcbf9b1',
                'label' => 'Client Website',
                'name' => 'client_website',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5b88d13bbf9b2',
                'label' => 'Client Introduction',
                'name' => 'client_introduction',
                'type' => 'textarea',
                'instructions' => 'Enter an introduction to your reverse sponsorship program',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'Welcome to our reverse sponsorship program. Every dollar spent here goes towards helping us raise important funds to support our membership base',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => 'br',
            ),
            array(
                'key' => 'field_5bd8fc5b99e19',
                'label' => 'Affliate Code / Tag',
                'name' => 'affliate_code',
                'type' => 'text',
                'instructions' => 'Enter the tag to add to the URL so the organisation is associated with any transactions made from this app',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5c0f287fc2cb4',
                'label' => 'Offers',
                'name' => 'offers',
                'type' => 'post_object',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'offer',
                ),
                'taxonomy' => '',
                'allow_null' => 0,
                'multiple' => 1,
                'return_format' => 'id',
                'ui' => 1,
            ),
            array(
                'key' => 'field_5c1b55f37cc6d',
                'label' => 'App Icon',
                'name' => 'app_icon',
                'type' => 'image',
                'instructions' => 'Upload an app image, must be a size of 512x512 and the system will automate generating the additional sizes',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
                'library' => 'all',
                'min_width' => 512,
                'min_height' => 512,
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
            array(
                'key' => 'field_5c1b56257cc6e',
                'label' => 'Short Name',
                'name' => 'short_name',
                'type' => 'text',
                'instructions' => 'The short name that shows when the user is prompted to save the app, only applies to new versions of iOS and Chrome',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 'RSP',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5c1b563f7cc6f',
                'label' => 'Theme Colour',
                'name' => 'theme_colour',
                'type' => 'color_picker',
                'instructions' => 'The background colour for the loading screen on android and the colour at the top of the app in iOS',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'enable_opacity' => false,
                'return_format' => 'string',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'apptemplate.php',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'seamless',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => false,
    ));

endif;
