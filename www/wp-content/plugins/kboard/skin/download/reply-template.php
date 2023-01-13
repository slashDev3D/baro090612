<?php while($content = $list->hasNextReply()):?>
<tr>
	<td class="kboard-list-uid"></td>
	<td class="kboard-list-download">
		<?php if($content->isAttached()):?>
			<?php foreach($content->getAttachmentList() as $key=>$attach):?>
			<button type="button" class="kboard-button-action kboard-button-download" onclick="window.location.href='<?php echo $url->getDownloadURLWithAttach($content->uid, $key)?>'" title="<?php echo sprintf(__('Download %s', 'kboard'), $attach[1])?>"><i class="icon-cloud-download"></i> <?php echo __('Download', 'kboard')?></button>
			<?php endforeach?>
		<?php endif?>
	</td>
	<td class="kboard-list-title" style="padding-left:<?php echo ($depth+1)*5?>px">
		<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>#kboard-document">
			<div class="kboard-download-cut-strings">
				<img src="<?php echo $skin_path?>/images/icon-reply.png" alt="">
				<?php if($content->isNew()):?><span class="kboard-download-new-notify">New</span><?php endif?>
				<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon-lock.png" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
				<?php echo $content->title?>
				<span class="kboard-comments-count"><?php echo $content->getCommentsCount()?></span>
			</div>
		</a>
	</td>
	<td class="kboard-list-language"><?php echo $content->option->language?></td>
	<td class="kboard-list-date"><?php echo $content->getDate()?></td>
</tr>
<?php $boardBuilder->builderReply($content->uid, $depth+1)?>
<?php endwhile?>