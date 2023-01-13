<div id="kboard-first-news-ticker">
	<div class="news-ticker-list">
		<?php $is_first=true; while($content = $list->hasNext()):?>
		<li class="rolling-item"<?php if($is_first):?> style="display:block;"<?php endif?>>
			<div class="title-area">
				<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>">
					<?php if($content->isNew()):?><span class="kboard-first-news-ticker-new-notify"><img src="<?php echo $skin_path?>/images/icon-new.png" class="kboard-icon-new" alt="new"></span><?php endif?>
					<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon-lock.png" class="kboard-icon-lock" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
					<?php echo wp_strip_all_tags($content->title)?>
					<span class="comments-count"><?php echo $content->getCommentsCount()?></span>
				</a>
			</div>
			<div class="date-area">
				<?php echo $content->getDate()?>
			</div>
		</li>
		<?php $is_first=false; endwhile?>
	</div>
	
	<div class="rolling-button-area">
		<a href="javascript:void(0);" class="rolling-prev"><i class="fas fa-caret-up"></i></a>
		<a href="javascript:void(0);" class="rolling-next"><i class="fas fa-caret-down"></i></a>
	</div>
</div>

<?php
do_action('kboard_first_news_ticker_enqueue_scripts');
?>