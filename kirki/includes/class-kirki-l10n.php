<?php
/**
 * Internationalization helper.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'Kirki_l10n' ) ) {

	/**
	 * Handles translations
	 */
	class Kirki_l10n {

		/**
		 * The plugin textdomain
		 *
		 * @access protected
		 * @var string
		 */
		protected $textdomain = 'distinctpress-pro';

		/**
		 * The class constructor.
		 * Adds actions & filters to handle the rest of the methods.
		 *
		 * @access public
		 */
		public function __construct() {

			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		}

		/**
		 * Load the plugin textdomain
		 *
		 * @access public
		 */
		public function load_textdomain() {

			if ( null !== $this->get_path() ) {
				load_textdomain( $this->textdomain, $this->get_path() );
			}
			load_plugin_textdomain( $this->textdomain, false, Kirki::$path . '/languages' );

		}

		/**
		 * Gets the path to a translation file.
		 *
		 * @access protected
		 * @return string Absolute path to the translation file.
		 */
		protected function get_path() {
			$path_found = false;
			$found_path = null;
			foreach ( $this->get_paths() as $path ) {
				if ( $path_found ) {
					continue;
				}
				$path = wp_normalize_path( $path );
				if ( file_exists( $path ) ) {
					$path_found = true;
					$found_path = $path;
				}
			}

			return $found_path;

		}

		/**
		 * Returns an array of paths where translation files may be located.
		 *
		 * @access protected
		 * @return array
		 */
		protected function get_paths() {

			return array(
				WP_LANG_DIR . '/' . $this->textdomain . '-' . get_locale() . '.mo',
				Kirki::$path . '/languages/' . $this->textdomain . '-' . get_locale() . '.mo',
			);

		}

		/**
		 * Shortcut method to get the translation strings
		 *
		 * @static
		 * @access public
		 * @param string $config_id The config ID. See Kirki_Config.
		 * @return array
		 */
		public static function get_strings( $config_id = 'global' ) {

			$translation_strings = array(
				'background-color'      => esc_attr__( 'Background Color', 'distinctpress-pro' ),
				'background-image'      => esc_attr__( 'Background Image', 'distinctpress-pro' ),
				'no-repeat'             => esc_attr__( 'No Repeat', 'distinctpress-pro' ),
				'repeat-all'            => esc_attr__( 'Repeat All', 'distinctpress-pro' ),
				'repeat-x'              => esc_attr__( 'Repeat Horizontally', 'distinctpress-pro' ),
				'repeat-y'              => esc_attr__( 'Repeat Vertically', 'distinctpress-pro' ),
				'inherit'               => esc_attr__( 'Inherit', 'distinctpress-pro' ),
				'background-repeat'     => esc_attr__( 'Background Repeat', 'distinctpress-pro' ),
				'cover'                 => esc_attr__( 'Cover', 'distinctpress-pro' ),
				'contain'               => esc_attr__( 'Contain', 'distinctpress-pro' ),
				'background-size'       => esc_attr__( 'Background Size', 'distinctpress-pro' ),
				'fixed'                 => esc_attr__( 'Fixed', 'distinctpress-pro' ),
				'scroll'                => esc_attr__( 'Scroll', 'distinctpress-pro' ),
				'background-attachment' => esc_attr__( 'Background Attachment', 'distinctpress-pro' ),
				'left-top'              => esc_attr__( 'Left Top', 'distinctpress-pro' ),
				'left-center'           => esc_attr__( 'Left Center', 'distinctpress-pro' ),
				'left-bottom'           => esc_attr__( 'Left Bottom', 'distinctpress-pro' ),
				'right-top'             => esc_attr__( 'Right Top', 'distinctpress-pro' ),
				'right-center'          => esc_attr__( 'Right Center', 'distinctpress-pro' ),
				'right-bottom'          => esc_attr__( 'Right Bottom', 'distinctpress-pro' ),
				'center-top'            => esc_attr__( 'Center Top', 'distinctpress-pro' ),
				'center-center'         => esc_attr__( 'Center Center', 'distinctpress-pro' ),
				'center-bottom'         => esc_attr__( 'Center Bottom', 'distinctpress-pro' ),
				'background-position'   => esc_attr__( 'Background Position', 'distinctpress-pro' ),
				'background-opacity'    => esc_attr__( 'Background Opacity', 'distinctpress-pro' ),
				'on'                    => esc_attr__( 'ON', 'distinctpress-pro' ),
				'off'                   => esc_attr__( 'OFF', 'distinctpress-pro' ),
				'all'                   => esc_attr__( 'All', 'distinctpress-pro' ),
				'cyrillic'              => esc_attr__( 'Cyrillic', 'distinctpress-pro' ),
				'cyrillic-ext'          => esc_attr__( 'Cyrillic Extended', 'distinctpress-pro' ),
				'devanagari'            => esc_attr__( 'Devanagari', 'distinctpress-pro' ),
				'greek'                 => esc_attr__( 'Greek', 'distinctpress-pro' ),
				'greek-ext'             => esc_attr__( 'Greek Extended', 'distinctpress-pro' ),
				'khmer'                 => esc_attr__( 'Khmer', 'distinctpress-pro' ),
				'latin'                 => esc_attr__( 'Latin', 'distinctpress-pro' ),
				'latin-ext'             => esc_attr__( 'Latin Extended', 'distinctpress-pro' ),
				'vietnamese'            => esc_attr__( 'Vietnamese', 'distinctpress-pro' ),
				'hebrew'                => esc_attr__( 'Hebrew', 'distinctpress-pro' ),
				'arabic'                => esc_attr__( 'Arabic', 'distinctpress-pro' ),
				'bengali'               => esc_attr__( 'Bengali', 'distinctpress-pro' ),
				'gujarati'              => esc_attr__( 'Gujarati', 'distinctpress-pro' ),
				'tamil'                 => esc_attr__( 'Tamil', 'distinctpress-pro' ),
				'telugu'                => esc_attr__( 'Telugu', 'distinctpress-pro' ),
				'thai'                  => esc_attr__( 'Thai', 'distinctpress-pro' ),
				'serif'                 => _x( 'Serif', 'font style', 'distinctpress-pro' ),
				'sans-serif'            => _x( 'Sans Serif', 'font style', 'distinctpress-pro' ),
				'monospace'             => _x( 'Monospace', 'font style', 'distinctpress-pro' ),
				'font-family'           => esc_attr__( 'Font Family', 'distinctpress-pro' ),
				'font-size'             => esc_attr__( 'Font Size', 'distinctpress-pro' ),
				'font-weight'           => esc_attr__( 'Font Weight', 'distinctpress-pro' ),
				'line-height'           => esc_attr__( 'Line Height', 'distinctpress-pro' ),
				'font-style'            => esc_attr__( 'Font Style', 'distinctpress-pro' ),
				'letter-spacing'        => esc_attr__( 'Letter Spacing', 'distinctpress-pro' ),
				'top'                   => esc_attr__( 'Top', 'distinctpress-pro' ),
				'bottom'                => esc_attr__( 'Bottom', 'distinctpress-pro' ),
				'left'                  => esc_attr__( 'Left', 'distinctpress-pro' ),
				'right'                 => esc_attr__( 'Right', 'distinctpress-pro' ),
				'center'                => esc_attr__( 'Center', 'distinctpress-pro' ),
				'justify'               => esc_attr__( 'Justify', 'distinctpress-pro' ),
				'color'                 => esc_attr__( 'Color', 'distinctpress-pro' ),
				'add-image'             => esc_attr__( 'Add Image', 'distinctpress-pro' ),
				'change-image'          => esc_attr__( 'Change Image', 'distinctpress-pro' ),
				'no-image-selected'     => esc_attr__( 'No Image Selected', 'distinctpress-pro' ),
				'add-file'              => esc_attr__( 'Add File', 'distinctpress-pro' ),
				'change-file'           => esc_attr__( 'Change File', 'distinctpress-pro' ),
				'no-file-selected'      => esc_attr__( 'No File Selected', 'distinctpress-pro' ),
				'remove'                => esc_attr__( 'Remove', 'distinctpress-pro' ),
				'select-font-family'    => esc_attr__( 'Select a font-family', 'distinctpress-pro' ),
				'variant'               => esc_attr__( 'Variant', 'distinctpress-pro' ),
				'subsets'               => esc_attr__( 'Subset', 'distinctpress-pro' ),
				'size'                  => esc_attr__( 'Size', 'distinctpress-pro' ),
				'height'                => esc_attr__( 'Height', 'distinctpress-pro' ),
				'spacing'               => esc_attr__( 'Spacing', 'distinctpress-pro' ),
				'ultra-light'           => esc_attr__( 'Ultra-Light 100', 'distinctpress-pro' ),
				'ultra-light-italic'    => esc_attr__( 'Ultra-Light 100 Italic', 'distinctpress-pro' ),
				'light'                 => esc_attr__( 'Light 200', 'distinctpress-pro' ),
				'light-italic'          => esc_attr__( 'Light 200 Italic', 'distinctpress-pro' ),
				'book'                  => esc_attr__( 'Book 300', 'distinctpress-pro' ),
				'book-italic'           => esc_attr__( 'Book 300 Italic', 'distinctpress-pro' ),
				'regular'               => esc_attr__( 'Normal 400', 'distinctpress-pro' ),
				'italic'                => esc_attr__( 'Normal 400 Italic', 'distinctpress-pro' ),
				'medium'                => esc_attr__( 'Medium 500', 'distinctpress-pro' ),
				'medium-italic'         => esc_attr__( 'Medium 500 Italic', 'distinctpress-pro' ),
				'semi-bold'             => esc_attr__( 'Semi-Bold 600', 'distinctpress-pro' ),
				'semi-bold-italic'      => esc_attr__( 'Semi-Bold 600 Italic', 'distinctpress-pro' ),
				'bold'                  => esc_attr__( 'Bold 700', 'distinctpress-pro' ),
				'bold-italic'           => esc_attr__( 'Bold 700 Italic', 'distinctpress-pro' ),
				'extra-bold'            => esc_attr__( 'Extra-Bold 800', 'distinctpress-pro' ),
				'extra-bold-italic'     => esc_attr__( 'Extra-Bold 800 Italic', 'distinctpress-pro' ),
				'ultra-bold'            => esc_attr__( 'Ultra-Bold 900', 'distinctpress-pro' ),
				'ultra-bold-italic'     => esc_attr__( 'Ultra-Bold 900 Italic', 'distinctpress-pro' ),
				'invalid-value'         => esc_attr__( 'Invalid Value', 'distinctpress-pro' ),
				'add-new'           	=> esc_attr__( 'Add new', 'distinctpress-pro' ),
				'row'           		=> esc_attr__( 'row', 'distinctpress-pro' ),
				'limit-rows'            => esc_attr__( 'Limit: %s rows', 'distinctpress-pro' ),
				'open-section'          => esc_attr__( 'Press return or enter to open this section', 'distinctpress-pro' ),
				'back'                  => esc_attr__( 'Back', 'distinctpress-pro' ),
				'reset-with-icon'       => sprintf( esc_attr__( '%s Reset', 'distinctpress-pro' ), '<span class="dashicons dashicons-image-rotate"></span>' ),
				'text-align'            => esc_attr__( 'Text Align', 'distinctpress-pro' ),
				'text-transform'        => esc_attr__( 'Text Transform', 'distinctpress-pro' ),
				'none'                  => esc_attr__( 'None', 'distinctpress-pro' ),
				'capitalize'            => esc_attr__( 'Capitalize', 'distinctpress-pro' ),
				'uppercase'             => esc_attr__( 'Uppercase', 'distinctpress-pro' ),
				'lowercase'             => esc_attr__( 'Lowercase', 'distinctpress-pro' ),
				'initial'               => esc_attr__( 'Initial', 'distinctpress-pro' ),
				'select-page'           => esc_attr__( 'Select a Page', 'distinctpress-pro' ),
				'open-editor'           => esc_attr__( 'Open Editor', 'distinctpress-pro' ),
				'close-editor'          => esc_attr__( 'Close Editor', 'distinctpress-pro' ),
				'switch-editor'         => esc_attr__( 'Switch Editor', 'distinctpress-pro' ),
				'hex-value'             => esc_attr__( 'Hex Value', 'distinctpress-pro' ),
			);

			// Apply global changes from the kirki/config filter.
			// This is generally to be avoided.
			// It is ONLY provided here for backwards-compatibility reasons.
			// Please use the kirki/{$config_id}/l10n filter instead.
			$config = apply_filters( 'kirki/config', array() );
			if ( isset( $config['i18n'] ) ) {
				$translation_strings = wp_parse_args( $config['i18n'], $translation_strings );
			}

			// Apply l10n changes using the kirki/{$config_id}/l10n filter.
			return apply_filters( 'kirki/' . $config_id . '/l10n', $translation_strings );

		}
	}
}
