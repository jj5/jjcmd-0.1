<?php

class jj_mudball_add_ext extends AppSubtask {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-25 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return $this->get_parent_task()->get_category();

  }

  protected function define_description() : string {

    return "Adds a 'mudball' submodule to an existing git repo.";

  }

  protected function define_parameters() {

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-25 jj5 - public functions...
  //

  public function run() {

    $spec = 'mudball';

    $url = APP_GIT_SUBMODULE_MAP[ $spec ] ?? null;
    $path = "ext/$spec";

    if ( ! $url ) {

      mud_fail( "unknown submodule spec.", [ 'spec' => $spec ] );

    }

    jj_git::add_submodule( $url, $path );

  }
}
