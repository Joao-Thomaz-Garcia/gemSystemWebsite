<?php include("nav.php")?>
<link rel="stylesheet" href="./css/login.css">
    <style>
        input {
            all: unset;
            padding: 5px;
            border: 1px solid rgb(219, 219, 219);
            margin-bottom: 10px!important;
        }
        button{
            cursor: pointer;
            transition-duration: 0.4s;
            }
            button:hover {
    background-color: rgb(30, 195, 241);
            }
    </style>

    <!-- HEADER - LOGIN -->
<header style="background-color: rgba(239,238,241,255);">
    <div style="
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-content: center;
    justify-content: center;
    align-items: center;"
 >
    <div class="left"
    style="height: 990px;
           width: 700px;
           background-image: url(images/gem.jfif);
           background-repeat: no-repeat;
           ">
    </div>
    <div class="right">
   
        <form style="
        display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
        align-content: center;
        align-items: stretch;
        justify-content: center;
        width: 350px;
        background-color: white;
        border: 1px solid rgb(219, 219, 219);
        padding: 40px;" action="" method="POST">

            <img src="images/logoGEM.png" style="padding: 0px 70px 30px 70px" alt="">

            <input type="text" placeholder="Insert Your E-mail Here">
            <button type="submit" style="
            text-align: center;
            margin-top: 10px;
            border-radius: 5px;
            padding: 10px;
            ">Request A New Password</button>

            </form>

        </div>
    </div>
</header>

    
    