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
            'the-object',
            [
                'label' => __('Bodymovin Object', 'bodymovin-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => __('Put da object hurr', 'bodymovin-elementor'),
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
        echo '<div id="draw" style="width: 100%; height: 100%;"></div>';
        // $bm_obj = $this->get_settings_for_display('theobject');
        $pass_obj = $this->get_settings_for_display("the-object");
        ?>

        <script type="text/javascript">
            var passedObj = <?php echo json_encode($pass_obj); ?>;
            // console.log(passedObj); 
        </script>

        <?php 
        // echo '<h3>' . print_r($bm_obj) . '</h3>';

        // $js = '<script>animation = bodymovin.loadAnimation({ container: document.getElementById("draw"), renderer: " html ", loop: true, autoplay: true, animationData: ' . $bm_obj . '});</script>';
        
        // echo $js;

    }

}