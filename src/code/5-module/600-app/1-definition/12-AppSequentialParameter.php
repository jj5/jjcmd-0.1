<?php

class AppSequentialParameter extends AppParameter {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - fields...
  //

  protected int $index;
  protected string $name;
  protected string $description;
  protected bool $is_list;
  protected int $min_count;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct(
    AppParameterType $type,
    bool $is_optional,
    int $index,
    string $name,
    string $description,
    bool $is_list
  ) {

    parent::__construct( $type, $is_optional );

    $this->index = $index;
    $this->name = $name;
    $this->description = $description;
    $this->is_list = $is_list;
    $this->min_count = $is_optional ? 0 : 1;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function get_index() : int {
    return $this->index;
  }

  public function get_ordinal() : int {
    return $this->index + 1;
  }

  public function get_name() : string {
    return $this->name;
  }

  public function get_description() : string {
    return $this->description;
  }

  public function is_list() : bool {
    return $this->is_list;
  }

  public function get_min_count() : int {
    return $this->min_count;
  }
}
