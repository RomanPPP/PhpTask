<?php
require_once "config.php";
 

$name = $date = $author = "";
$name_err = $date_err = $author_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Введите название.";
    }  else{
        $name = $input_name;
    }
    
    $input_date = trim($_POST["date"]);
    if(empty($input_date)){
        $date_err = "Укажите дату написания.";     
    } else{
        $date = $input_date;
    }
    
    $input_author = trim($_POST["author"]);
    if(empty($input_author)){
        $author_err = "Укажите автора книги.";     
    }  else{
        $author = $input_author;
    }
    
    if(empty($name_err) && empty($date_err) && empty($author_err)){
        $sql = "INSERT INTO books (name, author, date) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_author ,$param_date );
            $param_name = $name;
            $param_date = $date;
            $param_author = $author;
            if(mysqli_stmt_execute($stmt)){
         
                header("location: index.php");
                exit();
            } else{
                echo $stmt->error;
            }
        }
         
        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Добавить книгу</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Добавить книгу</h2>
                    <p>Укажите информацию о книге.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Название</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Дата написания</label>
                            <textarea name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>"><?php echo $date; ?></textarea>
                            <span class="invalid-feedback"><?php echo $date_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Автор</label>
                            <input type="text" name="author" class="form-control <?php echo (!empty($author_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $author; ?>">
                            <span class="invalid-feedback"><?php echo $author_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Отмена</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>