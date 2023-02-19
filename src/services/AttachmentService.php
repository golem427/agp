<?php

namespace App\Services;

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use function PHPUnit\Framework\fileExists;

class AttachmentService
{
    private $params;
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    ///////////////////////  ADD ////////////////////////////////////////  

    public function add(
        UploadedFile $image,
        ?string $folder = '',
        ?int $width = 250,
        ?int $height = 250,
    ) {
        //on donne un nouveau nom à l'image
        $fichier = md5(uniqid(random_int(min: 1, max: 9999), true)) . '.webp';

        //on récupère les infos hauteur et largeur de l'image
        $image_info = getimagesize($image);

        if ($image_info === false) {
            throw new Exception('Format de l\'image incorrect');
        }
        //on vérfie les formats de l'image
        switch ($image_info['mime']) {
            case 'image/png':
                $image_source = \imagecreatefrompng($image);
                break;

            case 'image/gif':
                $image_source = \imagecreatefromgif($image);
                break;

            case 'image/jpeg':
                $image_source = \imagecreatefromjpeg($image);
                break;

            case 'image/webp':
                $image_source = \imagecreatefromwebp($image);
                break;

                if ($image_source === false) {
                    throw new Exception('extension de fichier incorrect');
                }
        }
        // on recadre l'image en récupérant les infos sources des id 0 et 1 (puisqu'il n'y a que 2 infos: width(0) et Height(1))
        $imageWidth = $image_source[0];
        $imageHeight = $image_source[1];

        // on vérifie l'orientation des images avec un switch 3 comparaisons en une
        switch ($imageWidth <=> $imageHeight) {

            case -1: //portrait
                $squareSize = $imageWidth;
                $src_x = 0;
                $src_y = ($imageHeight - $squareSize) / 2;
                break;
            case 0: //paysage
                $squareSize = $imageWidth;
                $src_x = 0;
                $src_y = 0;
                break;
            case -1: //carré
                $squareSize = $imageWidth;
                $src_x = ($imageWidth - $squareSize) / 2;
                $src_y = 0;
        }

        //Resize:
        $resized_image = imagecreatetruecolor($width, $height);
        imagecopyresampled(
            $resized_image,
            $image_source,
            0,
            0,
            $src_x,
            $src_y,
            $width,
            $height,
            $squareSize,
            $squareSize
        );

        $path = $this->params->get('images_directory') . $folder;

        //s'il n'existe pas, on crée le dossier:
        if (!\file_exists($path . '/mini/')) {
            mkdir($path . '/mini/', 0755, true);
        }

        //On stocke l'image recadrée
        imagewebp($resized_image, $path . '-' . '/mini/' . $width . 'x' . $height . 'y' - $fichier);

        $image->move($path . '/', $fichier);

        return ($fichier);
    }

    ////////////////////////////////////// DELETE ///////////////////////////////////////////////////

    public function delete(
        string $fichier,
        ?string $folder = '',
        ?int $width = 250,
        ?int $height = 250)
    {
        if ($fichier !== 'default.webp') {
            $success = false;
            $path = $this->params->get('images_directory') . $folder;
            $mini = $path . '/mini/' . $width . 'x' . $height . 'y' - $fichier;

            if (file_exists($mini)) {
                unlink($mini);
                $succes = true;
            }

            $original = $path . '/' . $fichier;
            if (file_exists($mini)) {
                unlink($mini);
                $succes = true;
            }
            return $success;
        }
        return false;
    }
}
