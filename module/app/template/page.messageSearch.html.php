<?php
if( !empty( $data['show'] ) ) $show = $data['show'];
else $show =null;

if( !empty( $data['extra'] ) ) $extra = $data['extra'];
else $extra =null;

if( !empty( $data['keyword'] ) ) $keyword = $data['keyword'];
else $keyword = null;
?>
<div class='message-search-wrapper'>
	<form class='checkbox-form'>
		<input type='hidden' name='idx' value="">
	</form>
	<input type='hidden' name='idx' value="">
	<form class='message-search'>
		<input type='hidden' name='show' value='<?php echo $show ?>'/>
		<input type='hidden' name='extra' value='<?php echo $extra ?>'/>
		<table>
			<tr>
				<td class='remove-on-expand'>
					<div class='sprite check_box'></div>					
				</td>
				<td class='remove-on-expand'>
					<div class='sprite delete'></div>
				</td>				
				<td class='remove-on-expand'>
					<div class='mark-as-read'>Mark as Read</div>
				</td>
				<td width='99%'>
					<input type='text' name='keyword' value ='<?php echo $keyword ?>' />
				</td>
				<td>
					<input type='image' src='<?php echo sysconfig(URL_SITE) ?>module/app/img/search.png'>
				</td>
			</tr>
		</table>
	</form>
</div>