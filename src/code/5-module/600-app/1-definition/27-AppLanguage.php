<?php

abstract class AppLanguage extends AppSubtask {

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Languages;

  }
}
