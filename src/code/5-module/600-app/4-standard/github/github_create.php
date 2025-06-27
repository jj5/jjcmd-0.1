<?php

class jj_github_create extends AppSubtask {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-06-27 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return $this->get_parent_task()->get_category();

  }

  protected function define_description() : string {

    return "Creates a new github repository.";

  }

  protected function define_parameters() {

    $this->add_sequential_parameter( 'NAME', $is_optional = false );

    //$this->add_named_parameter( '--title', $is_optional = false );

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function run() {

    $name = $this->get_arg( 'NAME' );

    echo "$name\n";

    $home_dir = getenv( 'HOME' );

    if ( ! is_dir( $home_dir ) ) {

      mud_fail( "missing home directory: $home_dir", [ 'class' => get_called_class() ] );

    }

    $github_dir = "$home_dir/github";

    if ( ! is_dir( $github_dir ) ) {

      mud_fail( "missing github directory: $github_dir", [ 'class' => get_called_class() ] );

    }

    $working_copy = "$home_dir/github/$name";

    if ( file_exists( $working_copy ) ) {

      echo "repository already exists: $working_copy\n";

      exit( 1 );

    }

    $token = escapeshellarg( CFG_GITHUB_PAT );

    shell_exec( "echo $token | gh auth login --with-token" );

    echo shell_exec('gh auth status');

    $config_dir = "$home_dir/.config";

    if ( ! is_dir( $config_dir ) ) {

      mud_fail( "missing config directory: $config_dir", [ 'class' => get_called_class() ] );

    }

    $app_config_dir = "$config_dir/jjcmd";

    if ( ! is_dir( $app_config_dir ) ) {

      mud_mkdir( $app_config_dir, 0755 );

    }

    $new_path_file = "$app_config_dir/new-path.txt";

    file_put_contents( $new_path_file, "$working_copy\n" );

    mud_mkdir( $working_copy, 0755 );

    mud_chdir( $working_copy );

    $result = shell_exec( "git init" );

    if ( ! $result ) {

      mud_fail( "failed to init repository: $working_copy", [ 'class' => get_called_class() ] );

    }

    $year =  date( 'Y' );
    $note = "© Copyright $year John Elliot V. All rights reserved.\n";

    file_put_contents( ".gitignore", "vendor\nconfig.php\ndebug.php\n" );
    file_put_contents( "README.md", $note );
    file_put_contents( "LICENSE", $note );

    $result = shell_exec( "git add ." );

    if ( $result ) {

      mud_fail( "failed to add files: $working_copy\n" );

    }

    $result = shell_exec( "git commit -m 'Work, work...'" );

    if ( ! $result ) {


      mud_fail( "failed to commit files: $working_copy", [ 'class' => get_called_class() ] );

    }

    $result = shell_exec( "gh repo create $name --public --source=. --remote=origin --push" );

    if ( ! $result ) {

      mud_fail( "failed to create repository: $name", [ 'class' => get_called_class() ] );

    }

    echo "created repository: $name\n";
    echo "working copy: $working_copy\n";
    echo "to change dir: jj go new\n";

    shell_exec( "gh repo view --web" );

  }
}
