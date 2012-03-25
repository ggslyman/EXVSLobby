<?php
	echo $this->Html->css(array('style','anytime'),false);
	echo $this->Html->script(array('jquery-1.6.2.min','jquery-ui-1.8.16.custom.min','anytime','common'),false);
?>
<script type="text/javascript">
<!--
$(function(){
	AnyTime.picker( "field1",
			{ format: "%W, %M %D in the Year %z %E", firstDOW: 1 } );
		$(".datetimepicker").AnyTime_picker(
		{ format: "%Y/%m/%d %H:%i", labelTitle: "日時指定",
			labelHour: "Hora", labelMinute: "Minuto" } );
});
-->
</script>
<?php
	//エラー表示用タグ作成
	//
	function disp_error($errmsg){
		$err_head = '<font color="red">';
		$err_foot = '</font><BR />';
		return $err_head.$errmsg.$err_foot;
	}
?>
<?php
	echo $this->Html->link('対戦相手を探す。','entry_view',null,null,false)."<br/><br/><br/>";
?>
<h3>
	書き直しはできません<br />間違えた場合は削除してください。<br />
	またパスワードを入力しなかった場合は削除ができませんのでご了承ください。<br />
	登録期間に関しては実際に反応出来る時間を設定してください。<br />
	長期間表示されいる場合は予告なく削除される可能性があります。<br/>
	複数機種の情報を載せたい方は機種ごとに情報を登録してください。<br/>
	連絡手段が複数ある場合やリストに無い場合はその他(コメント欄)選択して、コメント欄に詳細を記載下さい。<br/>
</h3>
<?php
	//フォーム開始
	echo $this->Form->create("ExvsLobby",array("action"=>"entry_form","type"=>"post"));
	echo $this->Form->hidden("Entry.platform",array("value"=>1,"size"=>"24"));
	//大会IDをhiddenに設定
	//プレイヤー情報エラー処理
	if(isset($this->validationErrors["Entry"])){
		foreach($this->validationErrors["Entry"] as $error){
			echo disp_error($error);
		}
	}
?>
<table id="playerlist">
<?php
	//ps3id
?>
	<tr>
		<td>
			ゲームID
		</td>
		<td>
<?php
	echo $this->Form->text("Entry.game_id",array("value"=>$load_data["Entry"]["game_id"],"size"=>"24"));
?>
		</td>
	</tr>
	<tr>
		<td>
			パスワード
		</td>
		<td>
<?php
	echo $this->Form->password("Entry.password",array("size"=>"24"));
	echo "<br/>※前回登録時にパスワードを入力すると、次回、ゲームID、パスワードを入力し、<br/>読込ボタンを押すことで各種情報を前回入力情報で補完します。<br/>また削除時のパスワードとしても使用されます。";
	echo $this->Form->submit('読込', array('name' => 'load'));
?>
		</td>
	</tr>
<?php
/*
	<tr>
		<td>
			機種
		</td>
		<td>
<?php
	echo $this->Form->radio("Entry.platform",$platforms,array('value'=>$load_data["Entry"]["platform"],'legend' => false,'div' => false,'label' => false,'separator' => '<br />'));
?>
		</td>
	</tr>
*/
?>
	<tr>
		<td>
			ニックネーム
		</td>
		<td>
<?php
	//nickname
	echo $this->Form->text("Entry.nickname",array("value"=>$load_data["Entry"]["nickname"],"size"=>"24"));
?>
		</td>
	</tr>
	<tr>
		<td>
			連絡手段
		</td>
		<td>
<?php
	echo $this->Form->radio("Entry.messenger_type",$messenger_types,array('value'=>$load_data["Entry"]["messenger_type"],'legend' => false,'div' => false,'label' => false,'separator' => '<br />'));
?>
		</td>
	</tr>
	<tr>
		<td>
			連絡先(Skypeid等)
		</td>
		<td>
<?php
	echo $this->Form->text("Entry.messenger_id",array("value"=>$load_data["Entry"]["messenger_id"],"size"=>"24"));
?>
		</td>
	</tr>
	<tr>
		<td>
			PP
		</td>
		<td>
<?php
	//playerpoint
	echo $this->Form->text("Entry.single_point",array("value"=>$load_data["Entry"]["single_point"],"size"=>"5"));
?>
		</td>
	</tr>
	<tr>
		<td>
			プレイ予定時間
		</td>
		<td>
<?php
	//playerpoint
	echo $this->Form->text("Entry.start_datetime",array("size"=>"20","class"=>"datetimepicker")).'-'.$this->Form->text("Entry.end_datetime",array("size"=>"20","class"=>"datetimepicker"));
?>
		<br/>開始時刻は特に見ていませんが、終了日時を過ぎると表示されなくなります。<br/>特に日付をまたぐ募集の場合は気をつけて下さい。
		</td>
	</tr>
	<tr>
		<td>
			コメント
		</td>
		<td>
<?php
	//playerpoint
	echo $this->Form->textarea("Entry.comment",array("value"=>$load_data["Entry"]["comment"],"cols"=>"40","rows"=>"10"));
?>
		</td>
	</tr>
</table>
<br>
<?php
	if(isset($this->validationErrors["Character"])){
		foreach($this->validationErrors["Character"] as $error){
			echo disp_error($error);
		}
	}
?>
<table>
<?php
	$idx=1;
	foreach($characters as $character){
		if($idx++%3==1)echo "<tr>";
		//use character
		echo '<td align="right">';
		echo $character["Character"]["character_name"]."　";
		if($this->Form->error("character_point"))echo $err_head.$form->error("character_point").$err_foot;
		if(isset($charactors_cp[$character["Character"]["character_id"]])){
			$cp_value = $charactors_cp[$character["Character"]["character_id"]];
		}else{
			$cp_value = $this->Form->value("Character.character_point".$character["Character"]["character_id"]);
		}
		echo "CP：".$this->Form->text("EntryCharacter.character_point".$character["Character"]["character_id"],array("value"=>$cp_value,"size"=>"5"))."<BR>";
		echo '</td>';
		if($idx++%3==0)echo "</tr>";
	}
	echo "</table>";
	echo $this->Form->end('登録');
?>