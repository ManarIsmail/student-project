<?php

// Database connection
$conn = mysqli_connect("localhost", "root", "", "school_db");

if (!$conn) {
    die("Database Connection Failed!");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        Student Portal - Check Result
    </title>

</head>

<body class="bg-light">

<?php include 'nav.php'; ?>


<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-sm p-4 mb-4 border-0">

                <h3 class="text-primary mb-3 text-center">
                    Find Your Result
                </h3>


                <form method="POST" action="student.php">

                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Enter Your Name:
                        </label>

                        <input
                            type="text"
                            name="search_name"
                            class="form-control form-control-lg"
                            placeholder="e.g. Ahmed"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary w-100 btn-lg">

                        Search

                    </button>

                </form>

            </div>


<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $search_name = trim($_POST['search_name']);

    $search_sql =
        "SELECT * FROM students
         WHERE name LIKE '%$search_name%'";

    $result = mysqli_query($conn, $search_sql);


    if (mysqli_num_rows($result) > 0) {


        while ($student = mysqli_fetch_assoc($result)) {

            $score = $student['score'];

            $isPass = $score >= 50;

            $statusText = $isPass ? "Pass" : "Fail";

            $badgeClass = $isPass
                ? "alert-success"
                : "alert-danger";

?>

            <div class="card shadow p-4 text-center border-0 mb-4">

                <h4 class="text-secondary">
                    Official Result Card
                </h4>

                <hr>


                <h2 class="text-dark mb-3">

                    <?= htmlspecialchars($student['name']) ?>

                </h2>


                <h3 class="mb-4">

                    Score:

                    <strong>
                        <?= $score ?>
                    </strong>

                    / 100

                </h3>


                <div class="alert <?= $badgeClass ?> fw-bold fs-4 mb-0">

                    Status:
                    <?= $statusText ?>

                </div>

            </div>


<?php

        }

    } else {

        echo
        "<div class='alert alert-warning
        text-center fw-bold fs-5 shadow-sm'>

        No student found matching "
        . htmlspecialchars($search_name) .
        ".

        </div>";

    }
}

?>

        </div>

    </div>

</div>


</body>

</html>