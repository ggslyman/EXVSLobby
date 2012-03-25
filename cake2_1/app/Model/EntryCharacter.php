<?php
	App::uses('Model', 'Model');
	class EntryCharacter extends AppModel {
		var $name = 'EntryCharacter';
		var $primaryKey = 'entry_characters_id';
		var $belongsTo  = array(
				'Character' => array(
					'className' => 'Character',
					'foreignKey' => 'character_id'
				)
			);
		var $virtualFields = array(
				'users' => 'count(1)',
				'cp' => 'sum(EntryCharacter.character_point)',
				'av_cp' => 'round(sum(EntryCharacter.character_point)/count(*))'
			);
		var $validate = array(
			'entry_id' => array(
				'rule1' => array(
					'rule' => 'numeric',
					'message' => 'エントリーIDを変更しないでください。'
				),
				'rule2' => array(
					'rule' => 'notEmpty',
					'message' => 'エントリーIDを変更しないでください。'
				)
			),
			'character_id' => array(
				'rule1' => array(
					'rule' => 'numeric',
					'message' => 'キャラクターIDを変更しないでください。'
				),
				'rule2' => array(
					'rule' => 'notEmpty',
					'message' => 'キャラクターIDを変更しないでください。'
				)
			),
			'character_point' => array(
				'rule1' => array(
					'rule' => 'numeric',
					'message' => 'CPは数字で入力してください。'
				)
			)
		);
	}
?>
