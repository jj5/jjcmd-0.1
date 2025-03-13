<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - class definition...
//

class AppModule extends MudModuleApp {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - fields...
  //

  protected $class_to_task = [];
  protected $category_to_task_list = [];
  protected $task_list = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function run( $argv ) {

    $args = $argv;

    $script = array_shift( $args );

    mud_log_trace( '////////////////////////////////////////////////////////////////////////////////////////////////////' );
    mud_log_trace( 'script..', $script );
    mud_log_trace( 'args....', $args );

    $this->load_tasks();

    $task = $this->find_task( $args );

    if ( $task ) {

      mud_log_trace( "running task: " . get_class( $task ) );

      return $task->process();

    }

    mud_log_trace( "could not find task: " . implode( ' ', $args ) );

  }

  public function find_task( array $args ) {

    $task_args = [];

    while ( $args ) {

      $class_name = self::get_class_name( $args );

      mud_log_trace( "checking class: $class_name" );

      if ( class_exists( $class_name ) ) {

        $task = new $class_name();

        $task->set_args( $task_args );

        return $task;

      }

      $arg = array_pop( $args );

      array_unshift( $task_args, $arg );

    }

    mud_log_trace( "command not found: " . implode( ' ', $args ) );

    return new jj_help( $task_args );

  }

  public function get_class_name( array $args ) : string {

    return 'jj_' . str_replace( '-', '_', implode( '_', $args ) );

  }

  public function get_category_to_task_list() {

    $this->load_tasks();

    $result = [];
    $map = $this->category_to_task_list;

    foreach ( AppTaskCategory::cases() as $category_enum ) {

      if ( $category_enum === AppTaskCategory::Internal ) { continue; }

      $category_enum_value = $category_enum->value;

      $task_list = $map[ $category_enum_value ] ?? [];

      if ( ! $task_list ) { continue; }

      usort( $task_list, function( $a, $b ) {
        return $a->get_name() <=> $b->get_name();
      } );

      $result[ $category_enum_value ] = $task_list;

    }

    return $result;

  }

  public function get_task( $class, AppTask|null $parent = null ) {

    if ( ! array_key_exists( $class, $this->class_to_task ) ) {

      $task = new $class( $parent );

      $this->class_to_task[ $class ] = $task;
      $this->task_list[] = $task;
      $this->category_to_task_list[ $task->get_category()->value ][] = $task;

    }

    return $this->class_to_task[ $class ];

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-13 jj5 - protected functions...
  //

  protected function load_tasks() {

    $this->add_task( jj_complete::class );
    $this->add_task( jj_get_type::class );

    $this->add_task( jj_edit::class );
    $this->add_task( jj_go::class );

    $this->add_task( jj_find::class );
    $this->add_task( jj_name::class );
    $this->add_task( jj_path::class );

    $this->add_task( jj_chatgpt::class );
    $this->add_task( jj_cheat::class );
    $this->add_task( jj_define::class );
    $this->add_task( jj_search::class );

    $this->add_task( jj_bkts::class );
    $this->add_task( jj_clip::class );
    $this->add_task( jj_clip_file::class );
    $this->add_task( jj_host::class );

    $this->add_task( jj_bash::class );

    $this->add_task( jj_help::class );

  }

  protected function add_task( $class ) {

    $this->get_task( $class );

  }
}
