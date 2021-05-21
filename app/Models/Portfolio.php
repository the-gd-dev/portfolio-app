<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $appends = ['portfolio_image'];
    protected $fillable = [
        'user_id',
        'pcat_id',
        'name',
        'description',
        'link',
        'order',
        'project_date',
        'client_name',
        'portfolio_cover'
    ];
    public function getPortfolioImageAttribute(){
        if(!empty($this->portfolio_cover)){
            return $this->images()->find($this->portfolio_cover) ?? $this->images->first();
        }
        return '';
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->hasOne(PortfolioCategory::class, 'id', 'pcat_id');
    }
    public function images(){
        return $this->hasMany(PortfolioImages::class)->orderBy('order');
    }
}
