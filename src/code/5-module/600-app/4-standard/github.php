<?php

class jj_github extends AppTaskGroup {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-06-27 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Tools;

  }

  protected function define_description() : string {

    return "Operates on github.";

  }

  protected function define_options() {

    $this->add_subtask( jj_github_create::class );

  }
}
