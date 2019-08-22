<?php

/**
 * Elementor Bodymovin Widget.
 *
 * Elementor widget that inserts a Bodymovin animation into the page.
 *
 * @since 1.0.0
 */
class Bodymovin_Widget extends \Elementor\Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve Bodymovin widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'bodymovin';
    }

    /**
     * Get widget title.
     *
     * Retrieve Bodymovin widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Bodymovin', 'bodymovin-elementor');
    }

    /**
     * Get widget icon.
     *
     * Retrieve Bodymovin widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'fa fa-motorcycle';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Bodymovin widget belongs to.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['general'];
    }

    /**
     * Register Bodymovin widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'bodymovin-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'animname',
            [
                'label' => __('Animation Name', 'bodymovin-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => __('A unique name for this animation.', 'bodymovin-elementor'),
            ]
        );

        $this->add_control(
            'animlink',
            [
                'label' => __('Link', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'bodymovin-elementor'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        // $this->add_control(
        //     'the-object',
        //     [
        //         'label' => __('Bodymovin Object', 'bodymovin-elementor'),
        //         'type' => \Elementor\Controls_Manager::CODE,
        //         'input_type' => 'JSON',
        //         'placeholder' => __('Place the Bodymovin object here.', 'bodymovin-elementor'),
        //     ]
        // );

        $this->add_control(
            'lottie-file',
            [
                'label' => __('Lottie File', 'bodymovin-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'placeholder' => __('Upload the json file as if it were an image.', 'bodymovin-elementor'),
            ]
        );

        $this->add_control(
            'fallback-img',
            [
                'label' => __('Fallback Img', 'bodymovin-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'placeholder' => __('Fallback.', 'bodymovin-elementor'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'animsettings',
            [
                'label' => __('Animation Settings', 'bodymovin-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'shouldloop',
            [
                'label' => __('Loop Animation', 'bodymovin-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'input_type' => 'switcher'
            ]
        );

        $this->add_control(
            'should-autoplay',
            [
                'label' => __('Autoplay Animation', 'bodymovin-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'input_type' => 'switcher'
            ]
        );

        $this->add_control(
			'load-offset',
			[
				'label' => __( 'Loading Offset from bottom of screen', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
			]
		);


        $this->end_controls_section();

    }

    /**
     * Render Bodymovin widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */


    protected function render()
    {
        // $anim_obj = $this->get_settings_for_display("the-object");
        $anim_id = $this->get_settings_for_display("animname");
        $anim_link = $this->get_settings_for_display("animlink");
        $should_autoplay = $this->get_settings_for_display('should-autoplay');
        $should_loop = $this->get_settings_for_display("shouldloop");
        $load_offset = $this->get_settings_for_display("load-offset");
        $json_link = $this->get_settings_for_display('lottie-file');
        $fallback_img = $this->get_settings_for_display('fallback-img');
        $target = $anim_link['is_external'] ? ' target="_blank"' : '';
        $nofollow = $anim_link['nofollow'] ? ' rel="nofollow"' : '';
        $anim_url = $anim_link['url'];
        $anim_id = preg_replace("/[^A-Za-z0-9]/", '', $anim_id);

        if ('' != $anim_url) {
            echo '<a href="' . $anim_url . '"' . $target . $nofollow . '>';
        }
        echo '<div id="' . $anim_id . '" class="val-bme" style="width: 100%; height: 100%;" data-should-autoplay="' . $should_autoplay . '" data-should-loop="' . $should_loop . '" data-load-offset="' . $load_offset['size'] . '" data-bm-link="' . $json_link['url'] . '" data-bm-fallback="' . $fallback_img['url'] . '"></div>';
        if ('' != $anim_link) {
            echo '</a>';
        }
    }

    protected function _content_template()
    {
        ?>
        <div id={{{settings.animname}}} style="width: 100%; height: 100%;">
            <p style="margin: 0 auto; text-align: center;">Live Preview isn't available just yet, but {{{settings.animname}}} will appear here.</p>
        </div>
	<?php

}

}