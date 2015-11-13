<?php
	add_css('member.css');
	$user = login();
	if( empty( $user ) ) $submit_text = "회원 가입";
	else $submit_text = "회원 정보 수정";
?>

<div class='member-form-wrapper register englishworld'>
	<div class='title'><?php echo $submit_text; ?></div>
	<form class="member-register-form member-form ajax-file-upload" method="post" enctype="multipart/form-data">
		<input type="hidden" name="file_module" value="user">
        <input type="hidden" name="file_type" value="primary_photo">
        <input type="hidden" name="file_idx_target" value="<?php echo login('idx')?>">
        <input type="hidden" name="file_unique" value="1">
        <input type="hidden" name="file_finish" value="1">
        <input type="hidden" name="file_image_thumbnail_width" value="140">
        <input type="hidden" name="file_image_thumbnail_height" value="140">
        <input type="hidden" name="file_callback" value="callback_user_primary_photo_upload">
	<?php

		if( !empty( $variables['user'] ) ){
			echo "<h1>Admin Edit mode</h1>";
			echo html_hidden(['name'=>'idx', 'value'=>$variables['user']->get('idx')]);		
		}
	?>
        잉글리쉬월드 이용 약관
		<textarea style="margin-bottom:1.2em; width:100%; height:156px; box-sizing: border-box;">제1조(목적 등)
① 잉글리쉬 월드 원격영어교육 센터 서비스 약관(이하 "본 약관"이라 합니다)은 회원이 잉글리쉬 월드 원격영어교육 센터 (이하 "서비스제공자"라고 합니다)이 제공하는 잉글리쉬 월드 원격영어교육 센터 서비스(이하 "본 서비스"이라 합니다)를 이용함에 있어 "회원"과 "서비스제공자"의 권리·의무 및 책임사항을 규정함을 목적으로 합니다.

제2조(회원의 정의)
① "회원"이란 잉글리쉬 월드 원격영어교육 센터에 가입한 자로써, "잉글리쉬 월드 원격영어교육 센터"에 접속하여 본 약관에 따라 "본 교재를" 이용하여 서비스를 받는 자를 말합니다.

제3조(서비스의 제공 및 변경)
① "서비스제공자"는 "회원"에게 아래와 같은 서비스를 제공합니다.

1. 잉글리쉬 월드 원격영어교육 센터 화상/전화 영어 교재
2. 잉글리쉬 월드 원격영어교육 센터 화상/전화 영어 서비스
3. 기타 "서비스제공자"가 자체 개발하거나 다른 회사와의 협력계약 등을 통해 "회원"들에게 제공할 일체의 서비스

제4조(서비스의 중단)
① "서비스제공자"는 컴퓨터 등 정보통신설비의 보수점검·교체 및 고장, 통신의 두절 등의 사유가 발생한 경우에는 서비스의 제공을 일시적으로 중단할 수 있고, 새로운 서비스로의 교체 기타 "서비스제공자"가 적절하다고 판단하는 사유에 기하여 현재 제공되는 서비스를 완전히 중단할 수 있습니다.

② 제1항에 의한 서비스 중단의 경우에는 "서비스제공자"는 제7조 제2항에서 정한 방법으로 "회원"에게 통지합니다. 다만, "서비스제공자"가 통제할 수 없는 사유로 인한 서비스의 중단(시스템 관리자의 고의, 중과실이 없는 디스크 장애, 시스템 다운 등)으로 인하여 사전 통지가 불가능한 경우에는 그러하지 아니합니다.

제5조(회원 탈퇴 및 자격 상실 등)
① "회원"은 "서비스제공자"에 언제든지 자신의 회원등록을 말소해 줄 것("회원" 탈퇴)을 요청할 수 있으며 "서비스제공자"는 위 요청을 받은 즉시 해당 "회원"의 정보 말소를 위한 절차를 밟습니다

② "회원"이 다음 각 호의 사유에 해당하는 경우, "서비스제공자"는 "회원" 자격을 적절한 방법으로 제한 및 정지, 상실시킬 수 있습니다.

1. 개인정보를 허위로 기재한 경우
2. 다른 사람의 "서비스" 이용을 방해하거나 그 타인의 개인정보, 결제정보 등을 도용하는 등 전자거래 질서를 위협하는 경우
3. "서비스"를 이용하여 법령과 본 약관이 금지하거나 공서양속에 반하는 행위를 하는 경우

③ "서비스제공자"가 "회원"의 회원자격을 상실시키기로 결정한 경우에는 회원등록을 말소합니다. 이 경우 회원에게 회원등록 말소 전에 이를 통지하고, 소명할 기회를 부여합니다.

제6조(회원에 대한 통지)
① "서비스제공자"는 "본 서비스"에 대한 공지사항을 "회원"에게 "서비스제공자"가 부여한 메일주소로 할 수 있습니다.

② "서비스제공자"가 불특정다수 "회원"에 대한 통지를 하는 경우 칠(7)일이상 게시판에 공시함으로써 개별 통지에 갈음할 수 있습니다.

제7조(이용자의 개인정보보호)
① "본 서비스"에 등록된 ID를 잉글리쉬 월드 원격영어교육 센터이 관리합니다.

② "서비스제공자"는 관련법령이 정하는 바에 따라서 "회원"의 개인정보를 보호하기 위하여 노력합니다.(참고 "개인정보보호정책")

제8조(서비스제공자의 의무)
① "서비스제공자"는 법령과 본 약관이 금지하거나 공서양속에 반하는 행위를 하지 않으며 본 약관이 정하는 바에 따라 지속적이고, 안정적인 서비스를 제공하기 위해서 노력합니다.

② "서비스제공자"는 "회원"이 안전하게 인터넷 서비스를 이용할 수 있도록 "회원"의 개인정보(신용정보 포함)보호를 위한 보안 시스템을 구축합니다.

③ "서비스제공자"는 "회원"이 원하지 않는 영리목적의 광고성 전자우편을 발송하지 않습니다.

제9조 (이용대금의 결제)
① "회원"은 "본 서비스"의 이용대금의 지급방법으로 "잉글리쉬 월드 원격영어교육 센터"이 제공하는 지급방법 중 하나를 선택할 수 있습니다.

② "회원"이 대금지급을 위하여 "잉글리쉬 월드 원격영어교육 센터"이 정한 결제방법 중 신용카드나 화상를 통한 결제방법을 선택한 경우 신용카드번호 및 화상번호, 기타 결제의 이행을 위하여 필요한 개인정보를 정확하게 입력하여야 합니다. "잉글리쉬 월드 원격영어교육 센터"은 "회원"이 신용카드번호 및 화상번호 등을 허위 또는 부정확하게 입력함으로 인하여 "회원"에게 발생하는 손해에 대해 "잉글리쉬 월드 원격영어교육 센터"의 고의 또는 중과실이 없는 이상 책임을 부담하지 않습니다.

③ 가격이 저렴하기 때문에 회원은 다음 달 교재 대금을 계약 기간 만료 1주일(7일) 전에 입금해주셔야 합니다.

④ 회원의 명백한 탈퇴 의사가 없다면 자동으로 계약이 1개월 연장 됩니다. 계약이 연장된 후에 일어나는 모든 법적인 책임은 회원 당사자에게 있습니다.

제10조 (환급)
① "회원"이 "본 서비스"를 이용함에 있어 이미 납입한 이용료에 대한 환급은 "잉글리쉬 월드 원격영어교육 센터"이 정한 환급규정에 따릅니다.

② 본 조에서 정한 환급업무 그리고 전 제8조에서 정하는 이용대금 결제업무와 관련하여 "회원"에게 발생하는 손해에 대한 최종 배상책임은 "잉글리쉬 월드 원격영어교육 센터"에게 있습니다.

③ 서비스 개시 후 15일 까지 상담 후 환불 가능합니다.

④ 환불은 (수업받은 일 수/수업 받을 일수 x 이용대금)-소정의 수수료 로 계산합니다.

제11조 (이용해지 및 이용제한)
"회원"이 "본 서비스"의 이용을 해지하고자 하는 때에는 "회원" 본인이 서비스 또는 전자우편를 통하여 해지하고자 하는 날의 이(2)일 전까지(단, 해지일이 법정공휴일인 경우 공휴일 개시 삼(3)일 전까지) 이를 "서비스제공자"에 신청하여야 합니다.

제 12조 (손해배상 및 면책조항)
"서비스제공자"는 "본 서비스"의 이용과 관련하여 "서비스제공자"의 고의 또는 과실 없이 "회원에게 발생한 일체의 손해에 관하여 책임을 부담하지 않습니다."본 서비스"의 이용과 관련하여 "회원"에게 발생하는 손해에 대한 최종 배상책임은 "잉글리쉬 월드 원격영어교육 센터"에게 있습니다.

제13조 (약관의 개정)
① "서비스제공자"는 약관의규제등에관한법률, 전자거래기본법, 전자서명법, 정보통신망이용촉진등에관한법률 등 관련법을 위배하지 않는 범위에서 본 약관을 개정할 수 있습니다.

② "서비스제공자"가 본 약관을 개정할 경우에는 적용일자 및 개정사유를 명시하여 현행약관과 함께 초기화면에 그 적용일자 칠(7일) 이전부터 적용일자 전일까지 공지합니다.

③ "회원"은 변경된 약관에 대해 거부할 권리가 있습니다. "회원"은 변경된 약관이 공지된 후 십오(15)일 이내에 거부의사를 표명할 수 있습니다. "회원"이 거부하는 경우 "서비스제공자"는 당해 "회원"과의 계약을 해지할 수 있습니다. 만약 "회원"이 변경된 약관이 공지된 후 십오(15)일 이내에 거부의사를 표시하지 않는 경우에는 동의하는 것으로 간주합니다.

제14조 (재판관할)
"서비스제공자"와 "회원"간에 발생한 서비스 이용에 관한 분쟁에 대하여는 대한민국 법을 적용하며, 본 분쟁으로 인한 소는 민사소송법상의 관할을 가지는 대한민국의 법원에 제기합니다.

부 칙 : 본 약관은 2007. 11. 1. 부터 적용합니다.
		</textarea>


	<?php if ( !empty( $user ) ) { ?>

		<?php
		$file_upload_form_name = 'primary_photo';
		$form_upload_single_file = true;
		include template('user.photo');
		
		$name = $user->get('name');
		$mail = $user->get('mail');
		$mobile = $user->get('mobile');
		if( !empty( $variables['user'] ) ) $user = $variables['user'];
		
		echo html_row([
			'class' => 'data-set username',
			'caption' => '아이디',
			'text' => html_input([
				'id' => 'id',
				'name' => 'id',
				'value'=> $user->get('id'),
				'placeholder' => '아이디',
			]),
		]);
		?>
	<?php } else {

		$name = request('name');
		$mail = request('mail');		
		$mobile = request('mobile');

		?>

		<?php
			echo html_row([
				'class' => 'data-set username',
				'caption' => '아이디',
				'text' => html_input([
					'id' => 'id',
					'name' => 'id',
					'value'=>request('id'),
					'placeholder' => '아이디',
				]),
			]);
		?>
		<?php 		
			echo html_row([
				'class' => 'data-set password',
				'caption' => '비밀번호',
				'text' => html_password([
					'name' => 'password',
					'placeholder' => '비밀번호',
				]),
			]);
		?>
	<?php } ?>

	<?php
		if( !empty( $variables['user'] ) ){
			$user = $variables['user'] ;
			$name = $user->get('name');
			$mail = $user->get('mail');	
			$mobile = $user->get('mobile');		
		}
	?>

	<?php 
		echo html_row([
			'class' => 'data-set full_name',
			'caption' => '이름',
			'text' => html_input([
				'id' => 'name',
				'name' => 'name',
				'value'=>$name,
				'placeholder' => '이름',
			]),
		]);
	/*echo html_row([
		'caption' => 'Name',
		'text' => html_input(['type'=>'text', 'name'=>'name', 'value'=>$name, 'placeholder'=>'Input Name']),
	]);*/
	?>
	<?php 
		echo html_row([
			'class' => 'data-set mobile',
			'caption' => '이메일',
			'text' => html_input([
				'id' => 'data-set mobile',
				'name' => 'mobile',
				'value'=>$mobile,
				'placeholder' => 'Mobile',
			]),
		]);
	?>	
	<?php 
		echo html_row([
			'class' => 'data-set email',
			'caption' => '이메일',
			'text' => html_input([
				'id' => 'data-set email',
				'name' => 'mail',
				'value'=>$mail,
				'placeholder' => '이메일',
			]),
		]);
	/*echo html_row([
		'caption' => 'Email',
		'text' => html_input(['type'=>'email', 'name'=>'mail', 'value'=>$mail, 'placeholder'=>'Input Email']),
	]);*/
	?>		
		<div class='buttons'>
			<input type="submit" value="<?php echo $submit_text ?>">
			<a href="/" class="ui-btn ui-icon-action">취소</a>
		</div>
	</form>
</div>