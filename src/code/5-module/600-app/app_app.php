<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - include dependencies...
//

require_once __DIR__ . '/../../1-bootstrap/5-module.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - include components...
//

require_once __DIR__ . '/1-class/1-AppTask.php';
require_once __DIR__ . '/1-class/2-AppShell.php';
require_once __DIR__ . '/1-class/3-AppQuery.php';
require_once __DIR__ . '/1-class/4-AppCommand.php';
require_once __DIR__ . '/1-class/9-AppModule.php';

mud_load_deep_breadth_first( __DIR__ . '/2-shell' );
mud_load_deep_breadth_first( __DIR__ . '/3-query' );
mud_load_deep_breadth_first( __DIR__ . '/4-command' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-10 jj5 - functional interface...
//

function app_get_task( array $args ) {

  return app()->get_task( $args );

}

function app_get_class_name( array $args ) : string{

  return app()->get_class_name( $args );

}
