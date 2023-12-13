<?php

namespace App\Models;

use CodeIgniter\Model;
use PhpParser\Node\Expr\FuncCall;

class Admin_model extends Model
{

    public function __construct()
    {

        $this->db = \Config\Database::connect();
    }




    public function select_user($search = '', $status = '', $limit = "", $start = "")
    {


        $where = '';
        if ($limit != '' && empty($start)) {
            $limit = 'LIMIT ' . $limit . '';
        } else if ($limit != '' && $start != '') {
            $limit = 'LIMIT ' . $start . ',' . $limit . '';
        }

        if($status != ''){
           $where = 'user.is_active = '.$status.'';
        }else{
          $where =  "(user.first_name LIKE '%$search%' OR user.last_name LIKE '%$search%' OR  email LIKE '%$search%' )";
        }

        $query = "SELECT user.*, COUNT(orders.order_id) as no_of_orders
        FROM user
        LEFT JOIN orders ON orders.user_id = user.user_id
        WHERE ".$where."
        GROUP BY user.user_id
        ORDER BY user.user_id DESC ".$limit;
        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }


    public function select_product_sale($months){


        if($months == 1){
            $filterMonths = "AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
        }else if($months == 3){
            $filterMonths = " AND created_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)";
        }
        else if($months == 6){
            $filterMonths = "AND  created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)";
        }
        else if($months == 12){
            $filterMonths = " AND created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)";
        }else{
            $filterMonths = '';
        }
        
        $query = "SELECT SUM(final_price) as total_sale
        FROM orders 
        WHERE  (order_status IN (1, 2, 3))    
        ".$filterMonths."
       
        ";
        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }

    }
    public function select_product_sale_every(){

        $results = array();

        for ($month = 1; $month <= 12; $month++) {
        $filterMonths = "AND MONTH(created_at) = $month AND YEAR(created_at) = YEAR(CURDATE())";
        
           $query = "SELECT COALESCE(SUM(final_price), 0) as total_sale
            FROM orders 
            WHERE (order_status IN (1, 2, 3))
            " . $filterMonths;
        
          $query = $this->db->query($query);
          $query = $query->getResult();

           $results[$month] = $query[0]->total_sale;
       }

       return $results;

    }
    public function select_product_sale_every_day(){

        $results = array();

        // Get the current year, month, and day
        $currentYear = date('Y');
        $currentMonth = date('n'); // Month without leading zeros
        $currentDay = date('d');
        
        // Loop through the last three days, including the current day
        for ($i = 0; $i < $currentDay; $i++) {
            $day = $currentDay - $i;
        
            $filterDays = "AND DAY(created_at) = $day";
        
            $query = "SELECT COALESCE(SUM(final_price), 0) as total_sale
                      FROM orders 
                      WHERE (order_status IN (1, 2, 3))
                      AND MONTH(created_at) = $currentMonth
                      AND YEAR(created_at) = $currentYear
                      $filterDays";
        
            $query = $this->db->query($query);
            $query = $query->getResult();
        
            $results[$day] = $query[0]->total_sale;
        }
        
        return $results;
    }
    public function select_product_sale_every_three($months){

        $results = array();

        // Get the current year and month
        $currentYear = date('Y');
        $currentMonth = date('n'); // 'n' returns the month without leading zeros
        
        // Loop through the last three months, including the current month
        for ($i = 0; $i < $months; $i++) {
            $month = ($currentMonth - $i + 12) % 12; // Calculate the previous months
            $year = $currentYear - ($i > 0 && $month == 11 ? 1 : 0); // Adjust the year if needed
        
            $filterMonths = "AND MONTH(created_at) = $month AND YEAR(created_at) = $year";
        
            $query = "SELECT COALESCE(SUM(final_price), 0) as total_sale
                      FROM orders 
                      WHERE (order_status IN (1, 2, 3))
                      " . $filterMonths;
        
            $query = $this->db->query($query);
            $query = $query->getResult();
        
            $results[$month] = $query[0]->total_sale;
        }
        
        return $results;
    }
    public function select_product_sale_year(){
        $results = array();

        // Query to get distinct years from your database
        $distinctYearsQuery = "SELECT DISTINCT YEAR(created_at) as year FROM orders";
        $distinctYears = $this->db->query($distinctYearsQuery)->getResult();
        
        // Loop through the distinct years
        foreach ($distinctYears as $yearData) {
            $year = $yearData->year;
        
            // Query to calculate the sum of final_price for each year
            $sumQuery = "SELECT COALESCE(SUM(final_price), 0) as total_sale
                         FROM orders
                         WHERE YEAR(created_at) = $year
                         AND (order_status IN (1, 2, 3))";
        
            $sumQueryResult = $this->db->query($sumQuery)->getResult();
        
            // Store the sum of final_price for the year in the results array
            $results[$year] = $sumQueryResult[0]->total_sale;
        }
        
        return $results;
    }

    public function select_product_quantity(){

        $query = "SELECT COUNT(order_id) as total_orders
        FROM orders
        WHERE
            order_status IN (1, 2, 3)
            AND DATE(created_at) = CURDATE()
       
        ";
        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }

    }

    public function select_cousomers_months($months){


        if($months == 1){
            $filterMonths = "   WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
        }else if($months == 3){
            $filterMonths = "   WHERE  created_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)";
        }
        else if($months == 6){
            $filterMonths = "   WHERE  created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)";
        }
        else if($months == 12){
            $filterMonths = "   WHEREcreated_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)";
        }else{
            $filterMonths = '';
        }
        
        $query = "SELECT COUNT(user_id) as total_users
        FROM user 
       ".$filterMonths."
       
        ";
        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }

    }

    public function select_orders_notfication(){
        
 
        $query = "SELECT  orders.order_number, orders.price as sub_total ,product.product_name, user.first_name, user.last_name, orders.created_at
        FROM orders 
        INNER JOIN product  ON product.product_id = orders.product_id
        INNER JOIN user  ON user.user_id = orders.user_id
        WHERE  YEAR(orders.created_at) = YEAR(CURDATE())
        AND WEEK(orders.created_at) = WEEK(CURDATE())
         ORDER BY orders.order_id DESC";

        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public  function select_header_product($headerIds){
  

        $query = "SELECT header_product.*,  product.product_name, product.product_id
        FROM header_product 
        LEFT JOIN product ON product.product_id = header_product.product_id
        WHERE  header_id IN ($headerIds);
       
        ";
        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
        

    }
    public function select_product_search($search, $limit = "", $start = "")
    {



        if ($limit != '' && empty($start)) {
            $limit = 'LIMIT ' . $limit . '';
        } else if ($limit != '' && $start != '') {
            $limit = 'LIMIT ' . $start . ',' . $limit . '';
        }

        $query = "SELECT product.*,  product_category.category_id, product_category.category_name 
        FROM product 
        LEFT JOIN product_category ON product.category_id = product_category.category_id
        WHERE product.product_id <> 1 AND ( product_name LIKE '%$search%' OR product_id LIKE '%$search%' ) $limit;
       
        ";
        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }



    public function select_product_attribute_category($productId)
    {


        $query = "SELECT ac.*, pac.id AS product_attribute_id
        FROM attributes_categorie AS ac
        LEFT JOIN (
            SELECT DISTINCT attribute_categorie_id, id
            FROM product_attributes_categorie
            WHERE product_id = ?
        ) AS pac
        ON ac.attribute_categorie_id = pac.attribute_categorie_id";
        $query = $this->db->query($query, [$productId]);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }
    public function Select_data_attributes($searchTerm = "", $limit = '', $start = '')
    {
        if ($limit != '' && empty($start)) {
            $limit = 'LIMIT ' . $limit . '';
        } else if ($limit != '' && $start != '') {
            $limit = 'LIMIT ' . $start . ',' . $limit . '';
        }

        $query = "SELECT attributes.*  
        FROM attributes 
        WHERE attribute_categorie <>'haircolorMen' AND  attributes.attribute_categorie <> 'hairColorWomen' 
        AND (attribute_name  LIKE '%$searchTerm%' OR attribute_categorie  LIKE '%$searchTerm%') $limit";
        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }


    public function select__attribute_only_selected($productId, $attributeCategory)
    {

        $query = "SELECT attributes.*, product_attributes.id AS product_attribute_id
        FROM attributes 
        LEFT JOIN (
            SELECT DISTINCT id, attribute_id
            FROM product_attributes
            WHERE product_id = ?
        ) AS product_attributes
        ON attributes.attribute_id = product_attributes.attribute_id
        WHERE attributes.attribute_categorie IN ($attributeCategory)";

        $query = $this->db->query($query, [$productId]);

        $query = $query->getResult();




        if ($query) {
            return $query;
        } else {
            return false;
        }
    }


    public function select_attribute_color($productId){

        $query = "SELECT attributes.*, product_attributes.id AS product_attribute_id
        FROM attributes
        LEFT JOIN (
            SELECT DISTINCT id, attribute_id
            FROM product_attributes
            WHERE product_id = ?
        ) AS product_attributes
        ON attributes.attribute_id = product_attributes.attribute_id 
        WHERE attribute_categorie = 'hairColorMen' OR attribute_categorie = 'hairColorWomen' ORDER BY attributes.color_categorie  ASC; 
        ";

        $query = $this->db->query($query, [$productId]);

        $query = $query->getResult();




        if ($query) {
            return $query;
        } else {
            return false;
        }

    }
    public function select_attribute_perm($productId){

        $query = "SELECT attributes.*, product_attributes.id AS product_attribute_id
        FROM attributes
        LEFT JOIN (
            SELECT DISTINCT id, attribute_id
            FROM product_attributes
            WHERE product_id = ?
        ) AS product_attributes
        ON attributes.attribute_id = product_attributes.attribute_id 
        WHERE attribute_categorie = 'permYes' 
        ";

        $query = $this->db->query($query, [$productId]);

        $query = $query->getResult();




        if ($query) {
            return $query;
        } else {
            return false;
        }

    }
    public function select_attribute_grey($productId){

        $query = "SELECT attributes.*, product_attributes.id AS product_attribute_id
        FROM attributes
        LEFT JOIN (
            SELECT DISTINCT id, attribute_id
            FROM product_attributes
            WHERE product_id = ?
        ) AS product_attributes
        ON attributes.attribute_id = product_attributes.attribute_id 
        WHERE attribute_categorie = 'greyHairType' 
        ";

        $query = $this->db->query($query, [$productId]);

        $query = $query->getResult();




        if ($query) {
            return $query;
        } else {
            return false;
        }

    }
    public function select_attribute_hairStyle($productId){

        $query = "SELECT attributes.*, product_attributes.id AS product_attribute_id
        FROM attributes
        LEFT JOIN (
            SELECT DISTINCT id, attribute_id
            FROM product_attributes
            WHERE product_id = $productId
        ) AS product_attributes
        ON attributes.attribute_id = product_attributes.attribute_id 
        WHERE attribute_categorie = 'hairStyleMen' OR attribute_categorie = 'hairStyleWomen'; 
        ";

        $query = $this->db->query($query);

        $query = $query->getResult();




        if ($query) {
            return $query;
        } else {
            return false;
        }

    }
    public function select_attribute_curl($productId){

        $query = "SELECT attributes.*, product_attributes.id AS product_attribute_id
        FROM attributes
        LEFT JOIN (
            SELECT DISTINCT id, attribute_id
            FROM product_attributes
            WHERE product_id = ?
        ) AS product_attributes
        ON attributes.attribute_id = product_attributes.attribute_id 
        WHERE attribute_categorie = 'curlMen' OR attribute_categorie = 'curlWomen'; 
        ";

        $query = $this->db->query($query, [$productId]);

        $query = $query->getResult();




        if ($query) {
            return $query;
        } else {
            return false;
        }

    }

    public  function select_category($searchTerm = "", $limit = "", $start = "")
    {



        if ($limit != '' && empty($start)) {
            $limit = 'LIMIT ' . $limit . '';
        } else if ($limit != '' && $start != '') {
            $limit = 'LIMIT ' . $start . ',' . $limit . '';
        }

        $query = "WITH RECURSIVE CategoryHierarchy AS (
            SELECT category_id, parent_category_id, category_name
            FROM product_category
        
            UNION ALL
        
            -- Recursive case: Join with parent category
            SELECT c.category_id, c.parent_category_id, c.category_name
            FROM product_category c
            INNER JOIN CategoryHierarchy ch ON ch.parent_category_id = c.category_id
            WHERE ch.category_id IS NULL  -- Handle top-level categories
        )
        , CategoryProductCounts AS (
            SELECT ch.category_id, COUNT(p.product_id) AS product_count
            FROM CategoryHierarchy ch
            LEFT JOIN product p ON ch.category_id = p.category_id
            GROUP BY ch.category_id
        )
        SELECT ch.category_id, ch.parent_category_id, ch.category_name AS child_category_name, pc.category_name AS parent_category_name, cpc.product_count
        FROM CategoryHierarchy ch
        LEFT JOIN product_category pc ON ch.parent_category_id = pc.category_id
        LEFT JOIN CategoryProductCounts cpc ON ch.category_id = cpc.category_id
        WHERE  ch.category_id LIKE '%$searchTerm%' OR ch.category_name LIKE '%$searchTerm%'
        ORDER BY ch.category_id DESC
       " . $limit . "";

        $query = $this->db->query($query,);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }
    public  function select_category_single($categoryId)
    {
        $query = "WITH RECURSIVE CategoryHierarchy AS (
            SELECT category_id, parent_category_id, category_name, inc_filter
            FROM product_category
        
            UNION ALL
        
            -- Recursive case: Join with parent category
            SELECT c.category_id, c.parent_category_id, c.category_name, c.inc_filter
            FROM product_category c
            INNER JOIN CategoryHierarchy ch ON ch.parent_category_id = c.category_id
            WHERE ch.category_id IS NULL   -- Handle top-level categories
        )
        
        SELECT ch.category_id, ch.parent_category_id, ch.category_name AS child_category_name, ch.inc_filter, pc.category_name AS parent_category_name 
           FROM CategoryHierarchy ch
        LEFT JOIN product_category pc ON ch.parent_category_id = pc.category_id
        WHERE  ch.category_id  = ?
        ORDER BY ch.category_id DESC
        LIMIT 1";

        $query = $this->db->query($query, [$categoryId]);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function select_review($searchTerm= "", $limit = "", $start = "")
    {



        if ($limit != '' && empty($start)) {
            $limit = 'LIMIT ' . $limit . '';
        } else if ($limit != '' && $start != '') {
            $limit = 'LIMIT ' . $start . ',' . $limit . '';
        }



        $query = "SELECT
                   review.review_id,review.rating, review.review,  DATE_FORMAT(review.created_at, '%M %d, %Y') as created_at, user.first_name, user.last_name,
                   product.product_name, product.slug,
                   (
                   SELECT GROUP_CONCAT(image SEPARATOR ', ') FROM review_image  WHERE review_image.review_id = review.review_id ) AS images
                   FROM 
                   review INNER JOIN user ON user.user_id = review.user_id
                   INNER JOIN product ON product.product_id = review.product_id 
                   WHERE user.first_name
                   LIKE '%$searchTerm%' OR 
                   user.last_name LIKE '%$searchTerm%'
                   OR product.product_name LIKE '%$searchTerm%'  
                   ORDER BY review.review_id DESC " . $limit;

        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function select_orders($searchTerm, $limit = "", $start = "")
    {


        if ($limit != '' && empty($start)) {
            $limit = 'LIMIT ' . $limit . '';
        } else if ($limit != '' && $start != '') {
            $limit = 'LIMIT ' . $start . ',' . $limit . '';
        }


        $query = "SELECT orders.*, DATE_FORMAT(orders.created_at, '%d %M, %Y') as order_date, orders.price as sub_total, address.*,product.*, user.*
        FROM orders 
        INNER JOIN address ON address.address_id = orders.address_id
        INNER JOIN product  ON product.product_id = orders.product_id
        INNER JOIN user  ON user.user_id = orders.user_id
        WHERE  orders.order_id LIKE '%$searchTerm%' OR orders.order_number LIKE '%$searchTerm%' OR product.product_name LIKE '%$searchTerm%' 
        OR product.product_name LIKE '%$searchTerm%' OR user.first_name LIKE '%$searchTerm%' OR user.last_name LIKE '%$searchTerm%' 
       OR CONCAT(user.first_name, ' ', user.last_name) LIKE '%$searchTerm%'
       
        
         ORDER BY orders.order_id DESC " . $limit . "
       
        ";

        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }
    public function select_orders_where($orderStatus, $limit = "", $start = "")
    {


        if ($limit != '' && empty($start)) {
            $limit = 'LIMIT ' . $limit . '';
        } else if ($limit != '' && $start != '') {
            $limit = 'LIMIT ' . $start . ',' . $limit . '';
        }


        $query = "SELECT orders.*, DATE_FORMAT(orders.created_at, '%d %M, %Y') as order_date, orders.price as sub_total, address.*,product.*, user.*
        FROM orders 
        INNER JOIN address ON address.address_id = orders.address_id
        INNER JOIN product  ON product.product_id = orders.product_id
        INNER JOIN user  ON user.user_id = orders.user_id
        WHERE  orders.order_status =  ?
         ORDER BY orders.order_id DESC " . $limit . "
       
        ";

        $query = $this->db->query($query, [$orderStatus]);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }
    public function select_orders_id($orderId)
    {

        $query = "SELECT orders.*, DATE_FORMAT(orders.created_at, '%d %M, %Y') as order_date, orders.price as sub_total, address.*,product.*, user.*
        FROM orders 
        INNER JOIN address ON address.address_id = orders.address_id
        INNER JOIN product  ON product.product_id = orders.product_id
        INNER JOIN user  ON user.user_id = orders.user_id
        WHERE  orders.order_id =  ? LIMIT 1 ";

        $query = $this->db->query($query, [$orderId]);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }


    public function select_color_search($search, $limit = "", $start = "")
    {



        if ($limit != '' && empty($start)) {
            $limit = 'LIMIT ' . $limit . '';
        } else if ($limit != '' && $start != '') {
            $limit = 'LIMIT ' . $start . ',' . $limit . '';
        }

        $query = "SELECT *  
        FROM attributes 
        WHERE (attribute_categorie = 'hairColorMen' OR attribute_categorie = 'hairColorWomen') AND (attributes.attribute_name LIKE '%$search%' OR color_categorie LIKE '%$search%' ) $limit;
       
        ";
        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }
    public function select_HairStyle_search($search, $limit = "", $start = "")
    {



        if ($limit != '' && empty($start)) {
            $limit = 'LIMIT ' . $limit . '';
        } else if ($limit != '' && $start != '') {
            $limit = 'LIMIT ' . $start . ',' . $limit . '';
        }

        $query = "SELECT *  
        FROM attributes 
        WHERE (attribute_categorie = 'hairStyleMen' OR attribute_categorie = 'hairStyleWomen') AND (attributes.attribute_name LIKE '%$search%' OR attribute_categorie LIKE '%$search%' ) $limit;
       
        ";
        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }
    public function select_blog_search($search, $limit = "", $start = "")
    {



        if ($limit != '' && empty($start)) {
            $limit = 'LIMIT ' . $limit . '';
        } else if ($limit != '' && $start != '') {
            $limit = 'LIMIT ' . $start . ',' . $limit . '';
        }

        $query = "SELECT *, blog.slug as blog_slug  
        FROM blog 
        LEFT JOIN blog_category ON blog_category.blog_category_id = blog.category
        WHERE (blog.heading LIKE '%$search%' OR blog_category.category_name LIKE '%$search%' ) $limit;
       
        ";
        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function select_inbox($search, $limit = "", $start = "")
    {



        if ($limit != '' && empty($start)) {
            $limit = 'LIMIT ' . $limit . '';
        } else if ($limit != '' && $start != '') {
            $limit = 'LIMIT ' . $start . ',' . $limit . '';
        }

        $query = "SELECT *  
        FROM wholesaler_details 
        WHERE (
        wholesaler_details.representative_name LIKE '%$search%'
        OR wholesaler_details.company_name LIKE '%$search%' OR 
        wholesaler_details.email LIKE '%$search%' ) $limit";
        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }
  
    public function delete_data_batch($table, $where, $data)
    {

        $query = "DELETE FROM $table
        WHERE $where IN ($data)";

        $query = $this->db->query($query);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    public function select_recommnded_product($productId, $categoryName)
    {
   
        $query = "WITH RECURSIVE CategoryHierarchy AS (
            SELECT category_id, parent_category_id, category_name
            FROM product_category
            WHERE category_name =  ?
            UNION ALL
            -- Recursive case: Join with child categories
            SELECT c.category_id, c.parent_category_id, c.category_name
            FROM product_category c
            INNER JOIN CategoryHierarchy ch ON ch.category_id = c.parent_category_id
        )
        SELECT  p.* , recommended_product.recommended_product_id
        FROM product p
        JOIN CategoryHierarchy ch ON p.category_id = ch.category_id
        LEFT JOIN recommended_product  ON recommended_product.recommended_product_id = p.product_id AND recommended_product.product_id = ? 
          WHERE p.is_visible = 1  GROUP BY p.product_id";

        $query = $this->db->query($query, [$categoryName, $productId]);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }


}
