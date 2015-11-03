<?php
add_css();
?>
<?php 
//temporary solution
if( $_SERVER['REQUEST_URI'] == '/' ){ ?>
<div class='bottom-icon-menus'>
	<div class='inner'>
		<div class='item talk'>
			<a href='/course' class='image'>
				<img class='default' src='/theme/wooreeedu/img/talk.png'/>
				<img class='active' src='/theme/wooreeedu/img/talk-active.png'/>
			</a>
			<div class='label'>수업 과정</div>
		</div>
		<div class='item grad'>
			<a href='/junior' class='image'>
				<img class='default' src='/theme/wooreeedu/img/grad.png'/>
				<img class='active' src='/theme/wooreeedu/img/grad-active.png'/>
			</a>
			<div class='label'>쥬니어 과정</div>
		</div>
		<div class='item date'>		
			<a href='/camp' class='image'>
				<img class='default' src='/theme/wooreeedu/img/date.png'/>
				<img class='active' src='/theme/wooreeedu/img/date-active.png'/>
			</a>
			<div class='label'>영어 캠프</div>
		</div>
		<div class='item price'>
			<a href='/course/trainingCost' class='image'>
				<img class='default' src='/theme/wooreeedu/img/price.png'/>
				<img class='active' src='/theme/wooreeedu/img/price-active.png'/>
			</a>
			<div class='label'>연수 비용 안내</div>
		</div>
		<div class='item blog'>
			<a href='http://phil_n_kor.blog.me/' class='image'>
				<img class='default' src='/theme/wooreeedu/img/blog.png'/>
				<img class='active' src='/theme/wooreeedu/img/blog-active.png'/>
			</a>
			<div class='label'>블로그</div>
		</div>
		<div class='item gallery'>
			<a href='/gallery' class='image'>
				<img class='default' src='/theme/wooreeedu/img/gallery.png'/>
				<img class='active' src='/theme/wooreeedu/img/gallery-active.png'/>
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
					<li><a href="/course">연수 / 성인과정</a></li>
					<li><a href="/junior">주니어 과정</a></li>
					<li><a href="/camp">주니어 캠프</a></li>
					<li><a href="/gallery">사진갤러리</a></li>
					<li><a href="/ve">화상영어</a></li>
				</ul>
			</div>
		</div>
		<div class='b'>
			<div class='footer-list address'>
				<div class='footer-list-title'>
					연락처
				</div>
				
				<div class='row'>
					<b>오시는 길</b>
					#577 Suntrade Bldg,<br>
					Alabang-Zapote Rd,<br>
					Almanza, Las Pinas city
				</div>
				<div class='row'>
					<b>전화번호</b>
					553-4298<br>
					+63 0915-469-7300<br>
					+63 0917-508-077<br>
					+82 70 7893 1741<br>
				</div>
				<div class='row'>
					<b>메일주소</b>
					multilanguageschool@gmail.com<br>
					mlpschool@naver.com 
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
	Copyright (C) 2013 ~ <?=date('Y')?> 우리에듀. All Rights Reserved <br>
</div>

