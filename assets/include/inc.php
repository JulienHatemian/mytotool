<?php
    session_start();

    define( "URL", "/mytotool/" );
    
    spl_autoload_register( function( $cls ){
        //TODO AUTOLOAD MYTOTOOL
        $file_name = dirname( __DIR__, 2 ) . DIRECTORY_SEPARATOR . "class" . DIRECTORY_SEPARATOR . $cls . '.php';

        if( file_exists( $file_name ) )
        {
            require $file_name;
        }

    });


    function alert()
    {
		if( isset( $_SESSION[ 'alert' ] ) )
        {
            foreach( $_SESSION[ 'alert' ] as $type => $message )
            {
                echo '<div class="alert alert-' . $type . '">';
                echo $message;
                echo '</div>';
            }

            unset( $_SESSION[ 'alert' ] );
        }
	}