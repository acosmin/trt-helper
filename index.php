<?php
get_header();
if(current_user_can('edit_theme_options')) {
	$uri = 'https://themes.trac.wordpress.org/query?status=approved&group=priority&col=id&col=summary&col=reporter&col=owner&col=priority&col=changetime&col=keywords&report=24&order=changetime';
	$contents = wp_remote_fopen($uri);
	$dom = new DOMDocument();
	$dom->preserveWhiteSpace = false;
	$dom->loadHTML($contents);

	function ticket_reviewer_themelist( $dom ){
		$domxpath = new DOMXPath($dom);
		$themelist = array();
		$count = 1;

		$tr = $domxpath->query('//table[@class="listing tickets"]/tbody[1]/tr');


		foreach ($tr as $key) {
			foreach ($key->childNodes as $k) {
				if($k->nodeName === 'td') {
					foreach($k->attributes as $v){

						// Ticket ID
						if($v->nodeValue === 'id') {
							$themelist[$count]['id'] = trim(str_replace('#', '', $k->nodeValue));
						}

						// Theme Name
						if($v->nodeValue === 'summary') {
							$themerawn = str_replace('THEME: ', '', $k->nodeValue);
							$themename = trim(substr($themerawn, 0, strpos($themerawn, " –")));
							$themeslug = strtolower( $themename );
				    		$themeslug = preg_replace( '/[^a-z0-9_\-]/', '-', $themeslug );
							$themeslug = preg_replace( '/(--)/', '-', $themeslug );
							$themevers = trim(substr( $themerawn, strpos( $themerawn, '–') + 3 ) );

							$themelist[$count]['name'] 		= $themename;
							$themelist[$count]['slug'] 		= $themeslug;
							$themelist[$count]['version'] 	= $themevers;
						}

						// Theme Author
						if($v->nodeValue === 'reporter') {
							$themelist[$count]['reporter'] = trim($k->nodeValue);
						}

						// Modified
						if($v->nodeValue === 'changetime') {
							$themelist[$count]['changetime'] = trim($k->nodeValue);
						}

						// Created
						if($v->nodeValue === 'time') {
							$themelist[$count]['time'] = trim($k->nodeValue);
						}

					}
				}
			}
			$count++;
		}

		return (array) $themelist;
	}

	$themelist = ticket_reviewer_themelist( $dom );

?>

<section class="container">
	<div class="row">
		<div class="col-xs-12 themepositions" style="text-align:center; margin-bottom: 150px; font-size: 24px;">

		</div>
	</div>
</section>

<section class="container">
	<div class="row">
		<?php
			$default_thumb =  get_template_directory_uri() . '/images/placeholder.png';

			// Create list in grid
			foreach ($themelist as $key => $value) {
				$theme_thumb = 'https://themes.svn.wordpress.org/' . $value['slug'] . '/' . $value['version'] . '/screenshot.png';
				$ticket_link = 'https://themes.trac.wordpress.org/ticket/' . $value['id'];

				$output = '<div class="col-xs-3 themewrap">';
					$output .= '<div class="inner-col">';
						$output .= '<a target="_blank" href="' . esc_url($ticket_link) . '">';
						$output .= '<figure class="thumbnail">';
							$output .= '<img class="screenshot" src="' . esc_url($default_thumb) . '" data-src="' . esc_url($theme_thumb) . '" alt="thumb" />';
							$output .= '<span class="position">' . absint($key) .  '</span>';
							$output .= '<span class="author">' . esc_html($value['reporter']) .  '</span>';
						$output .= '</figure>';
						$output .= '<footer class="details clearfix">';
							$output .= esc_html($value['name']);
						$output .= '</footer>';
						$output .= '</a>';
					$output .= '</div>';
				$output .= '</div>';
				echo $output;
			}

		?>
	</div>
</section>

<script>
//<![CDATA[
	var trtPlaceholderIMG = '<?php echo esc_url( $default_thumb ); ?>';
//]]>
</script>

<?php
} else {
?>
<section class="container">
	<div class="row">
		<div class="col-xs-12 themepositions" style="text-align:center; margin-bottom: 150px; font-size: 24px;">
			<h4 class="login-heading"><?php _e( 'You need to login to see the results', 'textdomain' ); ?></h4>
			<?php wp_login_form(); ?>
		</div>
	</div>
</section>
<?php
}
get_footer();
