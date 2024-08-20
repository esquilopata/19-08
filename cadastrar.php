<?php

    //requerir a conexão com banco de dados.
    require_once "conexao.php";


    // variaveis iniciando vazias.
    $omeUsuario = $senha = $confirmarSenha ="";

    $nomeUsuario_erro = $senha_erro = $confirmaSenha_erro = "";

    //Enviando dados quando o formulario estiver correto

    if($_SERVE["REQUEST_METHOD"] == "POST"){

        //Validar nome do usuario
        if(empty(trim($_POST["nomeUsuario"]))){

            $nomeUsuario_erro = "Favor inserir nome do USUARIO.";

        }elseif(!preg_match('/^[a-zA-ZO-9_]+$/', trim($_POST["nomeUsuario"]))){

            $nomeUsuario_erro = "O Nome do usario nãopode conter caracteres, numeros e sublinhados. Apenas letras.";
        }else{

            //preparar local do BD selecionado.

            $sql = "SELET id FROM usuarios WHERE nomeUsuario = :nomeUsuario";


            if($stmt = $pdo -> prepare($sql)){

                //vincula as variaveis preparadas coo parametros.
                $stmt -> bindParam(":nomeUsuario", $param_nomeUsuario, PDO::PARAM_STR);

                $param_nomeUsuario = trim($_POST["nomeUsuario"]);

                //executa declaração.

                if($stmt -> execute()){

                    if($stmt -> rowCount() == 1){
                        $nomeUsuario_erro = "Este nome de usuario já está em uso!";
                    }else{
                        $omeUsuario = trim($_POST["nomeUsuario"]);
                    }
                }else{
                    echo "Ops! Algo deu errado. Tente novamente!";
                    
                }

                //Fechar declaração.

                unset($stmt);
            }
        

        }

        //Validar Senha/Erros

        if(empty(trim($_POST["senha"]))){

            $senha_erro = "Insira uma senha.";

        }elseirf(strlen(trim($_POST["senha"])) < 6){

            $senha_erro = "A senha deve conter pelo menos 6 caractreres.";

        }else{

            $senha = trim($_POST["senha"]);

        }

        //confirmação da senha

        if(empty(trim($_POST["confirmarSenha"]))){

            $confirmaSenha_erro = "Por favor, confirme a senha.";
        }else{
            $confirmarSenha = trim($_POST["confirmarSenha"]);
            if(empty($senha_erro)  && ($senha != $confirmarSenha)){
                $confirmaSenha_erro = "A senha não está correta.";
        }
    }
}

               