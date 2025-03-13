<?php

abstract class AppStandard extends AppTask {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

    $this->add_flag_parameter( '--clip' );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function process() {

    $clip = $this->get_arg( '--clip' );

    if ( $clip ) {

      $this->capture();

    }
    else {

      $this->run();

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-13 jj5 - protected functions...
  //

  protected function define_type() : AppTaskType { return AppTaskType::Standard; }

  protected function capture( $trim = true ) {

    $xclip = trim( `command -v xclip` );

    if ( ! is_executable( $xclip ) ) {

      mud_fail( "xclip is not installed.", [ 'class' => get_called_class() ] );

    }

    ob_start();

    $this->run();

    $result = ob_get_contents();

    ob_end_clean();

    if ( $trim ) {

      $result = trim( $result );

      echo "$result\n";

    }
    else {

      echo $result;

    }

    mud_stderr( "Output copied to clipboard.\n" );

    $arg = escapeshellarg( $result );

    if ( $trim ) {

      `echo -n $arg | $xclip -selection clipboard -loops 2`;

    }
    else {

      `echo $arg | $xclip -selection clipboard -loops 2`;

    }
  }
}
