<?php
add_css();
if( empty( $_GET['page'] ) ) $page = 'teacher_list';
else $page = $_GET['page'];
?>
<div class='temp-page videoEnglish'>
	<div class='menu'>
		<a <?php echo $page == 'teacher_list' ? "class='is-active'":'' ?> href="/ve?page=teacher_list">선생님 목록</a><a <?php echo $page == 'reservation' ? "class='is-active'":'' ?>  href="/ve?page=reservation">
		예약된 수업 시간표</a><a <?php echo $page == 'past' ? "class='is-active'":'' ?>  href="/ve?page=past">
		지난 수업</a><a <?php echo $page == 'solution' ? "class='is-active'":'' ?>  href="/ve?page=solution">
		강의실 입장</a>
	</div>
	<iframe src="http://wooree.begin.kr/iframe_login.php?id=<?php echo login('id')?>&classid=solution&page=<?php echo $page?>" width="100%" height="2600" style="border:0;"></iframe>

</div>