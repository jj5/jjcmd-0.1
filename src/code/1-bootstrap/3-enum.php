<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - load dependencies...
//

require_once __DIR__ . '/3-flags.php';
require_once __DIR__ . '/2-constant.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - load enumerations...
//

// 2025-03-09 jj5 - e.g.
//require_once __DIR__ . '/../3-lookup/mud_lookup.php';


enum AppTaskType : string {
  case Internal = 'internal';
  case Shell = 'shell';
  case Standard = 'standard';
}

enum AppTaskCategory : string {
  case Internal = 'Internal';
  case Shell = 'Shell';
  case Search = 'Search';
  case Web = 'Web';
  case Info = 'Info';
  case Tools = 'Tools';
  case Languages = 'Languages';
  case Help = 'Help';
}

enum AppParameterType : string {
  case String = 'string';
  case Integer = 'integer';
  case Float = 'float';
  case Boolean = 'boolean';
}
