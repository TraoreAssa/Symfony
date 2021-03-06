<?php
// src/MA/PlatformBundle/Entity/Image

namespace MA\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Table(name="ma_image")
 * @ORM\Entity(repositoryClass="MA\PlatformBundle\Entity\ImageRepository")
 */
class Image
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;  

  /**
   * @ORM\Column(name="url", type="string", length=255)
   */
  private $url;

  /**
   * @ORM\Column(name="alt", type="string", length=255)
   */
  private $alt;
  
  
  private $file;

  //on y stocker le nom du fichier temporaire
//   private $tempFilename;

  public function getFile()
  {
      return $this->file;
  }

  public function setFile(UploadedFile $file)
  {
       $this->file = $file;

    //    // on verifie s'il existe deja u fichier pour l'entité
    //    if (null !== $this->url) {
    //        $this->tempFilename = $this->url;
    //        // on reinitialise url et alt
    //        $this->url = '';
    //        $this->alt = '';
    //    }
  }

  public function monUpload()
  {
      if (null === $this->file) 
      {
          return;
      }

      $name =$this->file->getClientOriginalName();
      $this->file->move($this->getUploadRootDir(), $name);

      $this->url = $name;
      $this->alt = $name;
  }

//   /**
//    * @ORM\PrePersist()
//    * @ORM\PreUpdate()
//    */
//   public function preUpload()
//   {
//       if (null === $this->file) {
//           return;
//       }
//       $this->url = $this->file->guessExtension(); // devine l'extention (png jpg...)
//       $this->alt = $this->file->getClientOriginaName();
//   }

//   public function upload()
//   {
//       if (null === $this->file) {
//         return;
//       }
//     // si j'avais une ancienne image alors la supprimer (tempFile = ancienne image) 
//       if (null !== $this->tempFilename) {
//         $oldFile = $this->getUploadRootDir(). '/' . $this->id . '.' . $this->tempFilename;
//         if (file_exists($oldFile)) {
//             unlink($oldFile);
//         }
//       }

    //   // On deplace le fichier dans le repertoire de notre choix
    //   $this->file->move($this->getUploadRootDir(), $this->id . '.' . $this->url);
    //   // a ce stade on a enregistrer l'image dans le dossier web/upload/img sous la forme id.extension


    //   //1er etape : recuperartion du nom du fichier
    //   $name = $this->file->getClientOriginalName();

    //   // 2eme etape : on deplac le fichier dans le repertoire qu'on veux
    //   $this->file->move($this->getUploadRootDir(), $name);

    //   // 3eme etape : on sauvegarde le nom du fichier dans $url et $alt
    //   $this->url = $name;
    //   $this->alt = $name;
//   }

//   /**
//    * @ORM\PreRemove()
//    */
//   public function preRemoveUpload()
//   {
//     //on sauvegarde tempFilename le nom du fichier, car il depend de l'id
//     $this->tempFilename = $this->getUploadRootDir() . '/' . $this->id . '.' . $this->url;
      
//   }

//   /**
//    * @ORM\PostRemove()
//    */
//   public function removeUpload()
//   {
//       // en PostRemove on n'a pas acces a l'id, on utilise notre nom sauvegarder
//       if(file_exists($this->tempFilename))
//       {
//           //on supprime le ficher
//           unlink($this->tempFilename);
//       }
//   }

  public function getUploadDir()
  {
      // on retourne le chemin, reletif pour un navigateur
      return'uploads/img';
      
  }

  public function getUploadRootDir()
  {
      // on retourne le chemin, reletif vers l'image
      return __DIR__ . '/../../../../web/'. $this->getUploadDir();
      // __DIR__ est la place actuelle

  }
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt.
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt.
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }
}
