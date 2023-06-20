<?php

/*
use \Model\Script; 
use \Model\Model_Script_Crud;
*/

/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Script extends Controller_Template
{

  //======================================================
	//
	// 1. トップページ
	//
	//======================================================

	/**
	 * トップページ
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		// データをセット
		$vals['ds'] = Model_Script::find(array(
			'order_by' => array(
				'id' => 'desc'
			),
			'limit' => 1000,
		));

		// 空なら空の配列をセット
		if (empty($vals['ds'])) {
			$vals['ds'] = array();
		}

		// お知らせの日時
		$vals['information_date'] = $this->get_information_date($vals);
		$vals['information_summary'] = $this->get_information_summary($vals, $vals['information_date']);
		// ジャンルをセット
		$this->set_genres($vals);
		// キャラ人数をセット
		$this->set_chara_counts($vals);
		// 時間をセット
		$this->set_mins($vals);
		// 作者名をセット
		$this->set_author_names($vals);

		$view = View::forge('template'); //テンプレートとなるビューファイルの読込み
		$view->set('content',View::forge('script/index', $vals));
		$view->set('page_title','声劇台本置き場'); 	
		$view->set_global('site_title','声劇台本置き場'); 	
		
		return Response::forge($view);
	}

	/**
	 * 新着のお知らせの日付を返す
	 */
	private function get_information_date(&$vals) {		
		if (empty($vals['ds'])) {
			return date('Y/m/d');
		}
		
		foreach ($vals['ds'] as $d) {
			return date('Y/m/d', strtotime($d['update_date']));;
		}
	}

	/*
	 * お知らせの内容を返す
	 */
	private function get_information_summary(&$vals, $tdt) {
		$n = 0;

		if ( empty($vals['ds']) ) {
			return "お知らせはありません。";
		}

		if (is_null($tdt)) {
			return "お知らせはありません。";
		}
	
		$tdt_txt = date('Y-m-d');

		foreach ($vals['ds'] as $d) {
			$dt_txt = date('Y-m-d', strtotime($d['update_date']));

			if ($dt_txt == $tdt_txt) {
				$n = $n + 1;
			}
		}

		return $n . "件の台本が投稿されました。";
	}

	/*
	 * ジャンル一覧をgenresにセット
	 */
	private function set_genres(&$vals) {
		$genres = array();
		if ( isset($vals['ds']) ) {
			foreach ($vals['ds'] as $d) {
				$g = $d['genre'];

				if ( !in_array($g, $genres) ){
					array_push($genres, $g);
				}
			}
		}

      asort($genres);
		$vals['genres'] = $genres;
	}

	/*
	 * 人数一覧をchara_countsにセット
	 */
	private function set_chara_counts(&$vals) {
		$chara_counts = array();
		if ( isset($vals['ds']) ) {
			foreach ($vals['ds'] as $d) {
				$c = $d['chara_count'];

				array_push($chara_counts, $c);
			}
		}

		$chara_counts = array_unique($chara_counts);
    asort($chara_counts);
		$vals['chara_counts'] = $chara_counts;
	}	

	/*
	 * 時間一覧をminutesにセット
	 */
	private function set_mins(&$vals) {
		$mins = array();
		if ( isset($vals['ds']) ) {
			foreach ($vals['ds'] as $d) {
				$c = $d['minutes'];

				array_push($mins, $c);
			}
		}

		$mins = array_unique($mins);
        asort($mins);
		$vals['mins'] = $mins;
	}		

	/*
	 * 作者一覧をauthor_namesにセット
	 */
	private function set_author_names(&$vals) {
		$author_names = array();
		if ( isset($vals['ds']) ) {
			foreach ($vals['ds'] as $d) {
				$c = $d['author_name'];

				array_push($author_names, $c);
			}
		}

		$author_names = array_unique($author_names);
        asort($author_names);
		$vals['author_names'] = $author_names;
	}			

  //======================================================
	//
	// 2. 台本一覧
	//
	//======================================================

	/**
	 * 台本一覧
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_list()
	{
		// データをセット
		$vals['ds'] = Model_Script::find(array(
			'order_by' => array(
				'id' => 'desc'
			),
			'limit' => 1000,
		));

		// 空なら空の配列をセット
		if (empty($vals['ds'])) {
			$vals['ds'] = array();
		}		

		// ジャンルをセット
		$this->set_genres($vals);
		// キャラ人数をセット
		$this->set_chara_counts($vals);
		// 時間をセット
		$this->set_mins($vals);
		// 作者名をセット
		$this->set_author_names($vals);

		$view = View::forge('template'); //テンプレートとなるビューファイルの読込み
		$view->set('content',View::forge('script/list', $vals));
		$view->set('page_title','台本一覧'); 	
		$view->set_global('site_title','声劇台本置き場'); 	
		
		return Response::forge($view);

		/*
		$this->template->page_title = '台本一覧';
        $this->template->content = View::forge('script/index'); */
	}	

	//======================================================
	//
	// ３-1. about
	//
	//======================================================

	/**
	 * aboutページ
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_about()
	{
		$vals = array();

		$view = View::forge('template'); 
		$view->set('content',View::forge('script/about', $vals));
		$view->set('page_title','このサイトについて'); 	
		$view->set_global('site_title','声劇台本置き場'); 	
		
		return Response::forge($view);
	}

  //======================================================
	//
	// ３-2. 利用規約
	//
	//======================================================

	/**
	 * 利用規約
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_guideline()
	{
		$vals = array();

        $view = View::forge('template'); 
        $view->set('content',View::forge('script/guideline', $vals));
		$view->set('page_title','利用規約'); 	
		$view->set_global('site_title','声劇台本置き場'); 	
		
		return Response::forge($view);
	}

	//======================================================
	//
	// 3-3. 台本詳細
	//
	//======================================================

	/**
	 * 台本詳細
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_detail($sid)
	{		
		// 台本データをセット
		$datas = Model_Script::find_all();		
		$vals = array();
		$this->set_target_id_script($sid, $vals);
		// キャラクターデータをセット
		$this->set_target_id_script_charactors($sid, $vals);

		// Cookieからパスワード、名前をセット
		$vals['cookie_edit_password'] 		= Cookie::get('cookie_edit_password', '');
		$vals['cookie_author_name']   		= Cookie::get('cookie_author_name', '');
		$vals['cookie_author_twitter_id']   = Cookie::get('cookie_author_twitter_id', '');

		// ジャンルをセット
		$gr = $vals['genre'];
		if ($vals['genre'] == "その他") {
			$gr = "";
		}

		// タイトルをセット
		$pageTitle = "『" . $vals['title'] . " 』(" . $vals['minutes'] . "分 " . $vals['genre'] . " " . $vals["chara_count"] . "人用" . ") - 声劇台本置き場 " ;	

		// Viewにわたす
		$this->template->page_title = $pageTitle;	
    $this->template->content = View::forge('script/detail', $vals);
	}	

	/**
	 * 該当IDの台本をセット
	 */
	private function set_target_id_script($sid, &$vals) {
		// 台本データをセット
		$datas = Model_Script::find_all();	
		$vals = array();

		foreach ($datas as $d) {
			if ($d['id'] == $sid) {
				foreach ($d as $key => $v) {
					$vals[$key] = $v;
				}

				// ツイートURLをセット
				$vals['tweet_url'] = $this->get_tweet_url($vals);

				return;
			}
		}
	}

	/**
	 * ツイート用URLを返す
	 */
	private function get_tweet_url($vals) {
		$url = "https://twitter.com/intent/tweet?url=https://";

		try {
			$url .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$url .= "&text=『" . $vals['title'] . "』%0a作者：" . $vals['author_name']	. "様";
			if ($vals['author_twitter_id'] != "") {
				$url .= "（@" . str_replace("@", "", $vals['author_twitter_id']) . "）";
			}
		} catch (Exception $e) {
			// 例外が発生した場合に実行されるコード
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		return $url;
	}

	/**
	 * 該当IDのキャラデータをセット
	 */
	private function set_target_id_script_charactors($sid, &$vals) {
		// キャラデータをセット
		$cs = array();
		$c_vals = Model_Charactor::find(array(
			'order_by' => array(
				'id' => 'asc'
			),
		));

		$i = 0;
		foreach ($c_vals as $c_val) {
			if ($c_val['script_id'] == $sid) {
				$c = array();

				foreach ($c_val as $key => $v) {
					$c[$key] = $v;
				}

				// セリフ数をセット
				$c['voice_count'] = $this->get_target_chara_voice_count($c, $vals);

				$cs[$i] = $c;
				$i++;
			}
		}

		$vals['cs'] = $cs;

		return $vals;
	}

	/**
	 * 対象キャラのセリフ数を返す
	 */
	private function get_target_chara_voice_count(&$c, $vals) {
		try {
			$txt = $vals['script_body'];

			$q = $c['name'] . "：";
			//$count = substr_count($txt, $q);
			
			// 数字をリセット
			$count = 0;

			// 改行で分割
			$lines = explode("\n", $txt);
			//return count($lines);

			for ($i = 0; $i < count($lines); $i++) {
				if ($this->check_target_line_is_new_chara_voice($lines, $i, $q)) {
					$count++;
				}
			}

			return $count;
		} catch (Exception $e) {
			// 例外が発生した場合に実行されるコード
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		return 0;
	}

	/**
	 * 対象行に該当キャラの台詞が含まれ、前の行に含まれないかを返す
	 */
	private function check_target_line_is_new_chara_voice(&$lines, $i, $q) {
		try {
			// 該当行をセット
			$line = $lines[$i];
			// 対象行に含まれなければfalse
			if (strpos($line, $q) === false) {
				return false;
			}
			// 0行目ならTrue
			if ($i === 0) {
				return true;
			}

			// 該当行の1つ前をセット
			$pline = $lines[$i - 1];
			// 対象行に含まれればfalse
			if (strpos($pline, $q) !== false) {
				return false;
			}			
		} catch (Exception $e) {
			// 例外が発生した場合に実行されるコード
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}

		return true;
	}
	
  //======================================================
	//
	// 4. 台本投稿・編集用フォーム
	//
	//======================================================

	/**
	 * 台本投稿・編集用フォーム
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_edit_form($id = null)
	{
		$vals = array();
		// 初期値をセット
		$vals['id'] = "";
		$vals['title'] = "";		
		$vals['author_name'] = "";		
		$vals['author_twitter_id'] = "";	
		$vals['genre'] = "";		
		$vals['chara_count'] = "";		
		$vals['minutes'] = "";		
		$vals['description'] = "";		
		$vals['reusable'] = "";		
		$vals['edit_password'] = "";		
		$vals['script_body'] = "";
		$vals['script_url'] = "";

		// キャラデータをセット
		$vals['cs'] = array();

		// 記事をセット
		if ( !is_null($id) ) {
			$this->set_target_id_script($id, $vals);
			// キャラデータをセット
			$this->set_target_id_script_charactors($id, $vals);			
		}

		// Cookieからパスワード、名前をセット
		$vals['cookie_edit_password'] 		= Cookie::get('cookie_edit_password', '');	
		$vals['cookie_author_name'] 		= Cookie::get('cookie_author_name', '');	
		$vals['cookie_author_twitter_id']	= Cookie::get('cookie_author_twitter_id', '');	
		
		$this->template->page_title = '台本投稿/編集';
        $this->template->content = View::forge('script/edit_form', $vals);
	}

    //======================================================
	//
	// 5. 台本投稿確認用フォーム
	//
	//======================================================

	/**
	 * 台本投稿確認用フォーム
	 */
	public function action_edit_confirm()
	{
    $vals = array();		
		// POSTから値をセット
		$vals = $this->get_script_vals_from_post($vals);
		$vals = $this->get_chara_vals_from_post($vals);
		// 性別配分
		$vals['chara_sex_summary'] = $this->get_chara_sex_summary();

		// Viewにわたす
		$this->template->page_title = '内容確認';
        $this->template->content = View::forge('script/edit_confirm', $vals);
	}

  //======================================================
	// POSTからscriptの値をセット
	//======================================================

	/**
	 * POSTからscriptの値をセット
	 */
	function get_script_vals_from_post(&$vals) {
		// ID
		$vals['id'] = Input::post('id');

		// 件名
    $vals['title'] = Input::post('title');
		// 作者
    $vals['author_name'] = Input::post('author_name');
		// TwitterID
    $vals['author_twitter_id'] = Input::post('author_twitter_id');
		// ジャンル
    $vals['genre'] = Input::post('genre');
		// キャラ数
		$vals['chara_count'] = (int)Input::post('chara_count');
		// 時間
		$vals['minutes'] = (int)Input::post('minutes');
		// 説明
    $vals['description'] = Input::post('description');
		// 二次利用
    $vals['reusable'] = Input::post('reusable');
		// パスワード
    $vals['edit_password'] = Input::post('edit_password');
		// 本文
		$vals['script_body'] = Input::post('script_body');
		// URL
		$vals['script_url'] = Input::post('script_url');

		return $vals;
	}

	//======================================================
	// POSTからcharactorsの値をセット
	//======================================================

	/**
	 * POSTからcharactorsの値をセット
	 */
	function get_chara_vals_from_post(&$vals) {
		// キャラ名、性別、説明連結用のテキストを初期化
		$chara_txts_str = "";
		// キャラ名格納用の配列を初期化
		$chara_names = [];
		$chara_sexes = [];
		$chara_descriptions = [];
		$chara_color_cords = [];

		$cs = [];

		// キャラ名、性別、説明をセット
		for ($i = 0; $i < $vals['chara_count']; $i++) {			
			$c['name'] = Input::post('chara_name_' . $i);
			$c['sex']   = Input::post('chara_sex_' . $i);
			$c['description'] = Input::post('chara_description_' . $i);
			$c['color_cord'] = Input::post('chara_color_cord_' . $i);
			// #をカット
			$c['color_cord'] = str_replace("#", "", $c['color_cord']);

			// セリフ数をセット
			$c['voice_count'] = $this->get_target_chara_voice_count($c, $vals);

			$cs[$i] = $c;
		}

		$vals['cs'] = $cs;

		return $vals;
	}

	/**
	 * 性別配分を返す
	 * 　・男1、女2、不問1
	 */
	private function get_chara_sex_summary() {		
		$m_count = 0;
		$w_count = 0;
		$n_count = 0;
		$txt = '';

		// キャラ性別をセット
		for ($i = 0; $i < (int)Input::post('chara_count'); $i++) {			
			$sex   = Input::post('chara_sex_' . $i);

			if ($sex == '男') {
				$m_count++;
			} elseif ($sex == '女') {
				$w_count++;				
			} else {
				$n_count++;
			}
		}		

		if ($m_count != 0) {
			$txt = '男' . $m_count;
		}
		if ($w_count != 0) {
			if ($txt != '') {
				$txt .= '、';
			}

			$txt = $txt . '女' . $w_count;
		}
		if ($n_count != 0) {
			if ($txt != '') {
				$txt .= '、';
			}

			$txt = $txt . '不問' . $n_count;
		}
		
		return $txt;
	}

	//======================================================
	//
	// 6. 台本保存
	//
	//======================================================

	/**
	 * 台本保存
	 */
	public function action_save()
	{
		$is_for_insert = True;

		// POSTから値をセット
        $vals = array();				
		$vals = $this->get_script_vals_from_post($vals);

		// インサート時はIDを削除
		if (empty($vals['id'])) {
			unset($vals['id']);
		// 更新時
		} else {
			$result = DB::delete('charactors')->where('script_id', $vals['id'])->execute();	
			$result = DB::delete('scripts')->where('id', $vals['id'])->execute();	
		}

		// 現在日時をセット
		$vals['update_date'] = date("Y/m/d H:i:s");
		// 性別の概要をセット
		$vals['chara_sex_summary'] = $this->get_chara_sex_summary($vals);

		// Cookieにパスワード、名前などをセット
		Cookie::set('cookie_edit_password', $vals['edit_password'], 60 * 60 * 24 * 1000);		
		Cookie::set('cookie_author_name', $vals['author_name'], 60 * 60 * 24 * 1000);	
		Cookie::set('cookie_author_twitter_id', $vals['author_twitter_id'], 60 * 60 * 24 * 1000);	

		$d = Model_Script::forge();

		$d->set($vals);

		$n = $vals['chara_count'];

		// 保存
		$d->save();
		$id = $d->id; 	

		$msg = "台本「" . $vals['title'] ."」が投稿されました。";

		for ($i = 0; $i < $n; $i++) {
			// CharactorCRUDモデル生成			
			$d = Model_Charactor::forge();		
			$vals = array();

			$vals['name'] = Input::post('chara_name_' . $i);
			$vals['sex'] = Input::post('chara_sex_' . $i);
			$vals['description'] = Input::post('chara_description_' . $i);			
			$vals['color_cord'] = Input::post('chara_color_cord_' . $i);
			$vals['script_id'] = $id;

			$d->set($vals);

			// insert 文を準備します
			$query = DB::insert('charactors');			

			// 保存
			$d->save();			
		}			

		$vals['msg'] = $msg;

		
		// データをセット
		$vals['ds'] = Model_Script::find(array(
			'order_by' => array(
				'id' => 'desc'
			),
			'limit' => 50,
		));

		// 空なら空の配列をセット
		if (empty($vals['ds'])) {
			$vals['ds'] = array();
		}		

		// ジャンルをセット
		$this->set_genres($vals);
		// キャラ人数をセット
		$this->set_chara_counts($vals);
		// 時間をセット
		$this->set_mins($vals);
		// 作者名をセット
		$this->set_author_names($vals);

        $view = View::forge('template'); //テンプレートとなるビューファイルの読込み
        $view->set('content',View::forge('script/list', $vals));
		$view->set('page_title','台本一覧'); 	
		$view->set_global('site_title','声劇台本置き場'); 	
		
		return Response::forge($view);
		
		/*
		//Response::redirect('script/detail/' . $id);
		
		// 台本データをセット
		$datas = Model_Script::find_all();		
		$vals = array();

		$vals['msg'] = "台本が投稿されました。";

		$this->set_target_id_script($id, $vals);
		// キャラクターデータをセット
		$this->set_target_id_script_charactors($id, $vals);

		// Cookieからパスワード、名前をセット
		$vals['cookie_edit_password'] 		= Cookie::get('cookie_edit_password', '');
		$vals['cookie_author_name']   		= Cookie::get('cookie_author_name', '');
		$vals['cookie_author_twitter_id']   = Cookie::get('cookie_author_twitter_id', '');

		// Viewにわたす
		$this->template->page_title = $vals['title'];
        $this->template->content = View::forge('script/detail', $vals);*/
	}

	//======================================================
	//
	// 7. 台本削除
	//
	//======================================================

	/**
	 * 台本削除
	 */
	public function action_delete()
	{
		$msg = "";

		$id = Input::post('id');

		// 削除
		if ( !empty($id) ) {
			$result = DB::delete('charactors')->where('script_id', $id)->execute();	
			$result = DB::delete('scripts')->where('id', $id)->execute();	

			$msg = "1件の台本が削除されました。";
		}

		$vals['msg'] = $msg;

		// データをセット
		$vals['ds'] = Model_Script::find(array(
			'order_by' => array(
				'id' => 'desc'
			),
			'limit' => 50,
		));

		// 空なら空の配列をセット
		if (empty($vals['ds'])) {
			$vals['ds'] = array();
		}		

		// ジャンルをセット
		$this->set_genres($vals);
		// キャラ人数をセット
		$this->set_chara_counts($vals);
		// 時間をセット
		$this->set_mins($vals);
		// 作者名をセット
		$this->set_author_names($vals);

        $view = View::forge('template'); //テンプレートとなるビューファイルの読込み
        $view->set('content',View::forge('script/list', $vals));
		$view->set('page_title','台本一覧'); 	
		$view->set_global('site_title','声劇台本置き場'); 	
		
		return Response::forge($view);
	}

	//======================================================
	//
	// 10. 404
	//
	//======================================================

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('welcome/404'), 404);
	}
}
