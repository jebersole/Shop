<?php
namespace Entities;

use Entities\Entity;

class Snack extends Entity {
    
    public function __construct()
    {
        parent::__construct('snacks');
    }
    
    public function getUnitMap()
    {
        $items = $this->getWithJoin(['snacks.name', 'units.name'], ['units', 'snacks.unit_id', 'units.id']);
        $map = [];
        foreach ($items as $item) {
            // one unit is one snack item
            $map[$item['name'][0]] = $item['name'][1] === 'unit' ? $item['name'][0] : $item['name'][1];
        }
        return $map; 
    }
    
    public function getPrices()
    {
        return $this->get(['id', 'name', 'price']);; 
    }
}