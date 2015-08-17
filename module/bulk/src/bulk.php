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
        set_time_limit(0);
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
        $count = count($rows);


        $q = null;
        if ( $rows ) {
            echo "<h1>No of Search from smsgate_bulk_data table: $count</h1>";
            foreach( $rows as $row ) {

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

                // entity(BULK_DATA)->which($row['idx'])->set('stamp_last_sent', time())->save();
                //$ups[ $row['idx'] ] = time();
                $q .= "UPDATE ".BULK_DATA." SET stamp_last_sent=".time()." WHERE idx=$row[idx];";
                $numbers[] = $row['number'];
            }
        }

        if ( $q ) {
            entity()->beginTransaction();
            entity()->exec($q);
            system_log($q);
            entity()->commit();
        }

        $data = smsgate::scheduleMessage($numbers, $bulk->get('message'), $tag);

        $data['template'] = 'bulk.sent';
        $data['numbers'] = &$numbers;
        $data['already_sent'] = $already_sent;
        $data['in_queue'] = $in_queue;
        $data['cond'] = $cond;
        Response::render($data);
    }
}
