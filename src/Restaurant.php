<?php
class Restaurant
{
    private $name;
    private $website;
    private $phone_number;
    private $id;
    private $cuisine_id;

    function __construct($name, $website, $phone_number, $id = null, $cuisine_id)
    {
        $this->name = $name;
        $this->website = $website;
        $this->phone_number = $phone_number;
        $this->id = $id;
        $this->cuisine_id = $cuisine_id;
    }

    function setName($new_name)
    {
        $this->name = (string) $new_name;
    }

    function getName()
    {
        return $this->name;
    }

    function setWebsite($new_website)
    {
        $this->website = (string) $new_website;
    }

    function getWebsite()
    {
        return $this->website;
    }

    function set_Phone_number($new_phone_number)
    {
        $this->phone_number = (string) $new_phone_number;
    }

    function getPhone_number()
    {
        return $this->phone_number;
    }

    function getId()
    {
        return $this->id;
    }

    function getCuisine_Id()
    {
        return $this->cuisine_id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO restaurants (name, website, phone_number, cuisine_id) VALUES ('{$this->getName()}', '{$this->getWebsite()}', '{$this->getPhone_number()}', {$this->getCuisine_Id()});");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update()
    {
        $GLOBALS['DB']->exec("UPDATE restaurants SET name = '{$new_name}' WHERE id = {$this->getId()};");
    }

    function delete()
    {
      $GLOBALS['DB']->exec("DELETE FROM cuisines WHERE id = {$this->getId()};");
      $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE cuisine_id = {$this->getId()};");
    }

    static function getAll()
    {
        $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants ;");
        $restaurants = array();
        foreach($returned_restaurants as $restaurant) {
            $name = $restaurant['name'];
            $website = $restaurant['website'];
            $phone_number = $restaurant['phone_number'];
            $id = $restaurant['id'];
            $cuisine_id = $restaurant['type_id'];
            $new_restaurant = new Restaurant($name, $website, $phone_number, $id, $cuisine_id);
            array_push($restaurants, $new_restaurant);
        }
        return $restaurants;
      }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants;");
        }
    }
