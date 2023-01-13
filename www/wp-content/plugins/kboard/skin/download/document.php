<div id="kboard-document">
	<div id="kboard-download-document">
		<div class="kboard-document-wrap" itemscope itemtype="http://schema.org/Article">
			<div class="kboard-title" itemprop="name">
				<p><?php echo $content->title?></p>
			</div>
			
			<div class="kboard-detail">
				<?php if($content->category1):?>
				<div class="detail-attr detail-category1">
					<div class="detail-name"><?php echo $content->category1?></div>
				</div>
				<?php endif?>
				<?php if($content->category2):?>
				<div class="detail-attr detail-category2">
					<div class="detail-name"><?php echo $content->category2?></div>
				</div>
				<?php endif?>
				<?php if($content->option->tree_category_1):?>
				<?php for($i=1; $i<=$content->getTreeCategoryDepth(); $i++):?>
				<div class="detail-attr detail-tree-category-<?php echo $i?>">
					<div class="detail-name"><?php echo $content->option->{'tree_category_'.$i}?></div>
				</div>
				<?php endfor?>
				<?php endif?>
				<div class="detail-attr detail-writer">
					<div class="detail-name"><?php echo __('Author', 'kboard')?></div>
					<div class="detail-value"><?php echo apply_filters('kboard_user_display', $content->member_display, $content->member_uid, $content->member_display, 'kboard', $boardBuilder)?></div>
				</div>
				<div class="detail-attr detail-date">
					<div class="detail-name"><?php echo __('Date', 'kboard')?></div>
					<div class="detail-value"><?php echo date("Y-m-d H:i", strtotime($content->date))?></div>
				</div>
				<div class="detail-attr detail-view">
					<div class="detail-name"><?php echo __('Views', 'kboard')?></div>
					<div class="detail-value"><?php echo $content->view?></div>
				</div>
			</div>
			
			<div class="kboard-content" itemprop="description">
				<div class="content-view">
					<?php echo $content->content?>
				</div>
			</div>
			
			<?php if($content->option->download_skin_password && !$board->isAdmin()):?>
				<div class="kboard-attach kboard-attach-password">
					<form id="kboard-download-skin-form" method="post" onsubmit="return kboard_download_skin_password_submit_check()">
						<?php wp_nonce_field('kboard-download-skin-form-execute', 'kboard-download-skin-form-execute-nonce')?>
						<p>보안을 위해서 다운로드 비밀번호를 입력해야 합니다.</p>
						<p><input type="password" name="download_skin_password" placeholder="비밀번호" required></p>
					</form>
				</div>
				<?php if($content->isAttached()):?>
					<?php foreach($content->getAttachmentList() as $key=>$attach):?>
					<div class="kboard-attach">
						<?php echo __('Attachment', 'kboard')?> : <button type="button" class="kboard-button-action kboard-button-download" onclick="kboard_download_skin_password_form('<?php echo $url->getDownloadURLWithAttach($content->uid, $key)?>'); return false;" title="<?php echo sprintf(__('Download %s', 'kboard'), $attach[1])?>"><?php echo $attach[1]?></button>
					</div>
					<?php endforeach?>
				<?php endif?>
			
			<?php else:?>
				<?php if($content->isAttached()):?>
					<?php foreach($content->getAttachmentList() as $key=>$attach):?>
					<div class="kboard-attach">
						<?php echo __('Attachment', 'kboard')?> : <button type="button" class="kboard-button-action kboard-button-download" onclick="window.location.href='<?php echo $url->getDownloadURLWithAttach($content->uid, $key)?>'" title="<?php echo sprintf(__('Download %s', 'kboard'), $attach[1])?>"><?php echo $attach[1]?></button>
					</div>
					<?php endforeach?>
				<?php endif?>
			
			<?php endif?>
		</div>
		
		<?php if($content->visibleComments()):?>
		<div class="kboard-comments-area"><?php echo $board->buildComment($content->uid)?></div>
		<?php endif?>
		
		<div class="kboard-control">
			<div class="left">
				<a href="<?php echo $url->getBoardList()?>" class="kboard-download-button-small"><?php echo __('List', 'kboard')?></a>
				<a href="<?php echo $url->getDocumentURLWithUID($content->getPrevUID())?>" class="kboard-download-button-small"><?php echo __('Prev', 'kboard')?></a>
				<a href="<?php echo $url->getDocumentURLWithUID($content->getNextUID())?>" class="kboard-download-button-small"><?php echo __('Next', 'kboard')?></a>
				<?php if($board->isWriter() && !$content->notice):?><a href="<?php echo $url->set('parent_uid', $content->uid)->set('mod', 'editor')->toString()?>" class="kboard-download-button-small"><?php echo __('Reply', 'kboard')?></a><?php endif?>
			</div>
			<?php if($content->isEditor() || $board->permission_write=='all'):?>
			<div class="right">
				<a href="<?php echo $url->getContentEditor($content->uid)?>" class="kboard-download-button-small"><?php echo __('Edit', 'kboard')?></a>
				<a href="<?php echo $url->getContentRemove($content->uid)?>" class="kboard-download-button-small" onclick="return confirm('<?php echo __('Are you sure you want to delete?', 'kboard')?>');"><?php echo __('Delete', 'kboard')?></a>
			</div>
			<?php endif?>
		</div>
		
		<?php if($board->contribution() && !$board->meta->always_view_list):?>
		<div class="kboard-download-poweredby">
			<a href="https://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href);return false;" title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard')?>">Powered by KBoard</a>
		</div>
		<?php endif?>
	</div>
</div>

<script>
var kboard_download_skin_password_submit = false;
function kboard_download_skin_password_form(download_url){
	if(!jQuery('input[name="download_skin_password"]', '#kboard-download-skin-form').val()){
		alert(kboard_localize_strings.please_enter_the_password);
		jQuery('input[name="download_skin_password"]', '#kboard-download-skin-form').focus();
		return false;
	}
	kboard_download_skin_password_submit = true;
	jQuery('#kboard-download-skin-form').attr('action', download_url);
	jQuery('#kboard-download-skin-form').submit();
	return true;
}
function kboard_download_skin_password_submit_check(){
	if(!kboard_download_skin_password_submit){
		alert('다운로드할 첨부파일을 선택하세요.');
	}
	return kboard_download_skin_password_submit;
}
</script>