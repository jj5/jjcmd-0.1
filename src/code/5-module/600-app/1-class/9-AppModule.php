<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - class definition...
//

class AppModule extends MudModuleApp {

  public function run( $argv ) {

    $args = $argv;

    $script = array_shift( $args );

    mud_log_trace( "script: $script" );

    $task = $this->get_task( $args );

    if ( $task ) {

      mud_log_trace( "running task: " . get_class( $task ) );

      return $task->run();

    }

    mud_log_trace( "could not find task: " . implode( ' ', $args ) );

  }

  public function get_task( array $args ) {

    $task_args = [];

    while ( $args ) {

      $class_name = self::get_class_name( $args );

      mud_log_trace( "checking class: $class_name" );

      if ( class_exists( $class_name ) ) {

        return new $class_name( $task_args );

      }

      $arg = array_pop( $args );

      array_unshift( $task_args, $arg );

    }

    mud_log_trace( "command not found: " . implode( ' ', $args ) );

    return new jj_help( $task_args );

  }

  public function get_class_name( array $args ) : string {

    return 'jj_' . str_replace( '-', '_', implode( '_', $args ) );

  }
}
