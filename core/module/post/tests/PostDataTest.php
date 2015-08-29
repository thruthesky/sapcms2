<?php
use sap\core\post\PostConfig;
use sap\src\Request;

include_once "core/etc/phpunit/test.php";
class PostDataTest extends PHPUnit_Framework_TestCase
{

    private static $id = "post_data_test";

    public function __construct()
    {
        parent::__construct();
    }
    public function getNewConfig() {
        if ( $config = post_config(self::$id) ) $config->delete();
        $config = post_config()->set('id', self::$id)->set('name', self::$id)->save();
        return $config;
    }

    public function test_post_data_config() {
        $config = $this->getNewConfig();
        $option = [
            'idx_config' => $config->get('idx'),
            'title' => "...",
            'content' => "...",
        ];
        $data = post_data()->newPost($option);

        $this->assertTrue($data->config('id') == self::$id);

        $data->delete();
        $config->delete();
    }

    public function test_post_data_create() {
        $config = $this->getNewConfig();
        $option = [
            'idx_config' => $config->get('idx'),
            'title' => "Test title No. 1",
            'content' => "Test content No. 1",
        ];
        $data = post_data()->newPost($option);
        $this->assertTrue($config->countData()==1);
        $data->delete();
        $config->delete();
    }

    public function test_post_comment_create() {
        $config = $this->getNewConfig();
        $option = [
            'idx_config' => $config->get('idx'),
            'title' => "Test title No. 1",
            'content' => "Test content No. 1",
        ];
        $data = post_data()->newPost($option);

        $option = [
            'idx_config' => $config->get('idx'),
            'idx_parent' => $data->get('idx'),
            'title' => "Test title No. 1",
            'content' => "Test content No. 1",
        ];
        $comment = post_data()->newPost($option);

        $this->assertTrue($config->countData()==2);
        $data->delete();
        $comment->delete();
        $config->delete();
    }

    public function test_post_data_delete() {
        $config = $this->getNewConfig();
        $option = [
            'idx_config' => $config->get('idx'),
            'title' => "Test title No. 1",
            'content' => "Test content No. 1",
        ];
        $data = post_data()->newPost($option);
        $this->assertTrue($config->countData()==1);
        $this->assertTrue($data->markAsDelete());
        $config->delete();
    }


    public function test_post_data_comment_delete() {
        $config = $this->getNewConfig();
        $option = [
            'idx_config' => $config->get('idx'),
            'title' => "Test title No. 1",
            'content' => "Test content No. 1",
        ];
        $data = post_data()->newPost($option);

        $option = [
            'idx_config' => $config->get('idx'),
            'idx_parent' => $data->get('idx'),
            'title' => "Test title No. 2",
            'content' => "Test content No. 2",
        ];
        $comment1 = post_data()->newPost($option);

        $option = [
            'idx_config' => $config->get('idx'),
            'idx_parent' => $data->get('idx'),
            'title' => "Test title No. 3",
            'content' => "Test content No. 3",
        ];
        $comment2 = post_data()->newPost($option);

        $this->assertTrue($config->countData()==3);

        $this->assertFalse($data->markAsDelete());
        $this->assertTrue($config->countData()==3);

        $this->assertFalse($comment1->markAsDelete());
        $this->assertTrue($config->countData()==3);

        $this->assertTrue($comment2->markAsDelete());
        $this->assertTrue($config->countData()==0);

        $config->delete();
    }


}
