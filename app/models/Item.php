<?php
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class Item extends Eloquent implements StaplerableInterface{
	
	use EloquentTrait;
	protected $table = 'item_master';
	protected $guarded = array('id');
	
	
	public function __construct(array $attributes = array()){
        
        $this->hasAttachedFile('image', [
            'url' => '/system/:attachment/:id_partition/:style/:filename',
            'styles' => [
                'thumbnail' => ['dimensions' => '100x100', 'auto-orient' => true, 'convert_options' => ['quality' => 100]],
                'micro'     => '50X50'
            ],
            
        ]);
    
        parent::__construct($attributes);
    }
    
    
    public function skins(){
    
    	return $this->belongsToMany('Skin','Item_Skin','item_id','skin_id');
    
    }
    
    public function category(){
    
    	return $this->belongsTo('Category','category_id','id');
    
    
    }
}