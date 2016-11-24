<!DOCTYPE html>
<html <?php language_attributes(); ?> class="js">
<head>
	<?php
		if(current_user_can('edit_theme_options')) {
			echo '<style type="text/css"> .js div#trt-preloader { position: fixed; left: 0; top: 0; z-index: 99999; width: 100%; height: 100%; overflow: visible; background-color: rgba(255,255,255,0.9); }div#trt-preloader .ac-loader { height: 10px; width: 100%; position: absolute; top: 50%; margin-top: -5px; overflow: hidden; background-color: rgba(255,0,0,0.2); } div#trt-preloader .ac-loader:before { display: block; position: absolute; content: ""; left: -200px; width: 200px; height: 10px; background-color: red; animation: loading1 2s linear infinite; border-radius: 5px; } @keyframes loading1 { from { left: -200px; width: 30%; } 50% { width: 30%; } 70% { width: 70%; } 80% { left: 50%; } 95% { left: 120%; } to { left: 100% } } @media screen and (max-width: 1140px) { div#bx-preloader .ac-loader { height: 4px; margin-top: -2px; } div#bx-preloader .ac-loader:before { height: 4px; } } </style>';
		}
	?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Queue</title>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
	if(current_user_can('edit_theme_options')) {
		echo '<div id="trt-preloader"><div class="ac-loader"></div></div>';
	}
?>
