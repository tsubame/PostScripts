<!DOCTYPE html>
<html>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $page_title; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:title" content="<?php echo $page_title; ?>">
	<meta property="og:site_name" content="" />    
	<meta property="og:image" content="https://taltal3014.lsv.jp/fuelphp/public/assets/img/fox_mini.png">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:image" content="https://taltal3014.lsv.jp/fuelphp/public/assets/img/fox_mini.png">    

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
	<?php echo Asset::js('jquery.tablesorter.min.js'); ?>
	<?php echo Asset::js('jquery.mousewheel.js'); ?>
  <?php echo Asset::css('style.css'); ?>
</head>
<body>
	<header>
		<div class = "container">			
			
			<div class = "row">
				<!-- PC -->
				<div class = "col-1" id = "logo_img">			
				<a href = "<?php echo Uri::create('script/'); ?>">	
					<?php echo Asset::img('fox.png', array('width'=>'50')); ?>
				</a>
				</div>
				<div class = "col-9" id = "logo_text">
					<a href = "<?php echo Uri::create('script/'); ?>">						
					<h1>声劇台本置き場</h1>
					</a>
				</div>
			</div> 
		</div>			
	</header>

	<!-- ナビゲーションバーPC用 -->
	<nav id = "global_navi_pc" class = "navbar-expand-lg navbar-dark bg-dark d-none d-md-block">
		<div class = "container">				
			<a class = "nav_link mr-auto <?php if(substr($_SERVER['REQUEST_URI'], -1) == "/") { echo "active"; } ?>" href = "<?php echo Uri::create('script/'); ?>">TOP</a>　　
			<a class = "nav_link mr-auto <?php if(strpos($_SERVER['REQUEST_URI'], 'script/list')) { echo "active"; } ?>" href = "<?php echo Uri::create('script/list'); ?>">台本一覧</a>　　
			<a class = "nav_link mr-auto <?php if(strpos($_SERVER['REQUEST_URI'], 'script/edit_form')) { echo "active"; } ?>" href = "<?php echo Uri::create('script/edit_form'); ?>">台本投稿</a>　　
			<a class = "nav_link mr-auto <?php if(strpos($_SERVER['REQUEST_URI'], 'script/about')) { echo "active"; } ?>" href = "<?php echo Uri::create('script/about'); ?>">About</a>　　
			<a class = "nav_link mr-auto <?php if(strpos($_SERVER['REQUEST_URI'], 'script/guideline')) { echo "active"; } ?>" href = "<?php echo Uri::create('script/guideline'); ?>">利用規約</a>
        </div>
	</nav>
	<!-- ナビゲーションバーモバイル用 -->
	<nav id = "global_navi_mobile" class = "navbar-expand-lg navbar-dark bg-dark d-block d-md-none">
		<div class = "container">				
			<a class = "nav_link mr-auto <?php if(substr($_SERVER['REQUEST_URI'], -1) == "/") { echo "active"; } ?>" href = "<?php echo Uri::create('script/'); ?>">TOP</a>　
			<a class = "nav_link mr-auto <?php if(strpos($_SERVER['REQUEST_URI'], 'script/list')) { echo "active"; } ?>" href = "<?php echo Uri::create('script/list'); ?>">台本一覧</a>　
			<a class = "nav_link mr-auto <?php if(strpos($_SERVER['REQUEST_URI'], 'script/edit_form')) { echo "active"; } ?>" href = "<?php echo Uri::create('script/edit_form'); ?>">台本投稿</a>　
			<a class = "nav_link mr-auto <?php if(strpos($_SERVER['REQUEST_URI'], 'script/about')) { echo "active"; } ?>" href = "<?php echo Uri::create('script/about'); ?>">About</a>　
			<a class = "nav_link mr-auto <?php if(strpos($_SERVER['REQUEST_URI'], 'script/guideline')) { echo "active"; } ?>" href = "<?php echo Uri::create('script/guideline'); ?>">利用規約</a>
        </div>
	</nav>	

	<!-- メイン領域 -->
	<div id = "main">
		<div class = "container">	
			<?php echo $content; ?>
		</div>
	</div>

	<footer>
		<div id = "chara_explain" class = "d-none">
		</div>		

		<div id = "script_write_area" class = "d-none">
		</div>		
	</footer>
	<?php echo Asset::js('common.js'); ?>
</body>
</html>
