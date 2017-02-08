<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Job.php";


    $app = new Silex\Application();

    $app->get('/', function() {
        $new_job = new Job("Jan 2014 - May 2016", "Janitor", "Melrose Corp");
        $job_output = "";
        $job_output .= "<br>" . $new_job->getWhenEmployed();
        $job_output .= "<br>" . $new_job->getJobTitle();
        $job_output .= "<br>" . $new_job->getEmployer();
        return $job_output;
    });

    return $app;

?>
