<?php

acf_add_local_field_group(array (
	'key' => 'group_hero',
	'title' => 'Hero',
	'fields' => array (
		array (
			'multiple' => 0,
			'allow_null' => 0,
			'choices' => array (
				'default' => 'Page Title',
				'manual' => 'Custom Headline & Copy',
				'latest_post' => 'Latest Post',
				'select_post' => 'Select a Post',
			),
			'default_value' => array (
				0 => 'default',
			),
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
			'return_format' => 'value',
			'key' => 'field_hero_content_type',
			'label' => 'Content Type',
			'name' => 'hero_content_type',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'layout' => 'horizontal',
			'choices' => array (
				'button' => 'Button',
			),
			'default_value' => array (
			),
			'allow_custom' => 0,
			'save_custom' => 0,
			'toggle' => 0,
			'return_format' => 'value',
			'key' => 'field_hero_options',
			'label' => 'Options',
			'name' => 'hero_options',
			'type' => 'checkbox',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_hero_content_type',
						'operator' => '==',
						'value' => 'manual',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'default_value' => '',
			'maxlength' => 80,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'key' => 'field_58924f9a65e3c',
			'label' => 'Headline',
			'name' => 'hero_headline',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_hero_content_type',
						'operator' => '==',
						'value' => 'manual',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'default_value' => '',
			'maxlength' => 20,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'key' => 'field_58e2e6af8b427',
			'label' => 'Button Label',
			'name' => 'hero_button_label',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_hero_options',
						'operator' => '==',
						'value' => 'button',
					),
					array (
						'field' => 'field_hero_content_type',
						'operator' => '==',
						'value' => 'manual',
					),
				),
			),
			'wrapper' => array (
				'width' => '50',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'multiple' => 0,
			'allow_null' => 0,
			'choices' => array (
				'default' => 'Scroll to Next Section',
				'internal' => 'Internal',
				'external' => 'External',
			),
			'default_value' => array (
			),
			'ui' => 0,
			'ajax' => 0,
			'placeholder' => '',
			'return_format' => 'value',
			'key' => 'field_596e0d1b946fe',
			'label' => 'Button Link Target',
			'name' => 'hero_button_link_target',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_hero_options',
						'operator' => '==',
						'value' => 'button',
					),
					array (
						'field' => 'field_hero_content_type',
						'operator' => '==',
						'value' => 'manual',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'default_value' => '',
			'placeholder' => '',
			'key' => 'field_58e2e91b714d2',
			'label' => 'Button Link',
			'name' => 'hero_button_external_link',
			'type' => 'url',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_hero_content_type',
						'operator' => '==',
						'value' => 'manual',
					),
					array (
						'field' => 'field_hero_options',
						'operator' => '==',
						'value' => 'button',
					),
					array (
						'field' => 'field_596e0d1b946fe',
						'operator' => '==',
						'value' => 'external',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'post_type' => array (
			),
			'taxonomy' => array (
			),
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
			'key' => 'field_596e0e9cebe25',
			'label' => 'Button Link',
			'name' => 'hero_button_internal_link',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_hero_content_type',
						'operator' => '==',
						'value' => 'manual',
					),
					array (
						'field' => 'field_hero_options',
						'operator' => '==',
						'value' => 'button',
					),
					array (
						'field' => 'field_596e0d1b946fe',
						'operator' => '==',
						'value' => 'internal',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'post_type' => array (
			),
			'taxonomy' => array (
			),
			'allow_null' => 0,
			'multiple' => 0,
			'allow_archives' => 1,
			'key' => 'field_596e0fa3bbce3',
			'label' => 'Post Select',
			'name' => 'hero_post_select',
			'type' => 'page_link',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_hero_content_type',
						'operator' => '==',
						'value' => 'select_post',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));
