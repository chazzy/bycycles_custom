<?php

class Bycycle_Activator {

	public static function activate() {
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
        flush_rewrite_rules();
	}

}
