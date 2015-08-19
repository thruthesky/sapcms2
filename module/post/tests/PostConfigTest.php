<?php
use sap\post\PostConfig;

include_once "core/etc/phpunit/test.php";
class PostConfigTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }
    public function test_post_config_create()
    {

        $id = 'test-qna';
        $config = post_config('id', $id);
        if ( $config ) $config->delete();
        $this->assertFalse(post_config('id', $id));
        $count = post_config()->count();


        post_config()
            ->set('id', $id)
            ->set('name', 'QnA Forum')
            ->set('description', 'Ask anything you want!')
            ->save();
        $config = post_config('id', $id);
        $this->assertNotEmpty($config);
        $this->assertTrue($config instanceof PostConfig);
        $this->assertTrue( ($count+1) == post_config()->count() );
        post_config('id', $id)->set('name', 'New name')->save();
        post_config('id', $id)->delete();
        $this->assertTrue( $count == post_config()->count() );


    }
}
