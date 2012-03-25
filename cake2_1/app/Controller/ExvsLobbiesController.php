<?php
	//今回の主要処理を入れているコントロールクラス
	//本来、コントロールではこういうビジネスロジックを入れてはいけなくて、
	//Viewの入力をModelに渡し、Modelの処理結果をViewに渡すだけにするべきらしい。
	//でもModelに入れ込むのは結構めんどくさいからコントロールにベタ書いちゃう
	App::uses('AppController', 'Controller');
	class ExvsLobbiesController extends AppController{
		//name：1.3ではNameを入れる必要があったけど、2では必要ないみたい
		//var $name = 'ExvsLobbies';
		//uses：ここで使うモデルを指定するのが基本的な使い方だけれども、
		//ここでバインドすると毎回読み込むモデルの構造解析SQLを実行するのでｍ
		//各ファンクション内で$this->loadModelして読みこんでいる。
		var $uses = array();
		//いわゆるプラグイン的なもの。今回はコメントアウトしっぱなしだけれども、
		//DebugKitは本格的な開発では必須のアイテム
		//Authもログイン処理があるプログラムでは必須
		//var $components  = array('DebugKit.Toolbar','Auth');
		//このRequestHandlerはAjax的な処理をするために読み込んでいる
		var $components = array('RequestHandler');
		//JavaScriptを扱うヘルパーの読込だけど、今回HTMLヘルパーで読んでるから必要ないのかも
		//複数コントローラーを扱う場合は、Jsのような汎用的なヘルパーは各コントローラーで読むのではなく、
		//AppControllerという全てのコントローラーの元になるモデルで読み込むべき。
		var $helpers = array('Js');
		var $paginate = array();
		//全ての関数の実行前に行われる処理を記述する場所。
		//headerのrequire_once的なもの。
		//自前でログイン管理なんかするときには
		//ここでセッションのチェックとかしたりする。
		function beforeFilter() {
		}
		//後始末関数。あんまり使う時がない気がする。
		//人によってはViewの出力に対する共通フィルターとかを追記するらしい。
		//メリットがよくわからないので使ってない。
		function afterFilter() {
		}
		//indexはアクション名を省略された時に呼び出される処理。
		//今回は/exvs_lobbies/にアクセスした場合には
		//入力フォームに飛ぶように設定
		//
		function index(){
			$this->redirect('entry_form');
		}
		/*********************************************************************
			エントリーのフォーム
			主要機能はフォームの出力、過去データのロード、今回のデータの登録
		*********************************************************************/
		function entry_form(){
			//CakePHPでは強制的にNoticeという、実害はないが直した方がいいよ？というエラーを
			//ブラウザ上に出力結果として表示してしまうので
			//実運用に入ったらdebugというcoreファイルに記載されているパラメータを
			//0=エラー情報を出力しない設定にする。
			//もちろん本来はログファイル出力系の処理を入れて
			//エラーが起きてたら追えるようにする。
			Configure::write('debug', 0);
			//ここでモデルの読込を行う
			//実は今回はアクション二つで全モデルを読み込んでるので
			//クラスのプロパティのUsesで読み込んでも処理的に変わらないのだけれど、
			//習慣としてその関数で使うモデルをここで明記することにしている。
			$this->loadModel('Entry');
			$this->loadModel('Character');
			$this->loadModel('EntryCharacter');
			//ここの分岐はFormのボタンのname属性を利用した分岐
			//同一フォーム内の複数ボタンで別々の処理をする時によく使う手段。
			//Cakeじゃなくても$_POSTで拾えるので、
			//普通のPHPでも使える。
			if(isset($this->data['load'])){
				//$conditionsはCakeでは一般的にSQLの条件式を入れる部分。
				//今回はConditionsでWhere条件、OrderでOrder By条件、LimitでLimit条件を指定
				//以前書いたコードのままで作ったのでLimit1を残してしまったけれども、
				//CakePHPでやるならばOrder条件を入れて、find()の第一引数を
				//'first'にしてやるのが本式。
				//まあ、流れるSQLは多分同じ
				$conditions = array(
					'conditions' => array(
							'Entry.game_id' => $this->data['Entry']['game_id']
						,	'Entry.password' => md5($this->data['Entry']['password'])
									),
					'order' => array('Entry.entry_id'=>'DESC'),
					'limit' => 1
				);
				//Modelオブジェクトのfindで検索処理を実行
				//第一引数はall、first、listなどいくつか存在しますので
				//処理に合ったものを選びます
				//第二引数は上で作った検索条件です
				$load_data = $this->Entry->find('all',$conditions);
				//ここではデータが引けなかった場合に配列で初期化してます。
				//Noticeエラーが出てた為の処理なので基本意味ないです。
				if(count($load_data)==0){
					$load_data = array(
					'Entry'=>array(
						'game_id'	=>	'',
						'password'	=>	''
					));
				}
				//ここでロードデータが取れた場合に、データを取得してフォームに代入するために
				//Viewにパラメータを渡します（$this->set())
				//パスワードはDBに入っているのはMD5なのでPOSTデータを代入
				if($load_data){
					$load_data[0]["Entry"]["password"] = $this->data['Entry']['password'];
					//エントリー基本データをViewに引き渡し
					$this->set('load_data',$load_data[0]);
					//登録したCPのデータを取得する条件を指定
					$conditions = array(
						'conditions' =>array(
							'EntryCharacter.entry_id' => $load_data[0]["Entry"]["entry_id"]
						)
					);
					//find('all')指定では処理的にきれいな配列にならないので
					//一旦temp変数に代入し、ループで成形
					$temp_charactors = $this->EntryCharacter->find('all',$conditions);
					$charactors = array();
					//MSの主キーでCPが引けるように配列を修正
					foreach($temp_charactors as $temp_charactor){
						$charactors[$temp_charactor["EntryCharacter"]["character_id"]] = $temp_charactor["EntryCharacter"]["character_point"];
					}
					//作った配列をViewに引き渡し。
					$this->set('charactors_cp',$charactors);
				}else{
					//データが入ってなかったらPOSTデータをそのまま代入
					$this->set('load_data',$this->data);
				}
			}else{
				//こちらも同じ処理
				$this->set('load_data',$this->data);
				//別件で作ったときの残骸、後で消す。
				$unique_error = '';
				if($this->data){
					//フラグの初期化
					$valid_flag = true;
					//プレイヤー情報のvalidation
					//Validation設定はModelに定義してあり、
					//エラーがあればエラーメッセージも取れる。
					$this->Entry->set($this->data['Entry']);
					if(!$this->Entry->validates())$valid_flag = false;
					//キャラクター情報のvalidation。可変配列なのでForeachで処理
					foreach($this->data['EntryCharacter'] as $index_name => $cp){
						if(isset($cp)&&!is_numeric($cp)&&$cp!=''){
							$entry_char_row['EntryCharacter']['entry_id']= 1;
							$entry_char_row['EntryCharacter']['character_id']= str_replace('character_point','',$index_name);
							$entry_char_row['EntryCharacter']['character_point']= $cp;
							$this->EntryCharacter->set($entry_char_row);
							if(!$this->EntryCharacter->validates())$valid_flag = false;
						}
					}
					//Validationでエラーがでなければ保存処理を実行
					if($valid_flag){
						//保存用変数の初期化
						$row_entry = array();
						//プレイヤー情報のセーブ
						$row_entry['Entry']['entry_id'] = 0;
						//パスワードが入っていたらMD5で変換
						if(strlen($this->data['Entry']['password'])>0){
							$row_entry['Entry']['password'] = md5($this->data['Entry']['password']);
						}else{
						//パスワードが入ってなかったら空文字列を入れる
							$row_entry['Entry']['password'] = "";
						}
						//入れたパラメータでDBに保存
						//CakePHPのDBは基本的に主キーをAutoIncrimentにして
						//新規追加の時はIDに0を、更新の時には更新するデータをIDにセットし、
						//Saveを実行することでUpsertが実行されるので、
						//更新系と挿入系はデータの成形が終わった後は合流できる。
						$this->Entry->save($row_entry['Entry']);
						//getLastInsertID()を実行することによって、
						//最後にSaveメソッドを実行したクエリのIDを取得
						$last_id = $this->Entry->getLastInsertID();
						//キャラクター情報をセーブ
						//紐づけに上記last_idを使用
						foreach($this->data['EntryCharacter'] as $index_name => $cp){
							if(isset($cp)&&is_numeric($cp)){
								$entry_char_row = array();
								$entry_char_row['EntryCharacter']['entry_characters_id']= null;
								$entry_char_row['EntryCharacter']['entry_id']= $last_id;
								$entry_char_row['EntryCharacter']['character_id']=str_replace('character_point','',$index_name);
								$entry_char_row['EntryCharacter']['character_point']=$cp;
								$this->EntryCharacter->save($entry_char_row);
							}
						}
						//登録一覧へ
						//$this->render();
						$this->redirect('entry_view');
						//return;
					}
				}
			}
			//表示用デフォルトデータ
			//BP入力欄生成用のデータ取得
			$params= array(
				'fields' => array('Character.character_id','Character.character_name'),
				'order' => 'Character.character_id'
			);
			$characters = $this->Character->find('all',$params);
			$this->set('platforms',array(1=>'PS3',2=>'XBOX360',3=>'PC(steam)'));
			$this->set('messenger_types',array(1=>'Skype',2=>'MSN Messenger',3=>'PSN',4=>'TeamSpeak3',5=>'その他(コメント欄)'));
			$this->set('characters',$characters);
			$this->set('title_for_layout', '対戦相手募集登録');
			$this->render();
		}
		/*********************************************************************
			戦いたい人表示部分
		*********************************************************************/
		function entry_view($tournament_id = null){
			Configure::write('debug', 0);
			$this->loadModel('Entry');
			$this->loadModel('Character');
			$this->loadModel('EntryCharacter');
			//削除処理
			if(isset($this->data['delete']) && strlen($this->data["Entry"]["password"])>=1){
				if("48VYNcVYzstZtmqq6YisxbDoKDpSywCg"===$this->data["Entry"]["password"]){
					$del_data["Entry"]["delete_flag"] = 1;
					$del_data["Entry"]["entry_id"] = $this->data['Entry']['entry_id'];
					$this->Entry->save($del_data);
				}else{
					$conditions = array(
						'conditions' => array(
								'Entry.entry_id' => $this->data['Entry']['entry_id']
						)
					);
					$load_data = $this->Entry->find('first',$conditions);
					if($load_data){
						if($load_data["Entry"]["password"]==md5($this->data["Entry"]["password"])){
							$del_data["Entry"]["delete_flag"] = 1;
							$del_data["Entry"]["entry_id"] = $load_data["Entry"]["entry_id"];
							$this->Entry->save($del_data);
						}
					}
				}
			//対戦受付終了処理
			}elseif(isset($this->data['fight_start']) && strlen($this->data["Entry"]["password"])>=1){
				$conditions = array(
					'conditions' => array(
							'Entry.entry_id' => $this->data['Entry']['entry_id']
					)
				);
				$load_data = $this->Entry->find('first',$conditions);
				if($load_data){
					if($load_data["Entry"]["password"]==md5($this->data["Entry"]["password"])){
						$del_data["Entry"]["now_fight_flag"] = 1;
						$del_data["Entry"]["entry_id"] = $load_data["Entry"]["entry_id"];
						$this->Entry->save($del_data);
					}
				}
			//対戦受付開始処理
			}elseif(isset($this->data['fight_end']) && strlen($this->data["Entry"]["password"])>=1){
				$conditions = array(
					'conditions' => array(
							'Entry.entry_id' => $this->data['Entry']['entry_id']
					)
				);
				$load_data = $this->Entry->find('first',$conditions);
				if($load_data){
					if($load_data["Entry"]["password"]==md5($this->data["Entry"]["password"])){
						$del_data["Entry"]["now_fight_flag"] = 0;
						$del_data["Entry"]["entry_id"] = $load_data["Entry"]["entry_id"];
						$this->Entry->save($del_data);
					}
				}
			}
			//現在募集中の登録者
			//$this->paginate = array(
			$japan_timezone = new DateTimeZone('Asia/Tokyo');
			$now_date = new DateTime(null,$japan_timezone);
			$end_date = $now_date->format('Y/m/d H:i:s');
			date_add($now_date, date_interval_create_from_date_string('1 hours'));
			$start_date = $now_date->format('Y/m/d H:i:s');
			$params = array(
				'conditions' => array(
					'Entry.start_datetime <=' => $start_date,
					'Entry.end_datetime >' => $end_date,
					'Entry.delete_flag' => 0
					)
				,
				'order' => array('Entry.start_datetime'=>'ASC'),
				'recursive' => 2,
				'limit' => 65535
				);
			//$entrys = $this->paginate('Ssf4_entry');
			$entrys = $this->Entry->find('all',$params);
			//各出場者の使用キャラを取得
			$characters = array();
			$entry_ids = array();
			foreach($entrys as $entry){
				$characters[$entry['Entry']['entry_id']] = $this->EntryCharacter->find('all',array(
					'conditions' => array('EntryCharacter.entry_id' => $entry['Entry']['entry_id']),
					'fields' => array('Character.character_name','EntryCharacter.character_point'),
					'recursive' => 2,
					'order' => 'EntryCharacter.character_point DESC',
					'limit' => 65535
					));
					$entry_ids[] = $entry['Entry']['entry_id'];
			}
			$this->set('characters',$characters);
			$this->set('platforms',array(1=>'PS3',2=>'XBOX360'));
			$this->set('messenger_types',array(1=>'Skype',2=>'MSN Messenger',3=>'PSN',4=>'TeamSpeak3',5=>'その他(コメント欄)'));
			$this->set('entrys',$entrys);
			$this->set('title_for_layout', '対戦相手募集中');
			$this->render();
		}
		function getLatestEntry(){
			// デバッグ情報出力を抑制
			Configure::write('debug', 0);
			// ajax用のレイアウトを使用
			$this->layout = "ajax";
			// ajaxによる呼び出し？
			//if($this->RequestHandler->isAjax()) {
				$this->loadModel('entry');
				$now_date = new DateTime();
				$end_date = $now_date->format('Y/m/d H:i:s');
				date_add($now_date, date_interval_create_from_date_string('1 hours'));
				$start_date = $now_date->format('Y/m/d H:i:s');
				$params = array(
					'conditions' => array(
						'entry.start_datetime <=' => $start_date,
						'entry.end_datetime >' => $end_date
						,'entry.delete_flag' => 0
						)
					,
					'order' => array('entry.created'=>'DESC'),
					'limit' => 1
					);
				//$entrys = $this->paginate('Ssf4_entry');
				$entrys = $this->entry->find('all',$params);
				if($entrys){
					$this->set('last_update',$entrys[0]["entry"]["created"]);
				}else{
					$this->set('last_update',null);
				}
			//}
			$this->render();
		}
		/*********************************************************************
			RRGGBBの自動生成関数
			Googleのグラフ出力APIで使用
		*********************************************************************/
		function _get_col(){
			$r = rand(128,255); 
			$g = rand(128,255); 
			$b = rand(128,255); 
			$color = dechex($r) . dechex($g) . dechex($b); 
			return $color;
		}
	}
?>
