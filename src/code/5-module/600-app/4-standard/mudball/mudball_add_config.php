<?php

class jj_mudball_add_config extends AppSubtask {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-25 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return $this->get_parent_task()->get_category();

  }

  protected function define_description() : string {

    return "Adds standard mudball config files into current directory.";

  }

  protected function define_parameters() {

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-25 jj5 - public functions...
  //

  public function run() {

    if ( ! file_exists( '.gitignore' ) ) {

      file_put_contents( '.gitignore', "vendor\n" );

    }

    $this->git_ignore( 'config.php' );
    $this->git_ignore( 'debug.php' );

    if ( ! file_exists( 'config.php' ) ) {

      file_put_contents( 'config.php', $this->get_config_php() );

    }

    if ( ! file_exists( 'debug.php' ) ) {

      file_put_contents( 'debug.php', $this->get_debug_php() );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-25 jj5 - protected functions...
  //

  protected function remove_blank_lines( $string ) {

    return preg_replace( '/^\s*[\r\n]+/m', '', $string );

  }

  protected function git_ignore( $filename ) {

    if ( ! file_exists( '.gitignore' ) ) { return; }

    $gitignore = file_get_contents( '.gitignore' );

    if ( strpos( $gitignore, $filename ) === false ) {

      file_put_contents( '.gitignore', $this->remove_blank_lines( $gitignore . "\n$filename\n" ) );

    }
  }

  protected function get_config_php() {

    $result = <<<CODE
<?php

CODE;

    return $result;

  }

  protected function get_debug_php() {

    $result = <<<CODE
<?php

CODE;

    return $result;

  }
}
