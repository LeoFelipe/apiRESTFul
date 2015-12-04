<?php
namespace Api\Entities;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity(repositoryClass="Api\Repositories\Classificado")
 * @Table(name="classificados")
 */
class Classificado
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=50)
     */
    protected $titulo;

    /**
     * @Column(type="text")
     */
    protected $anuncio;

    /**
     * @Column(type="integer")
     */
    protected $idPedido;


    /********************************
     * Getter's e Setter's
     *******************************/
    /* Getter's */
    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getAnuncio() { return $this->anuncio;  }
    public function getIdPedido() { return $this->idPedido;  }

    /* Setter's */
    public function setTitulo($titulo) {  $this->titulo = $titulo; }
    public function setAnuncio($anuncio) { $this->anuncio = $anuncio; }
    public function setIdPedido($idCategoria) { $this->idPedido = $idPedido; }
}