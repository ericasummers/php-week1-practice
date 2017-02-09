<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Job.php";

    session_start();
    define('JOB_SESSION_KEY', 'list_of_jobs');
    if (empty($_SESSION[JOB_SESSION_KEY])) {
        $_SESSION[JOB_SESSION_KEY] = array();
    }

    $app = new Silex\Application();

    $app['debug'] = true;

    $app->register(
        new Silex\Provider\TwigServiceProvider(),
        array('twig.path' => __DIR__.'/../views')
    );

    $app->get('/', function() use ($app) {
        $jobs = Job::getAll();

        return $app['twig']->render('view_all.html.twig', array('jobs' => $jobs));
    });

    $app->post('/', function() use ($app) {
        if (array_key_exists("delete_all_jobs_button_clicked", $_POST)) {
            Job::deleteAll();
        } elseif (array_key_exists("add_new_job_button_clicked", $_POST)) {
            $job = new Job(
                $_POST['when_employed'],
                $_POST['job_title'],
                $_POST['employer']
            );
            $job->save();
        }

        $jobs = Job::getAll();

        return $app['twig']->render('view_all.html.twig', array('jobs' => $jobs));
    });

    return $app;

?>
