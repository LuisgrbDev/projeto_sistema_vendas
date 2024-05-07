<?php

require_once 'config/Database.php';
require_once 'entity/Grupo.php';
require_once 'BaseDAO.php';

class GrupoDAO implements BaseDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getById($id)
    {
        try {
            // Preparar a consulta SQL
            $sql = "SELECT * FROM grupousuario WHERE Id = :id";

            // Preparar a instrução
            $stmt = $this->db->prepare($sql);

            // Vincular parâmetros
            $stmt->bindParam(':id', $id);

            // Executa a instrução
            $stmt->execute();

            // Obtem o usuario encontrado;
            $grupo = $stmt->fetch(PDO::FETCH_ASSOC);

            // Retorna o usuário encontrado
            return $grupo ?
                new Usuario(
                    $grupo['Id'],
                    $grupo['Nome'],
                    $grupo['Descricao'],
                    $grupo['DataCriacao'],
                    $grupo['DataAtualizacao'],
                    $grupo['Ativo']
                )
                : null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAll()
    {
        try {
            // Preparar a consulta SQL
            $sql = "SELECT * FROM grupousuario";

            // Preparar a instrução
            $stmt = $this->db->prepare($sql);

            // Executar a instrução
            $stmt->execute();

            // Obter todos os usuários encontrados
            $grupo = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Retornar os usuários encontrados
            return array_map(function ($grupo) {
                return new GrupoUsuario(
                    $grupo['Id'],
                    $grupo['Nome'],
                    $grupo['descricao'],
                    $grupo['DataCriacao'],
                    $grupo['DataAtualizacao'],
                    $grupo['UsuarioAtualizacao'],
                    $grupo['Ativo']
                );
            }, $grupo);
        } catch (PDOException $e) {
            return [];
        }
    }


    public function create($grupo)
    {
        try {
            // Preparar a consulta SQL
            $sql = "INSERT INTO grupousuario( nome , descricao, usuarioatualizacao, Ativo, dataCriacao , dataAtualizacao)
                    VALUES(:nome, :descricao,:usuarioatualizacao,:ativo, current_timestamp(), current_timestamp())";

            // Preparar a instrução
            $stmt = $this->db->prepare($sql);

            // Bind parameters by reference
            $nomeGrupo = $grupo->getNome();
            $descricao = $grupo->getDescricao();
            $dataCriacao = $grupo->getDataCriacao();
            $dataAtualizacao = $grupo->getDataAtulizacao();
            $usuarioAtualizacao = $grupo->getUsuarioAtualizacao();
            $ativo = $grupo->getAtivo();

            $stmt->bindParam(':nome', $nomeGrupo);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':dataCriacao', $dataCriacao);
            $stmt->bindParam(':dataAtualizacao', $dataAtualizacao);
            $stmt->bindParam(':usuarioAtualizacao', $usuarioAtualizacao);
            $stmt->bindParam(':ativo', $ativo);

            // Executar a instrução
            $stmt->execute();

            // Retornar verdadeiro se a inserção for bem sucedida
            return true;
        } catch (PDOException $e) {
            // TO-DO: implementar log
            return false;
        }
    }

    public function update($usuario)
    {
        try {
            // Verifico se o usuário existe no banco de dados
            $existingUser = $this->getById($usuario->getId());

            if (!$existingUser) {
                return false; // Retorna falso se o usuário não existir
            }

            $sql = "UPDATE Usuario SET NomeUsuario = :nomeUsuario, Senha = :senha, Email = :email,
            GrupoUsuarioID = :grupoUsuarioID, Ativo = :ativo, DataAtualizacao = current_timestamp()
            WHERE Id = :id";

            $stmt = $this->db->prepare($sql);
            $id = $usuario->getId();
            $nome = $usuario->getNomeUsuario();
            $senha = $usuario->getSenha();
            $email = $usuario->getEmail();
            $grupoUsuarioID = $usuario->getGrupoUsuarioId();
            $ativo = $usuario->getAtivo();

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nomeUsuario', $nome);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':grupoUsuarioID', $grupoUsuarioID);
            $stmt->bindParam(':ativo', $ativo);


            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            // TO-DO: implementar log
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM Usuario WHERE Id = :id";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
