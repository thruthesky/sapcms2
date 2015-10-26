<?php
namespace sap\core\post;
use sap\src\Meta;



class PostVoteHistory extends Meta
{
    public function __construct() {
        parent::__construct(POST_VOTE_HISTORY);
    }

    public function voteGood($idx)
    {
        if ( ! login() ) return error(-50941, "Please, login first before you are going to vote.");
		$voteDone = $this->voteDone($idx);//added by benjamin because it is causing return function error on my PHP version 5.4.17
        if ( ! empty( $voteDone ) ) return error(-50945, "You have voted already on this post.");
        $no = $this->voteSaveGood($idx);
        return ['idx'=>$idx, 'no'=>$no, 'type'=>'good'];
    }

    public function voteBad($idx)
    {
        if ( ! login() ) return error(-50942, "Please, login first before you are going to vote.");
        $voteDone = $this->voteDone($idx);//added by benjamin because it is causing return function error on my PHP version 5.4.17
        if ( ! empty( $voteDone ) ) return error(-50945, "You have voted already on this post.");
        $no = $this->voteSaveBad($idx);
        return ['idx'=>$idx, 'no'=>$no, 'type'=>'bad'];
    }

    public function voteDone($idx)
    {
        $code = $this->getCode($idx);
        return $this->value($code);
    }

    private function getCode($idx)
    {
        return $idx . '.' . login("idx");
    }


    private function voteSaveGood($idx)
    {
        $no = post_data()->field($idx, 'no_vote_good');
        post_data()->which($idx)->set('no_vote_good', $no+1)->save();
        $code = $this->getCode($idx);
        $this->set($code, 'good', $idx);
        return $no+1;
    }
    private function voteSaveBad($idx)
    {
        $no = post_data()->field($idx, 'no_vote_bad');
        post_data()->which($idx)->set('no_vote_bad', $no+1);
        $code = $this->getCode($idx);
        $this->set($code, 'bad', $idx);
        return $no+1;
    }

}
