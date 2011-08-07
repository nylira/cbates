<?php

class Watermark_Reloaded {
	/**
	 * Watermark RELOADED version
	 *
	 * @var string
	 */
	public $version                 = '1.2.5';
	
	/**
	 * Array with default options
	 *
	 * @var array
	 */
	protected $_options             = array(
		'watermark_donated'  => 0,
		'watermark_hide_nag' => 0,
		'watermark_on'       => array(),
		'watermark_position' => 'bottom_right',
		'watermark_offset'   => array(
			'x' => 5,
			'y' => 5
		),
		'watermark_text'     => array(
			'value' => null,
			'font'  => 'Arial.ttf',
			'size'  => 20,
			'color' => '000000'
		)
	);
	
	/**
	 * Plugin work path
	 *
	 * @var string
	 */
	protected $_plugin_dir          = null;
	
	/**
	 * Settings url
	 *
	 * @var string
	 */
	protected $_settings_url        = null;
	
	/**
	 * Path to dir containing fonts
	 *
	 * @var string
	 */
	protected $_fonts_dir           = 'fonts/';
	
	/**
	 * Get option by setting name with default value if option is unexistent
	 *
	 * @param string $setting
	 * @return mixed
	 */
	protected function get_option($setting) {
	    if(is_array($this->_options[$setting])) {
	        $options = array_merge($this->_options[$setting], get_option($setting));
	    } else {
	        $options = get_option($setting, $this->_options[$setting]);
	    }

	    return $options;
	}
	
	/**
	 * Get array with options
	 *
	 * @return array
	 */
	private function get_options() {
		$options = array();
		
		// loop through default options and get user defined options
		foreach($this->_options as $option => $value) {
			$options[$option] = $this->get_option($option);
		}
		
		return $options;
	}
	
	/**
	 * Merge configuration array with the default one
	 *
	 * @param array $default
	 * @param array $opt
	 * @return array
	 */
	private function mergeConfArray($default, $opt) {
		foreach($default as $option => $values)	{
			if(!empty($opt[$option])) {
				$default[$option] = is_array($values) ? array_merge($values, $opt[$option]) : $opt[$option];
				$default[$option] = is_array($values) ? array_intersect_key($default[$option], $values) : $opt[$option];
			}
		}

		return $default;
    }
	
	/**
	 * Plugin installation method
	 */
	public function activateWatermark() {
		// record install time
		add_option('watermark_installed', time(), null, 'no');
				
		// loop through default options and add them into DB
		foreach($this->_options as $option => $value) {
			add_option($option, $value, null, 'no');	
		}
	}
	
	/**
	 * Create preview for admin
	 *
	 * @param array $opt
	 */
	public function createPreview(array $opt) {
		// merge custom settings with default settings
		$opt = $this->mergeConfArray($this->_options, $opt);
		
		// calculate required size of image
		$bbox = $this->calculateBBox($opt);
		$size = array(
			'width'  => $bbox['width']  + $this->_options['watermark_offset']['x'] * 2,
			'height' =>	$bbox['height'] + $this->_options['watermark_offset']['y'] * 2
		);

		// Create the image
		$image = imagecreatetruecolor($size['width'], $size['height']);

		// Add some background to image (#CCCCCC)
		$color = imagecolorallocate($image, 204, 204, 204);
		imagefilledrectangle($image, 0, 0, $size['width'], $size['height'], $color);
		
		// And finaly write text to image
		$this->imageAddText($image, $opt);
		
		// Set the content-type
		header('Content-type: image/png');
		
		// Output the image using imagepng()
		imagepng($image);
		imagedestroy($image);
	}
	
	/**
	 * Apply watermark to selected image sizes
	 *
	 * @param array $data
	 * @return array
	 */
	public function applyWatermark($data) {
		// get settings for watermarking
		$upload_dir   = wp_upload_dir();
		$watermark_on = $this->get_option('watermark_on');

		// loop through image sizes ...
		foreach($watermark_on as $image_size => $on) {
			if($on == true) {
				switch($image_size) {
					case 'fullsize':
						$filepath = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $data['file'];
						break;
					default:
						if(!empty($data['sizes']) && array_key_exists($image_size, $data['sizes'])) {
							$filepath = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . dirname($data['file']) . DIRECTORY_SEPARATOR . $data['sizes'][$image_size]['file'];
						} else {
							// early getaway
							continue 2;
						}	
				}
				
				// ... and apply watermark
				$this->doWatermark($filepath);
			}
		}

		// pass forward attachment metadata
		return $data;
	}
	
	/**
	 * Apply watermark to certain image
	 *
	 * @param string $filepath
	 * @return boolean
	 */
	public function doWatermark($filepath) {
		// get image mime type
		$mime_type = wp_check_filetype($filepath);
		$mime_type = $mime_type['type'];
		
		// get watermark settings
		$options = $this->get_options();

		// get image resource
		$image = $this->getImageResource($filepath, $mime_type);

		// add text watermark to image
		$this->imageAddText($image, $options);

		// save watermarked image
		return $this->saveImageFile($image, $mime_type, $filepath);
	}
	
	/**
	 * Add watermark text to image
	 *
	 * @param resource $image
	 * @param array $opt
	 * @return resource
	 */
	private function imageAddText($image, array $opt) {
		// allocate text color
		$color  = $this->imageColorAllocateHex($image, $opt['watermark_text']['color']);
		
		// calculate watermark position and get full path to font file
		$offset = $this->calculateOffset($image, $opt);
		$opt    = $this->getFontFullpath($opt);

		// Add the text to image
		imagettftext($image, $opt['watermark_text']['size'], 0, $offset['x'], $offset['y'], $color, $opt['watermark_text']['font'], $opt['watermark_text']['value']);
		
		return $image;
	}
	
	/**
	 * Allocate a color for an image from HEX code
	 *
	 * @param resource $image
	 * @param string $hexstr
	 * @return int
	 */
	private function imageColorAllocateHex($image, $hexstr) {
		$int = hexdec($hexstr);

		return imagecolorallocate($image,
			0xFF & ($int >> 0x10),
			0xFF & ($int >> 0x8),
			0xFF & $int
		);
	}
	
	/**
	 * Calculate offset acording to watermark alignment
	 *
	 * @param resource $image
	 * @param array $opt
	 * @return array
	 */
	private function calculateOffset($image, array $opt) {
		$offset = array('x' => 0, 'y' => 0);

		// get image size and calculate bounding box
		$isize  = $this->getImageSize($image);
		$bbox   = $this->calculateBBox($opt);

		list($ypos, $xpos) = explode('_', $opt['watermark_position']);
		
		// calculate offset according to equations bellow
		switch($xpos) {
			default:
			case 'left':
				$offset['x'] = 0 - $bbox['top_left']['x'] + $opt['watermark_offset']['x'];
				break;
			case 'center':
				$offset['x'] = ($isize['x'] / 2) - ($bbox['top_right']['x'] / 2) + $opt['watermark_offset']['x'];
				break;
			case 'right':
				$offset['x'] = $isize['x'] - $bbox['bottom_right']['x'] - $opt['watermark_offset']['x'];
				break;
		}
		
		switch($ypos) {
			default:
			case 'top':
				$offset['y'] = 0 - $bbox['top_left']['y'] + $opt['watermark_offset']['y'];
				break;
			case 'middle':
				$offset['y'] = ($isize['y'] / 2) - ($bbox['top_right']['y'] / 2) + $opt['watermark_offset']['y'];
				break;
			case 'bottom':
				$offset['y'] = $isize['y'] - $bbox['bottom_right']['y'] - $opt['watermark_offset']['y'];
				break;
		}

		return $offset;
	}
	
	/**
	 * Get array with image size
	 *
	 * @param resource $image
	 * @return array
	 */
	private function getImageSize($image) {
		return array(
			'x' => imagesx($image),
			'y' => imagesy($image)
		);
	}
	
	/**
	 * Calculate bounding box of watermark
	 *
	 * @param array $opt
	 * @return array
	 */
	private function calculateBBox(array $opt) {
		// http://ruquay.com/sandbox/imagettf/
		$opt = $this->getFontFullpath($opt);

		$bbox = imagettfbbox(
			$opt['watermark_text']['size'],
			0,
			$opt['watermark_text']['font'],
			$opt['watermark_text']['value']
		);

		$bbox = array(
			'bottom_left'  => array(
				'x' => $bbox[0],
				'y' => $bbox[1]
			),
			'bottom_right' => array(
				'x' => $bbox[2],
				'y' => $bbox[3]
			),
			'top_right'    => array(
				'x' => $bbox[4],
				'y' => $bbox[5]
			),
			'top_left'     => array(
				'x' => $bbox[6],
				'y' => $bbox[7]
			)
		);
		
		// calculate width & height of text
		$bbox['width']  = $bbox['top_right']['x'] - $bbox['top_left']['x'];
		$bbox['height'] = $bbox['bottom_left']['y'] - $bbox['top_left']['y'];
		
		return $bbox;
	}
	
	/**
	 * Get fullpath of font
	 *
	 * @param array $opt
	 * @return unknown
	 */
	private function getFontFullpath(array $opt) {
		$opt['watermark_text']['font'] = WP_PLUGIN_DIR . $this->_plugin_dir . $this->_fonts_dir . $opt['watermark_text']['font'];
		
		return $opt;
	}
	
	/**
	 * Get image resource accordingly to mimetype
	 *
	 * @param string $filepath
	 * @param string $mime_type
	 * @return resource
	 */
	private function getImageResource($filepath, $mime_type) {
		switch ( $mime_type ) {
			case 'image/jpeg':
				return imagecreatefromjpeg($filepath);
			case 'image/png':
				return imagecreatefrompng($filepath);
			case 'image/gif':
				return imagecreatefromgif($filepath);
			default:
				return false;
		}
	}
	
	/**
	 * Save image from image resource
	 *
	 * @param resource $image
	 * @param string $mime_type
	 * @param string $filepath
	 * @return boolean
	 */
	private function saveImageFile($image, $mime_type, $filepath) {
		switch ( $mime_type ) {
			case 'image/jpeg':
				return imagejpeg($image, $filepath, apply_filters( 'jpeg_quality', 90 ));
			case 'image/png':
				return imagepng($image, $filepath);
			case 'image/gif':
				return imagegif($image, $filepath);
			default:
				return false;
		}
	}
}

class Watermark_Reloaded_Admin extends Watermark_Reloaded {
	/**
	 * Error messages to diplay
	 *
	 * @var array
	 */
	private $_messages = array();
	
	/**
	 * List of available image sizes
	 *
	 * @var array
	 */
	private $_image_sizes         = array('thumbnail', 'medium', 'large', 'fullsize');
	
	/**
	 * List of available watermark positions
	 *
	 * @var array
	 */
	private $_watermark_positions = array(
		'x' => array('left', 'center', 'right'),
		'y' => array('top', 'middle', 'bottom')
	);
	
	/**
	 * Class constructor
	 *
	 */
	public function __construct() {
		$this->_plugin_dir   = DIRECTORY_SEPARATOR . str_replace(basename(__FILE__), null, plugin_basename(__FILE__));
		$this->_settings_url = 'options-general.php?page=' . plugin_basename(__FILE__);;
		
		$allowed_options = array(
			'watermark_donated',
			'watermark_hide_nag'
		);
		
		// set watermark options
		if(array_key_exists('option_name', $_GET) && array_key_exists('option_value', $_GET)
			&& in_array($_GET['option_name'], $allowed_options)) {
			update_option($_GET['option_name'], $_GET['option_value']);
			
			header("Location: " . $this->_settings_url);
			die();	
		// if user requested preview display preview image
		} elseif(array_key_exists('watermarkPreview', $_GET)) {
			$this->createPreview($_GET);
			die();
		} else {
			// register installer function
			register_activation_hook(WR_LOADER, array(&$this, 'activateWatermark'));
			
			// patch for the fonts fix in previous versions
			$watermark_text = get_option('watermark_text');
			if(false === strpos(strtolower($watermark_text['font']), 'ttf')) {
				$watermark_text['font'] = $watermark_text['font'] . '.ttf';
				update_option('watermark_text', $watermark_text);
			}
			
			// add plugin "Settings" action on plugin list
			add_action('plugin_action_links_' . plugin_basename(WR_LOADER), array(&$this, 'add_plugin_actions'));
			
			// add links for plugin help, donations,...
			add_filter('plugin_row_meta', array(&$this, 'add_plugin_links'), 10, 2);
			
			// push options page link, when generating admin menu
			add_action('admin_menu', array(&$this, 'adminMenu'));
			
			add_action('pre-upload-ui', array(&$this, 'uploadDonationsNag'));
	
			// check if post_id is "-1", meaning we're uploading watermark image
			if(!(array_key_exists('post_id', $_REQUEST) && $_REQUEST['post_id'] == -1)) {
				// add filter for watermarking images
				add_filter('wp_generate_attachment_metadata', array(&$this, 'applyWatermark'));
			}
		}
	}
	
	/**
	 * Add "Settings" action on installed plugin list
	 */
	public function add_plugin_actions($links) {
		array_unshift($links, '<a href="options-general.php?page=' . plugin_basename(__FILE__) . '">' . __('Settings') . '</a>');
		
		return $links;
	}
	
	/**
	 * Add links on installed plugin list
	 */
	public function add_plugin_links($links, $file) {
		if($file == plugin_basename(WR_LOADER)) {
			$links[] = '<a href="http://randomplac.es/wordpress-plugins/donate/">Donate</a>';
		}
		
		return $links;
	}
	
	/**
	 * Add menu entry for Watermark RELOADED settings and attach style and script include methods
	 */
	public function adminMenu() {		
		// add option in admin menu, for setting details on watermarking
		$plugin_page = add_options_page('Watermark Reloaded Options', 'Watermark Reloaded', 8, __FILE__, array(&$this, 'optionsPage'));

		add_action('admin_print_styles-' . $plugin_page,     array(&$this, 'installStyles'));
		add_action('admin_print_scripts-' . $plugin_page,    array(&$this, 'installScripts'));
		// also add JS to media upload popup
		add_action('admin_print_scripts-media-upload-popup', array(&$this, 'installScripts'));
	}
	
	/**
	 * Include styles used by Watermark RELOADED
	 */
	public function installStyles() {
		// Colorpicker
		wp_enqueue_style('jquery-colorpicker', WP_PLUGIN_URL . $this->_plugin_dir . 'jQueryPlugins/colorpicker/css/colorpicker.css');
		
		wp_enqueue_style('watermark-reloaded', WP_PLUGIN_URL . $this->_plugin_dir . 'style.css');
	}
	
	/**
	 * Include scripts used by Watermark RELOADED
	 */
	public function installScripts() {
		// Colorpicker
		wp_enqueue_script('jquery-colorpicker', WP_PLUGIN_URL . $this->_plugin_dir . 'jQueryPlugins/colorpicker/js/colorpicker.js');

		wp_enqueue_script('watermark-reloaded', WP_PLUGIN_URL . $this->_plugin_dir . 'script.js', $this->version);
	}
	
	/**
	 * List available fonts from fonts dir
	 *
	 * @return array
	 */
	private function getFonts() {
		$fonts_dir = WP_PLUGIN_DIR . $this->_plugin_dir . $this->_fonts_dir;
		
		$fonts = array();
		try {
			$dir = new DirectoryIterator($fonts_dir);
	
			foreach($dir as $file) {
				if($file->isFile()) {
					$font = pathinfo($file->getFilename());
					
					if(strtolower($font['extension']) == 'ttf') {
						if(!$file->isReadable()) {
							$this->_messages['unreadable-font'] = sprintf('Some fonts might be unreadable, try chmoding contents of the folder <strong>%s</string> to writable and refresh this page.', $this->_plugin_dir . $this->_fonts_dir);
						}

						$fonts[$font['basename']] = str_replace('_', ' ', $font['filename']);	
					}
				}
			}
			
			ksort($fonts);
		} catch(Exception $e) {}
		
		return $fonts;
	}

	/**
	 * Nag a little bit for Donation :)
	 */
	private function donationsNag() {
		$is_one_month = time() - $this->get_option('watermark_installed') > 60 * 60 * 24 * 30;
		if($is_one_month && !$this->get_option('watermark_donated') && !$this->get_option('watermark_hide_nag')) {
			$this->_messages['updated'][] =
				'Thanks for using <a href="' . $this->_settings_url . '">Watermark RELOADED</a>! You\'ve installed this plugin over a month ago.' . PHP_EOL .
				'If it works and you are satisfied with it, isn\'t it worth at least a few Euros/Dollars?' . PHP_EOL .
				'Donations help me to continue support and development of this <em>free</em> software!' . PHP_EOL .
				'<a href="http://randomplac.es/wordpress-plugins/donate/" target="_blank">Sure, no problem!</a>' . PHP_EOL .
				'<a href="' . $this->_settings_url . '&option_name=watermark_donated&option_value=1" rel="ajax" style="float: right; display: block; border: none; margin: 3px 0 0 10px;">' . PHP_EOL .
					'<small style="font-weight: normal;">' . PHP_EOL .
						'Sure, but I already did!' . PHP_EOL .
					'</small>' . PHP_EOL .
				'</a>' . PHP_EOL .
				'<a href="' . $this->_settings_url . '&option_name=watermark_hide_nag&option_value=1" rel="ajax" style="float: right; display: block; border: none; margin: 3px 0 0;">' . PHP_EOL .
					'<small style="font-weight: normal;">' . PHP_EOL .
						'No thanks, please don\'t bug me anymore!' . PHP_EOL .
					'</small>' . PHP_EOL .
				'</a>' . PHP_EOL .
				'<br clear="both" />';
		} elseif($this->get_option('watermark_donated') && !$this->get_option('watermark_hide_nag')) {
			$this->_messages['updated'][] =
				'Thank you very much for your donation. You help me to continue support and development of this plugin and other free software!' . PHP_EOL .
				'<a href="' . $this->_settings_url . '&option_name=watermark_hide_nag&option_value=1">' . PHP_EOL .
					'<small style="font-weight: normal;">' . PHP_EOL .
						'Hide this notice' . PHP_EOL .
					'</small>' . PHP_EOL .
				'</a>';
		}
	}
	
	/**
	 * Nag for Donation in image upload form
	 */
	public function uploadDonationsNag() {
		$this->donationsNag();

		$watermark_on = $this->get_option('watermark_on');
		if( !empty( $watermark_on ) ) {
			foreach($this->_messages as $namespace => $messages) {
				foreach($messages as $message) {
?>
<div class="<?php echo $namespace; ?>">
	<p>
		<strong><?php echo $message; ?></strong>
	</p>
</div>
<?php
				}
			}
		}
	}
	
	/**
	 * Display options page
	 */
	public function optionsPage() {
		// if user clicked "Save Changes" save them
		if(isset($_POST['Submit'])) {
			foreach($this->_options as $option => $value) {
				if(array_key_exists($option, $_POST)) {
					update_option($option, $_POST[$option]);
				} else {
					update_option($option, $value);
				}
			}

			$this->_messages['updated'][] = 'Options updated!';
		}

		if( !extension_loaded( 'gd' ) ) {
			$this->_messages['error'][] = 'Watermark RELOADED will not work without PHP extension GD.';
			
			$gd_info = gd_info();
			if ( !$gd_info['FreeType Support'] ) {
				$this->_messages['error'] = 'Text watermarking requires FreeType Library.';
			}
		}
		
		// add donations nag messages
		$this->donationsNag();
	
		foreach($this->_messages as $namespace => $messages) {
			foreach($messages as $message) {
?>
<div class="<?php echo $namespace; ?>">
	<p>
		<strong><?php echo $message; ?></strong>
	</p>
</div>
<?php
			}
		}
?>
<script type="text/javascript">var wpurl = "<?php bloginfo('wpurl'); ?>";</script>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>Watermark Reloaded Settings</h2>
		<form method="post" action="">
			<table class="form-table">

				<tr valign="top">
					<th scope="row">Enable watermark for</th>
					<td>
						<fieldset>
						<legend class="screen-reader-text"><span>Enable watermark for</span></legend>
						
						<?php $watermark_on = array_keys($this->get_option('watermark_on')); ?>
						<?php foreach($this->_image_sizes as $image_size) : ?>
							
							<?php $checked = in_array($image_size, $watermark_on); ?>
						
							<label>
								<input name="watermark_on[<?php echo $image_size; ?>]" type="checkbox" id="watermark_on_<?php echo $image_size; ?>" value="1"<?php echo $checked ? ' checked="checked"' : null; ?> />
								<?php echo ucfirst($image_size); ?>
							</label>
							<br />
						<?php endforeach; ?>
						
							<span class="description">Check image sizes on which watermark should appear.</span>						
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Watermark alignment</th>
					<td>
						<fieldset>
						<legend class="screen-reader-text"><span>Watermark alignment</span></legend>
						
							<table id="watermark_position" border="1">

								<?php $watermark_position = $this->get_option('watermark_position'); ?>
								<?php foreach($this->_watermark_positions['y'] as $y) : ?>
								<tr>
									<?php foreach($this->_watermark_positions['x'] as $x) : ?>
									<?php $checked = $watermark_position == $y . '_' . $x; ?>

									<td title="<?php echo ucfirst($y . ' ' . $x); ?>">
										<input name="watermark_position" type="radio" value="<?php echo $y . '_' . $x; ?>"<?php echo $checked ? ' checked="checked"' : null; ?> />
									</td>
									<?php endforeach; ?>
								</tr>
								<?php endforeach; ?>
							</table>
							
							<span class="description">Chose where on image watermark should be positioned.</span>

						</fieldset>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Watermark offset</th>
					<td>
						<fieldset>
						<legend class="screen-reader-text"><span>Watermark offset</span></legend>

							<?php $watermark_offset = $this->get_option('watermark_offset'); ?>
							
							<?php foreach(array('x', 'y') as $direction) : ?>							
							<?php echo $direction; ?>: <input class="wr_right" name="watermark_offset[<?php echo $direction; ?>]" type="text" value="<?php echo $watermark_offset[$direction]; ?>" size="2" />px<br />
							<?php endforeach; ?>

						</fieldset>
					</td>
				</tr>

			</table>

			<a name="watermark_text"></a>
			<div id="watermark_text" class="watermark_type">
				<h3>Text watermark</h3>
				<p>If you chose watermark should be text define how it should look like.</p>

				<table class="form-table">
					<?php $watermark_text = $this->get_option('watermark_text'); ?>
					
					<tr valign="top">
						<th scope="row">Watermark text</th>
						<td class="wr_width">
							<fieldset class="wr_width">
							<legend class="screen-reader-text"><span>Watermark text</span></legend>
	
								<input name="watermark_text[value]" type="text" value="<?php echo $watermark_text['value']; ?>" />
							
							</fieldset>
						</td>
						<th scope="row" class="nowidth">Preview</th>
					</tr>

					<tr valign="top">
						<th scope="row">Font</th>
						<td class="wr_width">
							<fieldset class="wr_width">
							<legend class="screen-reader-text"><span>Font</span></legend>
	
								<select class="wr_width" name="watermark_text[font]">
									<?php foreach($this->getFonts() as $key => $value) : ?>
									
									<?php $selected = $watermark_text['font'] == $key; ?>
	
									<option value="<?php echo $key; ?>" style="font-family: '<?php echo $value; ?>';"<?php echo $selected ? ' selected="selected"' : null; ?>>
										<?php echo $value; ?>
									</option>
									<?php endforeach; ?>
								</select>
							
							</fieldset>
						</td>
						<td rowspan="3">
							<img id="previewImg_text" src="" alt="" />
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row">Text size</th>
						<td class="wr_width">
							<fieldset class="wr_width">
							<legend class="screen-reader-text"><span>Text size</span></legend>
							
							<input class="wr_right" name="watermark_text[size]" type="text" value="<?php echo $watermark_text['size']; ?>" size="3" />
							<?php
							// http://php.net/imagettftext - $size attribute uses "px" in GD v1 and "pt" in GD v2
							echo version_compare(GD_VERSION, 2, '>=') ? 'pt' : 'px';
							?>
							
							</fieldset>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row">Text color</th>
						<td class="wr_width">
							<fieldset class="wr_width">
							<legend class="screen-reader-text"><span>Text color</span></legend>
							
							<span id="watermark_text_color_hash">#</span><input name="watermark_text[color]" type="text" maxlength="6" size="6" value="<?php echo $watermark_text['color']; ?>" />
							<div class="colorSelector">
								<div<?php if(!empty($watermark_text['color'])) : ?> style="background-color: #<?php echo $watermark_text['color']; ?>;"<?php endif; ?>></div>
							</div>
	
							</fieldset>
						</td>
					</tr>
					
				</table>
			</div>

			<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
			</p>

		</form>
</div>
<?php
	}
}

$watermark = new Watermark_Reloaded_Admin();
?>