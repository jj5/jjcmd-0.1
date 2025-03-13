<?php

abstract class AppTask {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - mixins...
  //

  use AppSpec;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - fields...
  //

  protected AppTaskType $type;
  protected AppTaskCategory $category;
  protected ReflectionClass $reflection_class;
  protected string $name;
  protected string $description;

  protected array $args;
  protected array $sequential_arg_map;
  protected array $named_arg_map;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    $this->type = $this->define_type();
    $this->category = $this->define_category();
    $this->reflection_class = new ReflectionClass( $this );
    $this->name = $this->define_name();
    $this->description = $this->define_description();
    $this->args = [];

    $this->define_parameters();
    $this->define_options();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - abstract functions...
  //

  public abstract function run();

  protected abstract function define_type() : AppTaskType;

  protected abstract function define_category() : AppTaskCategory;

  protected abstract function define_description() : string;

  protected abstract function define_parameters();

  protected abstract function define_options();


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function get_parent_task() : AppTask {

    // 2025-03-14 jj5 - HACK! This is regrettable, I should fix it...

    return $this;

  }

  public function is_subtask() : bool { return false; }

  public function complete( $arg1, $arg2, $arg3, $arg4 ) {

    mud_log_trace( "complete", [ $arg1, $arg2, $arg3, $arg4 ] );

    foreach ( $this->get_named_parameter_list() as $param ) {

      $name = $param->get_name();

      if ( strpos( $name, $arg2 ) === 0 ) {

        echo $name . "\n";

      }
    }
  }

  public function process() {

    $this->run();

  }

  public function get_type() : AppTaskType {

    return $this->type;

  }

  public function get_category() : AppTaskCategory {

    return $this->category;

  }

  public function get_name() : string {

    return $this->name;

  }

  public function get_description() : string {

    return $this->description;

  }

  public function set_args( array $args ) {

    $this->args = $args;

    $sequential_arg_map = [];
    $named_arg_map = [];

    $parameter_map = $this->get_parameter_map();
    $sequential_parameter_list = $this->get_sequential_parameter_list();
    $sequential_parameter = array_shift( $sequential_parameter_list );

    while ( null !== $arg = array_shift( $args ) ) {

      if ( $arg === '--' ) { break; }

      if ( array_key_exists( $arg, $parameter_map ) ) {

        $parameter = $parameter_map[ $arg ];

        assert( ! $parameter->is_sequential() );

        if ( $parameter->is_flag() ) {

          $named_arg_map[ $arg ] = $parameter->get_value();

        }
        else {

          $value = array_shift( $args );

          $named_arg_map[ $arg ] = $parameter->parse( $value );

        }
      }
      else {

        self::parse_sequential( $arg, $sequential_arg_map, $sequential_parameter, $sequential_parameter_list );

      }
    }

    while ( null !== $arg = array_shift( $args ) ) {

      self::parse_sequential( $arg, $sequential_arg_map, $sequential_parameter, $sequential_parameter_list );

    }

    $this->sequential_arg_map = $sequential_arg_map;
    $this->named_arg_map = $named_arg_map;

  }

  protected static function parse_sequential(
    $arg,
    &$sequential_arg_map,
    &$sequential_parameter,
    &$sequential_parameter_list,
  ) {

    if ( $sequential_parameter === null ) {

      mud_fail( "too many arguments.", [ 'class' => get_called_class() ] );

    }

    $arg_value = $sequential_parameter->parse( $arg );

    if ( $sequential_parameter->is_list() ) {

      $sequential_arg_map[ $sequential_parameter->get_name() ][] = $arg_value;

    }
    else {

      $sequential_arg_map[ $sequential_parameter->get_name() ] = $arg_value;

      $sequential_parameter = array_shift( $sequential_parameter_list );

    }
  }

  protected function set_arg( $name, $value ) {

    $this->named_arg_map[ $name ] = $value;

  }

  public function get_arg( $name ) {

    if ( array_key_exists( $name, $this->named_arg_map ) ) {

      return $this->named_arg_map[ $name ];

    }

    if ( array_key_exists( $name, $this->sequential_arg_map ) ) {

      return $this->sequential_arg_map[ $name ];

    }

    return null;

  }

  public function get_args() : array {

    return $this->args;

  }

  public function print_help( array $args ) {

    $opt_list = [];
    $req_list = [];

    foreach ( $this->get_parameter_list() as $param ) {

      if ( $param->is_optional() ) {

        $opt_list[] = $param;

      }
      else {

        $req_list[] = $param;

      }
    }

    $this->print_usage();

    echo "\n";

    echo $this->get_description() . "\n";

    if ( count( $req_list ) > 0 ) {

      echo "\nParameters:\n";

      foreach ( $req_list as $param ) {

        echo $param->print_help();

      }
    }

    if ( count( $opt_list ) > 0 ) {

      echo "\nOptions:\n";

      foreach ( $opt_list as $param ) {

        echo $param->print_help();

      }
    }
  }

  public function print_usage() {

    $task = $this;

    $path = [];

    do {

      $name = $task->get_name();

      $path[] = $name;

      $task = $task->get_parent_task();

    }
    while ( $task !== $task->get_parent_task() );

    array_reverse( $path );

    $path = implode( ' ', $path );

    echo "Usage: jj $path " . $this->get_usage() . "\n";

  }

  public function get_usage() : string {

    $opt_params = [];
    $doc_params = [];

    foreach ( $this->get_parameter_list() as $param ) {

      if ( $param->is_optional() && $param->is_named() ) {

        $opt_params[] = $param;

      }
      else {

        $doc_params[] = $param;

      }
    }

    $result = [];

    if ( count( $opt_params ) > 0 ) {

      $result[] = '[OPTION]...';

    }

    foreach ( $doc_params as $param ) {

      $result[] = $param->get_usage();

    }

    return implode( ' ', $result );

  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - protected functions...
  //

  protected function define_name() : string {

    // 2025-03-13 jj5 - NOTE: in future we might want to support a more flexible way of defining the name of a task such
    // as allowing dashes to be used in the name and then converting them to underscores. For now we just use the class
    // name.

    $class = $this->reflection_class->getShortName();

    $parts = explode( '_', $class );

    $name = array_pop( $parts );

    return $name;

  }

  protected function wordwrap( string $text ) : string {

    $width = trim( shell_exec( 'tput cols' ) );

    $width = $width ? intval( $width ) : 80;

    return trim( wordwrap( $text, $width, "\n" ) );

  }

  public function calc_subtasks() {

    $result = [];

    $prefix = $this->reflection_class->getShortName() . '_';

    foreach ( get_declared_classes() as $class ) {

      if ( isset( $result[ $class ] ) ) { continue; }

      if ( strpos( $class, $prefix ) === 0 ) {

        $subtask = app()->get_task( $class );

        $subtask->set_parent_task( $this );

        $result[ $class ] = $subtask;

      }
    }

    return $result;

  }

  protected function complete_file( $arg2 ) {

    $search = '.';

    mud_log_trace( 'arg2', $arg2 );

    if ( $arg2 === '' ) {

      // 2025-03-12 jj5 - nothing to do...

    }
    elseif ( is_dir( $arg2 ) ) {

      $search = rtrim( $arg2, '/' );

    }
    else {

      $search = dirname( $arg2 );

    }

    $list = [];

    foreach ( scandir( $search ) as $item ) {

      if ( $item === '.' ) { continue; }
      if ( $item === '..' ) { continue; }

      $list[] = $item;

    }

    if ( $search === '.' ) {

      $result = $list;

    }
    else {

      foreach ( $list as $item ) {

        $result[] = "$search/$item";

      }
    }

    return $this->report_complete( $result, $arg2 );

  }

  protected function report_complete( $list, $arg2 ) {

    foreach ( $list as $item ) {

      if ( strpos( $item, $arg2 ) === 0 ) {

        echo $item . "\n";

      }
    }
  }

}
