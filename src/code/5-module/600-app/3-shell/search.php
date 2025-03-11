<?php

class jj_search extends AppShell {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Web;

  }

  protected function define_description() : string {

    return "Searches the web for SPEC.";

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

    $this->add_sequential_parameter(
      'SPEC',
      'The query.',
      AppParameterType::String,
      $is_optional = false,
      $is_list = true,
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function run() {

    $spec = implode( ' ', $this->get_arg( 'SPEC' ) );

    $query = addslashes( 'https://duckduckgo.com/?atb=v320-1&ia=web&q=' . urlencode( $spec ) );

    mud_stdout( 'firefox ' . $query . "\n" );

  }
}
