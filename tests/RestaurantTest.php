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


    class RestaurantTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Cuisine::deleteAll();
            Restaurant::deleteAll();
        }

        function test_getName()
        {
          //Arrange
          $cuisine_type = "Peruvian";
          $id = null;
          $test_cuisine = new Cuisine($cuisine_type, $id);
          $test_cuisine->save();

          $name = "Andina";
          $website = "http://www.andinarestaurant.com/";
          $phone_number = "(503)228-9535";
          $id = null;
          $cuisine_id = $test_cuisine->getId();
          $test_restaurant = new Restaurant($name, $website, $phone_number, $id, $cuisine_id);

          //Act
          $result = $test_restaurant->getName();

          //Assert
          $this->assertEquals("Andina", $result);
        }

        function test_getId()
        {
            //Arrange
            $cuisine_type = "Peruvian";
            $id = null;
            $test_cuisine = new Cuisine($cuisine_type, $id);
            $test_cuisine->save();

            $name = "Andina";
            $website = "http://www.andinarestaurant.com/";
            $phone_number = "(503)228-9535";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $website, $phone_number, $id, $cuisine_id);
            $test_restaurant->save();

            //Act
            $result = $test_restaurant->getId();


            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
          //Arrange
          $cuisine_type = "Peruvian";
          $id = null;
          $test_cuisine = new Cuisine($cuisine_type, $id);
          $test_cuisine->save();

          $name = "Andina";
          $website = "http://www.andinarestaurant.com/";
          $phone_number = "(503)228-9535";
          $cuisine_id = $test_cuisine->getId();
          $test_restaurant = new Restaurant($name, $website, $phone_number, $id, $cuisine_id);

            //Act
            $test_restaurant->save();


            //Assert
            $result = Restaurant::getAll();
            $this->assertEquals($test_restaurant, $result[0]);
        }

        function test_getAll()
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
            $result = Restaurant::getAll();

            //Assert
            $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
          }

        function test_deleteAll()
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
            Restaurant::deleteAll();
            $result = Restaurant::getAll();


            //Assert
            $this->assertEquals([], $result);
        }

        function testUpdate()
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

            $new_name = "Anidna";

            //Act
            $test_restaurant->updateRestaurant($new_name);

            //Assert
            $this->assertEquals("Anidna", $test_restaurant->getName());
        }

        function testDeleteRestaurant()
        {
            //Arrange
            $cuisine_type = "Peruvian";
            $id = null;
            $test_cuisine = new Cuisine($cuisine_type, $id);
            $test_cuisine->save();

            $name = "Andina";
            $website = "http://www.andinarestaurant.com/";
            $phone_number = "(503)228-9535";
            $cuisine_id = $test_cuisine->getId();
            $test_restaurant = new Restaurant($name, $website, $phone_number,  $id, $cuisine_id);
            $test_restaurant->save();

            $name2 = "Las Primas";
            $website2 = "http://www.lasprimaskitchen.com";
            $phone_number2 = "(503)206-5790";
            $test_restaurant2 = new Restaurant($name2, $website2, $phone_number2,  $id, $cuisine_id);
            $test_restaurant2->save();

            //Act
            $test_restaurant->deleteRestaurant();

            //Assert
            $this->assertEquals([$test_restaurant2], Restaurant::getAll());
        }

    }

?>
