<?php
add_css();

extract( $variables );
add_css('featured.item.css');
?>
<div class='top-menu'>
	<div class='inner clearfix'>
		<div class='left'>
			<a href='/'>홈</a><span class='bullet'>•</span>
			<!--<a href='#'>우리에듀 소개</a><span class='bullet'>•</span>-->
			<a href='/post/list?id=qna'>질문하기</a><span class='bullet'>•</span>
			<a href='/gallery/1'>수업과정</a><span class='bullet'>•</span>
			<a href='/junior/1'>레벨테스트</a><span class='bullet'>•</span>
			<a href='/ve?page=teacher_list'>선생님목록</a>
		</div>
		<div class='right'>
			<?php
				$user_idx = login('idx');
				if( $user_idx == 1 ){ ?>
				<a href='/post/reportList'>Reports</a>
				<span class='bullet'>•</span>
				<a href='/message'>Messages</a>
				<span class='bullet'>•</span>
			<?php 				
			}
				if( empty( $user_idx ) ){
			?>
				<a href='/user/register'>회원가입</a>
				<span class='bullet'>•</span>			
				<a href='/user/login'>로그인</a>
			<?php } else { ?>
                    <a href="/ve?page=solution"><b style="color:#dd3438;">강의실입장</b></a>
                    <span class='bullet'>•</span>
                    <a href='/user/profile'>나의 정보</a>
                    <span class='bullet'>•</span>
				<a href='/user/logout'>로그아웃</a>
			<?php } ?>
		</div>
	</div>
</div>
<div id="header-top">
	<div class='inner'>
		<a href="/"><img class='logo' src="/theme/englishworld/img/full_logo.png"/></a>
		<ul id="main-menu" class="clearfix">
			<li><a <?php if( !empty( $page ) && $page == 'introduction' ) echo "class='is-active'"; ?> href='/introduction/1'>학원소개</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'videoEnglish' ) echo "class='is-active'"; ?> href='/ve?page=teacher_list'>강사목록</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'junior' ) echo "class='is-active'"; ?> href='/junior/1'>무료체험</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'camp' ) echo "class='is-active'"; ?> href='/camp/1'>수업신청</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'gallery' ) echo "class='is-active'"; ?> href='/gallery/1'>교육과정</a></li>
			<li><a <?php if( !empty( $page ) && strpos( $page, "post." ) !== false || !empty( $page ) && $page == 'post' ) echo "class='is-active'"; ?> href='/post/list?id=qna'>고객센터</a></li>
			<!--<li><a class='contactUs' href='#'>Contact Us</a></li>-->
		</ul>
		<div class='sub-menu'>
			<div class='inner clearfix'>
				<div class='featuredPost'>
					<div class='page-navigator'>
				<?php
					for( $i = 1; $i<=5; $i++ ){
						if( $i == 1 ) $is_active = ' is-active';
						else $is_active = null;
						echo "<div class='page-item$is_active' page='$i'></div>";
					}
				?>
				</div>
					<div class='inner'>
						<div class='item fake'><div class='banner'><img src='/theme/englishworld/img/menu_photo_5.jpg'/></div><div class='title text-center'>화상 콜센터 영어 수업</div></div><div class='item'><!--this is a fake banner 화상 콜센터 단합대회-->
						<div class='banner'><img src='/theme/englishworld/img/menu_photo_1.jpg'/></div><div class='title text-center'>선생님 노래자랑</div></div><div class='item'>
						<div class='banner'><img src='/theme/englishworld/img/menu_photo_2.jpg'/></div><div class='title text-center'>화상 콜센터 바다 여행</div></div><div class='item'>
						<div class='banner'><img src='/theme/englishworld/img/menu_photo_4.jpg'/></div><div class='title text-center'>화상 콜센터 시상식</div></div><div class='item'>
						<div class='banner'><img src='/theme/englishworld/img/menu_photo_3.jpg'/></div><div class='title text-center'>화상 콜센터 파티</div></div><div class='item'>
						<div class='banner'><img src='/theme/englishworld/img/menu_photo_5.jpg'/></div><div class='title text-center'>화상 콜센터 영어 수업</div></div><div class='item fake'>
						<div class='banner'><img src='/theme/englishworld/img/menu_photo_1.jpg'/></div><div class='title text-center'>선생님 노래자랑</div></div><!--this is a fake banner  화상 콜센터 팝송 노래-->
					</div>
				</div>
				<div class='item-list text-center'>
					<table cellpadding=0 cellspacing=0>
						<tr valign='top'>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/introduction/1">인사말</a></li>
										<li><a href="/introduction/3">처음 오신분</a></li>
										<li><a href="/introduction/4">화상 콜센터</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/ve?page=teacher_list">선생님 목록</a></li>
										<li><a href="/ve?page=reservation">수업 시간표</a></li>
										<li><a href="/ve?page=past">수업 평가</a></li>
										<li><a href="/ve?page=solution">강의실 입장</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/junior/1">무료체험 신청</a></li>
										<li><a href="/junior/3">무료체험 진행</a></li>
										<li><a href="/ve?page=past">무료체험 결과</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/camp/1">수업 신청 안내</a></li>
										<li><a href="/camp/3">수업료 안내</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/gallery/1">교육과정</a></li>
										<li><a href="/gallery/2">파닉스 영어</a></li>
										<!--<li><a href="/gallery/3">어린이 영어</a></li>-->
										<li><a href="/gallery/4">기초 영어 회화</a></li>
										<li><a href="/gallery/5">비지니스 영어</a></li>
										<li><a href="/gallery/6">읽기/독해</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/post/list?id=qna">질문과답변</a></li>
										<li><a href="/post/list?id=story">수업후기</a></li>
										<li><a href="/post/list?id=reminder">공지사항</a></li>
										<li><a href="/forum/1">전화 상담 안내</a></li>
									</ul>
								</div>
							</td>
						</tr>
					</table>
				</div><!--/item-list-->
			</div><!--/inner-->
		</div><!--/sub-menu-->
	</div>
</div>
<?php 
if( !empty( $variables['page'] )  ){
	$page = $variables['page'];
	$text = null;
	if( strpos( $page, "post." ) !== false ) {
		$page = 'post';
		//$text = "<a href='/post/list?id=".post_config()->getCurrent()->id."'>".post_config()->getCurrent()->name."</a>";
		$text = '';
	}
	else{
		if( !empty( $variables['header_text'] ) ) $text = $variables['header_text'];
		//$text = strtoupper($varia);
	}
	$url = "/theme/englishworld/img/header_".$page .".jpg";
	//$url = "/theme/englishworld/img/header_text.png";
	//if( file_exists( $url ) ){
	?>
	<div class='header-image<?php if( !empty( $page ) ) echo ' '.$page; ?>'>
		<img src='<?php echo $url; ?>'/>
		<div class='label'>
			<div class='inner'>
				<?php if( !empty( $text ) ) { ?>
				<div class='text'>
					<?php echo $text; ?>
					<div class='bottom_bar'></div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php 
	//}
} 
?>
<?php 
//temporary solution
if( $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/?' ){ ?>
<div class="front-top-banner">
	<div class='arrow' direction='left'>
		<img src="/theme/englishworld/img/top_arrow_left.png"/>
	</div>
	<div class='arrow' direction='right'>
		<img src="/theme/englishworld/img/top_arrow_right.png"/>
	</div>
	<div class='inner'>
		<div class='banner-wrapper five'>
			<img class='banner fake' src='/theme/englishworld/img/banner_5.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
						<div class='text top'>2015년 주니어 겨울 영어 캠프</div><br>
						<div class='text bottom'>즐거운 방학, 파인스 영어와 함께 영어 정복을 할 주니어 학생을 모집합니다.</div><br>
						<!--
						<div class='text top'>방문과외전문 + 화상영어</div><br>
                        <div class='text bottom'>화상영어와 방문과외로 두 마리 토끼(내신과 회화)를 다 잡는 국내 유일의 교육 전문 업체!</div><br>
						-->
                        <div class='text more'><a href="/introduction/1">자세히 보기<div class='triangle'></div></a></div>
					</div>
				</div>
			</div>
		</div><div class='banner-wrapper one '>
			<img class='banner' src='/theme/englishworld/img/banner_1.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
                        <div class='text top'>방문과외전문 + 화상영어</div><br>
						<div class='text bottom'>
							화상영어와 방문과외로 두 마리 토끼(내신과 회화)를 다 잡는 국내 유일의 교육 전문 업체!<br>
							<div style="font-size:84%; padding-top:0.6em;">
							영어에 가장 많은 시간을 들이고 있는데도 121등인 우리나라와 세계3위인 핀란드, 생각해 보셨나요?<br>
							생각(일본식)을 바꾸면 방법이 보이고, 방법을 바꾸면 우리도 달라질 수 있습니다.<br>
							영어가 언어가 되려면 원어민과 매일 문법적인 대화를 하는 것이 <b style="color:red;">유일한 해결책과 방법입니다.</b><br>
							화상만으로는 놓치거나 부족한 부분이 많이 있는데, 방문교사가 부족한 부분을 해결해주는 잉글리쉬월드
							</div>
						</div><br>


						<div class='text more'><a href="/introduction/1">자세히 보기<div class='triangle'></div></a></div>
					</div>
				</div>
			</div>
		</div><div class='banner-wrapper two'>
			<img class='banner' src='/theme/englishworld/img/banner_2.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
						<img class='fake-image' src='/theme/englishworld/img/banner_fake_image_perfect_sides.png'/>
						<div class='text-items'>
							<div class='text top'>대한민국 영어 121등 ??</div>
							<div class='text bottom'>매일 원어민과 화상영어를 통해서 121등에서 1등 영어를 하십시오.</div>
                            <div class='text more'><a href="/introduction/3">자세히 보기<div class='triangle'></div></a></div>
						</div>
					</div>
				</div>
			</div>
		</div><div class='banner-wrapper three'>
			<img class='banner' src='/theme/englishworld/img/banner_3.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
						<div class='text top'>잉글리쉬월드의 자랑. 최고의 화상영어 선생님과 알찬 수업 과정.</div><br>
						<div class='text bottom'>품격, 자질, 교육 !! 모든 면에서 뛰어난 잉글리쉬월드 화상 콜센터 선생님을 만나보세요.</div><br>
						<div class='text more'><a href='/ve?page=teacher_list'>자세히 보기<div class='triangle'></div></a></div>
					</div>
				</div>
			</div>
		</div><div class='banner-wrapper four'>
			<img class='banner' src='/theme/englishworld/img/banner_4.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
						<div class='text top'>영어는 암기가 아닌 생활 습관! 지겨운 공부는 시간 낭비!</div><br>
						<div class='text bottom'>잉글리쉬월드 화상영어로 진정한 배움의 시간을 가지세요.</div><br>
						<div class='text more'><a href='/junior/1'>무료 체험 설명</a></div>
					</div>
				</div>
			</div>
		</div><div class='banner-wrapper five'>
			<img class='banner' src='/theme/englishworld/img/banner_5.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
						<div class='text top'>2015년 주니어 겨울 영어 캠프</div><br>
						<div class='text bottom'>즐거운 방학, 파인스 영어와 함께 영어 정복을 할 주니어 학생을 모집합니다.</div><br>
						<div class='text more'><a href="http://pineseg.com/pinesjr/event_camp.html" target="_blank">자세히 보기<div class='triangle'></div></a></div>
					</div>
				</div>
			</div>
		</div><div class='banner-wrapper one'>
			<img class='banner fake' src='/theme/englishworld/img/banner_1.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
						<div class='text top'>방문과외전문 + 화상영어</div><br>
						<div class='text bottom'>화상영어와 방문과외로 두 마리 토끼(내신과 회화)를 다 잡는 국내 유일의 교육 전문 업체!</div><br>
						<!--
                        <div class='text top'>방문과외전문 + 화상영어</div><br>
						<div class='text bottom'>배움의 지름길 우리에듀!</div><br>
						-->
						<div class='text more'>자세히 보기<div class='triangle'></div></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>