<?php
/*
Plugin Name: Photospace Custom
Description: A custom version of the <a href=http://thriveweb.com.au/the-lab/photospace-responsive/">Photospace Responsive</a> plugin by <a href=http://deanoakley.com/">Dean Oakley</a>.
Author: andruxnet
Author URI: http://andrux.net/
Version: 1.0
Text Domain: photospace-custom
*/

/*  Copyright 2010  Dean Oakley  (email : contact@deanoakley.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Illegal Entry');
}

//============================== Photospace options ========================//
class photospace_responsive_plugin_options {

	public static function PSR_getOptions() {

		$options = get_option('psr_options');

		if (!is_array($options)) {

			$options['enable_history'] = false;

			$options['num_thumb'] = '9';

			$options['show_captions'] = false;

			$options['show_controls'] = false;

			$options['auto_play'] = false;
			$options['delay'] = 3500;

			$options['button_size'] = 50;

			$options['hide_thumbs'] = false;

			$options['reset_css'] = false;

			$options['thumbnail_margin'] = 10;

			$options['thumbnail_width'] = 50;
			$options['thumbnail_height'] = 50;
			$options['thumbnail_crop'] = true;

			$options['max_image_height'] = '500';
			$options['max_image_width'] = '600';

			$options['play_text'] = 'Play Slideshow';
			$options['pause_text'] = 'Pause Slideshow';

			update_option('psr_options', $options);
		}
		return $options;
	}

	public static function update() {
		if(isset($_POST['psr_save'])) {
			$options = photospace_responsive_plugin_options::PSR_getOptions();

			$options['num_thumb'] = stripslashes($_POST['num_thumb']);
			$options['thumbnail_margin'] =  stripslashes($_POST['thumbnail_margin']);
			$options['thumbnail_width'] = stripslashes($_POST['thumbnail_width']);
			$options['thumbnail_height'] = stripslashes($_POST['thumbnail_height']);

			$options['max_image_width'] = stripslashes($_POST['max_image_width']);
			$options['max_image_height'] = stripslashes($_POST['max_image_height']);

			$options['delay'] = stripslashes($_POST['delay']);

			$options['button_size'] = stripslashes($_POST['button_size']);

			if (isset($_POST['enable_history'])) {
				$options['enable_history'] = (bool)true;
			} else {
				$options['enable_history'] = (bool)false;
			}


			if (isset($_POST['thumbnail_crop'])) {
				$options['thumbnail_crop'] = (bool)true;
			} else {
				$options['thumbnail_crop'] = (bool)false;
			}

			if (isset($_POST['show_controls'])) {
				$options['show_controls'] = (bool)true;
			} else {
				$options['show_controls'] = (bool)false;
			}


			if (isset($_POST['show_captions'])) {
				$options['show_captions'] = (bool)true;
			} else {
				$options['show_captions'] = (bool)false;
			}

			if (isset($_POST['auto_play'])) {
				$options['auto_play'] = (bool)true;
			} else {
				$options['auto_play'] = (bool)false;
			}

			if (isset($_POST['hide_thumbs'])) {
				$options['hide_thumbs'] = (bool)true;
			} else {
				$options['hide_thumbs'] = (bool)false;
			}

			if (isset($_POST['reset_css'])) {
				$options['reset_css'] = (bool)true;
			} else {
				$options['reset_css'] = (bool)false;
			}

			$options['play_text'] = stripslashes($_POST['play_text']);
			$options['pause_text'] = stripslashes($_POST['pause_text']);


			update_option('psr_options', $options);

		} else {
			photospace_responsive_plugin_options::PSR_getOptions();
		}

		add_submenu_page( 'options-general.php', 'Photospace Responsive options', 'Photospace Responsive', 'edit_theme_options', basename(__FILE__), array('photospace_responsive_plugin_options', 'display'));
	}


	public static function display() {

		$options = photospace_responsive_plugin_options::PSR_getOptions();
		?>

		<div id="photospace_res_admin" class="wrap">

			<h2>Photospace Options</h2>

			<form method="post" action="#" enctype="multipart/form-data">

				<div class="wp-menu-separator" class="ps_border" ></div>

				<p><label><input name="show_controls" type="checkbox" value="checkbox" <?php if($options['show_controls']) echo "checked='checked'"; ?> /> Show controls</label></p>

				<p><label><input name="enable_history" type="checkbox" value="checkbox" <?php if($options['enable_history']) echo "checked='checked'"; ?> /> Enable history </label></p>


				<p><label><input name="show_captions" type="checkbox" value="checkbox" <?php if($options['show_captions']) echo "checked='checked'"; ?> /> Show Title / Caption / Desc under image</label></p>

				<p><label><input name="reset_css" type="checkbox" value="checkbox" <?php if($options['reset_css']) echo "checked='checked'"; ?> /> Try to clear current theme image css / formatting</label></p>


				<div class="ps_border" ></div>

				<div class="fl_box">
					<p><label><input name="auto_play" type="checkbox" value="checkbox" <?php if($options['auto_play']) echo "checked='checked'"; ?> /> Auto play slide show</label></p>
				</div>
				<div class="fl_box">
					<p><label><input name="hide_thumbs" type="checkbox" value="checkbox" <?php if($options['hide_thumbs']) echo "checked='checked'"; ?> /> Hide thumbnails</label></p>
				</div>
				<div class="fl_box">
					<p>Slide delay in milliseconds</p>
					<p><input type="text" name="delay" value="<?php echo($options['delay']); ?>" /></p>
				</div>

				<div class="fl_box">
					<p>Page button size</p>
					<p><input type="text" name="button_size" value="<?php echo($options['button_size']); ?>" /></p>
				</div>


				<div class="ps_border" ></div>

				<h3 style="font-style:italic; font-weight:normal; color:grey " >Images that are already on the server will not change size until you regenerate the thumbnails. Use <a title="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/" href="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/">AJAX thumbnail rebuild</a> or <a title="http://wordpress.org/extend/plugins/regenerate-thumbnails/" href="http://wordpress.org/extend/plugins/regenerate-thumbnails/">Regenerate Thumbnails</a> </h3>
				<h3 style="font-style:italic; font-weight:normal; color:grey " >Max size should be set to the size your images stretch to when your theme is at full size.</h3>

				<div class="fl_box">
					<p>Thumbnail Width</p>
					<p><input type="text" name="thumbnail_width" value="<?php echo($options['thumbnail_width']); ?>" /></p>
				</div>

				<div class="fl_box">
					<p>Thumbnail Height</p>
					<p><input type="text" name="thumbnail_height" value="<?php echo($options['thumbnail_height']); ?>" /></p>
				</div>

				<div class="fl_box">
					<p>Max image width</p>
					<p><input type="text" name="max_image_width" value="<?php echo($options['max_image_width']); ?>" /></p>
				</div>

				<div class="fl_box">
					<p>Max image height</p>
					<p><input type="text" name="max_image_height" value="<?php echo($options['max_image_height']); ?>" /></p>
				</div>

				<div class="fl_box">
					<p>Crop thumbnails</p>
					<p><label><input name="thumbnail_crop" type="checkbox" value="checkbox" <?php if($options['thumbnail_crop']) echo "checked='checked'"; ?> /></label></p>

				</div>

				<div class="ps_border" ></div>

				<div class="fl_box">
					<p>Number of thumbnails</p>
					<p><input type="text" name="num_thumb" value="<?php echo($options['num_thumb']); ?>" /></p>
				</div>

				<div class="fl_box">
					<p>Thumbnail margin</p>
					<p><input type="text" name="thumbnail_margin" value="<?php echo($options['thumbnail_margin']); ?>" /></p>
				</div>


				<div class="ps_border" ></div>


				<div class="fl_box">
					<p>Play text</p>
					<p><input type="text" name="play_text" value="<?php echo($options['play_text']); ?>" /></p>
				</div>

				<div class="fl_box">
					<p>Pause text</p>
					<p><input type="text" name="pause_text" value="<?php echo($options['pause_text']); ?>" /></p>
				</div>

				<div class="ps_border" ></div>


				<p><input class="button-primary" type="submit" name="psr_save" value="Save Changes" /></p>

			</form>

		</div>

		<?php
	}
}

function PSR_getOption($option) {
    global $mytheme;
    return $mytheme->option[$option];
}

// register functions
add_action('admin_menu', array('photospace_responsive_plugin_options', 'update'));

$options = get_option('psr_options');

add_theme_support( 'post-thumbnails' );
add_image_size('photospace_responsive_thumbnails', $options['thumbnail_width'] * 2, $options['thumbnail_height'] * 2, $options['thumbnail_crop']);
add_image_size('photospace_responsive_full', $options['max_image_width'], $options['max_image_height']);

function admin_styles() {
	if ( is_admin() ) {
		wp_enqueue_style( 'photospace-custom', plugins_url( 'admin.css', __FILE__ ) );
	}
}
add_action( 'admin_enqueue_scripts', 'admin_styles' );

//============================== insert HTML header tag ========================//

function photospace_responsive_scripts_method() {
	wp_enqueue_style( 'photospace-res-styles',	plugins_url( 'gallery.css', __FILE__ ) );
	wp_enqueue_script( 'galleriffic', plugins_url( 'jquery.galleriffic.js', __FILE__ ), array( 'jquery' ) );
}
add_action('wp_enqueue_scripts', 'photospace_responsive_scripts_method');

function photospace_res_scripts_method_history() {
	wp_enqueue_script( 'history', plugins_url( 'jquery.history.js', __FILE__ ) );
}
if ($options['enable_history']) {
	add_action('wp_enqueue_scripts', 'photospace_res_scripts_method_history');
}

function photospace_responsive_wp_headers() {

	$options = get_option('psr_options');

	echo "<!--	photospace [ START ] --> \n";

	echo '<style type="text/css">';

	if($options['reset_css']){

		echo '
			/* reset */
			.photospace_res img,
			.photospace_res ul.thumbs,
			.photospace_res ul.thumbs li,
			.photospace_res ul.thumbs li a{
				padding:0;
				margin:0;
				border:none !important;
				background:none !important;
			}
			.photospace_res span{
				padding:0;
				margin:0;
				border:none !important;
				background:none !important;
			}
			';
	}

	echo '
		.photospace_res ul.thumbs img {
			width:'.$options['thumbnail_width'] .'px;
			height:'.$options['thumbnail_height'] .'px;
		}
	';


	if(!empty($options['button_size']))
		echo '
			.photospace_res .thumnail_row a.pageLink {
				width:'.$options['button_size'] .'px;
				height:'.$options['button_size'] .'px;
				line-height: '.$options['button_size'] .'px;
			}
		';

	if(!empty($options['thumbnail_margin']))
		echo '	.photospace_res ul.thumbs li{
					margin-bottom:'. $options['thumbnail_margin'] .'px !important;
					margin-right:'. $options['thumbnail_margin'] .'px !important;
				}
		';


	if($options['hide_thumbs']){
		echo '
			.photospace_res .thumnail_row{
				display:none !important;
			}
		';
	}

	echo '</style>';

	echo "<!--	photospace [ END ] --> \n";
}

add_action( 'wp_head', 'photospace_responsive_wp_headers', 10 );
add_shortcode( 'gallery', 'photospace_responsive_shortcode' );
add_shortcode( 'photospace_res', 'photospace_responsive_shortcode' );

function photospace_responsive_shortcode( $atts ) {

	global $post;
	global $photospace_res_count;

	$options = get_option('psr_options');

	if ( ! empty( $atts['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $atts['orderby'] ) )
			$atts['orderby'] = 'post__in';
		$atts['include'] = $atts['ids'];
	}

	extract(shortcode_atts(array(
		'id' 				=> intval($post->ID),
		'num_thumb' 		=> $options['num_thumb'],
		'num_preload' 		=> $options['num_thumb'],
		'show_captions' 	=> $options['show_captions'],
		'show_controls' 	=> $options['show_controls'],
		'auto_play' 		=> $options['auto_play'],
		'delay' 			=> $options['delay'],
		'hide_thumbs' 		=> $options['hide_thumbs'],
		'horizontal_thumb' 	=> 0,
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'include'    => '',
		'exclude'    => ''

	), $atts));


	$photospace_res_count += 1;
	$post_id = intval($post->ID) . '_' . $photospace_res_count;

	if ( 'RAND' == $order )
		$orderby = 'none';

	$hide_thumb_style = '';
	if($hide_thumbs){
		$hide_thumb_style = 'hide_me';
	}

	$thumb_style_init = "{'display':'none', 'opacity':'0', 'cursor': 'default'}";
	$thumb_paging_init = "{'display':'inline-block', 'opacity': '0.3', 'cursor': 'default'}";
	$thumb_paging_on = "{'display':'inline-block', 'opacity': '1', 'cursor': 'pointer'}";
	$thumb_style_on  = "{'opacity' : '1' , 'display' : 'inline-block', 'cursor' : 'pointer'}";
	$thumb_style_off  = "{'opacity': '0.3' , 'display' : 'inline-block', 'cursor' : 'default'}";

	$output_buffer ='

		<div class="gallery_clear"></div>
		<div id="gallery_'.$post_id.'" class="photospace_res">
			';

			if($show_controls){
				$output_buffer .='<div id="controls_'.$post_id.'" class="controls"></div>';
			}

			$output_buffer .='
			<!-- Start Advanced Gallery Html Containers -->
			<div class="thumbs_wrap2">
				<div class="thumbs_wrap">
					<div id="thumbs_'.$post_id.'" class="thumnail_row '. $hide_thumb_style . '" >';


						if ( !empty($include) ) {
							$include = preg_replace( '/[^0-9,]+/', '', $include );
							$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

							$attachments = array();
							foreach ( $_attachments as $key => $val ) {
								$attachments[$val->ID] = $_attachments[$key];
							}
						} elseif ( !empty($exclude) ) {
							$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
							$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
						} else {
							$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
						}

						$paging_class = $num_thumb < count($attachments) ? 'psg_paging' : 'psg_paging disable-paging' ;

						$output_buffer .='
						<ul class="thumbs noscript">';


						if ( !empty($attachments) ) {
							foreach ( $attachments as $aid => $attachment ) {
								$img = wp_get_attachment_image_src( $aid , 'photospace_responsive_full');
								$thumb = wp_get_attachment_image_src( $aid , 'photospace_responsive_thumbnails');

								$_post = get_post($aid);

								$image_title = esc_attr($_post->post_title);
								$image_alttext = get_post_meta($aid, '_wp_attachment_image_alt', true);
								$image_caption = $_post->post_excerpt;
								$image_description = $_post->post_content;

								$output_buffer .='
								<li><a class="thumb" href="' . $img[0] . '" title="' . $image_title . '" >
										<img src="' . $thumb[0] . '" alt="' . $image_alttext . '" title="' . $image_title . '" />
									</a>
									';

								if($show_captions){
									$output_buffer .='
										<div class="caption">
											';

										if($image_caption != ''){
											$output_buffer .='
														<div class="image-caption">' .  $image_caption . '</div>
													';
										}

										if($image_description != ''){
											$output_buffer .='
													<div class="image-desc">' .  $image_description . '</div>
													';
										}

									$output_buffer .='

									</div>
									';
								}

									$output_buffer .='
								</li>
							';
							}
						}

						$blank_thumb = get_stylesheet_directory_uri() . '/images/blank-thumb.jpg';
						$total_thumbs = count( $attachments );
						for ( $i = $total_thumbs; $i < $num_thumb; $i++ ) {
							$output_buffer .= '<li><a class="thumb thumb-blank" href="javascript:void(0);"><img src="' . $blank_thumb . '" /></a></li>
							';
						}

						$output_buffer .='
							<li class="psr_paging">
						         <a class="thumb pageLink prev" href="javascript:void(0);" title="Previous Page"></a>
					        </li>
							<li class="psr_paging">
						         <a class="thumb pageLink next" href="javascript:void(0);" title="Next Page"></a>
					        </li>
				        ';


						$output_buffer .='
						</ul>

					</div>
				</div>
			</div>

			<!-- Start Advanced Gallery Html Containers -->
			<div class="gal_content">
				';

				$output_buffer .='
				<div class="slideshow-container">
					<div id="loading_'.$post_id.'" class="loader"></div>
					<div id="slideshow_'.$post_id.'" class="slideshow"></div>
					<div id="caption_'.$post_id.'" class="caption-container"></div>
				</div>

			</div>

	</div>

	<div class="gallery_clear"></div>

	';

	$output_buffer .= "

	<script type='text/javascript'>

			jQuery(document).ready(function($) {

				// We only want these styles applied when javascript is enabled
				$('.gal_content').css('display', 'block');

				// Initialize Advanced Galleriffic Gallery
				var gallery = $('#thumbs_".$post_id."').galleriffic({
					delay:                     " . intval($delay) . ",
					numThumbs:                 " . intval($num_thumb) . ",
					preloadAhead:              " . intval($num_preload) . ",
					enableTopPager:            false,
					enableBottomPager:         false,
					imageContainerSel:         '#slideshow_".$post_id."',
					controlsContainerSel:      '#controls_".$post_id."',
					captionContainerSel:       '#caption_".$post_id."',
					loadingContainerSel:       '#loading_".$post_id."',
					renderSSControls:          true,
					renderNavControls:         false,
					playLinkText:              '". $options['play_text'] ."',
					pauseLinkText:             '". $options['pause_text'] ."',
					enableHistory:              " . intval($options['enable_history']) . ",
					autoStart:                 	" . intval($auto_play) . ",
					enableKeyboardNavigation:	true,
					syncTransitions:           	false,
					defaultTransitionDuration: 	300,

					onTransitionOut:           function(slide, caption, isSync, callback) {
						slide.fadeTo(this.getDefaultTransitionDuration(isSync), 0.0, callback);
						caption.fadeTo(this.getDefaultTransitionDuration(isSync), 0.0);
					},
					onTransitionIn:            function(slide, caption, isSync) {
						var duration = this.getDefaultTransitionDuration(isSync);
						slide.fadeTo(duration, 1.0);

						// Position the caption at the bottom of the image and set its opacity
						var slideImage = slide.find('img');
						caption.fadeTo(duration, 1.0);

					},
					onPageTransitionOut:       function(callback) {
						//this.hide();
						setTimeout(callback, 100); // wait a bit
					},
					onPageTransitionIn:        function() {
						//var prevPageLink = this.find('a.prev').css(".$thumb_paging_on.");
						//var nextPageLink = this.find('a.next').css(".$thumb_paging_on.");

						// Show appropriate next / prev page links
						//if (this.displayedPage > 0)
							//prevPageLink.css(".$thumb_paging_on.");

						var lastPage = this.getNumPages() - 1;
						//if (this.displayedPage < lastPage)
							//nextPageLink.css(".$thumb_paging_on.");

						//this.fadeTo('fast', 1.0);
					}

				});

				";

			$output_buffer .= "
				/**************** Event handlers for custom next / prev page links **********************/
				gallery.find('a.prev').click(function(e) {
					gallery.previousPage();
					e.preventDefault();
				});

				gallery.find('a.next').click(function(e) {
					gallery.nextPage();
					e.preventDefault();
				});

			});
		</script>

		";

		return $output_buffer;
}