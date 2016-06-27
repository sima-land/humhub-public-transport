<?php

	use humhub\modules\user\models\User;
	use humhub\widgets\TopMenu;
	use humhub\modules\user\widgets\ProfileHeaderControls;
	
	return [
		'id' => 'public_transport_map',
		'class' => 'humhub\modules\public_transport_map\Module',
		'namespace' => 'humhub\modules\public_transport_map',
		'events' => [
			['class' => User::className(), 'event' => User::EVENT_BEFORE_DELETE, 'callback' => ['humhub\modules\public_transport_map\Events', 'onUserDelete']],
			['class' => TopMenu::className(), 'event' => TopMenu::EVENT_INIT, 'callback' => ['humhub\modules\public_transport_map\Events', 'onTopMenuInit']],
			['class' => ProfileHeaderControls::className(), 'event' => ProfileHeaderControls::EVENT_INIT, 'callback' => ['humhub\modules\public_transport_map\Events', 'onProfileHeaderControlsInit']],
		],
	];
	
?>
