<?php
	App::uses('Model', 'Model');
	class Entry extends AppModel {
		var $name = 'Entry';
		var $primaryKey = 'entry_id';
		var $validate = array(
			'ps3id' => array(
				'rule1' => array(
					'rule' => array('custom','/[a-zA-Z0-9\._-]+/'),
					'message' => 'PS3IDは半角英数のみです。'
				),
				'rule2' => array(
					'rule' => 'notEmpty',
					'message' => 'PS3IDは必須です。'
				)
			),
			'nickname' => array(
				'rule1' => array(
					'rule' => 'notEmpty',
					'message' => 'ニックネームは必須です。'
				)
			),
			'start_datetime' => array(
				'rule1' => array(
					'rule' => 'notEmpty',
					'message' => '開始予定時間は必須です。'
				)
			),
			'end_datetime' => array(
				'rule1' => array(
					'rule' => 'notEmpty',
					'message' => '終了予定時間は必須です。'
				)
			),
			'single_point' => array(
				'rule1' => array(
					'rule' => 'numeric',
					'message' => 'SPは数字で入力してください。'
				)
			)
		);
	}
?>
