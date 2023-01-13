<?php
if(!defined('ABSPATH')) exit;

if(!function_exists('kboard_pure_gallery_skin_fields')){
	add_filter('kboard_skin_fields', 'kboard_pure_gallery_skin_fields', 10, 2);
	function kboard_pure_gallery_skin_fields($fields, $board){
		if($board->skin == 'pure-gallery'){
			if(!isset($fields['over_image'])){
				$fields['over_image'] = array(
					'field_type' => 'over_image',
					'field_label' => '오버레이',
					'class' => '',
					'hidden' => '',
					'meta_key' => '',
					'field_name' => '',
					'permission' => '',
					'roles' => '',
					'default_value' => '',
					'placeholder' => '',
					'required' => '',
					'show_document' => '',
					'description' => '',
					'close_button' => 'yes'
				);
			}
		}
		
		return $fields;
	}
}

if(!function_exists('kboard_pure_gallery_get_template_field_html')){
	add_filter('kboard_get_template_field_html', 'kboard_pure_gallery_get_template_field_html', 10, 4);
	function kboard_pure_gallery_get_template_field_html($field_html, $field, $content, $board){
		if($field['field_type'] == 'over_image'){
			$url = new KBUrl();
			
			ob_start();
			?>
			<div class="kboard-attr-row kboard-attr-over-image">
				<label class="attr-name" for="kboard_attach_over_image">오버레이</label>
				<div class="attr-value">
					<?php if(isset($content->attach->over_image)):?><?php echo $content->attach->over_image[1]?> - <a href="<?php echo $url->getDeleteURLWithAttach($content->uid, 'over_image');?>" onclick="return confirm('<?php echo __('Are you sure you want to delete?', 'kboard')?>');"><?php echo __('Delete file', 'kboard')?></a><?php endif?>
					<input type="file" id="kboard_attach_over_image" name="kboard_attach_over_image" accept="image/*">
					<div class="description">※ 오버레이 이미지는 리스트의 썸네일에 마우스 오버시 보여지는 이미지입니다.</div>
				</div>
			</div>
			<?php
			$field_html = ob_get_clean();
		}
		
		return $field_html;
	}
}