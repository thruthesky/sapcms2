<?php
use sap\core\post\PostConfig;
use sap\src\Request;

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

    public function test_create_post() {
        $id = "temp-forum";
        if ( $config = post_config($id) ) $config->delete();
        $config = post_config()->set('id', $id)->set('name', 'Temp')->save();
        $post = post_data()
            ->set('idx_config', $config->get('idx'))
            ->set('title', 'hi')
            ->save();
        $post->delete();
        post_config($id)->delete();
    }


    public function test_get_current() {
        $id = 'test-config';
        if ( $config = post_config($id) ) $config->delete();
        $config = post_config()->set('id', $id)->set('name', 'Test config')->save();
        Request::set('id', $id);
        $this->assertTrue(post_config()->getCurrent()->id == $id);
        Request::reset();
        $this->assertFalse(post_config()->getCurrent());

        $data = post_data()->newPost([
            'idx_config' => $config->idx,
            'title'=>'hello',
            'content' => 'This is content',
        ]);
        $this->assertFalse( post_config()->getCurrent() );
        Request::set('idx', $data->idx);
        $this->assertTrue( post_config()->getCurrent()->id == $id );

        $config->delete();
        $data->delete();
    }
}
