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
            $sql = "SELECT * FROM GrupoUsuario WHERE Id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return new GrupoUsuario(
                    $result['Id'],
                    $result['Nome'],
                    $result['Descricao'],
                    $result['DataCriacao'],
                    $result['DataAtualizacao'],
                    $result['Ativo']
                );
            }

            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAll()
    {
        try {
            $sql = "SELECT * FROM GrupoUsuario WHERE";
            $stmt = $this->db->prepare($sql);
            $grupos = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $grupos = new GrupoUsuario(
                    null,
                    $row['Nome'],
                    $row['Descricao'],
                    $row['DataCriacao'],
                    $row['DataAtualizacao'],
                    $row['Ativo']
                );
            }

            return $grupos;
        } catch (PDOException $e) {
            return [];
        }
    }


    public function create($grupoUsuario)
    {
        try {
            $sql = "INSERT INTO GrupoUsuario (Nome, Descricao, DataCriacao, DataAtualizacao, UsuarioAtualizacao, Ativo)
                    VALUES (:nome, :descricao, :dataCriacao, :dataAtualizacao, :usuarioAtualizacao, :ativo)";

            $stmt = $this->db->prepare($sql);

            $nome = $grupoUsuario->getNome();
            $descricao = $grupoUsuario->getDescricao();
            $dataCriacao = $grupoUsuario->getDataCriacao();
            $dataAtualizacao = $grupoUsuario->getDataAtulizacao();
            $usuarioAtualizacao = null;
            $ativo = $grupoUsuario->getAtivo();

            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':dataCriacao', $dataCriacao);
            $stmt->bindParam(':dataAtualizacao', $dataAtualizacao);
            $stmt->bindParam(':usuarioAtualizacao', $usuarioAtualizacao);
            $stmt->bindParam(':ativo', $ativo);

            return $stmt->execute();
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
