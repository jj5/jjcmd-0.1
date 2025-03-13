<?php

class jj_bash_date extends AppLanguage {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_description() : string {

    return "How to format dates in BASH.";

  }

  protected function define_parameters() {

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function print() {
?>
date +%Y-%m-%d-%H%M%S
<?php
  }
}
