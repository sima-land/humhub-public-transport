<?php

namespace humhub\modules\transport;

use humhub\models\Setting;
use yii\helpers\Url;

/**
 * Class Module
 * @package humhub\modules\transport
 */
class Module extends \humhub\components\Module
{
    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/transport/admin/config']);
    }

    public function enable()
    {
        parent::enable();
        Setting::Set('is_shown', 0, 'transport');
    }
}
