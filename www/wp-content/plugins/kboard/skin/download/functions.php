<?php
add_filter('kboard_download_file', 'kboard_download_skin_password', 10, 3);
function kboard_download_skin_password($file_info, $content_uid, $board_id){
	
	$board = new KBoard($board_id);
	
	$content = new KBContent();
	$content->initWithUID($content_uid);
	
	if($content->option->download_skin_password && !$board->isAdmin()){
		
		$redirect_to = isset($_GET['redirect_to'])?esc_url_raw($_GET['redirect_to']):'';
		$password = isset($_POST['download_skin_password'])?$_POST['download_skin_password']:'';
		
		if(!isset($_POST['kboard-download-skin-form-execute-nonce']) || !wp_verify_nonce( $_POST['kboard-download-skin-form-execute-nonce'], 'kboard-download-skin-form-execute')){
			$file_info = false;
		}
		
		if(!$password){
			$file_info = false;
		}
		
		if($password != $content->option->download_skin_password){
			$file_info = false;
		}
		
		if($file_info === false){
			if($password){
				header('Content-Type: text/html; charset=UTF-8');
				die('<script>alert("'.__('※ Your password is incorrect.', 'kboard').'");window.history.go(-1);</script>');
			}
			else{
				header('Content-Type: text/html; charset=UTF-8');
				if($redirect_to){
					die('<script>alert("보안을 위해서 다운로드 비밀번호를 입력해야 합니다.");window.location.href="'.$redirect_to.'#kboard-document";</script>');
				}
				else{
					die('<script>alert("보안을 위해서 다운로드 비밀번호를 입력해야 합니다.");window.history.go(-1);</script>');
				}
			}
		}
	}
	
	return $file_info;
}