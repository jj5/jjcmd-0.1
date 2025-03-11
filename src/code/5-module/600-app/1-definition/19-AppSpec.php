<?php

trait AppSpec {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - fields...
  //

  protected array $parameter_map = [];
  protected array $parameter_list = [];
  protected array $sequential_parameter_list = [];
  protected array $named_parameter_list = [];
  protected array $flag_parameter_list = [];


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function get_spec() {

    $spec = [];

    foreach ( $this->parameter_list as $parameter ) {

      $spec[] = $parameter->get_spec();

    }

    return $spec;


  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - protected functions...
  //

  protected function add_sequential_parameter(
    string $name,
    string $description,
    AppParameterType $type = AppParameterType::String,
    bool|null $is_optional = null,
    bool $is_list = false
  ) {

    $index = count( $this->sequential_parameter_list );

    if ( $is_optional === null ) { $is_optional = $index > 0; }

    $parameter = new AppSequentialParameter(
      $type,
      $is_optional,
      $index,
      $name,
      $description,
      $is_list
    );

    assert( ! isset( $this->parameter_map[ $name ] ) );

    $this->parameter_map[ $name ] = $parameter;
    $this->parameter_list[] = $parameter;
    $this->sequential_parameter_list[] = $parameter;

  }

  protected function add_named_parameter(
    string $name,
    string $description,
    AppParameterType $type = AppParameterType::String,
    bool $is_optional = true,
  ) {

    $parameter = new AppNamedParameter(
      $type,
      $is_optional,
      $name,
      $description,
    );

    assert( ! isset( $this->parameter_map[ $name ] ) );

    $this->parameter_map[ $name ] = $parameter;
    $this->parameter_list[] = $parameter;
    $this->named_parameter_list[] = $parameter;

  }

  protected function add_flag_parameter(
    string $name_true,
    string $name_false,
    string $description,
    bool $default_value = false,
    bool $is_optional = true,
  ) {

    $parameter = new AppFlagParameter(
      $is_optional,
      $name_true,
      $description,
      $name_false,
      $default_value,
    );

    assert( ! isset( $this->parameter_map[ $name_true ] ) );

    $this->parameter_map[ $name_true ] = $parameter;
    $this->parameter_list[] = $parameter;
    $this->flag_parameter_list[] = $parameter;

  }
}
