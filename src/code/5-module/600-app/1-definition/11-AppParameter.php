<?php

abstract class AppParameter {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - fields...
  //

  protected string $name;
  protected string $description;
  protected AppParameterType $type;
  protected bool|null $is_optional;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct(
    string $name,
    string $description,
    AppParameterType $type,
    bool|null $is_optional = null,
  ) {

    $this->name = $name;
    $this->description = $description;
    $this->type = $type;
    $this->is_optional = $is_optional;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - abstract functions...
  //

  public abstract function is_sequential() : bool;
  public abstract function is_named() : bool;
  public abstract function is_flag() : bool;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function get_name() : string {
    return $this->name;
  }

  public function get_description() : string {
    return $this->description;
  }

  public function get_type() : AppParameterType {
    return $this->type;
  }

  public function is_optional() : bool|null {
    return $this->is_optional;
  }

  public function get_default( $default = null ) {

    // 2025-03-25 jj5 - NOTE: this might work differently in future but for now we just return the override value. In
    // future we might want to return a global default value if the override is null.

    return $default;

  }

  public function parse( string $spec ) {

    $result = null;

    switch ( $this->get_type() ) {

      case AppParameterType::String:
        $result = $spec;
        break;

      case AppParameterType::Integer:
        $result = (int)$spec;
        break;

      case AppParameterType::Float:
        $result = (float)$spec;
        break;

      case AppParameterType::Boolean:
        $result = ! in_array( strtolower( $spec ), [ 'false', 'no', 'off', '0' ], $strict = true );
        break;

      default:
        throw new Exception( 'Unknown parameter type: ' . $this->get_type()->name );

    }

    return $result;

  }

  public function print_help() {

    echo $this->get_name() . ' - ' . $this->get_description() . "\n";

  }
}
