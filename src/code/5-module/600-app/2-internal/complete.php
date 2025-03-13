<?php

class jj_complete extends AppInternal {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Internal;

  }

  protected function define_description() : string {

    return "This is an internal task for use with BASH completion.";

  }

  protected function define_parameters() {

    $this->add_sequential_parameter( 'ARG1' );
    $this->add_sequential_parameter( 'ARG2' );
    $this->add_sequential_parameter( 'ARG3' );
    $this->add_sequential_parameter( 'ARG4' );

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

    mud_log_trace( "jj_complete", $this->args );

    $arg1 = $this->get_arg( 'ARG1' );
    $arg2 = $this->get_arg( 'ARG2' );
    $arg3 = $this->get_arg( 'ARG3' );
    $arg4 = $this->get_arg( 'ARG4' );

    $task_list = app()->get_task_list();

    switch ( $arg3 ) {

      case 'jj';

        foreach ( $task_list as $task ) {

          echo $task->get_name() . "\n";

        }

        return;

    }

    $class = app()->get_class_name( [ $arg3 ] );

    if ( class_exists( $class ) ) {

      $task = app()->get_task( $class );

      $task->complete( $arg1, $arg2, $arg3, $arg4 );

      return;

    }

    $subtask_list = [];

    foreach ( $task_list as $task ) {

      $class = app()->get_class_name( [ $task->get_name(), $arg3 ] );

      if ( class_exists( $class ) ) {

        $subtask = app()->get_task( $class );

        $subtask_list[] = $subtask;

      }
    }

    if ( $subtask_list ) {

      return;

    }

  }
}
