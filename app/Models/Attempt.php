<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Attempt extends Model {
    protected $fillable = ['quiz_id','started_at','submitted_at','score'];

    public function quiz() {
        return $this->belongsTo(Quiz::class);
    }
    public function answers() {
        return $this->hasMany(Answer::class);
    }
}