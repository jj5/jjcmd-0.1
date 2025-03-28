<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - include dependencies...
//

require_once __DIR__ . '/../../1-bootstrap/5-module.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - include components...
//

require_once __DIR__ . '/1-definition/11-AppParameter.php';
require_once __DIR__ . '/1-definition/12-AppSequentialParameter.php';
require_once __DIR__ . '/1-definition/13-AppNamedParameter.php';
require_once __DIR__ . '/1-definition/14-AppFlagParameter.php';
require_once __DIR__ . '/1-definition/18-AppFile.php';
require_once __DIR__ . '/1-definition/19-AppSpec.php';

require_once __DIR__ . '/1-definition/21-AppTask.php';
require_once __DIR__ . '/1-definition/22-AppInternal.php';
require_once __DIR__ . '/1-definition/23-AppShell.php';
require_once __DIR__ . '/1-definition/24-AppStandard.php';
require_once __DIR__ . '/1-definition/25-AppTaskGroup.php';
require_once __DIR__ . '/1-definition/26-AppSubtask.php';
require_once __DIR__ . '/1-definition/27-AppLanguage.php';

require_once __DIR__ . '/1-definition/31-AppItem.php';

require_once __DIR__ . '/1-definition/99-AppModule.php';

mud_load_deep_breadth_first( __DIR__ . '/2-internal' );
mud_load_deep_breadth_first( __DIR__ . '/3-shell' );
mud_load_deep_breadth_first( __DIR__ . '/4-standard' );
mud_load_deep_breadth_first( __DIR__ . '/5-meta' );


/////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-10 jj5 - functional interface...
//

function app_find_task( array $args ) {

  return app()->find_task( $args );

}

function app_get_class_name( array $args ) : string{

  return app()->get_class_name( $args );

}
