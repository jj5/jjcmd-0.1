<?php

class jj_search extends AppStandard {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Web;

  }

  protected function define_description() : string {

    return "Searches the web for SPEC.";

  }

  protected function define_parameters() {

    $this->add_sequential_parameter( 'SPEC' );

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function run() {

    $spec = implode( ' ', $this->get_arg( 'SPEC' ) );

    $query = escapeshellarg( 'https://duckduckgo.com/?atb=v320-1&ia=web&q=' . urlencode( $spec ) );

    exec( 'firefox ' . $query );

  }
}
