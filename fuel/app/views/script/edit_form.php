

<!-- 見出し -->
<div class = "row"> 
	<h2 class = "blue">概要　　<small>台本の概要を記入してください。</small></h2>
</div>

<form action = "<?php echo Uri::create('script/edit_confirm'); ?>" method = "post" id = "script_edit_form">
	<!-- 説明描画用テーブル -->
	<table id="desc_edit" class = "col-12">
		<tr>
			<th class = "h_txt" style="width: 20%">タイトル</th>
			<td>
				<input type = "text" id = "title_txt_box" name = "title" value = "<?php echo $title; ?>" placeholder="例：星の王子さま" />						
			</td>
		</tr>		
		<tr>
			<th class = "h_txt">ジャンル</th>
			<td>
				<select name = "genre" href = "<?php echo $genre ?>">
					<option>ラブストーリー</option>
					<option>コメディ</option>
					<option>ファンタジー</option>
					<option>ホラー</option>
					<option>ミステリー</option>
					<option>時代劇</option>	
					<option>童話</option>							
					<option>その他</option>
				</select>						
			</td>					
		</tr>
		<tr>
			<th class = "h_txt">時間</th>
			<td>
				<select name = "minutes" id = "minutes_cb" href = "<?php echo $minutes ?>">
					<option value = "10">10</option>
					<option value = "20">20</option>
					<option value = "30">30</option>
					<option value = "40">40</option>
					<option value = "50">50</option>
					<option value = "60">60</option>
					<option value = "70">70</option>
					<option value = "80">80</option>
					<option value = "90">90</option>																									
				</select>		
				分					
			</td>					
		</tr>
		<tr>
			<th class = "h_txt">人数</th>
			<td>
				<select name = "chara_count" id = "chara_count_cb" href = "<?php echo $chara_count ?>">
					<option value = "1">1</option>
					<option value = "2">2</option>
					<option value = "3">3</option>
					<option value = "4">4</option>
					<option value = "5">5</option>
					<option value = "6">6</option>
					<option value = "7">7</option>
					<option value = "8">8</option>
					<option value = "9">9</option>					
				</select>	
				人							
			</td>					
		</tr>		
		<tr>
			<th class = "h_txt">台本使用規定</th>
			<td>
				<select name = "reusable" href = "<?php echo $reusable ?>">
					<!--<option>可（ご自由にお使いください）</option>
					<option>不可</option>-->              
                    <option>非商用利用時は連絡不要</option>
                    <option>商用、非商用問わず作者へ連絡要</option>
                    <option>台本説明欄参照</option>
				</select>							
			</td>
		</tr>						
		<tr>
			<th class = "h_txt">説明</th>
			<td>
				<textarea id = "desc_tb" rows = "8" name = "description" placeholder = "台本の概要説明を記入してください。"><?php echo $description; ?></textarea>
			</td>					
		</tr>
		<!-- 投稿形式 -->
		<tr>
			<th class = "h_txt">投稿形式</th>
			<td class = "script_format">
				<select name = "post_format" id = "post_format_cb">
					<option value = "text">テキストファイル</option>
					<!--<option value = "url" <?php if( $script_url != "") { echo "selected"; } ?>>URL</option>		-->																					
				</select>
				<!--<p class = "explain"><small>※テキストファイルを投稿したい場合はテキストファイル、外部サイトに台本を公開中の場合はURLを選択</small></p>-->	
			</td>
		</tr>		
		<!--
		<tr id = "script_url_row" class = "d-none">
			<th class = "h_txt">台本URL<br />
			</th>
			<td>
				<input type = "text" id = "url_txt_box" name = "script_url" value = "<?php echo $script_url ?>" placeholder="外部サイトのURLを記入" />
			</td>					
		</tr>-->
		<tr id = "script_file_row">
			<th class = "h_txt">台本ファイル</th>
			<td class = "script_file">
				<input type = "file" id = "file_select_btn" name = "text_file_path" accept="text/plain" />
				<p class = "explain"><small>※ボイコネフォーマットのテキストファイルを投稿できます。</small></p>
				<!-- テキストデータセット用 -->
				<textarea id = "script_body_tb" name = "script_body" rows="8" class = "d-none"></textarea>
			</td>					
		</tr>		
	</table>
	<!-- 削除ボタン -->
	<div id = "edit_button_area" class = "delete_button_area text-right">　
		<?php if (!empty($id)) { ?>
		<button type="button" id = "delete_button" class = "btn btn-danger">台本を削除</button>			
		<?php } ?>
	</div>
	
	<!-- 見出し -->
	<div class = "row"> 
		<h2 class = "blue">キャラ説明　　<small>キャラの説明を記入してください。</small></h2>
	</div>

	<!-- キャラ説明テーブル -->
	<table id="chara_edit" class = "col-12 list">
		<tr>
			<th class = "h_txt">キャラ名</th>
			<th class = "h_txt">性別</th>					
			<th class = "h_txt">説明</th>	
			<th class = "h_txt">色分け</th>	
		</tr>				
		<!-- ループ -->
		<?php for($i = 0; $i < 10; $i++) { 
			// キャラデータをセット
			if ($i < $chara_count) {
				$c = $cs[$i];
			} else {
				$c = null;
			}
		?>
		<tr id = "chara_row_<?php echo $i; ?>">
			<td class = "title">
				<input type = "text" name = "chara_name_<?php echo $i; ?>" class = "chara_name_tb" value = "<?php if (!is_null($c)) { echo $c['name']; } ?>" placeholder="例：田中"/>
			</td>
			<td class = "sex">
				<select name = "chara_sex_<?php echo $i; ?>" href = "<?php if (!is_null($c)) { echo $c['sex']; } ?>">
					<option value = "男">男</option>
					<option value = "女">女</option>
					<option value = "不問">不問</option>
				</select>
			</td>					
			<td class = "description">
				<textarea id = "desc_tb" name = "chara_description_<?php echo $i; ?>" placeholder = "キャラの説明を記入"><?php if (!is_null($c)) { echo $c['description']; } ?></textarea>			
			</td>
			<td class = "color_cord">
				<input type = "color" name = "chara_color_cord_<?php echo $i; ?>" id = "chara_color_cord_<?php echo $i; ?>" value = "<?php if (!is_null($c)) { echo "#" . $c['color_cord']; } ?>"  class = "color_cb" list = "color_list">
			</td>			
		</tr>
		<?php } ?>
		<!-- ループここまで -->
	</table>		

	<!-- 色要素 -->
	<datalist id = "color_list">
		<option id = "color_option_0" class = "chara_0 color_option" value = "#FFFFFF"></option>
		<option id = "color_option_1" class = "chara_1 color_option" value = "#FFFFFF"></option>
		<option id = "color_option_2" class = "chara_2 color_option" value = "#FFFFFF"></option>
		<option id = "color_option_3" class = "chara_3 color_option" value = "#FFFFFF"></option>
		<option id = "color_option_4" class = "chara_4 color_option" value = "#FFFFFF"></option>
		<option id = "color_option_5" class = "chara_5 color_option" value = "#FFFFFF"></option>		
		<option id = "color_option_6" class = "chara_6 color_option" value = "#FFFFFF"></option>	
		<option id = "color_option_7" class = "chara_7 color_option" value = "#FFFFFF"></option>	
		<option id = "color_option_8" class = "chara_8 color_option" value = "#FFFFFF"></option>	
	</datalist>

	<!-- 見出し -->
	<div class = "row"> 
		<h2 class = "blue">作者情報</h2>
	</div>
	<!-- 説明描画用テーブル -->
	<table id="desc_edit" class = "col-12">
		<tr>
			<th class = "h_txt" style="width: 20%">作者名</th>
			<td>
				<input type = "text" id = "author_txt_box" name = "author_name" value = "<?php echo $cookie_author_name ?>" placeholder="例：田中" autocomplete='username' />								
			</td>					
		</tr>				
		<tr>
			<th class = "h_txt">TwitterID<br /><small>※空欄でも可</small>	</th>
			<td>
				<input type = "text" name = "author_twitter_id" value = "<?php echo $cookie_author_twitter_id ?>" placeholder="例：abcd" />								
			</td>					
		</tr>						
		<tr>
			<th class = "h_txt">台本編集用パスワード<br />			
			</th>
			<td>
				<input type = "password" id = "edit_pass_tb" name = "edit_password" placeholder = "" value = "<?php echo $cookie_edit_password ?>" style = ”ime-mode:disabled;” autocomplete="new-password" />								
				<small>※台本の編集時に必要になります。</small>	
			</td>								
		</tr>					
	</table>	

	<!-- ボタン -->
	<div id = "bottom_bottun_area">
		<div class = "row">
			<div class = "col-12 text-center">
				<input type = "button" id = "dummy_submit_confirm_button" class="btn btn-outline-secondary" value = "内容を確認"></input>
				<input type = "submit" id = "hidden_submit_button" class="d-none" value = "ダミー用ボタン"></input>
				<!-- hidden要素。ID -->
				<input type = "hidden" name = "id" value = "<?php echo $id ?>"/>
			</div>
		</div>
	</div>
</form>

<!-- 削除用フォーム -->
<form action = "<?php echo Uri::create('script/delete'); ?>" method = "post" id = "script_delete_form">
	<!-- 隠し要素の削除ボタン -->	
	<input type = "submit" id = "hidden_delete_submit_button" class = "d-none" />
	<!-- hidden要素。ID -->
	<input type = "hidden" name = "id" value = "<?php echo $id ?>"/>
</form>
