<?php

class jj_bash_new extends AppLanguage {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_description() : string {

    return "Create a new BASH script.";

  }

  protected function define_parameters() {

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
#!/bin/bash

main() {

  set -euo pipefail;
  #shopt -s dotglob;
  #shopt -s nullglob;

  pushd "$( dirname "$0" )" >/dev/null;

}

main "$@";
<?php
  }
}
