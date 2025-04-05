<?php

abstract class AppTaskGroup extends AppTask {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-17 jj5 - definitions...
  //

  protected function define_parameters() {

    $this->add_sequential_parameter( 'SUBTASK' );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-13 jj5 - fields...
  //

  protected array $subtask_list = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-13 jj5 - public functions...
  //

  public function complete( $arg1, $arg2, $arg3, $arg4 ) {

    mud_log_trace( __FUNCTION__, [ $arg1, $arg2, $arg3, $arg4 ] );

    $subtask_list = $this->get_subtask_list();

    if ( $subtask_list ) {

      foreach ( $subtask_list as $subtask ) {

        $name = $subtask->get_name();

        if ( strpos( $name, $arg2 ) === 0 ) {

          echo $name . "\n";

        }
      }
    }
  }

  public function get_subtask_list() : array {

    return $this->subtask_list;

  }

  public function run() {

    $spec = $this->get_arg( 'SUBTASK' );

    $class = get_called_class() . '_' . $spec;

    if ( class_exists( $class ) ) {

      $subtask = app()->get_task( $class );

      $subtask->set_args( $this->args );

      $subtask->run();

    }
    else {

      $this->print_help( [] );

    }
  }

  public function print_help( array $args ) {

    $subtask_list = $this->get_subtask_list();

    if ( $subtask_list ) {

      foreach ( $subtask_list as $subtask ) {

        echo '* jj ' . $this->get_name() . ' ' . $subtask->get_name() . "\n";

      }
    }
    else {

      parent::print_help( $args );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - protected functions...
  //

  protected function define_type() : AppTaskType { return AppTaskType::Standard; }

  protected function add_subtask( string $class ) {

    $subtask = app()->get_task( $class );

    if ( ! $subtask ) {

      $subtask = app()->new_task( $class, $this );

    }

    $this->subtask_list[] = $subtask;

  }
}
