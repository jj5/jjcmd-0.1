<?php

class jj_edit extends AppShell {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  public function define_category() : AppTaskCategory {

    return AppTaskCategory::Shell;

  }

  protected function define_description() : string {

    return "Opens the ALIAS file in Vim.";

  }

  protected function define_parameters() {

    $this->add_sequential_parameter(
      'ALIAS',
      'The file to open.',
      AppParameterType::String,
      $is_optional = false,
      $is_list = false,
    );

  }

  protected function define_options() {

    $this->add_option( 'food', '/home/jj5/repo/svn/jprepo/plog-0.1', 'src/code/food.php' );

  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - fields...
  //

  protected $spec = [];


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

    $name = $this->get_arg( 'ALIAS' );

    $spec = $this->spec[ $name ];

    $dir = $spec[ 'dir' ];
    $file = $spec[ 'file' ];

    if ( ! is_dir( $dir ) ) {

      mud_fail( 'invalid directory.', [ 'dir' => $dir ] );

    }

    if ( ! is_file( "$dir/$file" ) ) {

      mud_fail( 'invalid file.', [ 'dir' => $dir, 'file' => $file ] );

    }

    echo  "$dir\n" .
          "$file\n";

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - protected functions...
  //

  protected function add_option( string $name, string $dir, string $file ) {

    $this->spec[ $name ] = [ 'name' => $name, 'dir' => $dir, 'file' => $file ];

  }
}
