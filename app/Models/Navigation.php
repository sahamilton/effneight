<?php
namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
/**
* Navigation
*/
class Navigation extends Model {
  use NodeTrait;
  /**
   * Table name.
   *
   * @var string
   */
  protected $table = 'navigations';

  protected $fillable=[
      'parent_id',
      'group',
      'display_name',
      'name','route',
      'icon',
      'sequence',
      'published'
    ];

    public function getLftName()
    {
        return 'left';
    }

    public function getRgtName()
    {
        return 'right';
    }

    public function getParentIdName()
    {
        return 'parent_id';
    }

    // Specify parent id attribute mutator
    public function setParentAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    public function scopePublished($query)
    {
        return $query->wherePublished(1);
    }

    public function getItem(){
      return 
          '<li class="mr-6 my-2 md:my-0">
            <a class="block py-1 md:py-3 pl-1 align-middle text-gray-500 no-underline hover:text-gray-900 border-b-2 border-white hover:border-pink-500"'
              . $this->getLink() .
            '</a>
          </li>';
    
    }
    public function getDropdownItem(){
      return '<a class="dropdown-item"' 
                . $this->getLink() .
             ' </a>';
    }

    private function getLink(){
      
      return ' href="' . route($this->route).'">
                    <i class="'. $this->icon .'"></i>'
                      . $this->display_name;
    }

    public  function getNavBar($id){
      
      $navItems = $this->findOrFail($id)->descendants()->get();
      $navBar= array();
      foreach ($navItems as $nav){
         
          $navBar[] = $nav->getItem();
      }
   
      return $navBar;
    }
}
