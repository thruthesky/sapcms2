<?php
namespace sap\core\post;

use sap\src\Entity;

class PostConfig extends Entity {
    public function __construct() {
        parent::__construct(POST_CONFIG);
    }


    /**
     *
     *
     * Returns a Post Configuration Entity
     *
     *      - Firstly, it looks for request('id')
     *      - Secondly, it looks for request('idx')
     *          -- If it's in admin page, then the 'idx' is post_config.idx
     *          -- if it's not in admin page, then the 'idx' is post_data.idx
     *      - Lastly, it looks for request('idx_parent')
     *
     * @return PostConfig|bool
     */
    public function getCurrent() {

        if ( $id = request('id') ) {
            return $this->load('id', $id);
        }
        else if ( segment(1) == 'create' ) {
            $id = segment(2);
            return $this->load('id', $id);
        }
        /**
         * When a new comment is to be created, request('idx_parent') will be available.
         */
        else if ( $idx = request('idx_parent') ) {
            $post = post_data($idx);
            if ( $post ) {
                if ( $post->get('idx_config') ) return $this->load($post->get('idx_config'));
            }
        }
        else if ( segment(0) == 'admin' && segment(3) == 'edit' ) {
            $idx = request('idx');
            return $this->load($idx);
        }
        else {
            $post = post_data()->getCurrent();
            if ( $post ) {
                $config = $post->getConfig();
                return $config;
            }
        }



        return FALSE;
    }


    /**
     * @param $widget
     * @return array|null|string
     *
     * @code
     * $name = post_config()->getCurrent()->getWidget('list');
     * widget($name, $variables);
     * @endcode
     */
    public function getWidget($widget) {
        $config = $this->getCurrent();
        $name = $config->get("widget_$widget");
        if ( empty($name) ) return "post_" . $widget;
        else return $name;
    }



    /**
     *
     * @param $field
     * @return array|bool|mixed|null
     *
     * @code
     *
    $no_item = post_config()->getCurrent()->config(NO_ITEM);
    $no_page = post_config()->getCurrent()->config(NO_PAGE);

     * @endcode
     */
    public function config($field) {

        $re = $this->get($field);
        if ( $re ) return $re;

        switch ( $field ) {
            case NO_ITEM : return post::globalConfig(NO_ITEM);
            case NO_PAGE : return post::globalConfig(NO_PAGE);
            default: return null;
        }
    }

    public function countData() {
        return post_data()->count("idx_config=".$this->get('idx'));
    }

}
