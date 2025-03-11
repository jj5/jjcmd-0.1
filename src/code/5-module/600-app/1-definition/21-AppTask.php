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


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    $this->type = $this->define_type();
    $this->category = $this->define_category();
    $this->reflection_class = new ReflectionClass( $this );
    $this->name = $this->define_name();
    $this->description = $this->wordwrap( $this->define_description() );
    $this->args = [];

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - abstract functions...
  //

  public abstract function run();

  protected abstract function define_type() : AppTaskType;

  protected abstract function define_category() : AppTaskCategory;

  // 2025-03-12 jj5 - TODO: make this abstract...
  protected function define_description() : string { return ''; }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function get_type() : AppTaskType {

    return $this->type;

  }

  public function get_category() : AppTaskCategory {

    return $this->category;

  }

  public function get_name() : string {

    return $this->name;

  }

  public function set_args( array $args ) {

    $this->args = $args;

  }

  public function get_args() : array {

    return $this->args;

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
