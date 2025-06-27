<?php

class jj_version extends AppStandard {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-06-27 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Help;

  }

  protected function define_description() : string {

    return "Print version info.";

  }

  protected function define_parameters() {

    // 2025-06-27 jj5 - there are no parameters for this task.

  }

  protected function define_options() {

    // 2025-06-27 jj5 - there are no options for this task.

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-06-27 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-06-27 jj5 - public functions...
  //

  public function run() {

    $args = $this->get_args();

    $this->print_version();

  }
}
