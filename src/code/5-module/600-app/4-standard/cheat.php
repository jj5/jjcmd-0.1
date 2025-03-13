<?php

class jj_cheat extends AppStandard {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Web;

  }

  protected function define_description() : string {

    return "Finds cheatsheets for SPEC from https://cheat.sh/ (web site).";

  }

  protected function define_parameters() {

    $this->add_sequential_parameter( 'TEXT' );

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

    $spec = implode( ' ', $this->get_arg( 'TEXT' ) );

    $query = escapeshellarg( 'https://cheat.sh/' . urlencode( $spec ) );

    passthru( 'curl -s ' . $query );

  }
}
