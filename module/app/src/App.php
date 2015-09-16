<?php
namespace sap\app;
use sap\core\post\PostData;
use sap\src\Response;

class App {

    public static function pageHeader() {
        ob_start();
        include template('page.header');
        return ob_get_clean();
    }


    public static function pagePanel() {
        ob_start();
        include template('page.panel');
        return ob_get_clean();
    }


    public static function login() {
        $page = self::createPage([
            'id' => 'login',
            'header' => self::pageHeader(),
            'panel' => self::pagePanel(),
            'content' => self::pageContentLogin(),
            'footer' => self::pageFooter(),
        ]);
        echo $page;
    }


    public static function pageFooter() {
        return "<h1>필고닷컴</h1>";
    }

    public static function frontPage() {
        $page = self::createPage([
            'id' => 'front_page',
            'header' => self::pageHeader(),
            'panel' => self::pagePanel(),
            'content' => self::pageContentFront(),
            'footer' => self::pageFooter(),
        ]);
        echo $page;
    }

    public static function offline() {
        $page = self::createPage([
            'id' => 'offline',
            'header' => "Offline",
            'panel' => "Offline",
            'content' =>  "Offline",
            'footer' =>  "Offline",
        ]);
        echo $page;
    }

    public static function pageContentFront() {
        ob_start();
        include template('page.front');
        return ob_get_clean();
    }

    public static function pageContentLogin() {
        ob_start();
        include template('page.login');
        return ob_get_clean();
    }

    /**
     * @param $post_id
     */
    public static function postList($post_id) {
        $page = self::createPage([
            'id' => 'postList',
            'header' => self::pageHeader(),
            'panel' => self::pagePanel(),
            'content' => self::pageContentPostList($post_id),
            'footer' => self::pageFooter(),
        ]);
        echo $page;
    }

    private static function createPage(array $options)
    {
        return <<< EOH
<div class="page" id="$options[id]">
    <div class="header" data-role="header">
        $options[header]
    </div>
    <div class="content">
$options[panel]
$options[content]
            </div>
    <div class="footer" data-role="footer">
        $options[footer]
    </div>
</div>
EOH;
    }

    private static function pageContentPostList($post_id)
    {
        ob_start();
        $posts = MobilePost::postList($post_id);
        include template('page.postList');
        return ob_get_clean();
    }


    public static function postCommentSubmit() {

        $content = request('content');

        // if ( empty($content) ) return Response::json(['error'=>'Content is empty']);

        $config = post_config()->getCurrent();
        if ( empty($config) ) return Response::json(['error'=>'Wrong post configuration']);

        $options['idx_config'] = $config->get('idx');
        $options['idx_user'] = login('idx');
        $options['content'] = request('content');
        $options['idx_root'] = post_data(request('idx_parent'))->get('idx_root');
        $options['idx_parent'] = request('idx_parent');
        $data = PostData::newPost($options);

        if ( empty($data) ) return Response::json(['error'=>'Could not create a comment']);
        else {
            $data->updateFormSubmitFiles();
            $comment = post_data($data->get('idx'))->getFields();
            $post['comments'] = [ $comment ];
            ob_start();
            include template('page.postList.comments');
            $data = ob_get_clean();
            echo $data;
        }
    }

    public static function loginSubmit() {
        Response::json(['error'=>0]);
    }
}
