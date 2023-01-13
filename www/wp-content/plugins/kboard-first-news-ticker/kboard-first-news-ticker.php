<?php
/*
Plugin Name: KBoard 퍼스트 뉴스티커
Plugin URI: https://www.cosmosfarm.com/wpstore/product/kboard-first-news-feed-skin
Description: KBoard 게시판의 최신글 모아보기 기능에 퍼스트 뉴스티커 스킨이 추가됩니다.
Version: 1.0
Author: 코스모스팜 - Cosmosfarm
Author URI: https://www.cosmosfarm.com
*/

if(!defined('ABSPATH')) exit;

define('KBOARD_FIRST_NEWS_TICKER_VERSION', '1.0');
define('KBOARD_FIRST_NEWS_TICKER_DIR', dirname(__FILE__));
define('KBOARD_FIRST_NEWS_TICKER_URL', plugins_url('', __FILE__));

add_filter('kboard_skin_latestview_list', 'kboard_skin_latestview_list_first_news_ticker', 10, 1);
function kboard_skin_latestview_list_first_news_ticker($list){
	
	$skin = new stdClass();
	$skin->dir = dirname(__FILE__);
	$skin->url = plugins_url('', __FILE__);
	$skin->name = basename($skin->dir);
	
	$list[$skin->name] = $skin;
	
	return $list;
}

add_action('wp_enqueue_scripts', 'kboard_first_news_ticker_init');
function kboard_first_news_ticker_init(){
	wp_register_style('kboard-first-news-ticker', KBOARD_FIRST_NEWS_TICKER_URL . '/style.css', array(), KBOARD_FIRST_NEWS_TICKER_VERSION);
	wp_register_script('kboard-first-news-ticker', KBOARD_FIRST_NEWS_TICKER_URL . '/script.js', array('jquery'), KBOARD_FIRST_NEWS_TICKER_VERSION);
	
	wp_register_script('jquery-cycle2', KBOARD_FIRST_NEWS_TICKER_URL . '/assets/cycle2/jquery.cycle2.min.js', array('jquery'), '2.1.6');
	wp_register_script('jquery-cycle2-scrollVert', KBOARD_FIRST_NEWS_TICKER_URL . '/assets/cycle2/plugin/jquery.cycle2.scrollVert.min.js', array('jquery-cycle2'), '2.1.6');
	
	$settings = kboard_first_news_ticker_settings();
	wp_localize_script('jquery-cycle2', 'kboard_first_news_ticker_settings', $settings);
}

add_action('kboard_first_news_ticker_enqueue_scripts', 'kboard_first_news_ticker_enqueue_scripts');
function kboard_first_news_ticker_enqueue_scripts(){
	$settings = kboard_first_news_ticker_settings();
	
	wp_enqueue_style('kboard-first-news-ticker');
	wp_enqueue_script('kboard-first-news-ticker');
	
	if($settings['fx'] == 'scrollVert'){
		wp_enqueue_script('jquery-cycle2-scrollVert');
	}
}

function kboard_first_news_ticker_settings(){
	$settings = array(
		'timeout' => '5000', // 자동 롤링 없애려면 0으로 입력
		'speed' => '1000',
		'fx' => 'scrollVert',
		'next' => '.rolling-prev',
		'prev' => '.rolling-next',
		'slides' => '.rolling-item',
	);
	return apply_filters('kboard_first_news_ticker_settings', $settings);
}