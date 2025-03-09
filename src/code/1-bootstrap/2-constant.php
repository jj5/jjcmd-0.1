<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - load dependencies...
//

require_once __DIR__ . '/1-library.php';

require_once __DIR__ . '/../../../inc/version.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-18 jj5 - path info...
//

define( 'JJCMD_PATH', realpath( __DIR__ . '/../../../' ) );
define( 'JJCMD_CONFIG_FILE', 'config.php' );
define( 'JJCMD_CONFIG_PATH', JJCMD_PATH . '/' . JJCMD_CONFIG_FILE );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2021-03-18 jj5 - maintainer info...
//

define( 'JJCMD_MAINTAINER_USERNAME',  'jj5'           );
define( 'JJCMD_MAINTAINER_EMAIL',     'jj5@jj5.net'   );
define( 'JJCMD_MAINTAINER_NAME',      'John Elliot V' );
define(
  'JJCMD_MAINTAINER',
  JJCMD_MAINTAINER_NAME . ' <' . JJCMD_MAINTAINER_EMAIL . '>'
);

define(
  'JJCMD_PLEASE_INFORM',
  'please let the maintainer know: ' . JJCMD_MAINTAINER
);


