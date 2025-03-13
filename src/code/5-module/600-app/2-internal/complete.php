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

        $list = [];

        foreach ( $task_list as $task ) {

          $list[] = $task->get_name();

        }

        return $this->report_complete( $list, $arg2 );

      case '--file' :

        return $this->complete_file( $arg2 );

    }

    $class = app()->get_class_name( [ $arg3 ] );

    if ( class_exists( $class ) ) {

      $task = app()->get_task( $class );

      return $task->complete( $arg1, $arg2, $arg3, $arg4 );

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

      if ( count( $subtask_list ) === 1 ) {

        return $subtask_list[ 0 ]->complete( $arg1, $arg2, $arg3, $arg4 );

      }

      // 2025-03-14 jj5 - TODO...

    }
  }
}
