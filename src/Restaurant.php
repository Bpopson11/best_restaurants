<?php
class Restaurant
{
    private $name;
    private $website;
    private $hours;
    private $id;
    private $cuisine_id;

    function __construct($name, $website, $hours, $id = null, $cuisine_id)
    {
        $this->name = $name;
        $this->website = $website;
        $this->hours = $hours;
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

    function setHours($new_hours)
    {
        $this->hours = (string) $new_hours;
    }

    function getHours()
    {
        return $this->hours;
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
            $GLOBALS['DB']->exec("INSERT INTO cuisines (name, website, hours, id, cuisine_id) VALUES ('{$this->getName()}', '{$this->getWebsite()}', '{$this->getHours()}', '{$this->getCuisine_Id()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

    function update()
    {
        $GLOBALS['DB']->exec("UPDATE restaurants SET name = '{$new_name}' WHERE id = {$this->getId()};");
    }

    function delete()
    {
      $GLOBALS['DB']->exec("DELETE FROM cuisines WHERE id = {$this->getId()};");
      $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE cuisine_type_id = {$this->getId()};");
    }

    static function getAll()
    {
        $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants ;");
        $restaurants = array();
        foreach($returned_restaurants as $restaurant) {
            $name = $restaurant['name'];
            $website = $restaurant['website'];
            $hours = $restaurant['hours'];
            $id = $restaurant['id'];
            $cuisine_id = $restaurant['type_id'];
            $new_restaurant = new Restaurant($name, $website, $hours, $id, $cuisine_id);
            array_push($restaurants, $new_restaurant);
        }
        return $restaurants;
      }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM pets;");
        }
    }
