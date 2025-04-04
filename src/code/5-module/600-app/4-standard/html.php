<?php

class jj_html extends AppTaskGroup {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Languages;

  }

  protected function define_description() : string {

    return "Generates HTML code.";

  }

  protected function define_options() {

    $this->add_subtask( jj_html_new::class );

  }
}
