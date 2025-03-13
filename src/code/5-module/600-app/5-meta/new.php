<?php

class jj_new extends AppTaskGroup {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Languages;

  }

  protected function define_description() : string {

    return "Creates new files.";

  }

  protected function define_parameters() {

    $this->add_sequential_parameter( 'LANGUAGE' );

  }

  protected function define_options() {

    $this->add_subtask( jj_bash_new::class );

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

  public function complete( $arg1, $arg2, $arg3, $arg4 ) {

    $subtask_list = $this->get_subtask_list();

    foreach ( $subtask_list as $subtask ) {

      $lang = $subtask->get_parent_task()->get_name();

      if ( strpos( $lang, $arg2 ) === 0 ) {

        echo $lang . "\n";

      }
    }
  }

  public function run() {

    $lang = $this->get_arg( 'LANGUAGE' );

    $class = 'jj_' . $lang . '_new';

    if ( class_exists( $class ) ) {

      $subtask = app()->get_task( $class );

      $subtask->run();

    }
    else {

      $this->print_help( [] );

    }
  }

  public function print_help( array $args ) {

    $subtask_list = $this->get_subtask_list();

    if ( $subtask_list ) {

      foreach ( $subtask_list as $subtask ) {

        echo '* jj new ' . $subtask->get_parent_task()->get_name() . "\n";

      }
    }
    else {

      parent::print_help( $args );

    }
  }
}
