<main>
<?php
@$id=$_REQUEST['id'];
    if($id == 0){
        echo "<style type='text/css'>
        #m0{
            background-color: white;
            color: #555;
            border-radius: 5px;
        }
        </style>";

        echo "<div id='home'>";
        echo "<div id='home_esquerda'>";
        echo "<img src='res/contab.jpg'>";
        echo "</div>";
        echo "<div id='home_direita'>";
        echo "<p style='font-size: 32px;'>LivraSoft Sistema de gestão de stocks de livros</p>";
        echo "Este programa será desenvolvido no âmbito do módulo 5407, do curso de Técnico de programação de sistemas informáticos que tem como objetivo a criação de um Software de controlo de stock de um armazém de livros. O programa deve permitir a inserção de livros, livrarias e fornecedores, identificação e registo das transações entre o armazém, as livrarias e fornecedores. A funcionalidade final será uma geração automática de entrada e saída de stocks semanal.";
        echo "</div>";
        echo "</div>";
    }
    else if($id == 1){
        echo "<style type='text/css'>
        #m1{
            background-color: white;
            color: #555;
            border-radius: 5px;
        }
        </style>";

        echo "<h2>Novo Utilizador</h2>";
        echo "<div class='form_criar'>";
        echo "<form name='criar_trabalhador' method='post'>
        <br><label>Nome:</label><br>
        <input type='text' required name='Nome' placeholder='Primeiro Nome '><br>
        <label>Sobrenome:</label><br>
        <input type='text' required name='sobrenome' placeholder='Ultimo Nome'><br>
        <label>Email:</label><br>
        <input type='email' required name='mail' placeholder='Endereço de correio eletrónico'><br>
        <label>Username:</label><br>
        <input type='text' required name='username' placeholder='O nome através do qual se irá autenticar'><br>
        <label>Password:</label><br>
        <input type='password' required name='password'><br>
        <input type='submit' name='criar' value='Registar'>
        </form></div>";

        if(isset($_POST['criar'])){
            include 'tools/key.php';

            $comando="SELECT * FROM tbl_login";
            $sql=mysqli_query($conn, $comando);

            $row=mysqli_fetch_array($sql);

            if($row['Nome'] == $_POST['Nome']){
                echo "<script>alert('Já existe um utilizador com o mesmo nome!');</script>";
                echo "<meta http-equiv='refresh' content='0'; URL='Index.php?id=1'>";
            }
            else
            {
                $comando="INSERT INTO tbl_login (Username, Email, Nome, Sobrenome, Password) VALUES ('$_POST[username]', '$_POST[mail]', '$_POST[Nome]', '$_POST[sobrenome]', '$_POST[password]')";
                $sql=mysqli_query($conn, $comando);

                if(!$sql){
                    die("Erro: ".mysqli_error());
                }
                else{
                    echo "<script>alert('Utilizador Criado com Sucesso!');</script>";
                    echo "<meta http-equiv='refresh' content='0'; URL='Index.php?id=1'>";
                }
            }	
        }
    }
    
    else if($id == 2){

        echo "<style type='text/css'>
        #m2{
            background-color: white;
            color: #555;
            border-radius: 5px;
        }
        </style>";

        echo "<h2>Login</h2>";
        echo "<div class='form_criar'>";
        echo "<form name='login' method='post'>
        <br>
        <label>Username:</label><br>
        <input type='text' required name='username' placeholder='blackmaster'><br>
        <label>Password:</label><br>
        <input type='password' required name='password' ><br>
        <input type='submit' name='login' value='Login'>
        </form>";
        echo "</div>";
        @$username=$_REQUEST["username"];
        @$password=$_REQUEST["password"];
        session_start(); 
        if (isset($_POST['login'])) {
            if (empty($_POST['username']) || empty($_POST['password'])) {
                $error = "Username or Password is invalid";
            }
            else{
                $username=$_POST['username'];
                $password=$_POST['password'];
                include 'tools/key.php';
                $query = mysqli_query($conn, "select * from tbl_login where Password='$password' AND Username='$username'");
                $rows = mysqli_num_rows($query);
                if ($rows == 1) {
                    session_start();
                    $_SESSION['login_user']=$_POST['username']; 
                    header("Location: index.php?id=3");
                } 
                else {
                    echo "<script>alert('Erro de login');</script>";
                }
                mysql_close($conn); 
            }
        }
    }
    
    else if($id == 3){
        session_start();
        if(!$_SESSION["login_user"]){
            echo "<script>alert('Precisa de Iniciar Sessão');</script>";
            session_destroy();
            header("Location: index.php?id=2") ;
        }
        echo "<style type='text/css'>
        #m3{
            background-color: white;
            color: #555;
            border-radius: 5px;
        }
        </style>";
        include 'tools/key.php';
        $comando="SELECT * FROM tbl_autores";
        $sql=mysqli_query($conn, $comando);
        echo "<h2>Novo Livro</h2>";
        echo "<div class='form_criar'>";
        echo "<form name='criar_livro' method='post'>
        <br><label>Titulo:</label><br>
        <input type='text' required name='titulo'><br>
        <br><label>Autor:</label><br>
        <select name='autor'>";
        while ($row=mysqli_fetch_array($sql)){
            echo "<option value='".$row['ID_autor']."'>".$row['Nome']."</option>";
        }
        $comando="SELECT * FROM tbl_tema";
        $sql=mysqli_query($conn, $comando);
        echo "</select><br><br>
        <br><label>Tema:</label><br>
        <select name='tema'>";
        while ($row=mysqli_fetch_array($sql)){
            echo "<option value='".$row['ID_tema']."'>".$row['Nome_tema']."</option>";
        }
        echo "</select><br><br>
        <label>Ano:</label><br>
        <input type='number' required name='ano' Min='1000'><br>
        <label>Quantidade:</label><br>
        <input type='number' required name='quantidade' Min='1'><br>
        <input type='submit' name='criar_livro' value='Criar Livro'>
        </form></div>";
        if(isset($_POST['criar_livro'])){
            $comando="INSERT INTO tbl_livros (Titulo, Ano, Quantidade, ID_autor, ID_tema) VALUES ('$_POST[titulo]', '$_POST[ano]', '$_POST[quantidade]', '$_POST[autor]', '$_POST[tema]')";
            $sql=mysqli_query($conn, $comando);
            if(!$sql){
                die("Erro: ".mysqli_error());
            }
            else{
                echo "<script>alert('Livro Criado com Sucesso!');</script>";
                echo "<meta http-equiv='refresh' content='0'; URL='Index.php?id=1'>";
            }
        }
    }
    
    else if($id == 4){
        session_start();
        if(!$_SESSION["login_user"]){
            echo "<script>alert('Precisa de Iniciar Sessão');</script>";
            session_destroy();
            header("Location: index.php?id=2") ;
        }
        echo "<style type='text/css'>
        #m4{
            background-color: white;
            color: #555;
            border-radius: 5px;
        }
        </style>";
        include 'tools/key.php';
        $comando="SELECT * FROM tbl_livros";
        $sql=mysqli_query($conn, $comando);
        echo "<h2>Transação de entrada de stock</h2>
        <form name='entrastock' method='post'>
        <div class='form_criar'>
        <br><label>Livro:</label><br>
        <select name='livroin'>";
        while ($row=mysqli_fetch_array($sql)){
            echo "<option value='".$row['ID_livro']."'>".$row['Titulo']."</option>";
        }
        $cmd="SELECT * FROM tbl_fornecedores";
        $sql=mysqli_query($conn, $cmd);
        echo "</select><br><br>
        <br><label>Fornecedor:</label><br>
        <select name='fornecedor'>";
        while ($row=mysqli_fetch_array($sql)){
            echo "<option value='".$row['ID_Fornecedor']."'>".$row['Nome']."</option>";
        }
        echo "</select><br><br>
        <label>Quantidade:</label><br>
        <input type='number' required name='qty_in' Min='1'><br>
        <input type='submit' name='fazer_trans_in' value='Transferir'>
        </div></form></div>";
        
        $comando="SELECT * FROM tbl_livros";
        $sql=mysqli_query($conn, $comando);
        echo "<h2>Transação de Saida de stock</h2>
        <form name='saistock' method='post'>
        <div class='form_criar'>
        <br><label>Livro:</label><br>
        <select name='livroout'>";
        while ($row=mysqli_fetch_array($sql)){
            echo "<option value='".$row['ID_livro']."'>".$row['Titulo']."</option>";
        }
        $cmd="SELECT * FROM tbl_livraria";
        $sql=mysqli_query($conn, $cmd);
        echo "</select><br><br>
        <br><label>Loja:</label><br>
        <select name='livraria'>";
        while ($row=mysqli_fetch_array($sql)){
            echo "<option value='".$row['ID_livraria']."'>".$row['Nome']."</option>";
        }
        echo "</select><br><br>
        <label>Quantidade:</label><br>
        <input type='number' required name='qty_out' Min='1'><br>
        <input type='submit' name='fazer_trans_out' value='Transferir'>
        </div></form></div>";
        if(isset($_POST['fazer_trans_out'])){
            $comando="SELECT * FROM tbl_livros where ID_livro=$_POST[livroout]";
            $sql=mysqli_query($conn, $comando);
            while ($row=mysqli_fetch_array($sql)){
                $totalbooks=$row['Quantidade'];
            }
            $mysqli = new mysqli ('localhost','jp1tz980_mnobre','01IqX8r19wXH','jp1tz980_fatima');
            $mysqli->autocommit(false);
            $total=intval($totalbooks)-intval($_POST[qty_out]);
            $mysqli->query("UPDATE tbl_livros set Quantidade=".$total." where ID_livro='$_POST[livroout]'");
            $mysqli->query("Insert into tbl_id_trans_out (Data, ID_livraria, Quantidade) VALUES(NOW(), '$_POST[livraria]', $_POST[qty_out])");
            if ($totalbooks>$_POST[qty_out]){
                $mysqli->commit();
                echo "<script>alert('Transferencia efectuada com Sucesso!');</script>";
            }
            else{
                $mysqli->rollback();
                echo "<script>alert('Transferencia não efectuada por falta de stock!');</script>";
            }
        }
        if(isset($_POST['fazer_trans_in'])){
            $comando="SELECT * FROM tbl_livros where ID_livro=$_POST[livroin]";
            $sql=mysqli_query($conn, $comando);
            while ($row=mysqli_fetch_array($sql)){
                $totalbooks=$row['Quantidade'];
            }
            $mysqli = new mysqli ('localhost','jp1tz980_mnobre','01IqX8r19wXH','jp1tz980_fatima');
            $mysqli->autocommit(false);
            $total=intval($totalbooks)+intval($_POST[qty_out]);
            $mysqli->query("UPDATE tbl_livros set Quantidade=".$total." where ID_livro='$_POST[livroin]'");
            $mysqli->query("Insert into tbl_id_trans_out (Data, ID_livraria, Quantidade) VALUES(NOW(), '$_POST[fornecedor]', $_POST[qty_in])");
            $mysqli->commit();
            echo "<script>alert('Transferencia efectuada com Sucesso!');</script>";
            
        }
    }
    
    else if($id == 5){
        session_start();
        session_destroy();
        header("location: index.php?id=0"); 
    }
       
?>
</main>