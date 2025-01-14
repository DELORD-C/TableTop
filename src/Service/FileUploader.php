<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(private $targetDirectory, private readonly SluggerInterface $slugger, private readonly Filesystem $fs) {}

    public function upload(UploadedFile $file, ?string $oldFile = null, ?string $directory = ""): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $this->fs->exists($this->getTargetDirectory() . '/' . $directory . '/' . $safeFilename . '.' . $file->guessExtension()) ?
            $safeFilename . '-' . uniqid() . '.' . $file->guessExtension() :
            $safeFilename . '.' . $file->guessExtension();

        try {
            $file->move($this->getTargetDirectory() . '/' . $directory, $fileName);
            if ($oldFile) {
                $this->fs->remove($this->getTargetDirectory().'/'.$oldFile);
            }
        } catch (FileException $e) {
            throw new FileException($e);
        }

        return $fileName;
    }

    public function remove(string $file, ?string $directory = ""): bool
    {
        try {
            $this->fs->remove($this->getTargetDirectory() . '/' . $directory . '/' . $file);
        } catch (FileException $e) {
            throw new FileException($e);
        }
        return true;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}