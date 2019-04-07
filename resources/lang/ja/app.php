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
            'login' => '登録・ログイン',
            'register' => 'ユーザー登録',
        ],
        'account' => [
            'index' =>  'アカウント設定',
            'confirm' => '退会確認',
        ],
        'user' => [
            'index' => ':nameのプロフィール',
            'edit' => 'プロフィール編集',
            'followings' => ':nameのフォロー',
            'followers' => ':nameのフォロワー',
        ],
        'home' => 'ホーム',
        'item' => ':title',
        'review' => ':nameさんのレビュー',
        'search' => '検索：:keyword',
    ],
    'word' => [
        'auth' => [
            'necessary' => '*必須',
            'any' => '*任意',
        ],
        'account' => [
            'linked' => '連携済み',
            'unlinked' => '連携解除',
            'link' => '未連携',
        ],
        'user' => [
            'necessary' => '*必須',
            'any' => '*任意',
        ],
        'item' => [
            'source' => '出典：アニメハック',
            'season' => 'シーズン：:season',
            'company' => '製作会社：:company',
            'reviews_count' => 'レビュー件数：:count件',
            'here' => 'コチラ',
            'link' => 'あらすじ、キャスト、音楽情報は',
            'official_link' => '公式サイト：',
        ],
        'search' => [
            'item' => 'アニメ作品',
            'user' => 'ユーザー',
            'result' => '「:keyword」に関する検索結果：:count件'
        ],
        'twitter' => 'Twitter',
        'facebook' => 'Facebook',
        'google' => 'Google',
        'mypage' => 'マイページ',
        'setting' => 'アカウント設定',
        'logout' => 'ログアウト',
        'resign' => '退会する',
        'count' => '件',
        'review' => 'レビュー',
        'comment' => 'コメント',
        'followings' => 'フォロー',
        'followers' => 'フォロワー',
        'minutes' => '分前',
        'hours' => '時間前',
        'days' => '日前',
        'score' => '評価',
        'title' => [
            'reviewd_anime' => 'レビューしたアニメ',
            'popular_anime' => '話題のアニメ',
            'timeline' => 'タイムライン',
            'watchlist' => 'ウォッチリスト',
            'item' => [
                'link' => '作品情報',
                'official_link' => '関連リンク'
            ],
            'review' => [
                'create' => 'レビューを投稿',
                'header_edit' => 'レビューを修正',
            ]
        ]
    ],
    'sentence' => [
        'auth' => [
            'login' => "お使いのSNSアカウントを使って\n登録・ログインができます。",
            'register' => [
                'cannot_edit' => '※登録後の変更はできません。',
                'can_edit' => '※登録後も設定から変更できます。',
            ]
        ],
        'account' => [
            'confirm' => [
                '1' => '本当にAnimaを退会してもよろしいですか？',
                '2' => 'これまでのレビュー記録やコメントが全て削除される可能性があります。',
                '3' => 'また、再度ご登録される際の復元は保証いたしません。',
            ]
        ],
        'comment' => [
            'confirm' => 'コメントを削除してもよろしいですか？',
        ],
        'review' => [
            'confirm' => 'レビューを削除してもよろしいですか？',
            'score' => 'スコアを設定しましょう。',
        ],
        'user' => [
            'cannot_edit' => '※登録後の変更はできません。',
            'can_edit' => '※登録後も設定から変更できます。',
        ],
        'home' => [
            'guest' => [
                '1' => 'アニメ情報・感想・レビュー評価ならAnima',
                '2' => '4000件以上のアニメから観たいアニメを見つけて、評価して、共有しよう。',
            ],
            'auth' => [
                '1' => "Animaでは、見たアニメのレビューを投稿したり、\nレビューを投稿している他のユーザーをフォロー\nすることで、タイムラインが作成されます。",
                '2' => "まずは見たアニメのレビューを投稿するか、\n気になる他のユーザーをフォローしてみましょう！",
            ]
        ]
    ],
    'button' => [
        'register_login' => '登録・ログイン',
        'register_login_start' => '登録・ログインしてはじめる',
        'follow' => 'フォローする',
        'following' => 'フォロー中',
        'edit_profile' => 'プロフィールを編集',
        'create' => '投稿',
        'edit' => '修正',
        'delete' => '削除する',
        'cancel' => 'キャンセル',
        'search' => '検索',
        'show_more' => 'さらに読み込む',
        'change' => '変更',
        'watchlist' => 'ウォッチリスト',
        'auth' => [
            'twitter' => 'Twitterで登録・ログイン',
            'facebook' => 'Facebookで登録・ログイン',
            'google' => 'Googleで登録・ログイン',
            'register' => '登録する',
        ],
        'comment' => [
            'create' => 'コメントを投稿する',
            'edit' => 'コメントを修正する',
            'delete' => 'コメントを削除する',
        ],
        'review' => [
            'share' => 'シェア',
            'create' => 'レビューを投稿する',
            'edit' => 'レビューを修正する',
            'delete' => 'レビューを削除する',
        ],
        'user' => [
            'save' => '保存',
        ],
    ],
    'label' => [
        '20_words' => '(20文字以内)',
        '300_words' => '(300文字以内)',
        'auth_user' => [
            'nickname' => 'Anima ID',
            'user_name' => 'ユーザー名',
            'content' => '自己紹介文',
            'profile' => 'プロフィール画像',
        ],
        'search' => [
            'placeholder' => 'アニメ作品・ユーザーを検索',
        ],
        'comment' => [
            'placeholder' => 'コメントを入力'
        ],
        'review' => [
            'placeholder' => 'コメントが入力できます。',
        ],
    ],
];
