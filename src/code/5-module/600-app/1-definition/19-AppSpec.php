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

  public function get_parameter_map() { return $this->parameter_map; }
  public function get_parameter_list() { return $this->parameter_list; }
  public function get_sequential_parameter_list() { return $this->sequential_parameter_list; }
  public function get_named_parameter_list() { return $this->named_parameter_list; }
  public function get_flag_parameter_list() { return $this->flag_parameter_list; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - protected functions...
  //

  protected function add_sequential_parameter( string $name, bool|null $is_optional = null ) {

    $template = app()->get_parameter( $name );

    $index = count( $this->sequential_parameter_list );

    if ( $is_optional === null ) {

      if ( $template->is_optional() === null ) {

        $is_optional = $index > 0;

      }
      else {

        $is_optional = true;

      }
    }

    $parameter = new AppSequentialParameter(
      $name,
      $template->get_description(),
      $template->get_type(),
      $is_optional,
      $template->is_list(),
      $index,
    );

    assert( ! isset( $this->parameter_map[ $name ] ) );

    $this->parameter_map[ $name ] = $parameter;
    $this->parameter_list[] = $parameter;
    $this->sequential_parameter_list[] = $parameter;

  }

  protected function add_named_parameter(
    string $name,
    bool|null $is_optional = null,
  ) {

    $template = app()->get_parameter( $name );

    if ( $is_optional === null ) {

      if ( $template->is_optional() === null ) {

        $is_optional = true;

      }
      else {

        $is_optional = true;

      }
    }

    $parameter = new AppNamedParameter(
      $name,
      $template->get_description(),
      $template->get_type(),
      $is_optional,
    );

    assert( ! isset( $this->parameter_map[ $name ] ) );

    $this->parameter_map[ $name ] = $parameter;
    $this->parameter_list[] = $parameter;
    $this->named_parameter_list[] = $parameter;

  }

  protected function add_flag_parameter( string $name ) {

    $template = app()->get_parameter( $name );

    $param = new AppFlagParameter(
      $name,
      $template->get_description(),
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

  public function get_optional_parameter_list() {

    return array_filter( $this->parameter_list, function( $parameter ) {
      return $parameter->is_optional();
    });

  }

  public function get_required_parameter_list() {

    return array_filter( $this->parameter_list, function( $parameter ) {
      return ! $parameter->is_optional();
    });

  }
}
