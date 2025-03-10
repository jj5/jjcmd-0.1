<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - class definition...
//

class AppModule extends MudModuleApp {

  public function run( $argv ) {

    $args = $argv;

    $script = array_shift( $args );

    error_log( "script: $script" );

    $task = $this->get_task( $args );

    if ( $task ) {

      error_log( "running task: " . get_class( $task ) );

      return $task->run();

    }

    error_log( "could not find task: " . implode( ' ', $args ) );

  }

  public function get_task( array $args ) {

    $task_args = [];

    while ( $args ) {

      $class_name = self::get_class_name( $args );

      error_log( "checking class: $class_name" );

      if ( class_exists( $class_name ) ) {

        return new $class_name( $task_args );

      }

      $arg = array_pop( $args );

      array_unshift( $task_args, $arg );

    }

    error_log( "command not found: " . implode( ' ', $args ) );

    return null;

  }

  public function get_class_name( array $args ) : string{

    return 'jj_' . str_replace( '-', '_', implode( '_', $args ) );

  }

  private function run_cmd( string $class_name, array $args ) {

    error_log( "running command: $class_name: " . implode( ' ', $args ) );

  }
}
