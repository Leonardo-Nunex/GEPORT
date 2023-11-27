<?php
session_start();

if (isset($_SESSION['matricula_usuario'])) {
    require_once '../conexao/conexao.php';

    $matricula_usuario = $_SESSION['matricula_usuario'];

    // Consulta para obter os dados do usuário
    $queryUsuario = "SELECT * FROM usuario WHERE matricula_usuario = :matricula_usuario";
    $pdoResultUsuario = $conexao->prepare($queryUsuario);
    $pdoResultUsuario->execute(array(":matricula_usuario" => $matricula_usuario));
    $dadosDoUsuario = $pdoResultUsuario->fetch(PDO::FETCH_ASSOC);

    // Consulta para obter os dados do curso
    $queryCurso = "SELECT * FROM cursos WHERE codigo = :codigo_curso_fk";
    $pdoResultCurso = $conexao->prepare($queryCurso);
    $pdoResultCurso->execute(array(":codigo_curso_fk" => $dadosDoUsuario['codigo_curso_fk']));
    $dadosDoCurso = $pdoResultCurso->fetch(PDO::FETCH_ASSOC);

    if ($dadosDoCurso) {
        $nome = $dadosDoCurso['nome'];
        $codigoCurso = $dadosDoCurso['codigo'];
    } else {
        echo 'Erro ao recuperar o nome do curso.';
        exit;
    }

    if ($dadosDoUsuario) {
        // Preencha as variáveis com os dados do usuário
        $nome_usuario = $dadosDoUsuario['nome_usuario'];
        $cpf = intval($dadosDoUsuario['cpf']);
        $sexo = $dadosDoUsuario['sexo'];
        $telefone = $dadosDoUsuario['telefone'];
        $endereco = $dadosDoUsuario['endereco'];
        $uf = $dadosDoUsuario['uf'];
        $cidade = $dadosDoUsuario['cidade'];
        $data_nascimento = $dadosDoUsuario['data_nascimento'];
        $email = $dadosDoUsuario['email'];
        $senha = $dadosDoUsuario['senha'];
    } else {
        echo 'Erro ao recuperar os dados do usuário.';
        exit;
    }
} else {
    echo 'Você não está logado ou não tem permissão para acessar esta página.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="atualizar.css">
    <title>Atualização de Cadastro
    </title>
</head>

<body>
    <div class="conteudo-1">
        <div class="cadastro">
            <div class="itens-form">
                <form action="atualizar_dados.php" method="post">
                    <h1>ATUALIZAR CADASTRO</h1>
                    <div class="input-2">
                        <input type="text" class="inputS" required name="nome_usuario" value="<?php echo $nome_usuario; ?>">
                        <i class='bx bx-user'></i>
                        <label for="nome">Nome</label>
                    </div>
                    <div class="input-2">
                        <input type="number" class="inputS" id="cpf" required name="cpf" value="<?php echo $cpf; ?>">
                        <i class='bx bx-user'></i>
                        <label for="cpf">CPF</label>
                    </div>
                    <div class="input-2" class="selecao">
                        <div id="DropDown">
                            <label for="sexo">Selecione o Sexo</label><br><br>
                            <label for="Cursos">Selecione o Curso</label><br>
                            <select id="sexo" name="sexo" required class="input-4">
                                <option value="<?php echo $sexo; ?>"><?php echo $sexo; ?></option>
                                <option value="Masculino" class="op">Masculino</option>
                                <option value="Feminino" class="op">Feminino</option>
                                <option value="Outro" class="op">Outro</option>
                            </select>
                            <br>
                            <select id="Cursos" name="Cursos" required class="input-4">
                                <option value="<?php echo $codigoCurso ;?>" class="op"><?php echo $nome; ?></option>
                                <option value="401" class="op">Administração</option>
                                <option value="402" class="op">Direito</option>
                                <option value="403" class="op">Enfermagem</option>
                                <option value="404" class="op">Estética e Coméstica</option>
                                <option value="405" class="op">Fisioterapia</option>
                                <option value="406" class="op">Gastronomia</option>
                                <option value="407" class="op">Gestão de RH</option>
                                <option value="408" class="op">Logística</option>
                                <option value="409" class="op">Nutrição</option>
                                <option value="410" class="op">Sistemas de Informação</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-2">
                        <input type="tel" class="inputS" required name="telefone" value="<?php echo $telefone; ?>">
                        <i class='bx bx-user'></i>
                        <label for="telefone">Telefone</label>
                    </div>
                    <div class="input-2">
                        <input type="text" class="inputS" required name="endereco" value="<?php echo $endereco; ?>">
                        <i class='bx bx-user'></i>
                        <label for="endereco">Endereço</label>
                    </div>
                    <div class="input-2">
                        <input type="text" class="inputS" required name="uf" value="<?php echo $uf; ?>">
                        <i class='bx bx-user'></i>
                        <label for="uf">UF</label>
                    </div>
                    <div class="input-2">
                        <input type="text" class="inputS" required name="cidade" value="<?php echo $cidade; ?>">
                        <i class='bx bx-user'></i>
                        <label for="cidade">Cidade</label>
                    </div>
                    <div class="input-2">
                        <input type="date" class="inputS" required name="data_nascimento" value="<?php echo $data_nascimento; ?>">
                        <i class='bx bx-user'></i>
                        <label for="data_nascimento"></label>
                    </div>
                    <div class="input-2">
                        <input type="email" class="inputS" required name="email" value="<?php echo $email; ?>">
                        <i class='bx bx-user'></i>
                        <label for="email">E-mail</label>
                    </div>
                    <div class="input-2">
                        <input type="password" class="inputS" required name="senha" value="<?php echo $senha; ?>">
                        <i class='bx bx-user'></i>
                        <label for="senha">Senha</label>
                    </div>


                    <div>
                    <button id="voltar" type="button" onclick="window.location.href='../perfil/perfil.html'">Cancelar</button>
                    </div>
                    <div class="input-2">
                        <input type="submit" name="update" required placeholder="Update Data">
                        <i class='bx bx-user'></i>
                    </div>
                </form>
            </div>
        </div>
</body>

</html>