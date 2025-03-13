<?php

class jj_html_new extends AppLanguage {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_description() : string {

    return "Create a new HTML file.";

  }

  protected function define_parameters() {

    $this->add_named_parameter( '--title', $is_optional = false );

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function run() {

    $title = $this->get_arg( '--title' );
    $bkts = date( 'Y-m-d-His' );
    $date = date( 'r' );

    $this->print( $title, $bkts, $date );

  }

  public function print( $title, $bkts, $date ) {
    $title = htmlentities( $title );
    $bkts = htmlentities( $bkts );
    $date = htmlentities( $date );
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <title><?= $title ?></title>
  <meta charset="utf-8">
  <meta name="date" content="<?= $date ?>">
  <meta name="author" content="John Elliot V et al.">
  <!--
  <meta name="referrer" content="no-referrer">
  <meta name="robots" content="noindex, nofollow">
  <meta name="keywords" content="">
  <meta name="description" content="">
  -->
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <!-- 2022-10-13 jj5 - SEE: https://en.wikipedia.org/wiki/Polyglot_markup -->

  <link href="/favicon.ico" rel="icon">

  <link
    rel="stylesheet"
    type="text/css"
    href="https://www.staticmagic.net/global/default.css?v=<?= $bkts ?>">

  <script src="https://www.staticmagic.net/global/default.js?v=<?= $bkts ?>"></script>

<style>

html {
  min-height: 101%;
}

</style>

<script>

"use strict";

window.addEventListener( 'load', handle_load );

function handle_load() {
  //console.log( 'hi' );
};

</script>

</head>
<body>
  <main>
    <h1><?= $title ?></h1>

  </main>
</body>
</html>
<?php
  }
}
