<?php
$story = "story";
if ( ! $config_story = post_config($story) ) {
    $config_story = post_config()->set('id', $story)->set('name', 'Story')->save();
}

$qna = "qna";
if ( ! $config_qna = post_config($qna) ) {
    $config_qna = post_config()->set('id', $qna)->set('name', 'Question and Answer')->save();
}


$option = [
	'idx_config' => $config_story->get('idx'),
	'title' => "Alphabets Activity",
	'content' => "Click on the images and find out which image contains that first letter. If you find this entertaining, join us to learn more.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/han/img/story_sample/1.jpg");
$data = $post->attachFile("theme/han/img/story_sample/2.jpg");

$option = [
	'idx_config' => $config_story->get('idx'),
	'title' => "Chat room for teens",
	'content' => "It's about teens who converse through phones, computers, or other devices. Take classes to read more.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/han/img/story_sample/3.jpg");
$data = $post->attachFile("theme/han/img/story_sample/4.jpg");

$option = [
	'idx_config' => $config_story->get('idx'),
	'title' => "English Ice Break",
	'content' => "A book with simple images to make children comprehend what each word stand for.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/han/img/story_sample/5.jpg");
$data = $post->attachFile("theme/han/img/story_sample/6.jpg");

#####################################################

$option = [
	'idx_config' => $config_qna->get('idx'),
	'title' => "How to send messages to the admin.",
	'content' => "To send messages to the website admin, scroll down to the lowest part of the website and type in you details. Click on send and you should receive an alert message saying that your message was sent successfully.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/han/img/qna_sample/1.png");

$option = [
	'idx_config' => $config_qna->get('idx'),
	'title' => "Logging in.",
	'content' => "To log in, simply click on the login button at the top right corner of the screen. A new page will appear and then click on submit button ( the blue one )",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/han/img/qna_sample/2.png");

$option = [
	'idx_config' => $config_qna->get('idx'),
	'title' => "To register.",
	'content' => "Click on the register button at the top right corner of the screen. Fill in the required details. Please do not forget to read the agreement.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/han/img/qna_sample/3.png");

$option = [
	'idx_config' => $config_qna->get('idx'),
	'title' => "Register to Video English",
	'content' => "Simply register on this website and click on the second menu '강사목록' or any of it's sub menus.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/han/img/qna_sample/4.png");

$option = [
	'idx_config' => $config_qna->get('idx'),
	'title' => "Creating you own post",
	'content' => "Click on menu '고객센터' or some of it's sub menus ( except the last one ) and you can post there as long as you are registered.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/han/img/qna_sample/5.png");

$option = [
	'idx_config' => $config_qna->get('idx'),
	'title' => "How can I add comments?",
	'content' => "Click on any post to view it. Below the view page you will see a textarea. You can add comments and files along with the comment.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/han/img/qna_sample/6.png");

$option = [
	'idx_config' => $config_qna->get('idx'),
	'title' => "Where can I view the teachers?",
	'content' => "Click on the second menu '강사목록' and you will be redirected to the teacher list page. If you are logged in, you will automatically get logged in on solution as well.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/han/img/qna_sample/7.png");
$data = $post->attachFile("theme/han/img/qna_sample/8.png");

$option = [
	'idx_config' => $config_qna->get('idx'),
	'title' => "Getting inside the class.",
	'content' => "Click on the last sub menu of the second menu '강사목록' or if you are in the solution page, click on the last menu '강의실 입장'. Note* that you can only enter the class 3 minutes early.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/han/img/qna_sample/9.png");