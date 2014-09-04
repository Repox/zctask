<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo issetOr($title, "Zitcom Usersystem Assignment"); ?></title>

    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      
    <?php if(isset($_SESSION['message'])): ?>
    <div class="container">
      <div class="alert alert-<?php echo $_SESSION['message']['type']; ?>" role="alert"><?php echo $_SESSION['message']['content'] ?></div>
    </div>
    <?php 
    unset($_SESSION['message']);
    endif; ?>


    <div class="container">
    <div class="row">
      <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
          <li class="active"><a href="<?php echo url('/dashboard'); ?>">Dashboard</a></li>
          <li><a href="<?php echo url('/createuser'); ?>">Opret bruger</a></li>
          <li><a href="<?php echo url('/creategroup'); ?>">Opret gruppe</a></li>
        </ul>
      </div>
      <div class="col-md-9">
        <?php echo $content; ?>
      </div>
    </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </body>
</html>