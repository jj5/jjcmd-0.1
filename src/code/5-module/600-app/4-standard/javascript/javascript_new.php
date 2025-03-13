<?php

class jj_javascript_new extends AppLanguage {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_description() : string {

    return "Create a new Javascript file.";

  }

  protected function define_parameters() {

    $this->add_named_parameter( '--title', $is_optional = false );

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function run() {

    $this->print();

  }

  public function print() {
?>
"use strict";
<?php
  }
}
