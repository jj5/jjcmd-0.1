<?php

class jj_bash_for extends AppLanguage {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_description() : string {

    return "How to 'for' loops in BASH.";

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
local list=( 'A', 'B', 'C' );

for item in "${list[@]}"; do

  echo "checking $item...";

  [ "$item" == "B" ] && continue;

  echo "found $item...";

done;

local length=${#list[@]}

for (( i=0; i<length; i++ )); do

  printf "index %d with value %s\n" $i "${list[$i]}"

done
<?php
  }
}
