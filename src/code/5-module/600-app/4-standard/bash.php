<?php

class jj_bash extends AppTaskGroup {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-17 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Languages;

  }

  protected function define_description() : string {

    return "Generates BASH code.";

  }

  protected function define_options() {

    $this->add_subtask( jj_bash_new::class );
    $this->add_subtask( jj_bash_safety::class );
    $this->add_subtask( jj_bash_dotglob::class );
    $this->add_subtask( jj_bash_nullglob::class );
    $this->add_subtask( jj_bash_args::class );
    $this->add_subtask( jj_bash_increment::class );
    $this->add_subtask( jj_bash_case::class );
    $this->add_subtask( jj_bash_array::class );
    $this->add_subtask( jj_bash_for::class );
    $this->add_subtask( jj_bash_date::class );

  }
}
