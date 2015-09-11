<?php

/*
category()->group('mall')->group('car')->group('hyundai')->set('starex', 'Starex 2015');
category()->group('mall')->group('car')->group('hyundai')->set('starexG', 'GrandStarex 2015');
category()->group('mall')->group('car')->group('toyota')->set('altis1.6eAT', 'Altis 1.6 E A/T Silver');

$mall = category()->group('mall')->gets();
di($mall);

category()->group('forum')->group('car')->group('hyundai')->set('starex', 'Starex 2015');
category()->group('forum')->group('car')->group('hyundai')->set('starexG', 'GrandStarex 2015');

$forum = category()->group('forum')->gets();
di($forum);
*/



$category = [
    'mall' => [
        'car' => [
            "Hyundai" => [
                "Starex 1.2",
                "Starex 2.4 2L Grand",
                "Starex Remousine",
            ],
            "Toyota" => [
                'Altis'
            ]
        ],
        'shoes' => [
            'running shoes' => [
                "Asics",
                "Nike"
            ],
            "men's shoes" => [
                "Landlover",
                "Rusty Ropes",
                "Broad Blocks",
                "Wall Streets"
            ]
        ]
    ],
    'forum' => [
        'News' => [
            'Breaking News',
            'World wide',
            'National',
            'Sports',
        ],
        'QnA' => [
            'Foods',
            'Camera',
            'Computer',
        ],
        'Discussion'
    ]
];



add_category($category);

function add_category($category, $idx_parent=0) {
    foreach( $category as $e ) {
        if ( is_array($e) ) add_category($e, $idx_parent);
        else {
            $item = category()->set('idx_parent', $idx_parent)->set('name', $e)->save();
            $idx_parent = $item->idx;
        }
    }
}