<div id="kboard-download-editor">
	<form class="kboard-form" method="post" action="<?php echo $url->getContentEditorExecute()?>" enctype="multipart/form-data" onsubmit="return kboard_editor_execute(this);">
		<?php wp_nonce_field('kboard-editor-execute', 'kboard-editor-execute-nonce')?>
		<input type="hidden" name="action" value="kboard_editor_execute">
		<input type="hidden" name="mod" value="editor">
		<input type="hidden" name="uid" value="<?php echo $content->uid?>">
		<input type="hidden" name="board_id" value="<?php echo $content->board_id?>">
		<input type="hidden" name="parent_uid" value="<?php echo $content->parent_uid?>">
		<input type="hidden" name="member_uid" value="<?php echo $content->member_uid?>">
		<input type="hidden" name="member_display" value="<?php echo $content->member_display?>">
		<input type="hidden" name="date" value="<?php echo $content->date?>">
		<input type="hidden" name="user_id" value="<?php echo get_current_user_id()?>">
		
		<div class="kboard-attr-row kboard-attr-title">
			<label class="attr-name" for="kboard-input-title"><?php echo __('Title', 'kboard')?></label>
			<div class="attr-value"><input type="text" id="kboard-input-title" name="title" value="<?php echo $content->title?>" placeholder="<?php echo __('Title', 'kboard')?>..."></div>
		</div>
		
		<?php if($board->use_category):?>
			<?php if($board->isTreeCategoryActive()):?>
				<div class="kboard-attr-row">
					<label class="attr-name" for="kboard-tree-category"><?php echo __('Category', 'kboard')?></label>
					<div class="attr-value">
						<?php for($i=1; $i<=$content->getTreeCategoryDepth(); $i++):?>
						<input type="hidden" id="tree-category-check-<?php echo $i?>" value="<?php echo $content->option->{'tree_category_'.$i}?>">
						<input type="hidden" name="kboard_option_tree_category_<?php echo $i?>" value="">
						<?php endfor?>
						<div class="kboard-tree-category-wrap"></div>
					</div>
				</div>
			<?php else:?>
				<?php if($board->initCategory1()):?>
				<div class="kboard-attr-row">
					<label class="attr-name" for="kboard-select-category1"><?php echo __('Category', 'kboard')?>1</label>
					<div class="attr-value">
						<select id="kboard-select-category1" name="category1">
							<option value=""><?php echo __('Category', 'kboard')?> <?php echo __('Select', 'kboard')?></option>
							<?php while($board->hasNextCategory()):?>
							<option value="<?php echo $board->currentCategory()?>"<?php if($content->category1 == $board->currentCategory()):?> selected<?php endif?>><?php echo $board->currentCategory()?></option>
							<?php endwhile?>
						</select>
					</div>
				</div>
				<?php endif?>
				<?php if($board->initCategory2()):?>
				<div class="kboard-attr-row">
					<label class="attr-name" for="kboard-select-category2"><?php echo __('Category', 'kboard')?>2</label>
					<div class="attr-value">
						<select id="kboard-select-category2" name="category2">
							<option value=""><?php echo __('Category', 'kboard')?> <?php echo __('Select', 'kboard')?></option>
							<?php while($board->hasNextCategory()):?>
							<option value="<?php echo $board->currentCategory()?>"<?php if($content->category2 == $board->currentCategory()):?> selected<?php endif?>><?php echo $board->currentCategory()?></option>
							<?php endwhile?>
						</select>
					</div>
				</div>
				<?php endif?>
			<?php endif?>
		<?php endif?>
		
		<div class="kboard-attr-row">
			<div class="attr-name"><?php echo __('Options', 'kboard')?></div>
			<div class="attr-value">
				<label class="attr-value-option"><input type="checkbox" name="secret" value="true" onchange="kboard_toggle_password_field(this)"<?php if($content->secret):?> checked<?php endif?>> <?php echo __('Secret', 'kboard')?></label>
				<?php if($board->isAdmin()):?>
				<label class="attr-value-option"><input type="checkbox" name="notice" value="true"<?php if($content->notice):?> checked<?php endif?>> <?php echo __('Notice', 'kboard')?></label>
				<?php endif?>
				<?php do_action('kboard_skin_editor_option', $content, $board, $boardBuilder)?>
			</div>
		</div>
		
		<?php if($board->viewUsernameField()):?>
		<div class="kboard-attr-row">
			<label class="attr-name" for="kboard-input-member-display"><?php echo __('Author', 'kboard')?></label>
			<div class="attr-value"><input type="text" id="kboard-input-member-display" name="member_display" value="<?php echo $content->member_display?>" placeholder="<?php echo __('Author', 'kboard')?>..."></div>
		</div>
		<div class="kboard-attr-row">
			<label class="attr-name" for="kboard-input-password"><?php echo __('Password', 'kboard')?></label>
			<div class="attr-value"><input type="password" id="kboard-input-password" name="password" value="<?php echo $content->password?>" placeholder="<?php echo __('Password', 'kboard')?>..."></div>
		</div>
		<?php else:?>
		<div style="overflow:hidden;width:0;height:0;">
			<input style="width:0;height:0;background:transparent;color:transparent;border:none;" type="text" name="fake-autofill-fields">
			<input style="width:0;height:0;background:transparent;color:transparent;border:none;" type="password" name="fake-autofill-fields">
		</div>
		<!-- ????????? ???????????? ?????? ?????? -->
		<div class="kboard-attr-row secret-password-row"<?php if(!$content->secret):?> style="display:none"<?php endif?>>
			<label class="attr-name" for="kboard-input-password"><?php echo __('Password', 'kboard')?></label>
			<div class="attr-value"><input type="password" id="kboard-input-password" name="password" value="<?php echo $content->password?>" placeholder="<?php echo __('Password', 'kboard')?>..."></div>
		</div>
		<!-- ????????? ???????????? ?????? ??? -->
		<?php endif?>
		
		<?php if($board->useCAPTCHA() && !$content->uid):?>
			<?php if(kboard_use_recaptcha()):?>
				<div class="kboard-attr-row">
					<label class="attr-name"></label>
					<div class="attr-value"><div class="g-recaptcha" data-sitekey="<?php echo kboard_recaptcha_site_key()?>"></div></div>
				</div>
			<?php else:?>
				<div class="kboard-attr-row">
					<label class="attr-name" for="kboard-input-captcha"><img src="<?php echo kboard_captcha()?>" alt=""></label>
					<div class="attr-value"><input type="text" id="kboard-input-captcha" name="captcha" value="" placeholder="<?php echo __('CAPTCHA', 'kboard')?>..."></div>
				</div>
			<?php endif?>
		<?php endif?>
		
		<div class="kboard-content">
			<?php
			echo kboard_content_editor(array(
				'board' => $board,
				'content' => $content,
				'required' => '',
				'placeholder' => '',
				'editor_height' => '400'
			));
			?>
		</div>
		
		<div class="kboard-attr-row">
			<label class="attr-name"><?php echo __('Photos', 'kboard')?></label>
			<div class="attr-value" style="line-height:30px">
				<a href="#" onclick="kboard_editor_open_media();return false;"><?php echo __('KBoard Add Media', 'kboard')?></a>
			</div>
		</div>
		
		<?php if($board->meta->max_attached_count > 0):?>
			<!-- ???????????? ?????? -->
			<?php for($attached_index=1; $attached_index<=$board->meta->max_attached_count; $attached_index++):?>
			<div class="kboard-attr-row">
				<label class="attr-name" for="kboard-input-file<?php echo $attached_index?>"><?php echo __('Attachment', 'kboard')?><?php echo $attached_index?></label>
				<div class="attr-value">
					<?php if(isset($content->attach->{"file{$attached_index}"})):?><?php echo $content->attach->{"file{$attached_index}"}[1]?> - <a href="<?php echo $url->getDeleteURLWithAttach($content->uid, "file{$attached_index}")?>" onclick="return confirm('<?php echo __('Are you sure you want to delete?', 'kboard')?>');"><?php echo __('Delete file', 'kboard')?></a><?php endif?>
					<input type="file" id="kboard-input-file<?php echo $attached_index?>" name="kboard_attach_file<?php echo $attached_index?>">
				</div>
			</div>
			<?php endfor?>
			<!-- ???????????? ??? -->
		<?php endif?>

		<div class="kboard-attr-row">
			<label class="attr-name" style="line-height:normal">????????????<br>????????????</label>
			<div class="attr-value">
				<input type="text" name="kboard_option_download_skin_password" value="<?php echo $content->option->download_skin_password?>">
				<p class="description">??? ???????????? ??????????????? ????????? ????????? ??????????????? ??????????????? ??? ????????????.</p>
			</div>
		</div>
		
		<div class="kboard-attr-row">
			<label class="attr-name"><?php echo __('Language', 'kboard')?></label>
			<div class="attr-value">
				<select name="kboard_option_language">
					<option value="KOR"<?php if($content->option->language == 'KOR'):?> selected<?php endif?>>KOR</option>
					<option value="ENG"<?php if($content->option->language == 'ENG'):?> selected<?php endif?>>ENG</option>
				</select>
			</div>
		</div>
		
		<div class="kboard-attr-row">
			<label class="attr-name" for="kboard-select-wordpress-search"><?php echo __('WP Search', 'kboard')?></label>
			<div class="attr-value">
				<select id="kboard-select-wordpress-search" name="wordpress_search">
					<option value="1"<?php if($content->search == '1'):?> selected<?php endif?>><?php echo __('Public', 'kboard')?></option>
					<option value="2"<?php if($content->search == '2'):?> selected<?php endif?>><?php echo __('Only title (secret document)', 'kboard')?></option>
					<option value="3"<?php if($content->search == '3'):?> selected<?php endif?>><?php echo __('Exclusion', 'kboard')?></option>
				</select>
			</div>
		</div>
		
		<div class="kboard-control">
			<div class="left">
				<?php if($content->uid):?>
				<a href="<?php echo $url->getDocumentURLWithUID($content->uid)?>" class="kboard-download-button-small"><?php echo __('Back', 'kboard')?></a>
				<a href="<?php echo $url->getBoardList()?>" class="kboard-download-button-small"><?php echo __('List', 'kboard')?></a>
				<?php else:?>
				<a href="<?php echo $url->getBoardList()?>" class="kboard-download-button-small"><?php echo __('Back', 'kboard')?></a>
				<?php endif?>
			</div>
			<div class="right">
				<?php if($board->isWriter()):?>
				<button type="submit" class="kboard-download-button-small"><?php echo __('Save', 'kboard')?></button>
				<?php endif?>
			</div>
		</div>
	</form>
</div>

<?php wp_enqueue_script('kboard-download-script', "{$skin_path}/script.js", array(), KBOARD_VERSION, true)?>