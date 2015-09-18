<?php
namespace sap\app;
use sap\core\post\PostData;
use sap\core\user\User;
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

        ob_start();
        include template('page');
        return ob_get_clean();
    }

    private static function pageContentPostList($post_id)
    {
        ob_start();
        $posts = MobilePost::postList($post_id);
        include template('page.postList.postForm');
        include template('page.postList');
        return ob_get_clean();
    }


    public static function postCommentSubmit() {
		$config = post_config()->getCurrent();
        if ( empty($config) ) return Response::json(['error'=>'Wrong post configuration']);

        $options['idx_config'] = $config->get('idx');
		$options['idx_user'] = login('idx');
		//$options['idx_user'] = 1;//using for test
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
	
	  public static function postSubmit(){
		$config = post_config()->getCurrent();
        if ( empty($config) ) return Response::json(['error'=>'Wrong post configuration']);

        $options['idx_config'] = $config->get('idx');
		$options['idx_user'] = login('idx');
		//$options['idx_user'] = 1;//using for test
        $options['content'] = request('content');
        $options['idx_root'] = post_data(request('idx_parent'))->get('idx_root');
        $options['idx_parent'] = request('idx_parent');
		
		$data = PostData::newPost($options);

        if ( empty($data) ) return Response::json(['error'=>'Could not create a comment']);
        else {
            $data->updateFormSubmitFiles();
            $posts[] = post_data($data->get('idx'))->getFields();			
            ob_start();
            include template('page.postList');
            $data = ob_get_clean();
            echo $data;
        }
	  }

    public static function loginSubmit() {
        $re = User::checkIDPassword(request('id'), request('password'));
        if ( $re ) {
            User::login(request('id'));
            $user = user(request('id'));
            $session_id = $user->get('session_id');
            //self::frontPage();
            sys()->log("session_id:$session_id");
            Response::json(['error'=>0, 'session_id'=>$session_id]);
        }
        else {
            Response::json(['error'=>-1]);
        }
    }
    public static function logout() {
        User::logout();
        //self::frontPage();
    }


    public static function profile() {
        $page = self::createPage([
            'id' => 'postList',
            'header' => self::pageHeader(),
            'panel' => self::pagePanel(),
            'content' => self::pageProfile(),
            'footer' => self::pageFooter(),
        ]);
        echo $page;
    }

    private static function pageProfile()
    {
        ob_start();
        include template('page.profile');
        return ob_get_clean();
    }

}
