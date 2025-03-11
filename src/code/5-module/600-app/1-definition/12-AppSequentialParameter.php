<?php

class AppSequentialParameter extends AppParameter {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - fields...
  //

  protected bool $is_list;
  protected int $index;
  protected int $min_count;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct(
    string $name,
    string $description,
    AppParameterType $type,
    bool $is_optional,
    bool $is_list,
    int $index,
  ) {

    parent::__construct( $name, $description, $type, $is_optional );

    $this->is_list = $is_list;
    $this->index = $index;
    $this->min_count = $is_optional ? 0 : 1;

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function is_sequential() : bool { return true; }
  public function is_named() : bool { return false; }
  public function is_flag() : bool { return false; }

  public function get_index() : int {
    return $this->index;
  }

  public function get_ordinal() : int {
    return $this->index + 1;
  }

  public function is_list() : bool {
    return $this->is_list;
  }

  public function get_min_count() : int {
    return $this->min_count;
  }

  public function get_usage() : string {

    $result = $this->is_optional() ? "[{$this->name}]" :  $this->name;

    if ( $this->is_list() ) {

      $result .= '...';

    }

    return $result;

  }
}
