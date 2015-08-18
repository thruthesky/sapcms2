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
                ->set('number', request('number'))
                ->save();
            return Response::redirect('/bulk');
        }
        else return Response::render();
    }

    public static function send() {
        set_time_limit(0);
        $conds = [];
        $cond = null;
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
        $notify_number = $bulk->get('number');
        $numbers = [];


        /*
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
        */



        $rows = entity(BULK_DATA)->rows($cond, "idx,number", \PDO::FETCH_KEY_PAIR);
        if ( $rows ) {
            $success = entity(SMS_SUCCESS)->rows("tag='$tag'", 'idx,number', \PDO::FETCH_KEY_PAIR);
            $queue = entity(SMS_QUEUE)->rows("tag='$tag'", 'idx,number', \PDO::FETCH_KEY_PAIR);
            $data = array_diff($rows, $success, $queue);
            if ( $data ) {
                $idxes = array_keys($data);
                $str_idxes = implode(',', $idxes);
                $q = "UPDATE ".BULK_DATA." SET stamp_last_sent=".time()." WHERE idx IN ( $str_idxes );";
                entity()->runExec($q);
                $numbers = array_values($data);
                $data = smsgate::scheduleMessage($numbers, $bulk->get('message'), $tag);
                smsgate::scheduleMessage($notify_number, "Bulk - $tag ($cond) - has been sent", $tag . ':notify:' . date('ymdHi'));
            }

        }

        $data['template'] = 'bulk.sent';
        $data['numbers'] = &$numbers;
        $data['cond'] = $cond;
        Response::render($data);
    }
}
