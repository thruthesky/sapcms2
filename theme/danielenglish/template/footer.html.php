<?php
add_css();
?>
<?php 
//temporary solution
if( $_SERVER['REQUEST_URI'] == '/' ){ ?>
<div class='bottom-icon-menus'>
	<div class='inner'>
		<div class='item talk'>
			<a href='/ve?page=solution' class='image'>
				<img class='default' src='/theme/danielenglish/img/book.png'/>
				<img class='active' src='/theme/danielenglish/img/book-active.png'/>
			</a>
			<div class='label'>강의실입장</div>
		</div>
		<div class='item grad'>
			<a href='/ve?page=reservation' class='image'>
				<img class='default' src='/theme/danielenglish/img/grad.png'/>
				<img class='active' src='/theme/danielenglish/img/grad-active.png'/>
			</a>
			<div class='label'>예약된 수업</div>
		</div>
		<div class='item date'>		
			<a href='/ve?page=past' class='image'>
				<img class='default' src='/theme/danielenglish/img/camp.png'/>
				<img class='active' src='/theme/danielenglish/img/camp-active.png'/>
			</a>
			<div class='label'>지난 수업</div>
		</div>
		<div class='item price'>
			<a href='/camp/3' class='image'>
				<img class='default' src='/theme/danielenglish/img/price.png'/>
				<img class='active' src='/theme/danielenglish/img/price-active.png'/>
			</a>
			<div class='label'>수업 비용 안내</div>
		</div>
		<div class='item blog'>
			<a href='/post/list?id=qna' class='image'>
				<img class='default' src='/theme/danielenglish/img/blog.png'/>
				<img class='active' src='/theme/danielenglish/img/blog-active.png'/>
			</a>
			<div class='label'>질문답변</div>
		</div>
		<div class='item gallery'>
			<a href='/post/list?id=story' class='image'>
				<img class='default' src='/theme/danielenglish/img/gallery.png'/>
				<img class='active' src='/theme/danielenglish/img/gallery-active.png'/>
			</a>
			<div class='label'>수강 후기</div>
		</div>
	</div>
</div>
<?php } ?>
<div class='grid3'>
	<div class='content footer-menu'>
		<div class='a'>
			<div class='footer-list menus'>
				<div class='footer-list-title'>
					빠른메뉴
				</div>			
				<ul>
					<li><a href="/">홈</a></li>
					<li><a href="/introduction/1">인사말</a></li>
					<li><a href="/gallery/2">어린이영어</a></li>
					<li><a href="/gallery/4">기초 영어 회화</a></li>
					<li><a href="/gallery/5">비지니스 영어</a></li>
					<li><a href="/post/list?id=qna">질문과 답변</a></li>
					<li><a href="/ve">선생님 목록</a></li>
				</ul>
			</div>
		</div>
		<div class='b'>
			<div class='footer-list address'>
				<div class='footer-list-title'>
					연락처
				</div>
				
				<div class='row'>
					<b>화상 센터</b>
					2nd Floor Galang Wong Building,<br>
					Salome Rd, Balibago<br>
					Pampanga.
				</div>
				<div class='row'>
					<b>전화번호</b>
					<?php echo $phone_number?><br>
				</div>
				<div class='row'>
					<b>계좌번호</b>
					농협<br>
					예금주:안준홍<br>
 					302 1023 8271 21<br>
				</div>
			</div>
		</div>
		<div class='c'>
			<div id='contactUs' class='footer-list contact'>
				<div class='footer-list-title'>
					문의하기
				</div>
				<form class='contact-us' action='/contactUs/messageSendSubmit'>
					<!--<input type='hidden' name='user_id_to' value='admin'>-->
					<input type='text' name='name' placeholder='이름'>
					<input type='email' name='email' placeholder='이메일'>
					<input type='text' name='title' placeholder='제목'>
					<textarea name='content' placeholder='본문'></textarea>
					<input type='submit' value='전송'>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="copyright">
	Copyright (C) 2013 ~ <?=date('Y')?> 잉글리쉬월드. All Rights Reserved <br>
</div>

