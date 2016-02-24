<?php
class Cuisine
{
    private $cuisine_type;
    private $id;

    function __construct($cuisine_type, $id = null)
    {
        $this->cuisine_type = $cuisine_type;
        $this->id = $id;
    }

    function setCuisine_type($new_cuisine_type)
    {
        $this->cuisine_type = (string) $new_cuisine_type;
    }

    function getCuisine_type()
    {
        return $this->name;
    }

    function getId()
    {
        return $this->id;
    }

    function getRestaurants()
    {
      $restaurants = array();
      $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants WHERE cuisine_id = {$this->getId()}");
      foreach($returned_restaurants as $restaurant) {
          $name = $restaurant['name'];
          $website = $restaurant['website'];
          $hours = $restaurant['hours'];          
          $id = $restaurant['id'];
          $cuisine_id = $restaurant['cuisine_id'];
          $new_restaurant = new Restaurant($cuisine_type, $id, $cuisine_id);
          array_push($restaurants, $new_restaurant);
        }
      return $restaurants;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO cuisine (cuisine_type) VALUES ('{$this->getCuisine_type()}')");
        $this->id= $GLOBALS['DB']->lastInsertId();
    }

    function update()
    {
        $GLOBALS['DB']->exec("UPDATE cuisines SET cuisine_type = '{$new_cuisine_type}' WHERE id = {$this->getId()};");
    }

    function delete()
    {
      $GLOBALS['DB']->exec("DELETE FROM cuisines WHERE id = {$this->getId()};");
      $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE cuisine_type_id = {$this->getId()};");
    }


    static function getAll()
    {
        $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
        $cuisines = array();
        foreach($returned_cuisines as $cuisine_type) {
            $name = $cuisine_type['name'];
            $id = $cuisine_type['id'];
            $new_cuisine_type = new Cuisine($name, $id);
            array_push($cuisines, $new_cuisine_type);
        }
        return $cuisines;
    }

    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM types;");
    }

  }
?>
