<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Restaurant.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=places_to_eat';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app ['debug'] = true; //YOUR BEST FRIEND!!!!!!!!!!!

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //not sure if you need the commented out $cuisine info. Index.html.twig won't load if it isn't commented out. Just FYI.
    $app->get("/", function() use ($app) {
        // $cuisine = new Cuisine($_GET['cuisine_type']);
        // $cuisine->save();
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get("/restaurants", function() use ($app) {
        return $app['twig']->render('restaurants.html.twig', array('restaurants' => Restaurant::getAll()));
    });

    //supposed to display all restaurants under a Cuisine type (breaks after submitting new restaurant)
    $app->post("/restaurants", function() use ($app) {
        $name = $_POST['name'];
        $website = $_POST['website'];
        $phone_number = $_POST['phone_number'];
        $cusine_id = $_POST['cuisine_id'];
        $restaurant = new Restaurant($name, $website, $phone_number, $id = null, $cuisine_id);
        $restaurant->save();
        $cuisine = Cuisine::find($cuisine_id);
        return $app['twig']->render('restaurants.html.twig', array('cuisine' => $cuisine, 'restaurant' => Cuisine::getRestaurants()));
    });

    //Everything below this point should work (it did last time we checked)
    $app->get("/cuisines", function() use ($app) {
        return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/cuisines", function() use ($app) {
        $cuisine = new Cuisine($_POST['cuisine_type']);
        $cuisine->save();
        return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll(), 'cuisine' => $cuisine));
    });

    $app->get("/cuisines/{id}", function($id) use ($app) {
        $cuisine = Cuisine::findCuisine($id);
        return $app['twig']->render('cuisines.html.twig', array('cuisine' => $cuisine, 'cuisines' => Cuisine::getAll()));
    });

    $app->get("/cuisines/{id}/edit", function($id) use ($app) {
        $cuisine = Cuisine::findCuisine($id);
        return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine, 'cuisines' => Cuisine::getAll()));
    });

    $app->patch("/cuisines/{id}", function($id) use ($app) {
        $cuisine_type = $_POST['cuisine_type'];
        $cuisine = Cuisine::findCuisine($id);
        $cuisine->updateCuisine($cuisine_type);
        return $app['twig']->render('cuisines.html.twig', array('cuisine' => $cuisine, 'restaurant' => $cuisine->getRestaurants(), 'cuisines' => Cuisine::getAll()));
    });

    $app->post("/delete_cuisines", function() use ($app) {
        Cuisine::deleteAll();
        return $app['twig']->render('index.html.twig', array('cuisines'=>Cuisine::getAll()));
    });

    $app->post("/delete_restaurants", function() use ($app) {
        Restaurant::deleteAll();
        return $app['twig']->render('index.html.twig');
    });


    return $app;
?>
