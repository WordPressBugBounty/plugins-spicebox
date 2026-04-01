<?php 
/* Slider Section */
	$wp_customize->add_section( 'slider_section' , array(
		'title'      => __('Hero settings', 'spicebox'),
		'panel'  => 'section_settings',
		'priority'   => 1,
   	) );
		
		// Enable slider
		$wp_customize->add_setting( 'home_page_slider_enabled' , array( 'default' => 'on') );
		$wp_customize->add_control(	'home_page_slider_enabled' , array(
				'label'    => __( 'Enable Hero Section', 'spicebox' ),
				'section'  => 'slider_section',
				'type'     => 'radio',
				'choices' => array(
					'on'=>__('ON', 'spicebox'),
					'off'=>__('OFF', 'spicebox')
				)
		));
		
		
		//Slider Image
		$wp_customize->add_setting( 'home_slider_image',array('default' => SPICEB_PLUGIN_URL .'inc/innofit/images/slider/slider.jpg',
		'sanitize_callback' => 'esc_url_raw', 'transport' => $selective_refresh,));
 
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'home_slider_image',
				array(
					'type'        => 'upload',
					'label' => __('Image','spicebox'),
					'settings' =>'home_slider_image',
					'section' => 'slider_section',
					
				)
			)
		);
		
		// Image overlay
		$wp_customize->add_setting( 'slider_image_overlay', array(
			'default' => true,
			'sanitize_callback' => 'sanitize_text_field',
		) );
		
		$wp_customize->add_control('slider_image_overlay', array(
			'label'    => __('Enable slider image overlay', 'spicebox' ),
			'section'  => 'slider_section',
			'type' => 'checkbox',
		) );
		
		
		//Slider Background Overlay Color
		$wp_customize->add_setting( 'slider_overlay_section_color', array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => 'rgba(0,0,0,0.30)',
            ) );	
            
            $wp_customize->add_control(new innofit_Customize_Alpha_Color_Control( $wp_customize,'slider_overlay_section_color', array(
               'label'      => __('Slider image overlay color','spicebox' ),
                'palette' => true,
                'section' => 'slider_section')
            ) );
		
		
		// Slider title
		$wp_customize->add_setting( 'home_slider_title',array(
		'default' => __('We provide solutions to<br /> grow your business','spicebox'),
		'sanitize_callback' => 'spiceb_innofit_home_page_sanitize_text',
		'transport'         => $selective_refresh,
		));	
		$wp_customize->add_control( 'home_slider_title',array(
		'label'   => __('Title','spicebox'),
		'section' => 'slider_section',
		'type' => 'text',
		));	
		
		//Slider discription
		$wp_customize->add_setting( 'home_slider_discription',array(
		'default' => __('Welcome to Innofit','spicebox'),
		'sanitize_callback' => 'spiceb_innofit_home_page_sanitize_text',
		'transport'         => $selective_refresh,
		));	
		$wp_customize->add_control( 'home_slider_discription',array(
		'label'   => __('Description','spicebox'),
		'section' => 'slider_section',
		'type' => 'textarea',
		));
		
		
		// Slider button text
		$wp_customize->add_setting( 'home_slider_btn_txt',array(
		'default' => __('Read more','spicebox'),
		'sanitize_callback' => 'spiceb_innofit_home_page_sanitize_text',
		'transport'         => $selective_refresh,
		));	
		$wp_customize->add_control( 'home_slider_btn_txt',array(
		'label'   => __('Button Text','spicebox'),
		'section' => 'slider_section',
		'type' => 'text',
		));
		
		// Slider button link
		$wp_customize->add_setting( 'home_slider_btn_link',array(
		'default' => '#',
		'sanitize_callback' => 'spiceb_innofit_home_page_sanitize_text',
		'transport'         => $selective_refresh,
		));	
		$wp_customize->add_control( 'home_slider_btn_link',array(
		'label'   => __('Button Link','spicebox'),
		'section' => 'slider_section',
		'type' => 'text',
		));
		
		// Slider button target
		$wp_customize->add_setting(
		'home_slider_btn_target', 
			array(
			'default'        => false,
			'sanitize_callback' => 'spiceb_innofit_home_page_sanitize_text',
		));
		$wp_customize->add_control('home_slider_btn_target', array(
			'label'   => __('Open link in new tab', 'spicebox'),
			'section' => 'slider_section',
			'type' => 'checkbox',
	    ));
				
		
	/**
	* Add selective refresh for Front page slider section controls.
	*/
	
	$wp_customize->selective_refresh->add_partial( 'home_slider_image', array(
		'selector'            => 'main-slider .item',
		'settings'            => 'home_slider_image',
	
	) );
	
	$wp_customize->selective_refresh->add_partial( 'home_slider_title', array(
		'selector'            => '.caption-content .title',
		'settings'            => 'home_slider_title',
		'render_callback'  => 'spiceb_innofit_slider_section_title_render_callback',
	
	) );
	
	$wp_customize->selective_refresh->add_partial( 'home_slider_discription', array(
		'selector'            => '.caption-content .subtitle',
		'settings'            => 'home_slider_discription',
		'render_callback'  => 'spiceb_innofit_slider_section_discription_render_callback',
	
	) );
	
	$wp_customize->selective_refresh->add_partial( 'home_slider_btn_txt', array(
		'selector'            => '.main-slider .btn-small',
		'settings'            => 'home_slider_btn_txt',
		'render_callback'  => 'spiceb_innofit_slider_btn_render_callback',
	
	) );

	 //Page editor Section
    $wp_customize->add_section('innofit_gutenberg_editor_section',array(
                'title' => esc_html__('Gutenberg Editor settings','spicebox'),
                'panel' => 'section_settings',
                'priority'       => 2,
    ));

    // Custom Control Button
    class Innofit_Editor_Customize_Control extends WP_Customize_Control {
        public $type = 'new_menu';

        public function render_content() {

            $template_file = 'template-business.php';

            $pages = get_posts(array(
                'post_type'  => 'page',
                'meta_key'   => '_wp_page_template',
                'meta_value' => $template_file,
                'posts_per_page' => 1,
            ));

            if ( !empty($pages) ) {
                $page_id = $pages[0]->ID;
                $edit_link = admin_url('post.php?post=' . $page_id . '&action=edit');
            } else {
                $edit_link = admin_url('edit.php?post_type=page');
            }
            ?>
            <div class="innofit-features-customizer">
                <p>Use this button to insert Gutenberg blocks into the Business Template page.</p>
                <a href="<?php echo esc_url($edit_link); ?>" class="innofit-button button-primary">
                    <?php esc_html_e('Page Editor Section', 'spicebox'); ?>
                </a>
            </div>
            <?php
        }
    }


    $wp_customize->add_setting(
        'edit_homepage_button_setting',
        array(
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        )   
    );

    $wp_customize->add_control( 
        new Innofit_Editor_Customize_Control( 
            $wp_customize, 
            'edit_homepage_button_setting', 
            array(
                'section' => 'innofit_gutenberg_editor_section',
                'setting' => 'edit_homepage_button_setting'
            )
        )
    );

	