<?php

define( 'APP_CACHE_DIR', '/var/state/jjcmd' );
define( 'APP_CACHE_FILE', 'jjcmd.json' );
define( 'APP_CACHE_PATH', APP_CACHE_DIR . '/' . APP_CACHE_FILE );

define( 'APP_CACHE_ATTEMPT_LIMIT', 50 );
define( 'APP_CACHE_ATTEMPT_DELAY', 100_000 );

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

  protected array $parameter_map = [];
  protected array $parameter_list = [];
  protected array $sequential_parameter_list = [];
  protected array $named_parameter_list = [];
  protected array $flag_parameter_list = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function get_cache( $spec, &$data = null ) {

    if ( ! file_exists( APP_CACHE_PATH ) ) { return null; }

    $handle = self::fopen( APP_CACHE_PATH, 'r' );

    self::flock( $handle, LOCK_SH );

    $json = self::stream_get_contents( $handle );

    self::flock( $handle, LOCK_UN );

    self::fclose( $handle );

    $data = json_decode( $json, true );

    $path = $data[ 'cache' ][ $spec ] ?? null;

    return $path;

  }

  public function clear_cache( $spec ) {

    return $this->set_cache( $spec, null );

  }

  public function set_cache( $spec, $path ) {

    if ( ! is_dir( APP_CACHE_DIR ) ) { return false; }

    $handle = self::fopen( APP_CACHE_PATH, 'c+' );

    self::flock( $handle, LOCK_EX );

    $contents = self::stream_get_contents( $handle );

    $data = json_decode( $contents, true );

    if ( ! $data ) { $data = []; }

    if ( ! isset( $data[ 'cache' ] ) ) { $data[ 'cache' ] = []; }

    unset( $data[ 'cache' ][ $spec ] );

    if ( $path ) {

      $data[ 'cache' ][ $spec ] = $path;

    }

    $json = json_encode( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );

    self::ftruncate( $handle, 0 );

    self::rewind( $handle );

    self::fwrite( $handle, $json );

    self::fflush( $handle );

    self::flock( $handle, LOCK_UN );

    self::fclose( $handle );

    return true;

  }

  protected static function fopen( string $path, string $mode ) {

    $handle = self::attempt( __FUNCTION__, function() use ( $path, $mode ) {

      return fopen( $path, $mode );

    } );

    return $handle;

  }

  protected static function flock( $handle, int $operation ) {

    return self::attempt( __FUNCTION__, function() use ( $handle, $operation ) {

      return flock( $handle, $operation );

    } );

  }

  protected static function stream_get_contents( $handle, ?int $length = null, int $offset = -1 ) {

    return self::attempt( __FUNCTION__, function() use ( $handle, $length, $offset ) {

      return stream_get_contents( $handle, $length, $offset );

    } );

  }

  protected static function ftruncate( $handle, int $size ) {

    return self::attempt( __FUNCTION__, function() use ( $handle, $size ) {

      return ftruncate( $handle, $size );

    } );

  }

  protected static function rewind( $handle ) {

    return self::attempt( __FUNCTION__, function() use ( $handle ) {

      return rewind( $handle );

    } );

  }

  protected static function fwrite( $handle, string $data, ?int $length = null ) {

    return self::attempt( __FUNCTION__, function() use ( $handle, $data, $length ) {

      return fwrite( $handle, $data, $length );

    } );

  }

  protected static function fflush( $handle ) {

    return self::attempt( __FUNCTION__, function() use ( $handle ) {

      return fflush( $handle );

    } );

  }

  protected static function fclose( $handle ) {

    return self::attempt( __FUNCTION__, function() use ( $handle ) {

      return fclose( $handle );

    } );

  }

  protected static function attempt( $function, $callback ) {

    for ( $attempt = 1; $attempt < APP_CACHE_ATTEMPT_LIMIT; $attempt++ ) {

      $result = $callback();

      if ( $result !== false ) { return $result; }

      usleep( APP_CACHE_ATTEMPT_DELAY );

      mud_log_4_warning( "failed to '$function', attempt $attempt." );

    }

    mud_fail( "failed to '$function' after $attempt attempts." );

  }

  public function run( $argv ) {

    $args = $argv;

    $script = array_shift( $args );

    mud_log_trace( '////////////////////////////////////////////////////////////////////////////////////////////////////' );
    mud_log_trace( 'script..', $script );
    mud_log_trace( 'args....', $args );

    $task = $args ? $this->find_task( $args ) : $this->get_help_task();

    if ( $task ) {

      mud_log_trace( "running task: " . get_class( $task ) );

      return $task->process();

    }

    mud_log_trace( "could not find task: " . implode( ' ', $args ) );

  }

  public function get_task_list() {

    $result = [];

    foreach ( $this->task_list as $task ) {

      if ( $task->is_subtask() ) { continue; }

      $result[] = $task;

    }

    return $result;

  }

  public function find_task( array $args ) {

    $task_args = [];

    while ( $args ) {

      $class_name = self::get_class_name( $args );

      mud_log_trace( "checking class: $class_name" );

      if ( class_exists( $class_name ) ) {

        $task = $this->get_task( $class_name );

        $task->set_args( $task_args );

        return $task;

      }

      $arg = array_pop( $args );

      array_unshift( $task_args, $arg );

    }

    mud_log_trace( "command not found: " . implode( ' ', $args ) );

    return null;

  }

  public function get_help_task( array $args = [] ) {

    $task = $this->get_task( jj_help::class );

    $task->set_args( $args );

    return $task;

  }

  public function get_class_name( array $args ) : string {

    return 'jj_' . str_replace( '-', '_', implode( '_', $args ) );

  }

  public function get_category_to_task_list() {

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

    return $this->class_to_task[ $class ] ?? null;

  }

  public function add_task( $class ) {

    $this->new_task( $class );

  }

  public function new_task( $class, AppTask|null $parent = null ) {

    if ( ! array_key_exists( $class, $this->class_to_task ) ) {

      $task = new $class( $parent );

      $this->class_to_task[ $class ] = $task;
      $this->task_list[] = $task;
      $this->category_to_task_list[ $task->get_category()->value ][] = $task;

    }

    return $this->class_to_task[ $class ];

  }

  public function get_parameter( string $name ) {

    return $this->parameter_map[ $name ] ?? null;

  }

  public function add_sequential_parameter(
    string $name,
    string $description,
    AppParameterType $type = AppParameterType::String,
    bool|null $is_optional = null,
    bool $is_list = false
  ) {

    $index = count( $this->sequential_parameter_list );

    if ( $is_optional === null ) { $is_optional = $index > 0; }

    $parameter = new AppSequentialParameter(
      $name,
      $description,
      $type,
      $is_optional,
      $is_list,
      $index,
    );

    assert( ! isset( $this->parameter_map[ $name ] ) );

    $this->parameter_map[ $name ] = $parameter;
    $this->parameter_list[] = $parameter;
    $this->sequential_parameter_list[] = $parameter;

  }

  public function add_named_parameter(
    string $name,
    string $description,
    AppParameterType $type = AppParameterType::String,
    bool $is_optional = true,
  ) {

    $parameter = new AppNamedParameter(
      $name,
      $description,
      $type,
      $is_optional,
    );

    assert( ! isset( $this->parameter_map[ $name ] ) );

    $this->parameter_map[ $name ] = $parameter;
    $this->parameter_list[] = $parameter;
    $this->named_parameter_list[] = $parameter;

  }

  public function add_flag_parameter(
    string $name,
    string $description,
  ) {

    $param = new AppFlagParameter(
      $name,
      $description,
      AppParameterType::Boolean,
      $is_optional = true,
      true,
    );

    assert( ! isset( $this->parameter_map[ $name ] ) );

    $this->parameter_map[ $name ] = $param;
    $this->parameter_list[] = $param;
    $this->named_parameter_list[] = $param;
    $this->flag_parameter_list[] = $param;

  }

}
