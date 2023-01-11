<!--Underscore Templates-->
<script type="text/template" id="tmpl-load-measurement-asset">
<div class="tg-displaybox">
	<i class="tg-deleteicon delete_asset fa fa-trash-o"></i>
	<div class="measurement_assets_img">   
		<figure><img width="171" height="171" src="{{data.url}}" alt="<?php esc_html_e('Measurement','tailors-online');?>"></figure>
	</div>
	<div class="tg-radioandtitle">
		<span class="tg-radio">
			<input type="radio" id="measurement_default_{{data.asset_counter}}" name="measurement[assets][default]" value="{{data.asset_counter}}">
			<label for="measurement_default_{{data.asset_counter}}" title="<?php esc_html_e('Set as Default','tailors-online');?>"></label>
		</span>
		<input type="text" name="measurement[assets][data][{{data.asset_counter}}][image_title]" class="tg-formcontrol" placeholder="<?php esc_html_e('Add title','tailors-online');?>">
		<input type="hidden" name="measurement[assets][data][{{data.asset_counter}}][media_id]" value="{{data.id}}">
		<input type="hidden" name="measurement[assets][data][{{data.asset_counter}}][media_url]" value="{{data.url}}">
	</div>
</div>
</script>