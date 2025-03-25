<?php

class jj_mudball extends AppTaskGroup {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-17 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Tools;

  }

  protected function define_description() : string {

    return "Operates on mudball projects.";

  }

  protected function define_options() {

    $this->add_subtask( jj_mudball_add_ext::class );
    $this->add_subtask( jj_mudball_add_inc::class );

  }
}
