<?php

class jj_git extends AppTaskGroup {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-17 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Tools;

  }

  protected function define_description() : string {

    return "Operates on git repositories.";

  }

  protected function define_options() {

    $this->add_subtask( jj_git_create::class );
    $this->add_subtask( jj_git_create_bare::class );
    $this->add_subtask( jj_git_add_ext::class );

  }
}
