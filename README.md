# Easy SQL Generator

## Pra que serve?
SQL Generator serve para gerar SQL de forma simples, facilitando suas consultas alem de conter os conceitos que da agilidade na consulta.

### [Change History](https://github.com/raniellyferreira/sqlgenerator/wiki/Change-History)

## Exemplo simples

```php
<?php
$sql = new Sqlgen();

$sql->where('coluna','valor');
echo $sql->get('tabela');

//Isto ira resultar em
//SELECT * FROM (tabela) WHERE coluna = 'valor'
```
### [Click here for more examples](https://github.com/raniellyferreira/sqlgenerator/wiki/Examples)
