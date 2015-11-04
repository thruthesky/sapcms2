<?php
$page = $_GET['page'];

?>
<div class='temp-page'>

	<a href="/ve?page=teacher_list">선생님 목록</a> |
	<a href="/ve?page=reservation">예약된 수업 시간표</a> |
	<a href="/ve?page=past">지난 수업</a> |
	<a href="/ve?page=solution">강의실 입장</a>

	<iframe src="http://wooree.begin.kr/iframe_login.php?id=<?php echo login('id')?>&classid=solution&page=<?php echo $page?>" width="100%" height="2600" style="border:0;"></iframe>

</div>