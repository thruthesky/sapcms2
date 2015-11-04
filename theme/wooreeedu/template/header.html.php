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
			<a href='/studyAbroad'>교육 프로그램</a><span class='bullet'>•</span>
			<a href='/ve'>화상영어</a><span class='bullet'>•</span>
			<a href='/paymentInfo'>수업료 납부 안내</a>
		</div>
		<div class='right'>
			<?php 
				$user_idx = login('idx');
				if( empty( $user_idx ) ){
			?>
				<a href='/user/register'>회원가입</a>
				<span class='bullet'>•</span>			
				<a href='/user/login'>로그인</a>
			<?php } else { ?>
				<a href='/user/profile'>나의 정보</a>
				<span class='bullet'>•</span>
				<a href='/user/logout'>로그아웃</a>
			<?php } ?>
		</div>
	</div>
</div>
<div id="header-top">
	<div class='inner'>
		<a href="/"><img class='logo' src="/theme/wooreeedu/img/full_logo.png"/></a>
		<ul id="main-menu" class="clearfix">
			<li><a <?php if( !empty( $page ) && $page == 'introduction' ) echo "class='is-active'"; ?> href='/introduction'>학원소개</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'course' ) echo "class='is-active'"; ?> href='/course'>어학연수</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'junior' ) echo "class='is-active'"; ?> href='/junior'>조기유학</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'camp' ) echo "class='is-active'"; ?> href='/camp'>단기캠프</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'gallery' ) echo "class='is-active'"; ?> href='/gallery'>프로그램</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'videoEnglish' ) echo "class='is-active'"; ?> href='/ve?page=teacher_list'>화상영어</a></li>
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
						<div class='item fake'><div class='banner'><img src='/theme/wooreeedu/img/menu_photo_5.jpg'/></div><div class='title text-center'>영어세미나</div></div><div class='item'>
						<div class='banner'><img src='/theme/wooreeedu/img/menu_photo_1.jpg'/></div><div class='title text-center'>노래자랑</div></div><div class='item'>
						<div class='banner'><img src='/theme/wooreeedu/img/menu_photo_2.jpg'/></div><div class='title text-center'>바다 여행</div></div><div class='item'>
						<div class='banner'><img src='/theme/wooreeedu/img/menu_photo_4.jpg'/></div><div class='title text-center'>영어 말하기 대회 시상식</div></div><div class='item'>
						<div class='banner'><img src='/theme/wooreeedu/img/menu_photo_3.jpg'/></div><div class='title text-center'>크리스마스 파티</div></div><div class='item'>
						<div class='banner'><img src='/theme/wooreeedu/img/menu_photo_5.jpg'/></div><div class='title text-center'>영어 수업</div></div><div class='item fake'>
						<div class='banner'><img src='/theme/wooreeedu/img/menu_photo_1.jpg'/></div><div class='title text-center'>팝송 노래</div></div>
					</div>
				</div>
				<div class='item-list text-center'>
					<table cellpadding=0 cellspacing=0>
						<tr valign='top'>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/introduction/multiLanguage">우리에듀 소개</a></li>
										<li><a href="/introduction/multiLanguage_2">우리에듀 특징</a></li>
										<li><a href="/introduction/schoolDormitory">학원 기숙사</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/course/lecture">기업강의</a></li>
										<li><a href="/course/trainingCost">어학연수</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/junior/juniorEarlyStudy">조기유학</a></li>
										<li><a href="/junior/advantagesInPH">조기유학 장점</a></li>
										<li><a href="/junior/earlyCost">조기유학 비용</a></li>
										<li><a href="/junior/recommended">추천 학교</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/camp/campInformation">단기캠프 정보</a></li>
										<li><a href="/camp/schedule">단기캠프 일정</a></li>
										<li><a href="/camp/preparation">단기캠프 준비</a></li>
										<li><a href="/camp/weekendActivities">주말 여행</a></li>
										<li><a href="/camp/requirement">여권/비자/SSP</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/gallery/popsong">영어 노래 교실</a></li>
										<li><a href="/gallery/tripping">캠프 여행</a></li>
										<li><a href="/gallery/speech">영어 발표회</a></li>
										<li><a href="/gallery/xmas">크리스마스파티</a></li>
										<li><a href="/gallery/seminar">원어민 강의</a></li>
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
		$text = 'FORUM';
	}
	else{
		if( !empty( $variables['header_text'] ) ) $text = $variables['header_text'];
		//$text = strtoupper($varia);
	}
	$url = "/theme/wooreeedu/img/header_".$page .".jpg";
	//if( file_exists( $url ) ){
	?>
	<div class='header-image'>	
		<img src='<?php echo $url; ?>'/>
		<div class='label'>
			<?php if( !empty( $text ) ) { ?>
			<div class='text'>
				<?php echo $text; ?>
				<div class='bottom_bar'></div>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php 
	//}
} 
?>
<?php 
//temporary solution
if( $_SERVER['REQUEST_URI'] == '/' ){ ?>
<div class="front-top-banner">
	<div class='arrow' direction='left'>
		<img src="/theme/wooreeedu/img/top_arrow_left.png"/>
	</div>
	<div class='arrow' direction='right'>
		<img src="/theme/wooreeedu/img/top_arrow_right.png"/>
	</div>
	<div class='inner'>
		<div class='banner-wrapper five'>
			<img class='banner fake' src='/theme/wooreeedu/img/banner_5.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='text top'>읽고, 토론하며, 함께 배우는 우리에듀.</div><br>
					<div class='text bottom'>배움의 지름길 우리에듀</div><br>
					<div class='text more'>자세히 보기<div class='triangle'></div></div>
				</div>
				<?php /*
				<div class='inner'>
					<div class='text top'>우리에듀 홈페이지에 오신 것을 환영합니다.</div><br>
					<div class='text bottom'>배움의 지름길 우리에듀!</div><br>
					<div class='text more'>자세히 보기<div class='triangle'></div></div>
				</div>
				*/ ?>
			</div>
		</div><div class='banner-wrapper one '>
			<img class='banner' src='/theme/wooreeedu/img/banner_1.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='text top'>영어는 언어이며 소통! 각 나라의 친구와 함께!</div><br>
					<div class='text bottom'>배움의 지름길 우리에듀!</div><br>
					<div class='text more'>자세히 보기<div class='triangle'></div></div>
				</div>
			</div>
		</div><div class='banner-wrapper two'>
			<img class='banner' src='/theme/wooreeedu/img/banner_2.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
						<div class='text top'>어학연수, 단기 캠프, 조기유학</div><br>
						<div class='text bottom'>우리에듀와 함께 신나는 영어 공부를 합시다.</div><br>
						<div class='text more'><a href='#'>자세히 보기</a></div>
					</div>
				</div>
			</div>
		</div><div class='banner-wrapper three'>
			<img class='banner' src='/theme/wooreeedu/img/banner_3.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='text top'>우리에듀의 자랑. 멋진 선생님과 알찬 수업 과정.</div><br>
					<div class='text bottom'>새로운 친구들을 사귀어 보세요.</div><br>
					<div class='text more'>자세히 보기<div class='triangle'></div></div>
				</div>
			</div>
		</div><div class='banner-wrapper four'>
			<img class='banner' src='/theme/wooreeedu/img/banner_4.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
						<div class='text top'>영어공부는 암기가 아닌 생활 습관! 지겨운 공부는 시간 낭비!</div><br>
						<div class='text bottom'>우리에듀에서 진정한 배움의 시간을 가지세요.</div><br>
						<div class='text more'><a href='#'>자세히 보기</a></div>
					</div>
				</div>
			</div>
		</div><div class='banner-wrapper five'>
			<img class='banner' src='/theme/wooreeedu/img/banner_5.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='text top'>읽고, 토론하며, 함께 배우는 우리에듀.</div><br>
					<div class='text bottom'>배움의 지름길 우리에듀</div><br>
					<div class='text more'>자세히 보기<div class='triangle'></div></div>
				</div>
			</div>
		</div><div class='banner-wrapper one'>
			<img class='banner fake' src='/theme/wooreeedu/img/banner_1.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='text top'>영어는 언어이며 소통! 각 나라의 친구와 함께!</div><br>
					<div class='text bottom'>배움의 지름길 우리에듀!</div><br>
					<div class='text more'>자세히 보기<div class='triangle'></div></div>
				</div>
				<?php /*
				<div class='inner'>					
					<div class='text top'>지금 바로 문의 해 주세요!</div><br>
					<div class='text bottom'>우리에듀</div><br>
					<div class='text more'>자세히 보기<div class='triangle'></div></div>
				</div>
				*/ ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>