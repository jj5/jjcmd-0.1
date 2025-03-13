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

    $this->add_sequential_parameter(
      'ARG1',
      'The 1st argument.',
    );

    $this->add_sequential_parameter(
      'ARG2',
      'The 2nd argument.',
    );

    $this->add_sequential_parameter(
      'ARG3',
      'The 3rd argument.',
    );

    $this->add_sequential_parameter(
      'ARG4',
      'The 4th argument.',
    );

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

    echo "option-1\noption-2\n";

  }
}
