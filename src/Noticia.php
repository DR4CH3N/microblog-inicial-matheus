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

    public function InserirNoticia():void {
        $sql = "INSERT INTO noticias(titulo, texto, resumo, imagem, destaque, usuario_id, categoria_id)
        VALUES(:titulo, :texto, :resumo, :imagem, :destaque, :usuario_id, :categoria_id)";
        
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindParam(":titulo", $this->titulo, PDO::PARAM_STR);
            $consulta->bindParam(":texto", $this->texto, PDO::PARAM_STR);
            $consulta->bindParam(":resumo", $this->resumo, PDO::PARAM_STR);
            $consulta->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);
            $consulta->bindParam(":destaque", $this->destaque, PDO::PARAM_STR);
            $consulta->bindParam(":categoria_id", $this->categoriaId, PDO::PARAM_INT);

            /* aqui, primeiro chamamos o getter de ID a partir do objeto/classe de Usuario.
            e só depois atribuimos ele ao parametro :usuario_id usando para isso o bindValue. 
            OBS: bindParam pode ser usado, mas há riscos de erro devido a forma como ele é executado pelo PHP.
            por isso, recomenda-se o uso do bindValue em situações como essa...
            OBS 2: absolutamente TUDO que tiver parenteses (metodos, classes, etc), use o bindValue para poder fazer o codigo em vez do bindParam. */
            $consulta->bindValue(":usuario_id", $this->usuario->getId(), PDO::PARAM_INT);
            $consulta->execute();


    
            } catch (Exception $erro) {
            die("Erro: ". $erro->getMessage());
            }
    
    }


    
    public function getId(): int
    {
        return $this->id;
    }

    
    public function setId(int $id)
    {
        $this->nome = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        return $this;
    }

    
    
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    
    public function setTitulo(string $titulo)
    {
        $this->nome = filter_var($titulo, FILTER_SANITIZE_SPECIAL_CHARS);

        return $this;
    }

    
    public function getTexto(): string
    {
        return $this->texto;
    }

    
    public function setTexto(string $texto)
    {
        $this->nome = filter_var($texto, FILTER_SANITIZE_SPECIAL_CHARS);

        return $this;
    }

   
    public function getResumo(): string
    {
        return $this->resumo;
    }

   
    public function setResumo(string $resumo)
    {
        $this->nome = filter_var($resumo, FILTER_SANITIZE_SPECIAL_CHARS);

        return $this;
    }


    public function getImagem(): string
    {
        return $this->imagem;
    }

    
    public function setImagem(string $imagem)
    {
        $this->nome = filter_var($imagem, FILTER_SANITIZE_SPECIAL_CHARS);

        return $this;
    }

    public function getDestaque(): string
    {
        return $this->destaque;
    }

    
    public function setDestaque(string $destaque)
    {
        $this->nome = filter_var($destaque, FILTER_SANITIZE_SPECIAL_CHARS);

        return $this;
    }

    
    public function getCategoriaId(): int
    {
        return $this->categoriaId;
    }

    
    public function setCategoriaId(int $categoriaId)
    {
        $this->nome = filter_var($categoriaId, FILTER_SANITIZE_NUMBER_INT);

        return $this;
    }
}