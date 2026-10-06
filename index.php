<?php

// Database connection
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "school_db"
);

if (!$conn) {
    die("Database Connection Failed!");
}


// Delete student
if (isset($_GET['delete_id'])) {

    $delete_id = $_GET['delete_id'];

    mysqli_query(
        $conn,
        "DELETE FROM students
         WHERE id = $delete_id"
    );

    header("Location: index.php");

    exit();
}


// Add student
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST['student_name'];

    $score = $_POST['student_score'];


    if (!empty($name) && is_numeric($score)) {

        mysqli_query(
            $conn,
            "INSERT INTO students (name, score)
             VALUES ('$name', '$score')"
        );

        header("Location: index.php");

        exit();

    }

}

?>


<!DOCTYPE html>

<html lang="en">


<head>

    <meta charset="UTF-8">

    <title>
        Admin Dashboard
    </title>

</head>


<body class="bg-light">


<?php include 'nav.php'; ?>


<div class="container">


    <h2 class="mb-4 text-secondary">
        Admin Dashboard
    </h2>


    <div class="row">


        <!-- Add new student -->

        <div class="col-md-4 mb-4">

            <div class="card shadow-sm p-4 border-0">

                <h4 class="card-title text-success mb-4">
                    Add New Student
                </h4>


                <form method="POST" action="index.php">


                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Student Name
                        </label>

                        <input
                            type="text"
                            name="student_name"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="mb-4">

                        <label class="form-label fw-bold">
                            Score
                        </label>

                        <input
                            type="number"
                            name="student_score"
                            class="form-control"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        class="btn btn-success w-100">

                        Save to Database

                    </button>


                </form>

            </div>

        </div>


        <!-- View Students list -->

        <div class="col-md-8">

            <div class="card shadow-sm p-4 border-0">


                <h4 class="card-title text-primary mb-4">
                    Full Student Records
                </h4>


                <div class="table-responsive">


                    <table
                        class="table table-hover
                        table-striped align-middle text-center">


                        <thead class="table-dark">

                            <tr>

                                <th>ID</th>

                                <th>Name</th>

                                <th>Score</th>

                                <th>Status</th>

                                <th>Action</th>

                            </tr>

                        </thead>


                        <tbody>


<?php

$result = mysqli_query(
    $conn,
    "SELECT * FROM students"
);


while ($row = mysqli_fetch_assoc($result)):

    $isPass = $row['score'] >= 50;

?>


                            <tr>


                                <td>
                                    <?= $row['id'] ?>
                                </td>


                                <td class="fw-bold">

                                    <?= htmlspecialchars($row['name']) ?>

                                </td>


                                <td>

                                    <?= $row['score'] ?>

                                </td>


                                <td>

                                    <span
                                        class="badge
                                        <?= $isPass
                                            ? 'bg-success'
                                            : 'bg-danger'
                                        ?>
                                        px-3 py-2">

                                        <?= $isPass
                                            ? 'Pass'
                                            : 'Fail'
                                        ?>

                                    </span>

                                </td>


                                <td>

                                    <a
                                        href="index.php?delete_id=<?= $row['id'] ?>"
                                        class="btn btn-sm btn-outline-danger"

                                        onclick="
                                        return confirm(
                                        'Are you sure you want to delete this student?'
                                        );
                                        ">

                                        Delete

                                    </a>

                                </td>


                            </tr>


<?php endwhile; ?>


                        </tbody>


                    </table>


                </div>

            </div>

        </div>


    </div>


    <footer
        class="text-center mt-5 py-3
        text-muted border-top">

        <p>

            &copy; 2026 WE Applied Technology School –
            Student Portal System

        </p>

    </footer>


</div>


</body>

</html>