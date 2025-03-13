<?php

class jj_bash_new extends jj_bash {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_description() : string {

    return "Generates BASH script from template.";

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

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
