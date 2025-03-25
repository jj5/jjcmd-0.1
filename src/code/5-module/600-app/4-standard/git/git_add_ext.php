<?php

class jj_git_add_ext extends AppSubtask {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-25 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return $this->get_parent_task()->get_category();

  }

  protected function define_description() : string {

    return "Adds a submodule to an existing git repo.";

  }

  protected function define_parameters() {

    $this->add_sequential_parameter( 'SPEC', $is_optional = false );

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-25 jj5 - public functions...
  //

  public function run() {

    static $map = [
      'mudball' => 'git@github.com:jj5/mudball-0.6.git',
    ];

    $spec = $this->get_arg( 'SPEC' );

    $url = $map[ $spec ] ?? null;
    $path = "ext/$spec";
    $commit_message = 'Work, work...';

    if ( ! $url ) {

      mud_fail( "unknown submodule spec.", [ 'spec' => $spec ] );

    }

    if ( ! is_dir( '.git' ) ) {

      mud_fail( "not a git repo.", [ 'cwd' => getcwd() ] );

    }

    if ( is_dir( $path ) ) {

      mud_fail( "submodule already exists.", [ 'path' => $path ] );

    }

    if ( ! is_dir( 'ext' ) ) {

      $perms = fileperms( '.' );

      //$octal_perms = substr( sprintf( '%o', $perms ), -4 );

      mud_mkdir( 'ext', $perms );

    }

    $arg_url = escapeshellarg( $url );
    $arg_path = escapeshellarg( $path );
    $arg_commit_message = escapeshellarg( $commit_message );

    mud_exec( "git submodule add $arg_url $arg_path" );
    mud_exec( "git add .gitmodules $arg_path" );
    mud_exec( "git commit -m $arg_commit_message" );
    mud_exec( "git push" );
    mud_exec( "git submodule update --init --recursive" );

  }
}
