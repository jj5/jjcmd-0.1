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

  public function get_task( $class ) {

    echo "getting class $class\n";

    if ( ! array_key_exists( $class, $this->class_to_task ) ) {

      $task = new $class();

      $this->class_to_task[ $class ] = $task;
      $this->task_list[] = $task;
      $this->category_to_task_list[ $task->get_category()->value ][] = $task;

    }

    return $this->class_to_task[ $class ];

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - private functions...
  //

  private function load_tasks() {

    if ( $this->task_list ) { return; }

    foreach ( get_declared_classes() as $class ) {

      if ( strpos( $class, 'jj_' ) === 0 ) {

        $this->get_task( $class );

      }
    }
  }
}
