<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EAduan;
use DB;

class PortalCms extends Model
{
    use EAduan;
    
    protected $table = 'sys_articles';
    
    protected $fillable = [
        'title_my', 'title_en', 'content_my', 'content_en', 'link', 'menu_id', 'status', 'hits', 'cat', 'photo'
    ];
    
    public static function GetPortalContent($cat)
    {
        $mArticles = DB::table('sys_articles')->where(['cat' => $cat, 'status' => '1'])->get();
        return $mArticles;
    }
    
    public function UpdatedBy() {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}