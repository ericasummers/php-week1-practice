<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Job.php";

    session_start();
    if (empty($_SESSION['list_of_jobs'])) {
        $_SESSION['list_of_jobs'] = array();
    }

    $app = new Silex\Application();

    $app->get('/', function() {
        $new_job1 = new Job("Jan 2014 - May 2016", "Janitor", "Melrose Corp");
        $new_job2 = new Job("Jan 2017 - May 2018", "Dish Washer", " Ritz");
        $jobs = array($new_job1, $new_job2);
        array_push($_SESSION['list_of_jobs'], $jobs);

        $output = '
        <!DOCTYPE html>
        <html>
            <head>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css">
                <title>Job History</title>
            </head>
            <body>
                <div class="container">';

        if ($jobs) {
            $output .= "<h2>Jobs Entered So Far</h2>";
        }

        foreach ($jobs as $job) {
            $output .= "<h3>" . $job->getWhenEmployed();
            $output .= " / " . $job->getJobTitle();
            $output .= " / " . $job->getEmployer() . "</h3>";
        }

        if ($jobs) {
            $output .= "<br>";
        }

        $output .=
                '<h2>Please enter a job to add to your employment history:</h2>
                    <form action="added_job.php" method="post">
                        <div class="form-group">
                            <label for="when_employed">When were you employed?</label>
                            <input id="when_employed" class="form-control" name="when_employed" type="text">
                        </div>
                        <div class="form-group">
                            <label for="job_title">Title</label>
                            <input id="job_title" class="form-control" name="job_title" type="text">
                        </div>
                        <div class="form-group">
                            <label for="employer">Who was your employer?</label>
                            <input id="employer" class="form-control" name="employer" type="text">
                        </div>
                        <button class="btn" type="submit">Add a Job!</button>
                    </form>
                </div>
            </body>
        </html>

        ';

        return $output;

    });

    return $app;

?>
