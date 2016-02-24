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

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();


    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->get("/restaurants", function() use ($app) {
        return $app['twig']->render('restaurants.html.twig', array('restaurants' => Restaurant::getAll()));
    });

    $app->post("/restaurants", function() use ($app) {
        $restaurant = new Restaurant($_POST['name'], $_POST['website'], $_POST['phone_number']);
        $restaurant->save();
        return $app['twig']->render('restaurants.html.twig', array('restaurants' => Restaurant::getAll()));
    });

    $app->get("/cuisines", function() use ($app) {
        return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll()));
    });

    $app->post("/cuisines", function() use ($app) {
        $cuisine = new Cuisine($_POST['cuisine_type']);
        $cuisine->save();
        return $app['twig']->render('cuisines.html.twig', array('cuisines' => Cuisine::getAll(), 'cuisine' => $cuisine));
    });

        $app ['debug'] = true;

    $app->get("/cuisines/{id}/edit", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine));
    });

    $app->patch("/cuisines/{id}", function($id) use ($app) {
        $name = $_POST['cuisine_type'];
        $cuisine = Cuisine::findCuisine($id);
        $cuisine->update($cuisine_type);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'tasks' => $cuisine->getRestaurants()));
    });

    $app->post("/delete_cuisines", function() use ($app) {
        Cuisine::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->post("/delete_restaurants", function() use ($app) {
        Restaurant::deleteAll();
        return $app['twig']->render('index.html.twig');
    });


    return $app;
?>
