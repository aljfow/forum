<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use FavouriteTable, RecordsActivity;
    
	protected $guarded = [];
    
	protected $with = ['owner', 'favourites'];

    protected $appends = ['favouritesCount', 'isFavourited'];
    
    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
    	return $this->belongsTo('App\Thread');
    }

    public function path()
    {
        return $this->thread->path() . '#reply-' . $this->id;
    }
}
