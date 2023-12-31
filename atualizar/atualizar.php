<?php
session_start();

if (isset($_SESSION['matricula_usuario'])) {
    require_once '../conexao/conexao.php';

    $matriculaUsuario = $_SESSION['matricula_usuario'];

    // Consulta para obter os dados do usuário
    $queryUsuario = "SELECT * FROM usuario WHERE matricula_usuario = :matricula_usuario";
    $pdoResultUsuario = $conexao->prepare($queryUsuario);
    $pdoResultUsuario->execute(array(":matricula_usuario" => $matriculaUsuario));
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
        echo '<script>alert("Erro ao recuperar dados do curso"); window.location="atualizarDados.php";<script>';
        exit;
    }

    if ($dadosDoUsuario) {
        // Preencha as variáveis com os dados do usuário
        $nomeUsuario = $dadosDoUsuario['nome_usuario'];
        $cpf = $dadosDoUsuario['cpf'];
        $sexo = $dadosDoUsuario['sexo'];
        $telefone = $dadosDoUsuario['telefone'];
        $endereco = $dadosDoUsuario['endereco'];
        $uf = $dadosDoUsuario['uf'];
        $cidade = $dadosDoUsuario['cidade'];
        $dataNascimento = $dadosDoUsuario['data_nascimento'];
        $email = $dadosDoUsuario['email'];
        $senha = $dadosDoUsuario['senha'];
    } else {
        echo '<script>alert("Erro ao recuperar os dados do usuário"); window.location="atualizarDados.php";<script>';
        exit;
    }
} else {
    echo '<script>alert("Você não está logado ou não tem permissão para acessar esta página"); window.location="atualizarDados.php";<script>';
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
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    </title>
</head>

<body>
    <script>
        function formatarCPF(cpf) {
            // Remove caracteres não numéricos
            cpf = cpf.replace(/\D/g, '');
            
            // Adiciona a máscara
            cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            
            // Atualiza o valor no campo
            document.getElementById('cpf').value = cpf;
        }
    </script>
    <script>
        function formatarTelefone(telefone) {
            // Remove caracteres não numéricos
            telefone = telefone.replace(/\D/g, '');
            
            // Adiciona a máscara
            telefone = telefone.replace(/(\d{2})(\d{9})/, '($1)$2');
            
            // Atualiza o valor no campo
            document.getElementById('telefone').value = telefone;
        }
    </script>
    <div class="conteudo-1">
        <div class="cadastro">
            <div class="itens-form">
                <form action="atualizar_dados.php" method="post">
                    <h1>ATUALIZAR CADASTRO</h1>
                    <div class="input-2">
                        <input type="text" class="inputS" required name="nome_usuario" value="<?php echo $nomeUsuario; ?>">
                        <i class='bx bx-user'></i>
                        <label for="nome">Nome</label>
                    </div>
                    <div class="input-2">
                    <input type="text" id="cpf" oninput="formatarCPF(this.value)" maxlength="14" name="cpf" required class="inputS" value="<?php echo $cpf; ?>">
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
                    <input type="text" id="telefone" oninput="formatarTelefone(this.value)" maxlength="13" name="telefone" required class="inputS" value="<?php echo $telefone; ?>">
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
                        <input type="date" class="inputS" required name="data_nascimento" value="<?php echo $dataNascimento; ?>">
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
                    <div class="input-2">
                    <button id="voltar" type="button" onclick="window.location.href='../perfil/perfil.php'">Cancelar</button>
                        <input type="submit" name="update" required placeholder="Update Data">
                        <i class='bx bx-user'></i>
                    </div>
                </form>
            </div>
        </div>
</body>

</html>