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

  protected function define_parameters() {

    $this->add_sequential_parameter( 'SUBTASK' );

  }

  protected function define_options() {

    $this->add_subtask( jj_html_new::class );

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

    mud_log_trace( "complete", [ $arg1, $arg2, $arg3, $arg4 ] );

    $task_list = app()->get_task_list();

    $subtask_list = $this->get_subtask_list();

    if ( $subtask_list ) {

      foreach ( $subtask_list as $subtask ) {

        $name = $subtask->get_name();

        if ( strpos( $name, $arg2 ) === 0 ) {

          echo $name . "\n";

        }
      }
    }
  }

  public function run() {

    $spec = $this->get_arg( 'SUBTASK' );

    $class = get_called_class() . '_' . $spec;

    if ( class_exists( $class ) ) {

      $subtask = app()->get_task( $class );

      $subtask->set_args( $this->args );

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

        echo '* jj html ' . $subtask->get_name() . "\n";

      }
    }
    else {

      parent::print_help( $args );

    }
  }
}
