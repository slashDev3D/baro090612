<div id="kboard-download-list">
	
	<!-- 검색폼 시작 -->
	<div class="kboard-header">
		<!-- 카테고리 시작 -->
			<?php
			if($board->use_category == 'yes'){
				if($board->isTreeCategoryActive()){
					$category_type = 'tree-select';
				}
				else{
					$category_type = 'default';
				}
				$category_type = apply_filters('kboard_skin_category_type', $category_type, $board, $boardBuilder);
				echo $skin->load($board->skin, "list-category-{$category_type}.php", $vars);
			}
			?>
		<!-- 카테고리 끝 -->
		
		<form id="kboard-search-form" method="get" action="<?php echo $url->toString()?>">
			<?php echo $url->set('category1', '')->set('category2', '')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput()?>
			
			<div class="kboard-search">
				<select name="target">
					<option value=""><?php echo __('All', 'kboard')?></option>
					<option value="title"<?php if(kboard_target() == 'title'):?> selected<?php endif?>><?php echo __('Title', 'kboard')?></option>
					<option value="content"<?php if(kboard_target() == 'content'):?> selected<?php endif?>><?php echo __('Content', 'kboard')?></option>
					<option value="member_display"<?php if(kboard_target() == 'member_display'):?> selected<?php endif?>><?php echo __('Author', 'kboard')?></option>
				</select>
				<input type="text" name="keyword" value="<?php echo kboard_keyword()?>">
				<button type="submit" class="kboard-download-button-small"><?php echo __('Search', 'kboard')?></button>
			</div>
		</form>
	</div>
	<!-- 검색폼 끝 -->
	
	<!-- 리스트 시작 -->
	<div class="kboard-list">
		<table>
			<thead>
				<tr>
					<td class="kboard-list-uid"><?php echo __('Number', 'kboard')?></td>
					<td class="kboard-list-download"><?php echo __('Download', 'kboard')?></td>
					<td class="kboard-list-title"><?php echo __('Title', 'kboard')?></td>
					<td class="kboard-list-language"><?php echo __('Language', 'kboard')?></td>
					<td class="kboard-list-date"><?php echo __('Date', 'kboard')?></td>
				</tr>
			</thead>
			<tbody>
				<?php while($content = $list->hasNextNotice()):?>
				<tr class="kboard-list-notice">
					<td class="kboard-list-uid"><?php echo __('Notice', 'kboard')?></td>
					<td class="kboard-list-download">
						<?php if($content->isAttached()):?>
							<?php foreach($content->getAttachmentList() as $key=>$attach):?>
							<button type="button" class="kboard-button-action kboard-button-download" onclick="window.location.href='<?php echo $url->getDownloadURLWithAttach($content->uid, $key)?>'" title="<?php echo sprintf(__('Download %s', 'kboard'), $attach[1])?>"><i class="icon-cloud-download"></i> <?php echo __('Download', 'kboard')?></button>
							<?php endforeach?>
						<?php endif?>
					</td>
					<td class="kboard-list-title">
						<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>#kboard-document">
							<div class="kboard-download-cut-strings">
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
				<?php endwhile?>
				<?php while($content = $list->hasNext()):?>
				<tr>
					<td class="kboard-list-uid"><?php echo $list->index()?></td>
					<td class="kboard-list-download">
						<?php if($content->isAttached()):?>
							<?php foreach($content->getAttachmentList() as $key=>$attach):?>
							<button type="button" class="kboard-button-action kboard-button-download" onclick="window.location.href='<?php echo $url->getDownloadURLWithAttach($content->uid, $key)?>'" title="<?php echo sprintf(__('Download %s', 'kboard'), $attach[1])?>"><i class="icon-cloud-download"></i> <?php echo __('Download', 'kboard')?></button>
							<?php endforeach?>
						<?php endif?>
					</td>
					<td class="kboard-list-title">
						<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>#kboard-document">
							<div class="kboard-download-cut-strings">
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
				<?php $boardBuilder->builderReply($content->uid)?>
				<?php endwhile?>
			</tbody>
		</table>
	</div>
	<!-- 리스트 끝 -->
	
	<!-- 페이징 시작 -->
	<div class="kboard-pagination">
		<ul class="kboard-pagination-pages">
			<?php echo kboard_pagination($list->page, $list->total, $list->rpp)?>
		</ul>
	</div>
	<!-- 페이징 끝 -->
	
	<?php if($board->isWriter()):?>
	<!-- 버튼 시작 -->
	<div class="kboard-control">
		<a href="<?php echo $url->getContentEditor()?>" class="kboard-download-button-small"><?php echo __('New', 'kboard')?></a>
	</div>
	<!-- 버튼 끝 -->
	<?php endif?>
	
	<?php if($board->contribution()):?>
	<div class="kboard-download-poweredby">
		<a href="https://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href);return false;" title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard')?>">Powered by KBoard</a>
	</div>
	<?php endif?>
</div>