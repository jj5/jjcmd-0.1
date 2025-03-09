<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - include dependencies...
//

require_once __DIR__ . '/../../1-bootstrap/5-module.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - include components...
//

require_once __DIR__ . '/class/1-AppTask.php';
require_once __DIR__ . '/class/2-AppShell.php';
require_once __DIR__ . '/class/3-AppQuery.php';
require_once __DIR__ . '/class/4-AppCommand.php';
require_once __DIR__ . '/class/9-AppModule.php';

mud_load_deep_breadth_first( __DIR__ . '/2-shell' );
