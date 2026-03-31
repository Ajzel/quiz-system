<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Question extends Model {
    protected $fillable = ['quiz_id','type','body','image','video_url','marks','order'];

    public function quiz() {
        return $this->belongsTo(Quiz::class);
    }
    public function options() {
        return $this->hasMany(Option::class);
    }
}