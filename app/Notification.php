<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Item;

class Notification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_id','receive_id','send_id','review_id'
    ];

    /**
     * 通知に関連するタイプ取得
     */
    public function type(){
        return $this->belongsTo('App\Type');
    }

    /**
     * 通知に関連するレビュー取得
     */
    public function review(){
        return $this->belongsTo('App\Review');
    }

    /**
     * ユーザーに関連する通知情報取得
     */
    public function getUserNotifications(int $user_id){
        $notifications = Notification::where('receive_id', $user_id)->get();
        foreach ($notifications as $notification) {
            $notification->user = User::find($notification->send_id);
            $notification->type = $notification->type->name;
            if($notification->type != 'follow'){
                $item_id = $notification->review->item_id;
                $notification->item = Item::find($item_id);
            }
        }

        return $notifications;
    }

    /**
     * 通知チェック
     */
    public function checkUserNotifications(int $user_id){
        $notifications_count = Notification::where('receive_id', $user_id)->count();
        if($notifications_count > 9){
            $notifications_count = "9+";
        }
        return $notifications_count;
    }
}
