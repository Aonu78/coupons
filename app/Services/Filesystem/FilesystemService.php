<?php

namespace App\Services\Filesystem;

use Illuminate\Contracts\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class FilesystemService
{
    /**
     * @param Filesystem $objFilesystem
     */
    public function __construct(
        private readonly Filesystem $objFilesystem
    ) {}

    public function save(string $path, string $content): void
    {
        if ($this->objFilesystem->exists($path)) {
            $this->objFilesystem->delete($path);
        }

        $this->objFilesystem->append($path, $content);
    }

    public function readFile(string $path): ?string
    {
        return $this->objFilesystem->get($path);
    }

    /**
     * @throws \Exception
     */
    public function copy(UploadedFile|string $pathFrom, string $strPathTo, ?string $fileName = null): void
    {
        if (is_string($pathFrom)) {
            if ($this->objFilesystem->exists($pathFrom)) {
                $this->objFilesystem->copy($pathFrom, $strPathTo);
                return;
            }

            if (file_exists($pathFrom) === false) {
                throw new \Exception("File Doesnt Exist");
            }

            $this->objFilesystem->put($strPathTo . '/' . $fileName, file_get_contents($pathFrom));
        } else {
            $this->objFilesystem->put($strPathTo . '/' . $fileName, $pathFrom->getContent());
        }
    }

    public function files(string $strDirectory): array
    {
        return $this->objFilesystem->files($strDirectory);
    }

    public function url(string $path): string
    {
        return $this->objFilesystem->url($path);
    }

    public function exists(string $path): bool
    {
        return $this->objFilesystem->exists($path);
    }

    public static function factory(): self
    {
        return resolve(FilesystemService::class);
    }
}
