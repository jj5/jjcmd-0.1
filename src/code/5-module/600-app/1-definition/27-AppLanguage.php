<?php

abstract class AppLanguage extends AppSubtask {

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Languages;

  }

  public function run() {

    $this->print();

  }

  protected abstract function print();

}
