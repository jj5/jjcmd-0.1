<?php

class jj_clip_file extends AppStandard {


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

    $this->add_sequential_parameter( 'FILE' );

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

  public function complete( $arg1, $arg2, $arg3, $arg4 ) {

    return $this->complete_file( $arg2 );

  }

  public function process() {

    $this->capture( $trim = false );

  }

  public function run() {

    foreach ( $this->get_arg( 'FILE' ) as $file ) {

      readfile( $file );

      echo "\n";

    }
  }
}
