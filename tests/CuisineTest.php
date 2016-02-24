<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost;dbname=places_to_eat';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class CuisineTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Cuisine::deleteAll();
            Restaurant::deleteAll();
        }

        function test_getRestaurant()
        {
          //Arrange
            $cuisine_type = "Peruvian";
            $id = null;
            $test_cuisine = new Cuisine($cuisine_type, $id);
            $test_cuisine->save();

            $test_cuisine_id = $test_cuisine->getId();


            $name = "Andina";
            $website = "http://www.andinarestaurant.com/";
            $phone_number = "(503)228-9535";
            $test_restaurant = new Restaurant($name, $website, $phone_number,  $id, $test_cuisine_id);
            $test_restaurant->save();


            $name2 = "Las Primas";
            $website2 = "http://www.lasprimaskitchen.com";
            $phone_number2 = "(503)206-5790";
            $test_restaurant2 = new Restaurant($name2, $website2, $phone_number2,  $id, $test_cuisine_id);
            $test_restaurant2->save();


            //Act
            $result = $test_cuisine->getRestaurants();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);

        }

        function test_getCuisine_type()
        {
            //Arrange
            $cuisine_type = "Peruvian";
            $test_cuisine_type = new Cuisine($cuisine_type);

            //Act
            $result = $test_cuisine_type->getCuisine_type();

            //Assert
            $this->assertEquals($cuisine_type, $result);
        }

        function test_getId()
        {
            //Arrange
            $cuisine_type = "Peruvian";
            $id = 1;
            $test_Cuisine = new Cuisine($cuisine_type, $id);

            //Act
            $result = $test_Cuisine->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $cuisine_type = "Peruvian";
            $test_Cuisine = new Cuisine($cuisine_type);
            $test_Cuisine->save();


            //Act
            $result = Cuisine::getAll();


            //Assert
            $this->assertEquals($test_Cuisine, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $cuisine_type = "Peruvian";
            $cuisine_type2 = "French";
            $test_Cuisine = new Cuisine($cuisine_type);
            $test_Cuisine->save();
            $test_Cuisine2 = new Cuisine($cuisine_type2);
            $test_Cuisine2->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([$test_Cuisine, $test_Cuisine2], $result);
          }

        function test_deleteAll()
        {
            //Arrange
            $cuisine_type = "Peruvian";
            $cuisine_type2 = "French";
            $test_Cuisine = new Cuisine($cuisine_type);
            $test_Cuisine->save();
            $test_Cuisine2 = new Cuisine($cuisine_type2);
            $test_Cuisine2->save();

            //Act
            Cuisine::deleteAll();
            $result = Cuisine::getAll();


            //Assert
            $this->assertEquals([], $result);
        }

    }

?>
