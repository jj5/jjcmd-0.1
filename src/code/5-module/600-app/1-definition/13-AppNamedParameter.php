<?php

class AppNamedParameter extends AppParameter {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - fields...
  //

  protected string $name;
  protected string $description;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct(
    AppParameterType $type,
    bool $is_optional,
    string $name,
    string $description,
  ) {

    parent::__construct( $type, $is_optional );

    $this->name = $name;
    $this->description = $description;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function get_name() : string {
    return $this->name;
  }

  public function get_description() : string {
    return $this->description;
  }
}
