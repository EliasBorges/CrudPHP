<?php 

$acao = "create";
$id = "";
$logadouro = "";
$numero = "";
$bairro = "";
$cidade = "";
$cep = "";
$complemento = "";
$uf = "";


if( isset($_GET["id"])){
  $acao = "update";

  $CadastrarEnderecoModel = new CadastrarEnderecoModel();

  $endereco = $CadastrarEnderecoModel->consultarPorId($_GET["id"]);

  $id = $endereco["codigo"];
  $logadouro = $endereco["logadouro"];
  $numero = $endereco["numero"];
  $bairro = $endereco["bairro"];  
  $cidade = $endereco["cidade"];
  $cep = $endereco["cep"];
  $complemento = $endereco["complemento"];
  $uf = $endereco["uf"]; 

  echo "<div class='card-panel teal lighten-2'>Categoria inserida com sucesso.</div>";
}

if($acao == "update"){
  $id = $endereco["Codigo"];
  $logadouro = $endereco["Logadouro"];
  $numero = $endereco["numero"];
  $bairro = $endereco["bairro"];  
  $cidade = $endereco["cidade"];
  $cep = $endereco["cep"];
  $complemento = $endereco["complemento"];
  $uf = $endereco["uf"]; 

  $CadastrarEnderecoModel->alterar($logadouro, $numero, $bairro, $cidade, $cep, $complemento, $uf);

  echo "<div class='card-panel teal lighten-2'>Categoria editada com sucesso.</div>";
}


?>
<?php
$conectar = mysqli_connect("localhost","root","","controleendereco") or die ("Erro na conex達o com o Banco de Dados");
mysqli_query($conectar, 'SET NAMES utf8');

$sql = "SELECT uf.CodigoIbge, uf.Sigla, uf.NomeEstado FROM unidadefederativa as uf";

$result = mysqli_query($conectar, $sql);

?>


<div class="form-horizontal">
  <form method="post" id="formCadastrarEndereco" action="../controller/CadastrarEnderecoController.php?acao=<?=$acao?>">
    <div class="form-group">
      <div class="col-sm-2">
        <label>Codigo</label>
        <input type="text" class="form-control" name="codigo" disabled>
      </div>

      <div class="col-sm-4">
        <label>Logadouro</label>
        <input type="text" class="form-control" name="logadouro" placeholder="Exemplo: Rua, Avenida">
      </div>


      <div class="col-sm-2">
        <label>Numero</label>
        <input type="text" class="form-control" name="numero" placeholder="Digite o numero">
      </div>

      <div class="col-sm-4">
        <label>Bairro</label>
        <input type="text" class="form-control" name="bairro" placeholder="Digite o bairro">
      </div>


    </div>

    <div class="form-group">
      <div class="col-sm-4">
        <label>Cidade</label>
        <input type="text" class="form-control" name="cidade" placeholder="Digite sua cidade">
      </div>

      <div class="col-sm-2">
        <label>CEP</label>
        <input type="text" class="form-control" name="cep" placeholder="Digite o CEP">
      </div>

      <div class="col-sm-2">
        <label>Complemento</label>
        <input type="text" class="form-control" name="complemento" placeholder="Digite o complemento">
      </div>

      <div class="col-sm-4">
        <label>Unidade Federativa</label>
        <select class="form-control" name="uf">
          <option>Selecione seu estado</option>
          <?php

          while($row = $result->fetch_assoc()){
            echo'
            <option value='.$row[CodigoIbge].'>'.$row[Sigla].' - '.$row[NomeEstado].'</option>
            ';
          }
          ?>
        </select>
      </div>
    </div><br>

    <div class="form-group" id="formSalvar">
      <div class="col-sm-3">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </div>

    <div id="mensagem"></div>
  </form>
</div>
<script type="text/javascript">

$("#formCadastrarEndereco").submit(function(event) {
 event.preventDefault();

 $.ajax({
  url: $("#formCadastrarEndereco").attr("action"),
  method: $("#formCadastrarEndereco").attr("method"),
  data: $("#formCadastrarEndereco").serialize(),
  success: function(data){
    $("#mensagem").html(data);
    $("#formCadastrarEndereco ").trigger('reset');
    $("#tabela").load("visualizar.php")
  }
})
});

</script>