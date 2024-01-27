<?php 
add_action('woocommerce_before_add_to_cart_form', 'gyc_design_area', 99);
function gyc_design_area(){
    $gyc_options_shortcode = get_option( 'gyc__settings' );

    $shortcode_use = isset($gyc_options_shortcode['show_on_product_page']) ? $gyc_options_shortcode['show_on_product_page'] : 'off';
    // var_dump($shortcode_use);
    if($shortcode_use == 'on'){
        echo do_shortcode('[gyc_price_gauge]');
    }
    

}

add_shortcode('gyc_price_gauge', 'gyc_price_gauge_shortcode');
function gyc_price_gauge_shortcode($atts, $content = null){

    $a = shortcode_atts( array(
		'gyc_price_gauge' => true
	), $atts );

    $reservered = get_post_meta(get_the_ID(), 'woo_ua_lowest_price', true);
    $options = get_option( 'gyc__settings' );
    $wd_style = isset($options['gauge_widget_style']) ? $options['gauge_widget_style'] : '1';

    $gauge_widget_text = isset($options['gauge_widget_text']) ? $options['gauge_widget_text'] : 'Met reserved price';

    $gyc_options_shortcode = get_option( 'gyc__settings' );
    $shortcode_use = isset($gyc_options_shortcode['show_on_product_page']) ? $gyc_options_shortcode['show_on_product_page'] : 'off';

//     $gyc_options = get_option( 'gyc__settings' );
// //    Card color 
//     $client_name = isset($gyc_options['gyc__text_field_0']) ? $gyc_options['gyc__text_field_0'] : 'Your Name';
    ob_start();

    $gyc_card = '<div id="gyc_card" class="gyc_custom_widget">';
    $gyc_card .= '<div class="speed_gauge" data-reserveprice="'.$reservered.'" data-gaugetype="'.$wd_style.'" data-met="'.$gauge_widget_text.'">
                    <style>
                    .reserve_gauge_meter {
                        width: 25em;
                        height: 25em;
                        padding: 20px;
                    }
                    </style>
                  </div>';
    $gyc_card .= '</div>';

    echo $gyc_card;
    $contents = ob_get_clean();
    return $contents;
}

add_action('wp_footer', 'gyc_footer_elements', 99);
function gyc_footer_elements(){
    $fe_options = get_option( 'gyc__settings' );
    $fe_wd_style = isset($fe_options['gauge_widget_style']) ? $fe_options['gauge_widget_style'] : '1';
    if($fe_wd_style == '4'):
    ?>
    <svg width="0" height="0" version="1.1" class="gradient-mask" xmlns="http://www.w3.org/2000/svg">   
      <defs>
          <linearGradient id="gradientGauge">
            <stop class="color-red" offset="0%"/>
            <stop class="color-yellow" offset="17%"/>
            <stop class="color-yellow" offset="40%"/>
            <stop class="color-green" offset="87%"/>
            <stop class="color-green" offset="100%"/>
          </linearGradient>
      </defs>  
    </svg>
    <?php
    endif; 
}
