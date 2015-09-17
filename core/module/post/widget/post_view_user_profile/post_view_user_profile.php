<?php
add_css();
/**
 * @input array $widget['post'] is the Array of post or comment.
 */

$post = & $widget['post'];
$idx_user = $post['idx_user'];
if( $idx_user == 0 ) $idx_user = 1;
$user = user()->load( $idx_user )->fields;
if( !empty( $user ) ){
	if( empty( $user['country'] ) ) $location = "No Location";
	else $location = $user['country'];
	
	$fans = "XX fans";

	$date = date( "M d, Y", $post['created'] );
	
	$id = $user['id'];	
	
	$primary_photo = data()->loadBy('user', 'primary_photo', $idx_user);
	if( !empty( $primary_photo ) ) $primary_photo = $primary_photo[0]->urlThumbnail(140,140);
	
	function humanTiming( $stamp )
	{
		$period = NULL;
		$secsago   =   time() - $stamp;
		
		if ($secsago < 60) {
			$w1 = "second";
			$w2 = "seconds";
			$period = $secsago == 1 ? '1 ' . $w1    : $secsago . " " . $w2 ;
		}
		else if ($secsago < 3600) {
			$w1 = "minute";
			$w2 = "minutes";
			$period    =   round($secsago/60);
			$period    =   $period == 1 ? '1 ' . $w1 : $period . " " . $w2;
		}
		else if ($secsago < 86400) {
			$w1 = "hour";
			$w2 = "hours";
			$period    =   round($secsago/3600);
			$period    =   $period == 1 ? '1 ' . $w1   : $period . " " .  $w1;
		}
		else if ($secsago < 604800) {
			$w1 = "day";
			$w2 = "days";
			$period    =   round($secsago/86400);
			$period    =   $period == 1 ? '1 '. $w1    : $period . " " . $w2;
		}
		else if ($secsago < 2419200) {
			$w1 = "week";
			$w2 = "weeks";
			$period    =   round($secsago/604800);
			$period    =   $period == 1 ? '1 ' . $w1   : $period . " " . $w2;
		}
		else if ($secsago < 29030400) {
			$w1 = "month";
			$w2 = "months";
			$period    =   round($secsago/2419200);
			$period    =   $period == 1 ? '1 ' . $w1   : $period . " " . $w2;
		}
		else {
			$w1 = "year";
			$w2 = "years";
			$period    =   round($secsago/29030400);
			$period    =   $period == 1 ? '1 ' . $w1   : $period . " " . $w2;
		} 
		return $period;
	}
	
	$human_timing = humanTiming( $post['created'] );
?>
	<section class="user-profile">
		<table cellpadding=0 cellspacing=0 width='100%'>
			<tr>
				<td width='60'>
					<?php if( !empty( $primary_photo ) ){?>
						<div class='primary-photo'><img src='<?php echo $primary_photo; ?>'/></div>
					<?php } else {?>
						<div class='primary-photo temp'></div>
					<?php }?>
				</td>
				<td>
					<div class='info'>
						<div class='name'><?php echo $id; ?></div>
						<div class='date'><?php echo $date; ?> | <?php echo $human_timing; ?></div>
						<div class='location'><?php echo $location; ?> | <?php echo $fans; ?></div>
					</div>
				</td>
			</tr>
		</table>
	</section>
<?php
}
?>