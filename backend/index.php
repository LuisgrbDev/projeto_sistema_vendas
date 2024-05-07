<?php
require_once("template/header.php");
// require_once 'dao/UsarioDAO.php';
// require_once 'entity/Usario.php';
require_once 'dao/GrupoUsuarioDAO.php';
require_once 'entity/grupo.php';

// $usuarioDao = new UsuarioDAO();
// print_r($usuarioDao->getAll());

// $novoUsuario = new Usuario(null, "novo usuario B", "1234aerqe", "novouser@mail.com", null, 1);
// echo $novoUsuario->getNomeUsuario();


// $usuarioDao->create($novoUsuario);
// $novoUsuario = new Usuario(2, "Clayton", "1234aerqe", "novouser@mail.com", null, 1);
// $usuarioDao->update($no);
// $grupo = new GrupoDAO();
// print_r($grupo->getAll());

$grupodao = new GrupoDAO();
$novoGrupo = new GrupoUsuario(null, "teste", "teste", null, 1);
$grupodao->create($novoGrupo);

 


?>
<h1>Olá Sistema Vendas Body</h1>
</body>

<?php
require_once("template/footer.php");
?>