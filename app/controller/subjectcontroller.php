<?php

require_once "../app/model/subjectmodel.php";

$subjectModel = new SubjectModel($pdo);

$subjects = $subjectModel->getSubjectsByYearAndSemester(
    'first year',
    'first semester'
);

require_once '../views/dashboard.php';