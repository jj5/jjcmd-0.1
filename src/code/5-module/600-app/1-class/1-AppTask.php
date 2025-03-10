<?php

abstract class AppTask {

  public array $args;

  public function __construct( array $args ) {

    $this->args = $args;

  }

  public abstract function get_type() : string;

  public abstract function run();

}
