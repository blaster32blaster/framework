<?php

include_once 'connection.php';
include_once 'Models/User.php';
include_once 'Models/Course.php';

/**
 * procees post data
 */
class processData
{
    /**
     * a db connection
     *
     * @var connection $connection
     */
    private $connection;

    public function __construct()
    {
        $this->connection = new connection;
    }

    /**
     * entry point for data processing
     *
     * @param Request $request
     * @return void
     */
    public function handle(Request $request)
    {
        $requestBody = $request->getBody();
        $cleaned = $this->clean($requestBody['choices']);

        if (!$this->validate($requestBody['choices'])) {
            return 'error, calculus was not included';
        }

        try {
            $user = new User($this->connection);
            $userResponse = $user->saveModel();

            // handle the courses
            foreach ($cleaned as $cleanCourse) {
                $course = new Course($this->connection);
                $course->user_id = $userResponse;
                $course->value = $cleanCourse;
                $course->saveModel();
            }
            http_response_code(200);
            return 'success saving to database';
        } catch (Exception $e) {
            http_response_code(400);
            return 'error saving to database';
        }
    }

    /**
     * validate the request
     *
     * @param array $request
     * @return boolean
     */
    private function validate(array $request) : bool
    {
        $hasCalculus = false;
        foreach ($request as $item) {
            if (strtoupper($item) === 'CALCULUS') {
                $hasCalculus = true;
            }
        }
        return $hasCalculus;
    }

    /**
     * clean input params
     *
     * @param array $request
     * @return array
     */
    private function clean(array $request) : array
    {
        $clean = [];
        foreach ($request as $item) {
            $clean[] = filter_var($item, FILTER_SANITIZE_STRING);
        }
        return $clean;
    }
}