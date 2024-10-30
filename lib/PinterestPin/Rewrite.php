<?php
class PinterestPin_Rewrite
{
    
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'theme_name_scripts'));
        add_action('parse_request', array(&$this, 'replace_content'));
    }
    
    public function theme_name_scripts() {
        wp_enqueue_script('pinjs', '//assets.pinterest.com/js/pinit.js');
    }
    
    public function replace_content(&$wp) {
        add_shortcode('jc-pin', array($this, 'filter_content'));
    }
    
    public function filter_content() {
        
        $pin = get_option(PinterestPin::OPTION_KEY . '_pin', array());
        $rand = rand(0, 999999);
        $pagelink = get_permalink();
        $title = get_the_title();
        $imageurl = wp_get_attachment_url(get_post_thumbnail_id(get_the_id()));
        
        $return = '<a href="http://www.pinterest.com/pin/create/button/';
        $return.= '?url=' . $pagelink;
        if ($imageurl) {
            $return.= '&media=' . $imageurl;
        }
        $return.= '&description=' . $title . '"';
        
        $return.= ' data-pin-do="buttonPin"';
        if($pin['pin_button_shape'] == 'circular'){
            $return.=' data-pin-shape="round"';
        }
        if($pin['pin-button-size'] == '28'){
            $return.=' data-pin-height="28"';
        }

        
        if ($pin['pin_count'] == 'no') {
            $return.= ' data-pin-config="none">';
        } elseif ($pin['pin_count'] == 'beside') {
            $return.= ' data-pin-config="beside">';
        } elseif ($pin['pin_count'] == 'above') {
            $return.= ' data-pin-config="above">';
        }


        
        if ($pin['pin_button_size'] == '20') {
            if ($pin['pin_button_shape'] == 'rectangular') {
                $return.= '<img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" />';
            } else {
                $return.= '<img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_round_red_16.png" />';
            }
        } elseif ($pin['pin_button_size'] == '28') {

            if ($pin['pin_button_shape'] == 'rectangular') {

                $return.= '<img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_28.png" />';
            } else {
                $return.= '<img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_round_red_28.png" />';
            }
        }
        
        $return.= '</a>';
        return $return;
    }
}
