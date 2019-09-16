<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Basic Language Lines
    | 基本言語
    |--------------------------------------------------------------------------
    */

    'title' => [
        'auth' => [
            'login' => 'Sign up / Log in',
            'register' => 'Sign up',
        ],
        'account' => [
            'index' =>  'Settings',
            'confirm' => 'Membership Cancellation',
        ],
        'user' => [
            'index' => ':name\'s Profile',
            'edit' => 'Edit Profile',
            'followings' => ':name\'s Following',
            'followers' => ':name\'s Followers',
            'notifications' => 'Notifications'
        ],
        'home' => 'Start your Anime life with Anima',
        'item' => ':title',
        'review' => 'name\'s Review on 『:title』',
        'search' => 'Search Results for :keyword',
    ],
    'word' => [
        'auth' => [
            'necessary' => 'Required',
            'any' => 'Optional',
        ],
        'account' => [
            'linked' => 'Connected',
            'unlinked' => 'Disconnect',
            'link' => 'Unconnected',
        ],
        'user' => [
            'necessary' => 'Required',
            'any' => 'Optional',
        ],
        'item' => [
            'source' => 'Soutce: Animehack',
            'season' => 'Season: :season',
            'company' => 'Studio :company',
            'reviews_count' => 'Reviews: :count件',
            'here' => 'here',
            'link' => 'Check here for the storyline, cast, and the music info of the movie.',
            'official_link' => 'Official website: ',
        ],
        'search' => [
            'item' => 'Anime',
            'user' => 'User',
            'result' => 'Search Results for 「:keyword」: :count'
        ],
        'twitter' => 'Twitter',
        'facebook' => 'Facebook',
        'google' => 'Google',
        'mypage' => 'My Page',
        'setting' => 'Settings',
        'logout' => 'Log out',
        'resign' => 'Cancel Membership',
        'count' => '',
        'review' => 'Review',
        'comment' => 'Comment',
        'followings' => 'Following',
        'followers' => 'Followers',
        'minutes' => 'minutes',
        'hours' => 'hours',
        'days' => 'days',
        'score' => 'Score',
        'title' => [
            'reviewd_anime' => 'Reviews',
            'popular_anime' => 'Popular Animes',
            'recommend_user' => 'Popular Users',
            'timeline' => 'Feed',
            'watchlist' => 'Watchlist',
            'item' => [
                'link' => 'Movie info',
                'official_link' => 'Related Links'
            ],
            'review' => [
                'create' => 'Post a review',
                'header_edit' => 'Edit review',
            ]
        ]
    ],
    'sentence' => [
        'auth' => [
            'login' => "User your Facebook, Twitter, Google account to sign up / log in.",
            'register' => [
                'cannot_edit' => 'You will not be able to change this once you sign up.',
                'can_edit' => 'You will be able to change this after you sign up from settings.',
            ]
        ],
        'account' => [
            'confirm' => [
                '1' => 'Are you sure you want to cancel the membership of Anima?',
                '2' => 'All your reviews and comments might be deleted once you cancel our membership.',
                '3' => 'We will not guarantee restoration of your data the next time you sign up.',
            ]
        ],
        'comment' => [
            'confirm' => 'Are you sure you want to delete your comment?',
        ],
        'review' => [
            'confirm' => 'Are you sure you want to delete your review?',
            'score' => 'Please set a score.',
        ],
        'user' => [
            'cannot_edit' => 'You will not be able to change this once you sign up.',
            'can_edit' => 'You will be able to change this after you sign up from settings.',
            'notification' => [
                'like' => ':user liked your review.',
                'comment' => ':user commented on your review.',
                'follow' => ':user followed you.',
                'like-comment' => ':user liked your comment.',
                'none' => 'Not notificaitions yet:)'
            ]
        ],
        'home' => [
            'guest' => [
                '1' => 'Start your Anime life with Anima',
                '2' => 'Find new Animes you want to watch from morethan 4,000 Animes, review them, and share with your friends!',
            ],
            'auth' => [
                '1' => "With Anima, you can post reviews on Animes you love, follow users with the same taste in Anime, and catch up with their reviews on the feed.",
                '2' => "Start by posting a review on any Animes you watched or following users with the same taste in Anime!",
            ]
        ]
    ],
    'button' => [
        'register_login' => 'Sign up / Log in',
        'register_login_start' => 'Sign up / Login to Start Your Anime Life',
        'follow' => 'Follow',
        'following' => 'Following',
        'edit_profile' => 'Edit profile',
        'create' => 'Post',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'cancel' => 'Cancel',
        'search' => 'Search',
        'show_more' => 'See more',
        'change' => 'Change',
        'watchlist' => 'Watchlist',
        'auth' => [
            'twitter' => 'Sign up / Login in with Twitter',
            'facebook' => 'Sign up / Login in with Facebook',
            'google' => 'Sign up / Login in with Google',
            'register' => 'Sign up',
        ],
        'comment' => [
            'create' => 'Post a comment',
            'edit' => 'Edit comment',
            'delete' => 'Delete comment',
        ],
        'review' => [
            'share' => 'Share',
            'create' => 'Post a review',
            'edit' => 'Edit review',
            'delete' => 'Delete review',
        ],
        'user' => [
            'save' => 'Save',
        ],
    ],
    'label' => [
        '20_words' => '(max 20 characters)',
        '300_words' => '(max 300 characters)',
        'auth_user' => [
            'nickname' => 'Anima ID',
            'user_name' => 'Name',
            'content' => 'Comment',
            'profile' => 'Profile image',
        ],
        'search' => [
            'placeholder' => 'Search Animes and users',
        ],
        'comment' => [
            'placeholder' => 'Add comments.'
        ],
        'review' => [
            'placeholder' => 'Add comment here.',
        ],
    ],
];
