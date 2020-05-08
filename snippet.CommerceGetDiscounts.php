<?php
if (!defined('MODX_BASE_PATH')) {
    die('HACK???');
}
$out = '';
$table = $modx->getFullTableName('commerce_discounts');
$action = !empty($action) ? $action : 'item';
$id = !empty($id) ? $id : '0';

include_once(MODX_BASE_PATH . 'assets/snippets/DocLister/lib/DLTemplate.class.php');
$parser = \DLTemplate::getInstance($modx);


//1 - category, 2 - products, 3 - tv relations, 4 - cart

switch ($action) {
    case 'item':
		//products
		$itemTpl = !empty($itemTpl) ? $itemTpl : '@CODE:( [+name+] [+discount_summ+])';
        $result = $modx->db->select("*", $table,  "discount_type = 2  AND active = 1 AND (`date_start` IS NULL OR `date_start`<=CURDATE()) AND (`date_finish` IS NULL OR `date_finish`>=CURDATE())");  

        if($modx->db->getRecordCount($result)) {
			$values = [];
			while( $row = $modx->db->getRow( $result ) ) {	
				$values['elements'] = json_decode($row['elements'],true);
				$values['name'] = $row['name'];
				$values['date_start'] = $row['date_start'];
				$values['date_finish'] = $row['date_finish'];
				$values['discount'] = $row['discount'];
				$values['discount_summ'] = $row['discount_summ'];
			}
			if (in_array($id,$values['elements'])){
				
				$out = $parser->parseChunk($itemTpl, $values);
			}
        }

        
        break;
    case 'groups':
		//groups
		$itemTpl = !empty($itemTpl) ? $itemTpl : '@CODE:( [+name+] [+discount_summ+])';
		
		$parents = $modx->getParentIds($id);
        $result = $modx->db->select("*", $table,  "discount_type = 1  AND active = 1 AND (`date_start` IS NULL OR `date_start`<=CURDATE()) AND (`date_finish` IS NULL OR `date_finish`>=CURDATE())");  

        if($modx->db->getRecordCount($result)) {
			$values = [];
			while( $row = $modx->db->getRow( $result ) ) {	
				$values['elements'] = json_decode($row['elements'],true);
				$values['name'] = $row['name'];
				$values['date_start'] = $row['date_start'];
				$values['date_finish'] = $row['date_finish'];
				$values['discount'] = (int)$row['discount'];
				$values['discount_summ'] = $row['discount_summ'];
			}
			foreach($parents as $one_parent){
				if(in_array($one_parent, $values['elements'])){
					$out .= $parser->parseChunk($itemTpl, $values);
				}
			}


        }
		
        
        
        break;
    default:
        break;
}

return $out;