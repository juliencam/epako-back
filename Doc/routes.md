# Routes

| URL                                    | Method HTTP | Controller                     | name                              | Content                        | Comment  |
| -------------------------------------- | ----------- | ------------------------------ | --------------------------------- | ------------------------------ | -------- |
| **BACK OFFICE**                        | -------     | ---------                      | ------                            | --------                       | -------- |
| **URL product**                        | -------     | ---------                      | ------                            | --------                       | -------- |
| `back/product/browse`                  | `GET`       | `ProductController`            | `back_product_browse`             | diplay all product             | -        |
| `back/product/edit/[id]`               | `GET POST`  | `ProductController`            | `back_product_edit`               | edit product                   | -        |
| `back/product/add`                     | `GET POST`  | `ProductController`            | `back_product_add`                | add product                    | -        |
| `back/product/delete/[id]`             | `DELETE`    | `ProductController`            | `back_product_delete`             | delete product                 | -        |
| **URL product category**               | -------     | ---------                      | ------                            | --------                       | -------- |
| `back/product/category/browse`         | `GET`       | `ProductCategoryController`    | `back_product_category_browse`    | diplay all product category    | -        |
| `back/product/category/edit/[id]`      | `GET POST`  | `ProductcategoryController`    | `back_product_category_edit`      | edit product category          | -        |
| `back/product/category/add`            | `GET POST`  | `ProductcategoryController`    | `back_product_category_add`       | add product category           | -        |
| `back/product/category/delete/[id]`    | `DELETE`    | `ProductcategoryController`    | `back_product_category_delete`    | delete product category        | -        |
|
| **URL place**                          | -------     | ---------                      | ------                            | --------                       | -------- |
| `back/place/browse`                    | `GET`       | `PlaceController`              | `back_place_browse`               | diplay all place               | -        |
| `back/place/edit/[id]`                 | `GET POST`  | `PlaceController`              | `back_place_edit`                 | edit place                     | -        |
| `back/place/add`                       | `GET POST`  | `PlaceController`              | `back_place_add`                  | add place                      | -        |
| `back/product/subcategory/delete/[id]` | `DELETE`    | `PlaceController`              | `back_place_delete`               | delete place                   | -        |
| **URL place category**                 | -------     | ---------                      | ------                            | --------                       | -------- |
| `back/place/category/browse`           | `GET`       | `PlaceCategoryController`      | `back_place_category_browse`      | diplay all place category      | -        |
| `back/place/category/edit/[id]`        | `GET POST`  | `PlaceCategoryController`      | `back_place_category_edit`        | edit place category            | -        |
| `back/place/category/add`              | `GET POST`  | `PlaceCategoryController`      | `back_place_category_add`         | add place category             | -        |
| `back/place/category/delete/[id]`      | `DELETE`    | `PlaceCategoryController`      | `back_place_category_delete`      | delete place category          | -        |
| **URL user**                           | -------     | ---------                      | ------                            | --------                       | -------- |
| `back/user/browse`                     | `GET`       | `UserController`               | `back_user_browse`                | diplay all user                | -        |
| `back/user/edit/[id]`                  | `GET POST`  | `UserController`               | `back_user_edit`                  | edit user                      | -        |
| `back/user/add`                        | `GET POST`  | `UserController`               | `back_user_add`                   | add user                       | -        |
| `back/user/delete/[id]`                | `DELETE`    | `UserController`               | `back_user_delete`                | delete user                    | -        |
| **URL departement**                    | -------     | ---------                      | ------                            | --------                       | -------- |
| `back/department/browse`               | `GET`       | `DepartmentController`         | `back_department_browse`          | diplay all department          | -        |
| `back/department/edit/[id]`            | `GET POST`  | `DepartementController`        | `back_department_edit`            | edit department                | -        |
| `back/department/add`                  | `GET POST`  | `DepartmentController`         | `back_department_add`             | add department                 | -        |
| `back/department/delete/[id]`          | `DELETE`    | `DepartmentController`         | `back_department_delete`          | delete department              | -        |
| **URL /review**                        | -------     | ---------                      | ------                            | --------                       | -------- |
| `back/review/browse`                   | `GET`       | `ReviewController`             | `back/review_browse`              | diplay all review              | -        |
| `back/review/edit/[id]`                | `GET POST`  | `ReviewController`             | `back/review_edit`                | edit review                    | -        |
| `back/review/add`                      | `GET POST`  | `ReviewController`             | `back/review_add`                 | add review                     | -        |
| `back/review/delete/[id]`              | `DELETE`    | `ReviewController`             | `back/review_delete`              | delete review                  | -        |
| **API**                                | -------     | ---------                      | ------                            | --------                       | -------- |
| **URL /place**                         | -------     | ---------                      | ------                            | --------                       | -------- |
| `api/place/browse`                     | `GET`       | `PlaceController`              | `api/place_browse`                | diplay all place               | -        |
| `api/place/read/[id]`                  | `GET`       | `PlaceController`              | `api/place_edit`                  | read place                     | -        |
| `api/place/category/department/read/[id]/[int]`       | `GET`       | `ProductCategoryController`    | `api/product_category_edit`       | read product by category and postalcode          | -        |  |
| **URL /place category**                | -------     | ---------                      | ------                            | --------                       | -------- |
| `api/place/category/browse`            | `GET`       | `PlaceCategoryController`      | `api/place_category_browse`       | diplay all place category      | -        |
| `api/place/category/read/[id]`         | `GET`       | `PlaceCategoryController`      | `api/place_category_edit`         | read place category            |
| **URL /product**                       | -------     | ---------                      | ------                            | --------                       | -------- |
| `api/product/browse`                   | `GET`       | `ProductController`            | `api/product_browse`              | diplay all product             | -        |
| `api/product/read/[id]`                | `GET`       | `ProductController`            | `api/product_edit`                | read product                   | -        |
| **URL /product category**              | -------     | ---------                      | ------                            | --------                       | -------- |
| `api/product/category/browse`          | `GET`       | `ProductCategoryController`    | `api/product_category_browse`     | diplay all product category    | -        |
| `api/product/category/read/[id]`       | `GET`       | `ProductCategoryController`    | `api/product_category_edit`       | read product category          | -        |  |
|
| **URL /department**                    | -------     | ---------                      | ------                            | --------                       | -------- |
| `api/department/browse`                | `GET`       | `DepartmentController`         | `api/department_browse`           | diplay all department          | -        |
| `api/department/read/[id]`             | `GET`       | `DepartmentController`         | `api/department_edit`             | read department                | -        |
