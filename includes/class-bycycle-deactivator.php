<?php

class Bycycle_Deactivator {
	public static function deactivate($config) {
        unregister_post_type( $config['plugin_name'] );
        flush_rewrite_rules();
	}
}
