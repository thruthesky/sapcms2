<?php
$id = "han";
if ( ! $config = post_config($id) ) {
    $config = post_config()->set('id', $id)->set('name', 'Han')->save();
}

$id_gallery = "han_gallery";
if ( ! $config_gallery = post_config($id_gallery) ) {
    $config_gallery = post_config()->set('id', $id_gallery)->set('name', 'Han Gallery')->save();
}


$option = [
	'idx_config' => $config->get('idx'),
	'title' => "Welcome to wooreeedu christmas event!",
	'content' => "We provide fun events for children so they can also find joy through learning.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/xmas_16.jpg");


$option = [
	'idx_config' => $config->get('idx'),
	'title' => "Presents for everyone! Ho Ho Ho! Santa is here! Just kidding!",
	'content' => "What else is there other than fun and games is of course PRESENTS! Presents for everyone who participated",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/xmas_8.jpg");



$option = [
	'idx_config' => $config->get('idx'),
	'title' => "Outbound trips to different parts of the country. Learn new places and new words along the way...",
	'content' => "We give outbound trips to relieve some stress, not only for students but also theirs teachers. Another purpose of this event to deepen their relationships and further improve each others understanding.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/tripping_5.jpg");
//wooreeedu_gallery
$option = [
	'idx_config' => $config_gallery->get('idx'),
	'title' => "About our weekends...? Fun and relaxation!",
	'content' => "Going out just to have fun is another way to decrease the student's frustration. We let students, along with their guardians, have fun for half a day so they can always feel energized and not lose interest in studying.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/weekend_1.jpg");

$option = [
	'idx_config' => $config_gallery->get('idx'),
	'title' => "We don't only speak english, we also sing them!",
	'content' => "This here is our ENGLISH ONLY POP SONG event. We provide selected songs and randomly distribute them to our students. They sing, or may as well, dance and will compete for the golden medal.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/popsong_2.jpg");

$option = [
	'idx_config' => $config_gallery->get('idx'),
	'title' => "Meet our champion for the English Only Pop Song event",
	'content' => "Will you look at that, aren't those some pretty flower? Well, he earned it! Right here is our champion. A round of applause everyone!",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/popsong_7.jpg");

$option = [
	'idx_config' => $config_gallery->get('idx'),
	'title' => "English seminar held last week in one of our facilities.",
	'content' => "This seminar is for those who have advanced knowledge in english. We give out tips on common grammar mistakes and give them techniques on how to always avoid them.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/seminar_1.jpg");


$option = [
	'idx_config' => $config_gallery->get('idx'),
	'title' => "The Global Leadership Speech Contest",
	'content' => "Right here is a speech contest. Anyone available is able to participate. We conduct such programs to enchance the student's ability to create their own sentences.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/speech_1.jpg");

$option = [
	'idx_config' => $config_gallery->get('idx'),
	'title' => "More about the Global Leadership Speech Contest",
	'content' => "Of course, we also give out prizes to further motivate our participants.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/speech_11.jpg");

$option = [
	'idx_config' => $config_gallery->get('idx'),
	'title' => "Participants of the Global Leadership Speech Contest",
	'content' => "Meet our audiences and participants. Join us now so you can be one of them on our next program.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/speech_12.jpg");

$option = [
	'idx_config' => $config_gallery->get('idx'),
	'title' => "Learn with us.",
	'content' => "Join wooreeedu now for a fun and learning experience like never before.",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/header_junior.jpg");

$option = [
	'idx_config' => $config_gallery->get('idx'),
	'title' => "More about us.",
	'content' => "This post will be about us who worked hard to get this far. We always do our best to meet our client's needs that is why we were able to be this successful...",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/header_introduction.jpg");

$option = [
	'idx_config' => $config_gallery->get('idx'),
	'title' => "A simple trip in a lake.",
	'content' => "We decided to take a trip to a certain lake. Everyone seems to be enjoying things well. Enroll now so you can join us next time",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/tripping_13.jpg");

$option = [
	'idx_config' => $config_gallery->get('idx'),
	'title' => "An eventful weekend.",
	'content' => "Right now we are in a pool. Nothing much to do but just have fun. Overworking yourself is bad so we do this kind of stuff from time to time...",
	'idx_user'=> 1
];
$post = post_data()->newPost($option);
$data = $post->attachFile("theme/wooreeedu/img/weekend_7.jpg");

