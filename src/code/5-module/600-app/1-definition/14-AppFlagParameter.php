<?php

class AppFlagParameter extends AppNamedParameter {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - fields...
  //

  protected string $name_false;
  protected bool $default_value;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct(
    bool $is_optional,
    string $name_true,
    string $description,
    string $name_false,
    bool $default_value = false,
  ) {

    parent::__construct( AppParameterType::Boolean, $is_optional, $name_true, $description );

    $this->name_false = $name_false;
    $this->default_value = $default_value;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function get_name_true() : string {
    return $this->get_name();
  }

  public function get_name_false() : string {
    return $this->name_false;
  }
}
