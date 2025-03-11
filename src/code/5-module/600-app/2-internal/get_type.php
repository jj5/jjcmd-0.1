<?php

class jj_get_type extends AppInternal {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Internal;

  }

  protected function define_description() : string {

    return "This is an internal task to facilitate shell integration. Tasks of type 'shell' are able to manipulate " .
      "the shell environment in some way, such as by changing the current working directory or opening an editor.";

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

    $this->add_sequential_parameter(
      'TASK',
      'The task to query.',
      AppParameterType::String,
      $is_optional = false,
      $is_list = true,
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function run() {

    $task = app_find_task( $this->args );

    echo $task->get_type()->value . "\n";

  }
}
