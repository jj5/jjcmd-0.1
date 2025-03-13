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

    $this->add_sequential_parameter(
      'SPEC',
      'The name of the item you want.',
      AppParameterType::String,
      $is_optional = true,
      $is_list = false,
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-13 jj5 - public functions...
  //

  public function get_subtask_list() : array {

    return $this->subtask_list;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - protected functions...
  //

  protected function define_type() : AppTaskType { return AppTaskType::Standard; }

  protected function add_subtask( string $class ) {

    $subtask = app()->get_task( $class, $this );

    $this->subtask_list[] = $subtask;

  }
}
