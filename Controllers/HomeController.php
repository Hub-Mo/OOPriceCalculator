<?php

class HomeController {

    public function render(){

        $dataSource = new DataSource();
        $customerNames = $dataSource->retrieveAllCustomerNames();
        $productNames = $dataSource->retrieveAllProducts();
        //$customerGroup = new CustomerGroup();
        //$fixedDiscount = $customerGroup->retrieveGroup();

        if(isset($_POST['submit'])){

            if($_POST['customerId'] !== 'Choose one' && $_POST['productId'] !== 'Choose Product'){

                $customerId = $dataSource->retrieveCustomer($_POST['customerId']);
                $productId = $dataSource->retrieveProduct($_POST['productId']);
                $allRelatedGroups = $dataSource->retrieveAllRelatedGroups($customerId['group_id']);


                $priceCalculator = new priceCalculator($customerId, $allRelatedGroups, $productId);

                $priceCalculator->getAllFixedDiscounts();
                $priceCalculator->getHighestVariableDiscounts();
                $test = $priceCalculator->getHighestFixedDiscountCustomer();
                $test2 = $priceCalculator->getCompareFixedWithVariableCustomerGroupDiscounts();

                var_dump($test2);
            
            }
            
        }

        require 'Views/home.php';

    }

}