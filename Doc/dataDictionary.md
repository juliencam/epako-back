# data dictionary

## Product (`product`)

|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|product id|
|name|VARCHAR(64)|NOT NULL| product name |
|content|TEXT|NOT NULL|product content |
|price|DECIMAL(10,2)|NOT NULL, DEFAULT 0|product price|
|status|TINYINT(1)|NOT NULL,UNSIGNED, DEFAULT 0|product status (0=actif, 1=inactif)|
|created_at|DATETIME|DEFAULT ON UPDATE|date of product creation|
|updated_at|DATETIME|NULL, DEFAULT ON UPDATE|date of picture update|
|sub_category|entity|NOT NULL, foreign key |the subcategory of product|

## Image (`image`)

|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|image id|
|alt|VARCHAR(128)|NULL|picture description|
|url|VARCHAR(128)|NOT NULL, UNIQUE|url|
|order|TINYINT(1)|NOT NULL, DEFAULT 0|Order of the picture,if there are several |
|created_at|DATETIME|DEFAULT ON UPDATE|date of picture creation|
|updated_at|DATETIME|NULL, DEFAULT ON UPDATE|date of picture update|
|product|entity|NULL, foreign key|the product of picture |

## Product Category(`productcategory`)

|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|product category id|
|name|VARCHAR(64)|NOT NULL, UNIQUE|product category name|
|pictogram|VARCHAR(20)|NOT NULL| product category pictogram|
|parent|entity|NULL, foreign key| Category object|
|childCategorys|entity|NULL, foreign key| childCategory of Category|
|created_at|DATETIME|DEFAULT ON UPDATE|date of product category creation|
|updated_at|DATETIME|NULL, DEFAULT ON UPDATE|date of product category update|

## User (`user`)

|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|user id|
|nickname|VARCHAR(64)|NOT NULL|user name|
|email|VARCHAR(64)|NOT NULL, UNIQUE|user email|
|role|longText|NOT NULL,DEFAULT ["ROLE_USER"]|role (DC2Type:json)|
|password|VARCHAR(255)|NOT NULL|user password|
|status|smallint(1)|NOT NULL, UNSIGNED, DEFAULT 0|user status (0=actif, 1=inactif 2=banned)|
|created_at|DATETIME|DEFAULT ON UPDATE|date of user creation|
|updated_at|DATETIME|NULL, DEFAULT ON UPDATE|date of user update|

## Review (`review`)

|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|review id |
|content|TEXT|NOT NULL|review content |
|rate|smallint(1)|NOT NULL, DEFAULT 1|the rate of the review (from 1 to 5)|
|status|smallint(1)|NOT NULL, UNSIGNED, DEFAULT 1|user status (0=actif, 1=inactif 2=banned)|
|created_at|DATETIME|DEFAULT ON UPDATE|date of review creation|
|updated_at|DATETIME|NULL, DEFAULT ON UPDATE|date of review update|
|published_at|DATETIME|NULL, DEFAULT ON UPDATE|date of review publication|
|user|entity|NOT NULL, foreign key|the user's review|
|place|entity|NULL, foreign key|the place's review|

## Place(`place`)

|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|place id|
|name|VARCHAR(64)|NOT NULL|place name|
|address|VARCHAR(255)|NOT NULL|place address|
|address_complement|VARCHAR(64)|NULL|place address complement|
|city|VARCHAR(64)|NOT NULL|place city|
|logo|VARCHAR(64)| NULL|place logo (picture)|
|status|smallint(1)|NOT NULL, UNSIGNED, DEFAULT 1|place status (0=actif, 1=inactif 2=banned)|
|created_at|DATETIME|DEFAULT ON UPDATE|date of place creation|
|updated_at|DATETIME|NULL, DEFAULT ON UPDATE|date of place update|
|published_at|DATETIME|NULL, DEFAULT ON UPDATE|date of place publication|
|department|entity|NOT NULL, foreign key|the department of the place|
|place_category|entity|NOT NULL, foreign key|the category of the place|

## Place Category (`place_category`)

|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|the id of the category of the place|
|name|VARCHAR(64)|NOT NULL, UNIQUE|place name|
|pictogram|VARCHAR(20)|NOT NULL|place category pictogram|
|created_at|DATETIME|DEFAULT ON UPDATE|date of place category creation|
|updated_at|DATETIME|NULL, DEFAULT ON UPDATE|date of place category update|


## Department(`department`)

|Champ|Type|Specificities|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|department id|
|name|VARCHAR(64)|NOT NULL, UNIQUE|department name|
|postalcode|smallint|NOT NULL, UNSIGNED, UNIQUE|department postalcode (only the first two digits)|
|created_at|DATETIME|DEFAULT ON UPDATE|date of department creation|
|updated_at|DATETIME|NULL, DEFAULT ON UPDATE|date of department update|