<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(private $targetDirectory, private readonly SluggerInterface $slugger, private readonly Filesystem $fs) {}

    public function upload(UploadedFile $file, ?string $oldFile = null): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
            if ($oldFile) {
                $this->fs->remove($this->getTargetDirectory().'/'.$oldFile);
            }
        } catch (FileException $e) {
            throw new FileException("Impossible de déplacer le fichier.");
        }

        return $fileName;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}