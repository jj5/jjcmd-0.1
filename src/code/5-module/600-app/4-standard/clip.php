<?php

class jj_clip extends AppStandard {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Info;

  }

  protected function define_description() : string {

    return "Copies ARGS to clipboard.";

  }

  protected function define_parameters() {

    $this->add_sequential_parameter( 'TEXT' );

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

  public function process() {

    $this->capture();

  }

  public function run() {

    $text = implode( ' ', $this->get_arg( 'TEXT' ) );

    mud_stdout( "$text\n" );

  }
}
