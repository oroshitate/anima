<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Basic Language Lines
    | 基本言語
    |--------------------------------------------------------------------------
    */

    'title' => [
        '401' => 'Unauthorized',
        '403' => 'Forbidden',
        '404' => 'Not Found',
        '419' => 'Session Has Expired',
        '429' => 'Too Many Access',
        '500' => 'Server Error',
        '503' => 'Maintenance',
    ],
    'sentence' => [
        '401' => [
            '1' => '認証に失敗しました',
            '2' => 'お手数ですが、右上のログインボタンより再度ログインしてください',
        ],
        '403' => [
            '1' => 'お探しのページに対するアクセス権限はありません',
        ],
        '404' => [
            '1' => 'お探しのページは見つかりませんでした',
        ],
        '419' => [
            '1' => 'セッションの有効期限が切れています',
            '2' => 'お手数ですが、右上のログインボタンより再度ログインしてください',
        ],
        '429' => [
            '1' => '現在アクセスが集中し、繋がりにくい状態です',
            '2' => '申し訳ございませんが、しばらく時間を置いてからアクセスしてください',
        ],
        '500' => [
            '1' => 'お探しのページを正しく表示できませんでした',
            '2' => '申し訳ございませんが、再度読み込んで頂くかしばらく時間を置いてからお試しください',
        ],
        '503' => [
            '1' => '現在メンテナンス中です',
            '2' => '申し訳ございませんが、メンテナンスが終了するまでしばらくお待ちください',
        ]
    ]
];
