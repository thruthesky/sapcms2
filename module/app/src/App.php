<?php
namespace sap\app;
use sap\core\post\PostData;
use sap\core\user\User;
use sap\src\Response;

use sap\core\message\Message;

class App {

    public static function pageHeader() {
        ob_start();
        include template('page.header');
        return ob_get_clean();
    }

    public static function pageFooter() {

        ob_start();
        include template('page.footer');
        return ob_get_clean();

        //return "All Rights Reserved © 2015";
        //return "필고닷컴";
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



    public static function frontPage() {
        $page = self::createPage([
            'id' => 'front_page',
            'header' => self::pageHeader(),
            'panel' => self::pagePanel(),
            'content' => self::pageContentFront(),
            //'footer' => self::pageFooter(),
        ]);
        echo $page;		
    }
	
	/*
	requires class='link', route='view_post', and idx = '$post_idx';
	//sample
	<div class='link' route='view_post' idx='$idx'>
	*/	
    public static function viewPost() {		
		$view_idx = request('idx');
		$view_item = self::pageContentPostView( $view_idx );
        $page = self::createPage([
            'id' => 'postList',
            'header' => self::pageHeader(),
            'panel' => self::pagePanel(),
            'content' => $view_item,
            //'footer' => self::pageFooter(),
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
            //'footer' => self::pageFooter(),
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

    private static function pageContentPostList($post_id,$view_idx = null)
    {
		if( !empty( $view_idx ) ) $skip_idx = $view_idx;
        ob_start();
        $posts = MobilePost::postList($post_id);
        include template('page.postList.postForm');
        include template('page.postList');
        return ob_get_clean();
    }
	
    private static function pageContentPostView($view_idx)
    {		
		$view_post = post_data()->load( $view_idx );
		if( !empty( $view_post ) ){
			$post_config_id = post_config()->load( $view_post->idx_config );
			if( !empty( $post_config_id ) ) $post_config_id = $post_config_id->id;
			
			if( !empty( $view_post ) ){
				post_data()->which($view_post->get('idx'))->set('no_view', $view_post->get('no_view') + 1)->save();
				$posts[] = $view_post->fields;
				ob_start();			
				include template('page.postList');
				echo self::pageContentPostList($post_config_id,$view_idx);
				return ob_get_clean();
			}
			else{
				return null;
			}
		}
		else{
			return "Incorrect IDX";
		}
    }


    public static function postCommentSubmit() {
		$user = login();
		if( empty( $user ) ) return Response::json(['error'=>'1001','message'=>'Please Login First!']);
		
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
		$user = login();
		
		//check for post content
		$content = trim(request('content'));
		if( empty( $content ) ){
			$fid = request('fid');
			if( empty( $fid ) ) return Response::json(['error'=>'1010','message'=>'Content cannot be empty!']);
		}
		//check for post content
		
		if( empty( $user ) ) return Response::json(['error'=>'1001','message'=>'Please Login First!']);
	  
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
			$posts[0]['content'] = nl2br( $posts[0]['content'] );
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
		$fid = request('fid');
		$user = login();		
        if ( empty($post) ) echo "ERROR -50564 Post does not exist";//$re = ['error'=>-50564, 'message'=>"Post does not exists."];
		else if ( $post->fields['idx_user'] != $user->fields['idx'] ) echo "ERROR -50554 This is not your post. You cannot edit or delete this post";//$re = ['error'=>-50554, 'message'=>"This is not your post. You cannot edit or delete this post."];
		else{
			$post
			->set( 'content',$content )
			//temp
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
			
			if( !empty( $fid ) ) $post->updateFormSubmitFiles();
			
			echo $content;
			
			$files = data()->loadBy('post', post_data($post->fields['idx'])->config('idx'), $post->fields['idx']);	
			$total_files = count( $files );
			if( !empty( $files ) ){
			echo "<section role='files'><div class='display-files' file_count='$total_files'>";
				if( $total_files > 1 ) App::display_files_thumbnail( $files, 200, 200 );
				else display_files($files); 					
			echo "</div></section>";
			}
		}
	}
	
	public static function PostEditCommentSubmit(){
		$idx = request('idx');
		$content = request('content');
		$fid = request('fid');
		$post = post_data($idx);
		$user = login();		
        if ( empty($post) ) echo "ERROR -50564 Post does not exist";//$re = ['error'=>-50564, 'message'=>"Post does not exists."];
		else if ( $post->fields['idx_user'] != $user->fields['idx'] ) echo "ERROR -50554 This is not your post. You cannot edit or delete this post";//$re = ['error'=>-50554, 'message'=>"This is not your post. You cannot edit or delete this post."];
		else{
			$post
			->set( 'content',$content )
			//temp
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
			
			if( !empty( $fid ) ) $post->updateFormSubmitFiles();
			
			echo $content;
			
			$files = data()->loadBy('post', post_data($post->fields['idx'])->config('idx'), $post->fields['idx']);	
			$total_files = count( $files );
			if( !empty( $files ) ){
			echo "<section role='files'><div class='display-files' file_count='$total_files'>";
				if( $total_files > 1 ) App::display_files_thumbnail( $files, 200, 200 );
				else display_files($files); 					
			echo "</div></section>";
			}
		}
	}

    public static function postDelete() {
		$idx = request('idx');
		$post = post_data($idx);
		$user = login();		
        if ( empty($post) ) echo "ERROR -50564 Post does not exist";//$re = ['error'=>-50564, 'message'=>"Post does not exists."];
		else if ( $post->fields['idx_user'] != $user->fields['idx'] ) echo "ERROR -50554 This is not your post. You cannot edit or delete this post";//$re = ['error'=>-50554, 'message'=>"This is not your post. You cannot edit or delete this post."];
		else{
			//delete all files first
			$files = data()->loadBy('post', post_data($post->idx)->config('idx'), $post->idx);
			foreach( $files as $file ){
				$file->delete();				
			}			
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
		$no = request('no');
		$post = post_data($idx)->fields;	
		$edit_mode = true;		
		ob_start();
		include template('page.postList.postForm');
		$data = ob_get_clean();
		
		echo $data;
    }
	
    public static function getPostCommentEditForm() {
		$idx = request('idx');
		$no = request('no');
		$comment_edit = post_data($idx)->fields;	
		$edit_mode = true;
		ob_start();		
		include template('page.postList.comment-form');		
		$data = ob_get_clean();
		
		echo "<div class='comment-form'>";
		echo $data;
		echo "</div>";
    }
	
	/*getPostFiles*/
	public static function getPostFiles(){
		$idx = request('idx');
		$no = request('no');
		
		$files = data()->loadBy('post', post_data($idx)->config('idx'), $idx);
		$total_files = count( $files );
		
		if( !empty( $files ) ){
			foreach( $files as $f ){
				$file = $f->fields;
				$url = $f->urlThumbnail( 100, 100 );
				//$url = $f->url();
				echo "<div idx='".$file['idx']."' class='file image delete'>";
				echo "<img src='".$url."'></div>";
				//echo "<div class='delete' title='Delete this file'>X</div>";
			}
		}
	}
	/*eo getPostFiles*/
	
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
        $options['mobile'] = request('mobile');
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
            ->set('mobile', request('mobile'))
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
			$name = $file->get('name_saved');
			if ( is_image($name) ) {
				$tag_imgs[] = "<div class='image' idx='".$file->idx."'><img src='$url'></div>";
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
	
	public static function modalWindow(){
		$action = request('action');
		self::$action();		
	}
	
	public static function modalImage(){
		$file = data()->load( request('idx') );
		$post_idx = $file->target_idx;
		$url = $file->url();
		
		
		echo "
			<div class='modal_image'>
				<img src='".$url."'/>
			</div>
			";
	}
	
	public static function humanTiming( $stamp )
	{
		$period = NULL;
		$secsago   =   time() - $stamp;
		
		if ($secsago < 60) {
			$w1 = "second";
			$w2 = "seconds";
			$period = $secsago == 1 ? '1 ' . $w1    : $secsago . " " . $w2 ;
		}
		else if ($secsago < 3600) {
			$w1 = "minute";
			$w2 = "minutes";
			$period    =   round($secsago/60);
			$period    =   $period == 1 ? '1 ' . $w1 : $period . " " . $w2;
		}
		else if ($secsago < 86400) {
			$w1 = "hour";
			$w2 = "hours";
			$period    =   round($secsago/3600);
			$period    =   $period == 1 ? '1 ' . $w1   : $period . " " .  $w1;
		}
		else if ($secsago < 604800) {
			$w1 = "day";
			$w2 = "days";
			$period    =   round($secsago/86400);
			$period    =   $period == 1 ? '1 '. $w1    : $period . " " . $w2;
		}
		else if ($secsago < 2419200) {
			$w1 = "week";
			$w2 = "weeks";
			$period    =   round($secsago/604800);
			$period    =   $period == 1 ? '1 ' . $w1   : $period . " " . $w2;
		}
		else if ($secsago < 29030400) {
			$w1 = "month";
			$w2 = "months";
			$period    =   round($secsago/2419200);
			$period    =   $period == 1 ? '1 ' . $w1   : $period . " " . $w2;
		}
		else {
			$w1 = "year";
			$w2 = "years";
			$period    =   round($secsago/29030400);
			$period    =   $period == 1 ? '1 ' . $w1   : $period . " " . $w2;
		} 
		return $period;
	}
	
	public static function loginCheck(){
		$user = login();
		if( empty( $user ) ) return Response::json(['error'=>'1001','message'=>'Please Login First!']);
		return Response::json(['error'=>'0','message'=>'No error']);
	}
	
	
	/*message*/
	public static function messageList(){
		$page = self::createPage([
            'id' => 'messageList',
            'header' => self::pageHeader(),
            'panel' => self::pagePanel(),
            'content' => self::pageMessageList(),
            //'footer' => self::pageFooter(),
        ]);
        echo $page;
	}
	
	public static function messageCreate(){
		$page = self::createPage([
            'id' => 'messageList',
            'header' => self::pageHeader(),
            'panel' => self::pagePanel(),
            'content' => self::pageMessageCreate(),
            'footer' => self::pageFooter(),
        ]);
        echo $page;
	}
	
	public static function pageMessageList(){
		$data = Message::getCollection();

		ob_start();		
        include template('page.messageMenu');
        include template('page.messageSearch');
		echo "<div class='message-list-body'>";
		
		echo "<div class='link sprite new_message' route='messageCreate'></div>";
		
		include template('page.messageList');  
		echo "</div>";
        return ob_get_clean();
	}
	
	public static function messageMore(){
		$data = Message::getCollection();		
        include template('page.messageList');        
	}
	
	public static function pageMessageCreate(){
		ob_start();
		include template('page.messageMenu');
		include template('page.messageCreateForm');
        return ob_get_clean();
	}
	
	public static function messageCreateSubmit(){
		//check for message content
		$content = trim(request('content'));
		if( empty( $content ) ){
			$fid = request('fid');
			if( empty( $fid ) ) return Response::json(['error'=>'1010','message'=>'Content cannot be empty!']);
		}
		//check for message content
	
		$data = Message::messageSubmit();
		return Response::json( $data );
		//di( $data );
	}
	
	public static function markAsRead(){
		Message::markAsRead();
	}
	
	public static function messageDelete(){
		$idxs = request('idx');
		$data = Message::deleteConfirm( $idxs );
		$data['action'] = 'delete';
	
		return Response::json( $data );
	}
	/*eo message*/
	
	/*PopupUserProfile*/
	public static function getPopupUserProfile(){
		$idx = request('idx');
		$profile_target = request('profile_target');
		$my_idx = login('idx');
		if( $idx == 0 ) $idx = 1;//temporary
		$user = User()->load( $idx );
		
		if( empty( $user ) ) return Response::json(['error'=>'-1002','message'=>'Invalid User ID!']);
		$reply = true;
		
		
		
		ob_start();
		echo "<div class='popup-profile remove-on-body-click' user_id='$idx' profile_target='$profile_target'>";
		echo "<div class='triangle outer'></div><div class='triangle inner'></div>";
		include template('page.userInformation');
		if( !empty( $my_idx ) ){
			$show_on_click_class = " show-on-click";
			include template('page.messageCreateForm');
		}
		echo "</div>";
		echo ob_get_clean();
	}
	/*eo PopupUserProfile*/
	
	/*postReport*/
	public static function getReportForm(){
		$idx = request('idx');
		$my_idx = login('idx');
		if( empty( $my_idx ) ) return Response::json(['error'=>'-1001','message'=>'Please Login First!']);
		$html =	"<form class='reportForm remove-on-body-click' action=''>".		
				"<input type='hidden' name='idx' value='".$idx."'>".
				"<table celpadding=0 cellspacing=0 width='100%'><tr>".
				"<td width='99%'><textarea name='reason' placeholder='Reason for reporting'></textarea></td>".
				"<td><input type='submit' value='Report'></td>".
				"</tr></table>".
				"</form>";
				
		return Response::json(['error'=>'0','html'=>$html]);
	}
	
	public static function postReport(){
		$idx = request('idx');
		$reason = request('reason');
		$my_idx = login('idx');
		$post = post_data()->load( $idx );
		if( empty( $my_idx ) ) return Response::json(['error'=>'-1001','message'=>'Please Login First!']);
		if( empty( $post ) ) return Response::json(['error'=>'-6000','message'=>'Invalid Post ID!']);
		if( empty( $reason ) ) return Response::json(['error'=>'-6010','message'=>'Reason Cannot be empty!']);
		
		
		$post
			->set( 'report', 'Y' )
			->set( 'reason', $reason )
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
			
		echo "Successfully reported this post!";
	}
	/*eo postReport*/
}
