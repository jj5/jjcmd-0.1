<?php

class jj_help extends AppQuery {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Help;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function run() {

    $category_to_task_list = app()->get_category_to_task_list();

    foreach ( $category_to_task_list as $category => $task_list ) {

      echo "$category:\n";

      foreach ( $task_list as $task ) {

        echo "* jj " . $task->get_name() . "\n";

      }

      echo "\n";

    }
  }
}
