<?php

// In case of wordpress update this file goes to functions.php

function custom_polylang_multilang_logo( $value ) {
	if ( function_exists( 'pll_current_language' ) ) {
		$slugs=['homepage','double-room','double-room-2','triple-room','triple-room-2','family-room','family-room-2','%ce%b1%cf%81%cf%87%ce%b9%ce%ba%ce%ae-%cf%83%ce%b5%ce%bb%ce%af%ce%b4%ce%b1'];
		$slugs_en = ['homepage','double-room','triple-room','family-room'];
		$slug =  basename(get_permalink());
		$logos = array(
			'en' => wp_get_attachment_image('883', array('200','120')),
			'el' => wp_get_attachment_image('928', array('200','120')),
			'en/eng' => wp_get_attachment_image('885', array('200','120')),
			'el/gr' => wp_get_attachment_image('927', array('200','120')),
		);
		$default_logo = $logos['en'];
		$current_lang = pll_current_language();
		if ( isset( $logos[ $current_lang ] ) )
			if (!in_array($slug,$slugs))
				$value = $logos[ $current_lang ];
			elseif (in_array($slug,$slugs_en))
				$value = $logos[ $current_lang."/eng" ];
			else
				$value = $logos[ $current_lang."/gr" ];
		else
			$value = $default_logo;
	}
	$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
            esc_url( home_url( '/' ) ),
            $value
        );
	return $html;
}
add_filter( 'get_custom_logo', 'custom_polylang_multilang_logo' );

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}


function js_calendar(){
	?>
	<script>
	
		console.log("hei");
		 jQuery( function($) {
			var dateFormat = "d M, yy";
			var theDate = formatDate(Date.now(),1);
      		$('[name="date-start"]').attr("min", theDate).on("change",function(){
				var date = new Date($('[name="date-start"]').val());
			 var minDates = formatDate(date,1);
			 console.log(date);
			 $('[name="date-end"]').attr("min", minDates);
			})
			 
		 });
		   
		function formatDate(date,a) {
			var d = new Date(date),
			month = '' + (d.getMonth() + 1),
			day = '' + d.getDate(),
			year = d.getFullYear();
			
			var help = parseInt(day)+a;
			day = help.toString();
			
			if (month.length < 2) 
				month = '0' + month;
			if (day.length < 2) 
				day = '0' + day;
			return [year, month, day].join('-');
		}
	</script>
<?php
};

add_action( 'wp_head', 'js_calendar' );