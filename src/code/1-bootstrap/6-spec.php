<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - load dependencies...
//

require_once __DIR__ . '/5-module.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-13 jj5 - this is where we define most of the application...
//

(function() {

  // 2025-03-14 jj5 - here we define all the parameters that can be used in the application...

  // 2025-03-14 jj5 - these are the auto-complete args BASH will pass to us...

  app()->add_sequential_parameter(
    'ARG1',
    'The 1st argument.',
    AppParameterType::String,
    $is_optional = false,
    $is_list = false,
  );

  app()->add_sequential_parameter(
    'ARG2',
    'The 2nd argument.',
    AppParameterType::String,
    $is_optional = false,
    $is_list = false,
  );

  app()->add_sequential_parameter(
    'ARG3',
    'The 3rd argument.',
    AppParameterType::String,
    $is_optional = false,
    $is_list = false,
  );

  app()->add_sequential_parameter(
    'ARG4',
    'The 4th argument.',
    AppParameterType::String,
    $is_optional = true,
    $is_list = false,
  );

  // 2025-03-14 jj5 - these are other parameters that can be used in the application...

  app()->add_sequential_parameter(
    'TASK',
    'The task to process. Can be a simple task or a task and subtask.',
    AppParameterType::String,
    $is_optional = false,
    $is_list = true,
  );

  app()->add_sequential_parameter(
    'SUBTASK',
    'The subtask to process.',
    AppParameterType::String,
    $is_optional = false,
    $is_list = false,
  );

  app()->add_sequential_parameter(
    'ALIAS',
    'The ALIAS to process.',
    AppParameterType::String,
    $is_optional = false,
    $is_list = false,
  );

  app()->add_sequential_parameter(
    'SEARCH',
    'The search specification.',
    AppParameterType::String,
    $is_optional = null,
    $is_list = false,
  );

  app()->add_sequential_parameter(
    'SPEC',
    'The spec for the task.',
    AppParameterType::String,
    $is_optional = null,
    $is_list = false,
  );

  app()->add_sequential_parameter(
    'FILE',
    'The FILE(s) to process.',
    AppParameterType::String,
    $is_optional = false,
    $is_list = true,
  );

  app()->add_sequential_parameter(
    'TEXT',
    'The text to process.',
    AppParameterType::String,
    $is_optional = false,
    $is_list = true,
  );

  app()->add_sequential_parameter(
    'INFO',
    'The name(s) of the info you want.',
    AppParameterType::String,
    $is_optional = false,
    $is_list = true,
  );

  app()->add_sequential_parameter(
    'LANGUAGE',
    'The LANGUAGE of the new file.',
    AppParameterType::String,
    $is_optional = false,
    $is_list = false,
  );

  // 2025-03-14 jj5 - these are named parameters that are available to any task in the application...

  app()->add_named_parameter(
    '--title',
    'The document TITLE.',
    AppParameterType::String,
    $is_optional = false,
    $is_list = false,
  );

  // 2025-03-14 jj5 - these are the flags that can be used by any task in the application...

  app()->add_flag_parameter(
    '--clip',
    'Copy the output to the clipboard.',
  );

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
  app()->add_task( jj_smtp::class );
  app()->add_task( jj_clip::class );
  app()->add_task( jj_clip_file::class );
  app()->add_task( jj_host::class );

  app()->add_task( jj_clear::class );

  app()->add_task( jj_bash::class );
  app()->add_task( jj_html::class );
  app()->add_task( jj_javascript::class );
  app()->add_task( jj_php::class );
  app()->add_task( jj_new::class );

  app()->add_task( jj_help::class );

})();
