<div id="kboard-pure-gallery-list">
	<ul class="kboard-pure-gallery-list">
		<?php while($content = $list->hasNext()):?>
		<li class="kboard-list-item<?php if($content->uid == kboard_uid()):?> kboard-list-selected<?php endif?>">
			<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>#kboard-document">
				<div class="kboard-list-thumbnail">
					<?php if($content->getThumbnail(500, 500)):?>
					<div class="kboard-list-thumbnail-child" style="background-image:url(<?php echo $content->getThumbnail(500, 500)?>)"></div>
					<?php endif?>
					<?php if(isset($content->attach->over_image)):?>
					<div class="kboard-list-thumbnail-over-background"></div>
					<div class="kboard-list-thumbnail-over-image"><img src="<?php echo site_url($content->attach->over_image[0])?>" alt=""></div>
					<?php endif?>
				</div>
				<div class="kboard-list-new"><?php if($content->isNew()):?><span class="kboard-oneticon-new-notify">New</span><?php endif?></div>
				<div class="kboard-list-title"><div class="kboard-pure-gallery-cut-strings">
					<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon-lock.png" class="kboard-icon-lock" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
					<?php echo $content->title?>
				</div></div>
				<div class="kboard-list-user"><?php echo $content->getUserDisplay()?></div>
			</a>
		</li>
		<?php endwhile?>
	</ul>
</div>

<?php wp_enqueue_script('pure-gallery-list', "{$skin_path}/list.js", array(), KBOARD_VERSION, true)?>