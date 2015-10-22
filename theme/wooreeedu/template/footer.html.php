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
			<div class='label'>LANGUAGE COURSES</div>
		</div>
		<div class='item grad'>
			<a href='/junior' class='image'>
				<img class='default' src='/theme/wooreeedu/img/grad.png'/>
				<img class='active' src='/theme/wooreeedu/img/grad-active.png'/>
			</a>
			<div class='label'>JUNIOR PROGRAMS</div>
		</div>
		<div class='item date'>		
			<a href='/camp' class='image'>
				<img class='default' src='/theme/wooreeedu/img/date.png'/>
				<img class='active' src='/theme/wooreeedu/img/date-active.png'/>
			</a>
			<div class='label'>CAMP</div>
		</div>
		<div class='item price'>
			<a href='/course/trainingCost' class='image'>
				<img class='default' src='/theme/wooreeedu/img/price.png'/>
				<img class='active' src='/theme/wooreeedu/img/price-active.png'/>
			</a>
			<div class='label'>TRAINING COST</div>
		</div>
		<div class='item blog'>
			<a href='http://phil_n_kor.blog.me/' class='image'>
				<img class='default' src='/theme/wooreeedu/img/blog.png'/>
				<img class='active' src='/theme/wooreeedu/img/blog-active.png'/>
			</a>
			<div class='label'>BLOG</div>
		</div>
		<div class='item gallery'>
			<a href='/gallery' class='image'>
				<img class='default' src='/theme/wooreeedu/img/gallery.png'/>
				<img class='active' src='/theme/wooreeedu/img/gallery-active.png'/>
			</a>
			<div class='label'>GALLERY</div>
		</div>
	</div>
</div>
<?php } ?>
<section class='grid3'>
	<div class='content footer-menu'>
		<div class='a'>
			<div class='footer-list menus'>
				<div class='footer-list-title'>
					QUICK <b>LINKS</b>
				</div>			
				<ul>
					<li><a href="/">Home</a></li>
					<li><a href="/introduction">Schools Introduction</a></li>
					<li><a href="/course">College / Adult Training</a></li>
					<li><a href="/junior">Junior Training</a></li>
					<li><a href="/camp">Junior Camp</a></li>					
					<li><a href="/gallery">Gallery</a></li>
					<li><a href="/ve">Video English</a></li>
				</ul>
			</div>
		</div>
		<div class='b'>
			<div class='footer-list address'>
				<div class='footer-list-title'>
					KEEP <b>IN TOUCH</b>
				</div>
				
			<table cellpadding=0 cellspacing=0 width='100%'>
				<tr valign='top'>
					<td><b>Address:</b></td>
					<td width='99%'>
						#577 Suntrade Bldg,</br>
						Alabang-Zapote Rd,</br>
						Almanza, Las Pinas city</br>
					</td>
				</tr>
			</table>
			<table cellpadding=0 cellspacing=0 width='100%'>
				<tr valign='top'>
					<td><b>Landline No:</b></td>
					<td width='99%'>553-4298</td>
				</tr>
			</table>
			<table cellpadding=0 cellspacing=0 width='100%'>
				<tr valign='top'>
					<td><b>Cellphone:</b></td>
					<td width='99%'>
						0915-469-7300 /</br>
						0917-508-077
					</td>
				</tr>
			</table>
			<table cellpadding=0 cellspacing=0 width='100%'>
				<tr valign='top'>
					<td><b>Internet Phone:</b></td>
					<td width='99%'>+82 70 7893 1741</td>
				</tr>
			</table>
			<table cellpadding=0 cellspacing=0 width='100%'>
				<tr valign='top'>
					<td><b>Email:</b></td>
					<td width='99%'>
						multilanguageschool@gmail.com</br>
						mlpschool@naver.com
					</td>
				</tr>
			</table>
			<!--
			<div class='social-links'>
				<img src='/theme/wooreeedu/img/fb.png'/>			
				<img src='/theme/wooreeedu/img/twitter.png'/>
				<img src='/theme/wooreeedu/img/naver.png'/>
			</div>
			-->
			</div>
		</div>
		<div class='c'>
			<div id='contactUs' class='footer-list contact'>
				<div class='footer-list-title'>
					<b>CONTACT</b> US
				</div>
				<form class='contact-us' action='/contactUs/messageSendSubmit'>
					<!--<input type='hidden' name='user_id_to' value='admin'>-->
					<input type='text' name='name' placeholder='Name'>
					<input type='email' name='email' placeholder='Email Address'>
					<input type='text' name='title' placeholder='Subject'>
					<textarea name='content' placeholder='Message'></textarea>
					<input type='submit' value='Submit'>
				</form>
			</div>
		</div>
	</div>
</section>
<div class="copyright">
	Copyright © 2015 Multi Language Power e-Center. All Rights Reserved <br>
	Powered by: <b>Wooreeedu Inc.</b>
</div>

