<?php

class jj_bash extends AppTaskGroup {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Languages;

  }

  protected function define_description() : string {

    return "Generates BASH code.";

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

    $this->add_subtask( jj_bash_new::class );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function run() {

    $spec = $this->get_arg( 'SPEC' );

    $class = get_called_class() . '_' . $spec;

    if ( class_exists( $class ) ) {

      $subtask = new $class();

      $subtask->run();

    }
    else {

      $this->print_help();

    }
  }

  public function print_help() {

    $subtask_list = $this->get_subtask_list();

    if ( $subtask_list ) {

      foreach ( $subtask_list as $subtask ) {

        echo '* jj bash ' . $subtask->get_name() . "\n";

      }
    }
    else {

      parent::print_help();

    }
  }
}
