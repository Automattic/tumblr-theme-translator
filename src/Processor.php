<?php

namespace Chrysalis\T3;

defined( 'ABSPATH' ) || exit;

class Processor extends \WP_HTML_Tag_Processor {
	public function get_bookmark( $name ) {
		if ( ! array_key_exists( $name, $this->bookmarks ) ) {
			return null;
		}

		return $this->bookmarks[ $name ];
	}
}
