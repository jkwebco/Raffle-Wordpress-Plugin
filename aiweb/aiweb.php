<?php # -*- coding: utf-8 -*-
/* Plugin Name: Aiweb Python embedded */

/**
 * Plugin Name: AIWEB's python thing.
 * Plugin URI: http://aiweb.biz
 * Description: Run python code by a shortcode.
 * Version: The Plugin's Version Number, e.g.: 1.0
 * Author: Aiweb
 * Author URI: http://aiweb.biz
 * License: A "Slug" license name e.g. GPL2
 */
/*from http://wordpress.stackexchange.com/questions/120259/running-a-python-scri
pt-within-wordpress/120261?noredirect=1#120261  */

add_shortcode( 'python', 'embed_python' );

function embed_python( $attributes )
{
    $data = shortcode_atts(
        [
            'file' => 'hello.py'
        ],
        $attributes
    );

   $handle = popen( __DIR__ . '/' . $data['file'] . ' 2>&1', 'r' );
    $read = '';

    while ( ! feof( $handle ) )
    {
        $read .= fread( $handle, 2096 );
    }

    pclose( $handle );

    return $read;
}

#chmod 777 hello.py for file 

#$pyScript = "/path/to/app.py";

#exec("/usr/bin/python $pyScript", $output);
#var_dump($output);