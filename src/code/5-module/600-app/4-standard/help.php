<?php

class jj_help extends AppStandard {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Help;

  }

  protected function define_description() : string {

    return "Print help for tasks. Call without task name to print global help.";

  }

  protected function define_parameters() {

    $this->add_sequential_parameter( 'TASK', $is_optional = true );

  }

  protected function define_options() {

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

    $args = $this->get_args();

    if ( count( $args ) > 0 ) {

      $this->print_help_for_task( $args );

    } else {

      $this->print_help_global();

    }
  }

  public function print_help_global() {

    $category_to_task_list = app()->get_category_to_task_list();

    foreach ( $category_to_task_list as $category => $task_list ) {

      echo "$category:\n";

      foreach ( $task_list as $task ) {

        echo "* jj " . $task->get_name() . "\n";

      }

      echo "\n";

    }
  }

  public function print_help_for_task( array $args ) {

    $task = app_find_task( $args );

    $task->print_help();

  }
}
