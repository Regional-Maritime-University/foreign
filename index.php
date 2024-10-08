<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Roboto+Mono:wght@700&family=Ubuntu:wght@400;700&display=swap" rel="stylesheet">
    <title>Admission Closed</title>
    <style>
        .flex-container>div {
            height: 100px !important;
            width: 100% !important;
        }
    </style>
</head>

<body class="fluid-container">

    <div id="wrapper">

        <?php require_once("./inc/page-nav-text-logo.php"); ?>

        <main class="container flex-container" style="height: 450px !important">
            <div class="flex-column align-items-center">
                <h1 style="text-align: center;">International Applicants Portal.</h1>

                <div class="row">

                    <div class="card col me-2">
                        <div class="card-header">
                            Member
                        </div>
                        <div class="card-body">
                            <p class="card-text">Continue here if you are a national of one these countries: Republics of Cameroon, The Gambia, Ghana, Liberia and Sierra Leone.</p>
                            <a href="member.php" class="btn btn-light">Click here</a>
                        </div>
                    </div>

                    <div class="card col">
                        <div class="card-header">
                            Non Member
                        </div>
                        <div class="card-body">
                            <p class="card-text">Continue here if you are NOT a national of one these countries: Republics of Cameroon, The Gambia, Ghana, Liberia and Sierra Leone.</p>
                            <a href="non-member.php" class="btn btn-light">Click here</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>