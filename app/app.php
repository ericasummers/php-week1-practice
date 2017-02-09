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

    $app->register(
        new Silex\Provider\TwigServiceProvider(),
        array('twig.path' => __DIR__.'/../views')
    );

    $app->get('/', function() use ($app) {
        $jobs = Job::getAll();

        return $app['twig']->render('view_all.html.twig', array('jobs' => $jobs));
    });


    $app->post('/added_job', function() use ($app) {
        $job = new Job(
            $_POST['when_employed'],
            $_POST['job_title'],
            $_POST['employer']
        );
        $job->save();

        return $app['twig']->render('add_job.html.twig', array('job' => $job));
    });

    $app->post('/delete_all', function() use ($app) {
        Job::deleteAll();

        return $app['twig']->render('delete_all.html.twig');
    });



    return $app;

?>
