<?php

abstract class AppTaskGroup extends AppTask {


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

    //mud_log_trace( "complete", [ $arg1, $arg2, $arg3, $arg4 ] );

    $subtask_list = $this->get_subtask_list();

    foreach ( $subtask_list as $subtask ) {

      echo $subtask->get_name() . "\n";

    }
  }

  public function get_subtask_list() : array {

    return $this->subtask_list;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - protected functions...
  //

  protected function define_type() : AppTaskType { return AppTaskType::Standard; }

  protected function add_subtask( string $class ) {

    $subtask = app()->new_task( $class, $this );

    $this->subtask_list[] = $subtask;

  }
}
