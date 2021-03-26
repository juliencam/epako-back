## Requete test pour la route du panier 

```php

$test = 'SELECT * FROM `place` INNER JOIN `product_category` ON `product_category`.`id` = `place`.`id`  WHERE `department_id` = 85  AND `product_category`.`id` = 22'
}
```

```sql
 SELECT `place_category`.*,`place`.* ,`product_category`.*,`place`.`id` AS placeID FROM  `place_category`
 INNER JOIN `place` ON `place`.`place_category_id` = `place_category`.`id`
 INNER JOIN `product_category` ON `product_category`.`id` = `place`.`id`
 WHERE  `place` .`id` =  10
```

```sql
 SELECT `place_category`.*,`place`.`id` AS placeID, `product_category`.`id` AS PCId ,`product_category_place` FROM  `place_category`
 INNER JOIN `place` ON `place`.`place_category_id` = `place_category`.`id`
 INNER JOIN `product_category` ON `product_category_place`.`product_category_id` = `product_category`.`id`
 INNER JOIN `place` AS db ON  `product_category_place`.`place_id` = `place`.`id`
 WHERE  `place` .`id` =  26
 ```

```sql
 SELECT  `place_category`.`id` , `place`.`id` AS placeID, `product_category`.`id` AS PCId FROM `place_category`,`product_category_place`
 INNER JOIN `place` as db ON `db`.`place_category_id` = `place_category`.`id`
 INNER JOIN `product_category` ON `product_category_place`.`product_category_id` = `product_category`.`id`
 INNER JOIN `place`  ON  `product_category_place`.`place_id` = `place`.`id`
 ```
```sql
 SELECT  `place_category`.`id` , `place`.`id` AS placeID, `product_category`.`id` AS PCId FROM `place_category`,`product_category_place`
 INNER JOIN `product_category` ON `product_category_place`.`product_category_id` = `product_category`.`id`
 INNER JOIN `place`  ON  `product_category_place`.`place_id` = `place`.`id`
 WHERE `product_category`.`id`  = 25
 ```