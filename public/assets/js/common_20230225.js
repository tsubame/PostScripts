$(function() {

	// セリフをテーブル形式で描画
	show_txt_by_table();
	// 入力フォームに色を追加
	draw_color_cord_to_option();
	// オプション要素の初期値選択
	select_option_init_val();
	// キャラ人数に合わせてキャラ説明テーブルの行の表示切り替え
	switch_chara_table_rows_hidden();
	// ジャンルタグに色付け
	paint_color_to_genres(); 
	// セリフを縦書きで描画
	show_txt_by_vertical();
    // キャラテーブルを全員分表示
    //switch_chara_table_rows_hidden();
	// テーブルソーター要素
	$(".list").tablesorter();

	/*======================================================
	/*
	/* 1-1. 台本一覧ページ　イベント テーブルの行クリック
	/*
	/*======================================================*/

	/**
	 * イベント テーブルの行クリック
	 */
	 $("table.list tr.link").click(function() {
		$url = $(this).attr("href");
		if ($url == "") {
			return;
		}

		window.location.href = $url;
	});

	/*======================================================
	/*
	/* 1-2. 台本一覧ページ　ジャンルに色付け
	/*
	/*======================================================*/

	/**
	 * 台本一覧ページ　ジャンルに色付け
	 */
	function paint_color_to_genres() {
		console.log("test");

		//ジャンルタグを走査
		$("span.genre").each(function(i){
			// ジャンルの値をセット
			var g = $(this).text();
			console.log(g);
			// 該当ジャンルのクラスをセット			
			var cl = get_genre_class(g);
			//console.log(cl);
			$(this).addClass(cl);
		});			
	}

	/**
	 * 該当ジャンルのclassタグを返す
	 * 　・Optioonタグで一致するもののクラスを返す
	 */
	function get_genre_class(g) {
		var rcl = "";
		// Optionタグを走査
		$("#filter_genre_cb").find("option").each(function(i){
			var cl = $(this).attr("class");
			var val = $(this).val();

			if (val == g) {
				rcl = cl;

				return;
			}
		});		
		
		return rcl;
	}


	/*======================================================
	/*
	/* 1-3. 台本一覧ページ　イベント 絞り込み用コンボボックス変更
	/*
	/*======================================================*/

	/**
	 * 台本一覧ページ　イベント 絞り込み用コンボボックス変更
	 */
	$(".filter").change(function() {
		// リスト内の行を走査。一度全て表示
		$(".list tbody tr").each(function(i){
			$(this).show();
		});	

		// ジャンルで絞り込み
		filter_by_genre();
		// 人数で絞り込み
		filter_by_chara_count();
		// 作者で絞り込み
		filter_by_author_name();
	});

    //======================================================
	// ジャンルで絞り込み
	//======================================================
	
	/**
	 * ジャンルで絞り込み
	 */
	function filter_by_genre() {
		var t_genre = $("#filter_genre_cb").val();

		// リスト内の行を走査
		$(".list tbody tr").each(function(i){
			var txt = $(this).text();

			//if (row_genre == t_genre || t_genre == "") {
			if ((txt.indexOf(t_genre) !== -1) || t_genre == "") {

			} else {
				$(this).hide();
			}
		});	
	}

	//======================================================
	// 人数で絞り込み
	//======================================================
	
	/**
	 * 人数で絞り込み
	 */
	 function filter_by_chara_count() {
		var t_count = $("#filter_chara_count_cb").val();

		// リスト内の行を走査
		$(".list tbody tr").each(function(i){
			var txt = $(this).text();			

			if ((txt.indexOf(t_count) !== -1) || t_count == "") {				

			} else {
				$(this).hide();
			}
		});	
	}

	//======================================================
	// 作者で絞り込み
	//======================================================
	
	/**
	 * 作者で絞り込み
	 */
	 function filter_by_author_name() {
		var t_author = $("#filter_author_name_cb").val();
		console.log(t_author);
		// リスト内の行を走査
		$(".list tbody tr").each(function(i){
			var txt = $(this).text();			

			if ((txt.indexOf(t_author) !== -1) || t_author == "") {				

			} else {
				$(this).hide();
			}
		});	
	}	

	/*======================================================
	/*
	/* 1-4. 台本一覧ページ　イベント 検索ボックスの値変更
	/*
	/*======================================================*/

	/**
	 * 台本一覧ページ　イベント 検索ボックスの値変更

	$("#searchBox").change(function() {
		var q = $("#searchBox").val();
		console.log(q);
		// リスト内の行を走査
		$(".list tbody tr").each(function(i){
			var txt = $(this).text();			

			if ((txt.indexOf(q) !== -1) || t_author == "") {				

			} else {
				$(this).hide();
			}
		});	
	}*/

	/*======================================================
	/*
	/* 2-1. 台本編集用ページ 入力フォームにカラーコードを描画
	/*
	/*======================================================*/

	/**
	 * 入力フォームにカラーコードを描画
	 */
	function draw_color_cord_to_option() {
		var i = 0
		$(".color_option").each(function(index) {
			var tag = $("#color_option_" + i)
			var color = tag.css('background-color');
			//console.log(color);

			if (color !== undefined) {
				color = rgbTo16(color);
				tag.val(color);

				var cb = $("#chara_color_cord_" + i);
				cb.val(color);
			}		
			
			i = i + 1;			
		});
	}

	//======================================================
	// カラーコード変換
	//======================================================

	/**
	 * カラーコード変換
	 */
	function rgbTo16(col){
		return "#" + col.match(/\d+/g).map(function(a){return ("0" + parseInt(a).toString(16)).slice(-2)}).join("");
	}

	/*======================================================
	/*
	/* 2-2. 台本編集用ページ　イベント キャラ人数コンボボックス変更 
	/*
	/*======================================================/

	/**
	 * イベント キャラ人数コンボボックス変更
	 * 　・人数に合わせてキャラ説明テーブルの行の表示切り替え
	 */
	$("#chara_count_cb").change(function() {
		switch_chara_table_rows_hidden();
	});

	//======================================================
	// 人数に合わせてキャラ説明テーブルの行の表示切り替え
	//======================================================

	/**
	 * 人数に合わせてキャラ説明テーブルの行の表示切り替え
	 */
	function switch_chara_table_rows_hidden() {
		var ROW_ID_PREFIX = "#chara_row_"

		// コンボボックスから値をセット
		var n = $("#chara_count_cb").val()

        console.log(n);

		// 行を一度すべて非表示
		for (i = 0; i < 10; i++) {
			var tr = $(ROW_ID_PREFIX + i)
			tr.hide()

			// キャラ名を入力不要に
			var tb = tr.find(".chara_name_tb")
			tb.attr('required', false);		
		} 

		// 特定の行を表示
		for (i = 0; i < n; i++) {
			var tr = $(ROW_ID_PREFIX + i)
			tr.removeClass("d-none")
			tr.show()

			// キャラ名を入力必須に
			var tb = tr.find(".chara_name_tb")
			tb.attr('required', true);		
		} 
	}


	/*======================================================
	/*
	/* 2-3. 台本編集用ページ　イベント ファイル選択ボタンクリック 
	/*
	/*======================================================/

	/**
	 * テキストファイルの内容をDOMにセット
	 */
	$("#file_select_btn").change(function(evt) {
		set_txt_file_content_to_dom()
	});

	//======================================================
	// テキストファイルの内容をDOMにセット
	//======================================================

	/**
	 * テキストファイルの内容をDOMにセット
	 */
	function set_txt_file_content_to_dom() {
		var file = $('#file_select_btn').prop('files')[0]; 

		// FileReaderの作成
		var reader = new FileReader();
		// テキスト形式で読み込む
		reader.readAsText(file);
		
		// 読込終了後の処理
		reader.onload = function(ev){
			//テキストエリアに表示する
			var txt = reader.result;
			console.log(txt);

			// DOMにセット
			$("#script_body_tb").val(txt);
		}
	}

	/*======================================================
	/*
	/* 2-4. 台本編集用ページ　イベント 投稿形式選択ボタンクリック
	/*
	/*======================================================/

	/**
	 * イベント 投稿形式選択ボタンクリック
	 * 　・コンボボックスの内容に合わせて要素の表示切り替え
	 */
	 $("#post_format_cb").change(function(evt) {
		var val = $(this).val()

		if ( val == "url" ) {
			$("#script_url_row").show();
			$("#script_url_row").removeClass("d-none")
			$("#script_file_row").hide();
		} else {
			$("#script_url_row").hide();
			$("#script_file_row").show();
		}
	});

	/*======================================================
	/*
	/* 2-5. 台本編集用ページ　オプション要素選択
	/*
	/*======================================================/

	/**
	 * 台本編集用ページ　オプション要素選択
	 * 　・selectタグのhref要素に値が設定されていればその要素をセット
	 */
	function select_option_init_val() {
		$('select').each(function(i) {
			var init_val = $(this).attr("href");

			$(this).find("option").each(function(i){
				if (init_val == $(this).val()) {
					$(this).prop('selected', true);	
					
					console.log($(this).val());				
				}
			});			
		});
	};

	/*======================================================
	/*
	/* 2-6. 台本編集用ページ　イベント 投稿内容を確認ボタンクリック
	/*
	/*======================================================*/		

	/**
	 * イベント 投稿内容を確認ボタンクリック
	 */
	 $("#dummy_submit_confirm_button").click(function() {
		// バリデーション
		if ( !check_input_validation() ) {
			return;
		}	

		// 隠し要素のボタンをクリック
		$('#hidden_submit_button').trigger("click");
	});

	/**
	 * バリデーション
	 */
	function check_input_validation() {
		if($("#title_txt_box").val().length == 0) {			
			$("#title_txt_box").focus();
			alert("タイトルが入力されていません。");

			return false;
		}

		if($("#author_txt_box").val().length == 0) {			
			$("#author_txt_box").focus();
			alert("作者名が入力されていません。");

			return false;
		}

		var op = $("#post_format_cb").val()
		// URL選択時はURLが空ならNG
		if ( op == "url" ) {
			var url = $("#url_txt_box").val();
			if(url == "" ) {			
				$("#url_txt_box").focus();
				alert("台本のURLが入力されていません。");

				return false;
			}
		// それ以外はファイルが空ならNG
		} else {
			if($("#file_select_btn").val().length == 0) {			
				$("#file_select_btn").focus();
				alert("台本ファイルが選択されていません。");

				return false;
			}
		}

		return true;
	}

	/*======================================================
	/*
	/* 2-7. 台本編集用ページ　イベント 編集完了ボタンクリック
	/*
	/*======================================================*/		

	/**
	 * イベント 投稿ボタンクリック
	 */
	$("#dummy_submit_button").click(function() {
		if (window.confirm('この内容で台本を投稿します。よろしいですか？')) {
			// 隠し要素のボタンをクリック
			$('#hidden_submit_button').trigger("click");
		} else {
			//キャンセルを選んだ場合
			return false;
		}
	});

	/*======================================================
	/*
	/* 2-8. 台本編集用ページ　イベント 台本削除ボタンクリック
	/*
	/*======================================================*/		

	/**
	 * イベント 台本削除ボタンクリック
	 */
	 $("#delete_button").click(function() {
		if (window.confirm('この台本を削除します。この操作は戻せません。よろしいですか？')) {
			var url = $(this).attr("name");
			// 隠し要素のボタンをクリック
			$('#hidden_delete_submit_button').trigger("click");
		} else {
			//キャンセルを選んだ場合
			return false;
		}
	});


	/*======================================================
	/*
	/* 3-1. 台本詳細ページ イベント 編集用パスワード入力完了ボタンクリック
	/*
	/*======================================================*/		

	/**
	 * イベント 編集用パスワード入力完了ボタンクリック
	 */
	 $("#dummy_submit_edit_password_button").click(function() {
		var correct_pass = $("#correct_edit_password").val()
		var input_pass = $("#edit_password_tb").val()

		console.log(correct_pass);
		console.log(input_pass);

		if (correct_pass != input_pass) {
			alert("パスワードが間違っています。");

			return;
		}

		// 隠し要素のボタンをクリック
		$('#hidden_submit_edit_password_button').trigger("click");
	});

	/*======================================================
	/*
	/* 3-2. 台本詳細ページ イベント 縦書きに切り替えボタンクリック
	/*
	/*======================================================*/	
	
	/**
	 * 台本詳細ページ イベント 縦書きに切り替えボタンクリック
	 */
	$("#show_by_vertical_button").click(function() {
		$("#vertical_modal_container").removeClass("d-none")		
		$("#vertical_modal_container").show();		
		$("#vertical_modal_container").addClass('active');	
		$("#horizon").hide();		
	});

	/*======================================================
	/*
	/* 3-3-1. 台本詳細ページ イベント 縦書き画面を閉じるボタンクリック
	/*
	/*======================================================*/	
	
	/**
	 * 台本詳細ページ イベント 縦書き画面を閉じるボタンクリック
	 */
	$("#close_vertical_button").click(function() {
		$("#vertical_modal_container").removeClass('active');
		$("#horizon").show();		
	});

	/*======================================================
	/*
	/* 3-3-2. 台本詳細ページ イベント 縦書きの枠外クリック
	/*
	/*======================================================*/	
	    
    /**
	 * 台本詳細ページ イベント 縦書きの枠外クリック
	 */
	$("#vertical_modal_container").click(function() {
		$("#vertical_modal_container").removeClass('active');
		$("#horizon").show();	
	});

	/*======================================================
	/*
	/* 3-3-3. 台本詳細ページ イベント 縦書きエリア内クリック
	/*
	/*======================================================*/	

    /**
     * 縦書きエリア内クリック
     * 　・イベントをキャンセル（枠外クリック時のイベント打ち消し）
     */
    $('#vertical_modal_body').on( 'click', function( e ){
        e.stopPropagation();
    });

	/*======================================================
	/*
	/* 3-4. 台本詳細ページ セリフをテーブル形式で描画（横書き）
	/*
	/*======================================================*/		

	/**
	 * セリフをテーブル形式で描画（横書き）
	 */
	 function show_txt_by_table() {
		var NARRE_TXT_PREFIX = "――― "
		var table_tag = "<table class = 'script'><tr><th class = 'name'></th><th>　</th></tr>"

		// 台本のテキストを改行で分割して取得	
		var line_txts = get_line_txts_from_div($("#script_write_area"));
		// テキストから名前だけをセット
		var names = get_names(line_txts)
		
		// 行を走査
		for ( i = 0; i < line_txts.length; i++ ) {
			// 該当行のテキストをセット
			var ltxt = line_txts[i];
			// 名前をセット 
			var txts = ltxt.split("：");
			var name = txts[0]
			// セリフをセット
			var vc = txts[1]

			// 前の行の氏名をセット
			var p_name = get_line_name(line_txts, i - 1)

			// 前の行の氏名と異なれば新しい行へ
			if ( p_name != name ) {
				// 1行目以外は閉じタグを追加
				if ( i != 0 ) {
					table_tag += "</td></tr>"
				}

				var ncl = get_name_class(names, name);
				//table_tag += "<tr class = '" + ncl + "'><td class = 'name'><span class = '" + ncl + "'>" + name + "</td>" + "<td class = 'text'>" 
				table_tag += "<tr class = '" + ncl + "'><td class = 'name'><span class = '" + ncl + "' style='background:#" + ncl + "'>" + name + "</td>" + "<td class = 'text'>" 

				// .の場合のみ、カット
				if (vc == ".") {
					vc = ""
				}

				// ト書きの場合のみ、--を追加
				if (name == "0") {
					vc = NARRE_TXT_PREFIX + vc
				}

				// セリフを描画
				table_tag += vc; 							
			// 前の行と氏名が同じなら改行＋セリフのみ
			} else {
				// .の場合のみ、カット
				if (vc == ".") {
					vc = ""
				}

				table_tag += "<br />" + vc
			}
		}

		table_tag += "</tr></table>"

		// 描画
		$("#script_show_area").html(table_tag);
	 }

	//======================================================
	// divタグから "：" 付の行のテキストのみを配列で返す
	//======================================================

	 /**
	  * divタグから：付の行のテキストのみを配列で返す
	  */ 
	 function get_line_txts_from_div(div_block) {
		var line_txts = []

		// 行で分割
		var splits = div_block.text().split(/\r\n|\n/);			
		for (i = 0; i < splits.length; i++) {
			var line_txt = splits[i].trim();

			// :を含めば
			if (line_txt.indexOf("：") != - 1) {
				line_txts.push(line_txt)
			}
		}

		return line_txts;
	 }

	//======================================================
	// 台本の該当行のキャラ名を返す
	//======================================================

	 /**
	  * 台本の該当行のキャラ名を返す
	  * 　・例："キャラ1：セリフ" → "キャラ1"
	  * 
	  * @param line_txts 第本テキスト
	  * @param i 行番号
	  * @return キャラ名
	  */ 
	 function get_line_name(line_txts, i) {
		// 0行目未満ならスキップ
		if ( i < 0 ) {
			return ""
		}

		// 該当行のテキストをセット
		var ltxt = line_txts[i]
		// "："で分割
		var txts = ltxt.split("：");

		return txts[0]
	 }

	//======================================================
	// キャラ名だけを配列で返す
	//======================================================	 

	 /**
	  * キャラ名だけを配列で返す
	  */
	function get_names(line_txts) {
		var names = []

		// 台本テキストを走査
		for ( i = 0; i < line_txts.length; i++ ) {
			// 該当行のテキストをセット
			var ltxt = line_txts[i];

			// "："で分割して名前をセット 
			var txts = ltxt.split("：");
			var name = txts[0]

			if ( names.indexOf(name) == -1 ) {
				names.push(name)
			}
		}

		return names
	}

	//======================================================
	// 該当のキャラ名のspanタグ用クラスを返す
	//======================================================	 	

	/**
	 * 該当のキャラ名のspanタグ用クラスを返す
	 * 　・"0"の場合は"ffffff"を返す
	 * 　・キャラクター紹介用テーブルから該当キャラのクラスを返す
	 * 
	 * @return cl_txt 
	 */ 
	function get_name_class(names, name) {
		var txt = "";
		const NARRATION_CLASS = "ffffff"

		// 0の場合は"ffffff"を返す
		if (name == "0") {
			return NARRATION_CLASS;
		}

		// キャラテーブルを走査
		$('table#chara tr').each(function(i) {
			// nameセルをセット
			var name_td = $(this).find("td.name");
			var span_td = $(this).find("span");

			// 名前が一致すれば
			if (span_td.text() == name) {
				var cl = span_td.attr("class");
				cl_txt = cl;

				return;
			} else if(name.indexOf(span_td.text()) !== -1) {
				var cl = span_td.attr("class");
				cl_txt = cl;				
			}
		});		

		return cl_txt;
	}
	
	/*======================================================
	/*
	/* 3-6. 台本詳細ページ セリフを描画（縦書き）
	/*
	/*======================================================*/		

	/**
	 * セリフを縦書き形式で描画
	 */
	 function show_txt_by_vertical() {
		var NARRE_TXT_PREFIX = "――― "
		var all_tag = "";

		// 行で分割
		var sc_div = $("#vertical_script_area")			
		var line_txts = get_line_txts_from_div(sc_div);

		// タイトルをセット
		var title = $('td.title').text();

		// 名前だけをセット
		var names = get_names(line_txts)

		// 行を走査
		for ( i = 0; i < line_txts.length; i++ ) {
			// 該当行のテキストをセット
			var ltxt = line_txts[i];
			// 名前をセット 
			var txts = ltxt.split("：");
			var name = txts[0]
			// セリフをセット
			var vc = txts[1]

			// 前の行の氏名をセット
			var p_name = get_line_name(line_txts, i - 1)

			// 前の行の氏名と異なれば新しい行へ
			if ( p_name != name ) {
				// 1行目以外は閉じタグを追加
				if ( i != 0 ) {
					all_tag += "</p></div>"
				}

				var ncl = get_name_class(names, name);

				all_tag += "<div class = '" + ncl + "'>"
				all_tag += "<span class = '" + ncl + "' style='background:#" + ncl + "'>" + name + "</span>" + "<p class = '" + ncl + "'>"
				
				// .の場合のみ、カット
				if (vc == ".") {
					vc = ""
				}
				
				// ト書きの場合のみ、--を追加
				if (name == "0" || name == "") {
					vc = NARRE_TXT_PREFIX + vc
				}

				// セリフを描画
				all_tag += vc; 							
			// 前の行と氏名が同じなら改行＋セリフのみ
			} else {
				// .の場合のみ、カット
				if (vc == ".") {
					vc = ""
				}

				all_tag += "<br />" + vc
			}
		}

		all_tag += "</p></div>"

		// 描画
		$("#vertical_script_area").html(all_tag);
	 }

	/*======================================================
	/*
	/* 3-7. 台本詳細ページ イベント 横書きセリフクリック
	/*
	/*======================================================*/		

	/**
	 * 縦書きセリフクリック
	 */
	 $("table.script td").click(function() {
		// 行のクラスを取得
		var cl = $(this).parent().attr("class");
		var bg = rgbTo16($(this).css("background-color"));
		console.log(cl);

		// 横書き台本の行を走査
		$('table.script tr').each(function(i) {
			// クラスをセット
			var tcl = $(this).attr("class");

			// クラスが一致すれば
			if (tcl == cl) {
				if (bg == "#ffffff") {
					$(this).children("td").css("background-color", "#f0f7fc");         
                } else {
					$(this).children("td").css("background-color", "#ffffff");						
				}
			}
		});		
	});

	/*======================================================
	/*
	/* 3-8. 台本詳細ページ イベント 縦書きセリフクリック
	/*
	/*======================================================*/		

	/**
	 * 縦書きセリフクリック
	 */
	$("div#vertical_script_area div").click(function() {
		// 段落のクラスを取得
		var cl = $(this).attr("class");
		var bg = rgbTo16($(this).css("background-color"));

		// 縦書き台本の段落を走査
		$('div#vertical_script_area div').each(function(i) {
			// nameセルをセット
			var tcl = $(this).attr("class");

			// クラスが一致すれば
			if (tcl == cl) {
				if (bg == "#ffffff") {
					$(this).css("background-color", "#efefef");	
				} else {
					$(this).css("background-color", "#ffffff");						
				}
			}
		});		
	});

    /*======================================================
	/*
	/* 3-9. 台本詳細ページ イベント 縦書きエリア　マウスホイール
	/*
	/*======================================================*/		

    // スクロール後の位置
    var moving;
    // 1スクロールの移動距離
    var speed = -2;

	/**
	 * 縦書きエリア　マウスホイール
	 */
    // アニメーション
    var animation = 'easeOutCirc';
    // アニメーションスピード
    var anm_speed = 500;
    $('.horizontal-scroll').mousewheel(function(event, mov) {
        // スクロール後の位置の算出
        var moving = $(this).scrollLeft() - mov * speed;
        // スクロールする
        $(this).scrollLeft(moving);
        // 余韻の計算
        if (mov < 0) {
            // 下にスクロールしたとき
            aftermov =  moving + after;
        } else {
            // 上にスクロールしたとき
            aftermov =  moving - after;
        }
        // 余韻アニメーション
        $(this).stop().animate({scrollLeft: aftermov}, anm_speed, animation);
        // 縦スクロールさせない
        return false;
    });
});

