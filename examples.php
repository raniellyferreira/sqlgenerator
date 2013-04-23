<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Generator Examples</title>
</head>

<body>
<?php 
include_once('sql_generator.class.php');

$sql = new Sqlgen();

//INSERT*************************************
$dados = array('column1' => 'val1',
'column2' => 'val2',
'column3' => 'val3',
'column4' => 123456
);

echo $sql->insert('table',$dados);

//RESULT: INSERT INTO `table` (`column1`, `column2`, `column3`, `column4`) VALUES ('val1', 'val2', 'val3', 123456)

echo str_repeat('<p>&nbsp;</p>',2);


//MASS INSERT*************************************
$dados = array(  array('column1' => 'val1','column2' => 'val2','column3' => 'val3','column4' => 123456),
				array('column1' => 'val1','column2' => 'val2','column3' => 'val3','column4' => 123456),
				array('column1' => 'val1','column2' => 'val2','column3' => 'val3','column4' => 123456),
				array('column1' => 'val1','column2' => 'val2','column3' => 'val3','column4' => 123456)
		);

echo $sql->mass_insert('table',$dados);

//RESULT: INSERT INTO `table` (`column1`, `column2`, `column3`, `column4`) VALUES ('val1', 'val2', 'val3', 123456), ('val1', 'val2', 'val3', 123456), ('val1', 'val2', 'val3', 123456), ('val1', 'val2', 'val3', 123456)

echo str_repeat('<p>&nbsp;</p>',2);
##################################################################################################################################################################
##################################################################################################################################################################
//SELECT*************************************
//OPTIONAL
$sql->select('tab1.column1,tab1.column2,tab1.column3,column4,tab2.*,SUM(tab1.column) as newvar');
//WHERE**************************************
$sql->where('column1','val1');
$sql->where('column2 >',1);
$sql->where('column3','val3','OR');
//OR
$sql->where(array('column1' => 'val1', 'column2 >' => 1),NULL,'AND');
//WHERE IN***************************************

$sql->add_before();
$sql->where_in('column1',array('val1','val2','val3',123345));
$sql->add_after();
$sql->where_in('column2',array('val1','val2','val3',123345),'and','not'); //GENERATE NOT IN


//ADD PARENTHESIS BEFORE THE NEXT PARAMETER. (.
$sql->add_before();
//LIKE***************************************
$sql->like('column3','val3','both'/* before, after, both (default) OR none */,'AND');
//RESULT WHERE ... AND column3 LIKE '%val3%'

//ADD PARENTHESES AFTER THE NEXT PARAMETER.
$sql->add_after();
$sql->like('column2','val3','before','OR');
//RESULT ... OR column2 LIKE '%val3'

//OOORRRRR
//ADD PARENTHESES BEFORE AND AFTER THE NEXT PARAMETER.
$sql->add_both();
$sql->like('column2','val3','before','OR');

//JOIN***************************************
$sql->join('tab2','tab1.id = tab2.id');
//OR
$sql->join('tab3','tab2.id = tab3.id','inner'); //OPTIONS left, right, outer, inner, left outer, and right outer


//BETWEEN************************************

$sql->between('column',0,100);

//GENERATE NOT BETWEEN
$sql->between('column2',0,100,'and','not');

//GROUP BY and HAVING************************

$sql->group_by('column1');
$sql->having('column1 >',1356);
$sql->having('column2 >',1358,'and');

//ORDER**************************************
$sql->order_by('calumn1','asc'); //asc or desc
//OR
$sql->order_by('calumn2 asc'); //asc or desc
//OR
$sql->order_by('rand'); // accept rand(), RAND, RAND()
//FOR ADD MORE REPEAT THIS FUNCTION

//LIMIT**************************************
$limite = 10;
$inicio = 5;

$sql->limit($limite);
//GENERATES: LIMIT 10
//OR
$sql->limit($limite,$inicio);
//GENERATES: LIMIT 5,10

//GENERATE SQL SELECT************************
echo $sql->get('table');
/*
RESULT:
SELECT `tab1`.`column1`,`tab1`.`column2`,`tab1`.`column3`,`column4`,`tab2`.*,SUM(`tab1`.`column`) as newvar FROM (`table`)
JOIN `tab2` ON `tab1`.`id` = `tab2`.`id`
INNER JOIN `tab3` ON `tab2`.`id` = `tab3`.`id`
WHERE `column1` = 'val1'
AND `column2` > 1
OR `column3` = 'val3'
AND `column1` = 'val1'
AND `column2` > 1
AND (`column1` IN ('val1','val2','val3',123345)
AND `column2` NOT IN ('val1','val2','val3',123345))
AND (`column3` LIKE '%val3%'
OR `column2` LIKE '%val3')
OR (`column2` LIKE '%val3')
AND `column` BETWEEN '0' AND '100'
AND `column2` NOT BETWEEN '0' AND '100'
GROUP BY `column1`
HAVING `column1` > 1356
AND `column2` > 1358
ORDER BY RAND()
LIMIT 5,10
*/

echo '<br>';
//OR
echo $sql->get('table',array('column1' => 'val1','column2' => 'val2'));//--WHERE; AND DEFAULT
//RESULT: SELECT * FROM (`table`) WHERE `column1` = 'val1' AND `column2` = 'val2'

echo str_repeat('<p>&nbsp;</p>',2);
##################################################################################################################################################################
##################################################################################################################################################################
//UPDATE*************************************
$dados = array('column1' => 'val1',
'column2' => 'val2',
'column3' => 'val3',
'column4' => 'val4'
);

$sql->where('column1','val1');
$sql->where('column2','val2'); // AND DEFAULT
echo $sql->update('table',$dados);
//RESULT UPDATE (`table`) SET `column1` = 'val1', `column2` = 'val2', `column3` = 'val3', `column4` = 'val4' WHERE `column1` = 'val1' AND `column2` = 'val2'

echo '<br>';
//OR
echo $sql->update('table',$dados,array('column1' => 'val1','column2' => 'val2'));//--WHERE; AND DEFAULT
//RESULT UPDATE (`table`) SET `column1` = 'val1', `column2` = 'val2', `column3` = 'val3', `column4` = 'val4' 
//WHERE `column1` = 'val1' AND `column2` = 'val2'

echo str_repeat('<p>&nbsp;</p>',2);
##################################################################################################################################################################
##################################################################################################################################################################
//DELETE*************************************
$sql->where('column1','val1');
$sql->where('column2','val2'); // AND DEFAULT

echo $sql->delete('table');
//RESULT DELETE FROM `table` 
//WHERE `column1` = 'val1' AND `column2` = 'val2'
echo '<br>';
//OR
echo $sql->delete('table',array('column1' => 'val1','column2' => 'val2')); //--WHERE; AND DEFAULT
//DELETE FROM `table` 
//WHERE `column1` = 'val1' AND `column2` = 'val2'

echo str_repeat('<p>&nbsp;</p>',3);
##################################################################################################################################################################
##################################################################################################################################################################
//Allowed chaining
echo $sql->print_debugger();
echo str_repeat('<p>&nbsp;</p>',3);
echo $sql->select('name,tel')->limit(1)->where('name','Tais')->order_by('name','asc')->get('tabela');



?>
</body>
</html>
