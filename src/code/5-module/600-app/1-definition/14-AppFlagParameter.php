<?php

class AppFlagParameter extends AppNamedParameter {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - fields...
  //

  protected bool $value;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct(
    string $name,
    string $description,
    AppParameterType $type,
    bool $is_optional,
    bool $value,
  ) {

    parent::__construct( $name, $description, $type, $is_optional );

    $this->value = $value;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function is_sequential() : bool { return false; }
  public function is_named() : bool { return true; }
  public function is_flag() : bool { return true; }

}
