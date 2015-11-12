<?php
add_css();
?>
<?php 
//temporary solution
if( $_SERVER['REQUEST_URI'] == '/' ){ ?>
<div class='bottom-icon-menus'>
	<div class='inner'>
		<div class='item talk'>
			<a href='/course/1' class='image'>
				<img class='default' src='/theme/englishworld/img/book.png'/>
				<img class='active' src='/theme/englishworld/img/book-active.png'/>
			</a>
			<div class='label'>수업 과정</div>
		</div>
		<div class='item grad'>
			<a href='/junior/1' class='image'>
				<img class='default' src='/theme/englishworld/img/grad.png'/>
				<img class='active' src='/theme/englishworld/img/grad-active.png'/>
			</a>
			<div class='label'>비지니스 영어</div>
		</div>
		<div class='item date'>		
			<a href='/camp/1' class='image'>
				<img class='default' src='/theme/englishworld/img/camp.png'/>
				<img class='active' src='/theme/englishworld/img/camp-active.png'/>
			</a>
			<div class='label'>어린이 영어</div>
		</div>
		<div class='item price'>
			<a href='/course/2' class='image'>
				<img class='default' src='/theme/englishworld/img/price.png'/>
				<img class='active' src='/theme/englishworld/img/price-active.png'/>
			</a>
			<div class='label'>수업 비용 안내</div>
		</div>
		<div class='item blog'>
			<a href='http://phil_n_kor.blog.me/' class='image'>
				<img class='default' src='/theme/englishworld/img/blog.png'/>
				<img class='active' src='/theme/englishworld/img/blog-active.png'/>
			</a>
			<div class='label'>질문답변</div>
		</div>
		<div class='item gallery'>
			<a href='/gallery/1' class='image'>
				<img class='default' src='/theme/englishworld/img/gallery.png'/>
				<img class='active' src='/theme/englishworld/img/gallery-active.png'/>
			</a>
			<div class='label'>사진 갤러리</div>
		</div>
	</div>
</div>
<?php } ?>
<section class='grid3'>
	<div class='content footer-menu'>
		<div class='a'>
			<div class='footer-list menus'>
				<div class='footer-list-title'>
					빠른메뉴
				</div>			
				<ul>
					<li><a href="/">홈</a></li>
					<li><a href="/introduction">인사말</a></li>
					<li><a href="/junior">어린이영어</a></li>
					<li><a href="/course">기초 영어 회화</a></li>
					<li><a href="/camp">비지니스 영어</a></li>
					<li><a href="/gallery">사진갤러리</a></li>
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
					<b>메일주소</b>
					hanmun777@naver.com<br>
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
</section>
<div class="copyright">
	Copyright (C) 2013 ~ <?=date('Y')?> 잉글리쉬월드. All Rights Reserved <br>
</div>

