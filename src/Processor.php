<?php

namespace Chrysalis\T3;

defined( 'ABSPATH' ) || exit;

/**
 * Undocumented class
 */
class Processor extends \WP_HTML_Tag_Processor {
	/**
	 * Undocumented function
	 *
	 * @param string $name The name of the bookmark.
	 *
	 * @return WP_HTML_Span|null The bookmark or null if it doesn't exist.
	 */
	public function get_bookmark( $name ) {
		if ( ! array_key_exists( $name, $this->bookmarks ) ) {
			return null;
		}

		return $this->bookmarks[ $name ];
	}
}
