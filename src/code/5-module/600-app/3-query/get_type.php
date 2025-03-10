<?php

class jj_get_type extends AppQuery {

  public function run() {

    $task = app_get_task( $this->args );

    echo $task->get_type() . "\n";

  }
}
