
<!-- メッセージ -->
<?php if(isset($msg)) { ?>
<div class="alert alert-primary alert-dismissible fade show msg_area" role="alert">
	<?php echo $msg ?>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php } ?>

<h2 class = "green">台本一覧&nbsp;<small id="scriptCount"><?php echo count($ds) ?>件</small></h2>

<!-- 絞り込み用 -->
<div class = "search_cb_area col-12 pull-right">
	<div class = "row justify-content-end">
		<div class = "col-12 text-right cb_right_area">
			<p>
  				<input id = "searchBox" type="text" size="30" placeholder="キーワード検索">
			</p>	         
			<p>
				ジャンルで絞り込み：
				<select id = "filter_genre_cb" class = "filter">
					<option value = ""></option>
					<?php for ($i = 0; $i < count($genres) ; $i++ ) { 
						$g = $genres[$i];                           
						?>
						<option value = "<?php echo $g ?>" class = "genre_<?php echo $i; ?>"><?php echo $g ?></option>
					<?php } ?>
				</select>
			</p>
			<p>
				人数で絞り込み：
				<select id = "filter_chara_count_cb" class = "filter">
					<option value = ""></option>                        
					<?php foreach ($chara_counts as $c) { ?>
						<option value = "<?php echo $c ?>人"><?php echo $c ?>人</option>
					<?php } ?>
				</select>
			</p>      
			<p>
				作者で絞り込み：
				<select id = "filter_author_name_cb" class = "filter">
					<option value = ""></option>                        
					<?php foreach ($author_names as $a) { ?>
						<option value = "<?php echo $a ?>"><?php echo $a ?></option>
					<?php } ?>
				</select>
			</p>                
		</div>
	</div>
</div>

<!-- 一覧描画用テーブル。PC用 -->
<div class="d-none d-md-block">
	<table class = "list col-12 hover" id = "new_script_table">
		<thead>
			<tr>
				<th class = "h_txt" style = "width: 30%">タイトル</th>
				<th class = "h_txt" style = "width: 12%">ジャンル</th>
				<th class = "h_txt" style = "width: 12%">人数</th>
				<th class = "h_txt" style = "width: 12%">男女比</th>            
				<th class = "h_txt" style = "width: 12%">時間</th>
				<th class = "h_txt" style = "width: 12%">作者</th>
				<th class = "h_txt" style = "width: 10%">更新日</th>
			</tr>
		</thad>

		<tbody>
			<?php foreach ($ds as $d) { ?>
			<tr class = "link" name = "<?php echo $d['id'] ?>" href = "<?php if ($d['script_url'] != "") { 
					echo $d['script_url'];
				} else { 
					echo Uri::create('script/detail/') . $d['id']; 
				} ?>">

				<td class = "title">
					<?php echo $d['title'] ?>
				</td>
				<td class = "genre">
					<span class = "genre"><?php echo $d['genre'] ?></span>
				</td>
				<td class = "chara_count">
					<?php echo $d['chara_count'] ?>人
				</td>
				<td class = "chara_sex_summary">
					<?php echo str_replace(" ", "：", $d['chara_sex_summary']) ?>
				</td>
				<td class = "minutes">
					<?php echo $d['minutes'] ?>分                   
				</td>
				<td class = "author_name">
					<?php echo $d['author_name'] ?>                 
				</td>
				<td class = "update_date">
					<?php echo  substr(str_replace('-', '/', substr($d['update_date'], 0, 10)), 5) ?>                 
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<!-- 一覧描画用テーブル。モバイル用 -->    
<div class="d-block d-md-none">
	<table class = "list col-12 hover mobile">
		<thead>
			<tr>
				<th class = "h_txt" style = "width: 30%">タイトル</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($ds as $d) { ?>
			<tr class = "link" name = "<?php echo $d['id'] ?>" search_txt = "<?php echo $d['title'] ?><?php echo $d['genre'] ?><?php echo $d['author_name'] ?><?php echo $d['chara_count'] ?>人" href = "<?php if ($d['script_url'] != "") { 
					echo $d['script_url'];
				} else { 
					echo Uri::create('script/detail/') . $d['id']; 
				} ?>">
				<td class = "mobile_td">
					<div class = "row">				
						<div class = "title col-9">
							<?php echo $d['title'] ?>
						</div>
						<div class = "col-3 genre">
							<span class = "genre chara_0"><?php echo $d['genre'] ?></span>
						</div>
					</div>
					<div class = "row bottom_info_area">											
						<span class = "minutes "><?php echo $d['minutes'] ?>分 </span>　                 
						<span class = "chara_count"><?php echo $d['chara_count'] ?>人（<?php echo str_replace(" ", "、", $d['chara_sex_summary']) ?>）</span>
						<span class = "author_name col-4">by <?php echo $d['author_name'] ?></span>
					</div>
				</td>
			</tr>	
		<?php } ?>	
		</tbody>            
	</table>
</div>    
