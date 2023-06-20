
<!-- フォーム -->
<form action = "<?php echo Uri::create('script/save'); ?>" method = "post">

	<!-- 見出し -->
	<div class = "row"> 
		<h2 class = "blue">投稿内容の確認　<small class = "text-danger">※内容を確認し、問題がなければ投稿ボタンを押して下さい。</small></h2>
	</div>

	<!-- 説明描画用テーブル -->
	<table id="desc_edit" class = "col-12">
		<tr>
			<th class = "h_txt" style="width: 20%">タイトル</th>
			<td>
				<?php echo $title; ?>				
			</td>
		</tr>
		<tr>
			<th class = "h_txt">作者名</th>
			<td>
				<?php echo $author_name; 
				if ( !empty($author_twitter_id)) {
					echo '　(<a href = "#">@' . str_replace("@", "", $author_twitter_id) . '</a>)';
				}
				?>			
			</td>					
		</tr>				
		<tr>
			<th class = "h_txt">ジャンル</th>
			<td>					
				<?php echo $genre; ?>					
			</td>					
		</tr>
		<tr>
			<th class = "h_txt">人数</th>
			<td>
				<?php echo $chara_count; ?>人（<?php echo $chara_sex_summary ?>）	
			</td>					
		</tr>
		<tr>
			<th class = "h_txt">時間</th>
			<td>
				<?php echo $minutes; ?>	
				分					
			</td>					
		</tr>
		<tr>
			<th class = "h_txt">台本使用規定</th>
			<td>
				<?php echo $reusable; ?>								
			</td>
		</tr>						
		<tr>
			<th class = "h_txt">説明</th>
			<td class = "description"><?php echo nl2br($description); ?></td>					
		</tr>
		<?php if ( !empty($script_url) ) { ?>
			<tr>
			<th class = "h_txt">URL</th>
			<td>
				<?php echo $script_url; ?>					
			</td>					
		</tr>
		<?php } ?>
	</table>

	<!-- ボタン領域 -->
	<div id = "bottom_bottun_area">
		<div class = "row">					
			<!-- 戻るボタン -->
			<div class = "col-4">
				<button type="button" class = "btn btn-outline-secondary" onclick="history.back()">戻る</button>			
			</div>
			<div class = "col-4 text-center">
				<button type="button" id = "dummy_submit_button" class="btn btn-success">投稿</button>
				<!-- hidden要素。非表示Submitボタン -->
				<input type = "submit" id = "hidden_submit_button" class = "d-none" />

				<!-- hidden要素 -->
				<input type = "hidden" name = "id" value = "<?php echo $id; ?>" />
				<input type = "hidden" name = "title" value = "<?php echo $title; ?>" />
				<input type = "hidden" name = "author_name" value = "<?php echo $author_name; ?>" />
				<input type = "hidden" name = "author_twitter_id" value = "<?php echo $author_twitter_id; ?>" />
				<input type = "hidden" name = "chara_count" value = "<?php echo $chara_count; ?>" />
				<input type = "hidden" name = "genre" value = "<?php echo $genre; ?>" />	
				<input type = "hidden" name = "minutes" value = "<?php echo $minutes; ?>" />
				<input type = "hidden" name = "description" value = "<?php echo $description; ?>" />												
				<input type = "hidden" name = "reusable" value = "<?php echo $reusable; ?>" />			
				<input type = "hidden" name = "edit_password" value = "<?php echo $edit_password; ?>" />			
				<input type = "hidden" name = "script_body" value = "<?php echo $script_body; ?>" />				
				<input type = "hidden" name = "script_url" value = "<?php echo $script_url; ?>" />	
			</div>
			<div class = "col-4">
			</div>
		</div>
	</div>

	<!-- 見出し -->
	<div class = "row"> 
		<h2 class = "blue">キャラ説明　　<small></small></h2>
	</div>

	<!-- キャラ説明描画用テーブル -->
	<table id="chara" class = "col-12 list">
		<tr>
			<th class = "h_txt" style = ""></th>
			<th class = "h_txt" style = "">キャラクター名</th>
			<th class = "h_txt" style = "">性別</th>					
			<!-- 台詞数 -->			
			<th class = "h_txt">台詞数</th>				
			<th class = "h_txt" style = "">説明</th>	
		</tr>		

		<!-- ループ -->
		<?php for ($i = 0; $i < $chara_count; $i++) { 
			$c = $cs[$i];
		?>
		
		<tr>
			<td class = "check_mark">
			</td>
			<td class = "name">
				<span class = "<?php echo $c['color_cord'] ?>" style = "background:#<?php echo $c['color_cord'] ?>"><?php echo $c['name'] ?></span>
				<input type = "hidden" name = "chara_name_<?php echo $i ?>" value = "<?php echo $c['name'] ?>">
				<input type = "hidden" name = "chara_color_cord_<?php echo $i ?>" value = "<?php echo $c['color_cord'] ?>">
			</td>
			<td>
				<?php echo $c['sex'] ?>
				<?php if ($c['sex'] == "男") { 
						echo Asset::img('man.png', array('width'=>'8')); 
					} elseif ($c['sex'] == "女") { 
						echo Asset::img('woman.png', array('width'=>'8')); 
					} ?>				
				<input type = "hidden" name = "chara_sex_<?php echo $i ?>" value = "<?php echo $c['sex'] ?>">							
			</td>					
			<!-- 台詞数 -->
			<td class = "voice_count">
				<?php if ($c['voice_count'] == 0) { 
							echo "-"; 
						} else { 
							echo $c['voice_count']; 
						} ?>
			</td>						
			<td class = "text-left description">
				<?php echo $c['description'] ?>
				<input type = "hidden" name = "chara_description_<?php echo $i ?>" value = "<?php echo $c['description'] ?>">
			</td>		
		</tr>
		<?php } ?>
	</table>		

	<!-- URLがなければ本編を表示 -->
	<?php if ( empty($script_url)) { ?>
	<!-- 見出し -->
	<div class = "row"> 
		<h2 class = "blue">台本本編プレビュー</h2>
	</div>

	<!-- 縦書き台本 -->
	<div id = "vertical_modal_container" class = "d-none">
		<div id = "vertical_modal_body">
			<div id = "vertical_button_area" class = "clearfix">	
				<div class = "float-right">		
					<input type = "button" id = "close_vertical_button" class = "btn btn-outline-secondary" value = "× 縦書き画面を閉じる"></input>		
				</div>
			</div>	
			<div id = "vertical_script_area" class = "">
				<?php echo $script_body; ?>		
			</div>
		</div>	
	</div>

	<!-- 横書き台本 -->
	<div id = "horizon">	
		<!-- 縦書きに切り替えボタン -->
		<div id = "show_by_vertical_button_area" class = "clearfix">
			<div class = "float-right">		
				<input type = "button" id = "show_by_vertical_button" class = "btn btn-outline-secondary" value = "縦書きで表示"></input>		
			</div>
		</div>	

		<!-- セリフプレーンテキスト描画欄（非表示）-->
		<div id = "script_write_area" class = "d-none">
			<?php echo $script_body; ?>
		</div>
		<!-- セリフ描画欄（テーブル）-->
		<div id = "script_show_area">
		</div>		
	</div>	

	<!-- 台本プレビュー用テーブル -->
	<!--
	<table id="script_preview" class = "col-12 list">
		<tr>
			<th class = "h_txt" style = "width:2%"></th>
			<th class = "h_txt" style = "width: 20%">キャラクター名</th>				
			<th class = "h_txt" style = "width: 78%">セリフ</th>	
		</tr>			
		<tr>
			<td class = "check_mark">
			</td>
			<td>
			</td>
			<td>
			</td>					
		</tr>	
	</table>-->	

	<?php } ?>
</form>	
