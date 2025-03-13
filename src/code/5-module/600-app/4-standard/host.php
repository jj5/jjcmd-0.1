<?php

class jj_host extends AppStandard {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Info;

  }

  protected function define_description() : string {

    return "Prints information about this host.";

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

    $this->add_sequential_parameter(
      'SPEC',
      'The name of the item you want.',
      AppParameterType::String,
      $is_optional = true,
      $is_list = true,
    );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function run() {

    $item_list = $this->get_arg( 'SPEC' );

    if ( count( $item_list ) === 1 ) {

      $item = $item_list[ 0 ];

      $value = $this->get_item( $item );

      echo "$value\n";

    }
    else {

      $max_len = 0;

      foreach ( $item_list as $item ) {

        $max_len = max( $max_len, strlen( $item ) );

      }

      foreach ( $item_list as $item ) {

        $this->print_item( $item, $max_len );

      }
    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - protected functions...
  //

  protected function get_item( string $item ) {

    return trim( file_get_contents( "/etc/staticmagic/$item" ) );

  }

  protected function print_item( string $item, int $max_len ) {

    $value = $this->get_item( $item );

    echo str_pad( $item, $max_len + 2, '.' ) . ': ' . $value . "\n";

  }
}
