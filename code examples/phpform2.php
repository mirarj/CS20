<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Form Demo</title>
    <style type="text/css">
        html,body {font-size:  20px;}
        .col1 {width: 150px; text-align: right; display: inline-block;}
        form input {width: 100px; font-size: 18px;}
        form {padding:  20px; background-color: #e7e7e7;margin: 20px; max-width: 300px;}
        .form-item {margin-bottom: 10px;}
        form input.submit {margin: 0 auto; display:block; width: 150px;}
    </style>
</head>

<body>
    <?php
    if (isset($_GET["num1"]))
    {
         //echo "need to process the form<br>";
        $n1 = $_REQUEST["num1"];
        $n2 = $_REQUEST["num2"];
        $op = $_REQUEST["add_subtract2"];
        if ($op == 'add')
            $sum = $n1 + $n2;
        else 
            $sum = $n1 - $n2;
        echo "The result is:  $sum<br>";
    }   
    else
    {
        $n1 = 100;
        $n2 = 101;
    }
    
    echo  "<script language = 'javascript'>n1=$n1</script>";
        
    
    ?>
    <script language="javascript">
    alert("The value of n1 is " + n1);
    </script>
    
    <form method='get' action = 'phpform2.php'>
        <div class='form-item'>
            <div class='col1'>First number:</div>
            <input type='text' name="num1" 
                   value="<?php echo $n1;   ?>">
        </div>
        <div class='form-item'>
            <div class='col1'>Second number:</div> 
            <input type='text' name="num2"
                   value="<?php echo $n2;   ?>">
        </div>
        <!--div class='form-item'>
            <div class='col1'>Pick 1:</div> 
            <input type='radio' name="add_subtract" value = 'add'>add<br>
            <input type='radio' name="add_subtract" value = 'subtract'>subtract
        </div -->
         <div class='form-item'>
            <div class='col1'>Choose operation:</div> 
            <select name="add_subtract2" size='1'>
                <option value='add'>add</option>
                <option 
                        value='subtract'     
                        <?php
                           if ($op == 'subtract')
                               echo "selected='1'";
                        ?>
                        > <!-- end option -->
                    subtract</option>
             </select>
        </div>
        <input type="submit" value="Add Them" class='submit'>
    </form>
</body>
</html>
