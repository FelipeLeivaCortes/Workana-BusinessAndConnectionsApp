<?php
require '../vendor/autoload.php';
use Models\Category\CategoryModel;
use Models\Subcategory\SubcategoryModel;

use function Helpers\dd;
use function Helpers\redirect;
use function Helpers\generateUrl;

class CategoryController
{

    public function consultCateogries(){
        $objCategory= new CategoryModel();
        $categories=$objCategory->consultCategories();
        $objSubcategory=new SubcategoryModel();
        foreach ($categories as &$cat) {
            $subcategories = $objSubcategory->consultSubcategoriesByCategory($cat['cat_id']);
            $cat['subcategories'] = $subcategories;
        }
        
        include_once '../app/Views/category/categoryConsult.php';
    }
    public function createSubcategoryModal(){
        $objCategory= new CategoryModel();
        $cat_id=$_POST['id'];
        $category=$objCategory->consultCategoryById($cat_id); 
        include_once '../app/Views/category/stockModalCreateSubcategory.php';
    }
    public function insertSubcategory(){
        $name=$_POST['subcat_name'];
        $desc=$_POST['subcat_desc'];
        $cat_id=$_POST['cat_id'];
        $objSubcategory=new SubcategoryModel();
        $objSubcategory->insertSubcategroy($name,$desc,$cat_id);
        redirect(generateUrl("Category","Category","consultCateogries"));
    }

    public function insertCategory(){
        $cat_name = isset($_POST['cat_name']) ? $_POST['cat_name'] : '';
        $cat_desc = isset($_POST['cat_desc']) ? $_POST['cat_desc'] : '';
    
        // Verificar si los datos están vacíos o faltantes
        if (empty($cat_name)) {
            // Mostrar una alerta si el nombre de la categoría está vacío
            echo "<script>alert('Por favor, ingresa un nombre para la categoría.');</script>";
            // Redirigir de vuelta a la página de registro
            redirect(generateUrl("Category", "Category", "consultCateogries"));
            return; // Salir de la función para evitar la inserción
        }
    
        // Si todos los datos son válidos, realizar la inserción en la base de datos
        $objCat = new CategoryModel();
        $objCat->insertCategory($cat_name, $cat_desc);
    
        // Redirigir a la página de consulta de categorías
        redirect(generateUrl("Category", "Category", "consultCateogries"));
    }
    


    public function UpdateCategoryModal(){
        $cat_id=$_POST['cat_id'];
        $objCat= new CategoryModel();
        $category=$objCat->consultCategoryById($cat_id);
        include_once '../app/Views/category/categoryUpdate.php';
    }

    public function updateCategory(){
        $cat_id=$_POST['cat_id'];
        $cat_name=$_POST['cat_name'];
        $cat_desc=$_POST['cat_desc'];
        $objCat= new CategoryModel();
        $objCat->UpdateCategory($cat_id,$cat_name,$cat_desc);
        redirect(generateUrl("Category","Category","consultCateogries"));   
    }


    public function DeleteCategory(){
        $cat_id=$_POST['cat_id'];
        $objCat= new CategoryModel();
        $objCat->DeleteCategory($cat_id);
    }



}






?>