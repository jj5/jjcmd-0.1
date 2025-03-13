<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - load dependencies...
//

require_once __DIR__ . '/5-module.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-13 jj5 - this is where we define most of the application...
//

(function() {

  // 2025-03-13 jj5 - here we define the main tasks...

  app()->add_task( jj_complete::class );
  app()->add_task( jj_get_type::class );

  app()->add_task( jj_edit::class );
  app()->add_task( jj_go::class );

  app()->add_task( jj_find::class );
  app()->add_task( jj_name::class );
  app()->add_task( jj_path::class );

  app()->add_task( jj_chatgpt::class );
  app()->add_task( jj_cheat::class );
  app()->add_task( jj_define::class );
  app()->add_task( jj_search::class );

  app()->add_task( jj_bkts::class );
  app()->add_task( jj_clip::class );
  app()->add_task( jj_clip_file::class );
  app()->add_task( jj_host::class );

  app()->add_task( jj_bash::class );

  app()->add_task( jj_help::class );

})();
