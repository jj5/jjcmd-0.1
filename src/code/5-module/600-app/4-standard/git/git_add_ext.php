<?php

class jj_git_add_ext extends AppSubtask {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-25 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return $this->get_parent_task()->get_category();

  }

  protected function define_description() : string {

    $result = "Adds a submodule to an existing git repo.";

    foreach ( APP_GIT_SUBMODULE_MAP as $spec => $url ) {

      $result .= "\n  - $spec: $url";

    }


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

    $spec = $this->get_arg( 'SPEC' );

    $url = APP_GIT_SUBMODULE_MAP[ $spec ] ?? null;
    $path = "ext/$spec";

    if ( ! $url ) {

      mud_fail( "unknown submodule spec.", [ 'spec' => $spec ] );

    }

    jj_git::add_submodule( $url, $path );

  }
}
