<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once("Connection.php");
    $conn = Connection::getConnection();
    // print_r($conn)

    if(isset($_POST ['submetido'])){
        $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : null;
    $genero = isset($_POST['genero']) ? $_POST['genero'] : null;
    $qtdPaginas = isset($_POST['qtdPaginas']) ? $_POST['qtdPaginas'] : null;

    $sql = 'INSERT INTO livros(titulo,genero,qtd_paginas)' . 'VALUES(?,?,?)';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$titulo, $genero, $qtdPaginas]);

    header("location: livros.php");

    } 
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Livros</title>
</head>

<body>
    <h1>Cadastro de Livros</h1>

    <h3>Formulário de Livros</h3>

    <form action="" method="POST">
        <input type="text" name="titulo" placeholder="Informe o Título" /><br><br>
        <select name="genero">
            <option value="">--Selecione--</option>
            <option value="D">Drama</option>
            <option value="R">Romance</option>
            <option value="F">Ficção</option>
            <option value="O">Outros</option>
        </select>
        <br><br>

        <input type="number" name="qtdPaginas" placeholder="Informe o número de páginas"><br><br>

        <button type="submit">Cadastar</button>

        <input type="hidden" name="submetido" value="1">
    </form>

    <h3>Listagem de Livros</h3>

    <?php
    $sql = "SELECT* FROM livros";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

    // print_r($result);
    ?>

    <table border="1"  >
        <tr  bgcolor="#48fafa">
            <td>ID</td>
            <td>Título</td>
            <td>Gênero</td>
            <td>Páginas</td>
            <td></td>
        </tr>

        <?php foreach ($result as $reg) : ?>
            <tr>
                <td> <?php echo $reg['id'] ?> </td>
                <td> <?php echo $reg['titulo'] ?> </td>
                <td> <?php
                        switch ($reg['genero']) {
                            case 'D':
                                echo "Drama";
                                break;
                            case 'F':
                                echo "Ficção";
                                break;
                            case 'R':
                                echo "Romance";
                                break;
                            case 'O':
                                echo "Outros";
                                break;
                        }
                        ?>
                </td>
                <td> <?php echo $reg['qtd_paginas'] ?> </td>
                <td><a style="color:red" href="livros_del.php?id=<?php echo $reg['id']?>" onclick=" return confirm('Confirma a exclusão?');">
                Excluir</a></td>
            </tr>

        <?php endforeach; ?>


    </table>

</body>

</html>