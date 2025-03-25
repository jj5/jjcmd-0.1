<?php

class jj_mudball_add_inc extends AppSubtask {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-25 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return $this->get_parent_task()->get_category();

  }

  protected function define_description() : string {

    return "Adds standard mudball include files into current directory.";

  }

  protected function define_parameters() {

    $this->add_named_parameter( '--code', $is_optional = false );
    $this->add_named_parameter( '--name', $is_optional = true );

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-25 jj5 - public functions...
  //

  public function run() {

    $code = $this->get_arg( '--code' );
    $name = $this->get_arg( '--name', $code );

    mud_log_trace( "code", $code );
    mud_log_trace( "name", $name );

    if ( ! is_dir( 'inc' ) ) {

      mud_mkdir( 'inc', fileperms( '.' ) );

    }

    if ( ! file_exists( 'inc/version.php' ) ) {

      file_put_contents( 'inc/version.php', $this->get_version_php( $code, $name ) );

    }

    if ( ! file_exists( 'inc/version.sh' ) ) {

      file_put_contents( 'inc/version.sh', $this->get_version_sh( $code, $name ) );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-25 jj5 - protected functions...
  //

  protected function get_version_php( $code, $name ) {

    $const = strtoupper( $code );

    $name_json = json_encode( $name );
    $code_json = json_encode( $code );

    $version_php = <<<CODE
<?php

// you can change the name but not the code...
define( '{$const}_NAME', $name_json );
define( '{$const}_CODE', $code_json );

//define( '{$const}_VERSION', '0.1.1' );
define( '{$const}_VERSION_MAJOR', 0 );
define( '{$const}_VERSION_MINOR', 1 );
define( '{$const}_VERSION_PATCH', 1 );

CODE;

    return $version_php;

  }

  protected function get_version_sh( $code, $name ) {

    $const = strtoupper( $code );

    $name_json = json_encode( $name );
    $code_json = json_encode( $code );

    $version_php = <<<CODE
#!/bin/bash

export {$const}_NAME=$name_json;
export {$const}_CODE=$code_json;

export {$const}_VERSION='0.1.1';
export {$const}_VERSION_MAJOR='0';
export {$const}_VERSION_MINOR='1';
export {$const}_VERSION_PATCH='1';

CODE;

    return $version_php;

  }
}
