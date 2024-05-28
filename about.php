<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Store</title>
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"> </script>
</head>
<body>

<?php include "css/include/nav.php" ?>    
<?php include "css/include/header.php" ?>      

<main>
    <div>
        <h5>Here are some cool facts about food</h5>
    </div>
    <br/>
    <div>
        <table class="table table-striped mt-5">
            <thead>
                <tr>
                    <th scope="col">Fact num</th>
                    <th scope="col">Fact</th>
                    <th scope="col">Is fun</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Did you know that the world's largest pizza was over 13,000 square feet?</td>
                    <td>yes</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>The world's oldest pizza is over 4,000 years old! It was discovered in Pompeii.</td>
                    <td>Very fun</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>The average person consumes over 100 slices of pizza in their lifetime!</td>
                    <td>not so fun</td>
                </tr>
            </tbody>
        </table>
    </div>
</main>    
</body>
</html>