<?php
    require_once("Connection.php");
    $id=isset($_GET['id'])? $_GET['id'] : null;

    if($id){
        $conn= Connection::getConnection();
        $sql="DELETE FROM livros WHERE id=?";
        $stmt= $conn->prepare($sql);
        $stmt->execute([$id]);

    header("location: livros.php");

    }else{
        echo "ID não encontrado.";
        echo "<br>";
        echo "<a href='livros.php'>Voltar</a>";
    }

?>