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

    /* Criando uma propriedade do tipo Usuario, ou seja, 
    a partir de uma classe que criamos anteriormente,
    com o objetivo de reutilizar recursos dela.
    
    Isto permitirá fazer uma ASSOCIAÇÃO entre classes. */
    public Usuario $usuario;

    private PDO $conexao;

    public function __construct()
    {
        /* No momento em que um objeto Noticia for instanciado
        nas páginas, aproveitaremos para também instanciar um objeto
        Usuario e com isso acessar recursos desta classe. */
        $this->usuario = new Usuario;

        /* Reaproveitando a conexão já existente
        a partir da classe de Usuario */
        $this->conexao = $this->usuario->getConexao();
    }

    public function inserirNoticia():void {
        $sql = "INSERT INTO noticias(titulo, texto, resumo, imagem, 
        destaque, usuario_id, categoria_id) 
        VALUES(:titulo, :texto, :resumo, :imagem, :destaque, 
        :usuario_id, :categoria_id)";

        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindParam(":titulo", $this->titulo, PDO::PARAM_STR);
            $consulta->bindParam(":texto", $this->texto, PDO::PARAM_STR);
            $consulta->bindParam(":resumo", $this->resumo, PDO::PARAM_STR);
            $consulta->bindParam(":imagem", $this->imagem, PDO::PARAM_STR);
            $consulta->bindParam(":destaque", $this->destaque, PDO::PARAM_STR);
            $consulta->bindParam(":categoria_id", $this->categoriaId, PDO::PARAM_INT);

            /* Aqui, primeiro chamamos o getter de ID a partir do objeto/classe
            de Usuario. E só depois atribuimos ele ao parâmetro :usuario_id
            usando para isso o bindValue. Obs.: bindParam pode ser usado, mas há riscos
            de erro devido a forma como ele é executado pelo PHP. Por isso, recomenda-se
            o uso do bindValue em situações como essa. */
            $consulta->bindValue(":usuario_id", $this->usuario->getId(), PDO::PARAM_INT);

            $consulta->execute();
        } catch (Exception $erro) {
            die("Erro: ". $erro->getMessage());
        }   

        
           
    }

    public function atualizar():void{
        /* se o tipo de usuario logado for admin */
        if ($this->usuario->getTipo() === 'admin') {
            /* então ele podera acessar as noticias de todo mundo */
            $sql = "UPDATE noticias 
            SET titulo = :titulo, texto = :texto, resumo = :resumo, imagem = :imagem, categoria_id = :categoria_id, destaque = :destaque 
            WHERE id = :id";

        } else {
            /* senão (ou seja, um editor), esse usuario (editor) poderá acessar SOMENTE suas proprias noticias */
            $sql = "UPDATE noticias 
            SET titulo = :titulo, texto = :texto, resumo = :resumo, imagem = :imagem, categoria_id = :categoria_id, destaque = :destaque 
            WHERE id = :id
            AND usuario_id = :usuario_id";
            
        }
        try {
            $consulta = $this->conexao->prepare($sql);

            $consulta->bindParam(":id",  $this->id, PDO::PARAM_INT);
            $consulta->bindParam(":titulo",  $this->titulo, PDO::PARAM_STR);
            $consulta->bindParam(":texto",  $this->texto, PDO::PARAM_STR);
            $consulta->bindParam(":resumo",  $this->resumo, PDO::PARAM_STR);
            $consulta->bindParam(":imagem",  $this->imagem, PDO::PARAM_STR);
            $consulta->bindParam(":categoria_id",  $this->categoriaId, PDO::PARAM_INT);
            $consulta->bindParam(":destaque",  $this->destaque, PDO::PARAM_STR);
            
            
            /* se NÃO for um usuario admin, então trate o parametro de usuario_id antes de executar */
            if ($this->usuario->getTipo() !== 'admin') {
                // parametro id da noticia
                

                // parametro usuario_id
                $consulta->bindValue(":usuario_id",  $this->usuario->getId(), PDO::PARAM_INT);

            } 
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $erro) {
            die("Erro: ". $erro->getMessage());
        } 
        
    } 

    public function listarUm():array {
        /* se o tipo de usuario logado for admin */
        if ($this->usuario->getTipo() === 'admin') {
            /* então ele podera acessar as noticias de todo mundo */
            $sql = "SELECT titulo, texto, resumo, imagem, usuario_id, categoria_id, destaque 
            FROM noticias WHERE id = :id";

        } else {
            /* senão (ou seja, um editor), esse usuario (editor) poderá acessar SOMENTE suas proprias noticias */
            $sql = "SELECT titulo, texto, resumo, imagem, usuario_id, categoria_id, destaque 
            FROM noticias WHERE id = :id AND usuario_id = :usuario_id";
        }

        try {
            $consulta = $this->conexao->prepare($sql);

            $consulta->bindParam(":id",  $this->id, PDO::PARAM_INT);
            
            /* se NÃO for um usuario admin, então trate o parametro de usuario_id antes de executar */
            if ($this->usuario->getTipo() !== 'admin') {
                // parametro id da noticia
                

                // parametro usuario_id
                $consulta->bindValue(":usuario_id",  $this->usuario->getId(), PDO::PARAM_INT);

            } 
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $erro) {
            die("Erro: ". $erro->getMessage());
        } 
        
        return $resultado; 
    } /* final do listar */


    public function listarNoticia():array {
        /* se o tipo de usuario logado for admin */
        if ($this->usuario->getTipo() === 'admin') {
            /* então ele podera acessar as noticias de todo mundo */
            $sql = "SELECT noticias.id, noticias.titulo, noticias.data, noticias.destaque, usuarios.nome AS autor FROM noticias LEFT JOIN usuarios
            ON noticias.usuario_id = usuarios.id

            ORDER BY DATA DESC";
        } else {
            /* senão (ou seja, um editor), esse usuario (editor) poderá acessar SOMENTE suas proprias noticias */
            $sql = "SELECT id, titulo, data, destaque FROM noticias
            WHERE usuario_id = :usuario_id
            ORDER BY data DESC";
        }

        try {
            $consulta = $this->conexao->prepare($sql);
            
            /* se NÃO for um usuario admin, então trate o parametro de usuario_id antes de executar */
            if ($this->usuario->getTipo() !== 'admin') {
                $consulta->bindValue(":usuario_id",  $this->usuario->getId(), PDO::PARAM_INT);
            }
            $consulta->execute();
            $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $erro) {
            die("Erro: ". $erro->getMessage());
        } 
        
        return $resultado; 
    } /* final do listar */

    public function excluirNoticia():void {
        if ( $this->usuario->getTipo() === 'admin') {
        $sql = "DELETE FROM noticias WHERE id = :id";
    }
    else {
        $sql = "DELETE FROM noticias WHERE id = :id AND usuario_id = :usuario_id";
    }
        
        try {
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindParam(":id", $this->id, PDO::PARAM_INT);

            if ( $this->usuario->getTipo() !== 'admin' ) {
                $consulta->bindValue(":id", $this->id, PDO::PARAM_INT);
            }
            $consulta->execute();
        } catch (Exception $erro) {
            die("Erro: ". $erro->getMessage());
        }
    }

    public function upload(array $arquivo) {
        // definindo os formatos aceitos
        $tiposValidos = [
        "image/png",
        "image/jpeg",
        "image/svg+xml",
        "image/gif"
        ];
        if ( !in_array($arquivo['type'], $tiposValidos) ) {
            die("<script>alert('formato invalido!');
            history.back();
            </script>
            ");
        } /* else {
            die("<script>alert('formato valido!')</script>");
        } */

        // acessando apenas o nome do arquivo
        $nome = $arquivo['name'];

        // acessando os dados de acesso temporario

        $temporario = $arquivo['tmp_name'];

        // definindo a pasta de destino junto com o nome do arquivo
        $destino = "../imagem/".$nome;

        // usamos a função abaixo para pegar da area temporaria
        // e enviar para a pasta de destino (com o nome do arquivo)
        move_uploaded_file($temporario, $destino);
    }





    /* 
    try {
            
        } catch (Exception $erro) {
            die("Erro: ". $erro->getMessage());
        }  */






   
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    
    public function setTitulo(string $titulo)
    {
        $this->titulo = filter_var($titulo, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    
    public function getTexto(): string
    {
        return $this->texto;
    }

    
    public function setTexto(string $texto)
    {
        $this->texto = filter_var($texto, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    
    public function getResumo(): string
    {
        return $this->resumo;
    }

    
    public function setResumo(string $resumo)
    {
        $this->resumo = filter_var($resumo, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    
    public function getImagem(): string
    {
        return $this->imagem;
    }

    
    public function setImagem(string $imagem)
    {
        $this->imagem = filter_var($imagem, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    
    public function getDestaque(): string
    {
        return $this->destaque;
    }

    
    public function setDestaque(string $destaque)
    {
        $this->destaque = filter_var($destaque, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    
    public function getCategoriaId(): int
    {
        return $this->categoriaId;
    }

    
    public function setCategoriaId(int $categoriaId)
    {
        $this->categoriaId = filter_var($categoriaId, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}