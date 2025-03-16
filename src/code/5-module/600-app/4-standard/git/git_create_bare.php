<?php

class jj_git_create_bare extends AppSubtask {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return $this->get_parent_task()->get_category();

  }

  protected function define_description() : string {

    return "Creates a new bare git repository.";

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


  }
}
