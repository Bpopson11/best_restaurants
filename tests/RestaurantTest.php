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

    //     function test_getId()
    //     {
    //         //Arrange
    //         $cuisine_type = "Peruvian";
    //         $id = 1;
    //         $test_Restaurant = new Restaurant($cuisine_type, $id);
    //
    //         //Act
    //         $result = $test_Restaurant->getId();
    //
    //         //Assert
    //         $this->assertEquals(true, is_numeric($result));
    //     }
    //
    //     function test_save()
    //     {
    //         //Arrange
    //         $cuisine_type = "Peruvian";
    //         $test_Restaurant = new Restaurant($cuisine_type);
    //         $test_Restaurant->save();
    //
    //
    //         //Act
    //         $result = Restaurant::getAll();
    //
    //
    //         //Assert
    //         $this->assertEquals($test_Restaurant, $result[0]);
    //     }
    //
    //     function test_getAll()
    //     {
    //         //Arrange
    //         $cuisine_type = "Peruvian";
    //         $cuisine_type2 = "French";
    //         $test_Restaurant = new Restaurant($cuisine_type);
    //         $test_Restaurant->save();
    //         $test_Restaurant2 = new Restaurant($cuisine_type2);
    //         $test_Restaurant2->save();
    //
    //         //Act
    //         $result = Restaurant::getAll();
    //
    //         //Assert
    //         $this->assertEquals([$test_Restaurant, $test_Restaurant2], $result);
    //       }
    //
    //     function test_deleteAll()
    //     {
    //         //Arrange
    //         $cuisine_type = "Peruvian";
    //         $cuisine_type2 = "French";
    //         $test_Restaurant = new Restaurant($cuisine_type);
    //         $test_Restaurant->save();
    //         $test_Restaurant2 = new Restaurant($cuisine_type2);
    //         $test_Restaurant2->save();
    //
    //         //Act
    //         Restaurant::deleteAll();
    //         $result = Restaurant::getAll();
    //
    //
    //         //Assert
    //         $this->assertEquals([], $result);
    //     }
    //
    }

?>
