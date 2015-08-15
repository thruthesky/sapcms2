<?php
namespace sap\bulk;


use sap\smsgate\smsgate;
use sap\src\Response;

class bulk {
    public static function index() {
        return Response::render();
    }
    public static function create() {
        if ( submit() ) {
            //di( entity(BULK_DATA)->count() );
            entity(BULK)
                ->set('name', request('name'))
                ->set('message', request('message'))
                ->save();
            return Response::redirect('/bulk');
        }
        else return Response::render();
    }

    public static function send() {
        $conds = [];
        if ( $location = request('location') ) $conds[] = "province='$location'";
        if ( $category = request('category') ) $conds[] = "category='$category'";
        if ( $days = request('days') ) {
            $stamp = time() - $days * 24 * 60 * 60;
            $conds[] = "stamp_last_sent<$stamp";
        }
        if ( $conds ) {
            $cond = implode(' AND ', $conds);
        }

        $bulk = entity(BULK)->load(request('idx'));
        $tag = $bulk->get('name');
        $numbers = [];
        $already_sent = [];
        $in_queue = [];
        $rows = entity(BULK_DATA)->rows($cond, "idx,number");
        foreach( $rows as $row ) {

            //entity(BULK_DATA)->load($row['idx'])->set('stamp_last_sent', time())->save();


            $queue = entity(SMS_QUEUE)->query("tag='$tag' AND number='$row[number]'");
            if ( $queue ) {
                $in_queue[] = $queue->get('number');
                continue;
            }


            $success = entity(SMS_SUCCESS)->query("tag='$tag' AND number='$row[number]'");
            if ( $success ) {
                $already_sent[] = $success->get('number');
                continue;
            }



            $numbers[] = $row['number'];

        }


        $data = smsgate::scheduleMessage($numbers, $bulk->get('message'), $tag);
        $data['template'] = 'bulk.sent';
        $data['numbers'] = &$numbers;
        $data['already_sent'] = $already_sent;
        $data['in_queue'] = $in_queue;
        Response::render($data);
    }
}
