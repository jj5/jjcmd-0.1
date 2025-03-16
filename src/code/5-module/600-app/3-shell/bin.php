<?php

class jj_bin extends AppShell {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-17 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Shell;

  }

  protected function define_description() : string {

    return 'pushd to /home/jj5/bin.';

  }

  protected function define_parameters() {

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-17 jj5 - public functions...
  //

  public function run() {

    echo "/home/jj5/bin\n";

  }
}
