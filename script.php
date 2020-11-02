<?php

// 1. conectar com o banco
// 2. criar a tabela de estados
// 3. ler o arquivo de estados
// 3.1 linha a linha fazer insert
// 4. criar a tabela de cidades
// 5. ler o arquivo de cidades
// 5.1 linha alinha fazer o insert

//Criar as constantes com as credencias de acesso ao banco de dados
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DATABASE', 'cidades_estados');

try {
    $conexao = new PDO('mysql:host=' . HOST . ';dbname=' . DATABASE, USER, PASS);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $erro) {
    echo "Erro ao tentar se conectar com o Banco de Dados: {$erro->getMessage()}";
}

$conexao->query(" DROP DATABASE IF EXISTS `atv_back_2`;
CREATE DATABASE IF NOT EXISTS `atv_back_2` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `atv_back_2`;

CREATE TABLE estado (
  	`cod_uf` varchar(2) NOT NULL,
  	`cod_ibge` int(11) NOT NULL DEFAULT '0',
  	`nome_estado` varchar(255) NOT NULL DEFAULT '0',
  	`nome_regiao` varchar(255) NOT NULL DEFAULT '0',
  	`quantidade_cidades` int(11) NOT NULL DEFAULT '0',
  	PRIMARY KEY (`cod_uf`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `atv_back_2` . `municipio`;
CREATE TABLE IF NOT EXISTS `atv_back_2`.`municipio` (
  	`cod_ibge` int(11) NOT NULL,
  	`cod_uf` varchar(2) NOT NULL,
  	`nome_municipio` varchar(255) NOT NULL,
  	`nome_regiao` varchar(255) NOT NULL,
  	`quantidade_populacao` int(11) NOT NULL,
  	`tipo_porte` varchar(255) NOT NULL,
  	PRIMARY KEY (`cod_ibge`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4; 

ALTER TABLE municipio
    ADD CONSTRAINT fk_estados FOREIGN KEY (cod_uf)
    REFERENCES estados(cod_uf) ON DELETE RESTRICT ON UPDATE RESTRICT;");


$estados = array_map(function($arquivo) {return str_getcsv($arquivo, ';', '', '');}, file('lista_estados.csv'));
unset($estados[0]);

foreach ($estados as $key => $estado) {
	$sql = $conexao->prepare(" INSERT INTO estado VALUES(:cod,:ibge,:estado,:regiao,:cidades) ");
	$sql->execute(array(
		':cod' => $estado[2],
		':ibge' => $estado[0],
		':estado' => $estado[1],
		':regiao' => $estado[3],
		':cidades' => $estado[4]
	));
}

$municipios = array_map(function($arquivo) {return str_getcsv($arquivo, ';', '', '');}, file('lista_muncipios.csv'));
unset($municipios[0]);

foreach ($municipios as $key => $municipio) {
	if(!isset($municipio[6])) {
		echo 'Pulando cidade que falta dados: ' . $municipio['4'] . '<br>';
		continue;
	}
	$sql = $conexao->prepare(" INSERT INTO municipio VALUES(:cod,:uf,:nome,:regiao,:habitantes,:porte) ");
	$sql->execute(array(
		':cod' => $municipio[1],
		':uf' => $municipio[3],
		':nome' => $municipio[4],
		':regiao' => $municipio[5],
		':habitantes' => $municipio[6],
		':porte' => $municipio[7]
	));
}