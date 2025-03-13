<?php

class jj_bash_array extends AppLanguage {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_description() : string {

    return "How to use arrays in BASH.";

  }

  protected function define_parameters() {

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function print() {
?>
array_demo() {
  local arr=();
  array_report "${arr[@]}";
  arr+=( 1 2 3 );
  array_report "${arr[@]}";
  arr+=( 4 5 6 );
  array_report "${arr[@]}";
}
array_report() {
  local arr=("$@");
  echo;
  echo "We have ${#arr[@]} items...";
  for val in "${arr[@]}"; do
    echo $val;
  done;
}
<?php
  }
}
