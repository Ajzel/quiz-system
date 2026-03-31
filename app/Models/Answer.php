<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model {
    protected $fillable = ['attempt_id','question_id','value'];
    protected $casts = ['value' => 'array'];

    public function question() {
        return $this->belongsTo(Question::class);
    }
}