<?php

namespace Microblog;
use PDO, Exception;

final class Noticia {
    private int $id;
    private string $data;
    private string $titulo;
    private string $texto;
    private string $resumo;
    private string $imagem;
    private string $destaque;

    private int $categoriaId;


    /* Criando uma propriedade do tipo usuario, ou seja,a partir de uma classe que criamos
    com o objetivo de reutilizar recursos dela. 
    
    isto permitira fazer uma ASSOCIAÇÃO entre classes.
    */
    public Usuario $usuario;

    private PDO $conexao;

    public function __construct()
    {
        /* no momento em que um objeto noticia for instanciado nas paginas
        aproveitaremos pra tambem instanciar um objeto Usuario e com isso acessar recursos desta classe. */
        $this->usuario = new Usuario;

        /* Reaproveitando a conexão ja existente a partir da classe Usuario */
        $this->conexao = $this->usuario->getConexao();
    }
}