# data dictionary

## product

|Champ|Type|Specificities|Description|
|----|:-----:|------|-------:|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|product id|
|name|VARCHAR(128)|NOT NULL| product name |
|content|LONGTEXT|NOT NULL|product content |
|price|double|NOT NULL, UNSIGNED, DEFAULT 0|product price|
|status|smallint|NOT NULL, UNSIGNED, DEFAULT 0|product status (0=actif, 1=inactif)|
|created_at|DATETIME|NOT NULL, ON UPDATE|date of product creation|
|updated_at|DATETIME|NULL, ON UPDATE|date of picture update|
|brand|VARCHAR(64)|NOT NULL| brand of product |
|tendance_boolean|tinyint(1)|NULL, DEFAULT 0| boolean for category tendance |

----

## productcategory

|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|product category id|
|parent_id|entity|NULL, foreign key, index| ProductCategory|
|name|VARCHAR(64)|NOT NULL, UNIQUE|product category name|
|pictogram|VARCHAR(255)|NULL| product category pictogram|
|created_at|DATETIME|NOT NULL, ON UPDATE|date of product category creation|
|updated_at|DATETIME|NULL, ON UPDATE|date of product category update|
|image|VARCHAR(255)|NOT NULL| image of product category |

---

## product_product_category
|Champ|Type|Specificities|Description|
|----|:-----:|------|-------:|
|product_id|INT(11)|PRIMARY KEY, NOT NULL, UNSIGNED, foreign key, index |product id|
|product_category_id|INT(11)|PRIMARY KEY, NOT NULL, UNSIGNED, foreign key, index |product category id|

---

## place

|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|place id|
|name|VARCHAR(64)|NOT NULL|name of place|
|address|VARCHAR(255)|NOT NULL|address of place|
|address_complement|VARCHAR(64)|NULL|address complement of place|
|city|VARCHAR(64)|NOT NULL|city of place|
|logo|VARCHAR(255)| NULL|place logo url|
|status|smallint|NOT NULL, UNSIGNED, DEFAULT 1|place status (0=actif, 1=inactif)|
|created_at|DATETIME|NOT NULL , ON UPDATE|date of place creation|
|updated_at|DATETIME|NULL, ON UPDATE|date of place update|
|published_at|DATETIME|NULL, ON UPDATE|date of place publication|
|image|VARCHAR(255)|NOT NULL| image of place |
|url|VARCHAR(620)|NULL| url of place |
|content|LONGTEXT|NULL|content of place |
|department_id|entity|NOT NULL, index, foreign key|the department of the place|
|place_category_id|entity|NOT NULL, index, foreign key|the category of the place|

---

## product_category_place
|Champ|Type|Specificities|Description|
|----|:-----:|------|-------:|
|product_category_id|INT(11)|PRIMARY KEY, NOT NULL, foreign key, index |product category id|
|place_id|INT(11)|PRIMARY KEY, NOT NULL,  foreign key, index |place id|

---

## image

|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|image id|
|alt|VARCHAR(128)|NULL|description of image|
|url|VARCHAR(255)|NULL|url of image|
|displayOrder|smallint|NOT NULL, UNSIGNED, DEFAULT 0|Order of the image,if there are several |
|image|VARCHAR(255)|NOT NULL| image of image |
|name|VARCHAR(255)|NULL|name of image|
|created_at|DATETIME|NOT NULL, ON UPDATE|date of image creation|
|updated_at|DATETIME|NULL, ON UPDATE|date of image update|
|product_id|entity|NULL, index, foreign key|the product of image |
---


## place_category

|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|the id of the category of the place|
|name|VARCHAR(64)|NOT NULL, UNIQUE|place name|
|pictogram|VARCHAR(255)|NULL|the url of pictogram of place category|
|created_at|DATETIME|NOT NULL, ON UPDATE|date of place category creation|
|updated_at|DATETIME|NULL, ON UPDATE|date of place category update|
|image|VARCHAR(255)|NOT NULL| image of place category |

---

## department

|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|department id|
|name|VARCHAR(64)|NOT NULL, UNIQUE|name of department |
|postalcode|VARCHAR(7)|NOT NULL, UNIQUE|postalcode of department (only the first two digits or character)|
|created_at|DATETIME|NOT NULL, ON UPDATE|date of department creation|
|updated_at|DATETIME|NULL, DEFAULT ON UPDATE|date of department update|

---

## user



|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|user id|
|nickname|VARCHAR(64)|NOT NULL|name of user |
|email|VARCHAR(180)|NOT NULL, UNIQUE|email of user|
|role|longText|NOT NULL|role (DC2Type:json)|
|password|VARCHAR(255)|NOT NULL|password of user|
|status|smallint|NOT NULL, UNSIGNED, DEFAULT 0|status of user (0=actif, 1=inactif 2=banned)|
|created_at|DATETIME|NOT NULL, ON UPDATE|date of user creation|
|updated_at|DATETIME|NULL, DEFAULT ON UPDATE|date of user update|

---
## review


|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|review id |
|content|LONGTEXT|NOT NULL|content of review |
|rate|smallint|NOT NULL, DEFAULT 1, UNSIGNED|the rate of the review (from 1 to 5)|
|status|smallint|NOT NULL, UNSIGNED, DEFAULT 1|status of user  (0=actif, 1=inactif)|
|created_at|DATETIME|NOT NULL, ON UPDATE|date of review creation|
|updated_at|DATETIME|NULL, ON UPDATE|date of review update|
|published_at|DATETIME|NULL, ON UPDATE|date of review publication|
|user_id|entity|NULL, index, foreign key|the user's review|
|place_id|entity|NULL, index, foreign key|the place's review|