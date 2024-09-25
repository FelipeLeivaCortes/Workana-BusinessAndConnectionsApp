<?php
require '../vendor/autoload.php';
use Models\Groups\GroupsModel;
use Models\Articles\ArticlesModel;
use Models\Category\CategoryModel;
use Models\Company\CompanyModel;
use Models\Customer_discounts\Customer_discountsModel;
use Models\Subcategory\SubcategoryModel;
use Models\User\UserModel;
use function Helpers\dd;
use function Helpers\generateUrl;
use function Helpers\redirect;

class GroupsController{

    public function viewCreateGroups()
    {
        $objGroups = new GroupsModel();
        $groups = $objGroups->consultGroups();
    
        $objCustomerDiscounts = new Customer_discountsModel();
        $objCompany = new CompanyModel();
        $objArt = new ArticlesModel();
        $objCat = new CategoryModel();
        $objSub = new SubcategoryModel();
    
        foreach ($groups as &$gp) {
            $customer_discounts = $objCustomerDiscounts->consultDiscounts($gp['gp_id']);
    
            $gp['Companies'] = [];
            $gp['Articles'] = [];
            $gp['Categories'] = [];
            $gp['Subcategories'] = [];
    
            foreach ($customer_discounts as $cust) {
                $companies = $objCompany->ConsultCompany($cust['c_id']);
                $articles = $objArt->consultArticleById($cust['ar_id']);
                $categories = $objCat->consultCategoryById($cust['cat_id']);
                $subcategories = $objSub->consultSubcategoryById($cust['sbcat_id']);
            
                $gp['Companies'][] = $companies; // Add [0] to access the first element of the array
                $gp['Articles'][] = $articles; // Add [0] to access the first element of the array
                $gp['Categories'][] = $categories; // Add [0] to access the first element of the array
                $gp['Subcategories'][] = $subcategories; // Add [0] to access the first element of the array
            }
            
        }
        include_once '../app/Views/groups/groupsCreate.php';
    }
    

    public function viewModalCreate()
    {
        $article = new ArticlesModel();
        $articles = $article->consultArticles();
    
        $category = new CategoryModel();
        $categories = $category->consultCategories();
    
        $objUser = new UserModel();
        $userClients = $objUser->consultUsersWithRolAndStatus('3', '1');
        $company = new CompanyModel();
        $companies = array(); // Create an array to store the companies       
        foreach ($userClients as $usc) {
            $companyInfo = $company->ConsultCompany($usc['c_id']);
            // Merge the company information into the $companies array
            $companies = array_merge($companies, $companyInfo);
        }


    
        $subcategory = new SubcategoryModel();
        $subcategories = $subcategory->consultSubcategories();
    
        include_once '../app/Views/groups/groupsModalCreate.php';
    }

   
    
    public function InsertGroups(){
        $name = isset($_POST['nameGroup']) ? $_POST['nameGroup'] : null;
        $discount_percentage = isset($_POST['discount_percentage']) ? $_POST['discount_percentage'] : null;
        $coupon = isset($_POST['coupon']) ? $_POST['coupon'] : null;
        $price = isset($_POST['price']) ? $_POST['price'] : null;
        $companies = isset($_POST['companies']) ? $_POST['companies'] : null;
        $categories = isset($_POST['categories']) ? $_POST['categories'] : null;
        $subcategories = isset($_POST['subcategories']) ? $_POST['subcategories'] : null;
        $articles = isset($_POST['articles']) ? $_POST['articles'] : null;
        $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : null;        
        $group= new GroupsModel();
        $group->insertGroup($name,$discount_percentage,$coupon,$date_end);
        $gp_id=$group->getLastId('group_discounts','gp_id');
        $discounts= new Customer_discountsModel();
        $discounts->insertCustomer_discounts($companies,$categories,$subcategories,$articles,$gp_id,$price);
        redirect(generateUrl("Groups","Groups","viewCreateGroups"));
    }

    public function viewModalUpdateGroup(){
        // var_dump($_POST);
        $obj= new GroupsModel();
        $id=$_POST['id'];
        $group=$obj->consultGroupById($id);
        
        $objCustomerDiscounts= new Customer_discountsModel();
        $result=$objCustomerDiscounts->consultDiscounts($id);
        // dd($result);
        $article = new ArticlesModel();
        $articles = $article->consultArticles();
    
        $category = new CategoryModel();
        $categories = $category->consultCategories();

        $objUser = new UserModel();
        $userClients = $objUser->consultUsersWithRolAndStatus('3', '1');
        $company = new CompanyModel();
        $companies = array(); // Create an array to store the companies       
        foreach ($userClients as $usc) {
            $companyInfo = $company->ConsultCompany($usc['c_id']);
            // Merge the company information into the $companies array
            $companies = array_merge($companies, $companyInfo);
        }
        $subcategory = new SubcategoryModel();
        $subcategories = $subcategory->consultSubcategories();
    
        // ARTICLES,SUBCATEGORIES,COMPANIES AND CATEGORIES ADD
        $objCustomerDiscounts= new Customer_discountsModel();

        $ADDarticles=$objCustomerDiscounts->consultAttrsListPrice($id);
        $ADDcategories=$objCustomerDiscounts->consultAttrsListPrice($id,'cat_id');
        $ADDcompanies=$objCustomerDiscounts->consultAttrsListPrice($id,'c_id');
        $ADDsubcategories=$objCustomerDiscounts->consultAttrsListPrice($id,'sbcat_id');
        
    
        include_once '../app/Views/groups/groupsModalUpdate.php';
    }

    public function updateListGroups(){
        $gp_id=$_POST['gp_id'];
        $objGroups= new GroupsModel();
        $objGroups->deleteCustomer_discountsByGp_id($gp_id);
        $objGroups->deleteListpriceGp_id($gp_id);
        $name = isset($_POST['nameGroup']) ? $_POST['nameGroup'] : null;
        $discount_percentage = isset($_POST['discount_percentage']) ? $_POST['discount_percentage'] : null;
        $coupon = isset($_POST['coupon']) ? $_POST['coupon'] : null;
        $price = isset($_POST['price']) ? $_POST['price'] : null;
        $companies = isset($_POST['companies']) ? $_POST['companies'] : null;
        $categories = isset($_POST['categories']) ? $_POST['categories'] : null;
        $subcategories = isset($_POST['subcategories']) ? $_POST['subcategories'] : null;
        $articles = isset($_POST['articles']) ? $_POST['articles'] : null;
        $date_end = isset($_POST['date_end']) ? $_POST['date_end'] : null;        
        $objGroups->insertGroup($name,$discount_percentage,$coupon,$date_end);
        $gp_id=$objGroups->getLastId('group_discounts','gp_id');
        $discounts= new Customer_discountsModel();
        $discounts->insertCustomer_discounts($companies,$categories,$subcategories,$articles,$gp_id,$price);
        redirect(generateUrl("Groups","Groups","viewCreateGroups")); 
    }

}   
?>