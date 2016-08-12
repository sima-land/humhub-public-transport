<?php

namespace humhub\modules\transport\components;

use Yii;
use yii\web\CompositeUrlRule;

class UrlRule extends CompositeUrlRule
{
    protected function createRules()
    {
        return [];
    }
}
