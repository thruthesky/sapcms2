<?php
namespace sap\app;
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
    <div class="ui-content content">
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

}
