<?php
namespace Models\Articles;
use Models\MasterModel;
Class ArticlesModel extends MasterModel
{

    public function consultArticles()
    {
        $sql = "SELECT ar_id,ar_name,ar_code,ar_desc,color_id,ar_measurement_value,ar_img_url,ar_data_url,ar_characteristics,mt_id,cat_id
                FROM articles";
            $params = [];
            $articles = $this->select($sql, $params);
        return $articles;
    }

    public function consultAllArticles()
    {
        $sql = "SELECT
                    ar.ar_id,
                    ar.ar_name,
                    ar.ar_code,
                    ar.ar_desc,
                    ar.ar_measurement_value,
                    ar.ar_characteristics,
                    cat.cat_name,
                    subcat.sbcat_name,
                    co.color_name,
                    mt.mt_name,
                    st.status_name
                FROM
                    articles ar LEFT JOIN category cat ON ar.cat_id = cat.cat_id
                    LEFT JOIN subcategory subcat ON ar.sbcat_id = subcat.sbcat_id
                    LEFT JOIN colors co ON ar.color_id = co.color_id
                    LEFT JOIN measurement_type mt ON ar.mt_id = mt.mt_id
                    LEFT JOIN status st ON ar.status_id = st.status_id;";
        
        return $this->select($sql, []);
    }

    public function consultArticleById($id)
    {
        $result = $this->selectById('articles', 'ar_id', $id);
        return $result;
    }
    

    public function insertArticle($ar_id, $ar_name, $ar_desc, $code,
        $characteristics, $color_id, $ar_measurement_value, $ar_img_url,
        $ar_data_url, $mt_id, $cat_id, $sbcat_id, $status_id = 1)
    {
        $sql = "INSERT INTO articles (
                    ar_id,
                    ar_name,
                    ar_desc,
                    ar_code,
                    ar_characteristics,
                    color_id,
                    ar_measurement_value,
                    ar_img_url,
                    ar_data_url,
                    mt_id,
                    cat_id,
                    sbcat_id,
                    status_id
                ) VALUES (
                    :ar_id,
                    :ar_name,
                    :ar_desc,
                    :code,
                    :characteristics,
                    :color_id,
                    :ar_measurement_value,
                    :ar_img_url,
                    :ar_data_url,
                    :mt_id,
                    :cat_id,
                    :sbcat_id,
                    :status_id
                )";

        $params = [
            ':ar_id'                => $ar_id,
            ':ar_name'              => $ar_name,
            ':ar_desc'              => $ar_desc,
            ':code'                 => $code,
            ':characteristics'      => $characteristics,
            ':color_id'             => $color_id,
            ':ar_measurement_value' => $ar_measurement_value,
            ':ar_img_url'           => $ar_img_url,
            ':ar_data_url'          => $ar_data_url,
            ':mt_id'                => $mt_id,
            ':cat_id'               => $cat_id,
            ':sbcat_id'             => $sbcat_id ,
            ':status_id'            => $status_id
        ];

        $this->insert($sql, $params);
    }
    
    public function deleteArticle($id)
    {
        $sql = "DELETE FROM articles WHERE ar_id = :id";
        $params = [
            ':id' => $id
        ];
        $this->delete($sql, $params);
    }
    
    public function updateArticle($id, $name, $description, $color, $value, $img_url,$cat_id,$sbcat_id,$mt_id,$charac,$data_url)
    {
        $sql = "UPDATE articles 
                SET ar_name = :name, ar_desc = :description, color_id = :color,
                ar_measurement_value = :value,ar_characteristics=:charac,ar_img_url = :img_url,ar_data_url=:data_url, cat_id=:cat_id,sbcat_id=:sbcat_id,mt_id=:mt_id
                WHERE ar_id = :id";
        $params = [
            ':id' => $id,
            ':name' => $name,
            ':description' => $description,
            ':color' => $color,
            ':value' => $value,
            ':img_url' => $img_url,
            ':cat_id'=>$cat_id,
            ':sbcat_id'=>$sbcat_id,
            ':mt_id'=>$mt_id,
            ':charac'=>$charac,
            ':data_url'=>$data_url
        ];
        $this->update($sql, $params);
    }
    
    public function getArticleUrls($ar_id)
    {
        $sql = "SELECT ar_data_url, ar_img_url FROM articles WHERE ar_id = :ar_id";
        $params = [':ar_id' => $ar_id];
        $result = $this->select($sql, $params);

        if ($result && count($result) > 0) {
            return $result[0];
        }

        return null;
    }

}

