<?php
    include "save_info.php"
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Money Tracker</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="vendor-front/bootstrap/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="vendor-front/bootstrap/css/bootstrap-theme.min.css">

    </head>
    <body>

        <a href="get_info.php"> view data </a>
        <form action="" method="POST">
          <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" name="amount" class="form-control" id="amount" placeholder="00.00">
          </div>
          <div class="form-group">
            <label for="concept">Concept</label>
            <input type="text" name="concept" class="form-control" id="concept" placeholder="">
          </div>
          <div class="form-group">
            <label for="label">Label</label>
            <input type="text" name="label" class="form-control" id="label" placeholder="">
          </div>
          <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" class="form-control" id="date" placeholder="">
          </div>

          <button type="submit" class="btn btn-default big">Submit</button>
        </form>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="vendor-front/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>