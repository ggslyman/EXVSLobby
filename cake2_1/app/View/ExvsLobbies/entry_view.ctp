<?php 
	echo $this->Html->css(array('style','sort'),false);
	echo $this->Html->script(array('jquery-latest.js','jquery.tablesorter.min','jquery.timer','audio.min'),false);
?>
<script type="text/javascript">
<!--
function doReload() {
	window.location.reload();
}
$(function(){
	$(".tablesorter").tablesorter({widgets:['zebra']});
	var latest_date = false;
	var new_date = false;
	$.ajax({
		url: 'getLatestEntry',
		type: 'GET',
		dataType: 'text',
		timeout: 10000,
		success: function(data){
			latest_date = data;
			$("#latest_update").html(latest_date);
		}
	});
	$.timer(60000, function (timer) {
		if(!latest_date || latest_date==""){
			$.ajax({
				url: 'getLatestEntry',
				type: 'GET',
				dataType: 'text',
				timeout: 10000,
				success: function(data){
					latest_date = data;
					$("#latest_update").html(latest_date);
				}
			});
		}else{
			$.ajax({
				url: 'getLatestEntry',
				type: 'GET',
				dataType: 'text',
				timeout: 10000,
				success: function(data){
					new_date = data;
				}
			});
			if((latest_date < new_date) || (!latest_date && new_date)){
				audiojs.events.ready(function() {
					var as = audiojs.createAll();
				});
				setTimeout("doReload()",4000) 
			}
		}
	});
	$("#ts3toggle").click(function () {
		if ($("#whatsts3").is(":hidden")){
			$("#whatsts3").slideDown("slow");
		} else {
			$("#whatsts3").slideUp("slow");
		}
	});
});
-->
</script>
最終更新日時：<span id="latest_update"></span><br/><br/>
<div style="font-weight:bold;color:#CC0000">
ページを開いたままにしておくと、新規登録がされた時にスト2の乱入音が鳴ります。<br/>
対戦相手待ちの方はこのページを別タブにでも開いておいてください。<br/>
この機能を利用する場合にはJavaScriptはONにしてください。<br/>
</div>
<br/>

<?php
	echo $this->Html->link('対戦相手を募集する。','entry_form',null,null,false)."<br/><br/>";
?>
<div id="ts3toggle">TeamSpeak3について</div>
<div id="whatsts3" style="display:none;">
FPSゲーマー御用達ボイスチャットツール。
スイッチ押下時のみトークなどあるので、USBフットスイッチなんかあるなら、
スティックのノイズのらなくていいかも。
<br />
公開サーバ情報:http://hovel.arcenserv.info/ts3/?%E3%83%95%E3%83%AA%E3%83%BC%E3%82%B5%E3%83%BC%E3%83%90<br />
PW:peer<br />
<?php
	echo $this->Html->link('TS3導入と日本語化','http://hovel.arcenserv.info/ts3/?%E3%82%AF%E3%83%A9%E3%82%A4%E3%82%A2%E3%83%B3%E3%83%88%2F%E5%B0%8E%E5%85%A5',array("target"=>"blank"),null,false);
	echo "<br/>";
	echo $this->Html->link('TS3使い方','http://hovel.arcenserv.info/ts3/?%E3%82%AF%E3%83%A9%E3%82%A4%E3%82%A2%E3%83%B3%E3%83%88%2F%E6%A9%9F%E8%83%BD%E7%B4%B9%E4%BB%8B',array("target"=>"blank"),null,false);
?>
<br />
</div><br/>
<?php
if($entrys){
?>
<table id="entry" class="tablesorter">
<thead>
<tr>
<th width="60">募集<br>開始<br>時間</th>
<th width="60">終了<br>予定<br>時間</th>
<th width="30">機種</th>
<th width="60">ゲームID</th>
<th width="50">ニックネーム</th>
<th width="90">連絡手段</th>
<th width="150">連絡先(Skypeid等)</th>
<th width="40">SP</th>
<th width="200">コメント</th>
<th width="130">使用キャラ</th>
<th width="80">対戦状況</th>
<th width="80">削除</th>
</tr>
</thead>
<tbody>
<?php
	foreach($entrys as $entry){
		echo '<tr><td>';
		echo str_replace(' ','<br/>',str_replace('-','/',substr($entry['Entry']['start_datetime'],2,14)));
		echo '</td><td>';
		echo str_replace(' ','<br/>',str_replace('-','/',substr($entry['Entry']['end_datetime'],2,14)));
		echo '</td><td>';
		echo $platforms[$entry['Entry']['platform']];
		echo '</td><td>';
		echo $entry['Entry']['game_id'];
		echo '</td><td>';
		echo $entry['Entry']['nickname'];
		echo '</td><td align="right">';
		echo $messenger_types[$entry['Entry']['messenger_type']];
		echo '</td><td>';
		echo $entry['Entry']['messenger_id'];
		echo '</td><td>';
		echo $entry['Entry']['single_point'];
		echo '</td><td>';
		echo nl2br(h($entry['Entry']['comment']));
		echo '</td><td>';
			foreach($characters[$entry['Entry']['entry_id']] as $character){
				echo '<div class="clearfix">';
				echo '<div style="float:left">';
				echo $character['Character']['character_name'];
				echo '</div><div style="float:right">';
				echo $character['EntryCharacter']['character_point'];
				echo '</div></div>';
				echo '<br/>';
			}
		echo '</td><td>';
		echo $this->Form->create("ExvsLobby",array("action"=>"entry_view","type"=>"post"));
		echo $this->Form->hidden('Entry.entry_id', array('value'=>$entry['Entry']['entry_id']));
		if($entry['Entry']['now_fight_flag']==1){
			echo "対戦中<br/>";
			echo $this->Form->password('Entry.password', array('value'=>"",'size'=>10)).$this->Form->submit('終了', array('name' => 'fight_end'));
		}else{
			echo "受付中<br/>";
			echo $this->Form->password('Entry.password', array('value'=>"",'size'=>10)).$this->Form->submit('開始', array('name' => 'fight_start'));
		}
		echo '</form>';
		echo '</td><td>';
		echo $this->Form->create("ExvsLobby",array("action"=>"entry_view","type"=>"post"));
		echo $this->Form->hidden('Entry.entry_id', array('value'=>$entry['Entry']['entry_id']));
		echo $this->Form->password('Entry.password', array('value'=>"",'size'=>10)).$this->Form->submit('削除', array('name' => 'delete'));
		echo '</form>';
		echo '</td></tr>';
	}
echo '</tbody>';
echo '</table>';
}
?>
登録期間に関しては実際に反応出来る時間を設定してください。<br />
長期間表示されいる場合は予告なく削除される可能性があります。<br />
<br />
今対戦できる相手が見つけられるという意味合いの為、<br/>
募集開始時間まで1時間以上あるデータは表示されません。<br/>
<br/>
<audio style="display:none;" src="http://www.vash-ch.com/ssf4ae/files/HERE_COMES_A_NEW_CHALLENGER.mp3" autoplay="autoplay" />
