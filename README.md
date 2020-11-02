Este projeto está licenciado sob os termos da licença MIT.

### Atividade de Estudo Back end 2
# Importação de Estados e Cidades 

Imagine que recebeu de sua equipe a missão simples
de criar estas tabelas e importar os registros no 
banco e para esta atividade irá usar seus
conhecimentos em PHP e PDO para fazer
a criação destas tabelas e posteriormente
a importação dos dados.


**Diante disso, desenvolva um script.php que atenda
aos requisitos abaixo (recebido de sua equipe)**

## Requisitos

1. criar uma tabela chamada estado com os campos
    - cod_uf varchar(2) chave primária
    - cod_ibge int
    - nome_estado varchar(255)
    - nome_regiao varchar(255)
    - quantidade_cidades (int)
    - **todos estes campos com valores obrigatórios**

2. importar para a tabela estado todos os registros
contidos no arquivo lista_estados.csv

3. criar uma tebela chamada municipio com os campos
    - cod_ibge int chave primária
    - cod_uf varchar(2) chave estrangeira tabela estado
    - nome_municipio
    - nome_regiao
    - quantidade_populacao
    - tipo_porte
    
4. importar para a tabela municipio todos os registros
contidos no arquivo lista_municipios.csv
