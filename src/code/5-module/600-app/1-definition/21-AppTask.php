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

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - abstract functions...
  //

  public abstract function run();

  protected abstract function define_type() : AppTaskType;

  protected abstract function define_category() : AppTaskCategory;

  protected abstract function define_description() : string;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

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

  public function print_help() {

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

    echo "Usage: jj " . $this->get_name() . " " . $this->get_usage() . "\n";

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

    return str_replace( '_', '-', substr( $this->reflection_class->getShortName(), 3 ) );

  }

  protected function wordwrap( string $text ) : string {

    $width = trim( shell_exec( 'tput cols' ) );

    $width = $width ? intval( $width ) : 80;

    return trim( wordwrap( $text, $width, "\n" ) );

  }
}
