<?php

namespace Innoboxrr\LaravelBlog\Services\Lambda\Actions;

use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Support\Facades\Storage;

class VideoToTextAIAction
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public static function handle(array $data)
    {
        $instance = new self($data);
        return $instance->process();
    }

    protected function process()
    {
        // Procesar el video y convertir a audio y recuperar la URL de S3
        $videoS3Url = $this->data['payload']['s3Url'];
        $mp3S3Url = $this->convertVideoToAudio($videoS3Url);

        return [
            'type' => 'videoToTextAI',
            'data' => [
                's3Url' => $mp3S3Url,
                'rewrite' => $this->data['payload']['rewrite'] ?? false,
                'useHtml' => $this->data['payload']['useHtml'] ?? false,
            ]
        ];
    }

    private function convertVideoToAudio($videoS3Url)
    {
        // Obtener la ruta relativa del archivo en S3
        $s3Path = parse_url($videoS3Url, PHP_URL_PATH);

        // Generar un nombre temporal para el archivo en el servidor local
        $tempVideoFile = 'temp/' . uniqid() . '.mp4'; // Cambia la extensión según corresponda

        // Descargar el archivo desde S3
        $videoContent = Storage::disk('s3')->get($s3Path);
        Storage::disk('local')->put($tempVideoFile, $videoContent);

        // Obtener la ruta absoluta del archivo temporal
        $tempVideoPath = Storage::disk('local')->path($tempVideoFile);

        // Configurar la salida para el archivo de audio
        $tempAudioFile = 'temp/' . uniqid() . '.mp3';
        $tempAudioPath = Storage::disk('local')->path($tempAudioFile);

        // Inicializar FFMpeg
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => config('laravel-blog.ffmpeg'), // Ruta al binario de FFmpeg
            'ffprobe.binaries' => config('laravel-blog.ffprobe'), // Ruta al binario de FFprobe
            'timeout'          => 3600,               // Tiempo máximo de procesamiento (en segundos)
            'threads'          => 4,                  // Número de hilos a usar
        ]);
        $video = $ffmpeg->open($tempVideoPath);

        // Configurar el formato de salida a MP3
        $format = new Mp3();
        $format->setAudioChannels(2)->setAudioKiloBitrate(128);

        // Convertir el video a audio
        $video->save($format, $tempAudioPath);

        // Subir el archivo de audio a S3
        $audioContent = file_get_contents($tempAudioPath);
        $audioS3Path = preg_replace('/\.[^.]+$/', '.mp3', $s3Path);
        Storage::disk('s3')->put($audioS3Path, $audioContent);

        // Eliminar los archivos temporales
        Storage::disk('local')->delete([$tempVideoFile, $tempAudioFile]);

        // Devolver la ruta del archivo procesado en S3
        return Storage::disk('s3')->url($audioS3Path);
    }

    public static function after($data, $payload, $response)
    {
        // Eliminar el archivo de audio del bucket de S3
        $videoS3Url = $data['payload']['s3Url'];
        $videoS3Path = parse_url($videoS3Url, PHP_URL_PATH);
        $audioS3Path = $payload['data']['s3Url'];
        $audioS3Path = parse_url($audioS3Path, PHP_URL_PATH);
        Storage::disk('s3')->delete($videoS3Path);
        Storage::disk('s3')->delete($audioS3Path);
    }
}