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

    public static function postListMore($post_id) {
        $posts = MobilePost::postList($post_id);
        if ( $posts ) {
            include template('page.postList');
        }
        else {
            echo '';
        }
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
            $fid = request('fid');
            sys()->log("fid: $fid");
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
	  
	public static function PostEditSubmit(){
		$idx = request('idx');
		$content = request('content');
		$post = post_data($idx);
		$user = login();		
        if ( empty($post) ) echo "ERROR -50564 Post does not exist";//$re = ['error'=>-50564, 'message'=>"Post does not exists."];
		else if ( $post->fields['idx_user'] != $user->fields['idx'] ) echo "ERROR -50554 This is not your post. You cannot edit or delete this post";//$re = ['error'=>-50554, 'message'=>"This is not your post. You cannot edit or delete this post."];
		else{
			$post
			->set( 'content',$content )
			->set( 'int_1', 0 )
			->set( 'int_2', 0 )
			->set( 'int_3', 0 )
			->set( 'int_4', 0 )
			->set( 'int_5', 0 )
			->set( 'int_6', 0 )
			->set( 'int_7', 0 )
			->set( 'int_8', 0 )
			->set( 'int_9', 0 )
			->set( 'int_10', 0 )
			->save();
			echo $content;
		}
	}
	
	public static function PostEditCommentSubmit(){
		$idx = request('idx');
		$content = request('content');
		$post = post_data($idx);
		$user = login();		
        if ( empty($post) ) echo "ERROR -50564 Post does not exist";//$re = ['error'=>-50564, 'message'=>"Post does not exists."];
		else if ( $post->fields['idx_user'] != $user->fields['idx'] ) echo "ERROR -50554 This is not your post. You cannot edit or delete this post";//$re = ['error'=>-50554, 'message'=>"This is not your post. You cannot edit or delete this post."];
		else{
			$post
			->set( 'content',$content )
			->set( 'int_1', 0 )
			->set( 'int_2', 0 )
			->set( 'int_3', 0 )
			->set( 'int_4', 0 )
			->set( 'int_5', 0 )
			->set( 'int_6', 0 )
			->set( 'int_7', 0 )
			->set( 'int_8', 0 )
			->set( 'int_9', 0 )
			->set( 'int_10', 0 )
			->save();
			echo $content;
		}
	}

    public static function postDelete() {
		$idx = request('idx');
		$post = post_data($idx);
		$user = login();		
        if ( empty($post) ) echo "ERROR -50564 Post does not exist";//$re = ['error'=>-50564, 'message'=>"Post does not exists."];
		else if ( $post->fields['idx_user'] != $user->fields['idx'] ) echo "ERROR -50554 This is not your post. You cannot edit or delete this post";//$re = ['error'=>-50554, 'message'=>"This is not your post. You cannot edit or delete this post."];
		else{
			$post->markAsDelete();
			$posts = [];			
			//$item = [];
			$post_root = post_data()->load( $post->fields['idx_root'] );
			if( !empty( $post_root ) ){
				$item = $post_root->fields;
				$item['comments'] = post_data()->getComments($post_root->fields['idx']);
				$posts[] = $item;
			}
			ob_start();
            include template('page.postList');
            $data = ob_get_clean();
            echo $data;
		}
    }

    public static function getPostEditForm() {
		$idx = request('idx');
		$post = post_data($idx)->fields;	
		$edit_mode = true;
		ob_start();
		include template('page.postList.postForm');
		$data = ob_get_clean();
		
		echo $data;
		
		$files = data()->loadBy('post', post_data($post['idx'])->config('idx'), $post['idx']);
		$total_files = count( $files );
		
		if( !empty( $files ) ){
			echo "<div class='edit-files' file_count='$total_files'>";
							
			foreach( $files as $f ){
				$file = $f->fields;
				$url = $f->urlThumbnail( 100, 100 );
				//$url = $f->url();
				echo "<div idx='".$file['idx']."' class='file image'>";
				echo "<img src='".$url."'>";
				echo "<div class='delete' title='Delete this file'>X</div></div>";
			}
							
			echo "</div>";
		}
    }
	
    public static function getPostCommentEditForm() {
		$idx = request('idx');
		$comment_edit = post_data($idx)->fields;	
		$edit_mode = true;
		ob_start();		
		include template('page.postList.comment-form');		
		$data = ob_get_clean();
		
		echo "<div class='comment-form'>";
		echo $data;
		
		$files = data()->loadBy('post', post_data($comment_edit['idx'])->config('idx'), $comment_edit['idx']);
		$total_files = count( $files );
		
		if( !empty( $files ) ){
			echo "<div class='edit-files' file_count='$total_files'>";
							
			foreach( $files as $f ){
				$file = $f->fields;
				$url = $f->urlThumbnail( 100, 100 );
				//$url = $f->url();
				echo "<div idx='".$file['idx']."' class='file image'>";
				echo "<img src='".$url."'>";
				echo "<div class='delete' title='Delete this file'>X</div></div>";
			}
							
			echo "</div>";
		}
		
		echo "</div>";
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
    private static function pageRegister()
    {
        ob_start();
        include template('page.register');
        return ob_get_clean();
    }


    public static function upload() {
        Response::json(['error'=>0]);
    }


    /**
     *
     */
    public static function register() {
        $page = self::createPage([
            'id' => 'postList',
            'header' => self::pageHeader(),
            'panel' => self::pagePanel(),
            'content' => self::pageRegister(),
            'footer' => self::pageFooter(),
        ]);
        echo $page;
    }

    public static function registerSubmit() {
        $id = request('id');
        if ( user_exists($id) ) return Response::json(['error'=>"User ID is in use. Please choose another."]);
        $options['id'] = $id;
        $options['password'] = request('password');
        $options['name'] = request('name');
        $options['mail'] = request('mail');
        $user = User::createUser($options);
        if ( empty($user) ) return Response::json(['error'=>"Failed on creating a user"]);
        $session_id = User::login($user->get('id')); // make session id
        return Response::json(['error'=>0, 'session_id'=>$session_id]);
    }
    public static function profileUpdateSubmit() {
        //$login = login();
        //$login->save();
        $idx = login('idx');
        if ( empty($idx) ) return Response::json(['error'=>'Please login first']);
        user()
            ->which($idx)
            ->set('name', request('name'))
            ->set('mail', request('mail'))
            ->save();
        Response::json(['error'=>0]);
    }
	
	
	
	
	
	
	public static function display_files_thumbnail( $files, $height, $width, $limit = 0 ) {
		if ( empty($files) ) return null;	
		$tag_imgs = [];
		$tag_files = [];
		//foreach($files as $file) {
		if( $limit == 0 ) $limit = count( $files );	
		for( $i = 0; $i < $limit; $i ++ ){
			$file = $files[$i];		
			$url = $file->urlThumbnail( $width, $height );
			$name = $file->get('name');
			if ( is_image($name) ) {
				$tag_imgs[] = "<div class='image'><img src='$url'></div>";
			}
			else {
				$tag_files[] = "<div class='attachment'><a href='$url'>$name</a></div>";
			}
		}
		
		echo "<div class='attachments'>";
		array_walk($tag_files, 'display');
		echo "</div>";
		echo "<div class='images clearfix'>";
		array_walk($tag_imgs, 'display');
		echo "</div>";
	}
}
